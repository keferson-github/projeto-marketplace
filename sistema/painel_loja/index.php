<?php 
@session_start();
require_once("../conexao.php");
require_once("verificar.php");


$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_atual)));
$data_amanha = date('Y-m-d', strtotime("+1 days",strtotime($data_atual)));


if($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '09' || $mes_atual == '11'){
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-30';
}else if($mes_atual == '02'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-29';
	}else{
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-28';
	}

}else{
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-31';
}


if($tipo_loja == "MultiLojas"){
$pag_inicial = 'pedidos_loja';
}else{
$pag_inicial = 'pedidos';	
}

if(@$_GET['pagina'] != ""){
	$pagina = @$_GET['pagina'];
}else{
	$pagina = $pag_inicial;
}

$id_usuario = @$_SESSION['id'];
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	$nome_usuario = $res[0]['nome'];
	$email_usuario = $res[0]['email'];	
	$ref_cliente = $res[0]['ref'];	
	$nivel_usuario = $res[0]['nivel'];
	$foto_usuario = $res[0]['foto'];	
	$mostrar_registros = $res[0]['mostrar_registros'];

	$query = $pdo->query("SELECT * from clientes where id = '$ref_cliente'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res);
	if($linhas > 0){
		$telefone_usuario = $res[0]['telefone'];
		$endereco_usuario = $res[0]['endereco'];
		$tipo_pessoa_usuario = $res[0]['tipo_pessoa'];
		$cpf_usuario = $res[0]['cpf'];
		$numero_usuario = $res[0]['numero'];
		$bairro_usuario = $res[0]['bairro'];
		$cidade_usuario = $res[0]['cidade'];
		$estado_usuario = $res[0]['estado'];
		$cep_usuario = $res[0]['cep'];
		$ativo_usuario = $res[0]['ativo'];
		$rg_usuario = $res[0]['rg'];
		$complemento_usuario = $res[0]['complemento'];
		$data_nasc_usuario = $res[0]['data_nasc'];
	}

}else{
	echo '<script>window.location="../"</script>';
	exit();
}

$id_img = '';
if($tipo_loja == 'MultiLojas'){
//recuperar as informações de configurações caso seja multilojas
	//variaveis globais
	$nome_sistema = 'Nome Sistema';
	$email_sistema = 'contato@hugocursos.com.br';
	$telefone_sistema = '(31)97527-5084';

	$query = $pdo->query("SELECT * from config where id_loja = '$ref_cliente'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res);
	if($linhas == 0){
		$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email = '$email_sistema', telefone = '$telefone_sistema', logo = 'logo.png', logo_rel = 'logo.jpg', icone = 'icone.png', ativo = 'Sim', multa_atraso = '0', juros_atraso = '0', marca_dagua = 'Sim', assinatura_recibo = 'Não', impressao_automatica = 'Não', api_whatsapp = '$api_whatsapp', token_whatsapp = '$token_whatsapp', instancia_whatsapp = '$instancia_whatsapp', alterar_acessos = 'Não', comissao_mk = '15', aprovar_produtos = 'Sim', aprovar_loja = 'Sim', cadastro_loja = 'Sim', itens_paginacao = '15', dias_pgto_comissao = '15', dias_excluir_pedidos = '15', id_loja = '$ref_cliente'");
	}else{
	$nome_sistema = $res[0]['nome'];
	$email_sistema = $res[0]['email'];
	$telefone_sistema = $res[0]['telefone'];
	$endereco_sistema = $res[0]['endereco'];
	$instagram_sistema = $res[0]['instagram'];
	$logo_sistema = $res[0]['logo'];
	$logo_rel = $res[0]['logo_rel'];
	$icone_sistema = $res[0]['icone'];
	$ativo_sistema = $res[0]['ativo'];
	$multa_atraso = $res[0]['multa_atraso'];
	$juros_atraso = $res[0]['juros_atraso'];
	$marca_dagua = $res[0]['marca_dagua'];
	$assinatura_recibo = $res[0]['assinatura_recibo'];
	$impressao_automatica = $res[0]['impressao_automatica'];
	$cnpj_sistema = $res[0]['cnpj'];
	$entrar_automatico = $res[0]['entrar_automatico'];
	$mostrar_preloader = $res[0]['mostrar_preloader'];
	$ocultar_mobile = $res[0]['ocultar_mobile'];
	$api_whatsapp = $res[0]['api_whatsapp'];
	$token_whatsapp = $res[0]['token_whatsapp'];
	$instancia_whatsapp = $res[0]['instancia_whatsapp'];
	$alterar_acessos = $res[0]['alterar_acessos'];
	$dados_pagamento = $res[0]['dados_pagamento'];
	$comissao_mk = $res[0]['comissao_mk'];
	$aprovar_produtos = $res[0]['aprovar_produtos'];
	$aprovar_loja = $res[0]['aprovar_loja'];
	$cadastro_loja = $res[0]['cadastro_loja'];
	$itens_paginacao = $res[0]['itens_paginacao'];
	$token_frete = $res[0]['token_frete'];
	$dias_pgto_comissao = $res[0]['dias_pgto_comissao'];
	$dias_excluir_pedidos = $res[0]['dias_excluir_pedidos'];
	$token_mp = $res[0]['token_mp'];
	$public_mp = $res[0]['public_mp'];
	$id_loja = $res[0]['id_loja'];

	$tel_whats = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);

	}

	$id_img = '_'.$ref_cliente;

}

