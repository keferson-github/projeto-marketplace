<?php 
$tabela = 'subcategorias';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$categoria = $_POST['categoria'];
$id = $_POST['id'];

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);

$nome_url = str_replace('%', '', $nome_url);
$nome_url = str_replace('"', '', $nome_url);
$nome_url = str_replace('/', '', $nome_url);
$nome_url = str_replace("'", '', $nome_url);
$nome_url = str_replace('$', '', $nome_url);

//validacao nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome' and categoria = '$categoria' and id_loja is null");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}



//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['imagem'];
}else{
	$foto = 'sem-foto.png';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/subcategorias/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.png"){
				@unlink('../../images/subcategorias/'.$foto);
			}

			$foto = $nome_img;		
			
		 	move_uploaded_file($imagem_temp, $caminho);
		 	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, descricao = :descricao, imagem = '$foto', ativo = 'Sim', categoria = :categoria, url = :url");

	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, descricao = :descricao, imagem = '$foto', ativo = 'Sim', categoria = :categoria, url = :url  where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":categoria", "$categoria");
$query->bindValue(":url", "$nome_url");
$query->execute();

echo 'Salvo com Sucesso';
 ?>