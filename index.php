<?php include("cabecalho.php");



 ?>


<!-- Main Container  -->
<div class="main-container container" style="margin-top: 20px">
    <div id="content">


      <!-- BANNER MOBILE  -->
      <div class="box-top hidden-lg hidden-md hidden-sm ">
        <div class="module sohomepage-slider ">
            <div class="" data-rtl="yes" data-autoplay="no" data-autoheight="no"
            data-delay="4" data-speed="0.6" data-margin="0" data-items_column0="1"
            data-items_column1="1" data-items_column2="1" data-items_column3="1" data-items_column4="1"
            data-arrows="no" data-pagination="yes" data-lazyload="yes" data-loop="no"
            data-hoverpause="yes">
            <div class="yt-content-slide">
              <?php 
              if($tipo_loja == "Marketplace"){
                $caminho = 'painel';
                $query = $pdo->query("SELECT * from banners");
            }else{
                $caminho = 'painel_loja';
              $query = $pdo->query("SELECT * from banners_lojas where loja = '$id_usuario'");
            }
              
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $linhas = @count($res);
              if($linhas > 0){                
                $banner1 = $res[0]['banner1'];
                $link1 = $res[0]['link1'];
                $validade1 = $res[0]['validade1'];
                $banner_padrao1 = $res[0]['banner_padrao1'];

                if(@strtotime($validade1) < @strtotime($data_atual)){
                    $banner1 = $banner_padrao1;
                }

                $banner2 = $res[0]['banner2'];
                $link2 = $res[0]['link2'];
                $validade2 = $res[0]['validade2'];
                $banner_padrao2 = $res[0]['banner_padrao2'];

                if(@strtotime($validade2) < @strtotime($data_atual)){
                    $banner2 = $banner_padrao2;
                }


                $banner3 = $res[0]['banner3'];
                $link3 = $res[0]['link3'];
                $validade3 = $res[0]['validade3'];
                $banner_padrao3 = $res[0]['banner_padrao3'];

                if(@strtotime($validade3) < @strtotime($data_atual)){
                    $banner3 = $banner_padrao3;
                }

                ?> 

                <a href="<?php echo $link1 ?>"><img src="sistema/<?php echo $caminho ?>/images/banners/<?php echo $banner1 ?>" alt="slider1"
                    class="img-responsive"></a>
                <?php } ?>

            </div>

        </div>

        <div class="loadeding"></div>
    </div>
</div>


<!-- Search -->
<div class="bottom2 col-lg-12 col-md-12 col-sm-12 ocultar_web" >
    <div class="search-header-w">


        <div id="" class="sosearchpro-wrapper so-search ">
            <form method="POST" action="lista_produtos">
            <div id="search0" class="search input-group form-group">
                <div class="select_category filter_type  icon-select hidden-sm hidden-xs">
                    <select class="no-border" name="categoria">
                        <option value="0">Filtrar Categoria</option>

                        <?php 
                        $query = $pdo->query("SELECT * from categorias where ativo = 'Sim' order by nome asc");
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
                    autocomplete="off" placeholder="Digite o nome do Produto..." name="buscar" id="busca_input_mobile" onkeyup="listarMobile(0)">
                    <span class="input-group-btn">
                        <button type="submit" class="button-search btn btn-primary"
                        name="submit_search"><i class="fa fa-search"></i></button>
                    </span>
                </div>
                <input type="hidden" name="route" value="product/search" />
            </form>
        </div>
    </div>
</div>
<!-- //end Search -->





