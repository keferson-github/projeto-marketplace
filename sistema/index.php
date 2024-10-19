<?php 
require_once("conexao.php");
@session_start();

$query = $pdo->query("SELECT * from usuarios where nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
$senha = '123';
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
if($linhas == 0){
	$pdo->query("INSERT INTO usuarios SET nome = '$nome_sistema', email = '$email_sistema', senha_crip = '$senha_crip', nivel = 'Administrador', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = '$telefone_sistema', data = curDate(), mostrar_registros = 'Sim' ");
}


//criar o banner padrao
$query = $pdo->query("SELECT * from banners");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO banners SET banner1 = 'sem-foto.png', cliente1 = '0', valor1 = '0', banner_padrao1 = 'sem-foto.png', banner2 = 'sem-foto.png', cliente2 = '0', valor2 = '0', banner_padrao2 = 'sem-foto.png', banner3 = 'sem-foto.png', cliente3 = '0', valor3 = '0', banner_padrao3 = 'sem-foto.png'  ");
}


//forma de envio valor fixo
$query = $pdo->query("SELECT * from envios where nome = 'Valor Fixo'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO envios SET nome = 'Valor Fixo'");
}

//forma de envio valor Melhor Envio
$query = $pdo->query("SELECT * from envios where nome = 'Melhor Envio'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO envios SET nome = 'Melhor Envio'");
}

 ?>



<!DOCTYPE html>
<html lang="pt-BR">
	
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
		<!-- META DATA -->
        <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Fluxo Comunicação Inteligente">
		<meta name="Author" content="Samuel Lima">
		<meta name="Keywords" content="fluxo, comunicacao, inteligente, marketing, whatsapp"/>
		
		<!-- TITLE -->
		<title><?php echo $nome_sistema ?></title>


		<link rel="icon" href="img/icone.png" type="image/x-icon"/>
		<link href="assets/css/icons.css" rel="stylesheet">
		<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/custom.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<link href="assets/css/style-transparent.css" rel="stylesheet">
		<link href="assets/css/skin-modes.css" rel="stylesheet" />
		<link href="assets/css/animate.css" rel="stylesheet">


		

	</head>


		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="img/loader.gif" class="loader-img loader loader_mobile" alt="">
		</div>
		<!-- /GLOBAL-LOADER -->

	<body class="ltr error-page1 bg-primary" id="pagina">


		<div class="square-box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>


		<div class="page " >


			<div class="page-single ">
				<div class="container margem_250_web">
					<div class="row ">
						<div class=" col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin ">
								 <!-- Demo content-->
								 <div class="main-card-signin d-md-flex">
									 <div class="wd-100p"><div class="d-flex mb-4 justify-content-center"><a href="../index"><img src="img/logo.png" class="sign-favicon" alt="logo" width="130px"></a></div>
										 <div class="">
											<div class="main-signup-header">
											
												<div class="panel panel-primary">
							
												   <div class="panel-body tabs-menu-body border-0 p-3">			

												   <?php
			if(isset($_SESSION['msg'])){

				echo '<div class="alert alert-danger mg-b-0 mb-3 alert-dismissible fade show" role="alert">
											<strong><span class="alert-inner--icon"><i class="fe fe-slash"></i></span></strong> '.$_SESSION['msg'].'!
											<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
										</div>';

				unset($_SESSION['msg']);
			}
		?>		


						
														
															   <form method="post" action="autenticar.php">
																   <div class="form-group">
																	   <label>Usuário</label> 
																	   <input class="form-control" name="usuario" placeholder="Digite seu Usuário" id="usuario" type="text" required value="">
																   </div>
																   <div class="form-group">
													              <label class="control-label">Senha</label>           
													              <input id="password-field" type="password" class="form-control" name="senha" placeholder="Digite sua Senha" required value="">
													              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>        
          														</div>

          														 <div class="form-group" style="margin-left: 22px">
          														<span><input class="form-check-input" type="checkbox" value="Sim" name="salvar" id="salvar_acesso"></span>
          														 	<span class="control-label" style="margin-top:5px">Salvar Acesso</span>         							 	
          														 </div>

																   <button class="btn btn-primary btn-block">Entrar no Sistema</button>
																
																</form>													
													  
												   </div>
											   </div>

												<div class="main-signin-footer text-center mt-3">

													<p><a href="" class="mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastrar" style="font-weight: 300; text-decoration: underline">Cadastre-Se?</a></p>

													<p><a href="" class="mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Esqueceu sua Senha?</a></p>
												</div>
											</div>
										 </div>
									 </div>
								 </div>
							 </div>
						 </div>
					</div>
				</div>
			</div>
		</div>





	</body>

