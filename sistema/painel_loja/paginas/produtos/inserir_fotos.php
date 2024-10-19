<?php 
$tabela = 'produtos_imagens';
require_once("../../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id'];

$id = $_POST['id-imagens'];

for ($i = 0; $i < count(@$_FILES['imgproduto']['name']); $i++){

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imgproduto']['name'][$i];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../images/produtos/' .$nome_img;

$imagem_temp = @$_FILES['imgproduto']['tmp_name'][$i]; 

if(@$_FILES['imgproduto']['name'][$i] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 

		if (@$_FILES['imgproduto']['name'][$i] != ""){			

			$foto = $nome_img;
		}

		//pegar o tamanho da imagem
			list($largura, $altura) = getimagesize($imagem_temp);
		 	if($largura > 1400){
		 		echo 'Diminua a imagem para um tamanho de no máximo 1400px de largura!';
		 		exit();
		 	}else{
		 		move_uploaded_file($imagem_temp, $caminho);
		 	}
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}else{
	echo 'Insira uma Imagem!';
	exit();
}

$query = $pdo->query("INSERT INTO $tabela SET produto = '$id', foto = '$foto'");

}

echo 'Inserido com Sucesso';

?>