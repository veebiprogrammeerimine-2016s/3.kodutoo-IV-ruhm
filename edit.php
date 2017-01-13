<?php
 	//edit.php
	require("functions.php");
	require("editFunctions.php");
 	
	if(isset($_GET["delete"])){
		deletePerson($_GET["id"]);
		header("Location: data.php");
		exit();
	}
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		updatePerson(cleanInput($_POST["id"]), cleanInput($_POST["City"]),
		cleanInput($_POST["Cinema"]), cleanInput($_POST["Movie"]), cleanInput($_POST["Genre"]),
		cleanInput($_POST["Comment"]), cleanInput($_POST["Rating"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
         exit();	
 		
 	}
 	
 	//saadan kaasa id
 	$p = getSinglePerosonData($_GET["id"]);
 	//var_dump($p);
 
 	
 ?>
 <br><br>
 <a href="data.php"> tagasi </a>
 
 <h2>Muuda kirjet</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	
  	<label for="City" >Linn</label><br>
 	<input id="City" name="City" type="text" value="<?php echo $p->City;?>" ><br><br>
  
	<label for="Cinema" >Kino</label><br>
	<input id="Cinema" name="Cinema" type="text" value="<?php echo $p->Cinema;?>" ><br><br>
	
	<label for="Movie" >Film</label><br>
 	<input id="Movie" name="Movie" type="text" value="<?php echo $p->Movie;?>" ><br><br>
	
   	<label for="Genre" >Şanr</label><br>
	<input id="Genre" name="Genre" type="text" value="<?php echo $p->Genre;?>" ><br><br>
	
	<label for="Comment" >Kommentaar</label><br>
 	<input id="Comment" name="Comment" type="text" value="<?php echo $p->Comment;?>" ><br><br>
	
   	<label for="Rating" >Hinne</label><br>
	<input id="Rating" name="Rating" type="text" value="<?php echo $p->Rating;?>" ><br><br>
 	
	<input type="submit" name="update" value="Salvesta">
</form> 
   
	<a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
	