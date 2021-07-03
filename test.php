<?php
$test = "password";
$password = password_hash($test, PASSWORD_DEFAULT);

echo $password;
header("Location: test2.php");

?>
