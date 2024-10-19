<?php 
@session_start();
$id_usuario = @$_SESSION['id'];

$tabela = 'mensagens';
require_once("../../../conexao.php");


$texto = filter_var(@$_POST['mensagem'], @FILTER_SANITIZE_STRING);
$id_produto = filter_var(@$_POST['id_produto'], @FILTER_SANITIZE_STRING);
$id_carrinho = filter_var(@$_POST['id_carrinho'], @FILTER_SANITIZE_STRING);
$id_venda = filter_var(@$_POST['id_venda'], @FILTER_SANITIZE_STRING);
$id_loja = filter_var(@$_POST['id_loja'], @FILTER_SANITIZE_STRING);

$query2 = $pdo->query("SELECT * from carrinho where id = '$id_carrinho'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$id_cliente = $res2[0]['cliente'];


$query = $pdo->prepare("INSERT INTO $tabela SET venda = :venda, carrinho = :carrinho, produto = :produto, cliente = :cliente, loja = :loja, texto = :texto,  data = curDate(), hora = curTime(), enviado = 'Loja' ");
$query->bindValue(":venda", "$id_venda");
$query->bindValue(":carrinho", "$id_carrinho");
$query->bindValue(":produto", "$id_produto");
$query->bindValue(":cliente", "$id_cliente");
$query->bindValue(":loja", "$id_loja");
$query->bindValue(":texto", "$texto");
$query->execute();

echo 'Salvo com Sucesso';


$query2 = $pdo->query("SELECT * from produtos where id = '$id_produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = $res2[0]['nome'];


//trazer as informações do cliente
$query2 = $pdo->query("SELECT * from clientes_finais where id = '$id_cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res2[0]['nome'];
$tel_cliente = $res2[0]['telefone'];
$email_cliente = $res2[0]['email'];

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

echo $instancia_whatsapp;

if($api_whatsapp != 'Não' and $tel_cliente != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $tel_cliente);
	
	$mensagem_whatsapp = '🤩 _Nova Mensagem_ %0A';

	if($tipo_loja == 'MultiLojas'){
		$mensagem_whatsapp .= '*Loja:* '.$nome_sistema.' %0A';
		$mensagem_whatsapp .= '*Telefone:* '.$telefone_sistema.' %0A';
	}
	
	$mensagem_whatsapp .= '*Produto:* '.$nome_produto.' %0A';
	$mensagem_whatsapp .= '*Cliente:* '.$nome_cliente.' %0A';	
	$mensagem_whatsapp .= '*Mensagem:* '.$texto.' %0A';
	

	require('../../../painel/apis/texto.php');
}

//enviar email
if($email_cliente != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email_cliente;
	$assunto = 'Nova Mensagem '. $nome_produto;
	$mensagem_email = 'Olá '.$nome_cliente.' você teve uma nova mensagem em sua compra! <br>';
	$mensagem_email .= '<b>Produto</b>: '.$nome_produto.'<br>';	
	$mensagem_email .= '<b>Mensagem: </b>'.$texto.'<br><br>';

	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('../../../painel/apis/disparar_email.php');
}

?>