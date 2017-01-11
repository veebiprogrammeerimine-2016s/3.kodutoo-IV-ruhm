<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("functions_2.php");
require("Helper.class.php");
$Helper = new Helper();
require("Event.class.php");
$Event = new Event($mysqli);

if(isset($_POST["update"])){

		$Event->updatePerson($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["place"]), $Helper->cleanInput($_POST["duration"]), $Helper->cleanInput($_POST["end_duration"]));
		
	header("Location: data_2.php?id=".$_POST["id"]."&success=true");
    exit();	
}

if(isset($_GET["delete"])){
		$Event->deletePerson($Helper->cleanInput($_GET["id"]));
//		header("Location: data_2.php");
//        exit();	
		
	}


$p = $Event->getSinglePersonData($_GET["id"]);


require("header.php"); 
?>

<a href="data_2.php"> tagasi </a>

<h2>Muuda kirjet</h2>
<form method="post" >
		<h1>Vali laud</h1>
		<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 

		<select name="place">
			<option value="astra">Astra maja</option>
			<option value="bfm">BFM maja</option>
		</select>
		<br><br>
		<h1>Vali alguse aeg</h1>
		<input type="time" placeholder="sisesta vahemik" name="duration" value="<?php echo $p->duration;?>">
		<br><br>
		<h1>Vali lõpu aeg</h1>
		<input type="time" placeholder="sisesta vahemik" name="end_duration" value="<?php echo $p->end_duration;?>">
		<br><br>
		<input type="submit" name="update" value="salvesta">
	</form>
 <a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
 


<?php require("footer.php"); ?>
