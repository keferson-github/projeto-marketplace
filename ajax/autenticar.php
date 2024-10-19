<?php 
@session_set_cookie_params(['httponly' => true]);
@session_start();
@session_regenerate_id(true);
require_once("../sistema/conexao.php");



$usuario = filter_var(@$_POST['email'], @FILTER_SANITIZE_STRING);
$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);

$query = $pdo->prepare("SELECT * from clientes_finais where email = :email order by id asc limit 1");
$query->bindValue(":email", "$usuario");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);

if($linhas > 0){

	if(!password_verify($senha, $res[0]['senha'])){
		echo 'Dados Incorretos!';		
		exit();
	}

	
	$_SESSION['nome_cliente'] = $res[0]['nome'];
	$_SESSION['id_cliente'] = $res[0]['id'];
	
	

	$id = $res[0]['id'];

	$_SESSION['aut_token_225'] = 'xss_010225';
	echo 'Logado com Sucesso';
	

	

}else{
	echo 'Dados Incorretos!';		
}


 ?>