//criar o banner padrao da loja
$query = $pdo->query("SELECT * from banners_lojas where loja = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO banners_lojas SET banner1 = 'sem-foto.png', cliente1 = '0', valor1 = '0', banner_padrao1 = 'sem-foto.png', banner2 = 'sem-foto.png', cliente2 = '0', valor2 = '0', banner_padrao2 = 'sem-foto.png', banner3 = 'sem-foto.png', cliente3 = '0', valor3 = '0', banner_padrao3 = 'sem-foto.png', loja = '$id_usuario'  ");
}

?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
	
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
		

		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Fluxo Comunicação Inteligente">
        <meta name="Author" content="Samuel Lima">
        <meta name="Keywords" content="fluxo, comunicacao, inteligente, marketing, whatsapp"/>

		<title><?php echo $nome_sistema ?></title>

		<link rel="icon" href="../img/icone.png" type="image/x-icon"/>
		<link href="../assets/css/icons.css" rel="stylesheet">
		<link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="../assets/css/style.css" rel="stylesheet">
		<link href="../assets/css/style-dark.css" rel="stylesheet">
		<link href="../assets/css/style-transparent.css" rel="stylesheet">
		<link href="../assets/css/skin-modes.css" rel="stylesheet" />
		<link href="../assets/css/animate.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="../assets/css/custom.css" rel="stylesheet" />
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/modernizr.custom.js"></script>		


		


	</head>

	<body class="ltr main-body app sidebar-mini">

		<?php if($mostrar_preloader == 'Sim'){ ?>
		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="../img/loader.gif" class="loader-img loader loader_mobile" alt="">
		</div>
		<!-- /GLOBAL-LOADER -->
		<?php } ?>

		<!-- Page -->
		<div class="page">

			<div>
				<!-- APP-HEADER1 -->
				<div class="main-header side-header sticky nav nav-item">
						<div class=" main-container container-fluid">
							<div class="main-header-left ">
								<div class="responsive-logo">
									<a href="index.php" class="header-logo">
										<img src="../img/foto-painel<?php echo $id_img ?>.png" class="mobile-logo logo-1" alt="logo" style="width:40% !important; margin-left: -120px !important">
										<img src="../img/foto-painel<?php echo $id_img ?>.png" class="mobile-logo dark-logo-1" alt="logo" style="width:40% !important; margin-left: -120px !important">
									</a>
								</div>
								<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
									<a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
									<a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
								</div>
								<div class="logo-horizontal">
									<a href="index.php" class="header-logo">
										<img src="../img/foto-painel<?php echo $id_img ?>.png" class="mobile-logo logo-1" alt="logo">
										<img src="../img/foto-painel<?php echo $id_img ?>.png" class="mobile-logo dark-logo-1" alt="logo">
									</a>
								</div>
								<div class="main-header-center ms-4 d-sm-none d-md-none d-lg-block form-group">
									
								</div>
							</div>
							<div class="main-header-right">
								
								<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
									<div class="" id="navbarSupportedContent-4">
										<ul class="nav nav-item header-icons navbar-nav-right ms-auto">

											<li class="dropdown nav-item" style="opacity: 0">
												------------
											</li>

											
								
											<li class="dropdown nav-item ocultar_mobile">
												<a class="new nav-link theme-layout nav-link-bg layout-setting" >
													<span class="dark-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/></svg></span>
													<span class="light-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/></svg></span>
												</a>
											</li>


												
											
											
											<li class="nav-item full-screen fullscreen-button">
												<a class="new nav-link full-screen-link" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"/></svg></a>
											</li>
						
											<li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
												<a class="new nav-link profile-user d-flex" href="#" data-bs-toggle="dropdown"><img src="images/perfil/<?php echo $foto_usuario ?>"></a>
												<div class="dropdown-menu">
													<div class="menu-header-content p-3 border-bottom">
														<div class="d-flex wd-100p">
															<div class="main-img-user"><img src="images/perfil/<?php echo $foto_usuario ?>"></div>
															<div class="ms-3 my-auto">
																<h6 class="tx-15 font-weight-semibold mb-0"><?php echo $nome_usuario ?></h6><span class="dropdown-title-text subtext op-6  tx-12"><?php echo $nivel_usuario ?></span>
															</div>
														</div>
													</div>
													<a class="dropdown-item" href="" data-bs-target="#modalPerfil" data-bs-toggle="modal"><i class="fa fa-user"></i>Perfil</a>	

													<?php if($tipo_loja == 'MultiLojas'){ ?>
													<span ><a class="dropdown-item " href="" data-bs-target="#modalConfig" data-bs-toggle="modal"><i class="fa fa-cogs "></i>  Configurações</a>
														</span>
													<?php } ?>
														
													<a class="dropdown-item" href="logout.php"><i class="fa fa-arrow-left"></i> Sair</a>
												</div>
											</li>
										</ul>
									</div>
								</div>
							
							</div>
						</div>
					</div>				<!-- /APP-HEADER -->

				<!--APP-SIDEBAR-->
				<div class="sticky">
					<aside class="app-sidebar">
						<div class="main-sidebar-header active">
							<a class="header-logo active" href="index.php">
								<img src="../img/foto-painel<?php echo $id_img ?>.png" class="main-logo  desktop-logo" alt="logo">
								<img src="../img/foto-painel<?php echo $id_img ?>.png" class="main-logo  desktop-dark" alt="logo">
								<img src="../img/icone.png" class="main-logo  mobile-logo" alt="logo">
								<img src="../img/icone.png" class="main-logo  mobile-dark" alt="logo">
							</a>
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
							<ul class="side-menu">


								<?php if($tipo_loja == "MultiLojas"){ ?>

									<li class="slide">
									<a class="side-menu__item" href="pedidos_loja">
										<i class="fa fa-home text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Pedidos</span></a>
								</li>

								<?php }else{ ?>	
								<li class="slide <?php echo @$pedidos ?>">
									<a class="side-menu__item" href="pedidos">
										<i class="fa fa-home text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Pedidos</span></a>
								</li>
								<?php } ?>

								<?php if($tipo_loja == "MultiLojas"){ ?>

										<li class="slide">
									<a class="side-menu__item" href="categorias">
										<i class="fa fa-product-hunt text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Categorias </span></a>
								</li>

								<li class="slide">
									<a class="side-menu__item" href="subcategorias">
										<i class="fa fa-product-hunt text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">SubCategorias </span></a>
								</li>

									

								<?php } ?>

								
										<li class="slide <?php echo @$produtos ?>">
									<a class="side-menu__item" href="produtos">
										<i class="fa fa-product-hunt text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Produtos </span></a>
								</li>
							
								
									<li class="slide <?php echo @$fornecedores ?>">
									<a class="side-menu__item" href="fornecedores">
										<i class="fa fa-users text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Fornecedores </span></a>
								</li>


										<li class="slide <?php echo @$receber ?>">
									<a class="side-menu__item" href="receber">
										<i class="fa fa-calendar text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Meus Recebimentos</span></a>
								</li>
								


										<li class="slide">
									<a class="side-menu__item" href="banners">
										<i class="fa fa-calendar text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Banners</span></a>
								</li>

									<?php if($tipo_loja == "MultiLojas"){ ?>

									<li class="slide ">
									<a class="side-menu__item" href="cupons">
										<i class="fa fa-product-hunt text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Cupom de Desconto </span></a>
								</li>
						
							<?php } ?>
			
								
							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>				<!--/APP-SIDEBAR-->
			</div>

			<!-- MAIN-CONTENT -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid ">

					<?php 
						//Classe para ocultar mobile
