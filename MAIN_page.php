<?php

	require("../../config.php");
	require("functions.php");
	require("style.php");
	
	//SESSION
	if (isset($_SESSION["userId"]))
	{
		header("Location: HOME_page.php");
	}
	
	//MUUTUJAD REGISTREERIMINE
	$signupEmail = $signupPassword = $signupUsername = $signupGender = "" ; 
	$signupEmailError = $signupPasswordError = $signupUsernameError = $signupGenderError = "";
	//MUUTUJAD LOOGIMINE
	$loginEmail = $loginPassword = "";
	$loginEmailError = $loginPasswordError = $error = "";
	
	//REGISTREERIMINE
	//E-POST REGISTREERIMINE
	if (isset ($_POST["signupEmail"])) {
		if (empty($_POST["signupEmail"])) {
		$signupEmailError = "* Väli on kohustuslik!";
		} else {
		$signupEmail = $_POST ["signupEmail"];
		}
	}
	
	//PAROOL
	if(isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
		$signupPasswordError = "* Väli on kohustuslik!";
		} else {
		if (strlen ($_POST["signupPassword"]) <6)
		$signupPasswordError = "* Parool peab olema vähemalt 6 tähemärkki pikk";
		}
	}
	
	//Kasutajanimi
	if (isset ($_POST["signupUsername"])) {
		if (empty ($_POST["signupUsername"])) {
		$signupUsernameError = "* Väli on kohustuslik";
		} else {
		if (strlen ($_POST["signupUsername"]) >20) {
		$signupUsernameError = "* Kasutajanimi ei tohi olla pikkem kui 20 tähemärkki";
		} else {
		$signupUsername = $_POST ["signupUsername"];
			}
		}
	}
	
	//REGISTREERIMISE LÕPP
	if ( $signupEmailError == "" AND
		$signupPasswordError == "" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"])
	)
	if (isset($_POST["signupEmail"])&&
		!empty($_POST["signupEmail"])
		)
	
	//SALVESTAMINE JA FUNKTSIOON
	{
	$signupPassword = hash("sha512", $_POST["signupPassword"]);
	registration($signupEmail, $signupPassword, $signupUsername, $_POST["signupGender"]);
	}
	
	//SISSELOOGIMINE
	//EMAIL LOOGIMINE
	if (isset ($_POST["loginEmail"])) {
		if (empty ($_POST["loginEmail"])) {
		$loginEmailError = "* Väli on kohustuslik!";
		} else {
		$loginEmail = $_POST ["loginEmail"];
		}
	}
	
	//PAROOLI LOOGIMINE
	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
		$loginPasswordError = "* Väli on kohustuslik!";
		} else {
		$loginPassword = $_POST ["loginPassword"];
		}
	}
	
	//LOOGIMISE LÕPP
	if (isset ($_POST["loginEmail"]) &&
		isset ($_POST["loginPassword"])  &&
		!empty ($_POST["loginEmail"]) &&
		!empty ($_POST["loginPassword"])
		)
	//LOOGIMINE JA FUNKTSIOON
	{
	$error = login($_POST["loginEmail"], $_POST["loginPassword"]); //ERROR näitab et parool vqi email on vale
	}
	
?>


<!DOCTYPE html>
<html>
	
	<style>	
	
	.submit {
		width: 20%;
		height: 40px;
		background-color: #AA7CFF;
		border: none;
		color: white;
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
		border: 1px solid black;
	}
	
	input[class=text1], select {
		width: 20%;
		height: 40px;
		padding: 12px 20px;
		margin: 8px 0;
		display: inline-block;
		border: 1px solid black;
		border-radius: 4px;
		box-sizing: border-box;
	}

	</style>	

<head>
	<title>Sisselogimise leht</title>
</head>
	
	<body>
	<center>
	<!--KASUTAJA SISENEB-->
	<h1>Log In</h1>
	<p style="color:red;"><?=$error;?></p> <!--näitab parool/email errorit-->
	<form method="POST">
		
		<!--EMAILI LOOGIMINE-->
		<label for="loginEmail">Email</label><br>
		<input name="loginEmail" class="text1" placeholder="Email" value="<?=$loginEmail;?>">
		<br><?php echo $loginEmailError;?></br>
		
		<!--PAROOLI LOOGIMINE-->
		<label for="loginPassword">Password</label><br>
		<input name="loginPassword" type="password" class="text1" placeholder="Password">
		<br><?php echo $loginPasswordError;?></br>
		
		<br><br>
		
		<input type="submit" class="submit submit1" value="Logi sisse"></br>
	</form>
	
	<br><br>
	<!--KASUTAJA REGISTREERIB-->
	<h1>Create new user</h1>
	<form method="POST">
	<label></label>
		
		
		<!--EMAIL REGISTREERIMINE-->
		<label for="signupEmail">Email</label><br>
		<input name="signupEmail" class="text1" placeholder="Email" value="<?=$signupEmail;?>">
		<br><?php echo $signupEmailError;?></br>
		

		<!--PAROOL REGISTREERIMINE-->
		<label for="signupPassword">Password</label><br>
		<input name="signupPassword" type="password" class="text1" placeholder="Password">
		<br><?php echo $signupPasswordError;?></p></br>
		
		<!--KASUTAJANIMI REGISTREERIMINE-->
		<label for="signupUsername">Username</label><br>
		<input name="signupUsername" class="text1"" placeholder="Username" value=<?=$signupUsername;?>>
		<br><?php echo $signupUsernameError;?></br>
		
		
		<!--SUGU REGISTREERIMINE-->
		<p><label for="signupGender">Gender:</label><br>
		<select name = "signupGender"  id="signupGender" required><br><br>
		<option value="">Show</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		<option value="Other">Other</option>
		</select>
		
		
		<br><br>
	
		<input type="submit" class="submit submit1" value="Loo kasutaja"></br>
	</form>
	</center>
	</body>
</html>