<?php
	
	require("functions.php");

	if (!isset ($_SESSION["userId"])) {
		header("Location: HOME_page.php");
		exit();	
	}
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: MAIN_page.php");
		exit();
	}
?>

<html>

Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href="?logout=1">Logi välja</a>

	<form method="POST">
	<input type="button" onClick="location.href='user_page.php'" style="background-color:#A1D852; color:white;" value="Minu kasutaja">

	</form>
	
</html>