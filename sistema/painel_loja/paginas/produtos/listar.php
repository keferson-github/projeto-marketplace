<?php 
require_once("../../verificar.php");
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];

$tabela = 'produtos';
require_once("../../../conexao.php");

$cat = @$_POST['p1'];
$sub = @$_POST['p2'];
$estoque = @$_POST['p3'];

if($estoque != ""){
	$sql_estoque = " and estoque < nivel ";
}else{
	$sql_estoque = " ";
}

if($cat != ""){
	$query = $pdo->query("SELECT * from $tabela where loja = '$id_usuario' and categoria = '$cat' $sql_estoque order by id desc");
	if($sub != ""){
		$query = $pdo->query("SELECT * from $tabela where loja = '$id_usuario' and categoria = '$cat' and subcategoria = '$sub' $sql_estoque order by id desc");
	}
}else{
	$query = $pdo->query("SELECT * from $tabela where loja = '$id_usuario' $sql_estoque order by id desc");
}



$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th class="esc">Valor</th>		
	<th class="esc">Estoque</th>	
	<th class="esc">Categoria</th>	
	<th class="esc">SubCategoria</th>	
	<th class="esc">Envio</th>	
	<th class="esc">Vendas</th>	
	<th class="esc">Imagem</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

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
	$carac = $res[$i]['carac'];
	$video = $res[$i]['video'];
	
	
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


	if($valor_promo > 0 and $promocao == 'Sim'){
		$texto_promo = ' / <span style="color:green">'.$valor_promoF.'</span>';
	}else{
		$texto_promo = '';
	}

	$descricao = @str_replace('"', '**', $descricao);
	$carac = @str_replace('"', '**', $carac);

	$nome_envio = $envio;


	if($estoque < $nivel){
		$classe_estoque = 'text-danger';
	}else{
		$classe_estoque = '';
	}
	

echo <<<HTML
<input type="text" id="descricao_temp_{$id}" value="{$descricao}" style="display:none">
<input type="text" id="carac_temp_{$id}" value="{$carac}" style="display:none">
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td style="color:{$classe_ativo}">{$nome}</td>
<td style="color:{$classe_ativo}" class="esc">{$valorF} $texto_promo</td>
<td style="color:{$classe_ativo}" class="{$classe_estoque}">{$estoque}</td>
<td style="color:{$classe_ativo}" class="esc">{$nome_categoria}</td>
<td style="color:{$classe_ativo}" class="esc">{$nome_subcategoria}</td>
<td style="color:{$classe_ativo}" class="esc">{$nome_envio}</td>
<td style="color:{$classe_ativo}" class="esc">{$vendas}</td>
<td style="color:{$classe_ativo}" style="color:{$classe_ativo}" class="esc"><img src="images/produtos/{$imagem}" width="25px"></td>

<td>
	<a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$nome}','{$valor}','{$valor_promo}','{$estoque}','{$nivel}','{$categoria}','{$subcategoria}','{$envio}','{$frete}','{$promocao}','{$imagem}','{$marca}','{$modelo}','{$peso}','{$largura}','{$altura}','{$comprimento}','{$palavras}','{$video}')" title="Editar Dados"><i class="fa fa-edit "></i></a>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

<a class="btn btn-primary btn-sm" href="#" onclick="mostrar('{$id}','{$nome}','{$valorF}','{$valor_promoF}','{$estoque}','{$nivel}','{$nome_categoria}','{$nome_subcategoria}','{$envio}','{$freteF}','{$promocao}','{$imagem}','{$marca}','{$modelo}','{$peso}','{$largura}','{$altura}','{$comprimento}','{$palavras}','{$ativo}','{$vendas}','{$dataF}','{$video}')" title="Mostrar Dados"><i class="fa fa-info-circle "></i></a>


<big><a class="btn btn-success btn-sm" href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} "></i></a></big>

<big><a class="btn btn-info btn-sm" href="#" onclick="imagens('{$id}', '{$nome}')" title="Inserir Imagens"><i class="fa fa-file-image-o "></i></a></big>

