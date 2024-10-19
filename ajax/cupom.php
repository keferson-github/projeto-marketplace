<?php
@session_start();
include("../sistema/conexao.php");
$codigo = filter_var(@$_POST['codigo'], @FILTER_SANITIZE_STRING);
$total_final = filter_var(@$_POST['total_final'], @FILTER_SANITIZE_STRING);

$sessao_carrinho = $_SESSION['sessao_carrinho'];

$data_atual = date('Y-m-d');

$id_loja = filter_var(@$_POST['id_loja'], @FILTER_SANITIZE_STRING);

if($tipo_loja == 'Marketplace'){
	$sql_cupom = " and id_loja is null";
}else{
	$sql_cupom = " and id_loja = '$id_loja'";
}

$query =$pdo->prepare("SELECT * FROM cupons where codigo = :codigo $sql_cupom");
$query->bindValue(":codigo", "$codigo");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_cupons = @count($res);
if($total_cupons == 0 ){
	echo 'Código do cupom não encontrado!';
	exit();
}else{

	$query2 =$pdo->prepare("SELECT * FROM cupons_usados where codigo = :codigo and sessao = '$sessao_carrinho'");
	$query2->bindValue(":codigo", "$codigo");
	$query2->execute();
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0 ){
		echo 'Cupom já utilizado para essa compra!';
		exit();
	}


	$valor_cupom = $res[0]['valor'];
	$data = $res[0]['data'];
	$quantidade = $res[0]['quantidade'];
	$valor_minimo = $res[0]['valor_minimo'];
	$tipo = $res[0]['tipo'];



	if($data != "" and $data != "0000-00-00"){
		if(strtotime($data) < strtotime($data_atual)){
			echo 'Cupom Vencido!';
			exit();
		}
	}

	if($quantidade < 1){		
			echo 'Quantidade do Cupom Insuficiente';
			exit();		
	}

	if($valor_minimo > 0){
		if($total_final <= $valor_minimo){
			echo 'O valor mínimo para uso deste cupom é '.$valor_minimo;
			exit();	
		}
	}

	if($tipo == '%'){
		$valor_cupom = $valor_cupom * $total_final / 100;
		$valor_total = $total_final - $valor_cupom;

	}else{
		$valor_total = $total_final - $valor_cupom;
	}
	
	//abater 1 na quantidade de cupom
	$nova_quant = $quantidade - 1;
	$query = $pdo->prepare("UPDATE cupons SET quantidade = '$nova_quant' where codigo = :codigo $sql_cupom");
	$query->bindValue(":codigo", "$codigo");
	$query->execute();

	$query = $pdo->prepare("INSERT cupons_usados SET codigo = :codigo, sessao = '$sessao_carrinho', data = curDate(), hora = curTime(), valor = '$valor_cupom'");
	$query->bindValue(":codigo", "$codigo");
	$query->execute();
}

echo 'Inserido';
?>