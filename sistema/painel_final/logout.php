<?php 
@session_start();
unset($_SESSION['id_cliente'], $_SESSION['nome_cliente'], $_SESSION['aut_token_225']);
echo '<script>window.location="../../index"</script>';

?>