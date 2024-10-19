<?php 
@session_start();
if (@$_SESSION['id_cliente'] == ""){
	echo '<script>window.location="../../login"</script>';
	exit();
}

if (@$_SESSION['aut_token_225'] != "xss_010225"){
	echo '<script>window.location="../../login"</script>';
	exit();
}

 ?>
