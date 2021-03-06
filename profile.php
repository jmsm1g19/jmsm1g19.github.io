<?php
	// - Enable the current session
    if(!isset($_SESSION["loggedIn"])){
        session_start();
    }
	// - ensure a setting is selected and if not apply steps as default
	//   for 
	if(!isset($_GET['data'])){
		$data = 'steps';
	}else{
		$data = $_GET['data'];
	}
	// - Connect to the databse
	$con = mysqli_connect("localhost","id16230640_root","#5r*Qo@NaYF[WT6D", "id16230640_userdata");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MYSQL: ".mysqli_connect_error();
	}
	
	// - Get Smart Watch data and put the data into personalData array based on GET setting 
	$personalData = array();
	// - Get team rRate data and add to array.. 
	//   if user isnt part of a team then populate with teams that they can join
	$teamData = array();
	
	
	// - Get smartwatch data and add the data to the data array depending on what GET[data] variable is defined	
	$sql="SELECT * FROM SmartWatch WHERE Username = '".$_SESSION["user"]."' ORDER BY DateLog DESC LIMIT 7";
	$result=mysqli_query($con,$sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($data == 'steps'){
				array_push($personalData, $row["Steps"], $row["DateLog"]);
			}else if($data == 'altitude'){
				array_push($personalData, $row["Altitude"], $row["DateLog"]);
			}else if($data == 'timeOutside'){
				array_push($personalData, $row["TimeOutside"], $row["DateLog"]);
			}
		}
	}else{
		echo "no data";
	}
	
	// - Get virus Vanquisher data if rRate was set in the GET variable and put it in personalData array
	if($data = 'rRate'){
		
		$sql="SELECT * FROM Rrate WHERE Username = '".$_SESSION["user"]."' ORDER BY DateLog DESC LIMIT 7";
		$result=mysqli_query($con,$sql);
		if (mysqli_num_rows($result) > 0) {
			//output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				array_push($personalData, $row["Rrate"], $row["DateLog"]);
			}
		}
	}
	
	// - Get stats for the team the user has joined
	// - if they havent joined a team then get a list of teams that they can join
	$sql = "SELECT TeamName FROM UserData WHERE Username = '".$_SESSION["user"]."'";
	$result=mysqli_query($con,$sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		// - TODO check teamname isnt null
		if($row["TeamName"] != null){
			echo "found teamname";
			$sql="SELECT * FROM TeamScores WHERE TeamName = '".$row["TeamName"]."' ORDER BY DateLog DESC LIMIT 7";
			$result=mysqli_query($con,$sql);
			if (mysqli_num_rows($result) > 0) {
				//output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					array_push($teamData, $row["Rrate"], $row["DateLog"]);
				}
			}
		}else{
			echo "User doesn have a team.. getting teams";
			$sql="SELECT * FROM Team";
			$result=mysqli_query($con,$sql);
			if (mysqli_num_rows($result) > 0) {
				array_push($teamData, null);
				//output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					array_push($teamData, $row["TeamName"]);
				}
			}
		}
	}
	
	
	
	mysqli_close($con);

?>

<!doctype html>
<html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="navBar.css">
  <link rel="stylesheet" type="text/css" href="leaderboardEntry.css">
  <style>
    body{
      margin: 0px;
      background-color: #fff;
    }

    .banner{
      height: 145px;
    }
    div.justified {
            display: flex;
            justify-content: center;
    }

    .mainContent{
      width: 50%;
      height: 50vh;
      background-color: #fff;
    }


    .formHeader{
        margin:0 auto;
        font-family: Baskerville Old Face;
        font-size: 48px;
        color: #555;
        text-align: center;

    }

    .subHeader{
      font-size: 28px;
    }

    p.subHeader{
      margin: 10px auto;
      /*border-bottom: 2px solid #30373f;*/
      display: inline-block;
    }

    .left{
      text-align: left;
    }

    .metaButton{
    	width: 120px;
    	height: 50px;
    	border: none;
    	background-color: #30373f;
    	margin: 20px 20px;
    	color: #fff;
    	font-family: Baskerville Old Face;
    	font-size: 16px;
    }

    .metaButton:hover{
    	background-color: #505A66;
    }

    .formMeta{
    	display: inline-block;
    	resize: none;
    	border: none;
    	border-bottom: 2px solid #30373f;
    	font-size: 28px;
    	font-family: Baskerville Old Face;
    	padding: 0px;
    	margin: 15px 5px;
    	height: 34px;
    	overflow: hidden;
    	vertical-align: bottom;
    	background-color: inherit;
    }

    .formMeta:focus{
    	border-bottom: 4px solid yellow;
    	outline:none;
    }

    .inlineForm{
      margin: 8px 5px;
      height: 32px;
      font-weight: 200;
    }
	
	#scoreContainer{
		width:50%;
		background-color: #fff;
		margin: 0px auto;
		border: none;
	}
    
    /*##################################################
############FilterBar Styles########################
##################################################*/
.filterBar{
	margin: 0px;
	padding: 0px;
	background-color: #fff;
	width: 100%;
	overflow:hidden;
	text-align: center;
}

