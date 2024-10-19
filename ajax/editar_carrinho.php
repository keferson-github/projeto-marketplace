<?php 
include("../sistema/conexao.php");

$id_carrinho = $_POST['id_carrinho'];
$total_quant = $_POST['total'];

if($total_quant == 0){
	$pdo->query("DELETE from carrinho where id = '$id_carrinho'");
	$pdo->query("DELETE from temp where carrinho = '$id_carrinho'");
}


$query = $pdo->query("SELECT * from carrinho where id = '$id_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	$valor = $res[0]['valor'];
	$total = $res[0]['total'];

$novo_total = $total_quant * $valor;

$pdo->query("UPDATE carrinho SET quantidade = '$total_quant', total = '$novo_total' where id = '$id_carrinho'");

?>