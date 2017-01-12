<?php

	require("functions.php");

	require("Helper.class.php");
	$Helper = new Helper();

	require("User.class.php");
	$User = new User($mysqli);

	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}


	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);

	//MUUTUJAD
	$signupEmailError = "*";
	$signupEmail = "";
  $loginemail = "";

	if (isset ($_POST["loginEmail"])) {
			if (empty ($_POST["loginEmail"])) {
			// on tühi
			$signupEmailError = "* Väli on kohustuslik!";
		} else {
			// email on olemas ja õige
			$loginEmail = $_POST["loginEmail"];
		}
	}

	//kas keegi vajutas nuppu ja see on olemas

	if (isset ($_POST["signupEmail"])) {
		  if (empty ($_POST["signupEmail"])) {
			// on tühi
			$signupEmailError = "* Väli on kohustuslik!";
		} else {
			// email on olemas ja õige
			$signupEmail = $_POST["signupEmail"];
		}
	}

	$signupPasswordError = "*";

	if (isset ($_POST["signupPassword"])) {

		if (empty ($_POST["signupPassword"])) {

			$signupPasswordError = "* Väli on kohustuslik!";

		} else {

			// parool ei olnud tühi

			if ( strlen($_POST["signupPassword"]) < 8 ) {

				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärkki pikk!";

			}

		}

	}

	//vaikimisi väärtus
	$gender = "";

	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}

	}




	if ( $signupEmailError == "*" AND
		 $signupPasswordError == "*" &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"])
	  ) {

		//vigu ei olnud, kõik on olemas
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";

		$password = hash("sha512", $_POST["signupPassword"]);

		echo $password."<br>";

		$User->signup($Helper->cleanInput($_POST["signupEmail"]), $Helper->cleanInput($_POST["signupPassword"]));


	}
  $notice = "";
  //kas kasutaja tahab sisse logida
	if (isset($_POST["loginEmail"]) &&
	    isset($_POST["loginPassword"]) &&
			!empty($_POST["loginEmail"]) &&
			!empty($_POST["loginPassword"])) {

		$notice = $User->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));

	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<style>

	body{background-color: lightgrey}
	body{
	   font-size: 1em !important;
	   color: #808080 !important;
	   font-family: Helvetica !important;
	}



	</style>
	<body>



		<h1><font size="6" face="Helvetica Neue" color="grey">Logi sisse</font></h1>
    <p style="color:red;"><?=$notice;?></p>

		<form method="POST" >

			<label>E-post</label><br>
			<div class="form-group">
					<input class="form-control" name="loginEmail" placeholder="E-post" type="email" value="<?php if(isset($_POST['loginEmail'])) { echo $_POST['loginEmail']; } ?>" class="textbox required email">
			</div>

			<label>Parool</label><br>
			<div class="form-group">
			<input class="form-control" name="loginPassword" placeholder="Parool" type="password">
			</div>

			<br><br>

			<input type="submit" value="Logi sisse">

		</form>

		<h1><font size="6" face="Helvetica Neue" color="grey">Loo kasutaja</font></h1>

		<form method="POST" >

			<label>E-post</label><br>
			<input name="signupEmail" placeholder="E-post" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>

			<br><br>

			<label>Parool</label><br>
			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>

			<br><br>

			<label>Eesnimi</label><br>
			<input name="signupFirstname" placeholder="Eesnimi" type="firstname">

			<br><br>

			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female" > naine<br>
			<?php } ?>

			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > mees<br>
			<?php } ?>


			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> muu<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other" > muu<br>
			<?php } ?>

      <br><br>

			<input type="submit" value="Loo kasutaja">

		</form>

	</body>
</html>
