<?php
	
	require("functions.php");
	
	if (!isset ($_SESSION["userId"])) {
		header("Location: HOME_page.php");
		exit();	
	}
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: MAIN_page.php");
		exit();
	}

	$people = profile();
?>

<html>
Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href="?logout=1">Logi välja</a>
</html>




<h2>Table</h2>
<?php 
	
$html = "";
		foreach ($people as $p) {
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->email."</td>";
				$html .= "<td>".$p->gender."</td>";
				$html .= "<td>".$p->nickname."</td>";
				$html .= "<td>".$p->avatar."</td>";	
		}
		
	$html .= "";
?>

<html>
  <table style="width:30%"><?=$html?></p></table>

</html>