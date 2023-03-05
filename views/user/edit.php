<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new User</title>
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
                    <li class="breadcrumb-item"><a href="/scripts/user/ReadUser.php">List Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
                </nav>
            <a href="/scripts/user/ReadUser.php">
            <button class="btn btn-outline-light btn-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                    </svg>  Go back 
                </button>
                </a>
                <p class="display-6 text-center">Edit information about user (id: <?php echo($_SESSION['edited_user_id']) ?>)</p>
                <form action="/../../scripts/user/UpdateUser.php" method="post">
                    <input value="<?php echo($_SESSION['edited_user_id']) ?>" type="hidden" name="edited_id">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username">Username</span>
                        <input value="<?php echo($_SESSION['edited_user_username']) ?>" 
                        name="username" type="text" class="form-control" placeholder="Username" aria-label="Username"
                            aria-describedby="username">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="firstname">First name</span>
                        <input value="<?php echo($_SESSION['edited_user_first_name']) ?>"  name="firstName" type="text" class="form-control" placeholder="First name" aria-label="First_name"
                            aria-describedby="firstname">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lastname">Last name</span>
                        <input value="<?php echo($_SESSION['edited_user_last_name']) ?>"  name="lastName" type="text" class="form-control" placeholder="Last name" aria-label="Last_name"
                            aria-describedby="lastname">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="birth_date">Birth Date</span>
                        <input value="<?php echo($_SESSION['edited_user_birth_date']) ?>"  name="birthDate" type="date" class="form-control" placeholder="Birth date" aria-label="Birth_date"
                            aria-describedby="birth_date">
                    </div>
                    <?php
                    if(isset($_SESSION['edit_user_message']))
                    {
                        print '
                        <div class="row justify-content-center text-center">
                            <div class="col-sm-12 mt-3 alert alert-warning fs-5">
                            '.$_SESSION['edit_user_message'].'
                            </div>
                        </div>
                        ';
                    }
                    ?>
       
                    <button type="submit" class="btn btn-outline-light d-block w-100">Edit user</button>

                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>

</html>
