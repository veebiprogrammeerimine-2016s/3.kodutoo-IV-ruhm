<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
	//ühendan sessiooniga
	require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/Event.class.php");
	$Event = new Event($mysqli);
	
	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas aadressireal on logout
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}
	
	
	if ( isset($_POST["testi_id"]) &&
		 isset($_POST["kommentaar"]) &&
		 !empty($_POST["testi_id"]) &&
		 !empty($_POST["kommentaar"])
	) {
		
		
		$kommentaar = $Helper->cleanInput($_POST["kommentaar"]);
		
		$Event->saveEvent($Helper->cleanInput($_POST["testi_id"]), $kommentaar);
	}
	
	// otsib
	if (isset($_GET["q"])) {
		
		$q = $_GET["q"];
	
	} else {
		//ei otsi
		$q = "";
	}
	
	//vaikimisi, kui keegi mingit linki ei vajuta
	$sort = "id";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$people = $Event->getAllPeople($q, $sort, $order);
	
	
	
	
	
	
	
	//echo "<pre>";
	//var_dump($people[5]);
	//echo "</pre>";
	
?>

<?php require("../header.php"); ?>
<h1>Data</h1>

<?php echo $_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<h2>Salvesta sündmus</h2>
<form method="POST" >
	
	<label>Testi ID</label><br>
	<input name="testi_id" type="number">
	
	<br><br>
	<label>Kommentaar</label><br>
	<input name="kommentaar" type="text">
	
	<br><br>
	
	<input type="submit" value="Salvesta">

</form>


<h2>Arhiiv</h2>











<form>

<div class="row">
	<div class="col-lg-2">
		<div class="input-group">
      <span class="input-group-btn">

        <button class="btn btn-default" type="submit">Go!</button>
      </span>
			<input type="search" name = "q" value="<?=$q;?>" class="form-control" placeholder="Search for...">


		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</form>









<?php


	$html = "<table class='table table-striped table-condensed table-hover'>";
	
		$html .= "<tr>";
		
			$orderId = "ASC";
			$arr="&darr;";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "id" ) {
					
				$orderId = "DESC";
				$arr="&uarr;";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
							ID ".$arr."
						</a>
					 </th>";
					 
			
			$orderTestiId = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "testi_id" ) {

				$orderTestiId = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=testi_id&order=".$orderTestiId."'>
							Testi ID
						</a>
					 </th>";
			
			
			$html .= "<th>Kommentar</th>";
			$html .= "<th>Edit</th>";

		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->testi_id."</td>";
				$html .= "<td>".$p->kommentaar."</td>";
                $html .= "<td>
							<a class='btn btn-default btn-xs' href='edit.php?id=".$p->id."'>
								<span class='glyphicon glyphicon-pencil'></span> Muuda
							</a>
						  </td>";

			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;

?>

<!--<h2>Midagi huvitavat</h2>-->

<?php
/*

	foreach($people as $p) {
		
		$style = "
		
		    background-color:".$p->lightColor.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 10px;
		";
				
		echo "<p style ='  ".$style."  '>".$p->age."</p>";
		
	}

*/
?>

<?php require("../footer.php"); ?> 
