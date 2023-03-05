<?php

session_start();

if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true)
{
    header('Location:ReadUser.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['id']))
    {
        $_SESSION['delete_user_message'] = 'User ID not provided.';
        header('Location:ReadUser.php');
        exit();
    }
    
    require_once __DIR__.'/../../db/config.php';
    
    try {
    
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            throw new Exception("Invalid input data");
        }
    
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    
        if ($stmt->rowCount() > 0)
        {
            $_SESSION['delete_user_message'] = 'Successfully deleted user (id: '.$id.') from database.';
        }
        else
        {
            $_SESSION['delete_user_message'] = 'User not found (id: '.$id.').';
        }

        $stmt = $pdo->prepare("DELETE FROM user_group_map WHERE user_id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        $_SESSION['delete_user_message'] = 'Failed to delete user (id: '.$id.') from database: '.$e->getdelete_user_message();
    }
    
    $pdo = null;
    
    header('Location:ReadUser.php');
    exit();
} 
else {
    header("Location: ReadUser.php");
    exit();
}

