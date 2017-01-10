<?php
	//edit.php
	require("functions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updatework(cleanInput($_POST["id"]), cleanInput($_POST["age"]), cleanInput($_POST["gender"]), cleanInput($_POST["color"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
if(isset($_GET["delete"])){
		
		delete($_GET["id"]);
		
		header("Location: data.php");
		exit();
	}
	
	//kui ei ole id-d aadressireal siis suunan data lehele
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
	}
	//saadan kaasa id
	$m = getSinglework($_GET["id"]);
	//var_dump($m);

?>
<br><br>
<a href="data.php"> Tagasi </a>
	<h1>Muuda andmed:</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >	
<h3>Sisesta looma vanus</h3>
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > <br>

		
		<input id="age" name="age" placeholder="Vanus" type="text" value="<?php echo $m->age;?>"> <br>
		
<h3>Sisesta looma sugu</h3>

	<input id="gender" name="gender" placeholder="Sugu" type="text" value="<?php echo $m->gender;?>"> <br><br>
	
<h3>Sisesta looma värvus</h3>

	<input id="color" name="color" placeholder="Värv" type="text" value="<?php echo $m->color;?>"> <br><br>


<input type="submit" name="update" value="Sisesta">
<br>
<br>


<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>

</form>