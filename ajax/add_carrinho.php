<?php 
@session_start();
$id_cliente = @$_SESSION['id_cliente'];



if($id_cliente == ""){
	$id_cliente = 0;
}

if(@$_SESSION['sessao_carrinho'] == ""){
	$sessao_carrinho = date('Y-m-d-H:i:s-').rand(0, 1500);
	$_SESSION['sessao_carrinho'] = $sessao_carrinho;
}else{
	$sessao_carrinho = $_SESSION['sessao_carrinho'];
}

include("../sistema/conexao.php");

$quantidade = filter_var(@$_POST['quantidade'], @FILTER_SANITIZE_STRING);
$produto = filter_var(@$_POST['produto'], @FILTER_SANITIZE_STRING);
$valor_produto = filter_var(@$_POST['valor_produto'], @FILTER_SANITIZE_STRING);
$valor_frete = filter_var(@$_POST['valor_frete'], @FILTER_SANITIZE_STRING);
$nome_frete = filter_var(@$_POST['nome_frete'], @FILTER_SANITIZE_STRING);
$loja_produto = filter_var(@$_POST['loja_produto'], @FILTER_SANITIZE_STRING);

$total = $quantidade * $valor_produto;

//verificar estoque
$query = $pdo->query("SELECT * from produtos where id = '$produto' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque_produto = $res[0]['estoque'];
if($quantidade > $estoque_produto){
	echo 'Não temos essa quantidade em estoque, no momento temos apenas '.$estoque_produto.' produtos no estoque!';
	exit();
}

//verificar se há obrigatóriedade de seleção de grade
$query = $pdo->query("SELECT * from grades where produto = '$produto' and ativo = 'Sim' and obrigatoria = 'Sim' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
      $id_grade = $res[$i]['id'];
      $nome_grade = $res[$i]['texto'];


	      $query2 = $pdo->query("SELECT * from temp where sessao = '$sessao_carrinho' and produto = '$produto' and grade = '$id_grade' and carrinho = 0 order by id asc");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$linhas2 = @count($res2);
			if($linhas2 == 0){
				echo $nome_grade;
				exit();
			}

   }
}


	$query = $pdo->prepare("INSERT INTO carrinho SET sessao = :sessao, cliente = :cliente, data = curDate(), hora = curTime(), produto = :produto, quantidade = :quantidade, valor = :valor, total = :total, venda = '0', frete = :valor_frete, nome_frete = :nome_frete, loja = :loja_produto, status = 'Aguardando Envio'");

	$query->bindValue(":sessao", "$sessao_carrinho");
	$query->bindValue(":cliente", "$id_cliente");
	$query->bindValue(":produto", "$produto");
	$query->bindValue(":quantidade", "$quantidade");
	$query->bindValue(":valor", "$valor_produto");
	$query->bindValue(":total", "$total");
	$query->bindValue(":valor_frete", "$valor_frete");
	$query->bindValue(":nome_frete", "$nome_frete");
	$query->bindValue(":loja_produto", "$loja_produto");
	$query->execute();
	$ult_id = $pdo->lastInsertId();

	$pdo->query("UPDATE temp SET carrinho = '$ult_id' where carrinho = '0' and sessao = '$sessao_carrinho'");

	echo 'Salvo com Sucesso';

	?>