<?php

session_start();

if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true)
{
    header('Location:ReadGroup.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['id']))
    {
        $_SESSION['message'] = 'Group ID not provided.';
        header('Location:ReadGroup.php');
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
    
        $stmt = $pdo->prepare("DELETE FROM user_groups WHERE id = ?");
        $stmt->execute([$id]);
    
        if ($stmt->rowCount() > 0)
        {
            $_SESSION['delete_group_message'] = 'Successfully deleted group (id: '.$id.') from database.';
        }
        else
        {
            $_SESSION['delete_group_message'] = 'Group not found (id: '.$id.').';
        }

        $stmt = $pdo->prepare("DELETE FROM user_group_map WHERE group_id = ?");
        $stmt->execute([$id]);



    } catch(PDOException $e) {
        $_SESSION['delete_group_message'] = 'Failed to delete group (id: '.$id.') from database: '.$e->getMessage();
    }
    
    $pdo = null;
    
    header('Location:ReadGroup.php');
    exit();
} else {
    header("Location: EditGroup.php?id=$editedId");
    exit();
}

