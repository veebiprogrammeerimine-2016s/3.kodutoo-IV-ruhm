<?php  


require("functions_2.php");
	require ("User.class.php");
	$User = new User($mysqli);

	require ("Helper.class.php");
	$Helper = new Helper ();

	if (isset($_SESSION["userid"])) {
		header("Location: data.php");
	}

// MUUTUJAD
	$signupEmail = "";
	$signupEmailError = "";
	$signupPassword = "";
	$signupPasswordError = "";
	$loginEmail = "";
	$loginEmailError = "";
	$loginPassword = "";
	$loginPasswordError = "";
	$loginSalvestatudEmail = "";

// LOGIN EMAIL
		if (isset($_POST["loginEmail"])) {
			if (empty($_POST["loginEmail"])) {
				$loginEmailError = " Sisesta e-post";
			}
		}

		if(isset($_POST["loginPassword"])){
			if(empty($_POST["loginPassword"])){
				$loginPasswordError=" Sisesta parool";
			}
		}

// SIGNUP EMAIL
	if (isset($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
				$signupEmailError = " Väli on kohustuslik!";
			} else {
				$signupEmail = $_POST["signupEmail"];
			}
		}

	if (isset($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
				$signupPasswordError = " Väli on kohustuslik!";		
			} else {
				$signupPassword = $_POST["signupPassword"];
			}
		}


// Kontrollin, kas signupEmailError ja signupPasswordError on "" ehk e-post ja parool on sisestatud
	if ($signupEmailError == "" &&
		$signupPasswordError == "" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"])
		) {
//see osa on vajalik vaid testimiseks, kas eelnev on õige
		echo "Salvestan.. <br>";
		echo "email: ".$signupEmail."<br>";
		echo "parool: ".$_POST["signupPassword"]."<br>";
// parool krüpteeritakse
		$password = hash("sha512", $_POST["signupPassword"]);
	
		echo $password."<br>";
// signup FUNCTION
		$User->signup($signupEmail, $password);
		}

	$notice = "";
//$defaultEmail = "sisesta_email";	
	if (isset($_POST["loginEmail"]) &&
	 	isset($_POST["loginPassword"]) &&
	 	!empty($_POST["loginEmail"]) &&
	 	!empty($_POST["loginPassword"])
	 	) {
// login Autofill 
		$loginSalvestatudEmail = $_POST["loginEmail"];
//
	 	$notice = $User->login ($_POST["loginEmail"], $_POST["loginPassword"]);	
	 	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>MVP kodutöö 16_10_06</title>
</head>
<body>


	
	<form method="POST">
	<h1>Logi sisse</h1>

			<p style="color:red"><?=$notice;?></p>
				<input type="email" placeholder="sisesta e-post" name="loginEmail" value="
				<?=$loginSalvestatudEmail;?>"> <?php echo $loginEmailError; ?>	
				
				<br><br>
				<input type="password" placeholder="sisesta parool" name="loginPassword">
				
				<br><br>
				<input type="submit" value="logi sisse">
	</form>
 	<form method="POST">
	<h1>Loo kasutaja</h1>		

				<input type="email" placeholder="loo kasutaja" name="signupEmail" value= "<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
				
				<br><br>
				<input type="password" placeholder="sisesta parool" name="signupPassword"><?php echo $signupPasswordError; ?>
				
				<br><br>
				<input type="submit" value="loo kasutaja">

	</form>

</body>
</html>