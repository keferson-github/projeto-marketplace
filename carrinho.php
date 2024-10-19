<?php 
include("cabecalho.php");
@session_start();
$id_cliente = @$_SESSION['id_cliente'];

$query = $pdo->query("SELECT * from carrinho where sessao = '$sessao_carrinho'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
    echo '<script>window.location="index"</script>';  
}


$query = $pdo->query("SELECT * from clientes_finais where id = '$id_cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
    $nome_cliente = $res[0]['nome'];
    $telefone_cliente = $res[0]['telefone'];
    $email_cliente = $res[0]['email'];
    $rua_cliente = $res[0]['rua'];
    $numero_cliente = $res[0]['numero'];
    $cep_cliente = $res[0]['cep'];
    $bairro_cliente = $res[0]['bairro'];
    $complemento_cliente = $res[0]['complemento'];
    $cidade_cliente = $res[0]['cidade'];
    $estado_cliente = $res[0]['estado'];
}

?>

<!-- Main Container  -->
<div class="main-container container">
    <ul class="breadcrumb">

    </ul>

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-12" >

            <div class="table-responsive form-group" id="listar_carrinho">

            </div>

            <div class="panel-group" id="accordion">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapse-coupon" class="accordion-toggle" data-toggle="collapse"
                            data-parent="#accordion" aria-expanded="true" id="col_cupom">Cupom de Desconto

                            <i class="fa fa-caret-down"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapse-coupon" class="panel-collapse collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <label class="col-sm-2 control-label" for="input-coupon">Código do Cupom</label>
                        <div class="input-group">
                            <input type="text" name="coupon" value="" placeholder="Código do Cupom"
                            id="codigo_cupom" class="form-control">
                            <span class="input-group-btn"><input onclick="cupom()" type="button" value="Aplicar Cupom"
                                id="button-coupon" data-loading-text="Carregando..."
                                class="btn btn-primary"></span>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if($id_cliente == ""){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapse-login" class="accordion-toggle collapsed" data-toggle="collapse"
                            data-parent="#accordion" aria-expanded="false" id="col_login">Faça Login

                            <i class="fa fa-caret-down"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapse-login" class="panel-collapse collapse" aria-expanded="true">
                    <div class="panel-body">
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
     <?php } ?>




        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#collapse-cadastro" class="accordion-toggle" data-toggle="collapse"
                    data-parent="#accordion" aria-expanded="false">
                    <?php if($id_cliente == ""){ ?>
                    Cadastre-se
                <?php }else{ ?>
                    Confirme seus Dados
                <?php } ?>

                    <i class="fa fa-caret-down"></i>
                </a>
            </h4>
        </div>
        <div id="collapse-cadastro" class="panel-collapse collapse" aria-expanded="false">
            <div class="panel-body">
             <div class="page-login">

                <div class="account-border">
                    <div class="row" style="margin:15px">                               

                         <form method="post" id="form_cadastro"
                        class="form-horizontal account-register clearfix">
                        <fieldset id="account">
                            <legend>Dados Pessoais</legend>
                            <div class="form-group required" style="display: none;">
                                <label class="col-sm-2 control-label">Dados Pessoais</label>
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
                                    <input type="text" name="nome" value="<?php echo @$nome_cliente ?>" placeholder="Nome Completo"
                                        class="form-control" required="">
                                </div>
                            </div>
                         
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" value="<?php echo @$email_cliente ?>" placeholder="E-Mail" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-telephone">Telefone</label>
                                <div class="col-sm-10">
                                    <input type="tel" id="telefone" name="telefone" value="<?php echo @$telefone_cliente ?>" placeholder="Telefone"
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
                            <legend>Endereço para Entrega</legend>
                             <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-company">CEP</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cep" id="cep" value="<?php echo @$cep_cliente ?>" placeholder="CEP" 
                                        class="form-control" required="" onblur="pesquisacep(this.value);">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-company">Rua</label>
                                <div class="col-sm-10">
                                    <input type="text" name="rua" id="endereco" value="<?php echo @$rua_cliente ?>" placeholder="Rua" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address-1">Número</label>
                                <div class="col-sm-10">
                                    <input type="text" name="numero" id="numero" value="<?php echo @$numero_cliente ?>" placeholder="Número"
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-2 control-label" for="input-address-1">Complemento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="complemento" id="complemento" value="<?php echo @$complemento_cliente ?>" placeholder="Complemento"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address-2">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" name="bairro" id="bairro" value="<?php echo @$bairro_cliente ?>" placeholder="Bairro"
                                         class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-city">Cidade</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cidade" id="cidade" value="<?php echo @$cidade_cliente ?>" placeholder="Cidade" 
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-postcode">Estado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="estado" id="estado" value="<?php echo @$estado_cliente ?>" placeholder="Estado"
                                        class="form-control" required="">
                                </div>
                            </div>
                           
                            <div align="center" id="mensagem" style="text-align: center"></div>
                            <input type="hidden" name="id" value="<?php echo @$id_cliente ?>">
                        </fieldset>

                        
                      
                        <?php if($id_cliente == ""){ ?>
                        <div class="buttons">
                            <div class="pull-right">Aceito os Termos de Serviços <a href="termos" class="agree iframe-link"><b>Ver Termos</b></a>
                                <input class="box-checkbox" type="checkbox" name="aceito" value="1" required> &nbsp;
                                <input id="btn_salvar" type="submit" value="Cadastrar" class="btn btn-primary">
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="buttons"> 
                        <div class="pull-right">                           
                                <input id="btn_salvar" type="submit" value="Editar Dados" class="btn btn-primary">
                          </div>    
                        </div>
                        <?php } ?>
                    </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





