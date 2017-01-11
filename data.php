<?php

	//Ühendan sessiooniga
	require("../../config.php");
	require("functions.php");

	
	//Kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["food"]) && 
	isset($_POST["kcal"]) &&
	isset($_POST["day"]) &&
	!empty($_POST["food"]) &&
	!empty($_POST["kcal"]) &&
	!empty($_POST["day"]))  {
		tabelisse2($_POST["food"], $_POST["kcal"], $_POST["day"]);
	}
	
	$foods = getAllFoods();
	
	
	if(isset($_GET["search"]) &&
	!empty($_GET["search"])) {
		$search = $_GET["search"];
		$foods=getSearchedFoods($search);
	}
	
	if(isset($_GET["id"]) &&
	!empty($_GET["id"])) {
		$archiveId=$_GET["id"];
		archiveFood($archiveId);
	}
	
	$archivedFoods=getArchivedFoods();
	
?>
<h1>Data</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>
	<a href="?logout=1">Logi välja</a>
</p>
<br>

<form method="POST">
	<input name="food" placeholder="Toit" type="text"> <br><br>
	<input name="kcal" placeholder="Kcal" type="number"> <br><br>
	<input name="day" placeholder="Päev" type="text"> <br><br>
	<input type="submit" value="Sisesta andmed">
</form>

<h2>Sissekanded</h2>
<p>Otsi toidu järgi:</p>
<form>
	<input name="search" placeholder="Otsing..." type="text">
	<input type="submit" value="Otsi"><br><br>
</form>

<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>ID</th>";
		$html .= "<th>Toit</th>";
		$html .= "<th>Kcal</th>";
		$html .= "<th>Päev</th>";
		$html .= "<th>Arhiveeri</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach ($foods as $f) {
		$html .= "<tr>";
			$html .= "<th>".$f->id."</th>";
			$html .= "<th>".$f->food."</th>";
			$html .= "<th>".$f->kcal."</th>";
			$html .= "<th>".$f->day."</th>";
			$html .= "<td><a href='data.php?id=".$f->id."'>Arhiveeri</a></td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;
?>

<h2>Arhiveeritud sissekanded</h2>
<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>ID</th>";
		$html .= "<th>Toit</th>";
		$html .= "<th>Kcal</th>";
		$html .= "<th>Päev</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach ($archivedFoods as $aF) {
		$html .= "<tr>";
			$html .= "<th>".$aF->id."</th>";
			$html .= "<th>".$aF->food."</th>";
			$html .= "<th>".$aF->kcal."</th>";
			$html .= "<th>".$aF->day."</th>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;
?>














