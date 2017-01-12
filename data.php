<?php
	//ühendan sessiooniga
	require("functions.php");

  require("Helper.class.php");
	$Helper = new Helper($mysqli);

	require("Feedback.class.php");
	$Feedback = new Feedback($mysqli);

	$pointsError = "*";

	if (isset ($_POST["points"])) {
			if (empty ($_POST["points"])) {
				$pointsError = "* Sisesta punktide arv (1-10)!";
			} else {
				$points = $_POST["points"];
		}

	}

	$colorError = "*";

	if (isset ($_POST["color"])) {
			if (empty ($_POST["color"])) {
				$colorError = "* Sisesta värv!";
			} else {
				$color = $_POST["color"];
		}

	}

	$addressError = "*";

	if (isset ($_POST["address"])) {
			if (empty ($_POST["address"])) {
				$addressError = "* Sisesta aadress!";
			} else {
				$address = $_POST["address"];
		}

	}

	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	//kas aadressireal on logout
	if (isset($_GET["logout"])) {

		session_destroy();

		header("Location: login.php");
		//exit();

	}


	if ( isset($_POST["points"]) &&
		 isset($_POST["color"]) &&
		 isset($_POST["address"]) &&
		 !empty($_POST["points"]) &&
		 !empty($_POST["color"]) &&
		 !empty($_POST["address"])

	) {

    $Feedback->saveFeedback($Helper->cleanInput($_POST["points"]), $Helper->cleanInput($_POST["color"]), $Helper->cleanInput($_POST["address"]));
		header("Location: data.php");
	}

  if (isset($_GET["f"])) {

    $f = $_GET["f"];

  } else {
    $f = "";
    }
    $sort = "id";
  $order = "ASC";

  if(isset($_GET["sort"]) && (isset($_GET["order"]))) {
    $sort = $_GET["sort"];
    $order = $_GET["order"];
  }

  $Feedback = $Feedback->getAllFeedbacks($f, $sort, $order);
  /*echo "<pre>";
	var_dump($feedback);
	echo "</pre>";*/

?>
<h1>Data</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<h1>Anna oma endisele üürikorterile hinnang</h1>

<p>
	Palun anna oma endisele üürikorterile hinnang ühest kümneni
</p>

<form method="POST" >

	<label>Punktid (1-10)</label><br>
	<input name="points" type="number"> <?php echo $pointsError; ?>

	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color"> <?php echo $colorError; ?>

	<br><br>
	<label>Korteri aadress</label><br>
	<input name="address" type="text"> <?php echo $addressError; ?>

	<br><br>
	<input type="submit" value="Salvesta">

</form>


<h2>Arhiiv</h2>

<form>
<input type="search" name="f" value="<?=$f;?>">
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

    $orderPoints = "ASC";
      if (isset($_GET["order"]) &&
          $_GET["order"] == "ASC" &&
          $_GET["sort"] == "points" ) {
          $orderPoints = "DESC";
      }

    $orderColor = "ASC";
      if (isset($_GET["order"]) &&
          $_GET["order"] == "ASC" &&
          $_GET["sort"] == "color" ) {
          $orderColor = "DESC";
      }

    $orderAddress = "ASC";
      if (isset($_GET["order"]) &&
          $_GET["order"] == "ASC" &&
          $_GET["sort"] == "address" ) {
          $orderAddress = "DESC";
      }

			$html .= "<th><a href='?f=".$f."&sort=id&order=".$orderId."'>ID</a></th>";
			$html .= "<th><a href='?f=".$f."&sort=points&order=".$orderPoints."'>punktid</a></th>";
			$html .= "<th><a href='?f=".$f."&sort=color&order=".$orderColor."'>värv</a></th>";
			$html .= "<th><a href='?f=".$f."&sort=address&order=".$orderAddress."'>aadress</a></th>";
		$html .= "</tr>";

		//iga liikme kohta massiivis
		foreach ($Feedback as $f) {

		$html .= "<tr>";
			$html .= "<td>".$f->id."</td>";
			$html .= "<td>".$f->points."</td>";
			$html .= "<td>".$f->color."</td>";
			$html .= "<td>".$f->address."</td>";
      $html .= "<td><a href='edit.php?id=".$f->id."'>Muuda</a></td>";
		$html .= "</tr>";

		}

	$html .= "</table>";

	echo $html;

?>

<h2>Midagi huvitavat</h2>

<?php
	foreach($Feedback as $f) {
		$style = "
		    background-color:".$f->color.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 10px;
		";
		echo "<p style ='  ".$style."  '>".$f->points."</p>";
	}

	?>
