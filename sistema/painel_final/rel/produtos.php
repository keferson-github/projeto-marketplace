<?php 

include('../../conexao.php');
include('data_formatada.php');

$token_rel = @$_GET['token'];
if($token_rel != 'A5090'){
echo '<script>window.location="../../"</script>';
exit();
}

$data_atual = date('Y-m-d');

$id_usuario = $_GET['usuario'];
$categoria = $_GET['categoria'];
$subcategoria = $_GET['subcategoria'];

$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");	
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_operador = @$res[0]['nome'];

$query2 = $pdo->query("SELECT * FROM categorias where id = '$categoria'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_categoria = $res2[0]['nome'];
	}else{
		$nome_categoria = '';
	}

	$query2 = $pdo->query("SELECT * FROM subcategorias where id = '$subcategoria'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_subcategoria = $res2[0]['nome'];
	}else{
		$nome_subcategoria = '';
	}


$filtro_operador = "";

if($categoria == ""){

	$filtro_operador = ''; 

}else{

	$filtro_operador = " CATEGORIA ".@mb_strtoupper($nome_categoria);

	if($subcategoria != ""){
		$filtro_operador .= " / SUBCATEGORIA ".@mb_strtoupper($nome_subcategoria);
	}

}


?>

<!DOCTYPE html>

<html>

<head>



<style>



@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');

@page { margin: 145px 20px 25px 20px; }

#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }

#content {margin-top: 0px;}

#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }

#footer .page:after {content: counter(page, my-sec-counter);}

body {font-family: 'Tw Cen MT', sans-serif;}



.marca{

	position:fixed;

	left:50;

	top:100;

	width:80%;

	opacity:8%;

}



</style>



</head>

<body>

<?php 

if($marca_dagua == 'Sim'){ ?>

<img class="marca" src="<?php echo $url_sistema ?>sistema/img/logo.jpg">	

<?php } ?>





<div id="header" >



	<div style="border-style: solid; font-size: 10px; height: 50px;">

		<table style="width: 100%; border: 0px solid #ccc;">

			<tr>

				<td style="border: 1px; solid #000; width: 37%; text-align: left;">

					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>sistema/img/logo.jpg" width="130px">

				</td>

				
				<td style="width: 1%; text-align: center; font-size: 13px;">

				

				</td>

				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">

						<b><big>RELATÓRIO DE PRODUTOS </big></b><br> <?php echo @mb_strtoupper($filtro_operador) ?> <br> <?php echo @mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 8px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">

					<td style="width:28%">NOME</td>

					<td style="width:10%">VALOR</td>

					<td style="width:7%">ESTOQUE</td>

					<td style="width:20%">CATEGORIA</td>

					<td style="width:20%">SUBCATEGORIA</td>

					<td style="width:8%">ENVIO</td>	

					<td style="width:7%">VENDAS</td>	

					

					

				</tr>

			</thead>

		</table>

</div>



<div id="footer" class="row">

<hr style="margin-bottom: 0;">

	<table style="width:100%;">

		<tr style="width:100%;">

			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>

			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>

		</tr>

	</table>

</div>



<div id="content" style="margin-top: 0;">







		<table style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>

				<tbody>

					<?php


if($categoria != ""){
	$query = $pdo->query("SELECT * from produtos where loja = '$id_usuario' and categoria = '$categoria' order by id desc");
	if($subcategoria != ""){
		$query = $pdo->query("SELECT * from produtos where loja = '$id_usuario' and categoria = '$categoria' and subcategoria = '$subcategoria' order by id desc");
	}
}else{
	$query = $pdo->query("SELECT * from produtos where loja = '$id_usuario' order by id desc");
}


$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

for($i=0; $i<$linhas; $i++){

	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$valor = $res[$i]['valor'];	
	$valor_promo = $res[$i]['valor_promo'];
	$estoque = $res[$i]['estoque'];
	$nivel = $res[$i]['nivel'];
	$categoria = $res[$i]['categoria'];
	$subcategoria = $res[$i]['subcategoria'];
	$envio = $res[$i]['envio'];
	$frete = $res[$i]['frete'];
	$promocao = $res[$i]['promocao'];
	$imagem = $res[$i]['imagem'];
	$marca = $res[$i]['marca'];
	$modelo = $res[$i]['modelo'];
	$peso = $res[$i]['peso'];
	$largura = $res[$i]['largura'];
	$altura = $res[$i]['altura'];
	$comprimento = $res[$i]['comprimento'];
	$palavras = $res[$i]['palavras'];
	$descricao = $res[$i]['descricao'];
	$nome_url = $res[$i]['nome_url'];
	$ativo = $res[$i]['ativo'];
	$vendas = $res[$i]['vendas'];
	$data = $res[$i]['data'];
	$loja = $res[$i]['loja'];
	
	
	if($ativo == 'Sim'){
	$icone = 'fa-check-square';
	$titulo_link = 'Desativar Usuário';
	$acao = 'Não';
	$classe_ativo = '';
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
	}


	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$valor_promoF = @number_format($valor_promo, 2, ',', '.');
	$valorF = @number_format($valor, 2, ',', '.');
	$freteF = @number_format($frete, 2, ',', '.');	


	$query2 = $pdo->query("SELECT * FROM categorias where id = '$categoria'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_categoria = $res2[0]['nome'];
	}else{
		$nome_categoria = '';
	}

	$query2 = $pdo->query("SELECT * FROM subcategorias where id = '$subcategoria'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_subcategoria = $res2[0]['nome'];
	}else{
		$nome_subcategoria = '';
	}

	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$loja'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_usuario = $res2[0]['nome'];
		$ref = $res2[0]['ref'];
	}else{
		$nome_usuario = '';
	}


	$query2 = $pdo->query("SELECT * FROM envios where id = '$envio'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_envio = $res2[0]['nome'];
	}else{
		$nome_envio = '';
	}


	if($valor_promo > 0 and $promocao == 'Sim'){
		$texto_promo = ' / <span style="color:green">'.$valor_promoF.'</span>';
	}else{
		$texto_promo = '';
	}




  	 ?>



  	 

      <tr>

<td style="width:28%"><?php echo $nome ?></td>

<td style="width:10%"><?php echo $valorF ?> <?php echo $texto_promo ?></td>

<td style="width:7%"><?php echo $estoque ?></td>

<td style="width:20%"><?php echo $nome_categoria ?></td>

<td style="width:20%"><?php echo $nome_subcategoria ?></td>

<td style="width:8%;"><?php echo $nome_envio ?></td>

<td style="width:7%"><?php echo $vendas ?></td>




    </tr>



<?php } } ?>

				</tbody>

	

			</thead>

		</table>

	





</div>

<hr>

		


</body>



</html>





