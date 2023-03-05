<?php

session_start();

if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true)
{
    
    header('Location:/../../index.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['user_id']))
    {

        $_SESSION['message'] = 'User ID not provided.';
        header('Location:ReadGroupUser.php');
        exit();
    }
    if (empty($_POST['group_id']))
    {
        $_SESSION['message'] = 'Group ID not provided.';
        header('Location:ReadGroupUser.php');
        exit();
    }
    
   
    require_once __DIR__.'/../../db/config.php';
    
    try {
    
        $group_id = filter_input(INPUT_POST, 'group_id', FILTER_VALIDATE_INT);
        if (!$group_id) {
            throw new Exception("Invalid input data");
        }

        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if (!$user_id) {
            throw new Exception("Invalid input data");
        }
        
        
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $pdo->prepare("DELETE FROM user_group_map WHERE group_id = :group_id AND user_id = :user_id");
        $stmt->execute([':group_id' => $group_id,':user_id'=>$user_id]);

        
    
        if ($stmt->rowCount() > 0)
        {
            $_SESSION['delete_group_user_message'] = 'Successfully deleted user from group (id: '.$group_id.').';
        }
        else
        {
            $_SESSION['delete_group_user_message'] = 'Relation not found (id: '.$group_id.').';
        }

       
    } catch(PDOException $e) {
        $_SESSION['delete_group_user_message'] = 'Failed to delete user from group (id: '.$id.') from database: '.$e->getMessage();
    }
    
    $pdo = null;
    
    header('Location:ReadGroupUser.php?group_id='.$group_id);

    exit;
} else {
    header('Location:ReadGroupUser.php?group_id='.$group_id);
    exit;
}

