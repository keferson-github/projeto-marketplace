<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$tabela = 'pagar';
require_once("../../../conexao.php");
require_once("../../verificar.php");

$mostrar_registros = 'Não';
if($mostrar_registros == 'Não'){	
	$sql_usuario_lanc = " and loja = '$id_usuario '";
}else{	
	$sql_usuario_lanc = " ";
}

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

$total_pago = 0;
$total_pendentes = 0;

$total_pagoF = 0;
$total_pendentesF = 0;

$dataInicial = @$_POST['p2'];
$dataFinal = @$_POST['p3'];
$filtro = @$_POST['p1'];
$tipo_data = @$_POST['p4'];

if($tipo_data == ""){
	$tipo_data = 'vencimento';
}

if($dataInicial == ""){
	$dataInicial = $data_inicio_mes;
}

if($dataFinal == ""){
	$dataFinal = $data_final_mes;
}


$total_valor = 0;
$total_valorF = 0;
$total_total = 0;
$total_totalF = 0;
$total_vencidas = 0;
$total_vencidasF = 0;
$total_hoje = 0;
$total_hojeF = 0;
$total_amanha = 0;
$total_amanhaF = 0;
$total_recebidas = 0;
$total_recebidasF = 0;
$total_pend = 0;
$total_pendF = 0;


//PEGAR O TOTAL DAS CONTAS A PAGAR PENDENTES
$query = $pdo->query("SELECT * from $tabela where pago = 'Não' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_valor += $res[$i]['valor'];
		$total_valorF = @number_format($total_valor, 2, ',', '.');
}}

//PEGAR O TOTAL DAS CONTAS A PAGAR
if($mostrar_registros == 'Não'){
	
	$query = $pdo->query("SELECT * from $tabela where loja = '$id_usuario'");
}else{
	$query = $pdo->query("SELECT * from $tabela");
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_total += $res[$i]['valor'];
		$total_totalF = @number_format($total_total, 2, ',', '.');
}}


//PEGAR O TOTAL DAS CONTAS A PAGAR VENCIDAS
$query = $pdo->query("SELECT * from $tabela where vencimento < curDate() and pago = 'Não' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_vencidas += $res[$i]['valor'];
		$total_vencidasF = @number_format($total_vencidas, 2, ',', '.');
}}


//PEGAR O TOTAL DAS CONTAS A PAGAR PENDENTES
$query = $pdo->query("SELECT * from $tabela where pago = 'Não' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_pend += $res[$i]['valor'];
		$total_pendF = @number_format($total_pend, 2, ',', '.');
}}

