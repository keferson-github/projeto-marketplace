<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
require_once("../../../conexao.php");
$id = $_POST['id'];

if($tipo_loja == 'Marketplace'){
	$sql_filtro = " ";
}else{
	$sql_filtro = " and id_loja = '$id_usuario'";
}


echo '
<select class="sel3" name="subcategoria" id="subcategoria" style="width:100%">';

$query = $pdo->query("SELECT * from subcategorias where categoria = '$id' $sql_filtro order by nome asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
	} } 
	echo '</select>
	';	

	?>


	<script type="text/javascript">
		$(document).ready(function() {
			$('.sel3').select2({
				dropdownParent: $('#modalForm')
			});
			
		});
	</script>