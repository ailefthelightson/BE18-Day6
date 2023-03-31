<?php

session_start();

if(isset($_SESSION["user"])){
    header("Location: home.php");
}
if(isset($_SESSION["adm"])){
    header("Location: dashboard.php");
}
require_once "components/db_connect.php";

$email = $passError = $password = $emailError = "";

$error = false;

if(isset($_POST['btn-logic'])){
    $email = trim($_POST["email"]);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = trim($_POST["password"]);
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    if(empty($email)){
        $error=true;
        $emailError = "Please enter your email address";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error=true;
        $emailError = "Please enter your password";
    }
    if (empty($password)){
        $error=true;
        $passError = "Please enter your password";
    }
    if(!$error){
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM `users` WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);

        if($count == 1){
            if($row["status"] == "adm"){
                $_SESSION["adm"] = $row["id"];
                header("dashboard.php");
                exit;
            }else{
                if($row["status"] == "user"){
                    $_SESSION["user"] == $row["id"];
                    header("Location: home.php");
                    exit;
                }
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php require_once "components/boot.php";?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN HERE</title>
</head>
<body>
    <div class="container">
        <form class="w-75"  action="<?=htmlspecialchars($_SERVER['SCRIPT_NAME'])?>" autocomplete="off" enctype="multipart/form-data" method="post">
    <h1>LOGIN HERE</h1>
    <hr>
    <input type="email" autocomplete="off" placeholder="your email" class="form-control" name="email" value="<?=$email?>" maxlength="256">
    <span class="text-danger"><?=$emailError?></span>   

    <input type="password" placeholder="your password" class="form-control" name="password" maxlength="15">
    <span class="text-danger"><?=$passError?></span>

    <button class="btn btn-block btn-primary" type="submit" name="btn-logic">Sign In</button>
    
    </form>
<h3>Haven't registered?</h3>
<a href="register.php">Click here to register</a>
    </div>
</body>
</html>