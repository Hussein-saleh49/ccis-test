<?php
$errors=$_SESSION["error"] ??[];
unset ($_SESSION["error"]);
?>

<?php if(! empty($errors)) :?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors as $error) :?>
                <li><?php echo $error ?></li>
            <?php endforeach; ?>    
        </ul>
    </div>
    <?php endif;?>
