<?php 
include("../sistema/conexao.php");

$id_carrinho = $_POST['id_carrinho'];


$query = $pdo->query("SELECT * from carrinho where id = '$id_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

	$id = $res[0]['id'];
	$cliente = $res[0]['cliente'];
	$produto = $res[0]['produto'];
	$quantidade = $res[0]['quantidade'];
	$valor = $res[0]['valor'];
	$total = $res[0]['total'];

	$valorF = @number_format($valor, 2, ',', '.');
	$totalF = @number_format($total, 2, ',', '.');

	$query2 = $pdo->query("SELECT * from produtos where id = '$produto'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$linhas2 = @count($res2);
	if($linhas2 > 0){
		$nome_produto = $res2[0]['nome'];	
		$url_produto = $res2[0]['nome_url'];	
		$foto_produto = $res2[0]['imagem'];	
	}




 //grade do produto
	$query3 = $pdo->query("SELECT * from temp where carrinho = '$id' order by id asc");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	$linhas3 = @count($res3);
	if($linhas3 > 0){
		for($i3=0; $i3<$linhas3; $i3++){
			$id_temp = $res3[$i3]['id'];
			$id_grade = $res3[$i3]['grade'];
			$id_item = $res3[$i3]['id_item'];

			$query2 = $pdo->query("SELECT * from grades where id = '$id_grade' order by id asc");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$nome_grade = $res2[0]['nome_comprovante'];

			$query2 = $pdo->query("SELECT * from itens_grade where id = '$id_item' order by id asc");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$nome_item = $res2[0]['texto'];
			$valor_item = $res2[0]['valor'];

			$ocultar_valor = 'ocultar';
			if($valor_item > 0){
				$ocultar_valor = '';
			}

			echo '<span style="font-size:13px;"><b> '.$nome_grade.'</b>: '.$nome_item.' <span class="'.$ocultar_valor.' text-danger">R$ '.$valor_item.'</span> </span><br>';


		}
	}


}

?>

<script type="text/javascript">
	$("#nome_produto").text('<?=$nome_produto?>');       
</script>