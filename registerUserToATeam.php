<?php

$con = mysqli_connect("localhost","id16230640_root","#5r*Qo@NaYF[WT6D", "id16230640_userdata");

if (mysqli_connect_errno()){
	//echo "Failed to connect to MYSQL: ".mysqli_connect_error();
}
if(isset($_GET["teamName"])){ 
	$sql="UPDATE UserData SET TeamName = '".$_GET["teamName"]."'";

    if($result=mysqli_query($con,$sql)){

    }else{
		echo("Error description: " . mysqli_error($con));
	}
}
mysqli_close($con);
header('Location: http://borisbasher.com/profile.php');
exit();
?>