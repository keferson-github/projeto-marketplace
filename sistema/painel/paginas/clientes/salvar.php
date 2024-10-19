<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

@session_start();
$id_usuario = @$_SESSION['id'];


$nome = filter_var($_POST['nome'], @FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], @FILTER_SANITIZE_STRING);
$telefone = filter_var($_POST['telefone'], @FILTER_SANITIZE_STRING);
$endereco = filter_var($_POST['endereco'], @FILTER_SANITIZE_STRING);
$data_nasc = filter_var($_POST['data_nasc'], @FILTER_SANITIZE_STRING);
$cpf = filter_var($_POST['cpf'], @FILTER_SANITIZE_STRING);
$tipo_pessoa = filter_var($_POST['tipo_pessoa'], @FILTER_SANITIZE_STRING);
$numero = filter_var($_POST['numero'], @FILTER_SANITIZE_STRING);
$bairro = filter_var($_POST['bairro'], @FILTER_SANITIZE_STRING);
$cidade = filter_var($_POST['cidade'], @FILTER_SANITIZE_STRING);
$estado = filter_var($_POST['estado'], @FILTER_SANITIZE_STRING);
$cep = filter_var($_POST['cep'], @FILTER_SANITIZE_STRING);
$id = filter_var(@$_POST['id'], @FILTER_SANITIZE_STRING);
$ativo = filter_var(@$_POST['ativo'], @FILTER_SANITIZE_STRING);
$url = filter_var(@$_POST['url'], @FILTER_SANITIZE_STRING);
$pix = filter_var(@$_POST['pix'], @FILTER_SANITIZE_STRING);

$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);
$conf_senha = filter_var(@$_POST['conf_senha'], @FILTER_SANITIZE_STRING);

if($senha != $conf_senha){
	echo 'As senhas não coincidem!!';
	exit();
}

if($senha == ""){
	$senha = '123';
	$senhaF = '123';
}else{
	$senhaF = 'Senha que você definiu no cadastro!';
}

if($ativo != 'Sim' and $aprovar_loja == 'Sim'){
	$ativo = 'Não';
}

$rg = filter_var($_POST['rg'], @FILTER_SANITIZE_STRING);
$complemento = filter_var($_POST['complemento'], @FILTER_SANITIZE_STRING);
$genitor = filter_var(@$_POST['genitor'], @FILTER_SANITIZE_STRING);
$genitora = filter_var(@$_POST['genitora'], @FILTER_SANITIZE_STRING);

if($tipo_pessoa == 'Física' and $cpf != ""){
	require_once("../../validar_cpf.php");
}



//validacao email
if($email != ""){
	$query = $pdo->prepare("SELECT * from $tabela where url = :url");
	$query->bindValue(":url", "$url");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Url já Cadastrada!';
		exit();
	}
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


if($data_nasc == ""){
	$nasc = '';	
}else{
	$nasc = " ,data_nasc = '$data_nasc'";
	
}




if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, telefone = :telefone, data_cad = curDate(), endereco = :endereco, cpf = :cpf, tipo_pessoa = :tipo_pessoa $nasc, usuario = '$id_usuario', numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, rg = :rg, complemento = :complemento, genitor = :genitor, genitora = :genitora, ativo = '$ativo', url = :url, pix = :pix");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, cpf = :cpf, tipo_pessoa = :tipo_pessoa $nasc , numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, rg = :rg, complemento = :complemento, genitor = :genitor, genitora = :genitora, url = :url, pix = :pix where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":tipo_pessoa", "$tipo_pessoa");
$query->bindValue(":numero", "$numero");
$query->bindValue(":bairro", "$bairro");
$query->bindValue(":cidade", "$cidade");
$query->bindValue(":estado", "$estado");
$query->bindValue(":cep", "$cep");
$query->bindValue(":rg", "$rg");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":genitor", "$genitor");
$query->bindValue(":genitora", "$genitora");
$query->bindValue(":url", "$url");
$query->bindValue(":pix", "$pix");
$query->execute();


$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
if($id == ""){
	$ult_id = $pdo->lastInsertId();
	//inserir o usuário
	$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha_crip = '$senha_crip', nivel = 'Loja', ativo = '$ativo', data = curDate(), ref = '$ult_id', foto = 'sem-foto.jpg'");

}else{	
	$ult_id = $id;
	$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email where ref = '$ult_id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->execute();

$url_sistema = $url_sistema.'sistema';


if($id == ""){
//enviar whatsapp
if($api_whatsapp != 'Não' and $telefone != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
	$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '🤩_Olá '.$nome.' Você foi Cadastrado no Sistema!!_ %0A';
	$mensagem_whatsapp .= '*Email:* '.$email.' %0A';
	$mensagem_whatsapp .= '*Senha:* '.$senhaF.' %0A';
	$mensagem_whatsapp .= '*Url Acesso:* %0A'.$url_sistema.' %0A%0A';
	$mensagem_whatsapp .= '_Ao entrar no sistema, troque sua senha!_';

	require('../../apis/texto.php');
}

//enviar email
if($email != ''){
	$url_logo = $url_sistema.'img/logo.png';
	$destinatario = $email;
	$assunto = 'Cadastrado no sistema '. $nome_sistema;
	$mensagem_email = 'Olá '.$nome.' você foi cadastrado no sistema <br>';
	$mensagem_email .= '<b>Usuário</b>: '.$email.'<br>';
	$mensagem_email .= '<b>Senha: </b>'.$senhaF.'<br><br>';
	$mensagem_email .= 'Url Acesso: <br><a href="'.$url_sistema.'">'.$url_sistema. '</a><br><br>';
	$mensagem_email .= '<i>Ao entrar no sistema, troque sua senha!</i>'. '<br><br>';
	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('../../apis/disparar_email.php');
}


if($ativo = 'Não'){
	//enviar whatsapp
	if($api_whatsapp != 'Não' and $telefone_sistema != ''){

		$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);
		$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
		$mensagem_whatsapp .= '🤩 _Um novo cliente se cadastrou no sistema_ %0A';
		$mensagem_whatsapp .= '*Nome:* '.$nome.' %0A';
		$mensagem_whatsapp .= '*Email:* '.$email.' %0A';
		$mensagem_whatsapp .= '*Telefone:* '.$telefone.' %0A';		

		require('../../apis/texto.php');
	}

	//enviar email
	if($email_sistema != ''){
		$url_logo = $url_sistema.'sistema/img/logo.png';
		$destinatario = $email;
		$assunto = 'Novo Cliente Cadastrado '. $nome_sistema;
		$mensagem_email = 'O cliente '.$nome.' se cadastrou no sistema <br>';
		$mensagem_email .= '<b>Nome</b>: '.$nome.'<br>';
		$mensagem_email .= '<b>Email: </b>'.$email.'<br>';
		$mensagem_email .= '<b>Telefone: </b>'.$telefone.'<br><br>';
		
		$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
		require('../../apis/disparar_email.php');
	}
}

}

echo 'Salvo com Sucesso';


 ?>
