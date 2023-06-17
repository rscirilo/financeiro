<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel - <?php echo $viewData['company_name']; ?></title>
        <link rel="stylesheet" href="assets/css/template.css">        
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    </head>
    <body>
        <div class="leftmenu">
            <div class="company_name">
                <?php echo $viewData['company_name']; ?>
            </div><!--company_name-->
            <div class="topo-sair">
                    <div><a href="<?php echo BASE_URL.'/login/logout'; ?>">Sair</a></div>
                    <div><?php echo $viewData ['user_email']; ?></div>
                </div><!--topo-->
            <div class="menuarea">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>clients">Clientes</a></li>
                    <li><a href="<?php echo BASE_URL; ?>emprestimo">Empréstimos</a></li>
                    <!-- <li><a href="<?php echo BASE_URL; ?>estatistica">Estatísticas</a></li> -->
                    <!-- <li><a href="<?php echo BASE_URL; ?>permissions">Permissões</a></li> -->
                    <!-- <li><a href="<?php echo BASE_URL; ?>users">Usuários</a></li>
                    <li><a href="<?php echo BASE_URL; ?>exemplo">Exemplo</a></li> -->

                </ul>
            </div><!--menuarea-->
        </div><!--leftmenu-->

        
         <div class="area">
                <?php $this->loadViewInTemplate($viewName, $viewData); ?>
            </div><!--area-->
    </body>
</html>
