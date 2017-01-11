<?php 
	var_dump($_POST);
	var_dump(isset($_POST["signupEmail"]));
	
	
	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	
	// kui on sisseloginud siis suunan data lehele
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	
	//echo "<br>";
	
	//var_dump($_POST);
	
	//MUUTUJAD
$loginEmail="";
$loginPassword="";
$signupEmailError = "";
$signupEmail = "";
$signupGender="";
$signupAge="";
//signup email

if (isset ($_POST["signupEmail"])) {

	//on olemas
	// kas epost on tühi
	if (empty ($_POST["signupEmail"])) {

		// on tühi
		$signupEmailError = "Sisesta email";

	} else {
		// email on olemas ja õige
		$signupEmail = $_POST["signupEmail"];

	}

}

//signup parool

$signupPasswordError = "";
//kas on üldse olemas
if (isset ($_POST["signupPassword"])) {
	// oli olemas, ehk keegi vajutas nuppu
	// kas oli tühi
	if (empty ($_POST["signupPassword"])) {
		//oli tõesti tühi
		$signupPasswordError = "Sisesta parool";
	} else {

		// parool ei olnud tühi

		//kas on piisavalt pikk parool

		if ( strlen($_POST["signupPassword"]) < 8 ) {

			$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk!";
		}
	}
}

//kas parool uuesti on täidetud

$signupPasswordAgainError = "";

$passwordAgainError = "";
//kas on üldse olemas
if (isset ($_POST["passwordAgain"])) {
	// oli olemas, ehk keegi vajutas nuppu
	// kas oli tühi
	if (empty ($_POST["passwordAgain"])) {
		//oli tõesti tühi
		$signupPasswordAgainError = "Sisesta parool uuesti";
	} else {

		//kas paroolid sobivad kokku
		if(isset ($_POST["signupPassword"]) && $_POST["signupPassword"] !== $_POST["passwordAgain"])  {
			$passwordAgainError = "paroolid ei sobi kokku";
		}

	}
}

//signup sugu
$signupGenderError = "";
if (isset ($_POST["signupAge"])) {
	if (!isset ($_POST["signupGender"])) {
		$signupGenderError = "Vali sugu";
	} else {
		$signupGender = $_POST["signupGender"];
	}
}



//signup vanus

$signupAgeError = "";

if (isset ($_POST["signupAge"])) {
	if (empty ($_POST["signupAge"])) {

		// on tühi
		$signupAgeError = "Sisesta vanus";

	} else {
		$signupAge = $_POST["signupAge"];
	}
}
//login errorid
$loginEmailError ="";

if (isset ($_POST["loginEmail"])) {

	//on olemas
	// kas epost on tühi
	if (empty ($_POST["loginEmail"])) {

		// on tühi
		$loginEmailError = "Palun sisesta Email";

	} else {
		// email on olemas ja õige
		$loginEmail = $_POST["loginEmail"];

	}
}



if($signupEmailError == "" AND
	$signupGenderError == "" &&
	$signupAgeError == "" &&
	$signupPasswordError == "" &&
	$passwordAgainError == "" &&
	$signupPasswordAgainError == "" &&
	isset($_POST["signupEmail"]) &&
	isset($_POST["signupGender"])&&
	isset($_POST["signupAge"])&&
	isset($_POST["signupPassword"])&&
	isset($_POST["passwordAgain"])
) {

	//vigu ei olnud, kõik on olemas
	echo "Salvestan...<br>";
	echo "email ".$_POST["signupEmail"]."<br>";
	echo "vanus ".$_POST["signupAge"]."<br>";
	echo "sugu ".$_POST["signupGender"]."<br>";

	$password = hash("sha512", $_POST["signupPassword"]);

	echo $password."<br>";


	$User->signup($signupEmail, $password, $signupAge, $signupGender);


}



$loginPasswordError ="";

if (isset ($_POST["loginPassword"])) {

	//on olemas
	// kas epost on tühi
	if (empty ($_POST["loginPassword"])) {

		// on tühi
		$loginPasswordError = "Palun sisesta parool";

	} else {
		// email on olemas ja õige
		$loginPassword = $_POST["loginPassword"];

	}
}










$notice = "";
//kas kasutaja tahab sisse logida
if ( isset($_POST["loginEmail"]) &&
	isset($_POST["loginPassword"]) &&
	!empty($_POST["loginEmail"]) &&
	!empty($_POST["loginPassword"])
) {
		
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}

?>
<?php require("../header.php"); ?>
<div class="container">

			<h1>Logi sisse</h1>
	<br>


					<form method="POST" class="form-signin">
				<input class="form-control" name="loginEmail" type="email" placeholder="Email" value="<?=$loginEmail;?>">

						<br>



						<input class="form-control" name="loginPassword" placeholder="Parool" type="password">

						<br>


				<input type="submit" value="Logi sisse">
						<br><br>


						<p>Ei ole kasutaja? <span> <a href="signup.php">Loo kasutaja</a> </span> </p>
				<p style="color:red;"><?=$notice;?></p>
				<p style="color:red;"><?=$loginEmailError;?></p>
				<p style="color:red;"><?=$loginPasswordError;?></p>
			</form>

				</div> <!-- /container -->

<div class="container">

<h1>Loo Kasutaja</h1>
	<br>


	<form method="POST" class="form-signin"  >



				<input class="form-control" name="signupEmail" type="email" placeholder="Email" value="<?=$signupEmail;?>">
		<br>

				<input class="form-control" type="number" size="10" name="signupAge" placeholder="Vanus" min="1" max="150" value="<?=$signupAge;?>">
		<br>

				<select class="form-control" name="signupGender">
					<option selected disabled>Vali sugu</option>
					<option value="Mees">Mees</option>
					<option value="Naine">Naine</option>
					<option value="Muu">Muu</option>

				</select>
		<br>

				<input class="form-control" name="signupPassword" placeholder="Parool" type = "password">

		<br>

				<input class="form-control" name="passwordAgain" placeholder="Parool uuesti" type = "password">


		<br>

				<input  type="submit" value="Loo kasutaja" href="signup.php">
		<br>
		<br>

		<p>Tagasi <a href="login.php" >Logi sisse</a></p>

			</form>
</div> <!-- /container -->


<p style="color:red;"><?=$signupEmailError;?></p>
			<p style="color:red;"><?=$signupGenderError;?></p>
			<p style="color:red;"><?=$signupAgeError;?></p>
			<p style="color:red;"><?=$signupPasswordError;?></p>
			<p style="color:red;"><?=$passwordAgainError;?></p>
			<p style="color:red;"><?=$signupPasswordAgainError;?></p>


<?php require("../footer.php"); ?> 