</html>

				


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true" class="text-white">&times;</span></button>
    
      </div>
      <form method="post" id="form-recuperar">
      <div class="modal-body">
        	<label for="recipient-name" class="col-form-label">E-mail:</label>
        	<input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>        	
       
       <br>
       <small><div id="mensagem-recuperar" align="center"></div></small>
      </div>
      <div class="modal-footer">  
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>    
        <button type="submit" class="btn btn-primary">Recuperar Senha</button>
      </div>
  </form>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalCadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Cadastre-se como Loja</h5>
        <button id="btn_fechar_cadastro" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true" class="text-white">&times;</span></button>
    
      </div>
      <form method="post" id="form-cliente">
      <div class="modal-body">
        	
					<div class="row">
						<div class="col-md-6 mb-2 col-6">							
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-3 col-6">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone">							
						</div>		

						<div class="col-md-3 mb-2">							
							<label>Nascimento</label>
							<input type="date" class="form-control" id="data_nasc" name="data_nasc" placeholder="" >							
						</div>

						
					</div>


					<div class="row">

						<div class="col-md-3 mb-2 col-6">							
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
								<option value="Física">Física</option>
								<option value="Jurídica">Jurídica</option>
							</select>							
						</div>		

						<div class="col-md-3 mb-2 col-6">							
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF/CNPJ" >							
						</div>


						<div class="col-md-3">							
							<label>RG</label>
							<input type="text" class="form-control" id="rg" name="rg" placeholder="RG" >							
						</div>		

							<div class="col-md-3">							
							<label>Url da Loja</label>
							<input type="text" class="form-control" id="url" name="url" placeholder="Ex: lojahugo" >							
						</div>				


						
					</div>


					<div class="row">
						
						<div class="col-md-4">							
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>							
						</div>

							<div class="col-md-4">							
							<label>Senha</label>
							<input type="password" class="form-control" name="senha" placeholder="Senha" required>							
						</div>

							<div class="col-md-4">							
							<label>Confirmar Senha</label>
							<input type="password" class="form-control"  name="conf_senha" placeholder="Cofirmar Senha" required>							
						</div>
					</div>

					<div class="row">

						<div class="col-md-2 mb-2">							
							<label>CEP</label>
							<input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" onblur="pesquisacep(this.value);">							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Rua</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" >							
						</div>

						<div class="col-md-2 mb-2">							
							<label>Número</label>
							<input type="text" class="form-control" id="numero" name="numero" placeholder="Número" >							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Se houver" >							
						</div>



					</div>


					<div class="row">

						<div class="col-md-4 mb-2">							
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" >							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" >							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Estado</label>
							<select class="form-select" id="estado" name="estado">
							<option value="">Selecionar</option>
							<option value="AC">Acre</option>
							<option value="AL">Alagoas</option>
							<option value="AP">Amapá</option>
							<option value="AM">Amazonas</option>
							<option value="BA">Bahia</option>
							<option value="CE">Ceará</option>
							<option value="DF">Distrito Federal</option>
							<option value="ES">Espírito Santo</option>
							<option value="GO">Goiás</option>
							<option value="MA">Maranhão</option>
							<option value="MT">Mato Grosso</option>
							<option value="MS">Mato Grosso do Sul</option>
							<option value="MG">Minas Gerais</option>
							<option value="PA">Pará</option>
							<option value="PB">Paraíba</option>
							<option value="PR">Paraná</option>
							<option value="PE">Pernambuco</option>
							<option value="PI">Piauí</option>
							<option value="RJ">Rio de Janeiro</option>
							<option value="RN">Rio Grande do Norte</option>
							<option value="RS">Rio Grande do Sul</option>
							<option value="RO">Rondônia</option>
							<option value="RR">Roraima</option>
							<option value="SC">Santa Catarina</option>
							<option value="SP">São Paulo</option>
							<option value="SE">Sergipe</option>
							<option value="TO">Tocantins</option>
							<option value="EX">Estrangeiro</option>
						</select>												
					</div>

					
				</div>


					<div class="row">
						<div class="col-md-12 mb-2">							
							<label>Chave Pix</label>
							<input type="text" class="form-control" id="pix" name="pix" placeholder="Chave Pix" >							
						</div>
				</div>


				<input type="hidden" class="form-control" id="id" name="id">	
								

				<br>
				<small><div id="mensagem" align="center"></div></small>
      </div>
      <div class="modal-footer">  
       
        <button id="btn_salvar_cliente" type="submit" class="btn btn-primary">Salvar</button>
      </div>
  </form>
    </div>
  </div>
</div>


<form action="autenticar.php" method="post" style="display:none">
	<input type="text" name="id" id="id_usua">
	<input type="text" name="pagina" id="pagina_salva">
	<button type="submit" id="btn_auto"></button>
</form>


<script src="assets/plugins/jquery/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/js/eva-icons.min.js"></script>        
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/themecolor.js"></script>
        <script src="assets/js/custom.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		
		var email_usuario = localStorage.email_usu;
		var senha_usuario = localStorage.senha_usu;
		var id_usuario = localStorage.id_usu;
		var pagina = localStorage.pagina;

		var redirecionar = "<?=$entrar_automatico?>";

		if(id_usuario != "" && id_usuario != undefined && redirecionar == 'Sim'){
			$('#pagina').hide();
			$('#id_usua').val(id_usuario);
			$('#pagina_salva').val(pagina);
			$('#btn_auto').click();
		}else{
			$('#pagina').show();
		}

		if(email_usuario != "" && email_usuario != undefined){
			$('#salvar_acesso').prop('checked', true);
		}else{
			$('#salvar_acesso').prop('checked', false);
		}

		$('#usuario').val(email_usuario);
		$('#password-field').val(senha_usuario);

	});
</script>

 
<script>
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>




<script type="text/javascript">
	$("#form-recuperar").submit(function () {

		$('#mensagem-recuperar').text('Enviando!!');

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "recuperar-senha.php",
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
	function mudarPessoa(){
		var pessoa = $('#tipo_pessoa').val();
		if(pessoa == 'Física'){
			$('#cpf').mask('000.000.000-00');
			$('#cpf').attr("placeholder", "Insira CPF");
		}else{
			$('#cpf').mask('00.000.000/0000-00');
			$('#cpf').attr("placeholder", "Insira CNPJ");
		}
	}
</script>



<script type="text/javascript">
	
$("#form-cliente").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $('#mensagem').text('Salvando...')
    $('#btn_salvar_cliente').hide();

    $.ajax({
        url: 'painel/paginas/clientes/salvar.php',
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

            	alert(mensagem)
                $('#btn_fechar_cadastro').click();                

                $('#mensagem').text('')          

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }

            $('#btn_salvar_cliente').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>


	<!-- Mascaras JS -->
<script type="text/javascript" src="painel/js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


