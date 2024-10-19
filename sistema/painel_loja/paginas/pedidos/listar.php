<?php 
require_once("../../verificar.php");
@session_start();
$id_usuario = @$_SESSION['id'];

$tabela = 'carrinho';
require_once("../../../conexao.php");

$dataInicial = @$_POST['p1'];
$dataFinal = @$_POST['p2'];

$data_hoje = date('Y-m-d');
$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$data_ontem = date('Y-m-d', @strtotime("-1 days",@strtotime($data_atual)));
$data_amanha = date('Y-m-d', @strtotime("+1 days",@strtotime($data_atual)));


if($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '07' || $mes_atual == '09'){
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-30';
}else if($mes_atual == '02'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-29';
	}else{
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-28';
	}

}else{
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-31';
}

if($dataInicial == ""){
	$dataInicial = $data_inicio_mes;
}

if($dataFinal == ""){
	$dataFinal = $data_final_mes;
}

$query = $pdo->query("SELECT * from $tabela where data >= '$dataInicial' and data <= '$dataFinal' and loja = '$id_usuario' and pago = 'Sim' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th>Pedido</th>	
	<th class="esc">Produto</th>
	<th>Valor</th>	
	<th>Cliente</th>	
	<th class="esc">Frete</th>
	<th class="esc">Data</th>	
	<th class="esc">Tipo Frete</th>	
	<th class="esc">Status</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$sessao = $res[$i]['sessao'];
	$cliente = $res[$i]['cliente'];
	$valor = $res[$i]['valor'];	
	$total = $res[$i]['total'];
	$frete = $res[$i]['frete'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$quantidade = $res[$i]['quantidade'];
	$venda = $res[$i]['venda'];
	$nome_frete = $res[$i]['nome_frete'];	
	$codigo_envio = $res[$i]['codigo_envio'];	
	$produto = $res[$i]['produto'];	
	$status = $res[$i]['status'];
	$venda = $res[$i]['venda'];
	$loja = $res[$i]['loja'];	

	$dataF = implode('/', array_reverse(@explode('-', $data)));

	$valorF = @number_format($valor, 2, ',', '.');
	$totalF = @number_format($total, 2, ',', '.');
	$freteF = @number_format($frete, 2, ',', '.');	

	$query2 = $pdo->query("SELECT * from produtos where id = '$produto'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas2 = @count($res2);
		if($linhas2 > 0){
			$nome_produto = $res2[0]['nome'];	
			$url_produto = $res2[0]['nome_url'];	
			$foto_produto = $res2[0]['imagem'];	
		}


		$query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas2 = @count($res2);
		if($linhas2 > 0){
			$nome_cliente = $res2[0]['nome'];				
		}else{
			$nome_cliente = '';
		}


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





echo <<<HTML
<tr>
<td>{$venda}</td>
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
		 </td>
<td>R$ {$valorF}</td>
<td>{$nome_cliente}</td>
<td class="esc">R$ {$freteF}</td>
<td class="esc">{$dataF}</td>
<td class="esc ">{$nome_frete}</td>
<td><span class="badge {$badge_status}"><big>{$status}</big></span></td>
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
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
?>



<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>

<script type="text/javascript">	



function alterarStatus(id, status, rastreio){	
    	
    	$('#id_carrinho').val(id);
    	$('#status_carrinho').val(status).change();	
    	$('#rastreio_carrinho').val(rastreio);	
    	$('#modalPedidos').modal('show');
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