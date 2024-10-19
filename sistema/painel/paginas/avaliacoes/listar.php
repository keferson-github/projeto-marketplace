<?php 
require_once("../../verificar.php");
@session_start();

$tabela = 'avaliacoes';
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


$query = $pdo->query("SELECT * from $tabela where data >= '$dataInicial' and data <= '$dataFinal' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th>Pedido</th>	
	<th>Cliente</th>
	<th>Loja</th>	
	<th>Produto</th>	
	<th class="esc">Nota</th>	
	<th class="esc">Texto</th>
	<th class="esc">Data</th>	
	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$venda = $res[$i]['venda'];
	$carrinho = $res[$i]['carrinho'];
	$produto = $res[$i]['produto'];	
	$cliente = $res[$i]['cliente'];
	$nota = $res[$i]['nota'];
	$texto = $res[$i]['texto'];
	$hora = $res[$i]['hora'];
	$data = $res[$i]['data'];
	

	$dataF = implode('/', array_reverse(@explode('-', $data)));	


$query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = @$res2[0]['nome'];

$query2 = $pdo->query("SELECT * from produtos where id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = @$res2[0]['nome'];
$loja = @$res2[0]['loja'];

$query2 = $pdo->query("SELECT * from usuarios where id = '$loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_loja = @$res2[0]['nome'];

if($nota <= 3){
	$badge_status = 'bg-danger';
}else{
	$badge_status = 'bg-success';
}

echo <<<HTML
<tr>
<td>{$venda}</td>
<td>{$nome_cliente}</td>
<td>{$nome_loja}</td>
<td>{$nome_produto}</td>
<td><span class="badge {$badge_status}"><big>{$nota}</big></span></td>
<td>{$texto}</td>
<td class="esc">{$dataF}</td>

<td>
	

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>


    <a href="#" title="Ver Detalhamento" onclick="editar('{$id}', '{$texto}')" class="btn btn-primary btn-sm "  ><i class="fa fa-edit "></i> </a>


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



function editar(id, texto){		    	
    	
    	$('#id').val(id);
    	$('#texto').val(texto);
    	$('#modalAvaliar').modal('show');
	}
	

	
</script>