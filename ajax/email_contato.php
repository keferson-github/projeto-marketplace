<?php
include("../sistema/conexao.php");

$nome = @$_POST['nome'];
$email = @$_POST['email'];
$mensagem = @$_POST['mensagem'];
$email_sistema = @$_POST['email_sistema'];

$mensagem_email = '<b>Nome</b>: '.$nome.'<br>';	
$mensagem_email .= '<b>Email</b>: '.$email.'<br>';
$mensagem_email .= '<b>Mensagem</b>: '.$mensagem.'<br>';

$destinatario = $email_sistema;
$assunto = 'Email Site '.$nome_sistema;
$mensagem = $mensagem_email;
$cabecalhos = 'MIME-Version: 1.0' . "\r\n";
$cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$cabecalhos .= "From: ".$email;

@mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Salvo com Sucesso';
?>