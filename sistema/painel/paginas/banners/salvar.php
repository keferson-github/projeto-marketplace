<?php 
$tabela = 'banners';
require_once("../../../conexao.php");

$cliente1 = $_POST['cliente1'];
$link1 = $_POST['link1'];
$valor1 = $_POST['valor1'];
$validade1 = $_POST['validade1'];
$obs1 = $_POST['obs1'];

$cliente2 = $_POST['cliente2'];
$link2 = $_POST['link2'];
$valor2 = $_POST['valor2'];
$validade2 = $_POST['validade2'];
$obs2 = $_POST['obs2'];

$cliente3 = $_POST['cliente3'];
$link3 = $_POST['link3'];
$valor3 = $_POST['valor3'];
$validade3 = $_POST['validade3'];
$obs3 = $_POST['obs3'];

$id = $_POST['id'];




//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner1 = $res[0]['banner1'];
}else{
	$banner1 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner1']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner1']['tmp_name']; 

if(@$_FILES['banner1']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner1 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner1);
			}

			$banner1 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}






//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner2 = $res[0]['banner2'];
}else{
	$banner2 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner2']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner2']['tmp_name']; 

if(@$_FILES['banner2']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner2 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner2);
			}

			$banner2 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}




//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner3 = $res[0]['banner3'];
}else{
	$banner3 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner3']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner3']['tmp_name']; 

if(@$_FILES['banner3']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner3 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner3);
			}

			$banner3 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}




//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner_padrao1 = $res[0]['banner_padrao1'];
}else{
	$banner_padrao1 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner_padrao1']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner_padrao1']['tmp_name']; 

if(@$_FILES['banner_padrao1']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner_padrao1 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner_padrao1);
			}

			$banner_padrao1 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}





//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner_padrao2 = $res[0]['banner_padrao2'];
}else{
	$banner_padrao2 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner_padrao2']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner_padrao2']['tmp_name']; 

if(@$_FILES['banner_padrao2']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner_padrao2 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner_padrao2);
			}

			$banner_padrao2 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}





//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$banner_padrao3 = $res[0]['banner_padrao3'];
}else{
	$banner_padrao3 = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner_padrao3']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/banners/' .$nome_img;

$imagem_temp = @$_FILES['banner_padrao3']['tmp_name']; 

if(@$_FILES['banner_padrao3']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($banner_padrao3 != "sem-foto.png"){
				@unlink('../../images/banners/'.$banner_padrao3);
			}

			$banner_padrao3 = $nome_img;		
			move_uploaded_file($imagem_temp, $caminho);
		 	
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



$query = $pdo->prepare("UPDATE $tabela SET banner1 = :banner1, cliente1 = :cliente1, valor1 = :valor1, link1 = :link1, validade1 = :validade1, banner_padrao1 = :banner_padrao1, obs1 = :obs1, banner2 = :banner2, cliente2 = :cliente2, valor2 = :valor2, link2 = :link2, validade2 = :validade2, banner_padrao2 = :banner_padrao2, obs2 = :obs2, banner3 = :banner3, cliente3 = :cliente3, valor3 = :valor3, link3 = :link3, validade3 = :validade3, banner_padrao3 = :banner_padrao3, obs3 = :obs3 where id = '$id'");

$query->bindValue(":banner1", "$banner1");
$query->bindValue(":cliente1", "$cliente1");
$query->bindValue(":valor1", "$valor1");
$query->bindValue(":link1", "$link1");
$query->bindValue(":validade1", "$validade1");
$query->bindValue(":banner_padrao1", "$banner_padrao1");
$query->bindValue(":obs1", "$obs1");

$query->bindValue(":banner2", "$banner2");
$query->bindValue(":cliente2", "$cliente2");
$query->bindValue(":valor2", "$valor2");
$query->bindValue(":link2", "$link2");
$query->bindValue(":validade2", "$validade2");
$query->bindValue(":banner_padrao2", "$banner_padrao2");
$query->bindValue(":obs2", "$obs2");

$query->bindValue(":banner3", "$banner3");
$query->bindValue(":cliente3", "$cliente3");
$query->bindValue(":valor3", "$valor3");
$query->bindValue(":link3", "$link3");
$query->bindValue(":validade3", "$validade3");
$query->bindValue(":banner_padrao3", "$banner_padrao3");
$query->bindValue(":obs3", "$obs3");
$query->execute();

echo 'Salvo com Sucesso';
 ?>