//PEGAR O TOTAL DAS CONTAS A PAGAR QUE VENCE HOJE
$query = $pdo->query("SELECT * from $tabela where vencimento = curDate() and pago = 'Não' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_am = @count($res);
if($total_am > 0){
	for($i=0; $i < $total_am; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_hoje += $res[$i]['valor'];
		$total_hojeF = @number_format($total_hoje, 2, ',', '.');
}}


//PEGAR O TOTAL DAS CONTAS A PAGAR RECEBIDAS
$query = $pdo->query("SELECT * from $tabela where pago = 'Sim' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_pg = @count($res);
if($total_pg > 0){
	for($i=0; $i < $total_pg; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_recebidas += $res[$i]['valor'];
		$total_recebidasF = @number_format($total_recebidas, 2, ',', '.');
}}


$data_hoje = date('Y-m-d');
$data_amanha = date('Y/m/d', @strtotime("+1 days",@strtotime($data_hoje)));


//PEGAR O TOTAL DAS CONTAS A PAGAR QUE VENCE AMANHÃ
$query = $pdo->query("SELECT * from $tabela where vencimento = '$data_amanha' and pago = 'Não' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_am = @count($res);
if($total_am > 0){
	for($i=0; $i < $total_am; $i++){
	foreach ($res[$i] as $key => $value){}
		$total_amanha += $res[$i]['valor'];
		$total_amanhaF = @number_format($total_amanha, 2, ',', '.');
}}


if($filtro == 'Vencidas'){
	$query = $pdo->query("SELECT * from $tabela where $tipo_data < curDate() and pago = 'Não' $sql_usuario_lanc order by id desc ");
}else if($filtro == 'Recebidas'){
	$query = $pdo->query("SELECT * from $tabela where pago = 'Sim' $sql_usuario_lanc order by id desc ");
}else if($filtro == 'Pendentes'){
	$query = $pdo->query("SELECT * from $tabela where pago = 'Não' $sql_usuario_lanc order by id desc ");
}else if($filtro == 'Hoje'){
	$query = $pdo->query("SELECT * from $tabela where $tipo_data = curDate() and pago = 'Não' $sql_usuario_lanc order by id desc ");
}else if($filtro == 'Amanha'){
	$query = $pdo->query("SELECT * from $tabela where $tipo_data = '$data_amanha' and pago = 'Não' $sql_usuario_lanc order by id desc ");
}else if($filtro == 'Todas'){
	if($mostrar_registros == 'Não'){
		$query = $pdo->query("SELECT * from $tabela where  loja = '$id_usuario' order by id desc ");
	}else{
		$query = $pdo->query("SELECT * from $tabela order by id desc ");
	}
}else{
	$query = $pdo->query("SELECT * from $tabela WHERE $tipo_data >= '$dataInicial' and vencimento <= '$dataFinal' $sql_usuario_lanc order by id desc ");
}



$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	
	<th>Descrição</th>	
	<th class="">Valor</th>		
	<th class="esc">Vencimento</th>	
	<th class="esc">Data Pgto</th>		
	<th class="esc">Arquivo</th>	
	
	</tr> 
	</thead> 
	<tbody>	
	<small>
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$descricao = $res[$i]['descricao'];
	$fornecedor = $res[$i]['fornecedor'];
	$funcionario = $res[$i]['funcionario'];
	$valor = $res[$i]['valor'];
	$vencimento = $res[$i]['vencimento'];
	$data_pgto = $res[$i]['data_pgto'];
	$data_lanc = $res[$i]['data_lanc'];
	$forma_pgto = $res[$i]['forma_pgto'];
	$frequencia = $res[$i]['frequencia'];
	$obs = $res[$i]['obs'];
	$arquivo = $res[$i]['arquivo'];
	$referencia = $res[$i]['referencia'];
	$id_ref = $res[$i]['id_ref'];
	$multa = $res[$i]['multa'];
	$juros = $res[$i]['juros'];
	$desconto = $res[$i]['desconto'];
	$taxa = $res[$i]['taxa'];
	$subtotal = $res[$i]['subtotal'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$usuario_pgto = $res[$i]['usuario_pgto'];
	$pago = $res[$i]['pago'];
	$loja = $res[$i]['loja'];

	$vencimentoF = implode('/', array_reverse(@explode('-', $vencimento)));
	$data_pgtoF = implode('/', array_reverse(@explode('-', $data_pgto)));
	$data_lancF = implode('/', array_reverse(@explode('-', $data_lanc)));



	$valorF = @number_format($valor, 2, ',', '.');
	$multaF = @number_format($multa, 2, ',', '.');
	$jurosF = @number_format($juros, 2, ',', '.');
	$descontoF = @number_format($desconto, 2, ',', '.');
	$taxaF = @number_format($taxa, 2, ',', '.');
	$subtotalF = @number_format($subtotal, 2, ',', '.');

	if($pago == "Sim"){
		$valor_finalF = @number_format($subtotal, 2, ',', '.');
	}else{
		$valor_finalF = @number_format($valor, 2, ',', '.');
	}



	//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf' || $ext == 'PDF'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip' || $ext == 'RAR' || $ext == 'ZIP'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx' || $ext == 'DOC' || $ext == 'DOCX'){
	$tumb_arquivo = 'word.png';
}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){
	$tumb_arquivo = 'excel.png';
}else if($ext == 'xml'){
	$tumb_arquivo = 'xml.png';
}else{
	$tumb_arquivo = $arquivo;
}
	
	

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_lanc = $res2[0]['nome'];
}else{
	$nome_usu_lanc = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_pgto = $res2[0]['nome'];
}else{
	$nome_usu_pgto = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_frequencia = $res2[0]['frequencia'];
}else{
	$nome_frequencia = 'Sem Registro';
}

$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_pgto = $res2[0]['nome'];
	$taxa_pgto = $res2[0]['taxa'];
}else{
	$nome_pgto = 'Sem Registro';
	$taxa_pgto = 0;
}



if($pago == 'Sim'){
	$classe_pago = 'verde';
	$ocultar = 'ocultar';
	$total_pago += $subtotal;
	$ocultar_pendentes = '';
}else{
	$classe_pago = 'text-danger';
	$ocultar = '';
	$total_pendentes += $valor;
	$ocultar_pendentes = 'ocultar';
}	

$valor_multa = 0;
$valor_juros = 0;
$classe_venc = '';
if(@strtotime($vencimento) < @strtotime($data_hoje)){
	$classe_venc = 'text-danger';
	$valor_multa = $multa_atraso;

	//pegar a quantidade de dias que o pagamento está atrasado
	$dif = @strtotime($data_hoje) - @strtotime($vencimento);
	$dias_vencidos = floor($dif / (60*60*24));

	$valor_juros = ($valor * $juros_atraso / 100) * $dias_vencidos;
}

