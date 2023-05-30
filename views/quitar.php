<?php if(isset($error_msg) && !empty($error_msg)): ?>
<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>
<!-- DADOS DO EMPRESTIMO -->
<p>Se for o caso de quitar juros simples pode escolher mais de um mês mas o recomendado pra juros composto é fazer de mês em mês pois o valor é alterado</p>
<?php
	$juros = 0;
	$juros_por_mes = array(); // Array para armazenar os valores dos juros por mês

	if ($client_info['juros_sc'] == 0) { // composto
		$capital = $client_info['valor_emprestimo'];
		$taxa_juros = $client_info['juros_mes'] / 100;
		$tempo = $client_info['qtd_mensalidade'];
	
		$juros_por_mes = array(); // Array para armazenar os valores dos juros por mês
	
		for ($mes = 1; $mes <= $tempo; $mes++) {
			$montante_mes = $capital * pow(1 + $taxa_juros, $mes);
			$juros_mes = $montante_mes - $capital;
			$juros_por_mes[$mes] = $juros_mes;
		}
	
		$juros = isset($juros_por_mes[$tempo]) ? $juros_por_mes[$tempo] : 0; // Valor dos juros do mês especificado, ou 0 se não existir
	}



	else if($client_info['juros_sc'] == 1){ //simples
		$juros = $client_info['valor_emprestimo'] * $client_info['juros_mes']/100;
	}



?>
<p>juros mensalidade a pagar: <?php echo sprintf("%.2f", $juros); ?></p>

<hr/>
<!-- CALCULO DO JUROS COMPOSTO E SIMPLES -->

<!-- FORMULÁRIO -->

<form class="form" method="POST">
<input type="hidden" name="id" id="id" value="<?php echo $client_info['id'];?>" />	

<!-- aqui vão coisas do calculo -->
<input type="hidden" name="juros-pago" value="<?php echo $juros ?>">
<!-- fim -->
	<input type="hidden" name="juros_mes" value="<?php echo $client_info['juros_mes'];?>">
	<input type="hidden" name="recebido" value="<?php echo $client_info['recebido'];?>">
	<input type="hidden" name="valor_atual" value="<?php echo $client_info['valor_atual']?>">
	<input type="hidden" name="qtd_mensalidade" value="<?php echo $client_info['qtd_mensalidade'];?>">
	<input type="hidden" name="valor_emprestimo" value="<?php echo $client_info['valor_emprestimo']?>"/><br/><br/>
	<input type="hidden" name="data_emprestimo" value="<?php echo $client_info['data_emprestimo']; ?>">
	<input type="hidden" name="juros_sc" value="<?php echo $client_info['juros_sc']; ?>">
	<input type="hidden" name="id_client" value="<?php echo $client_info['id_client']; ?>" />
	<input type="hidden" name="id_company" value="<?php echo $client_info['id_company']; ?>" />
	<input type="hidden" name="meses_pagos" value="<?php echo $client_info['qtd_mensalidade']; ?>" />
	<input type="hidden" name="mensalidade" value="<?php echo $client_info['mensalidade'] ?>">

	<label>Esse é um pagamento ou mensalidade?</label>
<br/>
<select name="select" id="select">
	<option></option>
	<option value="sim">mensalidade</option>
	<option value="nao">pagamento</option>
</select>

<br></br>

<div id="mensal" class="mensal">
	<label for="valor">Valor pago</label><br/>
	<input type="text" name="valor" /><br/><br/>
</div>

<div id="meses" class="meses">
	<label for="valor">Quantos meses foram pagos?</label><br/>
	<input type="number" name="meses_pagos" /><br/><br/>
</div>

<input type="submit" id="submit" class="submit" value="Adicionar pagamento" />
</form>

<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_quitacao.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_inventory_add.js"></script>
