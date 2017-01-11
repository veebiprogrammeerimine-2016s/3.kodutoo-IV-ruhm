<?php
	//edit.php
	require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/Event.class.php");
	$Event = new Event($mysqli);
	
	if(isset($_GET["delete"])){
		$Event->deletePerson($_GET["id"]);
		header("Location: data.php");
		exit();
	}
	
	
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		$Event->updatePerson($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["testi_id"]), $Helper->cleanInput($_POST["kommentaar"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	//saadan kaasa id
	$p = $Event->getSinglePerosonData($_GET["id"]);
	var_dump($p);

	
?>
<?php require("../header.php"); ?> 
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="testi_id" >testi id</label><br>
	<input id="testi_id" name="testi_id" type="text" value="<?php echo $p->testi_id;?>" ><br><br>
  	<label for="kommentaar" >kommentaar</label><br>
	<input id="kommentaar" name="kommentaar" type="text" value="<?=$p->kommentaar;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
  
  <a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
  
  
<?php require("../footer.php"); ?> 