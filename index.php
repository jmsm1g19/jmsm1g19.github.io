<?php
    if(!isset($_SESSION["loggedIn"])){
        session_start();
    }
?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="navBar.css">
<link rel="stylesheet" type="text/css" href="filterBar.css">
<link rel="stylesheet" type="text/css" href="leaderboardEntry.css">
<link rel="stylesheet" type="text/css" href="./reset.css">
<link rel="shortcut icon" href="./favicon.ico">
<title>Boris Basher</title>
<style>
body{
	margin: 0px;
	background-color: #fff;
}

.banner{
	height: 145px;
}

.formHeader{
		margin:0 auto;
		font-family: Baskerville Old Face;
		font-size: 48px;
		color: #555;
		text-align: center;
		background-color: inherit;

}

.subHeader{
	font-size: 28px;
}

p.subHeader{
	margin: 10px auto;
	display: inline-block;
}



#scoreContainer{
	width:50%;
	background-color: #fff;
	margin: 0px auto;
	border: none;
}

@media only screen and (max-width: 1000px) {
  /* For mobile phones: */
  #scoreContainer {
    width: 98%;
    background-color: #fff;
	margin: 0px auto;
	border: none;
  }
}

</style>
</head>

<body>
<!-- HTML for the Navigation bar -->
<div class="navBar">
	<p class="titleFont" style="margin-left: 10%">Boris Basher</p>
	<ul>
		<li style = "margin-right: 10%"><a class="navElement" id = "loginOrProfile" href="/login.php">Login/Register</a></li>
		<li><a class="navElement" href="/index.php">Leaderboard</a></li>
	</ul>
</div>

<!-- php to modify the navigation bar login/register button to profile if the user has already logged in -->
<?php
    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "1"){
        echo '<script type="text/javascript">
                document.getElementById("loginOrProfile").textContent = "Profile";
                document.getElementById("loginOrProfile").href = "/profile.php";
            </script>';
    }
?>

<!-- some extra colour below the navigation bar and to make it all less cramped
     could be used for splash announcements about which team is leading but
     will probably leave it blank -->
<div class="navBar banner">
</div>

<!-- HTML to display the leaderboards-->
<div id="scoreContainer">
	<div style="width: 100%; margin-left: auto; margin-right: auto; border-bottom: 1px solid black; background-color: inherit;">
		<h1 class="formHeader">Top Scorers</h1>
	</div>
	<!-- filterbar allows user to change which leaderboard to display by filtering the data-->
	<div class="filterBar">
		<ul>
			<li><a href="#">Steps</a></li>
			<li><a href="#">Stairs Climbed</a></li>
			<li><a href="#">Time Outside</a></li>
			<li><a href="#">R-Rate</a></li>
		</ul>
	</div>
</div>

<script>
var resourceArray = [["Template User", "Steps: 255","1","#"],
					 ["person 2", "Steps: 200", "2","#"],
					 ["Person 3", "Steps: 150", "3", "#"]];
for(h = 0; h < 4; h++){
	for(i = 0; i < resourceArray.length; i++){
		// - Create resource container div
		// - Assign it the correct style: leaderboardEntry
		// - Assign its onclick link
		var newEntry = document.createElement("div");
		newEntry.setAttribute("class", "leaderboardEntry");
		newEntry.setAttribute("onclick", "" + resourceArray[i][3]);

		// - Create title text paragraph
		// - Assign the title text from array
		var title = document.createElement("p");
		title.innerHTML = resourceArray[i][0];
		title.setAttribute("class", "formHeader subHeader left");

		// - Create Rating paragraph
		// - Assign rating value from the Array
		var examBoard = document.createElement("p");
		examBoard.innerHTML = resourceArray[i][1]
		examBoard.setAttribute("class", "formHeader subHeader center");

		var rating = document.createElement("p");
		rating.innerHTML = "Ranking: " + resourceArray[i][2].toString();
		rating.setAttribute("class", "formHeader subHeader right");

		// - Add title and rating paragraphs to the score entry
		newEntry.appendChild(title);
		newEntry.appendChild(examBoard);
		newEntry.appendChild(rating);
		var container = document.getElementById("scoreContainer");
		container.appendChild(newEntry);
	}
}
var container = document.getElementById("scoreContainer");
var br = document.createElement("br");
container.appendChild(br);
</script>
</body>
</html>
