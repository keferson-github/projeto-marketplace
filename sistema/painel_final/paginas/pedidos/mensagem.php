<?php 
@session_start();
$id_usuario = @$_SESSION['id_cliente'];
$tabela = 'mensagens';
require_once("../../../conexao.php");


$texto = filter_var(@$_POST['mensagem'], @FILTER_SANITIZE_STRING);
$id_produto = filter_var(@$_POST['id_produto'], @FILTER_SANITIZE_STRING);
$id_carrinho = filter_var(@$_POST['id_carrinho'], @FILTER_SANITIZE_STRING);
$id_venda = filter_var(@$_POST['id_venda'], @FILTER_SANITIZE_STRING);
$id_loja = filter_var(@$_POST['id_loja'], @FILTER_SANITIZE_STRING);

$query = $pdo->prepare("INSERT INTO $tabela SET venda = :venda, carrinho = :carrinho, produto = :produto, cliente = :cliente, loja = :loja, texto = :texto,  data = curDate(), hora = curTime(), enviado = 'Cliente' ");
$query->bindValue(":venda", "$id_venda");
$query->bindValue(":carrinho", "$id_carrinho");
$query->bindValue(":produto", "$id_produto");
$query->bindValue(":cliente", "$id_usuario");
$query->bindValue(":loja", "$id_loja");
$query->bindValue(":texto", "$texto");
$query->execute();

echo 'Salvo com Sucesso';


$query2 = $pdo->query("SELECT * from produtos where id = '$id_produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = $res2[0]['nome'];

$query2 = $pdo->query("SELECT * from clientes_finais where id = '$id_usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res2[0]['nome'];


//trazer as informações da loja
$query2 = $pdo->query("SELECT * from usuarios where id = '$id_loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_loja = $res2[0]['nome'];
$tel_loja = $res2[0]['telefone'];
$email_loja = $res2[0]['email'];

//disparos

if($api_whatsapp != 'Não' and $tel_loja != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $tel_loja);
	
	$mensagem_whatsapp = '🤩 _Nova Mensagem_ %0A';
	$mensagem_whatsapp .= '*Loja:* '.$nome_loja.' %0A';
	$mensagem_whatsapp .= '*Produto:* '.$nome_produto.' %0A';
	$mensagem_whatsapp .= '*Cliente:* '.$nome_cliente.' %0A';	
	$mensagem_whatsapp .= '*Mensagem:* '.$texto.' %0A';
	

	require('../../../painel/apis/texto.php');
}

//enviar email
if($email_loja != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email_loja;
	$assunto = 'Nova Mensagem '. $nome_loja;
	$mensagem_email = 'Olá '.$nome_loja.' você teve uma nova mensagem em seus produtos! <br>';
	$mensagem_email .= '<b>Cliente</b>: '.$nome_cliente.'<br>';	
	$mensagem_email .= '<b>Mensagem: </b>'.$texto.'<br><br>';

	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('../../../painel/apis/disparar_email.php');
}

?>