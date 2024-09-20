<?php
session_start();

unset($_SESSION["manager"]);
$_SESSION["success"]=["logged out successfully"];
header("location: login.php");
exit;
?>

