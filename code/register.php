<?php
require __DIR__."/core/DBmanager.php";
require __DIR__."/helper/functions.php";
// require __DIR__."/models/auth.php";

session_start();
// $user=auth();
$is_authenticated = !empty($_SESSION['manager']);

    if ($is_authenticated) {
        $_SESSION['errors'] = [
            'Logout, first!'
        ];
        header('Location: home.php');
        exit;
    }


if(SERVER()->ispostrequest()){
    // extract($_POST);
    $name=REQUEST()->get("name");
    $email=REQUEST()->get("email");
    $password=REQUEST()->get("password");
    $password_confirmation=REQUEST()->get("password_confirmation");
    
if($password!== $password_confirmation){
    $_SESSION["error"]=["password do not match"];
    header("location: register.php");
    exit;
}    
if(empty($password) || strlen($password)<8){
     $_SESSION["error"]=["password must be at least 8 charcters"];
    header("location: register.php");
    exit;
}
if(empty($_SESSION["error"])){
    $password=password_hash($password,PASSWORD_DEFAULT);
    try{
        $pdo=new DBmanager();
        $sql="INSERT INTO managers(name,email,password) VALUES(:name,:email,:password)";
        $pdo->doquery($sql,...compact('name','email','password'));
        
        $sql="SELECT * FROM managers WHERE email=:email";
        $stmt=$pdo->doquery($sql, ...compact('email'));
        $manager=$stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $_SESSION["manager"]=serialize($manager);
        $_SESSION["success"]=["account is created successfully"];
        header("location: home.php");
        die;

    }catch(\PDOException $e){
        $_SESSION["error"]=[$e->getmessage()];
        header("location: register.php");
        die;

    }


}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Register</title>
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
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h3 class="text-center mb-4">Manager Registration</h3>


            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" >
                </div>
                <div class="form-group">
                    <label for="password_confirmation">password_confirmation</label>
                    <input type="password" class="form-control" id="password_confirmation   " name="password_confirmation" placeholder="confirm your password">
                </div>
                <button type="submit" class="btn btn-success btn-block">Register</button>
            </form>

            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php">Login here</a></p>
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
