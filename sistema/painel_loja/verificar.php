<?php 
@session_start();
if (@$_SESSION['id'] == ""){
	echo '<script>window.location="../"</script>';
	exit();
}

if (@$_SESSION['aut_token_045'] != "xss_010204"){
	echo '<script>window.location="../"</script>';
	exit();
}

 ?>
