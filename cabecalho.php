<?php 
@session_start();
$id_cliente = @$_SESSION['id_cliente'];

if(@$_SESSION['sessao_carrinho'] == ""){
    $sessao_carrinho = date('Y-m-d-H:i:s-').rand(0, 1500);
    $_SESSION['sessao_carrinho'] = $sessao_carrinho;
}else{
    $sessao_carrinho = $_SESSION['sessao_carrinho'];
}

include("sistema/conexao.php");
$data_atual = date("Y-m-d");


$url = @$_GET['url_loja'];

if($tipo_loja == 'MultiLojas'){

    if(@$url != ""){
        $sessao_url = $url;
        $_SESSION['sessao_url'] = $url;
    }else{
        if(@$_SESSION['sessao_url'] == ""){
            //pegar a primeira loja cadastrada
             $query2 = $pdo->query("SELECT * from clientes where ativo = 'Sim' order by id asc limit 1");
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            $url = @$res2[0]['url'];
            $_SESSION['sessao_url'] = $url;
            
        }
        $sessao_url = $_SESSION['sessao_url'];
    }

    $query2 = $pdo->query("SELECT * from clientes where url = '$sessao_url'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $id_loja = @$res2[0]['id'];



}else{
    $query2 = $pdo->query("SELECT * from clientes where url = '$url'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $id_loja = @$res2[0]['id'];   
}

//verificar se é multi lojas para recuperar o config
$id_img = '';
if($tipo_loja == 'MultiLojas'){
//recuperar as informações de configurações caso seja multilojas
       $query = $pdo->query("SELECT * from config where id_loja = '$id_loja'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $linhas = @count($res);
    if($linhas > 0){
       
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

    $id_img = '_'.$id_loja;

}

$query2 = $pdo->query("SELECT * from usuarios where ref = '$id_loja'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$id_usuario = @$res2[0]['id'];

if($tipo_loja == 'MultiLojas'){
 $sql_produtos = " and loja = '$id_usuario'";
 $sql_cat = " and id_loja = '$id_usuario'";
}else{
 $sql_produtos = " ";
 $sql_cat = " and id_loja is null";
}

$total_carrinho_cabF = 0;
$total_carrinho_cab = 0;
$query = $pdo->query("SELECT * from carrinho where sessao = '$sessao_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_itens_carrinho_cab = @count($res);
if($total_itens_carrinho_cab > 0){
    for($i=0; $i<$total_itens_carrinho_cab; $i++){
        $id = $res[$i]['id'];

        $total_cr = $res[$i]['total'];
        $total_carrinho_cab += $total_cr;

        $valorF = @number_format($valor, 2, ',', '.');
        $totalF = @number_format($total, 2, ',', '.');
        $total_carrinho_cabF = @number_format($total_carrinho_cab, 2, ',', '.');
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<!--  smartaddons.com/templates/html/emarket/product.html -->

<head>

    <!-- Basic page needs
        ============================================ -->
        <?php if(@$nome_produto != ""){
            $titulo_pagina = @$nome_produto;
        }else{
            $titulo_pagina = $nome_sistema;
        } ?>

         <?php if(@$palavras_produto != ""){
            $keywords = @$palavras_produto;            
        }else{
            $keywords = 'Stomp Hair - O maior MarketPlace da Área da Beleza!';
        } ?>

        <?php if(@$imagem_produto != ""){
            $caminho_imagem = $url_sistema.'sistema/painel_loja/images/produtos/'.@$imagem_produto;            
        }else{
            $caminho_imagem = $url_sistema.'sistema/img/logo.png';  
        } ?>


          <meta property="og:description" content="<?php echo $titulo_pagina ?>" />
  <meta property="og:image" content="<?php echo $caminho_imagem ?>">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630"> 

        <title><?php echo $titulo_pagina ?></title>
        <meta charset="utf-8">
        <meta name="keywords"
        content="<?php echo $keywords ?>" />
        <meta name="description"
        content="Marketplace criado por Grupo Web System." />
        <meta name="author" content="Stomp Hair">
        <meta name="robots" content="index, follow" />

    <!-- Mobile specific metas
        ============================================ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon
        ============================================ -->

        <link rel="shortcut icon" type="image/png" href="sistema/img/favicon-16x16.png" />


    <!-- Libs CSS
        ============================================ -->
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="js/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
        <link href="css/themecss/lib.css" rel="stylesheet">
        <link href="js/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="js/minicolors/miniColors.css" rel="stylesheet">

    <!-- Theme CSS
        ============================================ -->
        <link href="css/themecss/so_searchpro.css" rel="stylesheet">
        <link href="css/themecss/so_megamenu.css" rel="stylesheet">
        <link href="css/themecss/so-categories.css" rel="stylesheet">
        <link href="css/themecss/so-listing-tabs.css" rel="stylesheet">
        <link href="css/themecss/so-newletter-popup.css" rel="stylesheet">

        <link href="css/footer/footer1.css" rel="stylesheet">
        <link href="css/header/header1.css" rel="stylesheet">
        <link id="color_scheme" href="css/theme.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

    <!-- Google web fonts
        ============================================ -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700' rel='stylesheet'
        type='text/css'>
        <style type="text/css">
            body {
                font-family: 'Roboto', sans-serif
            }
        </style>

    </head>

    <body class="res layout-subpage layout-1 banners-effect-5">
        <div id="wrapper" class="wrapper-fluid">
            <!-- Header Container  -->
            <header id="header" class=" typeheader-1" >
                <!-- Header Top -->
                <div class="header-top hidden-compact ocultar_web" >
                    <div class="container">
                        <div class="row">
                            <div class="header-top-left col-lg-7 col-md-8 col-sm-6 col-xs-4" >
                                <div class="hidden-sm hidden-xs welcome-msg"> </div>
                                <ul class="top-link list-inline hidden-lg hidden-md" >
                                    <div style="margin-top: 7px" class="logo "><a href="index.php"><img src="sistema/img/foto-painel<?php echo $id_img ?>.png" title="<?php echo $nome_sistema ?>"
                                        alt="<?php echo $nome_sistema ?>" width="250px" /></a></div>
                                    </ul>
                                </div>
                                <div class="header-top-right collapsed-block col-lg-5 col-md-4 col-sm-6 col-xs-8">
                                    <ul class="top-link list-inline lang-curr">

                                        <?php if($id_cliente == ""){ ?>
                                          <li class="currency">
                                            <div class="btn-group ">                                        
                                                <a class="btn btn-link" href="cadastrar">
                                                 <i class="fa fa-user"></i> <span class="">Cadastre-se</span>              
                                             </a>                                          
                                         </div>

                                     </li>
                                 <?php } ?>


                                 <li class="language">
                                    <div class="btn-group languages-block "> 
                                        <?php if($id_cliente == ""){ ?>                                       
                                            <a class="btn btn-link dropdown-toggle" href="login" >
                                                <i class="fa fa-lock"></i> <span class="">Logar</span>              
                                            </a>  
                                        <?php }else{ ?>   
                                           <a title="Acessar seu Painel" class="btn btn-link dropdown-toggle" target="_blank" href="sistema/painel_final" >
                                            <i class="fa fa-sign-in"></i> <span class="">Painel</span>              
                                        </a>  
                                    <?php } ?>                                     
                                </div>

                            </li>

                        </ul>



                    </div>
                </div>
            </div>
        </div>
        <!-- //Header Top -->

        <!-- Header center -->
        <div class="header-middle">
            <div class="container">
                <div class="row " >
                    <!-- Logo -->
                    <div class="navbar-logo col-lg-2 col-md-2 col-sm-12 col-xs-12 ocultar_mobile">
                        <div class="logo "><a href="index.php"><img src="sistema/img/foto-painel<?php echo $id_img ?>.png" title="<?php echo $nome_sistema ?>"
                            alt="<?php echo $nome_sistema ?>" width="150px" /></a></div>
                        </div>
                        <!-- //end Logo -->

                        <!-- Main menu -->
                        <div class="main-menu col-lg-6 col-md-7 margem_100_web" style="z-index: 20000 !important; ">
                            <div class="responsive so-megamenu megamenu-style-dev ">
                                <nav class="navbar-default ">
                                    <div class=" container-megamenu  horizontal open ">
                                        <div class="navbar-header " >
                                            <button type="button" id="show-megamenu" data-toggle="collapse"
                                            class="navbar-toggle" style="position:fixed; top:60px; right:15px">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>

                                    <div class="megamenu-wrapper" >
                                        <span id="remove-megamenu" class="fa fa-times"></span>
                                        <div class="megamenu-pattern">
                                            <div class="container-mega">
                                                <ul class="megamenu" data-transition="slide"
                                                data-animationtime="250">
                                                <li class="">
                                                    <p class="close-menu"></p>
                                                    <a href="index" class="clearfix">
                                                        <strong>Home</strong>

                                                    </a>
                                                </li>

                                                <?php if($tipo_loja != 'MultiLojas'){ ?>
                                                <li class="with-sub-menu hover">
                                                    <p class="close-menu"></p>
                                                    <a href="#" class="clearfix">
                                                        <strong>Lojas</strong>

                                                        <b class="caret"></b>
                                                    </a>
                                                    <div class="sub-menu" style="width: 300px; right: auto;">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="column">
                                                                        <a href="index"
                                                                        class="title-submenu">Lojas Parceiras</a>
                                                                        <div>
                                                                            <ul class="row-list">
                                                                                <?php 
                                                                                $query = $pdo->query("SELECT * from clientes where ativo = 'Sim' order by nome asc");
                                                                                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                                                                $linhas = @count($res);
                                                                                if($linhas > 0){
                                                                                    for($i=0; $i<$linhas; $i++){
                                                                                     ?>
                                                                                     <li><a href="loja-<?php echo $res[$i]['url']; ?>"><?php echo $res[$i]['nome']; ?></a></li>

                                                                                 <?php } }else{ echo 'Nenhuma loja cadastrada!';} ?>

                                                                             </ul>

                                                                         </div>
                                                                     </div>
                                                                 </div>


                                                             </div>
                                                         </div>
                                                     </div>
                                                 </li>
                                             <?php } ?>


                                                 <li class="with-sub-menu hover">
                                                    <p class="close-menu"></p>
                                                    <a href="#" class="clearfix">
                                                        <strong>Categorias</strong>                                                                
                                                        <b class="caret"></b>
                                                    </a>
                                                    <div class="sub-menu" style="width: 300px; right: auto;">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="column">
                                                                        <a href="categorias"
                                                                        class="title-submenu" title="Ver Todas">Categorias dos Produtos</a>
                                                                        <div>
                                                                            <ul class="row-list">
                                                                             <?php 
                                                                             $query = $pdo->query("SELECT * from categorias where ativo = 'Sim' $sql_cat order by nome asc");
                                                                             $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                                                             $linhas = @count($res);
                                                                             if($linhas > 0){
                                                                                for($i=0; $i<$linhas; $i++){
                                                                                 ?>
                                                                                 <li><a href="categoria-<?php echo $res[$i]['url']; ?>-0"><?php echo $res[$i]['nome']; ?></a></li>

                                                                             <?php } }else{ echo 'Nenhuma categoria cadastrada!';} ?>
                                                                         </ul>

                                                                     </div>
                                                                 </div>
                                                             </div>


                                                         </div>
                                                     </div>
                                                 </div>
                                             </li>


                                             <li class="">
                                                <p class="close-menu"></p>
                                                <a href="sistema" class="clearfix">
                                                    <strong>Vender</strong>

                                                </a>

                                            </li>


                                             <li class="">
                                                <p class="close-menu"></p>
                                                <a href="contatos" class="clearfix">
                                                    <strong>Contato</strong>

                                                </a>

                                            </li>


                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- //end Main menu -->

            <div class="middle-right col-lg-4 col-md-3 col-sm-6 col-xs-8">
                <div class="signin-w  hidden-sm hidden-xs">
                    <ul class="signin-link blank">
                        <?php if($id_cliente == ""){ ?>
                            <li class="log login"><i class="fa fa-lock"></i> <a class="link-lg"
                                href="login">Entrar </a> ou <a href="cadastrar">Cadastre-se</a></li>
                            <?php }else{ ?>
                              <li class="log login"><i class="fa fa-sign-in"></i> <a title="Acessar seu painel" target="_blank" class="link-lg"
                                href="sistema/painel_final">Painel</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="telephone hidden-xs hidden-sm hidden-md">
                        <ul class="blank">
                            <li><a href="#"><i class="fa fa-truck"></i>Telefone</a></li>
                            <li><a href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $tel_whats ?>" target="_blank"><i class="fa fa-phone-square"></i><?php echo $telefone_sistema ?></a></li>
                        </ul>
                    </div>


                </div>

            </div>

        </div>
    </div>
    <!-- //Header center -->

    <!-- Header Bottom -->
    <div class="header-bottom hidden-compact " >
        <div class="container" >
            <div class="row" >

                <div class="bottom1 menu-vertical col-lg-2 col-md-3 col-sm-3" style="z-index: 19000 !important;">
                    <div class="responsive so-megamenu megamenu-style-dev ">
                        <div class="so-vertical-menu ">
                            <nav class="navbar-default">

                                <div class="container-megamenu vertical" >
                                    <div id="menuHeading" >
                                        <div class="megamenuToogle-wrapper" >
                                            <div class="megamenuToogle-pattern" >
                                                <div class="container" >
                                                    <div >
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    Categorias
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="navbar-header margem_30_web" >
                                        <button type="button" id="show-verticalmenu" data-toggle="collapse"
                                        class="navbar-toggle">
                                        <i class="fa fa-bars"></i>
                                        <span> Categorias </span>
                                    </button>
                                </div>
                                <div class="vertical-wrapper">
                                    <span id="remove-verticalmenu" class="fa fa-times"></span>
                                    <div class="megamenu-pattern">
                                        <div class="container-mega">
                                            <ul class="megamenu">                                                   

                                               <?php 
                                               $query = $pdo->query("SELECT * from categorias where ativo = 'Sim' $sql_cat order by nome asc");
                                               $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                               $linhas = @count($res);
                                               if($linhas > 0){
                                                for($i=0; $i<$linhas; $i++){
                                                    $id_cat = $res[$i]['id'];
                                                    ?> 


                                                    <li class="item-vertical css-menu with-sub-menu hover">
                                                        <p class="close-menu"></p>
                                                        <a href="categoria-<?php echo $res[$i]['url'] ?>-0" class="clearfix">

                                                            <img src="sistema/painel/images/categorias/<?php echo  $res[$i]['imagem'] ?>"
                                                            alt="icon" width="20px">
                                                            <span><?php echo $res[$i]['nome'] ?></span>
                                                            <b class="caret"></b>
                                                        </a>


                                                        <?php 
                                                        $query2 = $pdo->query("SELECT * from subcategorias where ativo = 'Sim' and categoria = '$id_cat' $sql_cat order by nome asc");
                                                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                                        $linhas2 = @count($res2);
                                                        if($linhas2 > 0){

                                                         ?> 

                                                         <div class="sub-menu" data-subwidth="20">
                                                            <div class="content" style="width:300px">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 hover-menu">
                                                                                <div class="menu">
                                                                                    <ul>
                                                                                        <?php 
                                                                                        for($i2=0; $i2<$linhas2; $i2++){
                                                                                           ?>
                                                                                           <li>
                                                                                            <a href="subcategoria-<?php echo $res2[$i2]['url'] ?>-0"
                                                                                                class="main-menu"><?php echo $res2[$i2]['nome'] ?></a>
                                                                                            </li>
                                                                                        <?php } ?>

                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php  } ?>



                                                </li>


                                            <?php } }else{ echo 'Nenhuma categoria cadastrada!';} ?>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

        </div>

        <!-- Search -->
        <div class="bottom2 col-lg-7 col-md-6 col-sm-6" >
            <div class="search-header-w">


                <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
                    <form method="POST"
                    action="lista_produtos">
                    <div id="search0" class="search input-group form-group">
                        <div class="select_category filter_type  icon-select hidden-sm hidden-xs">
                            <select class="no-border" name="categoria">
                                <option value="0">Filtrar Categoria</option>
                                <?php 
                                $query = $pdo->query("SELECT * from categorias where ativo = 'Sim' $sql_cat order by nome asc");
                                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                $linhas = @count($res);
                                if($linhas > 0){
                                    for($i=0; $i<$linhas; $i++){
                                        $id_cat = $res[$i]['id'];
                                        ?> 
                                        <option value="<?php echo $id_cat ?>"><?php echo $res[$i]['nome'] ?></option>

                                    <?php } } ?>
                                </select>
                            </div>

                            <input class="autosearch-input form-control" type="text" value="" size="50"
                            autocomplete="off" placeholder="Digite o nome do Produto..." name="buscar">
                            <span class="input-group-btn">
                                <button type="submit" class="button-search btn btn-primary"
                                name="submit_search"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <input type="hidden" name="loja" value="<?php echo $id_usuario ?>">
                        <input type="hidden" name="route" value="product/search" />
                    </form>
                </div>
            </div>
        </div>
        <!-- //end Search -->

        <!-- Secondary menu -->
        <div class="bottom3 col-lg-3 col-md-3 col-sm-3 " >


            <!--cart-->
            <div class="shopping_cart margem_30_web" >
                <div id="cart" class="btn-shopping-cart">

                    <a title="Ir para o carrinho" href="carrinho" class="btn-group top_cart dropdown-toggle"
                    >
                    <div class="shopcart">
                        <span class="icon-c">
                            <i class="fa fa-shopping-bag"></i>
                        </span>
                        <div class="shopcart-inner">
                            <p class="text-shopping-cart">

                               Carrinho
                           </p>

                           <span class="total-shopping-cart cart-total-full">
                            <span class="items_cart" id="total_itens_carrinho"><?php echo $total_itens_carrinho_cab ?></span><span class="items_cart2" >
                            item(s)</span><span class="items_carts">  R$ <span id="valor_itens_carrinho"><?php echo $total_carrinho_cabF ?></span></span>
                        </span>
                    </div>
                </div>
            </a>


        </div>

    </div>
    <!--//cart-->


</div>

</div>
</div>



</div>




</header>
<!-- //Header Container  -->


