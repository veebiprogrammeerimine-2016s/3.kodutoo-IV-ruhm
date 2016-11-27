<?php

	require("functions.php");
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if(isset($_GET["delete"])){
		deleteOffer($_GET["id"]);
	}
	
	if(isset($_POST["update"])){
		
		updateApple(cleanInput($_POST["id"]), cleanInput($_POST["variety"]), cleanInput($_POST["location"]), cleanInput($_POST["quantity"]), cleaninput($_POST["price"]));
		
		header("Location: myData.php");
        exit();	
		
	}
	
	$p = getSingleApple($_GET["id"]);

	
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Õunaturg</title>
		<link type="text/css" rel="stylesheet" href="stylesheet.css" />
	</head>
	
	<body>
		<header>
			<h1>Õunaturg</h1>
		</header>
		
		<div class="wrapper">
		
			<a href="myData.php" id="back">Jätan muutmata</a>

			<a href="?logout=1" id="logout">logi välja</a>
		
			<div class="word">
				<br><p>Uuendage valitud pakkumist, või <a id="delete" href="?id=<?=$_GET["id"];?>&delete=true">kustutage</a> see sootuks</p><br>
			</div><!--.word-->
			
			<div class="edit boxL">
				
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
				
					<input type="hidden" name="id" value="<?=$_GET["id"];?>" >
					
					<label>Õunasort</label><br>
					<input name="variety" type="text" class="formVariety" maxlength="34" value="<?=$p->variety;?>" >
					<br><br>
					
					<label>Asukoht</label><br>
					<input name="location" type="text" class="formLocation" maxlength="60" value="<?=$p->location;?>">
					<br><br>
					
					<label>Kogus kilogrammides</label><br>
					<input name="quantity" type="number" step="0.1" min="0" class="formNumber" value="<?=$p->quantity;?>" >
					<br><br>
					
					<label>Hinnasoov (€/kg)</label><br>
					<input name="price" type="number" step="0.01" min="0" class="formNumber" value="<?=$p->price;?>" >
					<br><br>
					
					<input type="submit" name="update" value="Muuda">
				</form>
  
			</div><!--.editBoxU-->
			
		</div><!--.wrapper-->
		<footer><p>&copy; Rait Keernik</p></footer>
	</body>
</html>
