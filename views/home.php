<h1>Home</h1>
<h2>Sobre seus clientes</h2>

<?php
$count_clients = 0;
foreach($quantidade_clientes as $client):
	$count_clients++;
?>
<?php endforeach;?> <!-- CONTAR CLIENTES -->

<p>Você tem <?php echo($count_clients);?> clientes ativos</p>

<?php
$count_emp = 0;
foreach($quantidade_emprestimos as $emprestimo):
	$count_emp++;
?>
<?php endforeach;?> <!-- CONTAR EMPRESTIMOS -->


<p>Atualmente tem <?php echo$count_emp; ?> emprestimos ativos</p>

<h2>Sobre seus Emprestimos</h2>

<h2>Sobre seu caixa</h2>