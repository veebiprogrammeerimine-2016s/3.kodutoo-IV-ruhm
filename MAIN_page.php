<?php

	require("../../config.php");
	require("functions.php");
	
	//SESSION
	if (isset($_SESSION["userId"]))
	{
		header("Location: HOME_page.php");
	}
	
	//MUUTUJAD REGISTREERIMINE
	$signupEmail = $signupPassword = $signupUsername = $signupGender = "" ; 
	$signupEmailError = $signupPasswordError = $signupUsernameError = $signupGenderError = "*";
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
	if ( $signupEmailError == "*" AND
		$signupPasswordError == "*" &&
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
		
	<head>
	<title>Sisselogimise leht</title>
	</head>
	
	<body>
	<!--KASUTAJA SISENEB-->
	<h1>Sisene</h1>
	<p style="color:red;"><?=$error;?></p> <!--näitab parool/email errorit-->
	<form method="POST">
		
		<!--EMAILI LOOGIMINE-->
		<label for="loginEmail">E-post</label><br>
		<input name="loginEmail" type="loginEmail">
		<?php echo $loginEmailError;?>
		
		<br><br>
		<!--PAROOLI LOOGIMINE-->
		<label for="loginPassword">Parool</label><br>
		<input name="loginPassword" type="password">
		<?php echo $loginPasswordError;?>
		
		<br><br>
		
		<input type="submit" value="Logi sisse"></br>
	</form>
	

	<!--KASUTAJA REGISTREERIB-->
	<h1>Loo kasutaja</h1>
	<form method="POST">
	<label></label>
		
		<p> * On kohustuslikud</p>
		<!--EMAIL REGISTREERIMINE-->
		<label for="signupEmail">E-post</label><br>
		<input name="signupEmail" type = "signupEmail" placeholder="E-post">
		<?php echo $signupEmailError;?>
		
		<br>
		
		<!--PAROOL REGISTREERIMINE-->
		<br><label for="signupPassword">Parool</label></br>
		<input name="signupPassword" type = "password" placeholder="Parool">
		<?php echo $signupPasswordError;?>
		
		<br>
		
		<!--KASUTAJANIMI REGISTREERIMINE-->
		<br><label for="signupUsername">Sinu kasutaja nimi</label></br>
		<input name="signupUsername" type = "signupUsername" placeholder="Kasutajanimi" value=<?=$signupUsername;?>>
		<?php echo $signupUsernameError;?>
		
		<br>
		
		<!--SUGU REGISTREERIMINE-->
		<p><label for="signupGender">Sugu:</label><br>
		<select name = "signupGender"  id="signupGender" required><br><br>
		<option value="">Näita</option>
		<option value="Mees">Mees</option>
		<option value="Naine">Naine</option>
		<option value="Muu">Muu</option>
		</select>
		
		
		<br><br>
	
		<input type="submit" value="Loo kasutaja"></br>
	</form>
	</body>
</html>