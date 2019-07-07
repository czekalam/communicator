<?php
    session_start();
    if(!isset($_SESSION['userId'])) {
        header('Location: index.php');
    }
    
    if(isset($_POST["to"])) {
        $to = $_POST['to'];
        $text = $_POST['text'];

        require_once "dbconfig.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $userId = $_SESSION['userId'];
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        $response = $connection->query("SELECT id FROM users WHERE login='$to'");
        if($response->num_rows>0){
            $table = $response->fetch_assoc();
            $toId = $table['id'];
            $connection->query("INSERT INTO messages VALUES (NULL, '$userId', '$toId', '$text')");
            $connection->close();
            header('Location: messageList.php');
        }
        else {
            echo 'wrong username';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset='UTF-8'/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href='reset.css'/>
        <link rel="stylesheet" href='message.css'/>
        <title>Comunicate Us</title>
    </head>
    <body>
        <a href="sign_out.php">sign out</a>
        <form method="post">
            <label>To <input type="text" name="to"/></label>
            <label>Text<input type="text" name="text"/></label>
            <label><input type="submit" name="send"/></label>
        </form>
    </body>
</html>