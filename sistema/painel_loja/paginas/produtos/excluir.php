<?php 
$tabela = 'produtos';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = @$res[0]['imagem'];
if($foto != "sem-foto.png"){
	@unlink('../../images/produtos/'.$foto);
}


$query = $pdo->query("SELECT * FROM produtos_imagens where produto = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
for($i=0; $i<$linhas; $i++){
	$foto = @$res[$i]['foto'];
	if($foto != "sem-foto.png"){
		@unlink('../../images/produtos/'.$foto);
	}
}

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
$pdo->query("DELETE FROM produtos_imagens WHERE produto = '$id' ");
echo 'Excluído com Sucesso';
?>