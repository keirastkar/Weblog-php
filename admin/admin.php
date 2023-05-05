<?php
session_start();
include("./include/config.php");
include("./include/db.php");

if (isset($_POST['admin'])) {

    if (trim($_POST['email']) != "" || trim($_POST['password']) != "") {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user_select = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password ");
        $user_select->execute(['email' => $email, 'password' => $password]);

        if ($user_select->rowCount() == 1) {
            $_SESSION['email'] = $email;
            header("Location:index.php");
            exit();
        }
    } else {
        header("Location:admin.php?err_msg= fields are necessary");
        exit();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/admin.css" />

    <title>Admin Page</title>
</head>

<body>
    <div class="container">

        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
            <div class="card bg-dark">
                <?php
                if (isset($_GET['err_msg'])) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_GET['err_msg'] ?>
                    </div>
                <?php
                }
                ?>
                <h3 class="text-white text-center pt-3">Login</h3>
                    <div class="card-body" style="width: 400px">
                        <form method="post">
                            <div class="form-group">
                                <label class="text-white" for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email...">
                            </div>
                            <div class="form-group">
                                <label class="text-white" for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password...">
                            </div>

                            <button type="submit" name="admin" class="btn btn-outline-primary btn-block">Login</button>
                        </form>
                    </div>

            </div>
        </div>
    </div>
</body>