<?php 
include("../sistema/conexao.php");
@session_start();
$id_cliente = @$_SESSION['id_cliente'];

if(@$_SESSION['sessao_carrinho'] == ""){
	$sessao_carrinho = date('Y-m-d-H:i:s-').rand(0, 1500);
	$_SESSION['sessao_carrinho'] = $sessao_carrinho;
}else{
	$sessao_carrinho = $_SESSION['sessao_carrinho'];
}

$total_produtos = 0;
$total_carrinho = 0;
$total_frete = 0;
$total_desconto = 0;

$query2 = $pdo->query("SELECT * from cupons_usados where sessao = '$sessao_carrinho'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas2 = @count($res2);
if($linhas2 > 0){
	for($i2=0; $i2<$linhas2; $i2++){
		$valor_desc = $res2[$i2]['valor'];
		$total_desconto += $valor_desc;
	}
}

$query = $pdo->query("SELECT * from carrinho where sessao = '$sessao_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	echo '<script>window.location="index"</script>';  
}

echo '

<table class="table table-bordered">
<thead>
<tr>                                    
<td class="text-left">Produto</td>                                   
<td class="text-left">Quantidade</td>
<td class="text-right">Valor</td>
<td class="text-right">Total</td>

</tr>

</thead>
<tbody>';

$query = $pdo->query("SELECT * from carrinho where sessao = '$sessao_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$id = $res[$i]['id'];
		$cliente = $res[$i]['cliente'];
		$produto = $res[$i]['produto'];
		$quantidade = $res[$i]['quantidade'];
		$valor = $res[$i]['valor'];
		$total = $res[$i]['total'];
		$frete = $res[$i]['frete'];

				                        //verificar se tem cupom de desconto



		$total_produtos += $total;
		$total_frete += $frete;
		$total_carrinho += $total;
		$total_carrinho += $frete;


		$valorF = @number_format($valor, 2, ',', '.');
		$totalF = @number_format($total, 2, ',', '.');
		
		$total_freteF = @number_format($total_frete, 2, ',', '.');
		$total_produtosF = @number_format($total_produtos, 2, ',', '.');
		$total_descontoF = @number_format($total_desconto, 2, ',', '.');

		$query2 = $pdo->query("SELECT * from produtos where id = '$produto'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas2 = @count($res2);
		if($linhas2 > 0){
			$nome_produto = $res2[0]['nome'];	
			$url_produto = $res2[0]['nome_url'];	
			$foto_produto = $res2[0]['imagem'];	
		}



		echo '                               
		<tr>
		<td class=""><a class="" href="produto-'.$url_produto.'"><img width="70px"
		src="sistema/painel_loja/images/produtos/'.$foto_produto.'"
		alt="'.$nome_produto.'" title="Detalhes do Produto"
		class="img-thumbnail" /></a>

		<a class="ocultar_mobile_inline" href="produto-'.$url_produto.'">'.$nome_produto.'</a>
		<div class="ocultar_mobile_inline" style="position:relative; bottom:-22px; left:-90px; " >
		';

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

				echo '<span style="font-size:12px;"><b> '.$nome_grade.'</b>: '.$nome_item.' </span>';


			}
		}

		echo'</div></td>

		<td class="text-left" >

		<span style="display:inline-block;"> 
		<a href="#" onclick="dim('.$id.')"><img  src="image/demo/colors/minus.png" width="15px"></a></span>

		<input style="display:inline-block; width:20px; border:none; text-align:center;  outline:none" type="text" id="quant_car_'.$id.'" value="'.$quantidade.'" size="1"
		class="" />

		<span style="display:inline-block;"> 
		<a href="#" onclick="aum('.$id.')"><img src="image/demo/colors/plus.png" width="15px"> </a></span>';

		if($linhas3 > 0){
			echo '<br><br>
			<a href="#" onclick="grades('.$id.')" style="font-size:11px">Opcionais</a>';  
		}	        

		echo '</td>
		<td class="text-right">R$ '.$valorF.'</td>
		<td class="text-right">R$ '.$totalF.'

		</td>
		</tr>';

	}

		$total_carrinho = $total_carrinho - $total_desconto;
		$total_carrinhoF = @number_format($total_carrinho, 2, ',', '.');

	 }else{
		echo 'Nenhum Produto Adicionado!';
	}

	echo '</tbody>
	</table>

	';


	?>

	<script type="text/javascript">

		$("#total_carrinho").val('<?=$total_carrinho?>');
		$("#total_itens_carrinho").text('<?=$linhas?>');
		$("#valor_itens_carrinho").text('<?=$total_carrinhoF?>');

		$("#total_dos_itens").text('<?=$total_produtosF?>');
		$("#total_subtotal").text('<?=$total_carrinhoF?>');

		$("#total_frete_carrinho").val('<?=$total_frete?>');
		$("#total_frete_carrinho_F").text('<?=$total_freteF?>');

		$("#total_desconto").val('<?=$total_desconto?>');
		$("#total_desconto_F").text('<?=$total_descontoF?>');


		function aum(id_carrinho){
			var qtd = $("#quant_car_"+id_carrinho).val();
			var total = parseFloat(qtd) + 1;

			$("#quant_car_"+id_carrinho).val(total);
			editarItem(id_carrinho, total);   
		}


		function dim(id_carrinho){
			var qtd = $("#quant_car_"+id_carrinho).val();

			if(qtd == 1){			
				editarItem(id_carrinho, 0);
			}else{
				var total = parseFloat(qtd) - 1;
				editarItem(id_carrinho, total);
			}


			$("#quant_car_"+id_carrinho).val(total)      
		}

		function editarItem(id_carrinho, total){
			$.ajax({
				url: 'ajax/editar_carrinho.php',
				method: 'POST',
				data: {id_carrinho, total},
				dataType: "html",

				success:function(result){
					listarCarrinho();    

				}
			});
		}
	</script>