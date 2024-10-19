<?php 
$tabela = 'carrinho';
require_once("../../../conexao.php");

$pedido = $_POST['pedido'];
$sessao = $_POST['sessao'];




$query = $pdo->query("SELECT * from $tabela where venda = '$pedido' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" >
	<thead> 
	<tr> 
	
	
	<th class="esc" >Item</th>	
	<th class="esc" >Loja</th>		
	<th class="esc">Total</th>	
	<th class="esc">Vlr Frete</th>
	<th>Status</th>	
	<th class="esc">Tipo Frete</th>	
	<th>Código Envio</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
		$cliente = $res[$i]['cliente'];
		$produto = $res[$i]['produto'];
		$quantidade = $res[$i]['quantidade'];
		$valor = $res[$i]['valor'];
		$total = $res[$i]['total'];
		$frete = $res[$i]['frete'];
		$nome_frete = $res[$i]['nome_frete'];
		$codigo_envio = $res[$i]['codigo_envio'];
		$status = $res[$i]['status'];
		$loja = $res[$i]['loja'];
		$venda = $res[$i]['venda'];

		$query2 = $pdo->query("SELECT * from produtos where id = '$produto'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas2 = @count($res2);
		if($linhas2 > 0){
			$nome_produto = $res2[0]['nome'];	
			$url_produto = $res2[0]['nome_url'];	
			$foto_produto = $res2[0]['imagem'];	
		}

		$nome_produtoF = mb_strimwidth($nome_produto, 0, 15, "...");


	$dataF = implode('/', array_reverse(@explode('-', $data)));

	$valorF = @number_format($valor, 2, ',', '.');
	$totalF = @number_format($total, 2, ',', '.');
	$descontoF = @number_format($desconto, 2, ',', '.');
	$freteF = @number_format($frete, 2, ',', '.');

	$grades = '';
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

				$grade_produto = '<span style="font-size:12px;"><b> '.$nome_grade.'</b>: '.$nome_item.' </span><br>';
				$grades .= $grade_produto;

			}

		}

		$ocultar_grades = '';
		if($grades == ''){
			$ocultar_grades = 'ocultar';
		}



		if($status == 'Aguardando Envio'){
			$badge_status = 'bg-danger';
		}else if($status == 'Enviado'){
			$badge_status = 'bg-primary';
		}else if($status == 'Entregue'){
			$badge_status = 'bg-success';
		}else{
			$badge_status = 'bg-warning';
		}


		$query2 = $pdo->query("SELECT * from usuarios where id = '$loja'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome_loja = $res2[0]['nome'];


	


echo <<<HTML
<tr>

<td class="esc"><img width="30px"
		src="../painel_loja/images/produtos/{$foto_produto}"
		alt="'.$nome_produto.'" title="Detalhes do Produto"
		 /> ({$quantidade}) {$nome_produto}
		 <div class="dropdown" style="display: inline-block;">                      
                        <a class="text-primary {$ocultar_grades}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-info-circle "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text" style="background: #fffff2; padding:15px; margin-left: -50px; font-size: 14px">
                        <p>{$grades}</p>
                        </div>
                        </div>
                        </div>
                        &nbsp; &nbsp; &nbsp; &nbsp; 
		 </td>
<td class="esc">{$nome_loja}</td>
<td class="esc">R$ {$totalF}</td>

<td class="esc">R$ {$freteF}</td>
<td><span class="badge {$badge_status}"><big>{$status}</big></span></td>
<td class="esc ">{$nome_frete}</td>
<td class="esc ">{$codigo_envio}</td>

<td>

    <a href="#" title="Status Envio" onclick="alterarStatus('{$id}', '{$status}', '{$codigo_envio}')" class="btn btn-primary btn-sm "  ><i class="fa fa-edit "></i> </a>

    <a href="#" title="Mensagem" onclick="mensagem('{$id}', '{$produto}', '{$nome_produto}', '{$venda}', '{$loja}')" class="btn btn-secondary btn-sm"  ><i class="fa fa-commenting-o "></i> </a>


</td>

</tr>
HTML;

}

}else{
	echo 'Não possui nenhum cadastro!';
}


echo <<<HTML
</tbody>
<small></small>
</table>
HTML;
?>



<script type="text/javascript">	


function alterarStatus(id, status, rastreio){
    	
    	$('#id_carrinho').val(id);
    	$('#status_carrinho').val(status).change();	
    	$('#rastreio_carrinho').val(rastreio);	
    	$('#modalPedidos2').modal('show');
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
	
</script>