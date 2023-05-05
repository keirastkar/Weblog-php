<?php
session_start();
include("./include/config.php");
include("./include/db.php");

if (isset($_POST['signin'])) {

    if (trim($_POST['email'] != "") && trim($_POST['password']) != "" && trim($_POST['name']) != "") {
        $user_email = $_POST['email'];
        $sql = "SELECT email FROM subscribers WHERE email = '$user_email'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) <1) {


            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user_create = $db->prepare("INSERT INTO `subscribers` (`name` , `email`, `password`) VALUES (:name , :email, :password)");
            $user_create->execute([':name' => $name, ':email' => $email, ':password' => $password]);
            $last_insert_id = $db->lastInsertId();
            if ($last_insert_id) {
                $_SESSION['email'] = $email;
                header("Location:login.php");
                exit();
            }

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

        } else {
            header("Location:signin.php?err_msg= This email is already exists");
            exit();
        }
    }else {
        header("Location:signin.php?err_msg= The fields are nessesery");
        exit();

    }
}
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/admin.css" />

    <title>Sign up Page</title>
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
            <h3 class="text-white text-center pt-3">Sign up</h3>
            <div class="card-body" style="width: 400px">
                <form method="post">
                    <div class="form-group">
                        <label class="text-white" for="email">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name...">
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email...">
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password...">
                    </div>
                    <div class="checkbox mb-3">
                        <label class="text-white">
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <a href="login.php">Already have an account?</a>
                    <button type="submit" name="signin" class="btn btn-outline-primary btn-block">Sign up</button>
                </form>

            </div>

        </div>
    </div>
</div>
</body>