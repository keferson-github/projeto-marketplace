<?php 
require_once("verificar.php");
$pag = 'avaliacoes';

if(@$avaliacoes == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
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


<!-- Modal Avaliar -->
	<div class="modal fade" id="modalAvaliar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="tituloPedidos">Editar Avaliação</h4>
					<button id="btn-fechar-avaliar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form_avaliar">
				<div class="modal-body">				
				

					<div class="row">
						<div class="col-md-12">
							<label>Avaliação</label>
							<input maxlength="255" type="text" name="texto" id="texto" class="form-control" placeholder="O que achou do produto?" required="">
						</div>	

					</div>
					
					<input type="hidden" name="id" id="id">

					<div id="mensagem_avaliar" align="center"></div>
					
				</div>

				<div class="modal-footer">       
				<button type="submit" id="btn_salvar_avaliar" class="btn btn-primary">Salvar</button>
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
                listar()

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
</script>