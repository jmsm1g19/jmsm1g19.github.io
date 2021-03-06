<?php

// Logout script
if(!isset($_SESSION["loggedIn"])){
	session_start();
    
}
  
// destroy everything in this session
  
unset($_SESSION["user"]);
$_SESSION["loggedIn"] = 0;
session_unset();
session_destroy();
session_write_close();
session_unset();
session_write_close();
header('Location: https://borisbasher.com/index.php');

exit();

?>