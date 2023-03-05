<?php

session_start();

require_once __DIR__.'/../../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$row) {
        $_SESSION['edit_user_message'] = 'User not found';
        header('Location: /../index.php');
        exit;
    }

    $_SESSION['edited_user_id'] = $id;
    $_SESSION['edited_user_username'] = $row['username'];
    $_SESSION['edited_user_first_name'] = $row['first_name'];
    $_SESSION['edited_user_last_name'] = $row['last_name'];
    $_SESSION['edited_user_birth_date'] = $row['birth_date'];

    header('Location: /../../views/user/edit.php');
    exit;
} catch (PDOException $e) 
{
    echo "Error: " . $e->getMessage();
    exit;
}