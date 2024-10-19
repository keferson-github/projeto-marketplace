<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id' ");
$pdo->query("UPDATE usuarios SET ativo = '$acao' WHERE ref = '$id' ");
echo 'Alterado com Sucesso';
?>