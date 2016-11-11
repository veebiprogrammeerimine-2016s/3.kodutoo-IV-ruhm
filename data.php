<?php
	

	require("upload.php");
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: index.php");
		exit();
	}
	
	
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: index.php");
		exit();
	}
	
	

	if (isset($_GET["deleted"])) {
		
		$succ = "Teie soovitud postitus on kustutatud.";
	} else {
		
		$succ = "";
	}
	
	
	if (isset($_GET["submitted"])) {
		
		$succpic = "Your picture was submitted";
	} else {
		
		$succpic = "";
	}
	
	if(empty($_GET["srch"])) {
		
		$srch = "";
	}
	
	if(isset($_GET["srch"])) {
		
		$srch = $_GET["srch"];
	} else {
		$srch= "";
	}
	
	if(isset($_GET["filter"])) {
		$filter = $_GET["filter"];

	}
	
	$filter="asc";
	$filter2 = "Newest first";
	
	if(isset($_GET["desc"])) {
			
			$filter = "asc";
			$filter2 ="Newest first";
	}
	
	if(isset($_GET["asc"])) {
			
			$filter = "desc";
			$filter2 ="Oldest first";
	}
	
	
	
	echo $srch;
	
	

	$people = getAllPeople($srch,$filter);
?>

<!DOCTYPE html>
<html>


<link rel="stylesheet" type="text/css" href="data.css">
<h1>Olete sisselogitud</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Log out</a>
</p>
<br><br>
<div class="form">


		
		
		<font color="white"><h1>Submit a post</h1></font>
		

		
		
		
			<form name="postpic" method="post" enctype="multipart/form-data">

				Select an image to upload:<br><br>
				<input type="file" name="fileToUpload" id="fileToUpload">
				<br><br>
				Caption:
				<input type="text" name="caption" placeholder="Insert a caption" id="caption">
				<br><br>
				<input type="submit" value="Submit post" name="submit">
			</form>
		
		
		
</div>
		
		
		
<div class="form">


		
		
		<font color="white"><h1>Find a post</h1></font>
		

		
		
		
			<form>

					<form>
						<input type ="search" name="srch" value="<?=$srch;?>">
						<input type="submit" value="Search" name="submit">
						<br><br><br>
						<a href='?<?php echo $filter; ?>=true'> <?php echo $filter2; ?> </a>
					</form>
				
			</form>
		
		
		
</div>
		
		<br><br>
		
<div class="fixed">
Greg Nesselmann 2016 ©
</div>


<span style="color:red"><?php echo $succ; ?></span>
<span style="color:green"><?php echo $succpic; ?></span>
<div class="wrapper">
<div class="masonry">
	
	<?php
		/*
		$html = "<div class="form">";
	
		$html .= "<h2>Submitted posts</h2>";
	
		$html .= "<table>";
		
			$html .= "<tr>";
				$html .= "<th>ID</th>";
				$html .= "<th>Caption</th>";
				$html .= "<th>Image URL</th>";
			$html .= "</tr>";
		
		
			foreach ($people as $p) {
				$html .= "<tr>";
					$html .= "<td>". $p->id."</td>";
					$html .= "<td>". $p->caption."</td>";
					$html .= "<td>".$p->imgurl."</td>";
				$html .= "</tr>";
			}
		
		
		$html .= "</table>";
		
		$html .= "</div>";
		
		echo $html;
		
		*/
	?>
	
	<?php
		
		$html = "";

		foreach ($people as $p) {
			//$html .= "<br><br>";
			$html .= "<div class='item'> ";
				
				//$html .= "<p style='float:left'>#". $p->id."</p>";
				$html .= '<a href=edit.php?id=' .$p->id. ''   .">kustuta</a>";
				$html .= "<h3>". $p->caption."</h3>";
				$html .= ""."<img src=".$p->imgurl. " >"."";
				//$html .= "<br><br>";
			$html .= "</div>";
		}

		
		
		echo $html;
	?>
	

	
	
	<?php 


	/*foreach($people as $p) {
		
		$style = "
		    background-color:".$p->imgurl.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 20px;
		";
				
		echo "<p style = '".$style."'>"."</p>";
		
	}*/
	?>
</div>
</div>
	
</html>