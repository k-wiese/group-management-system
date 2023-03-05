<?php
    session_start();

    if(isset($_SESSION['delete_user_message']))
    {
        unset($_SESSION['delete_user_message']);
    }
    
    if(isset($_SESSION['delete_group_message']))
    {
        unset($_SESSION['delete_group_message']);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body class="bg-dark text-white">
<div class="container " style="margin-top:34vh">
    <div class="row justify-content-center">
        <p class="display-6 text-center mb-3"> Group Management System</p>
    
        <?php
            if(isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true)
            {
                
                print '
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 mt-5 text-center">
                            <div class="p-2">
                                <a href="/scripts/user/ReadUser.php">
                                    <button class="d-block w-100 btn btn-outline-light">Manage Users</button>
                                </a>

                            </div>
                            <div class="p-2">
                                <a href="/scripts/group/ReadGroup.php">
                                    <button class="d-block w-100 btn btn-outline-light">Manage User Groups</button>
                                </a>
                            </div>
                            <div class="p-2">
                                <a href="/scripts/Logout.php">
                                    <button class="d-block w-100 btn btn-outline-light">Log out</button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                ';
            }
            else
            {
                print
                '
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <form action="/scripts/Login.php" method="POST">

                                <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input name="username" class="form-control" id="username">
                                </div>
                                <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                                </div>

                                <button type="submit" class="btn btn-outline-light">Log In</button>

                            </form>
                        </div>
                    </div>
                </div>
                ';
                if(isset($_SESSION['login_message']))
                {
                    print 
                    '
                    <div class="row justify-content-center">
                        <div class="col-sm-6 mt-3 alert alert-danger fs-5">
                            '.$_SESSION['login_message'].'
                        </div>
                    </div>
                    ';
                }
            }
        ?>
       
    </div>

</div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>