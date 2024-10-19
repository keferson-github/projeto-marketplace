<?php 
include("../sistema/conexao.php");

$busca = '%'.filter_var(@$_POST['busca'], @FILTER_SANITIZE_STRING).'%';

//PEGAR PAGINA ATUAL PARA PAGINAÇAO
if(@$_POST['pagina'] != null){
    $pag = filter_var($_POST['pagina'], @FILTER_SANITIZE_STRING);
}else{
    $pag = 0;
}

$limite = $pag * @$itens_paginacao;
$pagina = $pag;
//$nome_pag = 'lista_produtos.php';

$id_loja = @$_POST['id_loja'];

if($id_loja == ""){
  $sql_loja = "";
}else{
  $sql_loja = " and loja = '$id_loja' ";
}

echo '<div class="products-list row nopadding-xs so-filter-gird" >';

 $query = $pdo->prepare("SELECT * from produtos where ativo = 'Sim' and (nome like :busca or palavras like :busca) $sql_loja order by vendas desc LIMIT $limite, $itens_paginacao");
                  $query->bindValue(":busca", "$busca");
                  $query->execute();
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
                        $descricao = $res[$i]['descricao'];

                        if($valor_promo > 0 and $valor > 0){
                            $porcentagem = 100 - ($valor_promo * 100 / $valor);
                        }else{
                            $porcentagem = 0;
                        }
                        

                          $query2 = $pdo->query("SELECT * from produtos_imagens where produto = '$id' order by id asc ");
                          $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                          $imagem2 = @$res2[0]['foto'];
                          if($imagem2 == ""){
                            $imagem2 = $imagem;
                          }

                        $nomeF = mb_strimwidth($nome, 0, 22, "...");

                        if($valor_promo > 0){
                            $valor_produto = $valor_promo;
                        }else{
                           $valor_produto = $valor;  
                       }

                       $valorF = @number_format($valor, 2, ',', '.');
                       $valor_promoF = @number_format($valor_promo, 2, ',', '.');
                       $valor_produtoF = @number_format($valor_produto, 2, ',', '.');
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

                    $ocultar_promo = 'none';
                    if($valor_promo > 0){
                    	$ocultar_promo = '';
                    }


                    //trazer o total de registros para paginacao
                     $query2 = $pdo->prepare("SELECT * from produtos where ativo = 'Sim' and (nome like :busca or palavras like :busca) ");
                  $query2->bindValue(":busca", "$busca");
                  $query2->execute();
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  $num_total = @count($res2);
                  $num_paginas = ceil($num_total/$itens_paginacao);

echo <<<HTML

 <div class="product-layout col-lg-15 col-md-4 col-sm-6 col-xs-12">
                                <div class="product-item-container">
                                    <div class="left-block">
                                       <div class="product-image-container second_img">
                                            <a href="produto-{$url}" target="_self"
                                            title="{$nome}">
                                            <img src="sistema/painel_loja/images/produtos/{$imagem}"
                                            class="img-1 img-responsive"
                                            alt="Pastrami bacon">
                                            <img src="sistema/painel_loja/images/produtos/{$imagem2}"
                                            class="img-2 img-responsive"
                                            alt="{$nome}">
                                        </a>
                                    </div>
                                        <div style="display:{$ocultar_promo}" class="box-label"> <span class="label-product label-sale"> {$porcentagemF}% </span>
                                        </div>
                                        <div class="button-group so-quickview cartinfo--left">
                                            <a href="produto-{$url}" type="button" class="addToCart btn-button " title="Add ao Carrinho"
                                                > <i class="fa fa-shopping-basket"></i>
                                                <span>Add ao Carrinho </span>
                                            </a>
                                          
                                            <!--quickview-->
                                            <a class="btn-button quickview quickview_handler visible-lg"
                                                href="produto-{$url}" title="Quick view" data-fancybox-type="iframe"><i
                                                    class="fa fa-eye"></i><span>Ver Produto</span></a>
                                            <!--end quickview-->
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <div class="caption">
                                            <div class="rating" > 

                                                <span class="fa fa-stack"><i
                                    class="fa fa-star{$nota1} fa-stack-2x"></i></span>
                                    <span class="fa fa-stack"><i
                                        class="fa fa-star{$nota2} fa-stack-2x"></i></span>
                                        <span class="fa fa-stack"><i
                                            class="fa fa-star{$nota3} fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i
                                                class="fa fa-star{$nota4} fa-stack-2x"></i></span>
                                                <span class="fa fa-stack"><i
                                                    class="fa fa-star{$nota5} fa-stack-2x"></i></span>
                                            </div>
                                            <h4><a href="product.html" title="Chicken swinesha" target="_self">{$nomeF}</a></h4>
                                            <div class="price" > <span
                                                                            class="price-new">R$ {$valor_produtoF}</span>
                                                                          
                                                                        <span class="price-old" style="display:{$ocultar_promo}">R$ {$valorF}</span>
                                                                   
                                                                    </div>
                                            <div class="description item-desc">
                                                <p>{$descricao} </p>
                                            </div>
                                            <div class="list-block" style="padding:0px">
                                                 <a  class="addToCart btn-button cards_carrinho" title="Add ao Carrinho"
                                                href="produto-{$url}"> <i class="fa fa-shopping-basket"></i>
                                                <span>Add ao Carrinho </span>
                                            </a>
                                          
                                            <!--quickview-->
                                           
                                            <!--end quickview-->
                                                <!--end quickview-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


HTML;
}
}else{ echo '<p style="margin-left:30px">Não foi encontrado nenhum produto!</p>'; }
	
	echo '</div>';
	echo '<hr>';
    echo '<div class="" align="center">';
      echo '<a href="#" onclick="listar(0)" class="btn btn-default grid "><i class="fa fa-chevron-left"></i></a>';

            for($i = 0; $i < @$num_paginas; $i++){
                        $estilo = '';
                        if($pagina == $i){
                            $estilo = 'active';
                        }

                        if($pagina >= ($i - 2) && $pagina <= ($i + 2)){ 
                             echo '<a href="#" onclick="listar('.$i.')" class="btn btn-default grid '.$estilo.'">'.$i + 1 .'</a>';

                       } 

                    }             
                     
                     $numero_final = @$num_paginas - 1;                  
                                        
                     echo '<a href="#" onclick="listar('.$numero_final.')" class="btn btn-default grid "><i class="fa fa-chevron-right"></i></a> </div>';                               
?>


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