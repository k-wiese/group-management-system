<?php
session_start();

if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true) {
    header('Location:/../../index.php');
    exit();
}

require_once __DIR__ . '/../../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
    $_SESSION['store_group_user_message'] = 'Connection failed: ' . $e->getMessage();
    header('Location:CreateGroupUser.php?group_id='.$group_id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_id = trim($_POST['group_id']);

    if (empty($group_id)) {
        $_SESSION['store_group_user_message'] = 'Group name cannot be empty.';
        header('Location:CreateGroupUser.php?group_id='.$group_id);
        exit();
    }
    $user_id = trim($_POST['user_id']);

    if (empty($user_id)) {
        $_SESSION['store_group_user_message'] = 'Group name cannot be empty.';
        header('Location:CreateGroupUser.php?group_id='.$group_id);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM user_group_map WHERE group_id = :group_id AND user_id= :user_id");
    $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($user_rows) > 0){
        $_SESSION['store_group_user_message'] = 'User already in group';
        header('Location:CreateGroupUser.php?group_id='.$group_id);
        exit();
    }



    $stmt = $pdo->prepare('INSERT INTO user_group_map (user_id, group_id) VALUES (:user_id, :group_id)');
    $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    var_dump($stmt);



    if ($stmt->errorCode() !== '00000') {
        $_SESSION['store_group_user_message'] = 'Error adding group: ' . $stmt->errorInfo()[2];
        header('Location:CreateGroupUser.php?group_id='.$group_id);
        exit();
    }

    $_SESSION['store_group_user_message'] = 'Group user added successfully.';
    header('Location:CreateGroupUser.php?group_id='.$group_id);
    exit();
}