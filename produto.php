<?php 
@session_start();
$id_cliente = @$_SESSION['id_cliente'];

include("sistema/conexao.php");
$url = @$_GET['url'];

$query = $pdo->query("SELECT * from produtos where nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
    $id_produto = $res[0]['id'];
    $nome_produto = $res[0]['nome'];
    $palavras_produto = $res[0]['palavras'];
    $imagem_produto = $res[0]['imagem'];
}

include("cabecalho.php");

$url = @$_GET['url'];

$query = $pdo->query("SELECT * from clientes_finais where id = '$id_cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){   
    $cep_cliente = $res[0]['cep'];   
}



$query = $pdo->query("SELECT * from produtos where nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
    $id_produto = $res[0]['id'];
    $nome_produto = $res[0]['nome'];
    $valor_produto = $res[0]['valor']; 
    $valor_promo_produto = $res[0]['valor_promo'];
    $estoque_produto = $res[0]['estoque'];
    $nivel_produto = $res[0]['nivel'];
    $categoria_produto = $res[0]['categoria'];
    $subcategoria_produto = $res[0]['subcategoria'];
    $envio_produto = $res[0]['envio'];
    $frete_produto = $res[0]['frete'];
    $promocao_produto = $res[0]['promocao'];
    $imagem_produto = $res[0]['imagem'];
    $marca_produto = $res[0]['marca'];
    $modelo_produto = $res[0]['modelo'];
    $peso_produto = $res[0]['peso'];
    $largura_produto = $res[0]['largura'];
    $altura_produto = $res[0]['altura'];
    $comprimento_produto = $res[0]['comprimento'];
    $palavras_produto = $res[0]['palavras'];
    $descricao_produto = $res[0]['descricao'];
    $nome_url_produto = $res[0]['nome_url'];
    $ativo_produto = $res[0]['ativo'];
    $vendas_produto = $res[0]['vendas'];
    $data_produto = $res[0]['data'];
    $loja_produto = $res[0]['loja'];
    $carac_produto = $res[0]['carac'];
    $nota_produto = $res[0]['nota'];
    $video_produto = $res[0]['video'];
    $nome_frete = $res[0]['nome_frete'];

    if($envio_produto == 'Valor Fixo'){
        $nome_do_frete = $nome_frete;
    }else{
        $nome_do_frete = $envio_produto;
    }
    


    $nota1_produto = '-o';
    $nota2_produto = '-o';
    $nota3_produto = '-o';
    $nota4_produto = '-o';
    $nota5_produto = '-o';

    if($nota_produto >= 1){
        $nota1_produto = '';
    }

    if($nota_produto >= 2){
        $nota2_produto = '';
    }

    if($nota_produto >= 3){
        $nota3_produto = '';
    }

    if($nota_produto >= 4){
        $nota4_produto = '';
    }

    if($nota_produto >= 5){
        $nota5_produto = '';
    }


    if($valor_promo_produto > 0){
        $valor_produto_pagina = $valor_promo_produto;
    }else{
       $valor_produto_pagina = $valor_produto;  
   }

   $valor_produtoF = @number_format($valor_produto, 2, ',', '.');
   $valor_promo_produtoF = @number_format($valor_promo_produto, 2, ',', '.');
   $valor_produto_paginaF = @number_format($valor_produto_pagina, 2, ',', '.');

   $frete_produtoF = @number_format($frete_produto, 2, ',', '.');

   if($envio_produto == 'Valor Fixo'){
    $valor_do_frete = $frete_produto;
}else{
    $valor_do_frete = '0';
}

$pdo->query("DELETE FROM temp where carrinho = '0' and sessao = '$sessao_carrinho'");


}else{
    echo '<script>window.location="index"</script>';  
    exit();
}




if($estoque_produto <= 0){
    $classe_estoque = 'disabled';
    $texto_estoque = '<span class="text-danger">Estoque Indisponível!</span>';
}else{
    $classe_estoque = '';
    $texto_estoque = '';
}

