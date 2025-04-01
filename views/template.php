<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel - <?php echo $viewData['company_name']; ?></title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</head>
<body>
    <!-- Botão de alternância do menu -->
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <div class="leftmenu">
        <div class="company_name">
            <?php echo $viewData['company_name']; ?>
        </div>
        
        <div class="topo-sair">
            <div><a href="<?php echo BASE_URL.'/login/logout'; ?>">Sair</a></div>
            <div><?php echo $viewData['user_email']; ?></div>
        </div>

        <div class="menuarea">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>clients">Clientes</a></li>
                <li><a href="<?php echo BASE_URL; ?>emprestimo">Empréstimos</a></li>
            </ul>
        </div>
    </div>

    <div class="area">
        <?php $this->loadViewInTemplate($viewName, $viewData); ?>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.leftmenu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>
