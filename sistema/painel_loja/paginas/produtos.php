<?php 
require_once("verificar.php");
$pag = 'produtos';

//verificar se ele tem a permissão de estar nessa página
if(@$produtos == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

if($tipo_loja == 'Marketplace'){
	$sql_filtro = " ";
}else{
	$sql_filtro = " where id_loja = '$id_usuario'";
}

?>

<div class="justify-content-between">
	<div class="left-content mt-2 mb-3">
		<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar <?php echo ucfirst($pag); ?></a>





		<div class="dropdown" style="display: inline-block;">                      
			<a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
			<div  class="dropdown-menu tx-13">
				<div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
					<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
				</div>
			</div>
		</div>


		<form action="rel/produtos_class.php" method="post" target="_blank" style="display: inline-block;">
		<div style="display: inline-block; position:absolute; right:10px; margin-bottom: 10px">
			<button style="width:40px" type="submit" class="btn btn-danger ocultar_mobile_app" title="Gerar Relatório"><i class="fa fa-file-pdf-o"></i></button>
		</div>


		<div style="display: inline-block;">							
			
			<select class="sel4" name="categoria" id="categoria_busca" style="width:200px" onchange="listarSubCategoriasBusca(); buscar()">
				<option value="">Categoria para Filtrar</option>
				<?php 
				$query = $pdo->query("SELECT * from categorias $sql_filtro order by nome asc");
				$res = $query->fetchAll(PDO::FETCH_ASSOC);
				$linhas = @count($res);
				if($linhas > 0){
					for($i=0; $i<$linhas; $i++){ ?>
						<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
					<?php } } ?>
				</select>								
			</div> 



			<div style="display: inline-block;">							
			
			<div id="listar_subcategorias_busca"></div>						
			</div> 

			<select class="form-select" style="width:200px; display: inline-block; margin-left: 20px" id="filtrar_estoque" name="filtrar_estoque" onchange="buscar()">
				<option value="">Todos</option>
				<option value="estoque">Estoque Baixo</option>
			</select>

		</form>

		</div>

	</div>


	<div class="row row-sm">
		<div class="col-lg-12">
			<div class="card custom-card">
				<div class="card-body" id="listar">

				</div>
			</div>
		</div>
	</div>

	<input type="hidden" id="ids">

	<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
					<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form_produtos">
					<div class="modal-body">

						<nav style="margin-bottom: 20px">
							<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<button class="nav-link active" id="nav-dados-tab" data-bs-toggle="tab" data-bs-target="#nav-dados" type="button" role="tab" aria-controls="nav-dados" aria-selected="true">Dados Produto</button>
								<button class="nav-link" id="nav-tamanho-tab" data-bs-toggle="tab" data-bs-target="#nav-tamanho" type="button" role="tab" aria-controls="nav-tamanho" aria-selected="false">Tamanho Embalagem</button>
								<button class="nav-link" id="nav-carac-tab" data-bs-toggle="tab" data-bs-target="#nav-carac" type="button" role="tab" aria-controls="nav-carac" aria-selected="false">Características</button>
								<button class="nav-link" id="nav-descricao-tab" data-bs-toggle="tab" data-bs-target="#nav-descricao" type="button" role="tab" aria-controls="nav-descricao" aria-selected="false">Descrição</button>

							</div>
						</nav>


						<div class="tab-content" id="nav-tabContent">

							<div class="tab-pane fade show active" id="nav-dados" role="tabpanel" aria-labelledby="nav-dados-tab" style="overflow: scroll; max-height:380px; scrollbar-width: thin; padding-right: 15px">

								<div class="row">
									<div class="col-md-12 mb-2">							
										<label>Nome</label>
										<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
									</div>
								</div>


								<div class="row">

									<div class="col-md-3 mb-2 col-6">							
										<label>Valor</label>
										<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor" required>							
									</div>

									<div class="col-md-3 mb-2 col-6">							
										<label>Valor Promocional</label>
										<input type="text" class="form-control" id="valor_promocional" name="valor_promocional" placeholder="Valor Promocional">							
									</div>


									<div class="col-md-3 mb-2 col-6">							
										<label>Estoque</label>
										<input type="number" class="form-control" id="estoque" name="estoque" placeholder="Estoque" required>							
									</div>

									<div class="col-md-3 mb-2 col-6">							
										<label>Nível Alerta</label>
										<input type="number" class="form-control" id="nivel_estoque" name="nivel_estoque" placeholder="Estoque" required>							
									</div>


								</div>


								<div class="row">

									<div class="col-md-5 mb-2">							
										<label>Categoria</label>
										<select class="sel2" name="categoria" id="categoria" style="width:100%" onchange="listarSubCategorias()">
											<?php 
											$query = $pdo->query("SELECT * from categorias $sql_filtro order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											$linhas = @count($res);
											if($linhas > 0){
												for($i=0; $i<$linhas; $i++){ ?>
													<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
												<?php } } ?>
											</select>								
										</div>


										<div class="col-md-5 mb-2">							
											<label>Sub Categoria</label>
											<div id="listar_subcategorias"></div>

										</div>

										<div class="col-md-2 mb-2">							
												<label>Promoção</label>
												<select class="form-select" name="promocao" id="promocao">
													<option value="Não">Não</option>
													<option value="Sim">Sim</option>								
												</select>						
											</div>


									</div>



									<div class="row">

										<div class="col-md-3 mb-2 col-6">							
											<label>Tipo Envio</label>
											<select class="sel2" name="tipo_envio" id="tipo_envio" style="width:100%">
												<?php 
												$query = $pdo->query("SELECT * from envios order by nome asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){ ?>
														<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>
													<?php } } ?>
												</select>								
											</div>

											<div class="col-md-2 mb-2">							
												<label>Valor Frete</label>
												<input type="text" class="form-control" id="valor_frete" name="valor_frete" placeholder="Se for fixo" >							
											</div>		


											<div class="col-md-2 mb-2">							
												<label>Nome Frete</label>
												<input type="text" class="form-control" id="nome_frete" name="nome_frete" placeholder="(Correios, Jetlog, Etc)" >								
											</div>


											<div class="col-md-3 mb-2">							
												<label>Imagem Capa</label>
												<input type="file" class="form-control" id="imagem" name="foto" onchange="carregarImg()">							
											</div>

											<div class="col-md-2">								
												<img width="60px" id="target">						

											</div>
											


										</div>

									</div>



									<div class="tab-pane fade show " id="nav-tamanho" role="tabpanel" aria-labelledby="nav-tamanho-tab">



										<div class="row">
											<div class="col-md-6 mb-2 col-6">							
												<label>Marca</label>
												<input type="text" class="form-control" id="marca" name="marca" placeholder="Marca do Produto">							
											</div>


											<div class="col-md-6 mb-2 col-6">							
												<label>Modelo</label>
												<input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo do Produto">							
											</div>
										</div>					

										<div class="row">
											<div class="col-md-3 mb-2 col-6">							
												<label>Peso</label>
												<input type="text" class="form-control" id="peso" name="peso" placeholder="100 G coloque 0.1">							
											</div>

											<div class="col-md-3 mb-2 col-6">							
												<label>largura CM</label>
												<input type="number" class="form-control" id="largura" name="largura" placeholder="Em CM">							
											</div>

											<div class="col-md-3 mb-2 col-6">							
												<label>Altura CM</label>
												<input type="number" class="form-control" id="altura" name="altura" placeholder="Em CM">							
											</div>

											<div class="col-md-3 mb-2 col-6">							
												<label>Comprimento CM</label>
												<input type="number" class="form-control" id="comprimento" name="comprimento" placeholder="Em CM">							
											</div>
										</div>


										<div class="row">

											<div class="col-md-12 mb-2">							
												<label>Palavras Chaves</label>
												<input type="text" class="form-control" id="palavras" name="palavras" placeholder="Palavra chave para buscas" >							
											</div>



										</div>		


										<div class="row">

											<div class="col-md-12 mb-2">							
												<label>Url Vídeo Youtube</label>
												<input type="text" class="form-control" id="video" name="video" placeholder="A url não pode ser incorporada, copie e cole direto" >							
											</div>



										</div>					


									</div>





									<div class="tab-pane fade show " id="nav-carac" role="tabpanel" aria-labelledby="nav-carac-tab">
										<div class="row">
											<div class="col-md-12 mb-2">						

												<textarea maxlength="255" class="textarea_menor" id="carac" name="carac" ></textarea>						
											</div>
										</div>

									</div>



									<div class="tab-pane fade show " id="nav-descricao" role="tabpanel" aria-labelledby="nav-descricao-tab">
										<div class="row">
											<div class="col-md-12 mb-2">						

												<textarea class="textarea_menor" id="area" name="descricao" ></textarea>						
											</div>
										</div>

									</div>





								</div>





								<input type="hidden" class="form-control" id="id" name="id">					

								<br>
								<small><div id="mensagem" align="center"></div></small>
							</div>
							<div class="modal-footer">       
								<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>




			<!-- Modal Dados -->
			<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
							<button id="btn-fechar-dados" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
						</div>

						<div class="modal-body">


							<div class="row">


								<div class="col-md-12">
									<div class="tile">
										<div class="table-responsive">
											<table id="" class="text-left table table-bordered">
												<tr>
													<td class="bg-warning alert-warning">Valor</td>
													<td><span id="valor_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning">Valor Promocional</td>
													<td><span id="valor_promo_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Estoque</td>
													<td><span id="estoque_dados"></span></td>
												</tr>


												<tr>
													<td class="bg-warning alert-warning w_150">Nível Alerta</td>
													<td><span id="nivel_dados"></span></td>
												</tr>
												<tr>
													<td class="bg-warning alert-warning w_150">Categoria</td>
													<td><span id="categoria_dados"></span></td>
												</tr>


												<tr>
													<td class="bg-warning alert-warning w_150">SubCategoria</td>
													<td><span id="subcategoria_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Tipo Envio</td>
													<td><span id="envio_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Valor Frete</td>
													<td><span id="frete_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Promoção</td>
													<td><span id="promocao_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Marca</td>
													<td><span id="marca_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Modelo</td>
													<td><span id="modelo_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Peso</td>
													<td><span id="peso_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Largura</td>
													<td><span id="largura_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Altura</td>
													<td><span id="altura_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Comprimento</td>
													<td><span id="comprimento_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Palavras</td>
													<td><span id="palavras_dados"></span></td>
												</tr>



												<tr>
													<td class="bg-warning alert-warning w_150">Ativo</td>
													<td><span id="ativo_dados"></span></td>
												</tr>


												<tr>
													<td class="bg-warning alert-warning w_150">Vendas</td>
													<td><span id="vendas_dados"></span></td>
												</tr>

												<tr>
													<td class="bg-warning alert-warning w_150">Data</td>
													<td><span id="data_dados"></span></td>
												</tr>

												<tr>
													<td align="center"><img src="" id="target_dados" width="200px"></td>
													<td>
														<a target="_blank" id="video_dados" class="thumb-video pull-left" href=""><i
                                        class="fa fa-youtube-play"></i> Ver Vídeo</a>
													</td>
												</tr>   




											</table>
										</div>
									</div>
								</div>





							</div>





						</div>

					</div>
				</div>
			</div>







			<!-- Modal Imagens -->
			<div class="modal fade" id="modalImagens" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_imagens"></span></h4>
							<button id="btn-fechar-imagens" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
						</div>

						<div class="modal-body">				

							<form id="form-fotos" method="POST" enctype="multipart/form-data" >
								<div class="row">
									<div class="col-md-9">
										<div class="col-md-12 form-group">
											<label>Imagens do Produto</label>
											<input type="file" class="form-control" id="imgproduto" name="imgproduto[]" multiple="multiple">
										</div>                           

									</div>

									<div class="col-md-3" style="margin-top: 25px">
										<button type="submit" id="btn-fotos" name="btn-fotos" class="btn btn-primary">Salvar</button>
									</div>


									<div class="col-md-12" id="listar-imagens">

									</div>



									<input type="hidden" class="form-control" name="id-imagens"  id="id-imagens">
								</div>

								<small>  
									<div align="center" id="mensagem_fotos" class="">

									</div>
								</small>   
							</form>

						</div>

					</div>
				</div>
			</div>







			<!-- Modal Grades-->
			<div class="modal fade" id="modalGrades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_nome_grades"></span></h4>
							<button id="btn-fechar-imagens" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
						</div>

						<div class="modal-body">
							<form id="form-grades">


								<div class="row">

									<div class="col-md-8">
										<div class="form-group">
											<label for="exampleInputEmail1">Descrição na hora da compra <small>(Até 70 Caracteres)</small></label>
											<input maxlength="70" type="text" class="form-control" id="texto" name="texto" placeholder="Descrição do item" required="">    
										</div> 	
									</div>

									<div class="col-md-4" style="margin-top: -5px">
										<div class="form-group">
											<label for="exampleInputEmail1">Tipo Item 

												<li class="dropdown head-dpdn2" style="display: inline-block;">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-info-circle text-primary"></i></big></a>

													<ul class="dropdown-menu" style="margin-left:-230px;">
														<li>
															<div class="notification_desc2">
																<p>
																	<b>Seletor Único</b><br>
																	<span class="text-muted" style="font-size: 12px">Você poderá selecionar apenas uma opção, exemplo, esse produto acompanha uma bebida, selecione a bebida desejada.</span>
																</p><br>

																<p>
																	<b>Seletor Múltiplos</b><br>
																	<span class="text-muted" style="font-size: 12px">Você poderá selecionar diversos itens dentro desta grade, exemplo de adicionais, 3 adicionais de bacon, 2 de cheddar, etc.</span>
																</p><br>


																<p>
																	<b>Apenas 1 Item de cada</b><br>
																	<span class="text-muted" style="font-size: 12px">Você pode selecionar várias opções porém só poderá inserir 1 item de cada, exemplo remoção de ingredientes, retirar cebola, retirar tomate, etc, será sempre uma unica seleção por cada item.</span>
																</p><br>

																<p>
																	<b>Seletor Variação</b><br>
																	<span class="text-muted" style="font-size: 12px">Você poderá selecionar apenas uma opção, exemplo, Tamanho Grande, Médio, etc, será mostrado em locais onde define a variação do produto.</span>
																</p><br>

															</div>
														</li>										
													</ul>
												</li>


											</label>
											<select class="form-select" id="tipo_item" name="tipo_item" style="width:100%;" > 

												<option value="Único">Seletor Único</option>
												<option value="Múltiplo">Seletor Múltiplos</option>	
												<option value="1 de Cada">1 item de Cada</option>	
												<option value="Variação">Variação Produto</option>

											</select>   

										</div> 	
									</div>	




								</div>	


								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label for="exampleInputEmail1">Descrição Comprovante <small>(Até 70 Caracteres)</small></label>
											<input maxlength="70" type="text" class="form-control" id="nome_comprovante" name="nome_comprovante" placeholder="Descrição do item no comprovante" required="">    
										</div> 	
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInputEmail1">Obrigatória</label>
											<select class="form-select" id="obrigatoria" name="obrigatoria" > 
												<option value="Não">Não</option>	
												<option value="Sim">Sim</option>
												

											</select>   

										</div> 	
									</div>	
								</div>

								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label for="exampleInputEmail1">Tipo Valor</label>
											<select class="form-select" id="valor_item" name="valor_item" style="width:100%;" > 
												<option value="Agregado">Valor Agregado</option>	
												<option value="Único">Valor Único Produto</option>
												<option value="Produto">Mesmo Valor do Produto</option>
												<option value="Sem Valor">Sem Valor</option>	

											</select>   

										</div> 	
									</div>	


									<div class="col-md-5">
										<div class="form-group">
											<label for="exampleInputEmail1">Limite de Seleção Itens</label>
											<input type="number" class="form-control" id="limite" name="limite" placeholder="Selecionar até x Itens" >    
										</div> 	
									</div>

									<div class="col-md-2" style="margin-top: 25px; padding:0">
										<button type="submit" class="btn btn-primary">Salvar</button>

									</div>
								</div>


							



								<input type="hidden" id="id_grades" name="id">

							</form>

							<br>
							<small><div id="mensagem-grades" align="center"></div></small>


							<hr>
							<div id="listar-grades"></div>
						</div>


					</div>
				</div>
			</div>








			<!-- Modal Itens-->
			<div class="modal fade" id="modalItens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_nome_itens"></span></h4>
							<button id="btn-fechar-imagens" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
						</div>

						<div class="modal-body">
							<form id="form-itens">


								<div class="row">

									<div class="col-md-9">
										<div class="form-group">
											<label for="exampleInputEmail1">Nome <small>(Até 70 Caracteres)</small></label>
											<input maxlength="70" type="text" class="form-control" id="texto_item" name="texto" placeholder="Descrição do item" required="">    
										</div> 	
									</div>	

									<div class="col-md-3">
										<div class="form-group">
											<label for="exampleInputEmail1">Cor</label>
											<input maxlength="20" type="text" class="form-control" id="cor" name="cor" placeholder="#000000">    
										</div> 	
									</div>		



								</div>	

								<div class="row">

									<div class="col-md-4">

										<div class="form-group">
											<label for="exampleInputEmail1">Valor</label>
											<input type="text" class="form-control" id="valor_do_item" name="valor" placeholder="Valor Se Houver" >    
										</div> 	
									</div>	



									<div class="col-md-5">
										<div class="form-group">
											<label for="exampleInputEmail1">Limite de Seleção Itens</label>
											<input type="number" class="form-control" id="limite_itens" name="limite" placeholder="Selecionar até x Itens" >    
										</div> 	
									</div>



									<div class="col-md-3" style="margin-top: 20px">
										<button type="submit" class="btn btn-primary">Salvar</button>

									</div>
								</div>



								<input type="hidden" id="id_item" name="id">
								<input type="hidden" id="id_item_produto" name="id_item_produto">

							</form>

							<br>
							<small><div id="mensagem-itens" align="center"></div></small>


							<hr>
							<div id="listar-itens"></div>
						</div>


					</div>
				</div>
			</div>



			<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
			<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

			<script type="text/javascript">var pag = "<?=$pag?>"</script>
			<script src="js/ajax.js"></script>

			<script type="text/javascript">
				$(document).ready(function() {
					listarSubCategorias();
					listarSubCategoriasBusca();

					$('.sel2').select2({
						dropdownParent: $('#modalForm')
					});

					$('.sel4').select2({
						//dropdownParent: $('#modalForm')
					});

				});
			</script>


			<script type="text/javascript">
				function listarSubCategorias(){
					var id = $("#categoria").val();
					$.ajax({
						url: 'paginas/' + pag + "/listar_subcategorias.php",
						method: 'POST',
						data: {id},
						dataType: "html",

						success:function(result){
							$("#listar_subcategorias").html(result);

						}
					});
				}

				function listarSubCategoriasBusca(){
					var id = $("#categoria_busca").val();
					$.ajax({
						url: 'paginas/' + pag + "/listar_subcategorias_busca.php",
						method: 'POST',
						data: {id},
						dataType: "html",

						success:function(result){
							$("#listar_subcategorias_busca").html(result);

						}
					});
				}
			</script>

			<script type="text/javascript">
				function carregarImg() {
					var target = document.getElementById('target');
					var file = document.querySelector("#imagem").files[0];

					var reader = new FileReader();

					reader.onloadend = function () {
						target.src = reader.result;
					};

					if (file) {
						reader.readAsDataURL(file);

					} else {
						target.src = "";
					}
				}
			</script>


			<script type="text/javascript">


				$("#form_produtos").submit(function () {

					event.preventDefault();
					nicEditors.findEditor('area').saveContent();
					nicEditors.findEditor('carac').saveContent();
					var formData = new FormData(this);

					$('#mensagem').text('Salvando...')
					$('#btn_salvar').hide();

					$.ajax({
						url: 'paginas/' + pag + "/salvar.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {
							$('#mensagem').text('');
							$('#mensagem').removeClass()
							if (mensagem.trim() == "Salvo com Sucesso") {

								$('#btn-fechar').click();
								listar();

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





			<!--AJAX PARA EXECUTAR A INSERÇÃO DAS DEMAIS FOTOS DO IMÓVEL -->
			<script type="text/javascript">


				$("#form-fotos").submit(function () {

					event.preventDefault();
					var formData = new FormData(this);

					$.ajax({
						url: 'paginas/' + pag + "/inserir_fotos.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {

							$('#mensagem_fotos').removeClass()

							if (mensagem.trim() == "Inserido com Sucesso") {
								$('#mensagem_fotos').addClass('text-success');
                    //$('#nome').val('');
                    //$('#cpf').val('');
                    //$('#btn-cancelar-fotos').click();
                    listarImagens();

                } else {

                	$('#mensagem_fotos').addClass('text-danger')

                }

                $('#mensagem_fotos').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
            	var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                	myXhr.upload.addEventListener('progress', function () {
                		/* faz alguma coisa durante o progresso do upload */
                	}, false);
                }
                return myXhr;
            }
        });
				});



			</script>

			<!--AJAX PARA LISTAR OS DADOS DAS IMAGENS DOS IMÓVEIS NA MODAL -->
			<script type="text/javascript">
				function listarImagens(){
					var id = $('#id-imagens').val();	
					$.ajax({
						url: 'paginas/' + pag + "/listar-imagens.php",
						method: 'POST',
						data: {id},
						dataType: "text",

						success:function(result){
							$("#listar-imagens").html(result);
						}
					});
				}

			</script>


			<script type="text/javascript">





				function excluirImagem(id){

					$.ajax({
						url: 'paginas/' + pag + "/excluir-imagem.php",
						method: 'POST',
						data: {id},
						dataType: "text",

						success: function (mensagem) {
							$('#mensagem_fotos').text('');
							$('#mensagem_fotos').removeClass()
							if (mensagem.trim() == "Excluído com Sucesso") {                
								listarImagens();                
							} else {

								$('#mensagem_fotos').addClass('text-danger')
								$('#mensagem_fotos').text(mensagem)
							}


						},      

					});
				}


			</script>





			<script type="text/javascript">


				$("#form-grades").submit(function () {

					var id_var = $('#id_grades').val()

					event.preventDefault();
					var formData = new FormData(this);

					$.ajax({
						url: 'paginas/' + pag + "/inserir-grades.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {
							$('#mensagem-grades').text('');
							$('#mensagem-grades').removeClass()
							if (mensagem.trim() == "Salvo com Sucesso") {

                //$('#btn-fechar-var').click();
                listarGrades(id_var); 
                limparCamposGrades();         

            } else {

            	$('#mensagem-grades').addClass('text-danger')
            	$('#mensagem-grades').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

				});




			</script>


			<script type="text/javascript">
				function limparCamposGrades(){

					$('#texto').val('');
					$('#limite').val('');	
					$('#nome_comprovante').val('');	


				}



				function listarGrades(id){
					$.ajax({
						url: 'paginas/' + pag + "/listar-grades.php",
						method: 'POST',
						data: {id},
						dataType: "html",

						success:function(result){
							$("#listar-grades").html(result);
							$('#mensagem-excluir-grades').text('');
						}
					});
				}







				function excluirGrades(id){
					var id_var = $('#id_grades').val()
					$.ajax({
						url: 'paginas/' + pag + "/excluir-grade.php",
						method: 'POST',
						data: {id},
						dataType: "text",

						success: function (mensagem) {            
							if (mensagem.trim() == "Excluído com Sucesso") {                
								listarGrades(id_var);                
							} else {
								$('#mensagem-excluir-grades').addClass('text-danger')
								$('#mensagem-excluir-grades').text(mensagem)
							}

						},      

					});
				}




				function ativarGrades(id, acao){
					var id_var = $('#id_grades').val()
					$.ajax({
						url: 'paginas/' + pag + "/mudar-status-grade.php",
						method: 'POST',
						data: {id, acao},
						dataType: "text",

						success: function (mensagem) {            
							if (mensagem.trim() == "Alterado com Sucesso") {                
								listarGrades(id_var);                
							} else {
								$('#mensagem-excluir-grades').addClass('text-danger')
								$('#mensagem-excluir-grades').text(mensagem)
							}

						},      

					});
				}




			</script>











			<script type="text/javascript">


				$("#form-itens").submit(function () {

					var id_var = $('#id_item').val()

					event.preventDefault();
					var formData = new FormData(this);

					$.ajax({
						url: 'paginas/' + pag + "/inserir-itens.php",
						type: 'POST',
						data: formData,

						success: function (mensagem) {
							$('#mensagem-itens').text('');
							$('#mensagem-itens').removeClass()
							if (mensagem.trim() == "Salvo com Sucesso") {

                //$('#btn-fechar-var').click();
                listarItens(id_var); 
                limparCamposItens();         

            } else {

            	$('#mensagem-itens').addClass('text-danger')
            	$('#mensagem-itens').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

				});




			</script>


			<script type="text/javascript">
				function limparCamposItens(){

					$('#texto_item').val('');
					$('#limite_itens').val('');	
					$('#valor_do_item').val('');
					$('#cor').val('');			

				}



				function listarItens(id){
					$.ajax({
						url: 'paginas/' + pag + "/listar-itens.php",
						method: 'POST',
						data: {id},
						dataType: "html",

						success:function(result){
							$("#listar-itens").html(result);
							$('#mensagem-excluir-itens').text('');
						}
					});
				}







				function excluirItens(id){
					var id_var = $('#id_item').val()
					$.ajax({
						url: 'paginas/' + pag + "/excluir-item.php",
						method: 'POST',
						data: {id},
						dataType: "text",

						success: function (mensagem) {            
							if (mensagem.trim() == "Excluído com Sucesso") {                
								listarItens(id_var);                
							} else {
								$('#mensagem-excluir-itens').addClass('text-danger')
								$('#mensagem-excluir-itens').text(mensagem)
							}

						},      

					});
				}




				function ativarItens(id, acao){
					var id_var = $('#id_item').val()
					$.ajax({
						url: 'paginas/' + pag + "/mudar-status-itens.php",
						method: 'POST',
						data: {id, acao},
						dataType: "text",

						success: function (mensagem) {            
							if (mensagem.trim() == "Alterado com Sucesso") {                
								listarItens(id_var);                
							} else {
								$('#mensagem-excluir-itens').addClass('text-danger')
								$('#mensagem-excluir-itens').text(mensagem)
							}

						},      

					});
				}




			</script>


<script type="text/javascript">
	function buscar(){
		var cat = $('#categoria_busca').val()
		var sub = $('#subcategoria_busca').val()
		var estoque = $('#filtrar_estoque').val()
		listar(cat, sub, estoque)
	}
</script>