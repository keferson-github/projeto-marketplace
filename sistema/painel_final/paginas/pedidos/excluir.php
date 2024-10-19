<?php 
$tabela = 'vendas';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query2 = $pdo->query("SELECT * from vendas where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$sessao = $res2[0]['sessao'];

$pdo->query("DELETE FROM temp WHERE sessao = '$sessao' ");
$pdo->query("DELETE FROM carrinho WHERE venda = '$id' ");
$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>