.filterBar ul {
    list-style-type: none;
    padding: 0;
	display: inline;
	width:100%;
}

.filterBar li{
	display: inline-block;
	padding: 0px 15px;
}

.filterBar li:hover{
	font-weight: bold;
}

.filterBar a{
	display: inline-block;
  vertical-align: middle;
	text-decoration: none;
	width: 100%;
	margin: 0px auto;
	font-family: Baskerville Old Face;
	color: #000;
	font-size: 22px;
	padding: 5px;
}

</style>

</head>
<body onload="">
  <div class="navBar">
	<p class="titleFont" style="margin-left: 10%">Boris Basher</p>
	<ul>
		<li style = "margin-right: 10%"><a class="navElement" id = "loginOrProfile" href="/login.php">Login/Register</a></li>
		<li><a class="navElement" href="/index.php">Leaderboard</a></li>
	</ul>
  </div>

  <?php
	    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "1"){
	        echo '<script type="text/javascript">
	                document.getElementById("loginOrProfile").textContent = "Log Out";
	                document.getElementById("loginOrProfile").href = "/logout.php";
	            </script>';
	    }
	?>
  
  <div class="navBar banner">
  </div>
  
  
  
  
  <div id="scoreContainer">
	<div style="width: 100%; margin-left: auto; margin-right: auto; border-bottom: 1px solid black; background-color: inherit;">
	<!-- 
	
	#####TODO TODO TODO update username based on session data TODO TODO TODO#####
	
	-->
		<h1 id = "profileName" class="formHeader">Profile for: </h1>
	</div>
	<!-- filterbar allows user to change which leaderboard to display by filtering the data-->
	<div class="filterBar">
		<ul>
			<li><a href="?data=steps">Steps</a></li>
			<li><a href="?data=altitude">Stairs Climbed</a></li>
			<li><a href="?data=timeOutside">Time Outside</a></li>
			<li><a href="?data=rRate">R-Rate</a></li>
		</ul>
	</div>
	<!-- Temporary div styles to contain graphs, should change with the filterbar styles feel free to change them but shares CSS with the
	filterbar on index page
	-->
	<div style="width: 100%; height: 300px; margin-left: auto; margin-right: auto; border: 1px solid black; background-color: inherit;">
			<canvas id="userDataChart" style = "width: 100%; height: 300px"></canvas>
	</div>
	
	<div style="width: 100%; margin-left: auto; margin-right: auto; border-bottom: 1px solid black; background-color: inherit;">

		<h1 id = "teamTitle" class="formHeader">Team Score</h1>
	</div>
	
	<!-- Temporary div styles to contain graphs for team R-Rate.. maybe compare against graph of team one rank above them and one below them
	-->
	<div id = "teamContainer" style="width: 100%; height: 300px; margin-left: auto; margin-right: auto; 
									 border: 1px solid black; background-color: inherit; margin-bottom: 50px; 
									 overflow-y: scroll; overflow-x: hidden">
		<canvas id="teamChart" style = "width: 100%; height: 300px"></canvas>
		<form id ="newTeam" style = "text-align: center" action = "registerUserToATeam.php" method = "get">
			<input type="text" name="teamName" placeholder="Or Create a Team!" class = "formMeta"><br>
			<input id = "submit" type="submit" value="Create" class = "metaButton">
		</form>
	</div>
  </div>
  
  
  <script>

    var dailySteps = <?php echo json_encode($personalData); ?>;
	var teamRrate = <?php echo json_encode($teamData); ?>;
	var userName = <?php echo json_encode($_SESSION["user"]); ?>;
	document.getElementById("profileName").innerHTML  = "Profile for: " + userName;
	console.log(dailySteps);
	
	
	
	var userData = [parseInt(dailySteps[12]),
					parseInt(dailySteps[10]),
					parseInt(dailySteps[8]),
					parseInt(dailySteps[6]),
					parseInt(dailySteps[4]),
					parseInt(dailySteps[2]),
					parseInt(dailySteps[0])];

	var userDates = [dailySteps[13], 
					 dailySteps[11], 
					 dailySteps[9], 
					 dailySteps[7], 
					 dailySteps[5], 
					 dailySteps[3], 
					 dailySteps[1]];
	
	function displayTeams(teamNames){
		var canvas = document.getElementById('teamChart');
		canvas.style.display = "none";
		document.getElementById('teamTitle').innerHTML = "Choose a Team!";
		for(var i = 0; i < teamNames.length; i++){
			var newEntry = document.createElement("div");
			newEntry.setAttribute("class", "leaderboardEntry");
			newEntry.setAttribute("onclick", "window.location.href='registerUserToATeam.php?teamName=" + teamNames[i] + "'");
			
			var teamName = document.createElement("p");
			teamName.innerHTML = teamNames[i];
			teamName.setAttribute("class", "formHeader subHeader center");
			
			newEntry.appendChild(teamName);
			var container = document.getElementById("teamContainer");
			container.appendChild(newEntry);
		}
	}
 
	// - setup canvas function taken from: https://www.html5rocks.com/en/tutorials/canvas/hidpi/
	// - modifies the canvas resolution based on the client's display dpi
	function setupCanvas(canvas) {
		// Get the device pixel ratio, falling back to 1.
		var dpr = window.devicePixelRatio || 1;
		// Get the size of the canvas in CSS pixels.
		var rect = canvas.getBoundingClientRect();
		// Give the canvas pixel dimensions of their CSS
		// size * the device pixel ratio.
		canvas.width = rect.width * dpr;
		canvas.height = rect.height * dpr;
		console.log("Width: " + canvas.width + " Height: " + canvas.height);
		var ctx = canvas.getContext('2d');
		// Scale all drawing operations by the dpr, so you
		// don't have to worry about the difference.
		ctx.scale(dpr, dpr);
		return ctx;
	}
	
	function draw(dataPoints, dates){
		var canvas = document.getElementById('userDataChart');
		var ctx = setupCanvas(canvas);
		var width = canvas.width / window.devicePixelRatio;
		var height = canvas.height / window.devicePixelRatio;
		console.log("Adjusted canvas dimensions: " + width + ", " + height);
		
		ctx.lineWidth = 1;
		ctx.strokeStyle = "#000000";
		ctx.beginPath();
		
		// - axis
		ctx.moveTo(25, height-50);
		//ctx.lineTo(50, height - 50);
		ctx.lineTo(width - 25, height - 50);
		// - TODO add arrows
		
		var xAxisSpacing = (width -100)/7; // - display 7 days of the week
		
		// - x axis points
		for(var i = 1; i < 8; i++){
			ctx.moveTo((50+xAxisSpacing*i), height-52);
			ctx.lineTo((50+xAxisSpacing*i), height-48);// - 4px axis markers
		}
		
		
		// - find max steps
		var max = 0;
		for(var i = 0; i < dataPoints.length; i++){
			console.log(dataPoints[i])
			if(dataPoints[i] > max){
				max = dataPoints[i];
			}
		}
		console.log("Max: " + max);
		var pixelToValueRatio = (height-75)/max;
		
		// - Draw dataPoints
		ctx.fillStyle = "#30373f";
		ctx.moveTo(50, height - 50);
		for(var i = 0; i < dataPoints.length; i++){
			ctx.fillRect(50+xAxisSpacing*i, (height-50 - dataPoints[i]*pixelToValueRatio), xAxisSpacing,(dataPoints[i]*pixelToValueRatio));
			//ctx.lineTo((50+(xAxisSpacing)*(i+1) - xAxisSpacing/2), (height-50 - dataPoints[i]*pixelToValueRatio));
		}
		
		// - Todo add dates
		ctx.textAlign = "center";
		ctx.font = "18px Arial";
		
		for(var i = 0; i < 7; i++){
			ctx.fillText(dates[i], (50+xAxisSpacing*(i+1))-xAxisSpacing/2, height-25)
			ctx.fillText(dataPoints[i], (50+xAxisSpacing*(i+1))-xAxisSpacing/2, (height-50 - dataPoints[i]*pixelToValueRatio));
		}
		
		ctx.stroke(); 
	
	}
	draw(userData, userDates);
	//draw(userData, userDates);
	if(teamRrate[0] == null){
		teamRrate.shift()
		displayTeams(teamRrate);
	}else{
		
	}
  </script>
</body>
</html>
