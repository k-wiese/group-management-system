<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location:/../../index.php');
        exit();
    }

    require_once __DIR__ . '/../../db/config.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM user_groups WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['edited_group_id'] = $row['id'];
            $_SESSION['edited_group_name'] = $row['group_name'];
        } else {
            $_SESSION['edit_group_message'] = 'Group not found';
            header('Location:/../../index.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['edit_group_message'] = 'Error selecting group: ' . $e->getMessage();
        header('Location:/../../index.php');
        exit();
    }

    $stmt->closeCursor();
    $pdo = null;

    header('Location:/../../views/group/edit.php');
    exit();

