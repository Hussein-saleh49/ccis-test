<?php

require __DIR__."/core/DBmanager.php";
require __DIR__."/core/filemanager.php";
require __DIR__."/helper/functions.php";


session_start();
$is_authenticated = !empty($_SESSION['manager']);

    if (! $is_authenticated) {
        $_SESSION['error'] = [
            'Unauthenticated!'
        ];
        header(header: 'Location: login.php');
        exit;
    }

    $pdo = new DBmanager();
    
    if(isset($_SESSION["manager"])){
        $manager=unserialize($_SESSION["manager"]);
        $manager_id=$manager["id"];

      

        
        
        if(SERVER()->isgetrequest()){
            if(! empty (REQUEST()->has("action")) && REQUEST()->equal("action","delete")){
                $employee_id=REQUEST()->get("id");
        //         //delete file
        // $sql = "SELECT picture FROM employees WHERE id=? AND manager_id=?";
        // $stmt= $pdo->doquery($sql,$employee_id,$manager_id);
        //  $emp=$stmt->fetchall(PDO::FETCH_ASSOC);
        // if(! FILEMANAGER()->delete($emp["picture"]));{
        //     throw new Exception("error with deleting file");
        // }

        $sql="DELETE FROM employees WHERE id=? AND manager_id=?";
        $stmt=$pdo->doquery($sql,$employee_id,$manager_id);

        if($stmt->rowcount() <=0){
            $_SESSION["error"]=["no employee provided yet"];
            header("location: home.php");
            exit;
        }else{
            $_SESSION["success"]=["employee is deleted successfully"];
            header("location: home.php");
            exit;
        }


    }
}


$sql= "SELECT * FROM employees WHERE manager_id=? ";
$stmt = $pdo->doquery($sql,$manager_id);
$employees=$stmt->fetchall(PDO::FETCH_ASSOC);

}else{
    $_SESSION["error"]=["manager is not logged in"];
    header("location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Employees</title>
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
                    <form method="POST" action="logout.php">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Employees Managed by You</h2>
            <a href="add_employee.php" class="btn btn-success btn-lg">Add Employee</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Picture</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($employees) <= 0): ?>
                            <tr>
                            <td colspan="5" class="text-center align-middle">No data added yet!</td>
                            </tr>
                        <?php endif; ?>
                    <?php foreach($employees as $employee) : ?>
                    <tr>
                        <td><?php echo $employee["name"];?></td>
                        <td><?php echo $employee["email"];?></td>
                        <td><?php echo $employee["phone"]; ?></td>
                        <td><img src="uploads/<?php echo $employee["picture"]; ?>" alt="image" width="50" height="50" class="rounded"></td>
                        <td>
                            <a href="edit_employee.php?id=<?php echo $employee["id"]; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="home.php?action=delete&id=<?php echo $employee["id"];  ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Employee Management System</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
