<?php 
require_once("verificar.php");
$pag = 'categorias';

if(@$categorias == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

?>

<div class="justify-content-between">
	<div class="left-content mt-2 mb-3">
		<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar <?php echo ucfirst($pag); ?></a>



		<div class="dropdown" style="display: inline-block;">                      
			<a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
			<div  class="dropdown-menu tx-13">
				<div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
					<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
				</div>
			</div>
		</div>

	</div>

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

<!-- Modal  -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
				<div class="modal-body">


					<div class="row">
						<div class="col-md-12 mb-2">							
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>							
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 mb-2">							
							<label>Descrição</label>
							<input maxlength="255" type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" >							
						</div>

						
					</div>


					<div class="row">
						<div class="col-md-8 mb-2">							
							<label>Imagem</label>
							<input type="file" class="form-control" id="imagem" name="foto" onchange="carregarImg()">							
						</div>

						<div class="col-md-4">								
							<img width="80px" id="target">						
							
						</div>
					</div>


					



					<input type="hidden" class="form-control" id="id" name="id">					

					<br>
					<small><div id="mensagem" align="center"></div></small>
				</div>
				<div class="modal-footer">       
					<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>







<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#imagem").files[0];

		var reader = new FileReader();

		reader.onloadend = function () {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>