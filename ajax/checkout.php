<?php
@session_start();
include("../sistema/conexao.php");
$total_desconto = filter_var(@$_POST['total_desconto'], @FILTER_SANITIZE_STRING);
$total_final = filter_var(@$_POST['total_final'], @FILTER_SANITIZE_STRING);
$total_frete_carrinho = filter_var(@$_POST['total_frete_carrinho'], @FILTER_SANITIZE_STRING);
$id_cliente = filter_var(@$_POST['id_cliente'], @FILTER_SANITIZE_STRING);
$id_loja = filter_var(@$_POST['id_loja'], @FILTER_SANITIZE_STRING);

$sessao_carrinho = @$_SESSION['sessao_carrinho'];

if($sessao_carrinho == ""){
	echo 'Já foi efetuado este pedido!';
	exit();
}

$query = $pdo->prepare("INSERT vendas SET cliente = '$id_cliente', sessao = '$sessao_carrinho', data = curDate(), hora = curTime(), valor = :valor, desconto = :desconto, frete = :frete, pago = 'Não', loja = '$id_loja'");
$query->bindValue(":valor", "$total_final");
$query->bindValue(":desconto", "$total_desconto");
$query->bindValue(":frete", "$total_frete_carrinho");
$query->execute();
$ult_id = $pdo->lastInsertId();

//atualizar os itens do carrinho com o id da venda
$query = $pdo->query("UPDATE carrinho SET venda = '$ult_id', cliente = '$id_cliente' where sessao = '$sessao_carrinho'");

//limpe a sessão do carrinho
unset($_SESSION['sessao_carrinho']);

echo 'Inserido**'.$ult_id;





?>

