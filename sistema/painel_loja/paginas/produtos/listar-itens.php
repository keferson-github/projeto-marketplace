<?php 
require_once("../../../conexao.php");
$tabela = 'itens_grade';

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where grade = '$id' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

echo <<<HTML
	<small>
	<table class="table table-hover">
	<thead class="bg-primary"> 
	<tr> 
	<th class="cabecalho_tabela">Nome</th>	
	<th class="cabecalho_tabela">Valor Item</th> 	
	<th class="cabecalho_tabela">Limite</th> 		
	<th class="cabecalho_tabela">Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
		$id = $res[$i]['id'];
		$texto = $res[$i]['texto'];		
		$valor = $res[$i]['valor'];	
		$limite = $res[$i]['limite'];	
		$cor = $res[$i]['cor'];		
	$ativo = $res[$i]['ativo'];
	$produto = $res[$i]['produto'];

	$valorF = number_format($valor, 2, ',', '.');

		

		if($ativo == 'Sim'){
			$icone = 'fa-check-square';
			$titulo_link = 'Desativar Item';
			$acao = 'Não';
			$classe_linha = '';
		}else{
			$icone = 'fa-square-o';
			$titulo_link = 'Ativar Item';
			$acao = 'Sim';
			$classe_linha = 'text-muted';
		}

		if($limite == 0){
			$limite = 'ilimitado';
		}

		$square_cor = '';
		if($cor != ""){
			$square_cor = '<i class="fa fa-square " style="color:'.$cor.'"></i>';
		}


		
echo <<<HTML
<tr class="{$classe_linha}">
<td>
{$square_cor}
{$texto}
</td>
<td class="esc">R$ {$valorF}</td>
<td class="esc">{$limite}</td>
<td>
	
	<div class="dropdown" style="display: inline-block;">                      
                        <a class="text-danger" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><big><i class="fa fa-trash "></i></big> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirItens('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>



		<big><a href="#" onclick="ativarItens('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>


		


</td>
</tr>
HTML;

}

echo <<<HTML
	</tbody>
	<small><div align="center" id="mensagem-excluir-itens"></div></small>
	</table>
	</small>
HTML;


}else{
	echo '<small>Não possui nenhuma variação cadastrada!</small>';
}






 ?>

