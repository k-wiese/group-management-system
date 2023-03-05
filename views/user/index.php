<?php

    session_start();
    if($_SESSION['logged_in'] !== true)
    {
        header('Location:/../index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="bg-dark text-white">
    
    <div class="container " style="margin-top:30vh">
        <div class="row justify-content-center">
            <div class="col-sm-8">

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/../../index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Users</li>
                </ol>
                </nav>
                <a href="/../../index.php">
            <button class="btn btn-outline-light btn-sm mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                    </svg>  Go back 
                </button>
            </a>
                <p class="display-6 text-center mb-3">List of all users</p>
            <table class="table text-white align-center text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Birth date</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($_SESSION['users'] as $user)
                    {
                        print 
                        '
                        <tr>
                            <th scope="row">'.$user['id'].'</th>
                            <td>'.$user['username'].'</td>
                            <td>'.$user['first_name'].' '.$user['last_name'].'</td>
                            <td>'.$user['birth_date'].'</td>
                            <td> 
                                <a href="/../../scripts/user/EditUser.php?id='.$user['id'].'">
                                    <button class="btn btn-sm btn-outline-warning" > Edit </button>
                                </a>
                            </td>
                            
                            
                            <td> 
                            <form method="post" action="/../../scripts/user/DeleteUser.php">
                                <input type="hidden" value="'.$user['id'].'" name="id"/>
                                <button class="btn btn-sm btn-outline-danger" > Delete </button>
                            </form>
                            </td>
                        </tr>                        
                        ';
                    }
                ?>
                </tbody>
            </table>
            </div>

        </div>
        <?php
            if(isset($_SESSION['delete_user_message']))
            {
                print '
                <div class="row justify-content-center">
                    <div class="col-sm-8 mt-3 alert alert-warning fs-5">
                    '.$_SESSION['delete_user_message'].'
                    </div>
                </div>
                ';
            }
        ?>
        <div class="row justify-content-center mt-4">
            <div class="col-sm-8">
                <a href="/views/user/create.php">
                    <button class="btn btn-outline-light d-block w-100">Add new User</button>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>
</html>
