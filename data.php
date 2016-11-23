<?php
	//ühendan sessiooniga 
	require("functions.php");
	
	require("Helper.class.php");
	$Helper = new Helper($mysqli);
	
	require("Event.class.php");
	$Event = new Event($mysqli);
	
	
	$eventError = "*";
		
	if (isset ($_POST["event"])) {
			if (empty ($_POST["event"])) {
				$eventError = "*Sisesta ürituse nimi!";
			} else {
				$event = $_POST["event"];
		}
		
	} 
	
	$dateError = "*";
	
	if (isset ($_POST["date"])) {
			if (empty ($_POST["date"])) {
				$dateError = "*Sisesta kuupäev!";
			} else {
				$date = $_POST["date"];
		}
		
	} 
	
	$locationError = "*";
	
	if (isset ($_POST["location"])) {
			if (empty ($_POST["location"])) {
				$locationError = "*Sisesta ürituse asukoht!";
			} else {
				$location = $_POST["location"];
		}
		
	} 
	
	
		// kui ei ole sisseloginud, suunan login lehele
		if(!isset($_SESSION["userId"])) {
			header("Location: login.php");
		}
	
		//kas aadressi real on logout
	if (isset($_GET["logout"])) {
		session_destroy();
		
		header("Location: login.php");
		
	}
	if ( isset($_POST["event"]) &&
	     isset($_POST["date"]) &&
		 isset($_POST["location"]) &&
		 !empty($_POST["event"]) &&
		 !empty($_POST["date"])&&
		 !empty($_POST["location"])
		 ) {
			 $Event->saveEvent($Helper->cleanInput($_POST["event"], $_POST["date"], $_POST["location"]));
			 
			 header("Location: data.php");
			 
			 }
			 
		
	if (isset($_GET["q"])) {
		
		$q = $_GET["q"];
	
	} else {
		$q = "";
		}
		$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && (isset($_GET["order"]))) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
		
		
	
	
	
	$Event = $Event->getAllEvents($q, $sort, $order);
	
		//echo "<pre>";
		//var_dump($Event);
		//echo "</pre>";
?>

<h1>Data</h1>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
	
</p>
<body>
	
		<h1>Salvesta andmed</h1>
		
		<form method="POST" >
		
			<label>ürituse nimi</label><br>
			<input type="text" name="event" > <?php echo $eventError; ?>
			<br> <br>
			<label>kuupäev</label><br>
			<input type="date" name="date"> <?php echo $dateError; ?>
			<br> <br>
			<input type="text" name="location"> <?php echo $locationError; ?>
			<br> <br>
			
			<input type="submit" value="Salvesta">
		</form>

		
		<h2>Arhiiv</h2>
		
		<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>

<?php
	$html = "<table>";
		
		$html .= "<tr>";
		
			$orderId = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "id" ) {
					
				$orderId = "DESC";
				
			}
			
			$orderEvent = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "event" ) {
            $orderEvent = "DESC";
        }
		
			$orderDate = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "date" ) {
            $orderDate = "DESC";
        }
		
			$orderLocation = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "location" ) {
            $orderLocation = "DESC";
        }
		
			$html .= "<th>
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
							ID 
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=event&order=".$orderEvent."'>
							Üritus
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=date&order=".$orderDate."'>
							Kuupäev
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=location&order=".$orderLocation."'>
							Asukoht
						</a>
					 </th>";
					 
					 $html .= "</tr>";
		
		foreach ($Event as $e) {
			$html .= "<tr>";
			$html .= "<td>".$e->id."</td>";
			$html .= "<td>".$e->event."</td>";
			$html .= "<td>".$e->date."</td>";
			$html .= "<td>".$e->location."</td>";
		 $html .= "<td><a href='edit.php?id=".$e->id."'>Muuda</a></td>";
		$html .= "</tr>";
			
		}
	 
	
	
	$html .= "</table>";
	
	echo $html;
?>
</body>	
</html>
