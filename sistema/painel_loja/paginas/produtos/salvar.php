<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'produtos';
require_once("../../../conexao.php");



$nome = $_POST['nome'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$valor_promocional = $_POST['valor_promocional'];
$valor_promocional = str_replace(',', '.', $valor_promocional);
$estoque = $_POST['estoque'];
$nivel_estoque = $_POST['nivel_estoque'];
$categoria = $_POST['categoria'];
$subcategoria = @$_POST['subcategoria'];
$tipo_envio = $_POST['tipo_envio'];
$valor_frete = $_POST['valor_frete'];
$valor_frete = str_replace(',', '.', $valor_frete);
$promocao = $_POST['promocao'];
$nome_frete = $_POST['nome_frete'];

$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$peso = $_POST['peso'];
$peso = str_replace(',', '.', $peso);

$comprimento = $_POST['comprimento'];
$palavras = $_POST['palavras'];

$descricao = $_POST['descricao'];
$carac = $_POST['carac'];
$video = $_POST['video'];

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);

$nome_url = str_replace('%', '', $nome_url);
$nome_url = str_replace('"', '', $nome_url);
$nome_url = str_replace('/', '', $nome_url);
$nome_url = str_replace("'", '', $nome_url);
$nome_url = str_replace('$', '', $nome_url);

$video = str_replace('"', '', $video);
$video = str_replace("'", '', $video);

$id = $_POST['id'];

if($subcategoria == ""){
	$subcategoria = 0;
}

if($tipo_envio == 'Valor Fixo'){
	if($valor_frete == ''){
		echo 'Preencha o valor do Frete Fixo';
		exit();
	}

	if($nome_frete == ''){
		echo 'Preencha o nome da transportadora em que você usará para o envio!';
		exit();
	}
}


//validacao nome
if($nome != ""){
	$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Nome já Cadastrado em algum produto, escolha outro!';
		exit();
	}
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

$caminho = '../../images/produtos/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.png"){
				@unlink('../../images/produtos/'.$foto);
			}

			$foto = $nome_img;
		
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
}

$largura = $_POST['largura'];
$altura = $_POST['altura'];

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, valor = :valor, valor_promo = :valor_promo, estoque = :estoque, nivel = :nivel, categoria = :categoria, subcategoria = :subcategoria, envio = :envio, frete = :frete, promocao = :promocao, imagem = :imagem, marca = :marca, modelo = :modelo, peso = :peso, largura = :largura, altura = :altura, comprimento = :comprimento, palavras = :palavras, descricao = :descricao, nome_url = :nome_url, ativo = 'Sim', vendas = '0', data = curDate(), loja = '$id_usuario', carac = :carac, nota = '0', video = :video, nome_frete = :nome_frete");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, valor = :valor, valor_promo = :valor_promo, estoque = :estoque, nivel = :nivel, categoria = :categoria, subcategoria = :subcategoria, envio = :envio, frete = :frete, promocao = :promocao, imagem = :imagem, marca = :marca, modelo = :modelo, peso = :peso, largura = :largura, altura = :altura, comprimento = :comprimento, palavras = :palavras, descricao = :descricao, nome_url = :nome_url, carac = :carac, video = :video, nome_frete = :nome_frete where id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":valor", "$valor");
$query->bindValue(":valor_promo", "$valor_promocional");
$query->bindValue(":estoque", "$estoque");
$query->bindValue(":nivel", "$nivel_estoque");
$query->bindValue(":categoria", "$categoria");
$query->bindValue(":subcategoria", "$subcategoria");
$query->bindValue(":envio", "$tipo_envio");
$query->bindValue(":frete", "$valor_frete");
$query->bindValue(":promocao", "$promocao");
$query->bindValue(":imagem", "$foto");
$query->bindValue(":marca", "$marca");
$query->bindValue(":modelo", "$modelo");
$query->bindValue(":peso", "$peso");
$query->bindValue(":largura", "$largura");
$query->bindValue(":altura", "$altura");
$query->bindValue(":comprimento", "$comprimento");
$query->bindValue(":palavras", "$palavras");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":nome_url", "$nome_url");
$query->bindValue(":carac", "$carac");
$query->bindValue(":video", "$video");
$query->bindValue(":nome_frete", "$nome_frete");
$query->execute();

echo 'Salvo com Sucesso';


 ?>
