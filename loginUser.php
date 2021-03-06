<?php

$con = mysqli_connect("localhost","id16230640_root","#5r*Qo@NaYF[WT6D", "id16230640_userdata");

if (mysqli_connect_errno()){
	echo "Failed to connect to MYSQL: ".mysqli_connect_error();
}
if( $_POST["userName"] && $_POST["password"]){
    $Username = $_POST['userName'];
    $Password = $_POST['password'];
	
	$sql="SELECT PasswordHash FROM UserData WHERE Username = '".$Username."'";

    $result=mysqli_query($con,$sql);
	if (mysqli_num_rows($result) > 0) {
	//output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			if($Password == $row["PasswordHash"]){
			    //echo "Login Successful";
			    session_start();
                $_SESSION["loggedIn"] = "1";
                $_SESSION["user"] = $Username;
			}else{
			    //echo "incorrect Password";
			}
		}
	} else {
		//echo "Incorrect Username";
	}
}else{
    //echo "need to fill both username and password fields";
}
mysqli_close($con);
header('Location: https://borisbasher.000webhostapp.com/index.php');

exit();
?>