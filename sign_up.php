<?php
    session_start();
    if(isset($_POST["login"])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];
        
        require_once "dbconfig.php";
        $connection = $_SESSION['connection'];

        $validate=true;

        //login validation
        $response = $connection->query("SELECT login FROM users WHERE login='$login'");
        if($response->num_rows>0){
            $validate=false;
            $err_login = 'login not available ';
        }
        if(strlen($login)<1) {
            $err_login = 'too short login ';
        }

        //email validation 
        $response = $connection->query("SELECT email FROM users WHERE email='$email'");
        if($response->num_rows>0){
            $validate=false;
            $err_email = 'email not available ';
        }
        if(strlen($email)<1) {
            $err_email = 'too short email ';
        }

        //password validation 
        if(strlen($password)>20 || strlen($password)<5) {
            $validate=false;
            $err_password = 'too long/short password ';
        }

        //password2 validation
        if($password!=$password2) {
            $validate=false;
            $err_password = 'passwords are different ';
        }

        //if all ok
        if($validate) {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['email'] = $email;

            require_once "dbconfig.php";
            mysqli_report(MYSQLI_REPORT_STRICT);
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $connection->query("INSERT INTO users VALUES (NULL, '$login', '$hashed', '$email')");
            $connection->close();
            header('Location: index.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset='UTF-8'/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href='reset.css'/>
        <link rel="stylesheet" href='sign_up.css'/>
        <title>Comunicate Us</title>
    </head>
    <body>
        <form method="post">
            <label>Login <input type="text" name="login"/></label>
            <?php 
                if(isset($err_login)) {
                    echo '<p class="error">'.$err_login.'</p>';
                }
            ?>
            <label>E-mail<input type="email" name="email"/></label>
            <?php 
                if(isset($err_email)) {
                    echo '<p class="error">'.$err_email.'</p>';
                }
            ?>
            <label>Password<input type="password" name="password"/></label>
            <?php
                if(isset($err_password)) {
                    echo '<p class="error">'.$err_password.'</p>';
                }
            ?>
            <label>Confirm Password<input type="password" name="password2"/></label>
            <label><input class="submit" type="submit" name="sign in"/></label>
        </form>
    </body>
</html>