$total_pendentesF = @number_format($total_pendentes, 2, ',', '.');
$total_pagoF = @number_format($total_pago, 2, ',', '.');

$taxa_conta = $taxa_pgto * $valor / 100;




//PEGAR RESIDUOS DA CONTA
	$total_resid = 0;
	$valor_com_residuos = 0;
	$query2 = $pdo->query("SELECT * FROM $tabela WHERE id_ref = '$id' and residuo = 'Sim'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){

		$descricao = '(Resíduo) - ' .$descricao;

		for($i2=0; $i2 < @count($res2); $i2++){
			foreach ($res2[$i2] as $key => $value){} 
				$id_res = $res2[$i2]['id'];
			$valor_resid = $res2[$i2]['valor'];
			$total_resid += $valor_resid - $res2[$i2]['desconto'];
		}


		$valor_com_residuos = $valor + $total_resid;
	}
	if($valor_com_residuos > 0){
		$vlr_antigo_conta = '('.$valor_com_residuos.')';
		$descricao_link = '';
		$descricao_texto = 'd-none';
	}else{
		$vlr_antigo_conta = '';
		$descricao_link = 'd-none';
		$descricao_texto = '';
	}


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$id_loja = $res2[0]['ref'];

$nome_pessoa = '';
$telefone_pessoa = '';
$pix_pessoa = '';
$tipo_pessoa = 'Pessoa';
if($fornecedor != 0 || $funcionario != 0 || $loja != 0){
	if($fornecedor != 0){
		$tab = 'fornecedores';
		$id_pessoa = $fornecedor;
		$tipo_pessoa = 'Fornecedor';
	}

	if($funcionario != 0){
		$tab = 'usuarios';
		$id_pessoa = $funcionario;
		$tipo_pessoa = 'Funcionário';
	}

	if($loja != 0){
		$tab = 'clientes';
		$id_pessoa = $id_loja;
		$tipo_pessoa = 'Loja';
	}

	//nome pessoa
	$query2 = $pdo->query("SELECT * FROM $tab where id = '$id_pessoa'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$total_reg2 = @count($res2);
	if($total_reg2 > 0){
		$nome_pessoa = $res2[0]['nome'];
		$telefone_pessoa = $res2[0]['telefone'];
		$pix_pessoa = $res2[0]['pix'];

	}else{
		$nome_pessoa = '';
		$telefone_pessoa = '';
		$pix_pessoa = '';
	}

	
}


echo <<<HTML
<tr>

<td><i class="fa fa-square {$classe_pago} mr-1"></i> {$descricao}</td>
<td class="">R$ {$valor_finalF} <small><a href="#" onclick="mostrarResiduos('{$id}')" class="text-danger" title="Ver Resíduos">{$vlr_antigo_conta}</a></small></td>	

<td class="esc {$classe_venc}">{$vencimentoF}</td>
<td class="esc">{$data_pgtoF}</td>
<td class="esc"><a href="images/contas/{$arquivo}" target="_blank"><img src="../painel/images/contas/{$tumb_arquivo}" width="25px"></a></td>

</tr>
HTML;

}


echo <<<HTML
</small>
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>

</table>
</small>
<br>


			<p align="right" style="margin-top: -10px">
				<span style="margin-right: 10px">Total Pendentes  <span style="color:red">R$ {$total_pendentesF} </span></span>
				<span>Total Pago  <span style="color:green">R$ {$total_pagoF} </span></span>
			</p>

HTML;

}else{
	echo 'Nenhum Registro Encontrado!';
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



    $('#total_itens').text('R$ <?=$total_valorF?>');
	    $('#total_total').text('R$ <?=$total_totalF?>');
	    $('#total_vencidas').text('R$ <?=$total_vencidasF?>');
	    $('#total_hoje').text('R$ <?=$total_hojeF?>');
	    $('#total_amanha').text('R$ <?=$total_amanhaF?>');
	    $('#total_recebidas').text('R$ <?=$total_recebidasF?>');
	    $('#total_pendentes').text('R$ <?=$total_pendF?>');
} );
</script>


