<?php
if(!isset($_SESSION["loggedIn"])){
	session_start();
    
}

$con = mysqli_connect("localhost","id16230640_root","#5r*Qo@NaYF[WT6D", "id16230640_userdata");

if (mysqli_connect_errno()){
	//echo "Failed to connect to MYSQL: ".mysqli_connect_error();
}
if( $_POST["userName"] && $_POST["password"] && $_POST["deviceID"]){ 
    $Username = $_POST['userName']; 
    $Password = $_POST['password'];
	$borisID = $_POST['deviceID'];
	
	if(substr($borisID, 0, 2) == "BO"){
		$sql="INSERT INTO UserData (Username, PasswordHash, BorisID) VALUE('".$Username."','".$Password."','". $borisID."')";
	}else if(substr($borisID, 0, 2) == "SW"){
		$sql="INSERT INTO UserData (Username, PasswordHash, WatchID) VALUE('".$Username."','".$Password."','". $borisID."')";
	}
	
	//echo substr($borisID, 0, 2);

    if($result=mysqli_query($con,$sql)){
		//echo "opening session";
		$_SESSION["loggedIn"] = "1";
		$_SESSION["user"] = $Username;
		
    }else{
		echo("Error description: " . mysqli_error($con));
	}
}
mysqli_close($con);
header('Location: http://borisbasher.com/profile.php');
exit();
?>