<!-- ULTIMOS PRODUTOS  -->
<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 main-left sidebar-offcanvas altura_minima_col3" id="produtos_recentes">                      


    <div class="module product-simple">
        <h3 class="modtitle">
            <span>Produtos Recentes</span>
        </h3>
        <div class="modcontent">
            <div id="so_extra_slider_1" class="extraslider">
                <!-- Begin extraslider-inner -->
                <div class="extraslider-inner" data-rtl="yes"
                data-pagination="yes" data-autoplay="no" data-delay="4" data-speed="0.6"
                data-margin="0" data-items_column0="1" data-items_column1="1"
                data-items_column2="1" data-items_column3="1" data-items_column4="1"
                data-arrows="no" data-lazyload="yes" data-loop="no" data-buttonpage="top">
                <div class="item ">

                  <?php 
                  $query = $pdo->query("SELECT * from produtos where ativo = 'Sim' $sql_produtos order by id desc limit 10");
                  $res = $query->fetchAll(PDO::FETCH_ASSOC);
                  $linhas = @count($res);
                  if($linhas > 0){
                    for($i=0; $i<$linhas; $i++){
                        $id = $res[$i]['id'];
                        $nome = $res[$i]['nome'];
                        $nota = $res[$i]['nota'];
                        $valor = $res[$i]['valor'];
                        $valor_promo = $res[$i]['valor_promo'];
                        $imagem = $res[$i]['imagem'];
                        $url = $res[$i]['nome_url'];


                        $nomeF = mb_strimwidth($nome, 0, 17, "...");

                        if($valor_promo > 0){
                            $valor_produto = $valor_promo;
                        }else{
                           $valor_produto = $valor;  
                       }

                       $valorF = @number_format($valor, 2, ',', '.');
                       $valor_promoF = @number_format($valor_promo, 2, ',', '.');
                       $valor_produtoF = @number_format($valor_produto, 2, ',', '.');

                       $nota1 = '-o';
                       $nota2 = '-o';
                       $nota3 = '-o';
                       $nota4 = '-o';
                       $nota5 = '-o';

                       if($nota >= 1){
                        $nota1 = '';
                    }

                    if($nota >= 2){
                        $nota2 = '';
                    }

                    if($nota >= 3){
                        $nota3 = '';
                    }

                    if($nota >= 4){
                        $nota4 = '';
                    }

                    if($nota >= 5){
                        $nota5 = '';
                    }


                    ?> 

                    <div class="product-layout item-inner style1 ">
                        <div class="item-image">
                            <div class="item-img-info">
                                <a href="produto-<?php echo $url ?>" target="_self" title="<?php echo $nome ?>">
                                    <img src="sistema/painel_loja/images/produtos/<?php echo $imagem ?>"
                                    alt="<?php echo $nome ?>">
                                </a>
                            </div>

                        </div>
                        <div class="item-info">
                            <div class="item-title">
                                <a href="produto-<?php echo $url ?>" target="_self" title="<?php echo $nome ?>"><?php echo $nomeF ?></a>
                            </div>
                            <div class="rating">
                                <span class="fa fa-stack"><i
                                    class="fa fa-star<?php echo $nota1 ?> fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i
                                        class="fa fa-star<?php echo $nota2 ?> fa-stack-2x"></i></span>
                                        <span class="fa fa-stack"><i
                                            class="fa fa-star<?php echo $nota3 ?> fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i
                                                class="fa fa-star<?php echo $nota4 ?> fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i
                                                    class="fa fa-star<?php echo $nota5 ?> fa-stack-2x"></i></span>
                                                </div>
                                                <div class="content_price price">
                                                    <span class="price-new product-price">R$<?php echo $valor_produtoF ?> </span>&nbsp;&nbsp;
                                                    <?php if($valor_promo > 0){ ?>
                                                        <span class="price-old">R$ <?php echo $valorF ?> </span>&nbsp;
                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <!-- End item-info -->
                                            <!-- End item-wrap-inner -->
                                        </div>

                                    <?php } } ?>


                                    <!-- End item-wrap -->
                                </div>


                            </div>
                            <!--End extraslider-inner -->
                        </div>
                    </div>
                </div>




            </div>





            <!-- BANNERS WEB -->
            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 main-right" style="margin-bottom: 35px">
                <div class="slider-container row">

                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 col2">
                        <div class="module sohomepage-slider ">
                            <div class="" data-rtl="yes" data-autoplay="no"
                            data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="0"
                            data-items_column0="1" data-items_column1="1" data-items_column2="1"
                            data-items_column3="1" data-items_column4="1" data-arrows="no"
                            data-pagination="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                            <div class="yt-content-slide">
                                 <div class="banners">
                                 <div class="b-img">
                                <a href="<?php echo $link1 ?>"><img src="sistema/<?php echo $caminho ?>/images/banners/<?php echo $banner1 ?>"
                                    alt="slider1" class="img-responsive"></a>
                                </div>
                            </div>
                                </div>

                            </div>

                            <div class="loadeding"></div>
                        </div>

                    </div>


                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 col3">
                        <div class="modcontent clearfix">
                            <div class="banners banners1">
                                <div class="b-img">
                                    <a href="<?php echo $link2 ?>"><img src="sistema/<?php echo $caminho ?>/images/banners/<?php echo $banner2 ?>" alt="banner3"></a>
                                </div>
                                <div class="b-img2">
                                    <a href="<?php echo $link3 ?>"><img src="sistema/<?php echo $caminho ?>/images/banners/<?php echo $banner3 ?>" alt="banner3"></a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>




            <!-- Listing tabs -->
            <div class="module ">
                <h3 class="modtitle" style="display:inline-block;"><span style="margin-left: 20px">Produtos mais Vendidos</span></h3>
              



                <!--Middle Part Start-->
                <div id="content" class="col-md-9 col-sm-8">
                    <div class="products-category">
                        
                      
                        <!-- Filters -->
                        <div class="product-filter product-filter-top filters-panel">
                            <div class="row">
                                <div class="col-md-5 col-sm-3 col-xs-12 view-mode">

                                    <div class="list-view">
                                        <button class="btn btn-default grid active" data-view="grid"
                                            data-toggle="tooltip" data-original-title="Grid"><i
                                                class="fa fa-th"></i></button>
                                        <button class="btn btn-default list" data-view="list" data-toggle="tooltip"
                                            data-original-title="List"><i class="fa fa-th-list"></i></button>
                                    </div>

                                </div>
                                <div class="short-by-show form-inline text-right col-md-7 col-sm-9 col-xs-12">
                                     <span class="display_mobile" style="position:absolute; right:60px">
                                       <i class="fa fa-search "></i> <input onkeyup="listar(0)"  type="text" id="busca_input" class="" style="border:none; border-bottom: 1px solid #000; outline:none; width:250px">
                                   </span>

                                </div>
                                <!-- <div class="box-pagination col-md-3 col-sm-4 col-xs-12 text-right">
                                <ul class="pagination">
                                    <li class="active"><span>1</span></li>
                                    <li><a href="">2</a></li><li><a href="">&gt;</a></li>
                                    <li><a href="">&gt;|</a></li>
                                </ul>
                            </div> -->
                            </div>
                        </div>
                        <!-- //end Filters -->
                         <div id="listar_produtos">
                        
                         </div>
                        

                    </div>

                </div>


                <!--Middle Part End-->
            </div>



              
            </div>
            <!-- end Listing tabs -->




        </div>
    </div>

    <?php include("rodape.php") ?>


    <script type="text/javascript">

        $(document).ready( function () {
            listar(0);
        });
       
       
        
    </script>


    <script type="text/javascript">
        function listar(pagina){            
        var busca = $("#busca_input").val();
         var tipo_loj = "<?=$tipo_loja?>"; 

         if(tipo_loj == 'Marketplace'){
            var id_loja = "";
        }else{
            var id_loja = "<?=$id_usuario?>";
        }
         

    $.ajax({
        url: 'ajax/listar_produtos.php',
        method: 'POST',
        data: {busca, pagina, id_loja},
        dataType: "html",

        success:function(result){
            $("#listar_produtos").html(result);            
        }
    });
}
    </script>


        <script type="text/javascript">
        function listarMobile(pagina){            
        var busca = $("#busca_input_mobile").val(); 
        if(busca == ""){
            $("#produtos_recentes").show();   
        }      
    $.ajax({
        url: 'ajax/listar_produtos.php',
        method: 'POST',
        data: {busca, pagina},
        dataType: "html",

        success:function(result){
            $("#listar_produtos").html(result);
            if(busca != ""){
            $("#produtos_recentes").hide(); 
            }           
        }
    });
}
    </script>