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
                <?php
                // Calculate days in delay
                $data_emprestimo = DateTime::createFromFormat('Y-m-d H:i:s', $emprestimo_unico['data_emprestimo']);
                $data_atual = new DateTime();
                $intervalo = $data_atual->diff($data_emprestimo);
                $dias_emprestimo = $intervalo->days;
                $dias_esperados = $emprestimo_unico['qtd_mensalidade'] * 30;
                $dias_atraso = ($dias_emprestimo - $dias_esperados);
                
                // Calculate payment values
                $pago_juros_mensais = $emprestimo_unico['mensalidade'];
                $pago_avulso = $emprestimo_unico['recebido'];
                $pago_total = $pago_juros_mensais + $pago_avulso;
                ?>
                
                <div class="card">
                <?php
                        // Cálculos existentes...
                        
                        // Determinar a classe de status
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

<?php if (empty(array_filter($emprestimo_list, fn($e) => $e['valor_emprestimo'] == 0))): ?>
    <div class="no-loans">
        <p>Nenhum empréstimo finalizado foi encontrado</p>
    </div>
<?php else: ?>
    <div class="cards-container">
        <?php foreach($emprestimo_list as $emprestimo_unico):?>
            <?php if($emprestimo_unico['valor_emprestimo'] <= 0): ?>
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