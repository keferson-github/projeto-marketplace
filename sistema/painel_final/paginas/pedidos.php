<?php 
require_once("verificar.php");
$pag = 'pedidos';

//consultar pagamento aprovado
$query = $pdo->query("SELECT * from vendas where cliente = '$id_usuario' order by id desc");
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
		<div class="modal-dialog modal-lg" style="max-width:1000px">
			<div class="modal-content ">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel">Detalhes do Pedido</h4>
					<button id="btn-fechar-dados" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">
					<div id="listar_pedidos" style="overflow-x: scroll; overflow-y: hidden; white-space: nowrap; margin-bottom: 50px">						

					</div>
				</div>

				<input type="hidden" id="id_do_pedido">
				<input type="hidden" id="sessao_do_pedido">

			</div>
		</div>
	</div>




	<!-- Modal Avaliar -->
	<div class="modal fade" id="modalAvaliar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header bg-success text-white">
					<h4 class="modal-title" id="tituloPedidos"></h4>
					<button id="btn-fechar-avaliar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form_avaliar">
				<div class="modal-body">
					
					<div class="row">
						<div class="col-md-3">
							<label>Nota</label>
							<select class="form-select" name="nota" id="nota" required="">
								<option value="5">5</option>
								<option value="4">4</option>
								<option value="3">3</option>
								<option value="2">2</option>
								<option value="1">1</option>
							</select>
						</div>	
					</div>

					<div class="row">
						<div class="col-md-12">
							<label>Avaliação</label>
							<input maxlength="255" type="text" name="texto" id="texto" class="form-control" placeholder="O que achou do produto?" required="">
						</div>	

					</div>

					<input type="hidden" name="id_produto" id="id_produto">
					<input type="hidden" name="id_carrinho" id="id_carrinho">
					<input type="hidden" name="id_venda" id="id_venda">

					<div id="mensagem_avaliar" align="center"></div>
					
				</div>

				<div class="modal-footer">       
				<button type="submit" id="btn_salvar_avaliar" class="btn btn-primary">Salvar</button>
			</div>
			</form>
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
							<input maxlength="255" type="text" name="mensagem" id="mensagem_texto" class="form-control" placeholder="Mensagem para o vendedor" required="">
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
	function listarItens(){		

	var pedido = $('#id_do_pedido').val();
	var sessao = $('#sessao_do_pedido').val();

				 $.ajax({
			        url: 'paginas/' + pag + "/listar_itens.php",
			        method: 'POST',
			        data: {pedido, sessao},
			        dataType: "html",

			        success:function(result){
			            $("#listar_pedidos").html(result);
			           
			        }
			    });
			}





$("#form_avaliar").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem_avaliar').text('Salvando...')
    $('#btn_salvar_avaliar').hide();

    $.ajax({
        url: 'paginas/' + pag + "/avaliar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem_avaliar').text('');
            $('#mensagem_avaliar').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-avaliar').click();
                listarItens()

                $('#mensagem_avaliar').text('')          

            } else {

                $('#mensagem_avaliar').addClass('text-danger')
                $('#mensagem_avaliar').text(mensagem)
            }

            $('#btn_salvar_avaliar').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




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