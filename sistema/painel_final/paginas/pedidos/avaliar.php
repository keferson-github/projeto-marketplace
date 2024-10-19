<?php 
@session_start();
$id_usuario = @$_SESSION['id_cliente'];
$tabela = 'avaliacoes';
require_once("../../../conexao.php");

$nota = filter_var(@$_POST['nota'], @FILTER_SANITIZE_STRING);
$texto = filter_var(@$_POST['texto'], @FILTER_SANITIZE_STRING);
$id_produto = filter_var(@$_POST['id_produto'], @FILTER_SANITIZE_STRING);
$id_carrinho = filter_var(@$_POST['id_carrinho'], @FILTER_SANITIZE_STRING);
$id_venda = filter_var(@$_POST['id_venda'], @FILTER_SANITIZE_STRING);

$query2 = $pdo->query("SELECT * from carrinho where id = '$id_carrinho'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$status = $res2[0]['status'];
$loja = $res2[0]['loja'];
$cliente = $res2[0]['cliente'];
if($status != 'Entregue'){
	echo 'Você não pode avaliar esse item!';
	exit();
}


//verificar se o produto já foi avaliado por esse cliente
$query2 = $pdo->query("SELECT * from $tabela where produto = '$id_produto' and cliente = '$id_usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_ava = @count($res2);
if($total_ava > 0){
	echo 'Você já avaliou esse item!';
	exit();
}





//atualizar na tabela de produtos a nota do produto
$query2 = $pdo->query("SELECT * from produtos where id = '$id_produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nota_produto = $res2[0]['nota'];
$nome_produto = $res2[0]['nome'];
if($nota_produto > 0){
	$media_nota = ($nota_produto + $nota) / 2;
}else{
	$media_nota = $nota;
}

//dados cliente
$query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res2[0]['nome'];


$pdo->query("UPDATE produtos SET nota = '$media_nota' where id = '$id_produto'");


$query = $pdo->prepare("INSERT INTO $tabela SET venda = :venda, carrinho = :carrinho, produto = :produto, cliente = :cliente, nota = :nota, texto = :texto,  data = curDate(), hora = curTime() ");
$query->bindValue(":venda", "$id_venda");
$query->bindValue(":carrinho", "$id_carrinho");
$query->bindValue(":produto", "$id_produto");
$query->bindValue(":cliente", "$id_usuario");
$query->bindValue(":nota", "$nota");
$query->bindValue(":texto", "$texto");
$query->execute();

echo 'Salvo com Sucesso';



//trazer as informações da loja
$query2 = $pdo->query("SELECT * from usuarios where id = '$loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_loja = $res2[0]['nome'];
$tel_loja = $res2[0]['telefone'];
$email_loja = $res2[0]['email'];

//disparos

if($api_whatsapp != 'Não' and $tel_loja != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $tel_loja);
	
	$mensagem_whatsapp = '🤩 _Nova Avaliação_ %0A';
	$mensagem_whatsapp .= '*Loja:* '.$nome_loja.' %0A';
	$mensagem_whatsapp .= '*Produto:* '.$nome_produto.' %0A';
	$mensagem_whatsapp .= '*Cliente:* '.$nome_cliente.' %0A';
	$mensagem_whatsapp .= '*Nota:* '.$nota.' %0A';
	$mensagem_whatsapp .= '*Texto:* '.$texto.' %0A';
	

	require('../../../painel/apis/texto.php');
}

//enviar email
if($email_loja != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email_loja;
	$assunto = 'Nova Avaliação '. $nome_loja;
	$mensagem_email = 'Olá '.$nome_loja.' você teve uma nova avaliação em seus produtos! <br>';
	$mensagem_email .= '<b>Cliente</b>: '.$nome_cliente.'<br>';
	$mensagem_email .= '<b>Nota: </b>'.$nota.'<br>';
	$mensagem_email .= '<b>Mensagem: </b>'.$texto.'<br><br>';

	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('../../../painel/apis/disparar_email.php');
}

?>