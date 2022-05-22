<?php

require_once('class/config.php');
require_once('autoload.php');

if (isset($_POST['name']) && 
    isset($_POST['email']) && 
    isset($_POST['password']) &&
    isset($_POST['repeat_password'])
    ) {
        $name = clearPost($_POST['name']);
        $email = clearPost($_POST['email']);
        $password = clearPost($_POST['password']);
        $repeat_password = clearPost($_POST['repeat_password']);

        if(empty($name) or
        empty($email) or 
        empty($password) or
        empty($repeat_password)
        ) {
            $general_error = "Todos os campos são obrigatórios";
        } else {
            $user = new User($name, $email, $password);

            $user->setRepetition($repeat_password);

            $user->validateRegistration();

            if(empty($user->error)) {
                
                if($user->insert()) {
                    header('Location: index.php');
                } else {
                    $general_error = $user->error["general_error"];
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title>Cadastrar</title>
</head>
<body>
    <form method="POST">
        <h1>Cadastrar</h1>
         
        <?php if(isset($general_error)) { ?>
        <div class="erro-geral animate__animated animate__rubberBand">
            <?php echo $general_error; ?>
        </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="img/card.png">
            <input <?php if(isset($user->error["name_error"])) { 
                echo 'class="erro-input"';
            } 
            ?> 
            name="name" type="text" placeholder="Nome Completo">
            <div class="erro"><?php if(isset($user->error["name_error"])) { 
                echo $user->error_reporting["name_error"];
            }  
            ?></div>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/user.png">
            <input type="email" <?php if(isset($user->error["email_error"])) { 
                echo 'class="erro-input"';
            } 
            ?> 
            name="email" placeholder="Seu melhor email">
            <div class="erro"><?php if(isset($user->error["name_error"])) { 
                echo $user->error_reporting["email_error"];
            }  
            ?></div>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock.png">
            <input type="password" <?php if(isset($user->error["password_error"])) { 
                echo 'class="erro-input"';
            } 
            ?> 
            name="password" placeholder="Senha mínimo 6 Dígitos">
            <div class="erro"><?php if(isset($user->error["name_error"])) { 
                echo $user->error_reporting["password_error"];
            }  
            ?></div>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock-open.png">
            <input type="password" <?php if(isset($user->error["repeat_password_error"])) { 
                echo 'class="erro-input"';
            } 
            ?> 
            name="repeat_password" placeholder="Repita a senha criada">
            <div class="erro"><?php if(isset($user->error["name_error"])) { 
                echo $user->error_reporting["repeat_password_error"];
            }  
            ?></div>
        </div>   
        
        <div class="input-group">
            <input type="checkbox" id="termos" name="conditions" value="ok">
            <label for="termos">Ao se cadastrar você concorda com a nossa <a class="link" href="#">Política de Privacidade</a> e os <a class="link" href="#">Termos de uso</a></label>
        </div>  
       
        
        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php">Já tenho uma conta</a>
    </form>
</body>
</html>