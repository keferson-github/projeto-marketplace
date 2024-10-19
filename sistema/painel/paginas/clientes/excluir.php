<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
$pdo->query("DELETE FROM usuarios WHERE ref = '$id' ");
echo 'Excluído com Sucesso';
?>