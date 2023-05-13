<?php if(isset($error_msg) && !empty($error_msg)): ?>
<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>
<form class="form" method="POST">

	<label for="valor">Valor</label><br/>
	<input type="text" name="valor" value="" required /><br/><br/>

	<label for="juros">Juros</label><br/>
	<input type="text" name="juros" /><br/><br/>

	<label for="juros">Cliente</label><br/>
		<select name="id_cliente"><?php foreach($clients_list as $c): ?>
			<option name="id_cliente" value="<?php echo $c['id']?>"><?php echo $c['name']?></option><?php endforeach; ?>
		</select><br/><br/>

	<input type="submit" value="Adicionar" />

</form>