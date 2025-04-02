<head>
    <link rel="stylesheet" href=" <?php echo BASE_URL?>/assets/css/menu.css">
    <link rel="stylesheet" href=" <?php echo BASE_URL?>/assets/css/quitar.css">
</head>

<body>

    <?php if(isset($error_msg) && !empty($error_msg)): ?>
        <div class="warn"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <div class="emprestimo-info">
        <?php
            $juros = 0;
            $juros_por_mes = array();

            // Definir valores
            $capital = isset($client_info['valor_emprestimo']) ? $client_info['valor_emprestimo'] : 0;
            $devendo = isset($client_info['devendo']) ? $client_info['devendo'] : 0; // Usa 'devendo' ou o capital se não existir
            $juros_mes = isset($client_info['juros_mes']) ? $client_info['juros_mes'] : 0;
            $juros_sc = isset($client_info['juros_sc']) ? $client_info['juros_sc'] : 0;
            $data_emprestimo = isset($client_info['data_emprestimo']) ? $client_info['data_emprestimo'] : '';

            if ($juros_sc == 0) { // Juros composto
                $taxa_juros = $juros_mes / 100;
                $data_atual = new DateTime(date('Y-m-d'));
                $data_inicial = new DateTime(date('Y-m-d', strtotime($data_emprestimo)));
                $intervalo = $data_inicial->diff($data_atual);
                $diferenca_meses = $intervalo->m + ($intervalo->y * 12);

                if($diferenca_meses > $client_info['qtd_mensalidade']){
                    $a = $capital * $taxa_juros;  // Usa $devendo para cálculo
                    $quitacao_mes = $diferenca_meses - $client_info['qtd_mensalidade'];
                    $montante = $capital * pow(1 + $taxa_juros, $quitacao_mes); // Usa $devendo
                    $juros_total = $montante - $capital; // Usa $devendo
                    $total_mensalidade = $juros_total + $a;
                } else {
                    $total_mensalidade = $capital * $taxa_juros; // Usa $devendo
                }
            } else if ($juros_sc == 1) { // Juros simples
                $total_mensalidade = $capital * $juros_mes / 100; // Usa $devendo
            }
        ?>

        <p>Saldo Devedor Atual: R$ <?php echo number_format($devendo, 2, ',', '.'); ?></p>
        <p>Juros da mensalidade a pagar: R$ <?php echo number_format($total_mensalidade, 2, ',', '.'); ?></p>
        <p>Tipo de juros: <?php echo ($juros_sc == 0) ? 'Composto' : 'Simples'; ?></p>
        <p>Recomendado: <?php echo ($juros_sc == 0) ? 'Se for quitar mais de um mês faça isso mês por mês, um de cada vez' : 'Pode escolher quitar mais de um mês'; ?></p>
        <p>Pagar como mensalidade é pagar apenas o juros mensal, pagar um valor é o pagamento avulso da dívida ativa</p>
        <hr />

        <!-- FORMULÁRIO -->
        <form class="form" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($client_info['id']) ? $client_info['id'] : ''; ?>" />    
            <input type="hidden" name="juros-pago" value="<?php echo $juros ?>">
            <input type="hidden" name="juros_mes" value="<?php echo $juros_mes; ?>">
            <input type="hidden" name="recebido" value="<?php echo isset($client_info['recebido']) ? $client_info['recebido'] : ''; ?>">
            <input type="hidden" name="qtd_mensalidade" value="<?php echo isset($client_info['qtd_mensalidade']) ? $client_info['qtd_mensalidade'] : ''; ?>">
            <input type="hidden" name="valor_emprestimo" value="<?php echo $capital; ?>" />
            <input type="hidden" name="devendo" value="<?php echo $devendo; ?>" /> <!-- Campo principal para atualização -->
            <input type="hidden" name="data_emprestimo" value="<?php echo $data_emprestimo; ?>">
            <input type="hidden" name="juros_sc" value="<?php echo $juros_sc; ?>">
            <input type="hidden" name="id_client" value="<?php echo isset($client_info['id_client']) ? $client_info['id_client'] : ''; ?>" />
            <input type="hidden" name="id_company" value="<?php echo isset($client_info['id_company']) ? $client_info['id_company'] : ''; ?>" />
            <input type="hidden" name="meses_pagos" value="<?php echo isset($client_info['qtd_mensalidade']) ? $client_info['qtd_mensalidade'] : ''; ?>" />
            <input type="hidden" name="mensalidade" value="<?php echo isset($client_info['mensalidade']) ? $client_info['mensalidade'] : ''; ?>">

            <label>Esse é um pagamento ou mensalidade?</label><br/>
            <select name="select" id="select">
                <option></option>
                <option value="sim">Mensalidade</option>
                <option value="nao">Pagamento</option>
            </select>

            <br><br>

            <div id="mensal" class="mensal" style="display: none;">
                <label for="valor">Quantos meses foram pagos?</label><br/>
                <input type="number" name="meses_pagos" /><br/><br/>
            </div>

            <div id="meses" class="meses">
                <label for="valor">Valor pago</label><br/>
                <input type="text" name="valor" oninput="formatCurrency(this)" /><br/><br/>
            </div>

            <input type="submit" id="submit" class="submit" value="Adicionar pagamento" />
        </form>
    </div>

    <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_quitacao.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script_inventory_add.js"></script>

    <script>
        // Formatação de moeda para o campo de valor
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            value = (value/100).toFixed(2);
            input.value = parseFloat(value).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        document.getElementById('select').addEventListener('change', function() {
            var selectValue = this.value;
            var mensal = document.getElementById('mensal');
            var meses = document.getElementById('meses');

            if (selectValue === 'sim') {
                mensal.style.display = 'block';
                meses.style.display = 'none';
            } else if (selectValue === 'nao') {
                mensal.style.display = 'none';
                meses.style.display = 'block';
            } else {
                mensal.style.display = 'none';
                meses.style.display = 'none';
            }
        });
    </script>
</body>