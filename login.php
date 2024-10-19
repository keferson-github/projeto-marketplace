<?php include("cabecalho.php") ?>

<!-- Main Container  -->
        <div class="main-container container">
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="cadastrar">Cadastre-se</a></li>
                <li><a href="login">Entrar</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-12">
                    <div class="page-login">

                        <div class="account-border">
                            <div class="row">                               

                                <form  method="post" id="form_login">
                                    <div class="col-sm-6 customer-login">
                                        <div class="well">
                                          
                                            <div class="form-group">
                                                <label class="control-label " for="input-email">Seu E-mail</label>
                                                <input type="email" name="email" value="" id="input-email"
                                                    class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label " for="input-password">Senha</label>
                                                <input type="password" name="senha" value="" id="input-password"
                                                    class="form-control" />
                                            </div>

                                             <div align="center" id="mensagem"></div>
                                        </div>
                                        <div class="bottom-form" style="margin-top: -45px">
                                            <a href="" data-toggle="modal" data-target="#exampleModal" class="forgot">Recuperar Senha</a>
                                            <input id="btn_salvar" type="submit" value="Login" class="btn btn-default pull-right" />
                                        </div>

                                       
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- //Main Container -->



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 30000">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h3 class="modal-title" id="exampleModalLabel">Recuperar Senha</h3>        
    
      </div>
      <form method="post" id="form-recuperar">
      <div class="modal-body">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>         
       
       <br>
       <small><div id="mensagem-recuperar" align="center"></div></small>
      </div>
      <div class="modal-footer">  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>    
        <button type="submit" class="btn btn-primary">Recuperar Senha</button>
      </div>
  </form>
    </div>
  </div>
</div>


<?php include("rodape.php") ?>





<script type="text/javascript">
    

$("#form_login").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem').text('Logando...')
    $('#btn_salvar').hide();

    $.ajax({
        url: 'ajax/autenticar.php',
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Logado com Sucesso") {
               
                window.location="carrinho"; 
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



<script type="text/javascript">
    $("#form-recuperar").submit(function () {

        $('#mensagem-recuperar').text('Enviando!!');

        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "ajax/recuperar-senha.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {
                $('#mensagem-recuperar').text('');
                $('#mensagem-recuperar').removeClass()
                if (mensagem.trim() == "Recuperado com Sucesso") {
                                    
                    $('#email-recuperar').val('');
                    $('#mensagem-recuperar').addClass('text-success')
                    $('#mensagem-recuperar').text('Sua Senha foi enviada para o Email')         

                } else {

                    $('#mensagem-recuperar').addClass('text-danger')
                    $('#mensagem-recuperar').text(mensagem)
                }


            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>

