<h1>editar dívida</h1>
<?php if(isset($error_msg) && !empty($error_msg)): ?>
<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form class="form" method="POST">

	<label for="valor">Valor</label><br/>
	<input type="hidden" name="id" id="id" value="<?php echo $emp_info['id'];?>" />
	<input type="text" name="valor_emprestimo" value="<?php echo $emp_info['valor_emprestimo']?>"/><br/><br/>
	<input type="hidden" name="data_emprestimo" value="<?php echo $emp_info['data_emprestimo']; ?>">
	<input type="hidden" name="id_client" value="<?php echo $emp_info['id_client']; ?>" />
	<input type="hidden" name="id_company" value="<?php echo $emp_info['id_company']; ?>" />
	<input type="hidden" name="recebido" value="<?php echo $emp_info['recebido']; ?>" />
	
	<label for="juros">Juros</label><br/>
	<input type="text" name="juros_mes" value="<?php echo $emp_info['juros_mes'] ?>" /><br/><br/>

	<br/>

	<input type="submit" value="Editar" />

</form>

<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_inventory_add.js"></script>