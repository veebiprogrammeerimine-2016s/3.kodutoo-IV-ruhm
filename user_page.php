<?php
	
	require("functions.php");
	
	if(isset($_POST["update"])){	
		updatePerson(cleanInput($_POST["nickname"]));
		header("Location: user_page.php?id=".$_POST["id"]."&success=true");
		exit();	
	}

	$people = profile();
?>

<html>
<head>

	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}
	</style>
	
</head>

Tere tulemast <?=$_SESSION["userEmail"];?>!
	
	<form method="POST">
	
	<!--Username-->
	<h1>Sinu andmed</h1>
	<label for="nickname">Sinu username</label><br>
	<input name="nickname" type = "nickname" placeholder="username">
	<input type="submit" name="update" value="Uuenda">
	<br><br>
	<input type="button" onClick="location.href='HOME_page.php'" style="background-color:#A1D852; color:white;" value="Tagasi">
	
	</form>
</html>

<?php 
//TABELI STRUKTUUR	
$html = "<table>";
	
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<th>Kasutaja</th>";
		$html .= "<tr>";
		$html .= "<td>".$p->email."</td>";
		$html .= "<tr>";
		$html .= "<th>Sugu</th>";
		$html .= "<tr>";
		$html .= "<td>".$p->gender."</td>";
		$html .= "<tr>";
		$html .= "<th>Username</th>";
		$html .= "<tr>";
		$html .= "<td>".$p->nickname."</td>";
	$html .= "</tr>";
	}
	
$html .= "</table>";

echo $html;
?>

