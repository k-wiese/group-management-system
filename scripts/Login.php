<?php

session_start();



if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location:/../index.php');
    exit();
}

require_once __DIR__.'/../db/config.php';
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo 'Error: ' . $connection->connect_errno;
}
else 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = htmlentities($username, ENT_QUOTES, 'UTF-8');


    if ($result = @$connection->query(sprintf("SELECT * FROM users WHERE username='%s'", mysqli_real_escape_string($connection, $username)))) {
        $usersFound = $result->num_rows;
 
        if ($usersFound > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) 
            {
                $_SESSION['logged_in'] = true;
                if(isset($_SESSION['login_message']))
                {
                    unset($_SESSION['login_message']);
                }
                $connection->close();
                header('Location:/../index.php');
            } 
            else 
            {
                $_SESSION['login_message'] = 'Wrong username or password.';
                header('Location:/../index.php');
            }
        } 
        else 
        {
            $_SESSION['login_message'] = 'Wrong username or password.';
            header('Location:/../index.php');
        }
    } 
    $connection->close();
}
