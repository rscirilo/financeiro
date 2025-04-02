<head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/emprestimo.css">
</head>

<?php if($add_permission): ?>
<div class="button"><a href="<?php echo BASE_URL;?>/emprestimo/add">Adicionar Emprestimo</a></div>
<?php endif; ?>

<h2>Emprestimos em curso</h2>

<?php 
// Check if there are any active loans (devendo > 0)
$active_loans_exist = false;
foreach($emprestimo_list as $emprestimo_unico) {
    if($emprestimo_unico['devendo'] > 0) {
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
            <?php if($emprestimo_unico['devendo'] > 0): ?>
                <?php
                // Calculate days in delay
                $data_emprestimo = DateTime::createFromFormat('Y-m-d H:i:s', $emprestimo_unico['data_emprestimo']);
                $data_atual = new DateTime();
                $intervalo = $data_atual->diff($data_emprestimo);
                $dias_emprestimo = $intervalo->days;
                $dias_esperados = $emprestimo_unico['qtd_mensalidade'] * 30;
                $dias_atraso = ($dias_emprestimo - $dias_esperados);
                
                // Corrected payment values
                $pago_juros_mensais = $emprestimo_unico['mensalidade'] ?? 0;
                $pago_avulso = $emprestimo_unico['recebido'] ?? 0; // Only the amount actually paid
                $pago_total = $pago_juros_mensais + $pago_avulso; // Sum of mensalidade and avulso
                ?>
                
                <div class="card">
                    <?php
                    // Determine the status class
                    $status_class = '';
                    if ($dias_atraso <= 5) {
                        $status_class = 'verde';
                    } elseif ($dias_atraso <= 29) {
                        $status_class = 'amarelo';
                    } else {
                        $status_class = 'vermelho';
                    }
                    ?>
                    <div class="card <?php echo $status_class; ?>">
                        <h3>
                            <?php 
                            $client = new Clients();
                            $clientInfo = $client->getInfo($emprestimo_unico['id_client'], $emprestimo_unico['id_company']);
                            echo htmlspecialchars($clientInfo['name']);
                            ?>
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        <p><strong>Capital inicial: </strong>R$ <?php echo number_format($emprestimo_unico['valor_emprestimo'], 2, ',', '.'); ?></p>
                        <p><strong>Pago em juros mensais: </strong>R$ <?php echo number_format($pago_juros_mensais, 2, ',', '.'); ?></p>
                        <p><strong>Pago avulso: </strong>R$ <?php echo number_format($pago_avulso, 2, ',', '.'); ?></p>
                        <p><strong>Pago no total: </strong>R$ <?php echo number_format($pago_total, 2, ',', '.'); ?></p>
                        <p><strong>Dias em atraso: </strong><?php echo $dias_atraso; ?> dias</p>
                        <p><strong>Data do empréstimo: </strong><?php echo $data_emprestimo->format('d/m/Y H:i'); ?></p>
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

<?php 
// Check if there are any finished loans
$finished_loans_exist = false;
foreach($emprestimo_list as $emprestimo_unico) {
    if($emprestimo_unico['devendo'] <= 0) {
        $finished_loans_exist = true;
        break;
    }
}
?>

<?php if (!$finished_loans_exist): ?>
    <div class="no-loans">
        <p>Nenhum empréstimo finalizado foi encontrado</p>
    </div>
<?php else: ?>
    <div class="cards-container">
        <?php foreach($emprestimo_list as $emprestimo_unico):?>
            <?php if($emprestimo_unico['devendo'] <= 0): ?>
                <?php
                // Corrected payment values for finished loans
                $pago_juros_mensais = $emprestimo_unico['mensalidade'] ?? 0;
                $pago_avulso = $emprestimo_unico['recebido'] ?? 0; // Only the amount actually paid
                $pago_total = $pago_juros_mensais + $pago_avulso; // Sum of mensalidade and avulso
                
                // Calculate days for finished loans
                $data_emprestimo = DateTime::createFromFormat('Y-m-d H:i:s', $emprestimo_unico['data_emprestimo']);
                $data_atual = new DateTime();
                $intervalo = $data_atual->diff($data_emprestimo);
                $dias_emprestimo = $intervalo->days;
                $dias_esperados = $emprestimo_unico['qtd_mensalidade'] * 30;
                $dias_atraso = ($dias_emprestimo - $dias_esperados);
                ?>
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <?php 
                            $client = new Clients();
                            $clientInfo = $client->getInfo($emprestimo_unico['id_client'], $emprestimo_unico['id_company']);
                            echo htmlspecialchars($clientInfo['name']);
                            ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Capital inicial: </strong>R$ <?php echo number_format($emprestimo_unico['valor_emprestimo'], 2, ',', '.'); ?></p>
                        <p><strong>Pago em juros mensais: </strong>R$ <?php echo number_format($pago_juros_mensais, 2, ',', '.'); ?></p>
                        <p><strong>Pago avulso: </strong>R$ <?php echo number_format($pago_avulso, 2, ',', '.'); ?></p>
                        <p><strong>Pago no total: </strong>R$ <?php echo number_format($pago_total, 2, ',', '.'); ?></p>
                        <p><strong>Dias em atraso: </strong><?php echo $dias_atraso; ?> dias</p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>