<?php
require __DIR__."/core/DBmanager.php";
require __DIR__."/core/filemanager.php";
require __DIR__."/helper/functions.php";
session_start();

$pdo = new DBmanager();

if(SERVER()->ispostrequest()){
    $name = REQUEST()->get("name");
    $email = REQUEST()->get("email");
    $phone = REQUEST()->get("phone");   
    $picture = REQUEST()->getfile("picture");
    // var_dump($picture);
    if($picture){
        // move_uploaded_file($picture["tmp_name"],__DIR__."/uploads/".".".explode(".",$picture["name"])[1]);
        $picture = FILEMANAGER()->store($picture);
       if ($picture === false){
         throw new Exception("error in file path with uploads");

        }
    }
    if(isset($_SESSION["manager"])){
        $manager = unserialize($_SESSION["manager"]);
        $manager_id = $manager["id"];
    }
    $sql="INSERT INTO employees (name,email,phone,picture,manager_id)VALUES(?,?,?,?,?)";
    $stmt = $pdo->doquery($sql,$name,$email,$phone,$picture,$manager_id);
    $_SESSION["success"]=["employess is inserted successfully"];
   header("location: home.php");
   exit;
}









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add Employee</title>
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
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="logout.php">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h3 class="text-center mb-4">Add Employee</h3>

            
           
            <form action="add_employee.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter employee's name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter employee's email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter employee's phone" required>
                </div>
                <div class="form-group">
                <label for="picture">Picture:</label>
                <input type="file" class="form-control" name="picture" id="picture" accept="image/*" onchange="previewImage(event)" required><br>
                  </div>
                
                <button type="submit" class="btn btn-success btn-block">Add Employee</button>
            </form>
        </div>
    </div>

    
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Employee Management System</p>
    </footer>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