<script type="text/javascript">
	function editar(id, descricao, valor, fornecedor, funcionario, vencimento, data_pgto, forma_pgto, frequencia, obs, arquivo, loja){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#descricao').val(descricao);
    	$('#valor').val(valor);
    	$('#fornecedor').val(fornecedor).change();
    	$('#funcionario').val(funcionario).change();
    	$('#vencimento').val(vencimento);
    	$('#data_pgto').val(data_pgto);
    	$('#forma_pgto').val(forma_pgto).change();
    	$('#frequencia').val(frequencia).change();
    	$('#loja').val(loja).change();
    	$('#obs').val(obs);

    	$('#arquivo').val('');
    	$('#target').attr('src','images/contas/' + arquivo);		

    	$('#modalForm').modal('show');
	}


	function mostrar(descricao, valor, pessoa, vencimento, data_pgto, nome_pgto, frequencia, obs, arquivo, multa, juros, desconto, taxa, total, usu_lanc, usu_pgto, pago, arq, telefone, pix, tipo_pessoa){

		if(data_pgto == ""){
			data_pgto = 'Pendente';
		}

		if(pessoa == ""){
			pessoa = "Sem Registro";			
			$('#dados_pessoa').hide();
		}else{
			$('#dados_pessoa').show();
		}

		if(telefone == ""){
			telefone = "Sem Registro";
		}

		if(pix == ""){
			pix = "Sem Registro";
		}
		    	
    	$('#titulo_dados').text(descricao);
    	$('#valor_dados').text(valor);
    	$('#cliente_dados').text(pessoa);
    	$('#vencimento_dados').text(vencimento);
    	$('#data_pgto_dados').text(data_pgto);
    	$('#nome_pgto_dados').text(nome_pgto);
    	$('#frequencia_dados').text(frequencia);
    	$('#obs_dados').text(obs);
    	
    	$('#multa_dados').text(multa);
    	$('#juros_dados').text(juros);
    	$('#desconto_dados').text(desconto);    	
    	$('#taxa_dados').text(taxa);
    	$('#total_dados').text(total);
    	$('#usu_lanc_dados').text(usu_lanc);
    	$('#usu_pgto_dados').text(usu_pgto);
    	$('#telefone_dados').text(telefone);
    	$('#pix_dados').text(pix);
    	$('#tipo_pessoa').text(tipo_pessoa);
    	
    	$('#pago_dados').text(pago);
    	$('#target_dados').attr("src", "images/contas/" + arquivo);
    	$('#target_link_dados').attr("href", "images/contas/" + arq);

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#descricao').val('');
    	$('#valor').val('');    	
    	$('#vencimento').val("<?=$data_atual?>");
    	$('#data_pgto').val('');    	
    	$('#obs').val('');
    	$('#arquivo').val('');
    	$('#fornecedor').val(0).change();
    	$('#funcionario').val(0).change();
    	$('#arquivo').val('');

    	$('#target').attr("src", "images/contas/sem-foto.png");

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
    	$('#btn-baixar').hide();	
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
			$('#btn-baixar').hide();
		}else{
			$('#btn-deletar').show();
			$('#btn-baixar').show();
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


	function deletarSelBaixar(){
		var ids = $('#ids').val();
		var id = ids.split("-");

		for(i=0; i<id.length-1; i++){
			var novo_id = id[i];
				$.ajax({
					url: 'paginas/' + pag + "/baixar_multiplas.php",
					method: 'POST',
					data: {novo_id},
					dataType: "html",

					success:function(result){
						//alert(result)
						
					}
				});		
		}

		setTimeout(() => {
		  	buscar();
			limparCampos();
		}, 1000);

		
	}


	function permissoes(id, nome){
		    	
    	$('#id_permissoes').val(id);
    	$('#nome_permissoes').text(nome);    	

    	$('#modalPermissoes').modal('show');
    	listarPermissoes(id);
	}

	
		function parcelar(id, valor, nome){
    $('#id-parcelar').val(id);
    $('#valor-parcelar').val(valor);
    $('#qtd-parcelar').val('');
    $('#nome-parcelar').text(nome);
    $('#nome-input-parcelar').val(nome);
    $('#modalParcelar').modal('show');
    $('#mensagem-parcelar').text('');
}


function baixar(id, valor, descricao, pgto, taxa, multa, juros){
	$('#id-baixar').val(id);
	$('#descricao-baixar').text(descricao);
	$('#valor-baixar').val(valor);
	$('#saida-baixar').val(pgto).change();
	$('#subtotal').val(valor);

	
	$('#valor-juros').val(juros);
	$('#valor-desconto').val('');
	$('#valor-multa').val(multa);
	$('#valor-taxa').val(taxa);

	totalizar()

	$('#modalBaixar').modal('show');
	$('#mensagem-baixar').text('');
}


function mostrarResiduos(id){

	$.ajax({
		url: 'paginas/' + pag + "/listar-residuos.php",
		method: 'POST',
		data: {id},
		dataType: "html",

		success:function(result){
			$("#listar-residuos").html(result);
		}
	});
	$('#modalResiduos').modal('show');
	
	
}

function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    $('#arquivo_conta').val('');
    listarArquivos();   
}
	
</script>