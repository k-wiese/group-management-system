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
} catch(PDOException $e) {
    $_SESSION['create_group_message'] = 'Connection failed: ' . $e->getMessage();
    header('Location:/../../views/group/create.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = trim($_POST['group_name']);

    if (empty($group_name)) {
        $_SESSION['create_group_message'] = 'Group name cannot be empty.';
        header('Location:/../../views/group/create.php');
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO user_groups (group_name) VALUES (:group_name)');
    $stmt->bindParam(':group_name', $group_name, PDO::PARAM_STR);
    $stmt->execute();


    if ($stmt->errorCode() !== '00000') {
        $_SESSION['create_group_message'] = 'Error adding group: ' . $stmt->errorInfo()[2];
        header('Location:/../../views/group/create.php');
        exit();
    }

    $_SESSION['create_group_message'] = 'Group added successfully.';
    header('Location:/../../views/group/create.php');
    exit();
}

$pdo = null;

header('Location:/../../views/group/create.php');
exit();