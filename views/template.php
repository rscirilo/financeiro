<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Painel - <?php echo $viewData['company_name']; ?></title>
        <link rel="stylesheet" href="assets/css/menu.css">        
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    </head>
    <body>
        <button class="menu-toggle" id="menuToggle">☰</button>
        
        <div class="leftmenu" id="leftMenu">
            <div class="company_name">
                <?php echo $viewData['company_name']; ?>
            </div><!--company_name-->
            <div class="topo-sair">
                <div><a href="<?php echo BASE_URL.'/login/logout'; ?>">Sair</a></div>
                <div><?php echo $viewData['user_email']; ?></div>
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

        <div class="area" id="mainContent">
            <?php $this->loadViewInTemplate($viewName, $viewData); ?>
        </div><!--area-->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menuToggle = document.getElementById('menuToggle');
                const leftMenu = document.getElementById('leftMenu');
                const mainContent = document.getElementById('mainContent');

                menuToggle.addEventListener('click', function() {
                    leftMenu.classList.toggle('active');
                    menuToggle.classList.toggle('open');
                    
                    // Close menu when clicking outside on mobile
                    if (window.innerWidth <= 768) {
                        if (leftMenu.classList.contains('active')) {
                            document.addEventListener('click', closeMenuOnClickOutside);
                        } else {
                            document.removeEventListener('click', closeMenuOnClickOutside);
                        }
                    }
                });

                function closeMenuOnClickOutside(e) {
                    if (!leftMenu.contains(e.target) && e.target !== menuToggle) {
                        leftMenu.classList.remove('active');
                        menuToggle.classList.remove('open');
                        document.removeEventListener('click', closeMenuOnClickOutside);
                    }
                }

                // Adjust on window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        leftMenu.classList.remove('active');
                        menuToggle.classList.remove('open');
                        document.removeEventListener('click', closeMenuOnClickOutside);
                    }
                });
            });
        </script>
    </body>
</html>