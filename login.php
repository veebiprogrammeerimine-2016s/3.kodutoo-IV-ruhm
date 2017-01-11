<?php

	require("../../config.php");
	require("functions.php");
	
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
	}
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//MUUTUJAD
	$loginEmail = "";
	$loginEmailError = "";
	$signupEmailError = "*";
	$signupEmail = "";
	
	if(isset($_POST["loginEmail"])) {
		if (empty($_POST["loginEmail"])) {
			$loginEmailError = "* Väli on kohustuslik";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	
	if(isset($_POST["signupEmail"])) {
		if (empty($_POST["signupEmail"])) {
			$signupEmailError = "* Väli on kohustuslik";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
	}

	$signupPasswordError = "*";

	if(isset($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "* Väli on kohustuslik";
		} else {
			if(strlen ($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärki";
			}
		}
	}
	
	$gender = "";
	
	if(isset($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Väli on kohustuslik";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	$signupBdayError = "*";
	$signupBday = "";
	
	if(isset($_POST["signupBday"])) {
			if (empty($_POST["signupBday"])) {
				$signupBdayError = "* Väli on kohustuslik";
			} else {
				$signupBday = $_POST["signupBday"];
			}
	}
	
	if ($signupEmailError == "*" &&
		$signupPasswordError == "*" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"])
		) {
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "Sünnipäev".$_POST["signupBday"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
			signup2($signupEmail, $password, $gender, $signupBday);
	}
	
	$notice = "";
	//Kas kasutaja tahab sisse logida?
	if(isset($_POST["loginEmail"]) && 
	isset($_POST["loginPassword"]) &&
	!empty($_POST["loginEmail"]) &&
	!empty($_POST["loginPassword"])) {
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
	}

	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	
	<body>
		<h1>Logi sisse</h1>
		
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
			<input name="loginEmail" placeholder="E-post" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>
			<br><br>
			<input name="loginPassword" placeholder="Parool" type="password">
			<br><br>
			<input type="submit" value="Logi sisse">
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			<input name="signupEmail" placeholder="E-post" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			<br><br>
			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			<br><br>
			<?php if ($gender == "male") {?>
				<input type="radio" name="gender" value="male" checked> male <br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> male <br>
			<?php } ?>
				
			<?php if ($gender == "female") {?>
				<input type="radio" name="gender" value="female" checked> female <br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> female <br>
			<?php } ?>
			
			<?php if ($gender == "other") {?>
				<input type="radio" name="gender" value="other" checked> other <br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> other <br>
			<?php } ?>
			
			
			<p>Sisesta sünnikuupäev</p>
			<input type="date" name="signupBday" value="<?=$signupBday;?>"> <?php echo $signupBdayError; ?> <br>
			
			<input type="submit" value="Loo kasutaja">
		</form>
		
		<br>
		<p>Minu MVP on teha toitumispäevik, kuhu saab sisestada toidu, mida sõid, selle kalorid ning päeva, mil seda sõid.</p>
		
	</body>
</html>