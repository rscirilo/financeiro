<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="<?php echo BASE_URL; ?>/assets/css/login.css" rel="stylesheet" />
    </head>
    <body>

        <form class="box" method="POST">
        <h1>Login</h1>
        <input type="email" name="email" placeholder="digite seu e-mail">
        <input type="password" name="password" placeholder="digite sua senha">
        <input type="submit" value="Login">

        <?php if(isset($error) && !empty($error)): ?>
                <div class="warning"><?php echo $error; ?></div>
                <?php endif; ?>
        </form>    
    </body>
</html>   