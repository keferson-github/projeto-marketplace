<?php 
require_once("verificar.php");
$pag = 'receber';

if(@$receber == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

?>

<div class="justify-content-between">
	<form action="rel/receber_class.php" target="_blank" method="POST">
 	<div class="left-content mt-2 mb-3">



         <div class="cab_mobile"></div>               

         <div style="display: inline-block; margin-bottom: 10px">
			<input type="date" name="dataInicial" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo $data_inicio_mes ?>" onchange="buscar()">

			<input type="date" name="dataFinal" id="dataFinal" style="height:35px; width:49%; font-size: 13px" value="<?php echo $data_final_mes ?>" onchange="buscar()">	
		</div>	
		


		</div>	


		<div class="card-group" style="margin-bottom: -30px">
	
	<div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
		<a class="text-white" href="#" onclick="$('#tipo_data_filtro').val('Vencidas'); $('#pago').val('Vencidas'); buscar(); ">
			<div class="card-header bg-red border-light">
	             Vencidas
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span class="text-danger" id="total_vencidas">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>
    


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Hoje'); $('#pago').val(''); buscar(); ">
			<div class="card-header bg-orange border-light text-white">
	            Vence Hoje
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #f05800" id="total_hoje">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Amanha'); $('#pago').val(''); buscar(); ">
			<div class="card-header border-light text-white" style="background: gray">
	            Vence Amanhã
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: gray" id="total_amanha">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>

    


     <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick=" $('#tipo_data_filtro').val('Recebidas'); $('#pago').val('Sim'); buscar();">
			<div class="card-header border-light text-white" style="background: #2b7a00">
	            Recebidas
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #2b7a00" id="total_recebidas">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick=" $('#tipo_data_filtro').val('Pendentes'); $('#pago').val(''); buscar();">
			<div class="card-header border-light text-white" style="background: #6f0917 ">
	            Pendentes
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #6f0917 " id="total_pendentes">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


      <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Todas'); $('#pago').val(''); buscar();">
			<div class="card-header border-light text-white" style="background: #1f1f1f;">
	            Total
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #1f1f1f" class="verde" id="total_total">R$ 0,0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


</div>

		
		<input type="hidden" name="tipo_data" id="tipo_data">
		<input type="hidden" name="pago" id="pago">
		<input type="hidden" name="tipo_data_filtro" id="tipo_data_filtro">
		
		</form>
		
	</div>	



<div class="row row-sm">
<div class="col-lg-12">
<div class="card custom-card">
<div class="card-body" id="listar">

</div>
</div>
</div>
</div>


	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>


	



	<script type="text/javascript">
		function buscar(){
			var filtro = $('#tipo_data_filtro').val();
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();
			var tipo_data = $('#tipo_data').val();
			listar(filtro, dataInicial, dataFinal, tipo_data)

		}


		function tipoData(tipo){
			$('#tipo_data').val(tipo);
			buscar();
		}

		
		
	</script>

