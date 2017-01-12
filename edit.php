<?php

	require("functions.php");

	require("Helper.class.php");
	$Helper = new Helper();

	require("Feedback.class.php");
	$Feedback = new Feedback($mysqli);

	if(isset($_GET["delete"]) && isset($_GET["id"])){

		$Feedback->deleteFeedback($Helper->cleanInput($_GET["id"]));
		header("Location: data.php");
        exit();

	}


	if(isset($_POST["update"])){

		$Feedback->updateFeedback($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["points"]), $Helper->cleanInput($_POST["color"]), $Helper->cleanInput($_POST["address"]));

		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();

	}


	$f = $Feedback->getSingleFeedbackData($_GET["id"]);
	var_dump($f);

?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" >
  	<label for="points" >Punktid</label><br>
	<input id="points" name="points" type="number" value="<?php echo $f->points;?>" ><br><br>
  	<label for="color" >Värv</label><br>
	<input id="color" name="color" type="color" value="<?=$f->color;?>"><br><br>
	<label for="address" >Aadress</label><br>
	<input id="address" name="address" type="text" value="<?php echo $f->address;?>" ><br><br>

	<input type="submit" name="update" value="Salvesta">
  </form>

  <a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
