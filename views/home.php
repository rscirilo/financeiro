<head>
	<link rel="stylesheet" href="assets/css/template.css">
</head>

<body>
	<!-- <h1>Home</h1> -->
	<div class="container-obj">

		<!-- <h2>Sobre seus clientes</h2> -->
		<?php
		$count_clients = 0;
		foreach($quantidade_clientes as $client):
			$count_clients++;
		?>
		<?php endforeach;?> <!-- CONTAR CLIENTES -->

		<div class="container-obj-item">

		<p>Clientes ativos </br> <?php echo($count_clients);?> </p>

		<?php
		$count_emp = 0;
		$emprestado = 0;
		$recebido = 0;
		$lucro = 0;
		$mensalidade = 0;
		foreach($quantidade_emprestimos as $emprestimo):
			$emprestado = $emprestado + $emprestimo['valor_emprestimo'];
			$mensalidade = $mensalidade + $emprestimo['mensalidade'];
			$recebido = $recebido + $emprestimo['recebido'];
			$count_emp++;
		?>
		<?php endforeach;
		$lucro = ($mensalidade + $recebido) - $emprestado;

		?> <!-- CONTAR EMPRESTIMOS -->


		<p>Emprestimos ativos </br> <?php echo$count_emp; ?> </p>
	</div>
		<!-- PEGAR QUANTO FOI EMPRESTADO NO TOTAL, RECEBIDO NO TOTAL, CREDITO -->
		<h2>Sobre seus Emprestimos</h2>
		<div class="container-obj-item">
		<p class="">Total Emprestado:</br> <?php echo $emprestado?> </p>
		<p>Recebido no total:</br><?php echo $recebido + $mensalidade?> </p>
		<p class="lucro">Lucro total:</br><?php echo $lucro ?></p>
		</div>


		<h2>Emprestimos vencidos: </h2>
		<?php
		$data_atual = new DateTime(date('Y-m-d'));
		
		foreach($quantidade_emprestimos as $atrasado):
			$data_inicial = new DateTime(date('Y-m-d', strtotime($atrasado['data_emprestimo'])));

		$intervalo = $data_inicial->diff($data_atual);
		$diferencadias = $intervalo->format('%a');

		$quantidadedemesespagos = $atrasado['qtd_mensalidade'];

		$quantidadediasatraso = $quantidadedemesespagos * 30;

		//uma das condições do if
		$diastotal =  $diferencadias - $quantidadediasatraso ;
		if(($diferencadias > $quantidadediasatraso && $diastotal > 30) || ($quantidadedemesespagos == 0 && $diferencadias >= 30)){
			?>

			<div class="container-obj-item">
				<p>
					<?php
					$pula = "\n";
					  echo ' DIAS EM ATRASO: ', $diastotal;
					  echo ' VALOR: ', $atrasado['valor_emprestimo'];
					  ?>
				</p>
			</div>
		<?php } ?>
			
		<?php endforeach?>

		<!-- ESSA PARTE TA COMENTADA PARA ARRUMAR DEPOIS -->



		<!-- <h2>Perto do vencimento: </h2>
		<?php
		$data_atual = new DateTime(date('Y-m-d'));
		
		foreach($quantidade_emprestimos as $atrasado):
			$data_inicial = new DateTime(date('Y-m-d', strtotime($atrasado['data_emprestimo'])));

		$intervalo = $data_inicial->diff($data_atual);
		$diferencadias = $intervalo->format('%a');

		$quantidadedemesespagos = $atrasado['qtd_mensalidade'];

		$quantidadediasatraso = $quantidadedemesespagos * 30;

		//uma das condições do if
		$diastotal =  $diferencadias - $quantidadediasatraso ;
		if((($quantidadedemesespagos == 0) && ($diferencadias >= 20 && $diferencadias < 30))){
			?>

			<div class="container-obj-item">
				<p>
					<?php
					$pula = "\n";
					  echo ' FALTAM ', 30 - $diastotal, ' DIAS';
					  echo ' VALOR: ', $atrasado['valor_emprestimo'];
					  ?>
				</p>
			</div>
		<?php } ?>
			
		<?php endforeach?> -->

		<!-- FIM DO COMENTÁRIOD -->
	</div>
</body>