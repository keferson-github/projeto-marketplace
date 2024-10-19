<?php 
require_once("verificar.php");
$pag = 'banners';

if(@$banners == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

//recuperar os dados dos banners
$query = $pdo->query("SELECT * from banners order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);

$id = @$res[0]['id'];
$banner1 = @$res[0]['banner1'];
$cliente1 = @$res[0]['cliente1'];
$valor1 = @$res[0]['valor1'];
$link1 = @$res[0]['link1'];
$validade1 = @$res[0]['validade1'];
$banner_padrao1 = @$res[0]['banner_padrao1'];

$banner2 = @$res[0]['banner2'];
$cliente2 = @$res[0]['cliente2'];
$valor2 = @$res[0]['valor2'];
$link2 = @$res[0]['link2'];
$validade2 = @$res[0]['validade2'];
$banner_padrao2 = @$res[0]['banner_padrao2'];

$banner3 = @$res[0]['banner3'];
$cliente3 = @$res[0]['cliente3'];
$valor3 = @$res[0]['valor3'];
$link3 = @$res[0]['link3'];
$validade3 = @$res[0]['validade3'];
$banner_padrao3 = @$res[0]['banner_padrao3'];

$obs1 = @$res[0]['obs1'];
$obs2 = @$res[0]['obs2'];
$obs3 = @$res[0]['obs3'];

?>

<div class="justify-content-between">
	<div class="left-content mt-4 mb-3">

		<form id="form">
			<div class="">

				<div class="row">
					<div class="col-md-3 mb-2">							
						<label>Banner1 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner1" name="banner1" onchange="carregarImgBanner1()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner1" src="images/banners/<?php echo $banner1 ?>">	
					</div>

					<div class="col-md-3">							
						<label>Cliente</label>
						<select name="cliente1" id="cliente1" class="sel2" style="width:100%; height:35px; ">
							<option value="0">Selecione um Cliente</option>
							<?php							
							$query = $pdo->query("SELECT * from clientes order by id asc");							
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$linhas = @count($res);
							if($linhas > 0){
								for($i=0; $i<$linhas; $i++){
									$selected = '';
									if($res[$i]['id'] == $cliente1){
										$selected = 'selected';
									}
									echo '<option value="'.$res[$i]['id'].'"'.$selected.'>'.$res[$i]['nome'].'</option>';
								}
							}
							?>	
						</select>								
					</div>



					<div class="col-md-5 mb-2">							
						<label>Link</label>
						<input type="text" class="form-control" id="link1" name="link1" placeholder="Link se houver" value="<?php echo $link1 ?>">							
					</div>

					




				</div>


				<div class="row" style="border-bottom: 1px solid #595959; padding-bottom: 15px">

					<div class="col-md-3 mb-2">							
						<label>Banner Padrão 1 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner_padrao1" name="banner_padrao1" onchange="carregarImgBannerPadrao1()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner_padrao1" src="images/banners/<?php echo $banner_padrao1 ?>">	
					</div>

					<div class="col-md-2 mb-2">							
						<label>Valor</label>
						<input type="text" class="form-control" id="valor1" name="valor1" placeholder="Valor" value="<?php echo $valor1 ?>">							
					</div>


					<div class="col-md-2 mb-2">							
						<label>Validade</label>
						<input type="date" class="form-control" id="validade1" name="validade1" value="<?php echo $validade1 ?>" >							
					</div>	


					<div class="col-md-4 mb-2">							
						<label>Observação</label>
						<input type="text" class="form-control" id="obs1" name="obs1" placeholder="" value="<?php echo $obs1 ?>">							
					</div>


				</div>









				<div class="row" style="margin-top: 25px">
					<div class="col-md-3 mb-2">							
						<label>Banner2 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner2" name="banner2" onchange="carregarImgBanner2()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner2" src="images/banners/<?php echo $banner2 ?>">	
					</div>

					<div class="col-md-3">							
						<label>Cliente</label>
						<select name="cliente2" id="cliente2" class="sel2" style="width:100%; height:35px; ">
							<option value="0">Selecione um Cliente</option>
							<?php							
							$query = $pdo->query("SELECT * from clientes order by id asc");							
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$linhas = @count($res);
							if($linhas > 0){
								for($i=0; $i<$linhas; $i++){
									$selected = '';
									if($res[$i]['id'] == $cliente2){
										$selected = 'selected';
									}
									echo '<option value="'.$res[$i]['id'].'"'.$selected.'>'.$res[$i]['nome'].'</option>';
								}
							}
							?>	
						</select>								
					</div>



					<div class="col-md-5 mb-2">							
						<label>Link</label>
						<input type="text" class="form-control" id="link2" name="link2" placeholder="Link se houver" value="<?php echo $link2 ?>">							
					</div>


					



				</div>


				<div class="row" style="border-bottom: 1px solid #595959; padding-bottom: 15px">

					<div class="col-md-3 mb-2">							
						<label>Banner Padrão 2 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner_padrao2" name="banner_padrao2" onchange="carregarImgBannerPadrao2()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner_padrao2" src="images/banners/<?php echo $banner_padrao2 ?>">	
					</div>

					<div class="col-md-2 mb-2">							
						<label>Valor</label>
						<input type="text" class="form-control" id="valor2" name="valor2" placeholder="Valor" value="<?php echo $valor2 ?>">							
					</div>


					<div class="col-md-2 mb-2">							
						<label>Validade</label>
						<input type="date" class="form-control" id="validade2" name="validade2" value="<?php echo $validade2 ?>" >							
					</div>	

						<div class="col-md-4 mb-2">							
						<label>Observação</label>
						<input type="text" class="form-control" id="obs2" name="obs2" placeholder="" value="<?php echo $obs2 ?>">							
					</div>


				</div>





					<div class="row" style="margin-top: 25px">
					<div class="col-md-3 mb-2">							
						<label>Banner3 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner3" name="banner3" onchange="carregarImgBanner3()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner3" src="images/banners/<?php echo $banner3 ?>">	
					</div>

					<div class="col-md-3">							
						<label>Cliente</label>
						<select name="cliente3" id="cliente3" class="sel2" style="width:100%; height:35px; ">
							<option value="0">Selecione um Cliente</option>
							<?php							
							$query = $pdo->query("SELECT * from clientes order by id asc");							
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$linhas = @count($res);
							if($linhas > 0){
								for($i=0; $i<$linhas; $i++){
									$selected = '';
									if($res[$i]['id'] == $cliente3){
										$selected = 'selected';
									}
									echo '<option value="'.$res[$i]['id'].'"'.$selected.'>'.$res[$i]['nome'].'</option>';
								}
							}
							?>	
						</select>								
					</div>



					<div class="col-md-5 mb-2">							
						<label>Link</label>
						<input type="text" class="form-control" id="link3" name="link3" placeholder="Link se houver" value="<?php echo $link2 ?>">							
					</div>

				





				</div>


				<div class="row" style="border-bottom: 1px solid #595959; padding-bottom: 15px">

					<div class="col-md-3 mb-2">							
						<label>Banner Padrão 3 (950px x 450px)</label>
						<input type="file" class="form-control" id="banner_padrao3" name="banner_padrao3" onchange="carregarImgBannerPadrao3()">							
					</div>

					<div class="col-md-1">								
						<img width="80px" id="target_banner_padrao3" src="images/banners/<?php echo $banner_padrao3 ?>">	
					</div>

					<div class="col-md-2 mb-2">							
						<label>Valor</label>
						<input type="text" class="form-control" id="valor3" name="valor3" placeholder="Valor" value="<?php echo $valor3 ?>">							
					</div>


					<div class="col-md-2 mb-2">							
						<label>Validade</label>
						<input type="date" class="form-control" id="validade3" name="validade3" value="<?php echo $validade3 ?>" >							
					</div>	

						<div class="col-md-4 mb-2">							
						<label>Observação</label>
						<input type="text" class="form-control" id="obs3" name="obs3" placeholder="" value="<?php echo $obs3 ?>">							
					</div>

				</div>







				<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>
			</div>
		</form>

	</div>

</div>




<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({

		});

	});
</script>


<script type="text/javascript">
	function carregarImgBanner1() {
		var target = document.getElementById('target_banner1');
		var file = document.querySelector("#banner1").files[0];

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


<script type="text/javascript">
	function carregarImgBanner2() {
		var target = document.getElementById('target_banner2');
		var file = document.querySelector("#banner2").files[0];

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


<script type="text/javascript">
	function carregarImgBanner3() {
		var target = document.getElementById('target_banner3');
		var file = document.querySelector("#banner3").files[0];

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



<script type="text/javascript">
	function carregarImgBannerPadrao1() {
		var target = document.getElementById('target_banner_padrao1');
		var file = document.querySelector("#banner_padrao1").files[0];

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





<script type="text/javascript">
	function carregarImgBannerPadrao2() {
		var target = document.getElementById('target_banner_padrao2');
		var file = document.querySelector("#banner_padrao2").files[0];

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




<script type="text/javascript">
	function carregarImgBannerPadrao3() {
		var target = document.getElementById('target_banner_padrao3');
		var file = document.querySelector("#banner_padrao3").files[0];

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