</div>

<div class="row">
    <div class="col-sm-4 col-sm-offset-8">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-right">
                        <strong>Total dos Itens:</strong>
                    </td>
                    <td class="text-right">R$ <span id="total_dos_itens"></span></td>
                </tr>
                <tr>
                    <td class="text-right">
                        <strong>Desconto:</strong>
                    </td>
                    <td class="text-right">R$ <span id="total_desconto_F">0</span></td>
                </tr>
                <tr>
                    <td class="text-right">
                        <strong>Frete:</strong>
                    </td>
                    <td class="text-right">R$ <span id="total_frete_carrinho_F">0</span></td>
                </tr>                                    
                <tr>
                    <td class="text-right">
                        <strong>Sub Total:</strong>
                    </td>
                    <td class="text-right">R$ <b><span id="total_subtotal" style="font-size: 17px"></span></b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="buttons">
    <div class="pull-left"><a href="index" class="btn btn-primary">Continuar Comprando</a></div>
    <div onclick="fecharVenda()" class="pull-right"><a href="#" class="btn btn-primary">Pagar</a></div>
</div>
<br>
</div>
<!--Middle Part End -->

</div>
</div>
<!-- //Main Container -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="margin-top: 150px">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><span id="nome_produto">Nome Produto</span></h4>
        <button style="margin-top: -15px" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <div id="listar_caracteristicas">

    </div>
</div>

</div>
</div>
</div>



<input type="hidden" id="total_carrinho">
<input type="hidden" id="total_frete_carrinho">
<input type="hidden" id="total_desconto">


<?php include("rodape.php") ?>


<script type="text/javascript">
    $(document).ready( function () {
        listarCarrinho();
    });
</script>

<script type="text/javascript">
    function listarCarrinho(){  
        $.ajax({
           url: 'ajax/listar_carrinho.php',
           method: 'POST',
           data: {},
           dataType: "html",

           success:function(result){
            $("#listar_carrinho").html(result);       
            
        }
    });
    }

</script>


<script type="text/javascript">
    function grades(id_carrinho){
        $.ajax({
           url: 'ajax/listar_grades.php',
           method: 'POST',
           data: {id_carrinho},
           dataType: "html",

           success:function(result){
            $("#listar_caracteristicas").html(result);       
            
        }
    });

        $('#exampleModal').modal('show')


    }
</script>





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


    <!-- Mascaras JS -->
<script type="text/javascript" src="sistema/painel/js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 




<script type="text/javascript">
    function cupom(){
        var codigo =  $('#codigo_cupom').val();
        var total_final =  $('#total_carrinho').val();
        var id_loja =  '<?=$id_usuario?>';

         $.ajax({
           url: 'ajax/cupom.php',
           method: 'POST',
           data: {codigo, total_final, id_loja},
           dataType: "html",

           success:function(result){               
                if(result.trim() == 'Inserido'){
                    $('#codigo_cupom').val('');
                    $('#col_cupom').click();
                    listarCarrinho();

                }else{
                    alert(result)
                }
            }
        });
    }


    function fecharVenda(){
        var id_cliente =  '<?=$id_cliente?>';
        var id_loja =  '<?=$id_usuario?>';

        if(id_cliente == ""){
            alert('Faça Login antes de Finalizar!');
            $('#col_login').click();
            return;
        }

        var total_final =  $('#total_carrinho').val();
        var total_desconto =  $('#total_desconto').val();
        var total_frete_carrinho =  $('#total_frete_carrinho').val();

        if(total_final <= 0){
            alert('O total não pode ser menor ou igual a zero!');
            return;
        }

        $.ajax({
           url: 'ajax/checkout.php',
           method: 'POST',
           data: {total_final, total_desconto, total_frete_carrinho, id_cliente, id_loja},
           dataType: "html",

           success:function(result){  
                var split = result.split('**');

                if(split[0].trim() == 'Inserido'){
                   window.open('pagamentos/index.php?id_conta='+split[1]);
                }else{
                    if(result.trim() == "Já foi efetuado este pedido!"){
                        window.location="index.php";
                        return;
                    }else{
                         alert(result)
                    }
                   
                }
            }
        });

    }
</script>