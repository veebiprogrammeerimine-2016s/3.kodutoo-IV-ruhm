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
	
		table {
			border-collapse: collapse;
			width: 100%;
			background-color: white;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid white;
		}

		th {
			background-color: #AA7CFF;
			color:white;
		}

		tr:nth-child(even){
			background-color: black;
			color: white;
		}

		body {
			margin: 0;
			background-color: black;
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

		li a:hover:not(.active) {
			background-color: #AA7CFF;
			color: white;
		}
		
		h2 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h1 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 24px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 26.4px;
			color: white;
		}
		
		h3 {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 500;
			line-height: 15.4px;
			color: white;
		}
		
		p {
			font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 400;
			line-height: 20px;
		}
		
		input[type=text1], select {
			width: 50%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		.submit {
			width: 20%;
			background-color: #AA7CFF;
			border: none;
			color: white;
			padding: 2% 6%;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 2px 6px;
			-webkit-transition-duration: 0.4s; /* Safari */
			transition-duration: 0.4s;
			cursor: pointer;
			border-radius: 12px;
		}			

		.submit1 {
			background-color: #AA7CFF; 
			color: white; 
		}

		.submit1:hover {
			background-color: white;
			color: black;
		}		

	</style>
<body>
	
	<ul>
		<li><a href="HOME_page.php"> <img src="img/home.png"> Home </a></li>
		<li><a href="newtred.php"> <img src="img/newtred.png"> New post </a></li>
		<li><a href="user_page.php"> <img src="img/account.png"> My account </a></li>
		<li><a href="?logout=1"> <img src="img/logout.png"> Log out</a></li>
	</ul>
</head>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">

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

	<form method="POST">

	<!--Username-->
	<br>
	<label for="nickname"><font color="white">Update your username:</font></label>
	</br>
	<input name="nickname" type="text1" placeholder="username" required>

	<input type="submit" class="submit submit1" name="update" value="Uuenda">
	<br><br>
	
	</form>

<div>
</body>
</html>