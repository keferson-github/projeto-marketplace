<?php 
require_once("../../verificar.php");
@session_start();
$id_usuario = @$_SESSION['id_cliente'];

$tabela = 'vendas';
require_once("../../../conexao.php");


$query = $pdo->query("SELECT * from $tabela where cliente = '$id_usuario' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th>Pedido</th>	
	<th>Valor</th>	
	<th class="esc">Produtos</th>	
	<th class="esc">Desconto</th>			
	<th class="esc">Frete</th>
	<th class="esc">Data</th>	
	<th class="esc">Pago</th>	
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
	$desconto = $res[$i]['desconto'];
	$frete = $res[$i]['frete'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$ref_api = $res[$i]['ref_api'];
	$forma_pgto = $res[$i]['forma_pgto'];
	$pago = $res[$i]['pago'];	

	$dataF = implode('/', array_reverse(@explode('-', $data)));

	$valorF = @number_format($valor, 2, ',', '.');
	$descontoF = @number_format($desconto, 2, ',', '.');
	$freteF = @number_format($frete, 2, ',', '.');

	$total_produtos = 0;
	//total produtos
	$query2 = $pdo->query("SELECT * from carrinho where sessao = '$sessao'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas2 = @count($res2);
if($linhas2 > 0){
	for($i2=0; $i2<$linhas2; $i2++){
		$quantidade = $res2[$i2]['quantidade'];	
		$total_produtos += $quantidade;
	}
}


if($pago == 'Sim'){
	$classe_pago = 'verde';
	$ocultar = 'ocultar';	
}else{
	$classe_pago = 'text-danger';
	$ocultar = '';	
}	




echo <<<HTML
<tr>
<td>{$id}</td>
<td><i class="fa fa-square {$classe_pago} mr-1"></i> R$ {$valorF}</td>
<td class="esc"><a href="#" title="Ver Detalhamento" onclick="listarProdutos('{$id}', '{$sessao}')">{$total_produtos} Produtos</a></td>
<td class="esc">R$ {$descontoF}</td>
<td class="esc">R$ {$freteF}</td>
<td class="esc">{$dataF}</td>
<td class="esc {$classe_pago}">{$pago}</td>
<td>
	

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm {$ocultar}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

    <a class="btn btn-success btn-sm {$ocultar}" target="_blank" href="../../pagamentos/index.php?id_conta={$id}" ><i class="fa fa-usd "></i> </a>

    <a href="#" title="Ver Detalhamento" onclick="listarProdutos('{$id}', '{$sessao}')" class="btn btn-primary btn-sm "  ><i class="fa fa-info-circle "></i> </a>


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



function listarProdutos(id, sessao){		    	
    	
    	
    	$('#id_do_pedido').val(id);
    	$('#sessao_do_pedido').val(sessao);
    	listarItens();
    	$('#modalPedidos').modal('show');
	}
	

	
</script>