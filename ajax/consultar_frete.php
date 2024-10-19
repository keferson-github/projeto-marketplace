<?php
include("../sistema/conexao.php");
$cep = filter_var(@$_POST['cep'], @FILTER_SANITIZE_STRING);
$id = filter_var(@$_POST['id'], @FILTER_SANITIZE_STRING);

$cep = str_replace('-', '', $cep);

$query = $pdo->query("SELECT * from produtos where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
    
    $peso_produto = $res[0]['peso'];
    $largura_produto = $res[0]['largura'];
    $altura_produto = $res[0]['altura'];
    $comprimento_produto = $res[0]['comprimento'];    
    $loja_produto = $res[0]['loja'];
    

    $query = $pdo->query("SELECT * from usuarios where id = '$loja_produto'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $id_cliente = $res[0]['ref'];

    $query = $pdo->query("SELECT * from clientes where id = '$id_cliente'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $cep_origem = $res[0]['cep'];
    $cep_origem = str_replace('-', '', $cep_origem);


  }

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.melhorenvio.com.br/api/v2/me/shipment/calculate",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'from' => [
        'postal_code' => $cep_origem
    ],
    'to' => [
        'postal_code' => $cep
    ],
    'package' => [
        'height' => $altura_produto,
        'width' => $largura_produto,
        'length' => $comprimento_produto,
        'weight' => $peso_produto
    ]
  ]),
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Authorization: Bearer ".$token_frete,
    "Content-Type: application/json",
    "User-Agent: Aplicação"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $resp = json_decode($response);

   echo '<table class="table" style="font-size:13px">
   <tr style="font-weight:bold">
   <td></td>
   <td>Nome</td>
   <td>Valor</td>
   <td>Prazo</td>
   </tr>';

  foreach($resp as $index => $res){
    //if($res->name == 'PAC' || $res->name == 'SEDEX' || $res->name == 'éFácil'){
    $nome_frete = @$res->name;
    $valor_frete = @$res->price;
    $prazo_frete = @$res->delivery_time;
    $link_imagem = @$res->company->picture;
    $nome_companhia = @$res->company->name;

    if($valor_frete > 0){

  echo '
   <tr>
   ';
    echo '<td><input onchange="selecionarFrete('."'$nome_frete'".', '."'$valor_frete'".', '."'$prazo_frete'".', '."'$nome_companhia'".')" type="radio" class="form-check-input" name="frete_sel" id="frete_sel_'.@$res->name.'"></td>';
    echo '<td><img src="'.$link_imagem.'" width="55px"> '.@$res->name.'</td>';
    echo '<td style="color:red">'.@$res->price.'</td>';
    echo '<td>'.@$prazo_frete.' dias</td>';
  }
  '</tr>';

   }
  //}
 echo' </table>
  ';

}


?>

<script type="text/javascript">
  function selecionarFrete(nome, preco, prazo, companhia){
    $("#nome_frete").val(nome);
    $("#valor_frete").val(preco);
  }
</script>