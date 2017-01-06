<?php
	
	require("functions.php");
	require("style.php");
	
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
		body {
			margin: 0;
			background-color: black;
			color: white;
			}
		
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 25%;
			background-color: white;
			position: fixed;
			height: 100%;
			overflow: auto;
		}


		li a {
			display: block;
			color: #000;
			padding: 12px 4px;
			text-decoration: none;
		}

		li a.active {
			background-color: black;
			color: white;
		}

		li a:hover:not(.active) {
			background-color: #AA7CFF;
			color: white;
		}
	</style>
<body>
	
	<ul>
		<li><a class="active" href="HOME_page.php"> <img src="img/home.png"> Home </a></li>
		<li><a href="newtred.php"> <img src="img/newtred.png"> New post </a></li>
		<li><a href="user_page.php"> <img src="img/account.png"> My account </a></li>
		<li><a href="?logout=1"> <img src="img/logout.png"> Log out</a></li>
	</ul>
</head>

Tere tulemast <?=$_SESSION["userEmail"];?>!
	
	<form method="POST">
	
	<!--Username-->
	<h1>Sinu andmed</h1>
	<label for="nickname">Sinu username</label><br>
	<input name="nickname" type = "nickname" placeholder="username">
	<input type="submit" name="update" value="Uuenda">
	<br><br>
	
	</form>
<center>
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
</center>´
</html>
</body>


