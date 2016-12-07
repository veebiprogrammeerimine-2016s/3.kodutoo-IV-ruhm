<?php
	
	require("functions.php");
	
	require("Helper.class.php");
	$Helper = new Helper();
	
	require("Event.class.php");
	$Event = new Event($mysqli);
	
	if(isset($_GET["delete"]) && isset($_GET["id"])){
		
		$Event->deleteEvent($Helper->cleanInput($_GET["id"]));
		header("Location: data.php");
        exit();	
		
	}
	
	
	if(isset($_POST["update"])){
		
		$Event->updateEvent($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["event"]), $Helper->cleanInput($_POST["date"]), $Helper->cleanInput($_POST["location"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	
	$p = $Event->getSinglePerosonData($_GET["id"]);
	var_dump($p);

	
?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="event" >üritus</label><br>
	<input id="event" name="event" type="text" value="<?php echo $p->event;?>" ><br><br>
  	<label for="date" >kuupäev</label><br>
	<input id="date" name="date" type="date" value="<?=$p->date;?>"><br><br>
	<label for="location" >asukoht</label><br>
	<input id="location" name="location" type="text" value="<?php echo $p->location;?>" ><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
  <a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>