if($ocultar_mobile == 'Sim'){ ?>
	<style type="text/css">
		@media only screen and (max-width: 700px) {
		  .ocultar_mobile_app{
		    display:none; 
		  }
		}
	</style>
<?php } ?>
					

				<?php 
				echo "<script>localStorage.setItem('pagina', '$pagina')</script>";
				require_once('paginas/'.$pagina.'.php');
				?>				


				</div>
				<!-- Container closed -->
			</div>
			<!-- MAIN-CONTENT CLOSED -->

				
			






			<!-- FOOTER -->
			<div class="main-footer">
				<div class="container-fluid pt-0 ht-100p">
					 Copyright 2024 © <?php echo date('Y'); ?> <a href="javascript:void(0);" class="text-primary">Grupo Web System</a>. Todos os direitos reservados
				</div>
			</div>			<!-- FOOTER END -->

		</div>
		<!-- End Page -->

		<!-- BUYNOW-MODAL -->
		       
		
	
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>


		<!-- GRAFICOS -->
		<script src="../assets/plugins/chart.js/Chart.bundle.min.js"></script>		
		<script src="../assets/js/apexcharts.js"></script>

		<!--INTERNAL  INDEX JS -->
		<script src="../assets/js/index.js"></script>
	

	
		<script src="../assets/plugins/jquery/jquery.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/moment/moment.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/p-scroll.js"></script>
		<script src="../assets/js/eva-icons.min.js"></script>
		<script src="../assets/plugins/side-menu/sidemenu.js"></script>
		<script src="../assets/js/sticky.js"></script>
		<script src="../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../assets/plugins/sidebar/sidebar-custom.js"></script>


		<!-- INTERNAL DATA TABLES -->
		<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="../assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>


		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


		<!-- POPOVER JS -->
		<script src="../assets/js/popover.js"></script>

		<script src="../assets/js/themecolor.js"></script>
		<script src="../assets/js/custom.js"></script>		

		<!--INTERNAL  INDEX JS -->
		<script src="../assets/js/index.js"></script>




		
	</body>

