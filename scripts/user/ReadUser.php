<?php

session_start();

require_once __DIR__.'/../../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['users'] = $users;

    if(isset($_SESSION['edit_user_message']))
    {
        unset($_SESSION['edit_user_message']);
    }

    header('Location: /../../views/user/index.php');
    exit;
} catch (PDOException $e) {
    // Handle the error appropriately, e.g. log it and show a user-friendly error message
    echo "Error: " . $e->getMessage();
    exit;
}