<big><a class="btn btn-success btn-sm" href="#" onclick="grades('{$id}', '{$nome}')" title="Inserir Grade"><i class="fa fa-list "></i></a></big>


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
	function editar(id, nome, valor, valor_promo, estoque, nivel, categoria, subcategoria, envio, frete, promocao, imagem, marca, modelo, peso, largura, altura, comprimento, palavras, video){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	var descricao = $('#descricao_temp_'+id).val();

    	for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		var carac = $('#carac_temp_'+id).val();

    	for (let letra of carac){  				
			if (letra === '*'){
				carac = carac.replace('**', '"');
			}			
		}



    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#valor').val(valor);
    	$('#valor_promocional').val(valor_promo);
    	$('#estoque').val(estoque);    	
    	$('#nivel_estoque').val(nivel);
    	$('#video').val(video);
    	$('#imagem').val('');

    	$('#categoria').val(categoria).change();

    	setTimeout(function() {
		  $('#subcategoria').val(subcategoria).change();
		}, 500)
    	
    	$('#tipo_envio').val(envio).change();
    	$('#valor_frete').val(frete);
    	$('#promocao').val(promocao).change();

    	$('#target').attr('src','images/produtos/' + imagem);	

    	$('#marca').val(marca);
    	$('#modelo').val(modelo);
    	$('#peso').val(peso);
    	$('#largura').val(largura);
    	$('#altura').val(altura);	
    	$('#comprimento').val(comprimento);	
    	$('#palavras').val(palavras);	
    	
    	nicEditors.findEditor("area").setContent(descricao);
    	nicEditors.findEditor("carac").setContent(carac);

    	$('#modalForm').modal('show');
	}


	function mostrar(id, nome, valor, valor_promo, estoque, nivel, categoria, subcategoria, envio, frete, promocao, imagem, marca, modelo, peso, largura, altura, comprimento, palavras, ativo, vendas, data, video){

		var descricao = $('#descricao_temp_'+id).val();

		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}


		    	
    	$('#titulo_dados').text(nome);
    	$('#valor_dados').text(valor);
    	$('#valor_promo_dados').text(valor_promo);
    	$('#estoque_dados').text(estoque);
    	$('#nivel_dados').text(nivel);
    	$('#categoria_dados').text(categoria);

    	$('#subcategoria_dados').text(subcategoria);
    	$('#envio_dados').text(envio);
    	$('#frete_dados').text(frete);
    	$('#promocao_dados').text(promocao);
    	$('#marca_dados').text(marca);
    	$('#modelo_dados').text(modelo);

    	$('#peso_dados').text(peso);
    	$('#largura_dados').text(largura);
    	$('#altura_dados').text(altura);
    	$('#comprimento_dados').text(comprimento);
    	$('#palavras_dados').text(palavras);
    	$('#descricao_dados').html(descricao);
    	$('#ativo_dados').text(ativo);
    	$('#vendas_dados').text(vendas);
    	$('#data_dados').text(data);
    	

    	$('#video_dados').attr('href', video);

    	$('#target_dados').attr('src','images/produtos/' + imagem);		
    	
    	$('#modalDados').modal('show');

    	if(video == ""){
    		$('#video_dados').hide();
    	}else{
    		$('#video_dados').show();
    	}
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#valor').val('');
    	$('#valor_promocional').val('');
    	$('#estoque').val('');
    	$('#nivel_estoque').val('');

    	$('#valor_frete').val('');
    	$('#promocao').val('Não').change();
    	$('#imagem').val('');
    	$('#marca').val('');
    	$('#modelo').val('');
    	$('#peso').val('');
    	$('#largura').val('');
    	$('#altura').val('');
    	$('#comprimento').val('');
    	$('#palavras').val('');
    	$('#video').val('');

    	$('#target').attr("src", "images/produtos/sem-foto.png");

    	nicEditors.findEditor("area").setContent('');
    	nicEditors.findEditor("carac").setContent('');

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
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



<script type="text/javascript">
	function imagens(id, nome){	
		    	
    	$('#titulo_imagens').text(nome);    	
    	$('#id-imagens').val(id);   	
    	
    	listarImagens()
    	$('#modalImagens').modal('show');
	}
</script>



<script type="text/javascript">
	function grades(id, nome, cat){

		$('#titulo_nome_grades').text(nome);		
		$('#id_grades').val(id);		
		
		listarGrades(id);
		
		$('#modalGrades').modal('show');
		limparCamposGrades();
	}
</script>