</html>


<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header bg-primary text-white">
                            <h4 class="modal-title">Alterar Dados</h4>
                            <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
                        </div>

			<form id="form-perfil">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6 mb-2 col-6">							
							<label>Nome</label>
							<input type="text" class="form-control"  name="nome" placeholder="Seu Nome" required value="<?php echo $nome_usuario ?>">							
						</div>

						<div class="col-md-3 col-6">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone_perfil"  name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>">							
						</div>		

						<div class="col-md-3 mb-2">							
							<label>Nascimento</label>
							<input type="date" class="form-control"  name="data_nasc" placeholder="" value="<?php echo $data_nasc_usuario ?>">							
						</div>

						
					</div>


					<div class="row">

						<div class="col-md-4 mb-2 col-6">							
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa_usuario" class="form-select" onchange="mudarPessoaUsuario()">
								<option <?php if($tipo_pessoa_usuario == 'Física'){ ?> required <?php } ?> value="Física">Física</option>
								<option value="Jurídica" <?php if($tipo_pessoa_usuario == 'Jurídica'){ ?> required <?php } ?>>Jurídica</option>
							</select>							
						</div>		

						<div class="col-md-4 mb-2 col-6">							
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cpf_perfil"  name="cpf" placeholder="CPF/CNPJ" value="<?php echo $cpf_usuario ?>">							
						</div>


						<div class="col-md-4">							
							<label>RG</label>
							<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $rg_usuario ?>">							
						</div>				


						
					</div>


					<div class="row">
						
						<div class="col-md-4">							
							<label>Email</label>
							<input type="email" class="form-control"  name="email" placeholder="Email" required value="<?php echo $email_usuario ?>">							
						</div>

							<div class="col-md-4">							
							<label>Senha</label>
							<input type="password" class="form-control" name="senha" placeholder="Senha" required>							
						</div>

							<div class="col-md-4">							
							<label>Confirmar Senha</label>
							<input type="password" class="form-control"  name="conf_senha" placeholder="Cofirmar Senha" required>							
						</div>
					</div>

					<div class="row">

						<div class="col-md-2 mb-2">							
							<label>CEP</label>
							<input type="text" class="form-control" id="cep_usuario"  name="cep" placeholder="CEP" onblur="pesquisacepUsuario(this.value);" value="<?php echo $cep_usuario ?>">							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Rua</label>
							<input type="text" class="form-control"  id="rua_usuario"  name="endereco" placeholder="Rua" value="<?php echo $endereco_usuario ?>">							
						</div>

						<div class="col-md-2 mb-2">							
							<label>Número</label>
							<input type="text" class="form-control" id="numero_usuario"  name="numero" placeholder="Número" value="<?php echo $numero_usuario ?>">							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento_usuario"  name="complemento" placeholder="Se houver" value="<?php echo $complemento_usuario ?>">							
						</div>



					</div>


					<div class="row">

						<div class="col-md-4 mb-2">							
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro_usuario" name="bairro" placeholder="Bairro"  value="<?php echo $bairro_usuario ?>">							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade_usuario" name="cidade" placeholder="Cidade" value="<?php echo $cidade_usuario ?>">							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Estado</label>
							<select class="form-select" id="estado_usuario" name="estado">
							<option value="">Selecionar</option>
							<option value="AC">Acre</option>
							<option value="AL">Alagoas</option>
							<option value="AP">Amapá</option>
							<option value="AM">Amazonas</option>
							<option value="BA">Bahia</option>
							<option value="CE">Ceará</option>
							<option value="DF">Distrito Federal</option>
							<option value="ES">Espírito Santo</option>
							<option value="GO">Goiás</option>
							<option value="MA">Maranhão</option>
							<option value="MT">Mato Grosso</option>
							<option value="MS">Mato Grosso do Sul</option>
							<option value="MG">Minas Gerais</option>
							<option value="PA">Pará</option>
							<option value="PB">Paraíba</option>
							<option value="PR">Paraná</option>
							<option value="PE">Pernambuco</option>
							<option value="PI">Piauí</option>
							<option value="RJ">Rio de Janeiro</option>
							<option value="RN">Rio Grande do Norte</option>
							<option value="RS">Rio Grande do Sul</option>
							<option value="RO">Rondônia</option>
							<option value="RR">Roraima</option>
							<option value="SC">Santa Catarina</option>
							<option value="SP">São Paulo</option>
							<option value="SE">Sergipe</option>
							<option value="TO">Tocantins</option>
							<option value="EX">Estrangeiro</option>
						</select>												
					</div>

					
				</div>



					<div class="row">
						<div class="col-md-12 mb-2">							
							<label>Chave Pix</label>
							<input type="text" class="form-control" id="pix" name="pix" placeholder="Chave Pix" >							
						</div>
				</div>

					


					<div class="row">
						<div class="col-md-8 mb-3">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo @$foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>

						<div class="col-md-4 mb-3">								
							<img src="images/perfil/<?php echo $foto_usuario ?>"  width="80px" id="target-usu">								
							
						</div>

						
					</div>


									

				<br>
				<small><div id="msg-perfil" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header bg-primary text-white">
                            <h4 class="modal-title">Alterar Configurações</h4>
                            <button id="btn-fechar-config" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
                        </div>
			<form id="form-config">
			<div class="modal-body">
				

					<div class="row mb-3">						

						<div class="col-md-4">							
								<label>Nome da Loja</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome_sistema" placeholder="" value="<?php echo @$nome_sistema ?>" required>							
						</div>

						<div class="col-md-5">							
								<label>Email Loja</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email da Loja" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-3">							
								<label>Telefone Loja</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone da Loja" value="<?php echo @$telefone_sistema ?>" required>							
						</div>



					</div>


					<div class="row mb-3">
						<div class="col-md-6">							
								<label>Endereço <small>(Rua Número Bairro e Cidade)</small></label>
								<input type="text" class="form-control" id="endereco_sistema" name="endereco_sistema" placeholder="Rua X..." value="<?php echo @$endereco_sistema ?>" >							
						</div>

						<div class="col-md-6">							
								<label>Instagram</label>
								<input type="text" class="form-control" id="instagram_sistema" name="instagram_sistema" placeholder="Link do Instagram" value="<?php echo @$instagram_sistema ?>">							
						</div>
					</div>

			

					<div class="row mb-3">

							<div class="col-md-3">							
								<label>
									<div class="icones_mobile" class="dropdown" style="display: inline-block; ">                      
                        <a title="Clique para ver as opções das apis" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-info-circle text-primary"></i> </a>
                        <div  class="dropdown-menu tx-13" style="width:500px">
                        <div class="dropdown-item-text botao_excluir" style="width:500px">
                        <p>Integrei ao projeto 3 serviços de apis, estes serviços sáo terceirizados e tem custo adicional para utilização, segue abaixo site e contato dos 3. <br><br>

                        <b>1 - (Menuia)</b> Diego (81)98976-9960 <br>
                        <a href="https://chatbot.menuia.com/" target="_blank">https://chatbot.menuia.com/ </a> 
                        <br><br>

                         <b>2 - (WordMensagens)</b> Bruno (44) 99986-3238 <br>
                        <a href="http://wordmensagens.com.br/sistema/index.php" target="_blank">http://wordmensagens.com.br/sistema/index.php </a>
                        <br><br>

                         <b>3 - (NewTek)</b> Nando Silva (21) 99998-8666 <br>
                        <a href="https://webapp.newteksoft.com.br/" target="_blank">https://webapp.newteksoft.com.br/ </a>
                        <br><br>

                        </p>
                        
                        </div>
                        </div>
                        </div>

									Api Whatsapp <a href="#" onclick="testarApi()" title="Testar disparo Api"><i class="fa fa-whatsapp text-verde"></i></a></label>
								<select name="api_whatsapp" id="api_whatsapp" class="form-select">
									<option value="Não" <?php if($api_whatsapp == 'Não'){ ?> selected <?php } ?>>Não</option>
									<option value="menuia" <?php if($api_whatsapp == 'menuia'){ ?> selected <?php } ?>>Menuia</option>
									<option value="wm" <?php if($api_whatsapp == 'wm'){ ?> selected <?php } ?>>WordMensagens</option>
									<option value="newtek" <?php if($api_whatsapp == 'newtek'){ ?> selected <?php } ?>>NewTek</option>


								</select>						
						</div>


						<div class="col-md-4">							
								<label>Token Whatsapp (appkey)</label>
								<input type="text" class="form-control" id="token_whatsapp" name="token_whatsapp" placeholder="Token ou App Key" value="<?php echo @$token_whatsapp ?>">							
						</div>


						<div class="col-md-5">							
								<label>Instância Whatsapp (authKey)</label>
								<input type="text" class="form-control" id="instancia_whatsapp" name="instancia_whatsapp" placeholder="Instância ou authKey" value="<?php echo @$instancia_whatsapp ?>">							
						</div>


					</div>

						

						<div class="row mb-3">
							<div class="col-md-6">							
								<label>Access Token Mercado Pago</label>
								<input type="text" class="form-control" id="token_mp" name="token_mp"  value="<?php echo @$token_mp ?>">			
						</div>

						<div class="col-md-6">							
								<label>Public Key Mercado Pago</label>
								<input type="text" class="form-control" id="public_mp" name="public_mp"  value="<?php echo @$public_mp ?>">			
						</div>

						

					</div>

					

					<div class="row mb-3">
						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo (*PNG)</label> 
									<input class="form-control" type="file" name="foto-logo" onChange="carregarImgLogo();" id="foto-logo">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/logo<?php echo $id_img ?>.png"  width="80px" id="target-logo">									
								</div>
							</div>


							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo Painél (Clara)(*PNG)</label> 
									<input class="form-control" type="file" name="foto-painel" onChange="carregarImgPainel();" id="foto-painel">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/foto-painel<?php echo $id_img ?>.png"  width="80px" id="target-painel">									
								</div>
							</div>



						
					</div>







					<input type="hidden" name="id" value="<?php echo $ref_cliente ?>">
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>









	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 





