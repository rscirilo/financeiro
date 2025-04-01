<head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/emprestimo.css">
</head>

<?php if($add_permission): ?>
<div class="button"><a href="<?php echo BASE_URL;?>/emprestimo/add">Adicionar Emprestimo</a></div>
<?php endif; ?>

<h2>Emprestimos em curso</h2>

<?php 
// Check if there are any active loans (valor_emprestimo > 0)
$active_loans_exist = false;
foreach($emprestimo_list as $emprestimo_unico) {
    if($emprestimo_unico['valor_emprestimo'] > 0) {
        $active_loans_exist = true;
        break;
    }
}
?>

<?php if(!$active_loans_exist): ?>
    <div class="no-loans">
        <p>Nenhum empréstimo ativo no momento.</p>
        
    </div>
<?php else: ?>
    <div class="cards-container">
        <?php foreach($emprestimo_list as $emprestimo_unico):?>
            <?php if($emprestimo_unico['valor_emprestimo'] > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <?php 
                            $client = new Clients();
                            $clientInfo = $client->getInfo($emprestimo_unico['id_client'], $emprestimo_unico['id_company']);
                            $data['client_name'] = $clientInfo['name'];
                            echo $data['client_name'];
                            ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Capital: </strong><?php echo number_format($emprestimo_unico['valor_emprestimo'],2,',','.'); ?></p>
                        <p><strong>Pago: </strong><?php echo number_format($emprestimo_unico['recebido'] + $emprestimo_unico['mensalidade'],2,',','.'); ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo BASE_URL; ?>emprestimo/editar/<?php echo $emprestimo_unico['id']; ?>" class="button button_small">Editar</a>
                        <a href="<?php echo BASE_URL; ?>emprestimo/quitar/<?php echo $emprestimo_unico['id']; ?>" class="button button_small">Quitar</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<h2>Já finalizados</h2>

<?php if (empty(array_filter($emprestimo_list, fn($e) => $e['valor_emprestimo'] == 0))): ?>
    <p>Nenhum empréstimo finalizado.</p>
<?php else: ?>
    <div class="cards-container">
        <?php foreach($emprestimo_list as $emprestimo_unico):?>
            <?php if($emprestimo_unico['valor_emprestimo'] == 0): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <?php 
                            $client = new Clients();
                            $clientInfo = $client->getInfo($emprestimo_unico['id_client'], $emprestimo_unico['id_company']);
                            $data['client_name'] = $clientInfo['name'];
                            echo $data['client_name'];
                            ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Valor Recebido: </strong><?php echo number_format($emprestimo_unico['recebido'] + $emprestimo_unico['mensalidade'],2,',','.'); ?></p>
                        <p><strong>Data do Empréstimo: </strong><?php echo date('d/m/Y', strtotime($emprestimo_unico['data_emprestimo'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>