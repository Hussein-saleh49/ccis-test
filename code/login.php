<?php

use App\Models\Auth;

require __DIR__."/core/DBmanager.php";
require __DIR__."/helper/functions.php";
// require __DIR__."/models/auth.php";

session_start();
// $user = auth();
$is_authenticated = !empty($_SESSION['manager']);

if ($is_authenticated) {
    $_SESSION['error'] = [
        'Logout, first!'
    ];
    header('Location: home.php');
    exit;
}


if(SERVER()->ispostrequest()){
    // extract($_POST);
    $email=REQUEST()->get("email");
    $password=REQUEST()->get("password");
    
    try{
        $pdo=new DBmanager(); 

        $sql="SELECT * FROM managers WHERE email=:email";
        $stmt=$pdo->doquery($sql, ...compact('email'));
        $manager=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($manager){
            if(password_verify($password,$manager["password"])){
                $_SESSION["manager"]=serialize($manager);
                var_dump($_SESSION["manager"]);
                $_SESSION["success"]=["logged in successfully"];
                header("location: home.php");
                die;

            }else{
                $_SESSION["error"]=["wrong password"];
            }
        }else{
            $_SESSION["error"]=["user is not found"];

        }

     

    }catch(\PDOException $e){
        $_SESSION["error"]=["try again later".$e->getmessage()];
        header("location: login.php");
        die;

    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
 <?php include __DIR__."/compoents/messages/error.php"?>
 <?php include __DIR__."/compoents/messages/message.php"?>

    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Employee Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h3 class="text-center mb-4">Manager Login</h3>
            
           
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

    
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Employee Management System</p>
    </footer>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
