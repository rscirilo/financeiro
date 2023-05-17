<?php if(isset($error_msg) && !empty($error_msg)): ?>
<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>
<!-- DADOS DO EMPRESTIMO -->

<p>Valor emprestado: <?php echo $client_info['valor_emprestimo'] ?></p>
<p>% em juros: <?php echo $client_info['juros_mes'] ?></p>
<p>Valor da mensalidade: <?php echo $client_info['valor_emprestimo'] * ($client_info['juros_mes']/100) ?> </p>
<hr/>

<!-- FORMULÁRIO -->

<form class="form" method="POST">
<input type="hidden" name="id" id="id" value="<?php echo $client_info['id'];?>" />	
	<input type="hidden" name="juros_mes" value="<?php echo $client_info['juros_mes'];?>">
	<input type="hidden" name="recebido" value="<?php echo $client_info['recebido'];?>">
	<input type="hidden" name="valor_emprestimo" value="<?php echo $client_info['valor_emprestimo']?>"/><br/><br/>
	<input type="hidden" name="data_emprestimo" value="<?php echo $client_info['data_emprestimo']; ?>">
	<input type="hidden" name="id_client" value="<?php echo $client_info['id_client']; ?>" />
	<input type="hidden" name="id_company" value="<?php echo $client_info['id_company']; ?>" />

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
