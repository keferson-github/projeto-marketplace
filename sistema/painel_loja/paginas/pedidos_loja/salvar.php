<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'carrinho';
require_once("../../../conexao.php");

$id = $_POST['id'];
$status = $_POST['status'];
$rastreio = $_POST['rastreio'];

$query = $pdo->prepare("UPDATE $tabela SET codigo_envio = :codigo_envio, status = :status WHERE id = :id ");
$query->bindValue(":codigo_envio", "$rastreio");
$query->bindValue(":status", "$status");
$query->bindValue(":id", "$id");
$query->execute();

echo 'Salvo com Sucesso';


$query2 = $pdo->query("SELECT * from carrinho where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$id_cliente = $res2[0]['cliente'];
$id_produto = $res2[0]['produto'];

//trazer as informações do cliente
$query2 = $pdo->query("SELECT * from clientes_finais where id = '$id_cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res2[0]['nome'];
$tel_cliente = $res2[0]['telefone'];
$email_cliente = $res2[0]['email'];

$query2 = $pdo->query("SELECT * from produtos where id = '$id_produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = $res2[0]['nome'];

//disparos
if($tipo_loja == 'MultiLojas'){
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){	
	$ref_cliente = $res[0]['ref'];	
}

$query = $pdo->query("SELECT * from config where id_loja = '$ref_cliente'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res);
	if($linhas > 0){
		$nome_sistema = $res[0]['nome'];
		$email_sistema = $res[0]['email'];
		$telefone_sistema = $res[0]['telefone'];
		$api_whatsapp = $res[0]['api_whatsapp'];
		$token_whatsapp = $res[0]['token_whatsapp'];
		$instancia_whatsapp = $res[0]['instancia_whatsapp'];

	}
}


if($api_whatsapp != 'Não' and $tel_cliente != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $tel_cliente);
	
	$mensagem_whatsapp = 'ℹ️ _Atualização no Status do Pedido_ %0A';

	if($tipo_loja == 'MultiLojas'){
		$mensagem_whatsapp .= '*Loja:* '.$nome_sistema.' %0A';
		$mensagem_whatsapp .= '*Telefone:* '.$telefone_sistema.' %0A';
	}
	
	$mensagem_whatsapp .= '*Produto:* '.$nome_produto.' %0A';
	$mensagem_whatsapp .= '*Status:* '.$status.' %0A';
	if($status == 'Enviado'){
		$mensagem_whatsapp .= '*Código de Rastreio:* '.$rastreio.' %0A';
	}	
	

	require('../../../painel/apis/texto.php');
}

//enviar email
if($email_cliente != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email_cliente;
	$assunto = 'Atualização no Status Pedido '. $nome_produto;
	$mensagem_email = 'Olá '.$nome_cliente.' você teve uma nova atualização na sua compra! <br>';
	$mensagem_email .= '<b>Produto</b>: '.$nome_produto.'<br>';	
	$mensagem_email .= '<b>Status: </b>'.$status.'<br>';
	if($status == 'Enviado'){
		$mensagem_email .= '<b>Código de Rastreio:</b> '.$rastreio.' <br>';
	}

	$mensagem_email .= "<br><img src='".$url_logo."' width='200px'> ";
	require('../../../painel/apis/disparar_email.php');
}


?>