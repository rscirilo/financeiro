<h1>Empréstimos</h1>
<?php if($add_permission): ?>
<div class="button"><a href="<?php echo BASE_URL;?>/emprestimo/add">Adicionar Emprestimo</a></div>

<?php endif; ?>
<table border="0" width="100%">
    <tr>
        <th>Capital</th>
        <th>Pago</th>
        <th>Pago em Mensalidades</th>
        <th>sc</th>
        <th>mensalidades</th>
        <th>Ações</th>
        
    </tr>
    <?php foreach($emprestimo_list as $emprestimo_unico):?>
        <tr>
            <td><?php echo $emprestimo_unico['valor_emprestimo'] ?></td>
            <td><?php echo $emprestimo_unico['recebido'] ?></td>
            <td><?php echo $emprestimo_unico['mensalidade']?></td>
            <td><?php echo $emprestimo_unico['juros_sc'] ?></td>
            <td><?php echo $emprestimo_unico['qtd_mensalidade'] ?></td>
            <td>
                <div class="button button_small">
                    <a href="<?php echo BASE_URL; ?>emprestimo/editar/<?php echo $emprestimo_unico['id'];
                    ?>">Editar</a>
                </div>
                <div class="button button_small">
                    <a href="<?php echo BASE_URL; ?>emprestimo/quitar/<?php echo $emprestimo_unico['id'];
                    ?>">Quitar</a>
                </div>
            </td>

        </tr>

    <?php endforeach;?>
</table>