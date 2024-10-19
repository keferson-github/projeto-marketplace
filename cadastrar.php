<?php include("cabecalho.php") ?>

 <!-- Main Container  -->
        <div class="main-container container">
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i></a></li>
                 <li><a href="login">Login</a></li>
                <li><a href="cadastrar">Cadastre-se</a></li>
               
            </ul>

            <div class="row">
                <div id="content" class="col-sm-12">
                   
                    <form method="post" id="form_cadastro"
                        class="form-horizontal account-register clearfix">
                        <fieldset id="account">
                            <legend>Dados Pessoais</legend>
                            <div class="form-group required" style="display: none;">
                                <label class="col-sm-2 control-label">Grupo de Clientes</label>
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="customer_group_id" value="1" checked="checked">
                                            Default
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-firstname">Nome</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nome" value="" placeholder="Nome Completo"
                                        class="form-control" required="">
                                </div>
                            </div>
                         
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" value="" placeholder="E-Mail" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-telephone">Telefone</label>
                                <div class="col-sm-10">
                                    <input type="tel" id="telefone" name="telefone" value="" placeholder="Telefone"
                                         class="form-control" required="">
                                </div>
                            </div>

                             <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name="senha" value="" placeholder="Senha" 
                                        class="form-control" required="">
                                </div>
                            </div>

                             <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">Confirmar Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name="conf_senha" value="" placeholder="Confirmar Senha" 
                                        class="form-control" required="">
                                </div>
                            </div>
                           
                        </fieldset>
                        <fieldset id="address">
                            <legend>Endereço</legend>
                             <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-company">CEP</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cep" id="cep" value="" placeholder="CEP" 
                                        class="form-control" required="" onblur="pesquisacep(this.value);">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-company">Rua</label>
                                <div class="col-sm-10">
                                    <input type="text" name="rua" id="endereco" value="" placeholder="Rua" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address-1">Número</label>
                                <div class="col-sm-10">
                                    <input type="text" name="numero" id="numero" value="" placeholder="Número"
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-2 control-label" for="input-address-1">Complemento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="complemento" id="complemento" value="" placeholder="Complemento"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address-2">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" name="bairro" id="bairro" value="" placeholder="Bairro"
                                         class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-city">Cidade</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cidade" id="cidade" value="" placeholder="Cidade" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-postcode">Estado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="estado" id="estado" value="" placeholder="Estado"
                                        class="form-control" required="">
                                </div>
                            </div>
                           
                            <div align="center" id="mensagem" style="text-align: center"></div>
                        </fieldset>

                        
                      
                       
                        <div class="buttons">
                            <div class="pull-right">Aceito os Termos de Serviços <a href="termos" class="agree iframe-link"><b>Ver Termos</b></a>
                                <input class="box-checkbox" type="checkbox" name="aceito" value="1" required> &nbsp;
                                <input id="btn_salvar" type="submit" value="Continue" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- //Main Container -->


<?php include("rodape.php") ?>


    <!-- Mascaras JS -->
<script type="text/javascript" src="sistema/painel/js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 





<script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";
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
    

$("#form_cadastro").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem').text('Salvando...')
    $('#btn_salvar').hide();

    $.ajax({
        url: 'ajax/cadastrar.php',
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                alert('Cadastrado com Sucesso!');
                window.location="login"; 

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