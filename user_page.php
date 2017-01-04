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
table {
    border-collapse: collapse;
    width: 50%;
}

th, td {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
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
<h1>Teised kasutajad</h1>
</html>
<?php 
//TABELI STRUKTUUR	
$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>ID</th>";
		$html .= "<th>Kasutaja</th>";
		$html .= "<th>Sugu</th>";
		$html .= "<th>Username</th>";
	$html .= "</tr>";
			
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->id."</td>";
		$html .= "<td>".$p->email."</td>";
		$html .= "<td>".$p->gender."</td>";
		$html .= "<td>".$p->nickname."</td>";	
	$html .= "</tr>";
	}
	
$html .= "</table>";

echo $html;
?>

