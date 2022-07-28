<?php
//session_destroy();
session_start();
//session_destroy();

//unset($_SESSION);
$_SESSION['glpiname'] = "spgg-marlon-dietrich";
$_SESSION['glpiID'] = 31;

echo "Login realizado!<br>";
print_r($_SESSION);


//header("location:./index.php");                                               