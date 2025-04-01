<head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>

<body>
    <div class="container-obj">
	<?php
		$count_clients = 0;
		foreach($quantidade_clientes as $client):
			$count_clients++;
		?>
		<?php endforeach;?> <!-- CONTAR CLIENTES -->
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
        <!-- Informações sobre os clientes -->
        <div class="stats-container">
            <div class="stats-item">
                <p class="stats-title">Clientes Ativos</p>
                <p class="stats-value"><?php echo $count_clients; ?></p>
            </div>

            <!-- Informações sobre os empréstimos -->
            <div class="stats-item">
                <p class="stats-title">Empréstimos Ativos</p>
                <p class="stats-value"><?php echo $count_emp; ?></p>
            </div>
        </div>

        <!-- Detalhes sobre empréstimos -->
        <h2>Sobre seus Empréstimos</h2>
        <div class="stats-container">
            <div class="stats-item">
                <p class="stats-title">Total Emprestado:</p>
                <p class="stats-value"><?php echo number_format($emprestado, 2, ',', '.'); ?></p>
            </div>
            <div class="stats-item">
                <p class="stats-title">Recebido no Total:</p>
                <p class="stats-value"><?php echo number_format($recebido + $mensalidade, 2, ',', '.'); ?></p>
            </div>
            <div class="stats-item lucro <?php echo ($lucro >= 0) ? 'positivo' : 'negativo'; ?>">
				<p class="stats-title">Lucro Total:</p>
				<p class="stats-value"><?php echo number_format($lucro, 2, ',', '.'); ?></p>
			</div>
        </div>

        <!-- Empréstimos Vencidos -->
        <h2>Empréstimos Vencidos:</h2>
		<div class="stats-container">
			<?php
			$data_atual = new DateTime(date('Y-m-d'));
			$tem_emprestimos_atrasados = false; // Variável de controle

			foreach ($quantidade_emprestimos as $atrasado):
				$data_inicial = new DateTime(date('Y-m-d', strtotime($atrasado['data_emprestimo'])));
				$intervalo = $data_inicial->diff($data_atual);
				$diferencadias = $intervalo->format('%a');
				$quantidadedemesespagos = $atrasado['qtd_mensalidade'];
				$quantidadediasatraso = $quantidadedemesespagos * 30;

				$diastotal = $diferencadias - $quantidadediasatraso;

				if (($diferencadias > $quantidadediasatraso && $diastotal > 30) || ($quantidadedemesespagos == 0 && $diferencadias >= 30)) {
					$tem_emprestimos_atrasados = true; // Se encontrar um empréstimo atrasado, marca a variável como true
					?>
					<div class="stats-item atrasado">
						<p>DIAS EM ATRASO: <?php echo $diastotal; ?></p>
						<p>VALOR: <?php echo number_format($atrasado['valor_emprestimo'], 2, ',', '.'); ?></p>
					</div>
					<?php
				}
			endforeach;

			if (!$tem_emprestimos_atrasados): // Se não houver nenhum empréstimo atrasado
				?>
				<div class="no-loans">
					<p>Nenhum empréstimo em atraso.</p>
				</div>
			<?php endif; ?>
		</div>
        

    </div>
</body>
