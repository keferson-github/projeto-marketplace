<?php include("cabecalho.php");

//PEGAR PAGINA ATUAL PARA PAGINAÇAO
if(@$_GET['pagina'] != null){
    $pag = $_GET['pagina'];
}else{
    $pag = 0;
}

$limite = $pag * @$itens_paginacao;
$pagina = $pag;
$nome_pag = 'categorias-';

 ?>
<!-- Main Container  -->
        <div class="main-container container">
            <ul class="breadcrumb">
               

            </ul>

            <div class="row">

                <!--Left Part Start -->
                <aside class="col-sm-4 col-md-3 content-aside" id="column-left">
                    <div class="module category-style">
                        <h3 class="modtitle">Categorias</h3>
                        <div class="modcontent">
                            <div class="box-category">
                                <ul id="cat_accordion" class="list-group">

                                     <?php 
                                                                                $query = $pdo->query("SELECT * from categorias where ativo = 'Sim' $sql_cat order by nome asc");
                                                                                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                                                                $linhas = @count($res);
                                                                                if($linhas > 0){
                                                                                    for($i=0; $i<$linhas; $i++){
                                                                                        $id_cat = $res[$i]['id'];
                                                                                        $nome_cat = $res[$i]['nome'];
                                                                                        $url_cat = $res[$i]['url'];
                                                                                   ?>
                                                                                     <li class="hadchild"><a href="categoria-<?php echo $url_cat ?>-0" class="cutom-parent"><?php echo $nome_cat ?></a> <span class="button-view  fa fa-plus-square-o"></span>
                                      <?php 
                                                                                $query2 = $pdo->query("SELECT * from subcategorias where ativo = 'Sim' and categoria = '$id_cat' $sql_cat order by nome asc");
                                                                                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                                                                $linhas2 = @count($res2);
                                                                                if($linhas2 > 0){
                                                                                     echo '<ul style="display: block;">';

                                                                            for($i2=0; $i2<$linhas2; $i2++){ 
                                                                                $id_sub = $res2[$i2]['id'];
                                                                                $nome_sub = $res2[$i2]['nome'];
                                                                                $url_sub = $res2[$i2]['url'];
                                                                              ?>
                                       
                                            <li><a href="subcategoria-<?php echo $url_sub ?>-0"><?php echo $nome_sub ?></a></li>
                                            
                                        <?php } ?>
                                        

                                    <?php echo '</ul>'; } ?>

                                    </li>

                                                                               <?php } }else{ echo 'Nenhuma categoria cadastrada!';} ?>


                                  
                                    
                                  
                                    
                                </ul>
                            </div>


                        </div>
                    </div>
                    <div class="module product-simple">
                        <h3 class="modtitle">
                            <span>Produtos Recentes</span>
                        </h3>
                        <div class="modcontent">
                            <div class="extraslider">
                                <!-- Begin extraslider-inner -->
                                <div class=" extraslider-inner">
                                    <div class="item ">


                                        <?php 
                  $query = $pdo->query("SELECT * from produtos where ativo = 'Sim' $sql_produtos order by id desc limit 5");
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


                                    </div>

                                </div>
                                <!--End extraslider-inner -->
                            </div>
                        </div>
                    </div>
                    
                </aside>
                <!--Left Part End -->

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
                        <!--changed listings-->
                        <div class="products-list row nopadding-xs so-filter-gird">


                             <?php 
                  $query = $pdo->prepare("SELECT * from categorias where ativo = 'Sim' $sql_cat order by nome asc LIMIT $limite, $itens_paginacao");                  
                  $query->execute();
                  $res = $query->fetchAll(PDO::FETCH_ASSOC);
                  $linhas = @count($res);
                  if($linhas > 0){
                    for($i=0; $i<$linhas; $i++){
                        $id = $res[$i]['id'];
                        $nome = $res[$i]['nome'];
                        $imagem = $res[$i]['imagem'];
                        $url = $res[$i]['url'];
                        $descricao = $res[$i]['descricao'];
                        $imagem2 = $imagem;

                        $nomeF = mb_strimwidth($nome, 0, 22, "...");    

                    //trazer o total de registros para paginacao
                     $query2 = $pdo->prepare("SELECT * from categorias where ativo = 'Sim' $sql_cat");                
                  $query2->execute();
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  $num_total = @count($res2);
                  $num_paginas = ceil($num_total/$itens_paginacao);


                   $query2 = $pdo->query("SELECT * from produtos where categoria = '$id'");
                   $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                   $total_produtos = @count($res2); 

                    ?> 


                            <div class="product-layout col-lg-15 col-md-4 col-sm-6 col-xs-12">
                                <div class="product-item-container">
                                    <div class="left-block">
                                       <div class="product-image-container second_img">
                                            <a href="categoria-<?php echo $url ?>-0" target="_self"
                                            title="<?php echo $nome ?>">
                                            <img src="sistema/painel/images/categorias/<?php echo $imagem ?>"
                                            class="img-1 img-responsive"
                                            alt="Pastrami bacon">
                                            <img src="sistema/painel/images/categorias/<?php echo $imagem2 ?>"
                                            class="img-2 img-responsive"
                                            alt="<?php echo $nome ?>">
                                        </a>
                                    </div>
                                  
                                        <div class="button-group so-quickview cartinfo--left">
                                            <!--quickview-->
                                            <a class=" btn-button quickview quickview_handler visible-lg"
                                                href="categoria-<?php echo $url ?>-0" title="Ver Produtos" ><i
                                                    class="fa fa-eye"></i><span>Ver Produtos</span></a>
                                            <!--end quickview-->
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <div class="caption">
                                           
                                            <h4><a href="produto-<?php echo $url ?>" title="<?php echo $nome ?>" target="_self"><?php echo $nomeF ?></a></h4>
                                            <div class="price" > 
                                                <span class="price-new"><?php echo $total_produtos ?> Produtos</span>
                                                                       
                                                                    </div>
                                            <div class="description item-desc">
                                                <p><?php echo $descricao ?> </p>
                                            </div>
                                            <div class="list-block" style="padding:0px">
                                                 <a href="categoria-<?php echo $url ?>-0" type="button" class="addToCart btn-button cards_carrinho" title="Ver Produtos"
                                                > <i class="fa fa-eye"></i>
                                                <span>Ver Produtos </span>
                                            </a>
                                          
                                            
                                                <!--end quickview-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } }else{ echo '<p style="margin-left:30px">Não foi encontrado nenhum produto!</p>'; } ?>


                        </div>
                        <!--// End Changed listings-->

                       


                         <div class="" align="center">
                                        <a href="<?php echo $nome_pag ?>0" class="btn btn-default grid "><i class="fa fa-chevron-left"></i></a>

                                         <?php 
                    for($i = 0; $i < @$num_paginas; $i++){
                        $estilo = '';
                        if($pagina == $i){
                            $estilo = 'active';
                        }

                        if($pagina >= ($i - 2) && $pagina <= ($i + 2)){ ?>
                             <a href="<?php echo $nome_pag ?><?php echo $i ?>" class="btn btn-default grid <?php echo $estilo ?>"><?php echo $i + 1 ?></a>                        

                       <?php } 

                    }
                 ?>
                                       
                                        
                                        <a href="<?php echo $nome_pag ?><?php echo $num_paginas - 1 ?>" class="btn btn-default grid "><i class="fa fa-chevron-right"></i></a>
                                    </div>

                                    <hr>
                                     <p align="right">Encontrado <?php echo $num_total ?> Categorias!</p>
                        

                    </div>     
                </div>


        </div>
        <!--Middle Part End-->
    </div>
    <!-- //Main Container -->

<?php include("rodape.php") ?>


<script type="text/javascript">

    
        <!--
        // Check if Cookie exists
        
            if (screen.width < 640 || screen.height < 480) {
                view = 'list';
               
             }else{
                view = 'grid';
                
             }
            
        
        if (view) display(view);
        //-->
    </script>