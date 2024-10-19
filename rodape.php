
    <!-- Footer Container -->
    <footer class="footer-container typefooter-1">
        <!-- Footer Top Container -->
        <section class="footer-top">
            <div class="container ftop">
            
            </div>
        </section>
        <!-- /Footer Top Container -->

        <div class="footer-middle ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-style">
                        <div class="infos-footer">
                            <a href="#">
                                <?php if($tipo_loja == 'Marketplace'){ ?>
                                <img src="sistema/img/logo.jpg" alt="image" width="200px">
                            <?php }else{ ?>
                                <img src="sistema/img/logo<?php echo $id_img ?>.png" alt="image" width="80px">
                            <?php } ?>
                            </a>
                            <ul class="menu">
                                <li class="adres">
                                    <?php echo $endereco_sistema ?>
                                </li>
                                <li class="phone">
                                    <?php echo $telefone_sistema ?>
                                </li>
                                <li class="mail">
                                    <a style="text-transform: lowercase" href="mailto:<?php echo $email_sistema ?>"><?php echo $email_sistema ?></a>
                                </li>
                                <li class="time">
                                    Aberto 24 Horas
                                </li>
                            </ul>
                        </div>


                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 col-style">
                        <div class="box-information box-footer">
                            <div class="module clearfix">
                               
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 col-style">
                        <div class="box-account box-footer">
                            <div class="module clearfix">
                               <h3 class="modtitle">Informações</h3>
                                <div class="modcontent">
                                    <ul class="menu">
                                        <li><a href="sistema">Seja um Vendedor</a></li>
                                        <li><a href="#">Compra Segura</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#">Produtos de Qualidade</a></li>
                                        <li><a href="#">Produtos Verficados</a></li>
                                        <li><a href="#">Vendedores Qualificados</a></li>
                                        <li><a href="#">Lojas Parceiras</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 col-style">
                        <div class="box-service box-footer">
                            <div class="module clearfix">
                                
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-style">

  <div class="box-service box-footer">
                            <div class="module clearfix">

                            <h3 class="modtitle">Redes Sociais</h3>

<div class="modcontent">
                                    <ul class="menu">
                                       
                                        <li><a class="_blank" href="<?php echo $instagram_sistema ?>"
                                    target="_blank"><i class="fa fa-instagram"></i> <span>Instagram</span></a></li>

                                     <li><a class="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $tel_whats ?>"
                                    target="_blank"><i class="fa fa-whatsapp"></i> <span>Whatsapp</span></a></li>
                                    </ul>
                                </div>

                            </div>


                        </div>
                    </div>

                    <?php if($tipo_loja == 'Marketplace'){ ?>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-style">
                        <ul class="footer-links font-title">
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

                <?php } ?>

                    <br>
                    <div class="col-lg-12 col-xs-12 text-center">
                        <img src="sistema/img/pgtos.jpg" alt="imgpayment" width="320px">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Container -->
        <div class="footer-bottom ">
            <div class="container">
                <div class="copyright">
                    Todos os Direitos Reservados | Desenvolvido por <a href="https://www.grupowebsystem.com.br/"
                        target="_blank">Grupo Web System</a>
                </div>
            </div>
        </div>
        <!-- /Footer Bottom Container -->


        <!--Back To Top-->
        <div class="back-to-top"><i class="fa fa-angle-up"></i></div>
    </footer>
    <!-- //end Footer Container -->

    </div>








    <!-- Include Libs & Plugins
	============================================ -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="js/themejs/libs.js"></script>
    <script type="text/javascript" src="js/unveil/jquery.unveil.js"></script>
    <script type="text/javascript" src="js/countdown/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js"></script>
    <script type="text/javascript" src="js/datetimepicker/moment.js"></script>
    <script type="text/javascript" src="js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>


    <!-- Theme files
	============================================ -->
    <script type="text/javascript" src="js/themejs/homepage.js"></script>

    <script type="text/javascript" src="js/themejs/so_megamenu.js"></script>
    <script type="text/javascript" src="js/themejs/addtocart.js"></script>
    <script type="text/javascript" src="js/themejs/application.js"></script>
    <!-- 		 -->


<script src="js/lgpd-cookie.js" type="module"></script>
<Lgpd-cookie text='Não capturamos nenhuma informação de dados sensíveis, somente cookies para melhor performance de nosso website!' />
</body>

<!--  demo.smartaddons.com/templates/html/emarket/product.html by AkrAm, Sat, 20 Apr 2019 20:00:19 GMT -->

</html>


<script type="text/javascript">
    $(document).scroll(function () {
    var y = $(this).scrollTop();
    
    if (y > 5){
        $('#show-megamenu').fadeOut();
    }else{
        $('#show-megamenu').fadeIn();
    }
        
     
    

});
</script>