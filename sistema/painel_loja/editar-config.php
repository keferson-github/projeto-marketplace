<?php 
$tabela = 'config';
require_once("../conexao.php");

$nome = $_POST['nome_sistema'];
$email = $_POST['email_sistema'];
$telefone = $_POST['telefone_sistema'];
$endereco = $_POST['endereco_sistema'];
$instagram = $_POST['instagram_sistema'];

$api_whatsapp = $_POST['api_whatsapp'];
$token_whatsapp = $_POST['token_whatsapp'];
$instancia_whatsapp = $_POST['instancia_whatsapp'];

$id = $_POST['id'];

$token_mp = $_POST['token_mp'];
$public_mp = $_POST['public_mp'];


//foto logo
$caminho = '../img/logo_'.$id.'.png';
$imagem_temp = @$_FILES['foto-logo']['tmp_name']; 

if(@$_FILES['foto-logo']['name'] != ""){
	$ext = pathinfo($_FILES['foto-logo']['name'], PATHINFO_EXTENSION);   
	if($ext == 'png' || $ext == 'PNG'){ 	
				
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


//foto painel
$caminho = '../img/foto-painel_'.$id.'.png';
$imagem_temp = @$_FILES['foto-painel']['tmp_name']; 

if(@$_FILES['foto-painel']['name'] != ""){
	$ext = pathinfo(@$_FILES['foto-painel']['name'], PATHINFO_EXTENSION);   
	if($ext == 'png' || $ext == 'PNG'){ 	
			
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, instagram = :instagram, api_whatsapp = '$api_whatsapp', token_whatsapp = :token_whatsapp, instancia_whatsapp = :instancia_whatsapp, token_mp = :token_mp , public_mp = :public_mp  where id_loja = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":instagram", "$instagram");
$query->bindValue(":token_whatsapp", "$token_whatsapp");
$query->bindValue(":instancia_whatsapp", "$instancia_whatsapp");
$query->bindValue(":token_mp", "$token_mp");
$query->bindValue(":public_mp", "$public_mp");
$query->execute();

echo 'Editado com Sucesso';
 ?>