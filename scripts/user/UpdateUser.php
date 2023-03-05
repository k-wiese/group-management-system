<?php

    session_start();
    
    // Redirect to login page if user is not logged in
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
        header('Location: /../../index.php');
        exit();
    }

    // Turn on error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Require database configuration file
    require_once __DIR__.'/../../db/config.php';

    try {
        // Create a PDO instance to connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);

        // Set PDO to throw exceptions when errors occur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement for updating the user
        $stmt = $pdo->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, birth_date = ? WHERE id = ?");

        // Bind the parameters to the prepared statement
        $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $_POST['firstName'], PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['lastName'], PDO::PARAM_STR);
        $stmt->bindParam(4, $_POST['birthDate'], PDO::PARAM_STR);
        $stmt->bindParam(5, $_POST['edited_id'], PDO::PARAM_INT);

        // Execute the prepared statement
        if ($stmt->execute()) 
        {
            // Set a success message in the session variable and redirect to the EditUser page
            $_SESSION['edit_user_message'] = "User updated successfully";
            header('Location: EditUser.php?id=' . $_POST['edited_id']);
            exit();
        } else 
        {
            // Set an error message in the session variable and redirect to the EditUser page
            $_SESSION['edit_user_message'] = "Error updating user: " . $pdo->errorInfo()[2];
            header('Location: EditUser.php?id=' . $_POST['edited_id']);
            exit();
        }
    } catch (PDOException $e) {
        // If an error occurs, display the error message and stop executing the script
        echo "Error: " . $e->getMessage();
        die();
    } finally {
        // Close the database connection
        $pdo = null;
    } 

?>