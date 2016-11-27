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
	
	$variety = "";
	$varietyError = "";
	$location = "";
	$locationError = "";
	$quantity = "";
	$quantityError = "";
	$price = "";
	$priceError = "";

	if (isset ($_POST["variety"])) {

		if (empty ($_POST["variety"])) {
			
			$varietyError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["location"])) {

		if (empty ($_POST["location"])) {
			
			$locationError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["quantity"])) {

		if (empty ($_POST["quantity"])) {
			
			$quantityError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["price"])) {

		if ($_POST["price"] == "" ) {
			
			$priceError="Kui soovite õunad tasuta ära anda sisestage palun null!";
		}
	}	
	
	if ( isset($_POST["variety"]) &&
	     isset($_POST["location"]) &&
		 isset($_POST["quantity"]) &&
		 isset($_POST["price"]) &&
		 $varietyError == "" &&
		 $locationError == "" &&
		 $quantityError == "" &&
	     $priceError == ""
	) {
		$variety = cleanInput($_POST["variety"]);
		$location = cleanInput($_POST["location"]);
		$quantity = cleanInput($_POST["quantity"]);
		$price = cleanInput($_POST["price"]);
		
		saveApples($variety, $location, $quantity, $price);
		
		$variety = "";
		$location = "";
		$quantity = "";
		$price = "";	
	}

	$list = getMyApples();
	
	$c = getOfferCount();
	
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
		
			<a href="data.php" id="back">Tagasi Pealehele</a>
			
			<a href="?logout=1" id="logout">logi välja</a>
		
			<div class="word">
				<p>Kui teilgi leidub õunu mida soovite teistele müüa või tasuta ära anda, täitke palun järgnev vorm</p>
			</div><!--.word-->
			
			<div class="insert boxL">
				
				<form method="POST" >
	
					<label>Õunasort</label><br>
					<input name="variety" type="text" class="formVariety" maxlength="34" value="<?=$variety;?>" > <?php echo $varietyError; ?>
					<br><br>
					
					<label>Asukoht</label><br>
					<input name="location" type="text" class="formLocation" maxlength="60" value="<?=$location;?>"> <?php echo $locationError; ?>
					<br><br>
					
					<label>Kogus kilogrammides</label><br>
					<input name="quantity" type="number" placeholder="0.0" step="0.1" min="0" class="formNumber" value="<?=$quantity;?>" > <?php echo $quantityError; ?>
					<br><br>
					
					<label>Hinnasoov (€/kg)</label><br>
					<input name="price" type="number" placeholder="0.00" step="0.01" min="0" class="formNumber" value="<?=$price;?>" > <?php echo $priceError; ?>
					<br><br>
					
					<input type="submit" value="Sisesta">

				</form>
				
			</div><!--.insertBoxL-->
			
			<div class="word">
				<p>Teil on praegu <?=$c->count;?> aktiivset pakkumist:</p>
			</div><!--.word-->
			
			<div class="boxL">
			
				<?php

					
					$html = "<table>";
						
						$html .= "<tr>";
							$html .= "<th>Õunasort</th>";
							$html .= "<th>Kogus (kg)</th>";
							$html .= "<th>Hinnasoov (€/kg)</th>";
							$html .= "<th></th>";
						$html .= "</tr>";
						
						foreach ($list as $p) {
							
							$html .= "<tr>";
								$html .= "<td>".$p->variety."</td>";
								$html .= "<td>".$p->quantity."</td>";
								$html .= "<td>".$p->price."</td>";
								$html .= "<td><a class='editButton' href='edit.php?id=".$p->id."'>Muuda/Kustuta</a></td>";
							$html .= "</tr>";
							
						}
					
					$html .= "</table>";
					
					
					echo $html;

				?>
				
			</div><!--.boxL-->
			
			
		</div><!--.wrapper-->
		<footer><p>&copy; Rait Keernik</p></footer>
	</body>
</html>
