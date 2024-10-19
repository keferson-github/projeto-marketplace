<?php include("cabecalho.php") ?>

 <!-- Main Container  -->
        <div class="main-container container">
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="index">Home</a></li>
                <li><a href="contatos">Contatos</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-12">
                                       
                    <div class="info-contact clearfix">
                        <div class="col-lg-4 col-sm-4 col-xs-12 info-store">
                            <div class="row">
                                
                                <address>
                                    <div class="address clearfix form-group">
                                        <div class="icon">
                                            <i class="fa fa-envelope-o"></i>
                                        </div>
                                        <div class="text"><?php echo $email_sistema ?>
                                        </div>
                                    </div>
                                    <div class="phone form-group">
                                        <div class="icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="text">Telefone : <?php echo $telefone_sistema ?></div>
                                    </div>
                                    <div class="comment">
                                        Entre em contato conosco para tirar suas dúvidas ou reportar qualquer tipo de problema.
                                    </div>
                                </address>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-xs-12 contact-form">
                            <form id="form_email" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <fieldset>
                                    
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-name">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nome" value="" id="input-name"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email" value="" id="input-email"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-enquiry">Mensagem</label>
                                        <div class="col-sm-10">
                                            <textarea name="mensagem" rows="10" id="input-enquiry"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <button id="btn_salvar" class="btn btn-default buttonGray" type="submit">
                                            <span>Enviar</span>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="email_sistema" value="<?php echo $email_sistema ?>">
                                <div id="mensagem" align="center"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //Main Container -->


<?php include("rodape.php") ?>


<script type="text/javascript">
    

$("#form_email").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem').text('Enviando...')
    $('#btn_salvar').hide();

    $.ajax({
        url: 'ajax/email_contato.php',
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                alert('Enviado com Sucesso!');
                window.location="contatos"; 

                $('#mensagem').text('')          

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }

            $('#btn_salvar').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


</script>
