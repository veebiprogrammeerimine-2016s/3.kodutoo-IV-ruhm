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
	
	
	// otsib
	if (isset($_GET["q"])) {
		
		$q = $_GET["q"];
	
	} else {
		//ei otsi
		$q = "";
	}
	
	$sort = "price";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$list = getApples($q, $sort, $order);
	
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

			<a href="?logout=1" id="logout">logi välja</a><br>
		
			<div class="onOffer boxU">
				
				<div class="searchBox">
				
					<p>Hetkel aktiivsed pakkumised</p>
					
					<form>
						<input type="search" name="q" class="search" placeholder="Sisesta märksõna..." value="<?=$q;?>">
						<input type="submit" value="Otsi"><br>
					</form>
				
				</div><!--searchBox-->
				
				<a href="myData.php" id="myOffers">Minu pakkumised</a>
				
				<?php

					
					$html = "<table>";
						
						$html .= "<tr>";
						
							$orderVariety = "ASC";
							if (isset($_GET["order"]) && 
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "variety" ) {
								
								$orderVariety = "DESC";
							}
						
							$html .= "<th>
										<a href='?q=".$q."&sort=variety&order=".$orderVariety."'>Õunasort</a>
									</th>";
							
							$orderLocation = "ASC";
							if (isset($_GET["order"]) && 
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "location" ) {
								
								$orderLocation = "DESC";
							}
							
							$html .= "<th>
										<a href='?q=".$q."&sort=location&order=".$orderLocation."'>Asukoht</a>
									</th>";
							
							$orderQuantity = "ASC";
							if (isset($_GET["order"]) && 
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "quantity" ) {
								
								$orderQuantity = "DESC";
							}
							
							$html .= "<th>
										<a href='?q=".$q."&sort=quantity&order=".$orderQuantity."'>Kogus (kg)</a>
									</th>";
							
							$orderPrice = "ASC";
							if (isset($_GET["order"]) && 
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "price" ) {
								
								$orderPrice = "DESC";
							}
							
							$html .= "<th>
										<a href='?q=".$q."&sort=price&order=".$orderPrice."'>Hinnasoov (€/kg)</a>
									</th>";
							
						$html .= "</tr>";
						
						foreach ($list as $p) {
							
							$html .= "<tr>";
								$html .= "<td>".$p->variety."</td>";
								$html .= "<td>".$p->location."</td>";
								$html .= "<td>".$p->quantity."</td>";
								$html .= "<td>".$p->price."</td>";
							$html .= "</tr>";
							
						}
					
					$html .= "</table>";
					
					
					echo $html;

				?>
				
			</div><!--.onOffer-->
			
		</div><!--.wrapper-->
		<footer><p>&copy; Rait Keernik</p></footer>
	</body>
</html>