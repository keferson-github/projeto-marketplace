<?php 
require_once("../../../conexao.php");

$id = @$_POST['id']; 
$pag = "produtos_imagens";

$query = $pdo->query("SELECT * FROM produtos_imagens where produto = '$id' ");
echo <<<HTML
<div class='row'>

HTML;
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	$id = $res[$i]['id'];
	$foto = $res[$i]['foto'];
	}
echo <<<HTML
<div class="col-md-3">
	<a href="images/produtos/{$foto}" target="_blank"><img class='ml-4 mb-2' src="images/produtos/{$foto}" width="70px"></a>
		<div class="dropdown" style="display: inline-block;">                      
                        <a class="text-danger" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-close "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirImagem('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
</div>	
HTML;
}


echo <<<HTML
</div>
HTML;
?>







