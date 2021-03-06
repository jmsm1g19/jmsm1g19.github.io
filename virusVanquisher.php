<?php

$con = mysqli_connect("localhost","id16230640_root","#5r*Qo@NaYF[WT6D", "id16230640_userdata");

if (mysqli_connect_errno()){
	echo "Failed to connect to MYSQL: ".mysqli_connect_error();
}
if( $_POST["rrate"] && $_POST["borisID"] && $_POST["date"]){
	//echo "Post data received";
    $rrate = $_POST['rrate'];
    $borisID = $_POST['borisID'];
	$date = $_POST['date'];
	
	$sql = "SELECT Username FROM UserData WHERE BorisID = '".$borisID."'"; 
	$result=mysqli_query($con,$sql);
	if (mysqli_num_rows($result) > 0) {
	//output data of each row
		$row = mysqli_fetch_assoc($result);
		$username = $row["Username"];
		//echo "found username for borisID";
	}else{
		echo "cannot find a username corresponding to the BorisID: ".$borisID;
	}
	
	$sql="INSERT INTO Rrate (DateLog, Username, Rrate) VALUE('".$rrate."','".$username."','".$date."')";

    if($result=mysqli_query($con,$sql)){
        mysqli_free_result($result);
		///echo "everything is working correctly.. wowzers!!";
    }else{
		echo "couldnt add a new entry to the Rrate Table.. probably to do with date format but if you get this then everything youe end is okay";
    }
    
}else{
    echo "Have not received one of: rrate, borisID or date... ensure all 3 are sent at once";
}
mysqli_close($con);
exit();
?>