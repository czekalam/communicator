<?php
    session_start();
    if(!isset($_SESSION['userId'])) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset='UTF-8'/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href='reset.css'/>
        <link rel="stylesheet" href='messageList.css'/>
        <title>Comunicate Us</title>
    </head>
    <body>
        <div class="container">
            <a href="sign_out.php">Sign out</a>
            <a href='message.php'>New message</a>
            <?php
                $userId = $_SESSION['userId'];
                require_once "dbconfig.php";
                $connection = $_SESSION['connection'];
                $response = $connection->query("SELECT * FROM messages WHERE id_owner='$userId'");
                $rows = $response->num_rows;
                if($rows>0){
                    echo '<ul>';
                    for ($x = 0; $x < $rows; $x++) {
                        $table = $response->fetch_assoc();
                        $author_id = $table['id_author'];
                        $response2 = $connection->query("SELECT login FROM users WHERE id='$author_id'");
                        $table2 = $response2->fetch_assoc();
                        echo '<li><span class="author">'.$table2['login'].'</span><span class="text">'.$table['text'].'</span></li>';
                    } 
                    echo '</ul>';
                }
                else {
                    echo 'no messages';
                }
                $connection->close();
            ?>
        </div>
    </body>
</html>