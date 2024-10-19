<?php 
$data_atual = date('Y-m-d');
if(@$id_pedido != ""){
	$query2 = $pdo->query("SELECT * from vendas where id = '$id_pedido' order by id desc limit 1");
}else{
	$query2 = $pdo->query("SELECT * from vendas where ref_api = '$ref_api' order by id desc limit 1");
}

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$sessao = $res2[0]['sessao'];
$cliente = $res2[0]['cliente'];
$valor = $res2[0]['valor']; 
$desconto = $res2[0]['desconto'];
$frete = $res2[0]['frete'];
$data = $res2[0]['data'];
$hora = $res2[0]['hora'];
$ref_api = $res2[0]['ref_api'];
$forma_pgto = $res2[0]['forma_pgto'];
$pago = $res2[0]['pago'];   
$id = $res2[0]['id'];

$dataF = implode('/', array_reverse(@explode('-', $data)));

$valorF = @number_format($valor, 2, ',', '.');


//recuperar dados cliente
$query2 = $pdo->query("SELECT * from clientes_finais where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas2 = @count($res2);
if($linhas2 > 0){
    $nome_cliente = $res2[0]['nome'];
    $telefone_cliente = $res2[0]['telefone'];
    $email_cliente = $res2[0]['email'];   
}

//aprovar a venda
$pdo->query("UPDATE vendas set pago = 'Sim' where ref_api = '$ref_api'");

//lançar o valor da venda nas contas a receber
$pdo->query("INSERT INTO receber SET descricao = 'Nova Venda', cliente = '$cliente', valor = '$valor', vencimento = curDate(), data_pgto = curDate(), data_lanc = curDate(), forma_pgto = '$forma_pgto', frequencia = '0', arquivo = 'sem-foto.png', subtotal = '$valor', usuario_lanc = '0', usuario_pgto = '0', pago = 'Sim', referencia = 'Venda', caixa = '0', hora = curTime() ");

//atualiza os dados do carrinho para pago
$query = $pdo->query("UPDATE carrinho SET pago = 'Sim' where venda = '$id'");


//lançar a comissão dos lojistas
$query2 = $pdo->query("SELECT * from carrinho where venda = '$id' order by id asc");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas2 = @count($res2);
if($linhas2 > 0){
	for($i2=0; $i2<$linhas2; $i2++){
	$id_car = $res2[$i2]['id'];
	$produto = $res2[$i2]['produto'];
	$total = $res2[$i2]['total'];
	$frete = $res2[$i2]['frete'];
	$valor_comissao = $total - ($total * $comissao_mk / 100) + $frete;
	$venc_comissao = date('Y/m/d', strtotime("+$dias_pgto_comissao days",strtotime($data_atual)));
	$quantidade_item = $res2[$i2]['quantidade'];



	$query3 = $pdo->query("SELECT * from produtos where id = '$produto'");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			$linhas3 = @count($res3);
			if($linhas3 > 0){
				$nome_produto = $res3[0]['nome'];
				$loja = $res3[0]['loja'];
				$estoque_antigo = $res3[0]['estoque'];
				$vendas_produto = $res3[0]['vendas'];
				$nome_produtoF = mb_strimwidth($nome_produto, 0, 17, "...");
				$descricao_conta = 'Comissão: '.$nome_produtoF;

				$novo_estoque = $estoque_antigo - $quantidade_item;
				$vendas_produto += $quantidade_item;

				$pdo->query("UPDATE produtos SET estoque = '$novo_estoque', vendas = '$vendas_produto' where id = '$produto'");

				//insert nas contas a pagar
				$query = $pdo->query("INSERT INTO pagar SET descricao = '$descricao_conta', fornecedor = '0', funcionario = '0', loja = '$loja', valor = '$valor_comissao', vencimento = '$venc_comissao',  data_lanc = curDate(), frequencia = '0', arquivo = 'sem-foto.png', subtotal = '$valor_comissao', usuario_lanc = '0', pago = 'Não', referencia = 'Comissão', id_ref = '$id_car' ");		
			}

	}
}


$link_painel_cliente = $url_sistema.'sistema/painel_final';

//disparos do pedido para o cliente
if($api_whatsapp != 'Não' and $telefone_cliente != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_cliente);
	$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '🤩 _Olá '.$nome_cliente.' Obrigado pela Compra!!_ %0A%0A';

	$mensagem_whatsapp .= '*Detalhes da Compra* %0A%0A';
	$mensagem_whatsapp .= '*Id Pedido:* '.$id.' %0A';
	$mensagem_whatsapp .= '*Total:* R$'.$valorF.' %0A';
	$mensagem_whatsapp .= '*Data:* '.$dataF.' %0A%0A';

	$mensagem_whatsapp .= '_Itens da Compra_';

	$query2 = $pdo->query("SELECT * from carrinho where venda = '$id' order by id asc");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$linhas2 = @count($res2);
	if($linhas2 > 0){
			for($i2=0; $i2<$linhas2; $i2++){		
			
			$produto = $res2[$i2]['produto'];
			$quantidade = $res2[$i2]['quantidade'];		
			$id_car = $res2[$i2]['id'];		

			$query3 = $pdo->query("SELECT * from produtos where id = '$produto'");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			$linhas3 = @count($res3);
			if($linhas3 > 0){
				$nome_produto = $res3[0]['nome'];				
			}

			$mensagem_whatsapp .= '%0A✅ '.$quantidade.' '.$nome_produto.'%0A';

			$grades = '';
	//grade do produto
		$query3 = $pdo->query("SELECT * from temp where carrinho = '$id_car' order by id asc");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas3 = @count($res3);
		if($linhas3 > 0){
			for($i3=0; $i3<$linhas3; $i3++){
				$id_temp = $res3[$i3]['id'];
				$id_grade = $res3[$i3]['grade'];
				$id_item = $res3[$i3]['id_item'];

				$query4 = $pdo->query("SELECT * from grades where id = '$id_grade' order by id asc");
				$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
				$nome_grade = $res4[0]['nome_comprovante'];

				$query4 = $pdo->query("SELECT * from itens_grade where id = '$id_item' order by id asc");
				$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
				$nome_item = $res4[0]['texto'];

				$grade_produto = '*'.$nome_grade.'*: '.$nome_item.'%0A';
				$grades .= $grade_produto;

			}

		}

		$mensagem_whatsapp .= $grades;



			}

		}

		$mensagem_whatsapp .= '%0A';
		$mensagem_whatsapp .= '_Ver detalhamento painel cliente_ %0A';
		$mensagem_whatsapp .= $link_painel_cliente;

	require('texto.php');
}

