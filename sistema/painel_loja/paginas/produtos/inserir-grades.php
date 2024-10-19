<?php 
require_once("../../../conexao.php");

$tabela = 'grades';

$texto = $_POST['texto'];
$tipo_item = $_POST['tipo_item'];
$valor_item = $_POST['valor_item'];
$limite = $_POST['limite'];
$produto = $_POST['id'];
$nome_comprovante = $_POST['nome_comprovante'];
$obrigatoria = $_POST['obrigatoria'];

$query = $pdo->prepare("INSERT INTO $tabela SET produto = '$produto', tipo_item = :tipo_item, valor_item = :valor_item, texto = :texto, limite = :limite, ativo = 'Sim', nome_comprovante = :nome_comprovante, obrigatoria = :obrigatoria");


$query->bindValue(":tipo_item", "$tipo_item");
$query->bindValue(":valor_item", "$valor_item");
$query->bindValue(":texto", "$texto");
$query->bindValue(":limite", "$limite");
$query->bindValue(":nome_comprovante", "$nome_comprovante");
$query->bindValue(":obrigatoria", "$obrigatoria");
$query->execute();

echo 'Salvo com Sucesso';