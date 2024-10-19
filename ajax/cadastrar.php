<?php 
include("../sistema/conexao.php");

$nome = filter_var(@$_POST['nome'], @FILTER_SANITIZE_STRING);
$email = filter_var(@$_POST['email'], @FILTER_SANITIZE_STRING);
$telefone = filter_var(@$_POST['telefone'], @FILTER_SANITIZE_STRING);
$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);
$conf_senha = filter_var(@$_POST['conf_senha'], @FILTER_SANITIZE_STRING);

$cep = filter_var(@$_POST['cep'], @FILTER_SANITIZE_STRING);
$rua = filter_var(@$_POST['rua'], @FILTER_SANITIZE_STRING);
$numero = filter_var(@$_POST['numero'], @FILTER_SANITIZE_STRING);
$complemento = filter_var(@$_POST['complemento'], @FILTER_SANITIZE_STRING);
$bairro = filter_var(@$_POST['bairro'], @FILTER_SANITIZE_STRING);
$cidade = filter_var(@$_POST['cidade'], @FILTER_SANITIZE_STRING);
$estado = filter_var(@$_POST['estado'], @FILTER_SANITIZE_STRING);

$id = filter_var(@$_POST['id'], @FILTER_SANITIZE_STRING);

if($senha != $conf_senha){
	echo 'As senhas são diferentes!';
	exit();
}


$senha = password_hash($senha, PASSWORD_DEFAULT);

//validacao email
if($email != ""){
	$query = $pdo->prepare("SELECT * from clientes_finais where email = :email");
	$query->bindValue(":email", "$email");	
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);	
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Email já Cadastrado!';
		exit();
	}
}

if($id == ""){
	$query = $pdo->prepare("INSERT INTO clientes_finais SET nome = :nome, email = :email, telefone = :telefone, data = curDate(), rua = :rua, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, complemento = :complemento, senha = :senha");
}else{
	$query = $pdo->prepare("UPDATE clientes_finais SET nome = :nome, email = :email, telefone = :telefone, rua = :rua, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, complemento = :complemento, senha = :senha WHERE id = :id");
	$query->bindValue(":id", "$id");
}



$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":rua", "$rua");
$query->bindValue(":numero", "$numero");
$query->bindValue(":bairro", "$bairro");
$query->bindValue(":cidade", "$cidade");
$query->bindValue(":estado", "$estado");
$query->bindValue(":cep", "$cep");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":senha", "$senha");
$query->execute();

echo 'Salvo com Sucesso';


if($id == ""){
//enviar whatsapp
if($api_whatsapp != 'Não' and $telefone != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
	$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '🤩_Olá '.$nome.' você se cadastrou no Sistema!!_ %0A';
	$mensagem_whatsapp .= '*Email:* '.$email.' %0A';	
	$mensagem_whatsapp .= '*Url Acesso:* %0A'.$url_sistema.'login %0A%0A';
	
	require('../sistema/painel/apis/texto.php');
}

//enviar email
if($email != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email;
	$assunto = 'Cadastrado no sistema '. $nome_sistema;
	$mensagem_email = 'Olá '.$nome.' você se cadastrou no sistema <br>';
	$mensagem_email .= '<b>Usuário</b>: '.$email.'<br>';	
	$mensagem_email .= 'Url Acesso: <br><a href="'.$url_sistema.'login">'.$url_sistema. 'login</a><br><br>';
	
	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('../sistema/painel/apis/disparar_email.php');
}

}


?>