<h1>Empréstimos</h1>
<?php if($add_permission): ?>
<div class="button"><a href="<?php echo BASE_URL;?>/emprestimo/add">Adicionar Emprestimo</a></div>

<?php endif; ?>
<table border="0" width="100%">
    <tr>
        <th>Valor</th>
        <th>Juros</th>
        <th>Devendo</th>
        <th>Ações</th>
    </tr>
    <?php foreach($emprestimo_list as $emprestimo_unico):?>
        <tr>
            <td><?php echo number_format($emprestimo_unico['valor_emprestimo'], 2,',','.') ?></td>
            <td><?php echo $emprestimo_unico['juros_mes']?></td>
            <td>
                
            </td>
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