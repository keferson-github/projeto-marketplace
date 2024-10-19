<?php 
$tabela = 'cupons';
require_once("../../verificar.php");
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela where id_loja is null order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Código</th>	
	<th>Valor</th>	
	<th>Data</th>	
	<th>Quantidade</th>	
		<th>Valor Mínimo</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
		$codigo = $res[$i]['codigo'];
		$valor = $res[$i]['valor'];
		$data = $res[$i]['data'];
		$quantidade = $res[$i]['quantidade'];
		$valor_minimo = $res[$i]['valor_minimo'];
		$tipo = $res[$i]['tipo'];

		$dataF = implode('/', array_reverse(explode('-', $data)));
		$valorF = number_format($valor, 2, ',', '.');
		$valor_minimoF = number_format($valor_minimo, 2, ',', '.');
		$valor_p = number_format($valor, 0, ',', '.');

		if($tipo == '%'){
			$nome_tipo = $valor_p.' %';			
		}else{
			$nome_tipo = 'R$ '.$valorF;
		}

		
echo <<<HTML
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>{$codigo}</td>
<td>{$nome_tipo}</td>
<td>{$dataF}</td>
<td>{$quantidade}</td>
<td>{$valor_minimoF}</td>

<td>
	<big><a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$codigo}','{$valor}','{$data}','{$quantidade}','{$valor_minimo}','{$tipo}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash"></i> </a>
                        <div  class="dropdown-menu tx-13">
                       <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
</td>
</tr>
HTML;

}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}

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
	function editar(id, codigo, valor, data, quantidade, valor_minimo, tipo){
		$('#id').val(id);
		$('#codigo').val(codigo);
		$('#valor').val(valor);
		$('#data_validade').val(data);
		$('#quantidade').val(quantidade);
		$('#valor_minimo').val(valor_minimo);
		$('#tipo').val(tipo).change();
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}






	function limparCampos(){
		$('#id').val('');
		$('#codigo').val('');	
		$('#valor').val('');
		$('#data_validade').val('');
		$('#quantidade').val('1');	
		$('#valor_minimo').val('');	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluirMultiplos(id[i]);			
		}

		setTimeout(() => {
		  	listar();	
		}, 1000);

		limparCampos();
	}
</script>