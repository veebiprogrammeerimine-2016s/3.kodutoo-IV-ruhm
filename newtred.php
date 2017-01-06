<?php
	
	require("functions.php");
	require("style.php");

	
	//MUUTUJAD
	$companyname = $feedback = "";
	//MUUTUJAD ERROR
	$companynameerror = $feedbackerror = "";
	
	//LOGOUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: MAIN_page.php");
		exit();
	}
	
	//TAGASISIDE KOMMENTAAR
	//RESTARAUNT/CAFE NAME
	if (isset ($_POST["companyname"])) {
		if (empty ($_POST["companyname"])) {
		$companynameerror = "* This field is required!";
		} else {
		$companyname = $_POST["companyname"];
		}
	}
	
	//FEEDBACK
	if (isset ($_POST["feedback"])) {
		if (empty ($_POST["feedback"])) {
		$feedbackerror = "* This field is required!";
		} else {
		$feedback = $_POST["feedback"];
		}
	}
	
	//KUI KÕIK ON OKEI
	if (isset ($_POST["companyname"]) &&
		isset ($_POST["feedback"])  &&
		!empty ($_POST["companyname"]) &&
		!empty ($_POST["feedback"])
		)
	
	//SALVESTAMINE KOMMENTAARI
	{
	comment($companyname, $feedback, $_POST["rating"]);
	}

?>

<!DOCTYPE html>

<html>
<head>
	<style>

		body {
			margin: 0;
			background-color: black;
			}
		
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 25%;
			background-color: white;
			position: fixed;
			height: 100%;
			overflow: auto;
		}


		li a {
			display: block;
			color: #000;
			padding: 12px 4px;
			text-decoration: none;
		}

		li a:hover:not(.active) {
			background-color: #AA7CFF;
			color: white;
		}
		
		.submit {
			width: 50%;
			background-color: #AA7CFF;
			border: none;
			color: white;
			padding: 2% 6%;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			-webkit-transition-duration: 0.4s; /* Safari */
			transition-duration: 0.4s;
			cursor: pointer;
			border-radius: 12px;
		}			

		.submit1 {
			background-color: #AA7CFF; 
			color: white; 
		}

		.submit1:hover {
			background-color: white;
			color: black;
		}
		
		h2 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h1 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h3 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 15.4px;
			color: white;
		}
		
		p {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 400;
			line-height: 20px;
		}
		
		input[type=text1], select {
			width: 50%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

	</style>
</head>

<body>

	<ul>
		<li><a href="HOME_page.php"> <img src="img/home.png"> Home </a></li>
		<li><a href="newtred.php"> <img src="img/newtred.png"> New post </a></li>
		<li><a href="user_page.php"> <img src="img/account.png"> My account </a></li>
		<li><a href="?logout=1"> <img src="img/logout.png"> Log out</a></li>
		
	</ul>
	
<div style="margin-left:50%;padding:1px 16px;height:1000px;">
	<h2>Leave your feedback</h2>
	<form method="POST">
	
	<!--RESTARAUNT NAME-->
	<label for="companyname"><font color="white">Company name(what u visited):</font></label><br>
	<input name="companyname" type="text1" placeholder="Name of place u visited">
	<font color="white"><?php echo $companynameerror;?></font>
	<br>
	
	<!--FEEDBACK-->
	<label for="feedback"><font color="white">Your feedback:</font></label><br>
	<input name="feedback" type="text1" placeholder="Leave your feedback">
	<font color="white"><?php echo $feedbackerror;?></font>
	
	<!--RATING-->
	<p><label for="rating"><font color="white">Rate by 5 stars:</font></label><br>
	<select name = "rating"  id="rating" required>
		<option value="">How many stars</option>
		<option value="5">5</option>
		<option value="4">4</option>
		<option value="3">3</option>
		<option value="2">2</option>
		<option value="1">1</option>
	</select>
	<br><input type="submit" class="submit submit1" value="Send your comment"></br>
	
	</form>
</div>

</body>
</html>