<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!isset($_SESSION['logged_in']) or $_SESSION['logged_in'] !== true) {
        header('Location: /../../index.php');
        exit();
    }

    require_once __DIR__.'/../../db/config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        try {
            $newGroupName = filter_input(INPUT_POST, 'group_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $editedId = filter_input(INPUT_POST, 'edited_id', FILTER_VALIDATE_INT);

            if (!$newGroupName or !$editedId) {
                throw new Exception("Invalid input data");
            }

            $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("UPDATE user_groups SET group_name = ? WHERE id = ?");
            $stmt->execute([$newGroupName, $editedId]);

            if ($stmt->rowCount() === 1) {
                $_SESSION['edit_group_message'] = "Group updated successfully (id:".$editedId.')';
                header("Location: EditGroup.php?id=$editedId");
                exit();
            } else {
                throw new Exception("Error updating group : ".$editedId.' '. $pdo->errorInfo()[2]);
            }
        } catch (Exception $e) {
            $_SESSION['edit_group_message'] = "Error updating group: " . $e->getMessage();
            header("Location: EditGroup.php?id=$editedId");
            exit();
        }
    } else {
        header("Location: EditGroup.php?id=$editedId");
        exit();
    }
