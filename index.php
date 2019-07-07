<?php
    if(isset($_POST['login'])) {
        session_start();
        $login = htmlentities($_POST['login'],ENT_QUOTES,"UTF-8");
        $password = htmlentities($_POST['password'],ENT_QUOTES,"UTF-8");
        require_once "dbconfig.php";
        $connection = $_SESSION['connection'];
        $response = $connection->query("SELECT * FROM users WHERE login='".mysqli_real_escape_string($connection,$login)."'");
        if($response->num_rows>0){
            $table = $response->fetch_assoc();
            if (password_verify($password, $table['password'])) {
                $_SESSION['userId'] = $table['id'];
                $_SESSION['userLogin'] = $login;
                header('Location: messageList.php');
            }
            else {
                $err_password = 'wrong password';
            }
        }
        else {
            $err_login = 'wrong username';
        }
        $connection->close();
    }
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset='UTF-8'/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href='reset.css'/>
        <link rel="stylesheet" href='index.css'/>
        <title>Comunicate Us</title>
    </head>
    <body>
        <div class="box">
            <form method="post">
                <label>login <input type="text" name="login"/></label>
                <?php 
                    if(isset($err_login)) {
                        echo '<p class="error">'.$err_login.'</p>';
                    }
                ?>
                <label>password <input type="password" name="password"/></label>
                <?php 
                    if(isset($err_password)) {
                        echo '<p class="error">'.$err_password.'</p>';
                    }
                ?>
                <input class="submit" type="submit" name="sign in"/>
            </form>
            <a href="sign_up.php">Don't have an account? Sign up!</a>
        </div>
    </body>
</html>