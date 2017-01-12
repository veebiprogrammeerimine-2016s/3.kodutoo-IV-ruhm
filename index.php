<?php
    require("functions.php");
    // kui on session olemas siis saada teisele lehele
    if(isset($_SESSION["userID"])){
        header("Location: home.php");
    }
    // error muutujad
    $signupEmailError = "";
	$signupPasswordError= "";
    $signupNameError = "";
    // formi muutujad
    $signupEmail="";
    $signupName="";
    if (isset ($_POST["signupEmail"])) {
		if (empty ($_POST["signupEmail"])) {
			$signupEmailError = "- Väli on kohustuslik!";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
	}
    if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "- Väli on kohustuslik!";
		} else {
			if(strlen($_POST["signupPassword"]) < 8){
                $signupPasswordError = "- Parool peab olema vähemalt 8 tähemärkki pikk!";
            }
		}
	}
    if (isset ($_POST["signupName"])) {
		if (empty ($_POST["signupName"])) {
			$signupNameError = "- Väli on kohustuslik!";
		} else {
			$signupName = $_POST["signupName"];
		}
	}
    if ( $signupEmailError == "" AND $signupPasswordError == "" &&
         $signupNameError == "" && isset($_POST["signupEmail"]) && isset($_POST["signupName"]) &&
		 isset($_POST["signupPassword"])) 
    {
		$password = hash("sha512", $_POST["signupPassword"]);
		signup($_POST["signupEmail"], $_POST["signupName"], $password);
	}

    $notice = "";
    //kasutaja sisse logimine
    if(isset($_POST["loginEmail"]) &&
		 isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
    ){
        $notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
    }

?>
<html>
<head>
    <title>Sisselogimise leht</title>
</head>
<body>
    <h1>Logi sisse</h1>
    <p style="color:red;"></p>
    <form method="POST" >
        <label>E-post</label><br>
        <input name="loginEmail" type="email">
        <br>
        <label>Parool</label><br>
        <input name="loginPassword" placeholder="Parool" type="password">
        <br>
        <input type="submit" value="Logi sisse">
    </form>
    <h1>Loo kasutaja</h1>
    <form method="POST" >
        <label>E-post</label><br>
        <input name="signupEmail" type="email" placeholder="Email" value="<?php echo $signupEmail; ?>"> <?php echo $signupEmailError; ?>
        <br>
        <label>Parool</label><br>
        <input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
        <br>
        <label>Nimi</label><br>
        <input name="signupName" placeholder="Nimi" type="text" value="<?php echo $signupName; ?>"> <?php echo $signupNameError; ?>
        <br>
        <input type="submit" value="Loo kasutaja">

    </form>

</body>
</html>
