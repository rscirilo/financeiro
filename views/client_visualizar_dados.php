<head>
	<link rel="stylesheet" href=" <?php echo BASE_URL?>/assets/css/template.css">
</head>
<body>
	
<h1>Cliente - Informações</h1>
<h2>Dados Pessoais</h2>
	<p>Nome: <?php echo $client_info['name'];?></p>
	<p>Email: <?php echo $client_info['email']; ?></p>
	<p>Telefone: <?php echo $client_info['phone']; ?></p>
	<p>Estrelas: <?php echo $client_info['stars']; ?></p>
	<p>Endereço: <?php echo $client_info['address']; ?></p>
	<p>Número: <?php echo $client_info['address_number']; ?></p>
	<p>Complemento: <?php echo $client_info['address2']; ?></p>
	<p>Bairro: <?php echo $client_info['address_neighb']; ?></p>
	<p>Cidade/estado: <?php echo $client_info['address_city']; ?>/<?php echo $client_info['address_state']; ?></p>
	<p>País: <?php echo $client_info['address_country']; ?></p>
<h2>Observações</h2>
	<p><?php echo $client_info['internal_obs']; 
	if ($client_info['internal_obs'] == NULL){ ?>
		<p>Não há observações cadastradas</p>
	<?php }?>
</p>
<h2>Dados estatísticos</h2>
<?php 
$emprestimos_totais =0;
$emprestimos_devendo = 0;
$total_lucro = 0;
foreach($quantidade_emprestimos as $emprestimos):
	if($emprestimos['id_client'] == $client_info['id']){
		$emprestimos_totais = $emprestimos_totais + 1;
		$total_lucro = $total_lucro + (($emprestimos['recebido'] + $emprestimos['mensalidade']) - $emprestimos['valor_emprestimo']);
	}
	if($emprestimos['id_client'] == $client_info['id'] && $emprestimos['valor_emprestimo'] > 0){
		$emprestimos_devendo = $emprestimos_devendo + 1;
	}
endforeach;
	?>
	<p>Esse cliente já fez <?php echo $emprestimos_totais ?> empréstimos mas só tem <?php echo $emprestimos_totais - $emprestimos_devendo ?> pagos</p>
	<p>Seu lucro atual com esse cliente é <?php echo number_format($total_lucro,2,',','.')?></p>
</body>

