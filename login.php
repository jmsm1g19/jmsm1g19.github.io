<?php
if(!isset($_SESSION["loggedIn"])){
	session_start();
}
?>

<!doctype html>
<html>
<!--
?php

    /*
    DB Name: id6112766_dbname

    User: id6112766_root
    Password: password

    Host: localhost
    */
/*
    $con = mysqli_connect("localhost","id6112766_root","password", "id6112766_dbname");

    if (mysqli_connect_errno()){
        echo "Failed to connect to MYSQL: ".mysqli_connect_error();
    }

    $sql="SELECT UserID, Username, Password FROM Users ORDER BY UserID";

    if($result=mysqli_query($con,$sql)){
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
            //printf("%s (%s)\n", $row["Username"],$row["Password"]);
            //echo"<BR>";
        }
        mysqli_free_result($result);
    }

    mysqli_close($con);
*/

    
?
-->

<head>
    <link rel="stylesheet" type="text/css" href="navBar.css">
    <style type="text/css">
        body{
            margin: 0px;
            background-color: #fff;
        }
        .banner{
            height: 145px;
        }

        .mainHeading{
            display: inline-block;
            font-family: Baskerville Old Face;
            font-size: 45px;
            color: #000000;
            text-align: left;
            margin-left: 20px;
            margin-bottom: 5px;
        }

        #signUp{
            display: block;
        }

        .credentialForm{
            margin: 20px auto;
            border: solid black 1px;
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
          outline: none;
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

        .linkButton{
          background-color: inherit;
          border: none;
          text-decoration: underline;
          color: #555;
          outline:none;
          margin: 0px 0px;
        }

        .linkButton:hover{
          outline: none;
          color: #777;
        }

        div.justified {
                display: flex;
                justify-content: center;
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

  <div class="navBar banner">
  </div>

  <h1 id = "heading" class="formHeader">Register</h1>
  <div class = "justified">
    <form id ="signUp" action = "registerUser.php" method = "post">
      <input type="text" name="userName" placeholder="Username" class = "formMeta"><br>
      <input id = "deviceID" type="text" name="deviceID" placeholder="Device ID" class = "formMeta"><br id="emailFieldBreak">
      <input id = "passwordField" type="password" name="password" placeholder="Password" class = "formMeta"><br>
      <div class = "justified">
        <input id = "submit" type="submit" value="Register" class = "metaButton">
      </div>
    </form>
    <br>
  </div>
  <div class = justified>
    <div>
      <h2 id = "heading2" class = "formHeader subHeader" style = "display: inline-block;">Already got an Account?</h2>
    </div>
    <button id = "toggleLoginButton" class = "linkButton mainHeading subHeader" onclick = "toggleLogin()">Login Here</button>
  </div>

  <script>
    // - loginActive defines the current state of the login page
    // - Initially set to false since the register form is the pages in initial
    //   state
    var loginActive = false;
    // - Function called to toggle the forms purpose between logging in and
    //   registering
    function toggleLogin(){
      // - Determining which state needs to be activated
      // - If loginActive activate register page
      if(loginActive){
        // - Change page title to register
        document.getElementById("heading").innerHTML = "Register";
        // - make emailfield visible allowing the user to enter their details
        document.getElementById("deviceID").style.display = "initial";
        // - make BR visible so emailField and password field aren't displayed
        //   on the same line
        document.getElementById("emailFieldBreak").style.display = "initial";

        // - change the submit buttons label to register
        document.getElementById("submit").value = "Register";
        // - change the prompt at the bottom to ask the user if they already
        //   have an account
        document.getElementById("heading2").innerHTML = "Already got an Account?";
        // - change the toggle button's label to login here
        document.getElementById("toggleLoginButton").innerHTML = "Login Here";
        // - Ensure that the form forwards it's data to the correct php script
        document.getElementById("signUp").action = "registerUser.php";
      }
      // - if loginActive is false (register page is active)
      //   change the form to the login form
      else{
        // - change page title to Login
        document.getElementById("heading").innerHTML = "Login";
        // - make emailField and it's respective line break invisible
        //   as they are not needed to login
        document.getElementById("deviceID").style.display = "none";
        document.getElementById("emailFieldBreak").style.display = "none";

        // - change the submit buttons label to login
        document.getElementById("submit").value = "Login";
        // - change the prompt at the bottom of the page to ask the user if
        //   they dont have an account
        document.getElementById("heading2").innerHTML = "Not got an Account?";
        // - change the form's toggle button to display register here indicating
        //   it allows the user to register an account
        document.getElementById("toggleLoginButton").innerHTML = "Register Here";
        // - ensure that the form forwards the users data to the login form
        //   as opposed to the register form
        document.getElementById("signUp").action = "loginUser.php";
      }
    // - loginActive is toggled making it represent the current state of the form
    loginActive = !loginActive;
    }
  </script>

</body>

</html>
