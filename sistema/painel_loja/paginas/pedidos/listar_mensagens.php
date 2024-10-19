<?php 
@session_start();

$tabela = 'mensagens';
require_once("../../../conexao.php");

$id_carrinho = $_POST['id_carrinho'];


$query = $pdo->query("SELECT * from $tabela where carrinho = '$id_carrinho' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
		$cliente = $res[$i]['cliente'];
		$produto = $res[$i]['produto'];		
		$venda = $res[$i]['venda'];
		$loja = $res[$i]['loja'];
		$carrinho = $res[$i]['carrinho'];
		$texto = $res[$i]['texto'];
		$data = $res[$i]['data'];
		$hora = $res[$i]['hora'];
		$enviado = $res[$i]['enviado'];

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$horaF = date("H:i", @strtotime($hora));

	//verificar se o produto já foi avaliado por esse cliente
$query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res2[0]['nome'];

$query2 = $pdo->query("SELECT * from usuarios where id = '$loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_loja = $res2[0]['nome'];

if($enviado == 'Loja'){
	$enviado_por = '<span style="color:blue">Loja: </span>';
	$nome_enviado = $nome_loja;
	$mostrar_excluir = '';
}else{
	$enviado_por = 'Cliente: ';
	$nome_enviado = $nome_cliente;
	$mostrar_excluir = 'ocultar';
}

echo '<b>'.$enviado_por.'</b>'.$nome_enviado.' (<span style="font-size:12px"><i>'.$dataF.' as '.$horaF.'</i></span>) <a class="'.$mostrar_excluir.'" title="Excluir Mensagem" href="#" onclick="excluirMensagem('.$id.')"><i class="fa fa-trash text-danger"></i></a><br>';
echo '<span class="text-muted" style="font-size:13px"><i>'.$texto.'</i></span><br><br>';
}

}else{
	echo 'Não possui nenhum cadastro!';
}


?>



<script type="text/javascript">
	function avaliar(id, produto, nome_produto, venda){

		$('#tituloPedidos').text(nome_produto);
		$('#id_produto').val(produto);
		$('#id_carrinho').val(id);
		$('#id_venda').val(venda);
		$('#modalAvaliar').modal('show');
	}


	function mensagem(id, produto, nome_produto, venda, loja){

		$('#tituloMensagem').text(nome_produto);
		$('#id_produto_mensagem').val(produto);
		$('#id_carrinho_mensagem').val(id);
		$('#id_venda_mensagem').val(venda);
		$('#id_loja_mensagem').val(loja);
		$('#modalMensagem').modal('show');
		listarMensagens();
	}


	function excluirMensagem(id){
		$.ajax({
			        url: 'paginas/' + pag + "/excluir_mensagem.php",
			        method: 'POST',
			        data: {id},
			        dataType: "html",

			        success:function(result){			           
			           listarMensagens();
			        }
			    });
	}
</script>