//enviar email para o cliente
if(@$email_cliente != ''){
	$url_logo = $url_sistema.'sistema/img/logo.png';
	$destinatario = $email_cliente;
	$assunto = 'Compra Aprovada '. $nome_sistema;
	$mensagem_email = 'Olá '.$nome_cliente.' obrigado por comprar conosco, acesse seu painel para ver o detalhamento da compra! <br>';
	
	$mensagem_email .= 'Url Acesso: <br><a href="'.$link_painel_cliente.'">'.$link_painel_cliente. '</a><br><br>';
	
	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
	require('disparar_email.php');
}







//disparos do pedido para a loja
if($api_whatsapp != 'Não'){	

	$query2 = $pdo->query("SELECT * from carrinho where venda = '$id' order by id asc");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$linhas2 = @count($res2);
	if($linhas2 > 0){
			for($i2=0; $i2<$linhas2; $i2++){		
			
			$produto = $res2[$i2]['produto'];
			$quantidade = $res2[$i2]['quantidade'];	
			$nome_frete = $res2[$i2]['nome_frete'];		
			$id_car = $res2[$i2]['id'];		

			$query3 = $pdo->query("SELECT * from produtos where id = '$produto'");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			
				$nome_produto = $res3[0]['nome'];
				$loja = $res3[0]['loja'];

				$query3 = $pdo->query("SELECT * from usuarios where id = '$loja'");
				$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
				$telefone_loja = $res3[0]['telefone'];
				$email_loja = $res3[0]['email'];
				$nome_loja = $res3[0]['nome'];

				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_loja);				
				$mensagem_whatsapp = '🤩 *Nova Venda - Pedido '.$id.'* %0A';
				$mensagem_whatsapp .= '✅ '.$quantidade.' '.$nome_produto.'%0A';

				$grades = '';
	//grade do produto
		$query3 = $pdo->query("SELECT * from temp where carrinho = '$id_car' order by id asc");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas3 = @count($res3);
		if($linhas3 > 0){
			for($i3=0; $i3<$linhas3; $i3++){
				$id_temp = $res3[$i3]['id'];
				$id_grade = $res3[$i3]['grade'];
				$id_item = $res3[$i3]['id_item'];

				$query4 = $pdo->query("SELECT * from grades where id = '$id_grade' order by id asc");
				$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
				$nome_grade = $res4[0]['nome_comprovante'];

				$query4 = $pdo->query("SELECT * from itens_grade where id = '$id_item' order by id asc");
				$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
				$nome_item = $res4[0]['texto'];

				$grade_produto = '*'.$nome_grade.'*: '.$nome_item.'%0A';
				$grades .= $grade_produto;

			}

		}
				$mensagem_whatsapp .= $grades;
				$mensagem_whatsapp .= '%0A*Envio:* '.$nome_frete.'%0A';
				if($telefone_loja != ""){
					require('texto.php');
				}
				


				//enviar email para a loja
				if(@$email_loja != ''){
					$url_logo = $url_sistema.'sistema/img/logo.png';
					$destinatario = $email_loja;
					$assunto = 'Nova Venda Efetuada '. $nome_sistema;
					$mensagem_email = 'Olá '.$nome_loja.' você acaba de vender um novo item ('.$nome_produto.') <br>';				
										
					$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
					require('disparar_email.php');
				}


			}

		}		

	
}




?>