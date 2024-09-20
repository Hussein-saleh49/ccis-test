<?php 
require __DIR__."/core/DBmanager.php";
require __DIR__."/core/filemanager.php";
require __DIR__."/helper/functions.php";

session_start(); 
$pdo = new DBmanager();

$employee_id = request()->get('id');
if (! $employee_id) {
    header(header: "Location: home.php", response_code: 404);
    exit;
}


    $sql = "SELECT * FROM employees WHERE id = ?"; 
    $stmt = $pdo->doquery($sql, $employee_id); 
    $employee = $stmt->fetch(PDO::FETCH_ASSOC); 
 
    if (! $employee) {
        header(header: "Location: home.php", response_code: 404);
        exit;
    }
    if (server()->isPostRequest()) {

        $name = REQUEST()->get('name');
        $email = REQUEST()->get('email');
        $phone= REQUEST()->get('phone');
        $picture = REQUEST()->getfile('picture');

        $manager= unserialize($_SESSION['manager']); 
        $manager_id = $manager["id"];
        if ($employee['manager_id'] != $manager_id) { 
            $_SESSION['errors'] = ['you can not edit here']; 
            header("Location: home.php"); 
            exit; 
        } 

        $sql = "UPDATE employees SET name = ?, email = ?, phone = ?, picture = ? WHERE manager_id = ?";
       
        if ($picture['size'] > 0) {
            $picture = FILEMANAGER()->store($picture);
            if ($picture === false) {
                throw new Exception("Error in file paths while uploads - From helper function fileManager()");
            }
           
            $stmt = $pdo->doquery($sql, $name, $email, $phone, $picture, $manager_id);
        }else {
            
            $sql = "UPDATE employees SET name = ?, email = ?, phone = ? WHERE manager_id = ?";
            $pdo->doquery($sql, $name, $email, $phone, $manager_id);
        }

        $_SESSION['success'] = ['employee updated successfully!'];
        header('Location: home.php');
        exit;
    }
 
    
   
 
    
   

?> 
 
<!DOCTYPE html> 
<html lang="ar"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>edit employee</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
</head> 
<body class="bg-dark text-light"> 
    
    <?php include __DIR__."/compoents/messages/error.php"?>
<?php include __DIR__."/compoents/messages/message.php"?>

 
    <div class="container mt-5"> 
        <h1>تعديل بيانات الموظف</h1> 
     <form action="edit_employee.php?id=<?php echo htmlspecialchars($employee_id); ?>" method="POST" enctype="multipart/form-data"> 
    <div class="mb-3"> 
        <label for="name" class="form-label">name</label> 
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $employee['name']; ?>"> 
    </div> 
    <div class="mb-3"> 
        <label for="email" class="form-label">email</label> 
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['email']; ?>"> 
    </div> 
    <div class="mb-3"> 
        <label for="phone" class="form-label">phone</label> 
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $employee['phone']; ?>"> 
    </div> 
    <div class="mb-3"> 
        <label for="picture" class="form-label">picture</label> 
        <input type="file" class="form-control" id="picture" name="picture"> 
    </div> 
    <button type="submit" class="btn btn-primary">UPDATE</button> 
</div>
</form>
</body>
</html>