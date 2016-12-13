<?php


	require("functions.php");

	// kui on sisse loginud siis suunan data lehele
	if(isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}

//var_dump($_GET);

//echo "<br>";

//var_dump($_POST);

//Muutujad
	$signupEmailError = "*";
	$signupEmail = "";

	//kas keegi vajutas nuppu ja see on olemas

	if (isset ($_POST["signupEmail"])) {

		//on olemas
		// kas epost on tühi
		if (empty ($_POST["signupEmail"])) {

			// on tühi
			$signupEmailError = "* Väli on kohustuslik!";

		} else {
			// email on olemas ja õige
			$signupEmail = cleanInput($_POST["signupEmail"]);

		}

	}

	$signupPasswordError = "*";


	if (isset ($_POST["signupPassword"])) {


		if (empty ($_POST["signupPassword"])) {

			$signupPasswordError = "* Väli on kohustuslik!";

		} else {

			//parool ei olnud tyhi

			if( strlen($_POST["signupPassword"]) < 8 ) {

				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärki pikk";
			}
		}

	}

	$firstname = "";
	$firstnameError = "*";

	if (isset ($_POST["firstname"])) {


		if (empty ($_POST["firstname"])) {

			$firstnameError = "* Väli on kohustuslik!";

		}  else {

				$firstname = cleanInput($_POST["firstname"]);

		}

	}

	$lastname = "";
	$lastnameError = "*";


	if (isset ($_POST["lastname"])) {


		if (empty ($_POST["lastname"])) {

			$lastnameError = "* Väli on kohustuslik!";

		} else {

				$lastname = cleanInput($_POST["lastname"]);

		}

	}

	$birthdate = "";
	$birthdateError = "*";


	if (isset ($_POST["birthdate"])) {


		if (empty ($_POST["birthdate"])) {

			$birthdateError = "* Väli on kohustuslik!";

		} else { $birthdate = cleanInput($_POST["birthdate"]);

		}

	}


	$gender = "";
	$genderError = "*";

	if (isset ($_POST["gender"])) {

			if (!isset ($_POST["gender"])) {

				$genderError = "* Valik on kohustuslik!";

			} else {
				$gender = cleanInput($_POST["gender"]);
			}

		}

	$profession = "";

	if (isset ($_POST["profession"])) {

				$profession = cleanInput($_POST["profession"]);
			}



	$hobbies = "";

	if (isset ($_POST["hobbies"])) {

				$hobbies = cleanInput($_POST["hobbies"]);
			}



	if ( $signupEmailError == "*" &&
			 $signupPasswordError == "*" &&
			 $firstnameError == "*" &&
			 $lastnameError == "*" &&
			 $birthdateError == "*" &&
			 $genderError == "*" &&
			 isset($_POST["signupEmail"]) &&
			 isset($_POST["signupPassword"]) &&
			 isset($_POST["firstname"]) &&
			 isset($_POST["lastname"]) &&
			 isset($_POST["birthdate"]) &&
			 isset($_POST["gender"])
	   ) {

		//vigu ei olnud, kõik on olemas
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		//echo "parool ".$_POST["signupPassword"]."<br>";

		$password = hash("sha512", $_POST["signupPassword"]);

		//echo $password."<br>";

		signup($signupEmail, $password, $firstname, $lastname, $birthdate,
		$gender, $profession, $hobbies);

	}

	$notice = " ";
	//kas kasutaja tahab sisse logida

	if ( isset($_POST["loginEmail"]) &&
			isset($_POST["loginPassword"]) &&
			!empty($_POST["loginEmail"]) &&
			!empty($_POST["loginPassword"]))


	{

		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
	}

	$loginEmail = "";
	$loginEmailError = " ";

	if (isset ($_POST["loginEmail"])) {


		if (empty ($_POST["loginEmail"])) {


			$loginEmailError = "* Unustasid e-maili!";

		} else {

			$loginEmail = cleanInput($_POST["loginEmail"]);

		}

	}

	$loginPassword = "";
	$loginPasswordError = " ";

	if (isset ($_POST["loginPassword"])) {


		if (empty ($_POST["loginPassword"])) {


			$loginPasswordError = "* Unustasid parooli!";

		} else {

			$loginPassword = cleanInput($_POST["loginPassword"]);

		}

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

			<label> E-post</label><br>
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>

			<br><br>
			<label> Parool</label><br>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>

			<br><br>

			<input type="submit" value="Logi sisse">

		</form>


		<h1>Loo uus kasutaja</h1>

		<form method="POST" >

			<label> E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>

			<br><br>
			<label> Parool</label><br>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>

			<br><br>

			<label> Eesnimi</label><br>
			<input name="firstname" type="text" value="<?=$firstname;?>"> <?php echo $firstnameError; ?>

			<br><br>

			<label> Perekonnanimi</label><br>
			<input name="lastname" type="text" value="<?=$lastname;?>"> <?php echo $lastnameError; ?>

			<br><br>

			<label> Sünnikuupäev (dd/mm/yyyy)</label><br>
			<input name="birthdate" type="date" value="<?=$birthdate;?>"> <?php echo $birthdateError; ?>

			<br><br>

			<label> Sugu</label> <?php echo $genderError; ?> <br>

			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			<?php } ?>

			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			<?php } ?>

			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			<?php } ?>

			<br><br>

			<label> Eriala</label><br>
			<input name="profession" type="text" value="<?=$profession;?>">

			<br><br>

			<label> Hobid</label><br>
			<input name="hobbies" type="text" value="<?=$hobbies;?>">

			<br><br>

			<input type="submit" value="Loo kasutaja">

			<br><br>

		</form>



	</body>
</html>
