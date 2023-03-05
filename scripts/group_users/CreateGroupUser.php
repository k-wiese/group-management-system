<?php

session_start();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (empty($_GET['group_id']))
    {
        $_SESSION['message'] = 'ID not provided.';
        header('Location:/../group/ReadGroup.php');
        exit();
    }
    
    require_once __DIR__.'/../../db/config.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $_SESSION['users'] = $users;
    
        header('Location: /../../views/group_users/create.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    
    header('Location:/views/group_users/create.php');
    exit();
} 
else {
    header("Location: ReadGroupUser.php?id=".$_GET['group_id']);
    exit();
}

