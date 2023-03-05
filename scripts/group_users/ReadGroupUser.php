<?php

session_start();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (empty($_GET['group_id']))
    {
        $_SESSION['message'] = 'ID not provided.';
        header('Location:/../group/ReadGroup.php');
        exit();
    }

    if(isset($_SESSION['users'])){
        unset($_SESSION['users']);
    }
    
    require_once __DIR__.'/../../db/config.php';

    try {

        $group_id = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);

        if (!$group_id) {
            throw new Exception("Invalid input data");
        }

        $_SESSION['group_id'] = $group_id;

        $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM user_group_map WHERE group_id = :group_id");
        $stmt->execute([':group_id' => $group_id]);
        
        $group_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user_ids = [];
        foreach($group_rows as $row)
        {
            array_push($user_ids, $row['user_id']);
        }
        if(count($user_ids) > 0)
        {
            $users = [];
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id IN (" . implode(',', $user_ids) . ")");
            $stmt->execute();
    
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $stmt->closeCursor();
    
            $_SESSION['users'] = $users;
         
    
            header('Location: /../../views/group_users/index.php');
            exit;
        }else
        {
            header('Location: /../../views/group_users/index.php');
            exit;
        }

        
        
      

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    
    header('Location:/views/group_users/index.php');
    exit();
} 
else {
    header("Location: ReadGroup.php");
    exit();
}

