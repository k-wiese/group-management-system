<?php

session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
{
    header('Location:/../../index.php');
    exit();
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordConfirm']) || empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['birthDate']))
{
    $_SESSION['register_message'] = 'You have to fill every field.';
    header('Location:/../../views/user/create.php');
    exit();
}
else
{
    require_once __DIR__.'/../../db/config.php';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['register_message'] = 'Connection failed: ' . $e->getMessage();
        header('Location:/../../views/user/create.php');
        exit();
    }

    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    $username = htmlentities($username, ENT_QUOTES, 'UTF-8');
    $firstName = htmlentities($firstName, ENT_QUOTES, 'UTF-8');
    $lastName = htmlentities($lastName, ENT_QUOTES, 'UTF-8');

    if ($password !== $passwordConfirm) {
        $_SESSION['message'] = 'Passwords do not match.';
        header('Location:/../../views/user/create.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, first_name, last_name, birth_date, password) VALUES (:username, :firstName, :lastName, :birthDate, :hashed_password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':birthDate', $birthDate);
        $stmt->bindParam(':hashed_password', $hashed_password);

        if ($stmt->execute()) 
        {
            $_SESSION['message'] = 'Successfully saved user '.$username.' in database';
            header('Location:/../../views/user/create.php');
        } 
        else 
        {
            $_SESSION['message'] = 'Error saving user in database';
            header('Location:/../../views/user/create.php');
        }

        $stmt->closeCursor();
    } catch(PDOException $e) {
        $_SESSION['message'] = 'Error saving user in database: ' . $e->getMessage();
        header('Location:/../../views/user/create.php');
    }

    $pdo = null;
}
