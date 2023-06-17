<head>
	<link rel="stylesheet" href=" <?php echo BASE_URL?>/assets/css/template.css">
</head>
<body>
<h1>Emprestimo - Adicionar</h1>

<?php if(isset($error_msg) && !empty($error_msg)): ?>
<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>


	

<form class="form" method="POST">

	<label for="valor">Valor</label><br/>
	<input type="text" name="valor" required /><br/><br/>

	<label for="juros_s">Juros Simples ou Composto?</label>

	<select name="juros_sc" id="juros_sc">
		<option value="simples">simples</option>
		<option value="composto">composto</option>
	</select><br/><br/>

	<label for="juros">Juros</label><br/>
	<input type="text" name="juros" /><br/><br/>

	<label for="juros">Cliente</label><br/>
		<select name="id_cliente"><?php foreach($clients_list as $c): ?>
			<option name="id_cliente" value="<?php echo $c['id']?>"><?php echo $c['name']?></option><?php endforeach; ?>
		</select><br/><br/>

	<input type="submit" value="Adicionar" />

</form>
</body>
<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_inventory_add.js"></script>