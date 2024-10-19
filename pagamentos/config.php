<?php
@session_start();
require("../sistema/conexao.php");


if($tipo_loja == 'MultiLojas'){
    $sessao_url = @$_SESSION['sessao_url'];

    $query2 = $pdo->query("SELECT * from clientes where url = '$sessao_url'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $id_loja = @$res2[0]['id'];

    $query = $pdo->query("SELECT * from config where id_loja = '$id_loja'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $linhas = @count($res);
    if($linhas > 0){
       
    $nome_sistema = $res[0]['nome'];
    $email_sistema = $res[0]['email'];
    $telefone_sistema = $res[0]['telefone'];
    $endereco_sistema = $res[0]['endereco'];
    $instagram_sistema = $res[0]['instagram'];
    $logo_sistema = $res[0]['logo'];
    $logo_rel = $res[0]['logo_rel'];
    $icone_sistema = $res[0]['icone'];
    $ativo_sistema = $res[0]['ativo'];
    $multa_atraso = $res[0]['multa_atraso'];
    $juros_atraso = $res[0]['juros_atraso'];
    $marca_dagua = $res[0]['marca_dagua'];
    $assinatura_recibo = $res[0]['assinatura_recibo'];
    $impressao_automatica = $res[0]['impressao_automatica'];
    $cnpj_sistema = $res[0]['cnpj'];
    $entrar_automatico = $res[0]['entrar_automatico'];
    $mostrar_preloader = $res[0]['mostrar_preloader'];
    $ocultar_mobile = $res[0]['ocultar_mobile'];
    $api_whatsapp = $res[0]['api_whatsapp'];
    $token_whatsapp = $res[0]['token_whatsapp'];
    $instancia_whatsapp = $res[0]['instancia_whatsapp'];
    $alterar_acessos = $res[0]['alterar_acessos'];
    $dados_pagamento = $res[0]['dados_pagamento'];
    $comissao_mk = $res[0]['comissao_mk'];
    $aprovar_produtos = $res[0]['aprovar_produtos'];
    $aprovar_loja = $res[0]['aprovar_loja'];
    $cadastro_loja = $res[0]['cadastro_loja'];
    $itens_paginacao = $res[0]['itens_paginacao'];
    $token_frete = $res[0]['token_frete'];
    $dias_pgto_comissao = $res[0]['dias_pgto_comissao'];
    $dias_excluir_pedidos = $res[0]['dias_excluir_pedidos'];
    $token_mp = $res[0]['token_mp'];
    $public_mp = $res[0]['public_mp'];
    $id_loja = $res[0]['id_loja'];

    $tel_whats = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);

    }
}

require("tokens.php");



$modoProducao = true; // Defina isso como true para usar credenciais de produção e false para usar credenciais de teste

if ($modoProducao) {
    $NOME_SITE = $nome_sistema; // Nome do seu site em produção
    $TOKEN_MERCADO_PAGO = $access_token; // Token do Mercado Pago em produção
    $TOKEN_MERCADO_PAGO_PUBLICO = $public_key; // Token público do Mercado Pago em produção (PUBLIC KEY)
    
} else {
    $NOME_SITE = "Meu pix (Modo Teste)"; // Nome do seu site em modo de teste
    $TOKEN_MERCADO_PAGO = "APP_USR-7645692252055791-101021-ba91ccf6cd290bc3115e3270a30edb1e-131939455"; // Token do Mercado Pago em teste
    $TOKEN_MERCADO_PAGO_PUBLICO = "TEST-da159e2a-4731-4fe4-abf0-5d890ab6c0e0"; // Token público do Mercado Pago em teste
    
}


$DESCRICAO_PAGAMENTO = "Pagamento Compra"; // OBRIGATÓRIO: DESCRIÇÃO PAGAMENTO O PAGAMENTO

$MSG_APOS_PAGAMENTO = "Recebemos seu pagamento.";

$URL_REDIRECIONAR = "Sim"; // LINK PARA DIRECIONAR 6 SEGUNDOS APÓS RECEBER O PAGAMENTO (Coloque Sim caso queira que ele redirecione para o comprovante)

$PAGAMENTO_MINIMO = "0"; // NÃO OBRIGATORIO: VALOR PARA PAGAMENTO MINIMO. EXEMPLO: 10,00 / 20,40

$EMAIL_NOTIFICACAO = ""; // OBRIGATÓRIO. SE NÃO FOR CONFIGURADO O CLIENTE DEVERÁ INFORMAR.

$CPF_PADRAO = ""; // É OBRIGATÓRIO O CPF. SE NÃO FOI CONFIGURADO AQUI O CLIENTE DEVERÁ INFORMAR. 

//$URL_NOTIFICACAO = $url_sistema."painel/pagamentos/webhook.php";  // URL AO HOSPDAR
$URL_NOTIFICACAO = "https://google.com";  // URL LOCAL

$VALOR_PADRAO = "5,00"; // EX: 20,00

$ATIVAR_PIX = "1";

$ATIVAR_BOLETO = "1";

$ATIVAR_CARTAO_CREDITO = "1";

$ATIVAR_CARTAO_DEBIDO = "1";