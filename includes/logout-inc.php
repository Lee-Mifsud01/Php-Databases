<?php 

// Here we empty any session value, and destroy the session entirely

session_start();
session_unset();
session_destroy();

header("location: ../index.php");
echo "Redirecting .......";
exit();

?>