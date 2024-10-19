<?php 
@session_start();
$id = @$_SESSION['id'];

$tabela = 'usuarios';
require_once("../conexao.php");

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
$ativo = filter_var(@$_POST['ativo'], @FILTER_SANITIZE_STRING);
$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);
$pix = filter_var(@$_POST['pix'], @FILTER_SANITIZE_STRING);

$rg = filter_var($_POST['rg'], @FILTER_SANITIZE_STRING);
$complemento = filter_var($_POST['complemento'], @FILTER_SANITIZE_STRING);


$conf_senha = filter_var(@$_POST['conf_senha'], @FILTER_SANITIZE_STRING);
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);


if($conf_senha != $senha){
	echo 'As senhas não se coincidem';
	exit();
}


$query = $pdo->query("SELECT * from $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$ref = @$res[0]['ref'];


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



//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = 'images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		
			//pegar o tamanho da imagem
			list($largura, $altura) = getimagesize($imagem_temp);
		 	if($largura > 1400){
		 		$image = imagecreatefromjpeg($imagem_temp);
		        // Reduza a qualidade para 20% ajuste conforme necessário
		        imagejpeg($image, $caminho, 20);
		        imagedestroy($image);
		 	}else{
		 		move_uploaded_file($imagem_temp, $caminho);
		 	}
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, senha_crip = '$senha_crip', endereco = :endereco, foto = '$foto' where id = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");

$query->execute();


if($data_nasc == ""){
	$nasc = '';	
}else{
	$nasc = " ,data_nasc = '$data_nasc'";
	
}

$query = $pdo->prepare("UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, cpf = :cpf, tipo_pessoa = :tipo_pessoa $nasc , numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, rg = :rg, complemento = :complemento, pix = :pix where id = '$ref'");

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
$query->bindValue(":pix", "$pix");
$query->execute();

echo 'Editado com Sucesso';
 ?>