<?php
$messages=$_SESSION["success"] ??[];
unset($_SESSION["success"]);
?>
<?php if(! empty($messages)) :?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <ul>
            <?php foreach($messages as $message) :?>
                <li><?php echo $message ?></li>
            <?php endforeach; ?>    
        </ul>
    </div>
    <?php endif;?>