//total de avaliações
$query = $pdo->query("SELECT * from avaliacoes where produto = '$id_produto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_avaliacoes = @count($res);
if($total_avaliacoes == 1){
    $texto_avaliacoes = 'Avaliação';
}else{
    $texto_avaliacoes = 'Avaliações';
}


//PEGAR AS FOTOS
$imagem_do_produto_0 = $imagem_produto;
$imagem_do_produto_1 = "";
$imagem_do_produto_2 = "";
$imagem_do_produto_3 = "";
$imagem_do_produto_4 = "";
$imagem_do_produto_5 = "";
$imagem_do_produto_6 = "";
$imagem_do_produto_7 = "";
$imagem_do_produto_8 = "";
$imagem_do_produto_9 = "";
$imagem_do_produto_10 = "";
$query = $pdo->query("SELECT * from produtos_imagens where produto = '$id_produto' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
   $imagem_do_produto_1 = @$res[0]['foto']; 
   $imagem_do_produto_2 = @$res[1]['foto']; 
   $imagem_do_produto_3 = @$res[2]['foto']; 
   $imagem_do_produto_4 = @$res[3]['foto']; 
   $imagem_do_produto_5 = @$res[4]['foto']; 
   $imagem_do_produto_6 = @$res[5]['foto']; 
   $imagem_do_produto_7 = @$res[6]['foto']; 
   $imagem_do_produto_8 = @$res[7]['foto']; 
   $imagem_do_produto_9 = @$res[8]['foto']; 
   $imagem_do_produto_10 = @$res[9]['foto']; 
}
        ?>
        <!-- Main Container  -->
        <div class="main-container container">
            <ul class="breadcrumb">


            </ul>

            <div class="row">

                <!--Left Part Start -->
                <aside class="col-sm-4 col-md-3 content-aside ocultar_mobile" id="column-left">
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
                                          $query2 = $pdo->query("SELECT * from subcategorias where ativo = 'Sim' and categoria = '$id_cat' order by nome asc");
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
                                                    $valor_produto_recentes = $valor_promo;
                                                }else{
                                                   $valor_produto_recentes = $valor;  
                                               }

                                               $valorF = @number_format($valor, 2, ',', '.');
                                               $valor_promoF = @number_format($valor_promo, 2, ',', '.');
                                               $valor_produto_recentesF = @number_format($valor_produto_recentes, 2, ',', '.');

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
                                                                    <span class="price-new product-price">R$<?php echo $valor_produto_recentesF ?></span>&nbsp;&nbsp;
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

                                <div class="product-view row">
                                    <div class="left-content-product">

                                        <div class="content-product-left class-honizol col-md-5 col-sm-12 col-xs-12">
                                            <div class="large-image  ">
                                                <img itemprop="image" class="product-image-zoom ocultar_mobile"
                                                src="sistema/painel_loja/images/produtos/<?php echo $imagem_produto ?>"
                                                data-zoom-image="sistema/painel_loja/images/produtos/<?php echo $imagem_produto ?>"
                                                title="<?php echo $nome_produto ?>" alt="<?php echo $nome_produto ?>">
                                            </div>
                                            <?php if($video_produto != ""){ ?>
                                                <a class="thumb-video pull-left" href="<?php echo $video_produto ?>"><i
                                                    class="fa fa-youtube-play"></i></a>
                                                <?php } ?>

                                                <div id="thumb-slider" class="yt-content-slider full_slider owl-drag" data-rtl="yes"
                                                data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6"
                                                data-margin="10" data-items_column0="4" data-items_column1="3"
                                                data-items_column2="4" data-items_column3="1" data-items_column4="1"
                                                data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no"
                                                data-hoverpause="yes">

                                                <a data-index="0" class="img thumbnail "
                                                data-image="sistema/painel_loja/images/produtos/<?php echo $imagem_produto ?>" title="<?php echo $nome_produto ?>">
                                                <img src="sistema/painel_loja/images/produtos/<?php echo $imagem_produto ?>" title="<?php echo $nome_produto ?>"
                                                alt="<?php echo $nome_produto ?>">
                                            </a>

                                            <?php 
                                            $query = $pdo->query("SELECT * from produtos_imagens where produto = '$id_produto' order by id asc");
                                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                            $linhas = @count($res);
                                            if($linhas > 0){
                                                for($i=0; $i<$linhas; $i++){                                        
                                                    $imagem_do_produto = $res[$i]['foto'];
                                                                            
                                                    ?>
                                                    <a data-index="<?php echo $i ?>" class="img thumbnail "
                                                        data-image="sistema/painel_loja/images/produtos/<?php echo $imagem_do_produto ?>" title="<?php echo $nome_produto ?>">
                                                        <img src="sistema/painel_loja/images/produtos/<?php echo $imagem_do_produto ?>" title="<?php echo $nome_produto ?>"
                                                        alt="<?php echo $nome_produto ?>">
                                                    </a>
                                                <?php } } ?>

                                            </div>

                                        </div>

                                        <div class="content-product-right col-md-7 col-sm-12 col-xs-12">
                                            <div class="title-product">
                                                <h1><?php echo $nome_produto ?></h1>
                                            </div>
                                            <!-- Review ---->
                                            <div class="box-review form-group">
                                                <div class="ratings">
                                                    <div class="rating-box">                                     

                                                        <span class="fa fa-stack"><i
                                                            class="fa fa-star<?php echo $nota1_produto ?> fa-stack-1x"></i></span>
                                                            <span class="fa fa-stack"><i
                                                                class="fa fa-star<?php echo $nota2_produto ?> fa-stack-1x"></i></span>
                                                                <span class="fa fa-stack"><i
                                                                    class="fa fa-star<?php echo $nota3_produto ?> fa-stack-1x"></i></span>
                                                                    <span class="fa fa-stack"><i
                                                                        class="fa fa-star<?php echo $nota4_produto ?> fa-stack-1x"></i></span>
                                                                        <span class="fa fa-stack"><i
                                                                            class="fa fa-star<?php echo $nota5_produto ?> fa-stack-1x"></i></span>
                                                                        </div>
                                                                    </div>

                                                                    <a class="reviews_button" href="#"
                                                                    onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $total_avaliacoes ?>
                                                                    <?php echo $texto_avaliacoes ?></a>

                                                                </div>

                                                                <div class="product-label form-group">
                                                                    <div class="product_page_price price" itemprop="offerDetails" itemscope=""
                                                                    itemtype="http://data-vocabulary.org/Offer">
                                                                    <span class="price-new" itemprop="price">R$ <span id="valor_item_quantF"><?php echo $valor_produto_paginaF ?> </span></span>
                                                                    <?php if($valor_promo_produto > 0){ ?>
                                                                        <span class="price-old">R$ <?php echo $valor_produtoF ?></span>
                                                                    <?php } ?>
                                                                </div>

                                                            </div>

                                                            <?php if($carac_produto != "" and $carac_produto != "<br>"){ ?>
                                                                <div class="product-box-desc">
                                                                    <div class="inner-box-desc">
                                                                        <?php echo $carac_produto ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>



                                                            <div id="product">

                                                             <?php 
                                                             $query = $pdo->query("SELECT * from grades where produto = '$id_produto' and ativo = 'Sim' order by id asc");
                                                             $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                                             $linhas = @count($res);
                                                             if($linhas > 0){

                                                                ?>
                                                                <h4>Opcionais</h4>

                                                                <?php 
                                                                for($i=0; $i<$linhas; $i++){
                                                                    $id_grade = $res[$i]['id'];
                                                                    $tipo_item = $res[$i]['tipo_item'];
                                                                    $valor_item = $res[$i]['valor_item'];
                                                                    $texto = $res[$i]['texto'];
                                                                    $limite = $res[$i]['limite'];
                                                                    $ativo = $res[$i]['ativo'];
                                                                    $obrigatoria = $res[$i]['obrigatoria'];

                                                                    if($obrigatoria == 'Sim'){
                                                                        $classe_obg = 'required';
                                                                    }else{
                                                                     $classe_obg = ''; 
                                                                 }

                                                                 ?>

                                                                 <div class="image_option_type form-group <?php echo $classe_obg ?>">
                                                                     <input type="hidden" id="qt_<?php echo $id_grade ?>">
                                                                     <label class="control-label"><?php echo $texto ?> <?php if($limite > 0){ echo ' <span style="font-size:12px; color:#000">(até '.$limite.' itens!)</span>'; } ?></label>


                                                                     <ul class="product-options clearfix" id="input-option231">

                                                                        <?php 
                                                                        $query2 =$pdo->query("SELECT * FROM itens_grade where grade = '$id_grade' and ativo = 'Sim' order by id asc");
                                                                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                                                        $total_reg2 = @count($res2);
                                                                        if($total_reg2 > 0){ 
                                                                            for($i2=0; $i2 < $total_reg2; $i2++){      
                                                                                $id_item = $res2[$i2]['id']; 
                                                                                $texto_item = $res2[$i2]['texto']; 
                                                                                $valor_item_grade = $res2[$i2]['valor']; 
                                                                                $limite_item = $res2[$i2]['limite']; 
                                                                                $cor_item = $res2[$i2]['cor']; 
                                                                                $valor_item_gradeF = number_format($valor_item_grade, 2, ',', '.');

                                                                                $ocultar_valor = 'ocultar';
                                                                                if($valor_item_grade > 0){
                                                                                    $ocultar_valor = '';
                                                                                }

                                                                                if($cor_item == "#FFF" || $cor_item == ""){
                                                                                    $check_cor = "#000";
                                                                                }else{
                                                                                    $check_cor = "#FFF";
                                                                                }

                                                                                ?>

                                                                                <li class="radio">
                                                                                    <label>  

                                                                                      <?php if($tipo_item == 'Único' || $tipo_item == 'Variação'){ ?>                                                   
                                                                                        <input class="image_radio" type="radio" name=""
                                                                                        value="" id="<?php echo $id_item ?>" onchange="itens('<?php echo $id_item ?>', '<?php echo $id_grade ?>', '<?php echo $valor_item_grade ?>', '<?php echo $tipo_item ?>', '1', '<?php echo $valor_item ?>', '<?php echo $limite ?>' )">

                                                                                        <img style="background-color: <?php echo $cor_item ?>" src="image/demo/colors/transp.png"
                                                                                        data-original-title="<?php echo $texto_item ?>"
                                                                                        class="img-thumbnail icon icon-color"> <i
                                                                                        class="fa fa-check" style="color:<?php echo $check_cor ?>;"></i>

                                                                                    <?php } ?>  


                                                                                    <?php if($tipo_item == '1 de Cada'){ ?>

                                                                                        <label><input type="checkbox" id="<?php echo $id_item ?>" onchange="itens('<?php echo $id_item ?>', '<?php echo $id_grade ?>', '<?php echo $valor_item_grade ?>', '<?php echo $tipo_item ?>', '1', '<?php echo $valor_item ?>', '<?php echo $limite ?>' )"> </label>

                                                                                    <?php } ?>


                                                                                    <?php if($tipo_item == 'Múltiplo'){ ?>
                                                                                       <span>

                                                                                        <span style="display:inline-block;"> 
                                                                                            <img onclick="dim('<?php echo $id_grade ?>', '<?php echo $id_item ?>', '<?php echo $valor_item_grade ?>', '<?php echo $tipo_item ?>', '<?php echo $valor_item ?>', '<?php echo $limite_item ?>', '<?php echo $limite ?>')" src="image/demo/colors/minus.png" width="15px"> 

                                                                                        </span>


                                                                                        <span style="display:inline-block;">       <b><input id="quantidade_item_<?php echo $id_item ?>" value="0" style="background: transparent; border:none; width:18px; text-align: center; outline: none" readonly></b> </span>


                                                                                        <span style="display:inline-block;">  
                                                                                            <img onclick="aum('<?php echo $id_grade ?>', '<?php echo $id_item ?>', '<?php echo $valor_item_grade ?>', '<?php echo $tipo_item ?>', '<?php echo $valor_item ?>', '<?php echo $limite_item ?>', '<?php echo $limite ?>')" src="image/demo/colors/plus.png" width="15px">                    
                                                                                        </span>

                                                                                    </span>


                                                                                <?php } ?>  



                                                                            </label>

                                                                            <span style="margin-right: 8px; font-size: 11px">
                                                                                <?php if($cor_item == ""){ ?>
                                                                                    <span ><?php echo $texto_item ?></span>
                                                                                <?php } ?>

                                                                                <span class="valor-item <?php echo $ocultar_valor ?>">(R$ <?php echo $valor_item_gradeF ?>) </span> <?php if($limite_item > 0){ echo ' <span style="font-size:12px; color:red">(até '.$limite_item.' itens!)</span>'; } ?>

                                                                            </span>
                                                                        </li>



                                                                        <?php if($cor_item == ""){echo '<br>';} } } ?>

                                                                        <?php if($tipo_item != '1 de Cada' and $tipo_item != 'Múltiplo'){ ?>
                                                                            <li class="selected-option">
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>

                                                            <?php } ?>


                                                        <?php } ?>

                                                        <div style="margin-bottom: 10px">
                                                            <?php if($envio_produto == 'Valor Fixo'){ ?>
                                                                <b>Frete Fixo</b> R$ <?php echo $frete_produtoF ?>
                                                            <?php } ?>

                                                            <?php if($envio_produto == 'Melhor Envio'){ ?>
                                                                <b>Calcular Frete</b>
                                                                <div>
                                                                   <input class="form-control" type="text" name="cep_frete" id="cep" value="<?php echo @$cep_cliente ?>" style="width:100px; display:inline-block;">
                                                                   <button onclick="calcularFrete()" class="btn btn-mega " style="display:inline-block;">Calcular</button>
                                                               </div>
                                                           <?php } ?>
                                                       </div>

                                                       <div style="margin-bottom: 10px" id="div_frete">

                                                       </div>

                                                       <div class="form-group box-info-product">
                                                        <div class="option quantity">
                                                            <div class="input-group quantity-control" unselectable="on"
                                                            style="-webkit-user-select: none;">
                                                            <label>Qtd</label>
                                                            <input class="form-control" type="text" name="qtd" id="qtd" value="1">
                                                            <input type="hidden" name="product_id" value="50">
                                                            <span class="input-group-addon product_quantity_down">−</span>
                                                            <span class="input-group-addon product_quantity_up">+</span>
                                                        </div>
                                                    </div>

                                                    <div class="cart">
                                                        <input <?php echo $classe_estoque ?> type="button" data-toggle="tooltip" title="" value="Add ao Carrinho"
                                                        data-loading-text="Carregando..." id="button-cart"
                                                        class="btn btn-mega btn-lg" onclick="addCarrinho()"
                                                        data-original-title="Add ao Carrinho">
                                                        <?php echo $texto_estoque ?>
                                                    </div>


                                                </div>

                                            </div>
                                            <!-- end box info product -->


                                        </div>

                                    </div>
                                </div>
                                <!-- Product Tabs -->
                                <div class="producttab ">
                                    <div class="tabsslider  vertical-tabs col-xs-12">
                                        <ul class="nav nav-tabs col-lg-2 col-sm-3">
                                            <li class="active"><a data-toggle="tab" href="#tab-1">Descrição</a></li>
                                            <li class="item_nonactive"><a data-toggle="tab" href="#tab-review">Avaliaçãoes (<?php echo $total_avaliacoes ?>)</a></li>

                                        </ul>
                                        <div class="tab-content col-lg-10 col-sm-9 col-xs-12">
                                            <div id="tab-1" class="tab-pane fade active in">
                                                <p>
                                                    <?php echo $descricao_produto ?>
                                                </p>

                                            </div>
                                            <div id="tab-review" class="tab-pane fade">
                                                <form>
                                                    <div id="review">

                                                        <?php 
                                                        $query = $pdo->query("SELECT * from avaliacoes where produto = '$id_produto'");
                                                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                                        $total_ava = @count($res);
                                                        if($total_ava > 0){
                                                            for($i=0; $i<$total_ava; $i++){       
                                                                $cliente = $res[$i]['cliente'];
                                                                $nota = $res[$i]['nota'];
                                                                $texto = $res[$i]['texto'];
                                                                $data = $res[$i]['data'];
                                                                $dataF = implode('/', array_reverse(@explode('-', $data)));

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


                                                                $query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
                                                                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                                                $nome_cliente = $res2[0]['nome'];

                                                                ?>

                                                                <table class="table table-striped table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 50%;"><strong><?php echo $nome_cliente ?></strong>
                                                                            </td>
                                                                            <td class="text-right"><?php echo $dataF ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <p><?php echo $texto ?></p>
                                                                                <div class="ratings">
                                                                                    <div class="rating-box">
                                                                                      <span class="fa fa-stack"><i
                                                                                        class="fa fa-star<?php echo $nota1 ?> fa-stack-1x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                            class="fa fa-star<?php echo $nota2 ?> fa-stack-1x"></i></span>
                                                                                            <span class="fa fa-stack"><i
                                                                                                class="fa fa-star<?php echo $nota3 ?> fa-stack-1x"></i></span>
                                                                                                <span class="fa fa-stack"><i
                                                                                                    class="fa fa-star<?php echo $nota4 ?> fa-stack-1x"></i></span>
                                                                                                    <span class="fa fa-stack"><i
                                                                                                        class="fa fa-star<?php echo $nota5 ?> fa-stack-1x"></i></span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            <?php } }else{ echo 'Nenhuma Avaliação Ainda!'; } ?>
                                                                            <div class="text-right"></div>
                                                                        </div>


                                                                    </form>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- //Product Tabs -->

                                                    <!-- Related Products -->
                                                    <div class="related titleLine products-list grid module ">
                                                        <h3 class="modtitle">Outros produtos deste Vendedor </h3>

                                                        <div class="releate-products yt-content-slider products-list" data-rtl="no" data-loop="yes"
                                                        data-autoplay="no" data-autoheight="no" data-autowidth="no" data-delay="4" data-speed="0.6"
                                                        data-margin="30" data-items_column0="5" data-items_column1="3" data-items_column2="3"
                                                        data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no"
                                                        data-lazyload="yes" data-hoverpause="yes">



                                                        <?php 
                                                        $query = $pdo->query("SELECT * from produtos where ativo = 'Sim' and loja = '$loja_produto' order by id desc");
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

                                                                if($valor_promo > 0 and $valor > 0){
                                                                    $porcentagem = 100 - ($valor_promo * 100 / $valor);
                                                                }else{
                                                                    $porcentagem = 0;
                                                                }

                                                                if($id == $id_produto){
                                                                    continue;
                                                                }



                                                                $nomeF = mb_strimwidth($nome, 0, 22, "...");

                                                                if($valor_promo > 0){
                                                                    $valor_produto_recentes = $valor_promo;
                                                                }else{
                                                                   $valor_produto_recentes = $valor;  
                                                               }

                                                               $valorF = @number_format($valor, 2, ',', '.');
                                                               $valor_promoF = @number_format($valor_promo, 2, ',', '.');
                                                               $valor_produto_recentesF = @number_format($valor_produto_recentes, 2, ',', '.');
                                                               $porcentagemF = @number_format($porcentagem, 0, ',', '.');

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
                                                            <div class="item">
                                                                <div class="item-inner product-layout transition product-grid">
                                                                    <div class="product-item-container">
                                                                        <div class="left-block">
                                                                            <div class="product-image-container second_img">
                                                                                <a href="produto-<?php echo $url ?>" target="_self" title="<?php echo $nome ?>">
                                                                                    <img src="sistema/painel_loja/images/produtos/<?php echo $imagem ?>"
                                                                                    class="img-1 img-responsive" alt="<?php echo $nome ?>">
                                                                                    <img src="sistema/painel_loja/images/produtos/<?php echo $imagem ?>"
                                                                                    class="img-2 img-responsive" alt="<?php echo $nome ?>">
                                                                                </a>
                                                                            </div>

                                                                            <?php if($valor_promo > 0){ ?>   
                                                                                <div class="box-label"> <span class="label-product label-sale"> <?php echo $porcentagemF ?>% </span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <div class="button-group so-quickview cartinfo--left">
                                                                                <button type="button" class="addToCart btn-button" title="Add ao Carrinho"
                                                                                onclick="cart.add('60 ');"> <i class="fa fa-shopping-basket"></i>
                                                                                <span>Add ao Carrinho </span>
                                                                            </button>


                                                                            <!--quickview-->
                                                                            <a class="btn-button quickview quickview_handler visible-lg"
                                                                            href="produto-<?php echo $url ?>" title="Quick view"
                                                                            data-fancybox-type="iframe"><i class="fa fa-eye"></i><span>Ver Detalhes</span></a>
                                                                            <!--end quickview-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="right-block">
                                                                        <div class="caption">

                                                                            <div class="rating"> <span class="fa fa-stack"><i
                                                                                class="fa fa-star fa-stack-2x"></i></span>
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
                                                                                                <h4><a href="product.html" title="Pastrami bacon"
                                                                                                    target="_self"><?php echo $nomeF ?></a></h4>
                                                                                                    <div class="price" > <span
                                                                                                        class="price-new">R$ <?php echo $valor_produto_recentesF ?></span>
                                                                                                        <?php if($valor_promo > 0){ ?>   
                                                                                                            <span class="price-old">R$ <?php echo $valorF ?></span>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            <?php } } ?>






                                                                        </div>
                                                                    </div>

                                                                    <!-- end Related  Products-->
                                                                </div>






                                                            </div>


                                                        </div>
                                                        <!--Middle Part End-->
                                                    </div>
                                                    <!-- //Main Container -->


                                                    <input type="hidden" id="valor_total_input" value="<?php echo $valor_produto_pagina ?>">
                                                    <input type="hidden" id="valor_total_produto" value="<?php echo $valor_produto_pagina ?>">

                                                    <input type="hidden" id="nome_frete" value="<?php echo $nome_do_frete ?>">
                                                    <input type="hidden" id="valor_frete" value="<?php echo $valor_do_frete ?>">


                                                    <?php include("rodape.php") ?>

                                                    <script type="text/javascript">
                                                        function addCarrinho(){
                                                            var produto = '<?=$id_produto?>';        
                                                            var quantidade = $("#qtd").val();
                                                            var valor_produto = $("#valor_total_input").val();
                                                            var envio_produto = '<?=$envio_produto?>'; 
                                                            var valor_frete = $("#valor_frete").val();
                                                            var loja_produto = '<?=$loja_produto?>';      

                                                            var estoque_produto = '<?=$estoque_produto?>';
                                                            if(estoque_produto <= 0){
                                                                alert('Estoque Insuficiente!');
                                                                return;
                                                            }      

                                                            if(envio_produto == 'Melhor Envio'){
                                                                if(valor_frete <= 0){
                                                                    alert('Você precisa escolher uma opção de frete!');
                                                                    return;
                                                                }
                                                            }   

                                                            var valor_frete = $("#valor_frete").val();
                                                            var nome_frete = $("#nome_frete").val();


                                                            var total_item = $('#valor_total_input').val();
                                                            var valor_produto_item = $('#valor_total_produto').val();


                                                            if(total_item <= 0 && valor_produto_item <= 0 ){
                                                                alert("O valor do Pedido é zero, selecione as opções!");
                                                                return;
                                                            }

                                                            if(valor_produto_item <= 0){
                                                                alert("Selecione a Variação do Item");
                                                                return;
                                                            }


                                                            $.ajax({
                                                                url: 'ajax/add_carrinho.php',
                                                                method: 'POST',
                                                                data: {produto, quantidade, valor_produto, valor_frete, nome_frete, loja_produto},
                                                                dataType: "text",

                                                                success: function (mensagem) {
           //alert(mensagem)
           if (mensagem.trim() == "Salvo com Sucesso") {                
             window.location="carrinho";            
         }else{
            alert(mensagem)
        }

    },      

});



                                                        }
                                                    </script>




                                                    <script type="text/javascript">
                                                        function itens(id, grade, valor, tipo, quantidade, tipagem, limite_grade){

                                                           var produto = '<?=$id_produto?>';      
                                                           var marcado = $("#"+grade).val();
                                                           var qtd_marcada = $("#qt_"+grade).val();
                                                           if(qtd_marcada == ""){
                                                            qtd_marcada = 0;
                                                        }

                                                        if(tipo == '1 de Cada' && limite_grade > 0){
                                                           if($('#'+id).is(":checked") == true){
                                                            qtd_marcada_final = parseFloat(qtd_marcada) + 1;
                                                        }else{
                                                            qtd_marcada_final = parseFloat(qtd_marcada) - 1;
                                                        }            

                                                        if(qtd_marcada_final > limite_grade){
                                                            alert('O limite para essa escolha é de '+limite_grade+' Itens!');
                                                            $('#'+id).prop("checked", false);
                                                            return;
                                                        }else{
                                                            $("#qt_"+grade).val(qtd_marcada_final);
                                                        }
                                                    }


                                                    $.ajax({
                                                        url: 'ajax/adicionar_item.php',
                                                        method: 'POST',
                                                        data: {id, grade, valor, tipo, marcado, quantidade, tipagem, produto},
                                                        dataType: "text",

                                                        success: function (mensagem) {
           //alert(mensagem)
           if (mensagem.trim() == "Alterado com Sucesso") {                
            listarItens();                
        } 

    },      

});
                                                }



                                                function listarItens(){


                                                    var id = '<?=$id_produto?>';

                                                    $.ajax({
                                                       url: 'ajax/listar_itens_grade.php',
                                                       method: 'POST',
                                                       data: {id},
                                                       dataType: "html",

                                                       success:function(result){
            //alert(result)
            var split = result.split('*');

            $("#valor_total_input").val(split[0]);
            $("#valor_item_quantF").text(split[1]);
            $("#valor_total_produto").val(split[2]);
        }
    });
                                                }

                                            </script>






                                            <script type="text/javascript">
                                                function aum(grade, item, valor, tipo, tipagem, limite, limite_grade){
                                                    var quant = $("#quantidade_item_"+item).val();
                                                    var quantidade = parseFloat(quant) + 1; 


                                                    if(limite > 0){
                                                        if(quantidade > limite){
                                                            alert("A quantidade de itens não pode ser maior que "+limite)
                                                            $("#quantidade_item_"+item).focus();
                                                            return;
                                                        }
                                                    }  




                                                    var qt_grade = $("#qt_"+grade).val();
                                                    if(qt_grade == ""){
                                                        qt_grade = 0;
                                                    }
                                                    qt_grade = parseFloat(qt_grade) + 1;


                                                    if(limite_grade > 0){
                                                        if(qt_grade > limite_grade){
                                                            alert("A quantidade de itens selecionados não pode ser maior que "+limite_grade)
                                                            $("#quantidade_item_"+item).focus();
                                                            return;
                                                        }
                                                    }  
                                                    $("#qt_"+grade).val(qt_grade);



                                                    $("#quantidade_item_"+item).val(quantidade); 
                                                    $("#quantidade_item_"+item).focus();


                                                    itens(item, grade, valor, tipo, quantidade, tipagem);
                                                }

                                                function dim(grade, item, valor, tipo, tipagem, limite, limite_grade){
                                                    var quant = $("#quantidade_item_"+item).val();

                                                    var quantidade = parseFloat(quant) - 1;

                                                    if(quantidade < 0){
                                                        alert('Insira um valor igual ou maior que zero');
                                                        $("#quantidade_item_"+item).focus();
                                                        return;
                                                    } 


                                                    var qt_grade = $("#qt_"+grade).val();
                                                    if(qt_grade == ""){
                                                        qt_grade = 0;
                                                    }
                                                    qt_grade = parseFloat(qt_grade) - 1;
                                                    $("#qt_"+grade).val(qt_grade);


                                                    $("#quantidade_item_"+item).val(quantidade); 
                                                    $("#quantidade_item_"+item).focus();


                                                    itens(item, grade, valor, tipo, quantidade, tipagem);
                                                }

                                            </script>



                                            <!-- Mascaras JS -->
                                            <script type="text/javascript" src="sistema/painel/js/mascaras.js"></script>

                                            <!-- Ajax para funcionar Mascaras JS -->
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 



                                            <script type="text/javascript">
                                                function calcularFrete(){
                                                    var cep = $("#cep").val();
                                                    var id = '<?=$id_produto?>';       

                                                    $.ajax({
                                                       url: 'ajax/consultar_frete.php',
                                                       method: 'POST',
                                                       data: {cep, id},
                                                       dataType: "html",

                                                       success:function(result){                
                                                        $("#div_frete").html(result);                
                                                    }
                                                });

                                                }
                                            </script>


                                            <script type="text/javascript">
                                                $(document).ready(function() {


                                                    if("<?=$imagem_do_produto_0?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                                                                       
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }


                                                   if("<?=$imagem_do_produto_1?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },

                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }


                                               if("<?=$imagem_do_produto_2?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_3?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_4?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }




                                               if("<?=$imagem_do_produto_5?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_6?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_6?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_7?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_6?>" },
                                                       {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_7?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_8?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_6?>" },
                                                       {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_7?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_8?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }



                                               if("<?=$imagem_do_produto_9?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_6?>" },
                                                       {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_7?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_8?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_9?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }




                                                if("<?=$imagem_do_produto_10?>" != ""){
                                                   $('.large-image').magnificPopup({

                                                    items: [
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_0?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_1?>" },
                                                    {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_2?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_3?>" },
                                                     {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_4?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_5?>" },
                                                      {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_6?>" },
                                                       {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_7?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_8?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_9?>" },
                                                        {src: 'sistema/painel_loja/images/produtos/'+"<?=$imagem_do_produto_10?>" },                                                    
                                                    ],
                                                    gallery: { enabled: true, preload: [0,2] },
                                                    type: 'image',
                                                    mainClass: 'mfp-fade',
                                                    callbacks: {
                                                        open: function() {

                                                            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
                                                            var magnificPopup = $.magnificPopup.instance;
                                                            magnificPopup.goTo(activeIndex);
                                                        }
                                                    }
                                                });

                                               }





                                               });
                                           </script>