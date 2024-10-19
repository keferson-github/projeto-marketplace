<?php 
require_once("verificar.php");
$pag = 'pedidos';

if(@$pedidos == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

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
		<div class="modal-dialog modal-lg" style="max-width: 1000px">
			<div class="modal-content ">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel">Detalhes do Pedido</h4>
					<button id="btn-fechar-dados" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">
					<div id="listar_pedidos" style="overflow-x: scroll; overflow-y: hidden; white-space: nowrap;">						

					</div>
				</div>

			</div>
		</div>
	</div>





<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<script type="text/javascript">
	function listarItens(pedido, sessao){			
				
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


			function buscar(){			
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();
			
			listar(dataInicial, dataFinal)

		}
</script>