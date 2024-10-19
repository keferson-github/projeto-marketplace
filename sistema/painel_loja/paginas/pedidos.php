<?php 
require_once("verificar.php");
$pag = 'pedidos';

//consultar pagamento aprovado
$query = $pdo->query("SELECT * from vendas where pago != 'Sim' and ref_api is not null order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){	
		$ref_api = $res[$i]['ref_api'];
		$pago = $res[$i]['pago'];
		if($ref_api != "" and $pago == 'Não'){
	     	require('../../pagamentos/consultar_pagamento.php');     
		}	
	}
}

 ?>

     <div style="display: inline-block; margin-bottom: 10px; margin-top: 10px">
			<input type="date" name="dataInicial" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo $data_inicio_mes ?>" onchange="buscar()">

			<input type="date" name="dataFinal" id="dataFinal" style="height:35px; width:49%; font-size: 13px" value="<?php echo $data_final_mes ?>" onchange="buscar()">	
		</div>	

<div class="row row-sm">
<div class="col-lg-12">
<div class="card custom-card">
<div class="card-body" id="listar">

</div>
</div>
</div>
</div>

<input type="hidden" id="ids">


	<!-- Modal Pedidos -->
	<div class="modal fade" id="modalPedidos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content ">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel">Status do Pedido</h4>
					<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">

					<form id="form">
					
					<div class="row">
						<div class="col-md-4 mb-2">							
							<label>Status</label>
							<select  class="form-select" id="status_carrinho" name="status" >	
								<option value="Aguardando Envio">Aguardando Envio</option>
								<option value="Enviado">Enviado</option>
								<option value="Entregue">Entregue</option>
								<option value="Aguardando Estoque">Aguardando Estoque</option>
							</select>						
						</div>

					<div class="col-md-5 mb-2">							
						<label>Rastreio</label>
						<input type="text" class="form-control" id="rastreio_carrinho" name="rastreio" placeholder="Código se Houver" >							
					</div>

					<div class="col-md-3 mb-2" style="margin-top:24px ">							
						
						<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>						
					</div>
	
					</div>
					<input type="hidden" id="id_carrinho" name="id">
					


					</form>

					<div align="center" id="mensagem"></div>
				</div>

			</div>
		</div>
	</div>





	<!-- Modal Mensagem -->
	<div class="modal fade" id="modalMensagem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content ">
				<div class="modal-header text-white" style="background: #0a32a3">
					<h4 class="modal-title" id="tituloMensagem"></h4>
					<button id="btn-fechar-mensagem" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form_mensagem">
				<div class="modal-body">
					
				
					<div class="row">
						<div class="col-md-10">
							<label>Mensagem</label>
							<input maxlength="255" type="text" name="mensagem" id="mensagem_texto" class="form-control" placeholder="Mensagem para o cliente" required="">
						</div>	

						<div class="col-md-2" style="margin-top: 24px">       
				<button type="submit" id="btn_salvar_mensagem" class="btn btn-primary">Salvar</button>
			</div>

					</div>

					<input type="hidden" name="id_produto" id="id_produto_mensagem">
					<input type="hidden" name="id_carrinho" id="id_carrinho_mensagem">
					<input type="hidden" name="id_venda" id="id_venda_mensagem">
					<input type="hidden" name="id_loja" id="id_loja_mensagem">

					<div id="mensagem_mensagem" align="center"></div>

					<hr>
					<div id="listar_mensagens">
						
					</div>
					
				</div>

				
			</form>
			</div>
		</div>
	</div>




<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<script type="text/javascript">

			function buscar(){	
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();		
			listar(dataInicial, dataFinal)
		}




$("#form_mensagem").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem_mensagem').text('Salvando...')
    $('#btn_salvar_mensagem').hide();

    $.ajax({
        url: 'paginas/' + pag + "/mensagem.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem_mensagem').text('');
            $('#mensagem_mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {
              
                listarMensagens();

                $('#mensagem_mensagem').text('') 
                $('#mensagem_texto').val('')          

            } else {

                $('#mensagem_mensagem').addClass('text-danger')
                $('#mensagem_mensagem').text(mensagem)
            }

            $('#btn_salvar_mensagem').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


function listarMensagens(){
	var id_carrinho = $('#id_carrinho_mensagem').val();

	 $.ajax({
			        url: 'paginas/' + pag + "/listar_mensagens.php",
			        method: 'POST',
			        data: {id_carrinho},
			        dataType: "html",

			        success:function(result){
			            $("#listar_mensagens").html(result);
			           
			        }
			    });

}
</script>