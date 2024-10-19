<?php 
$tabela = 'avaliacoes';
require_once("../../../conexao.php");

$id = $_POST['id'];
$texto = $_POST['texto'];

$query = $pdo->prepare("UPDATE $tabela SET texto = :texto WHERE id = '$id' ");
$query->bindValue(":texto", "$texto");
$query->execute();
echo 'Salvo com Sucesso';
?>