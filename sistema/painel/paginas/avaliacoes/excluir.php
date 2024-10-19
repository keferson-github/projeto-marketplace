<?php 
$tabela = 'avaliacoes';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query2 = $pdo->query("SELECT * from $tabela where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nota = $res2[0]['nota'];
$produto = $res2[0]['produto'];

$soma_notas = 0;
//total de notas dadas ao produto
$query2 = $pdo->query("SELECT * from $tabela where produto = '$produto' and id != '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_notas = @count($res2);
if($total_notas > 0){
	for($i=0; $i<$linhas; $i++){
		$nota_av = $res2[$i]['nota'];
		$soma_notas += $nota_av;
	}

	$media_nota = $soma_notas / $total_notas;
}else{
	$media_nota = 0;
}

//atualizar nova nota do produto
$pdo->query("UPDATE produtos set nota = '$media_nota' WHERE id = '$produto' ");

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>