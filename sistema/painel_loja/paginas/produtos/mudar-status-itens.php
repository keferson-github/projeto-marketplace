<?php 
require_once("../../../conexao.php");
$tabela = 'itens_grade';

$id = $_POST['id'];
$acao = $_POST['acao'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' where id = '$id'");
echo 'Alterado com Sucesso';

?>