<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
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
	$("#form-perfil").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-perfil').text('');
				$('#msg-perfil').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-perfil').click();
					location.reload();				
						

				} else {

					$('#msg-perfil').addClass('text-danger')
					$('#msg-perfil').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>







<script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua_usuario').value=("");
            document.getElementById('bairro_usuario').value=("");
            document.getElementById('cidade_usuario').value=("");
            document.getElementById('estado_usuario').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua_usuario').value=(conteudo.logradouro);
            document.getElementById('bairro_usuario').value=(conteudo.bairro);
            document.getElementById('cidade_usuario').value=(conteudo.localidade);
            document.getElementById('estado_usuario').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacepUsuario(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua_usuario').value="...";
                document.getElementById('bairro_usuario').value="...";
                document.getElementById('cidade_usuario').value="...";
                document.getElementById('estado_usuario').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>




<script type="text/javascript">
	function mudarPessoaUsuario(){
		var pessoa = $('#tipo_pessoa_usuario').val();
		if(pessoa == 'Física'){
			$('#cpf_perfil').mask('000.000.000-00');
			$('#cpf_perfil').attr("placeholder", "Insira CPF");
		}else{
			$('#cpf_perfil').mask('00.000.000/0000-00');
			$('#cpf_perfil').attr("placeholder", "Insira CNPJ");
		}
	}
</script>




 <script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-config').click();
					location.reload();				
						

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>



<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
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
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
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
	function carregarImgPainel() {
    var target = document.getElementById('target-painel');
    var file = document.querySelector("#foto-painel").files[0];
    
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
	function testarApi(){
		var seletor_api = $('#api_whatsapp').val();
		var token = $('#token_whatsapp').val();
		var instancia = $('#instancia_whatsapp').val();
		var telefone_sistema = $('#telefone_sistema').val();

		$.ajax({
	        url: 'apis/teste_whatsapp.php',
	        method: 'POST',
	        data: {seletor_api, token, instancia, telefone_sistema},
	        dataType: "html",

	        success:function(result){
	            alert(result)
	        }
    	});
	}
</script>