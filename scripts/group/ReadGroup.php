<?php

session_start();

if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true)
{
    header('Location:/../../index.php');
    exit();
}

if(isset($_SESSION['edit_group_message']))
{
    unset($_SESSION['edit_group_message']);
}

if(isset($_SESSION['create_group_message']))
{
    unset($_SESSION['create_group_message']);
}
if(isset($_SESSION['delete_group_user_message']))
{
    unset($_SESSION['delete_group_user_message']);
}

if(isset($_SESSION['store_group_user_message']))
{
    unset($_SESSION['store_group_user_message']);
}



require_once __DIR__.'/../../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM user_groups");
    $stmt->execute();
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['groups'] = $groups;

    header('Location:/../../views/group/index.php');
} catch(PDOException $e) {
    echo "Error executing query: " . $e->getMessage();
}
?>