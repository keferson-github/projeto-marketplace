<?php 
@session_start();
$id = @$_SESSION['id_cliente'];

$tabela = 'clientes_finais';
require_once("../conexao.php");

$nome = filter_var($_POST['nome'], @FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], @FILTER_SANITIZE_STRING);
$telefone = filter_var($_POST['telefone'], @FILTER_SANITIZE_STRING);
$endereco = filter_var($_POST['endereco'], @FILTER_SANITIZE_STRING);
$numero = filter_var($_POST['numero'], @FILTER_SANITIZE_STRING);
$bairro = filter_var($_POST['bairro'], @FILTER_SANITIZE_STRING);
$cidade = filter_var($_POST['cidade'], @FILTER_SANITIZE_STRING);
$estado = filter_var($_POST['estado'], @FILTER_SANITIZE_STRING);
$cep = filter_var($_POST['cep'], @FILTER_SANITIZE_STRING);

$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);

$complemento = filter_var($_POST['complemento'], @FILTER_SANITIZE_STRING);

$conf_senha = filter_var(@$_POST['conf_senha'], @FILTER_SANITIZE_STRING);
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);


if($conf_senha != $senha){
	echo 'As senhas não se coincidem';
	exit();
}



//validacao email
if($email != ""){
	$query = $pdo->prepare("SELECT * from $tabela where email = :email");
	$query->bindValue(":email", "$email");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];	
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Email já Cadastrado!';
		exit();
	}
}



//validacao telefone
if($telefone != ""){
	$query = $pdo->prepare("SELECT * from $tabela where telefone = :telefone");
	$query->bindValue(":telefone", "$telefone");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Telefone já Cadastrado!';
		exit();
	}
}




$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, senha = '$senha_crip', rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, cep = :cep  where id = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":rua", "$endereco");
$query->bindValue(":numero", "$numero");
$query->bindValue(":bairro", "$bairro");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":cidade", "$cidade");
$query->bindValue(":estado", "$estado");
$query->bindValue(":cep", "$cep");

$query->execute();

echo 'Editado com Sucesso';
 ?>