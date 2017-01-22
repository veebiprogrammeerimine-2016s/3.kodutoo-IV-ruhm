<?php
	//edit.php
	require("functions.php");
	require("editFunctions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updatePerson(cleanInput($_POST["id"]), cleanInput($_POST["age"]), cleanInput($_POST["color"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
		if(isset($_POST["delete"])){
		
		deleteEntry(cleanInput($_POST["id"]));
		
		header("Location: data.php?id=".$_POST["id"]."&Delete=true");
        exit();	
		
	}
	
	//saadan kaasa id
	$p = getEntry($_GET["id"]);

	
?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="videokaart" >videokaart</label><br>
	<input id="videokaart" name="videokaart" type="text" value="<?php echo $p->vc;?>" ><br><br>
  	<label for="Mälutüüp" >Mälutüüp</label><br>
	<input id="Mälutüüp" name="Mälutüüp" type="text" value="<?=$p->mt;?>"><br><br>
	<label for="Mälukiirus" >Mälukiirus</label><br>
	<input id="Mälukiirus" name="Mälukiirus" type="number" value="<?=$p->mk;?>"><br><br>
	<label for="Videomälu" >Videomälu</label><br>
	<input id="Videomälu" name="Videomälu" type="number" value="<?=$p->vm;?>"><br><br>
	<label for="Mäluliidese_laius" >Mäluliidese laius</label><br>
	<input id="Mäluliidese_laius" name="Mäluliidese_laius" type="number" value="<?=$p->mll;?>"><br><br>
  	<label for="Hind" >Hind</label><br>
	<input id="Hind" name="Hind" type="number" value="<?=$p->h;?>"><br><br>
  	<input type="submit" name="delete" value="Kustuta">
	<input type="submit" name="update" value="Salvesta">
  </form>
  