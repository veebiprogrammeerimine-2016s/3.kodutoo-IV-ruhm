<?php
	include('header.php');
	
	
	require("functions.php");
	$Functions = new functions($mysqli);
	require("dijkstra.php");

	$start ="";
	$finish ="";
	$startError = "";
	$finishError = "";
	$startFloorError = "";
	$finishFloorError = "";
	
	//var_dump($Functions->mostUsed("start"));
?>
	 <br>
	 
<?php


	//var_dump($Functions->mostUsed("finish"));
	
	
	
	
	$Floors = array("A1" , "A2" , "A3" , "A4" , "A5" ,"S1" , "S2" , "S3" , "S4" , "S5" ,"M1" , "M2" , "M3" , "M4" , "M5" , "M6",
	"N1" , "N2" , "N3" , "N4" , "N5" ,"U1" , "U2" , "U3" , "U4" , "U5" ,"T1" , "T2" , "T3" , "T4" , "T5");
	
	$ring =" 
		background-color: lime;
		width: 10px;
		height: 10px;
		border-radius: 20px;
		text-align: center;
		line-height: 39px;
		margin: 0px;
		position:absolute;
		top:25%;
		left:73%;
	";
	
	
	if (isset($_POST["start"]))
	{
		if (empty($_POST["start"]))
		{
			$startError= "Alguspunkt puudu";	
		}	
		elseif (strlen($_POST["start"])== 4)
		{
			$start = $_POST["start"];
			
			$startFloor = (substr($start, 0, 2));
			//echo "Floor on ".$startFloor."  <br>";
			$startClass = (substr($start, 2, 2));
			//echo "Class on ".$startClass."  <br>";
		
		}
		else
		{
			$startError= "Sisestus pole sobiv";
		}
	}	
	
	if (isset($_POST["finish"]))
	{
		if (empty($_POST["finish"]))
		{
			$finishError= "Lõpp puudu";	
		}	
		elseif (strlen($_POST["finish"])== 4)
		{
			$finish = $_POST["finish"];
			$finishFloor = (substr($finish, 0, 2));
			//echo "Class on ".$finishFloor."  <br>";
			$finishClass = (substr($finish, 2, 2));
			//echo "Class on ".$finishClass."  <br>";
		}
		else
		{
			$finishError= "Sisestus pole sobiv";
		}
	}	
	

	if ($startError == "" && $finishError == "" && isset($_POST["start"]) && isset($_POST["finish"]))
	{
		if  (in_array($startFloor,$Floors))
		{
			//echo $startFloor.$startClass."  ";
			if (in_array($finishFloor,$Floors))
			{
				//echo $finishFloor.$finishClass."<br>";
				
				echo "<img src=".$startFloor.".jpg height=90%; width=100%;/>";
				echo "Roheline täpp on algus ja punane lõpp";
				$Functions->submit($start,$finish);
				
				header("Location: test.php?s=$start&f=$finish");
				
/*				if ($startFloor =="M2" && $startClass >= "06" && $startClass <= "08")
				{
					echo "<p style='".$ring."' ></p>";

				}
				else
				{
					
				}
				
*/				
			}
			else 
			{
				$finishFloorError = "Floor nimega '".$finishFloor."' puudub koolis";
			}
		
		}
		else
		{
			
			$startFloorError = "Floor nimega '".$startFloor."' puudub koolis";
		}
	}
	//echo $ring;
	//echo "<p style='".$ring."' ></p>";
	
	
	

	
	if(isset($_GET["s"]) && isset($_GET["f"])) {
		$startnumber = (substr($_GET["s"],1,3));
		$finishnumber = (substr($_GET["f"],1,3));
		
		
		define('I',1000);
		
		$points= array(
		array(217, 218, 5),array(218, 217, 5),
		array(219, 218, 2),array(218, 219, 2),
		array(218, 224, 2),array(224, 218, 2),
		array(224, 225, 12),array(225, 224, 12),
		array(224, 219, 6),array(219, 224, 6),
		array(225, 226, 6),array(226, 225, 6),
		array(226, 227, 23),array(227, 226, 23),
		array(227, 211, 12),array(211, 227, 12),
		array(211, 206, 3),array(206, 211, 3),
		array(206, 207, 3),array(207, 206, 3),
		array(207, 208, 4),array(208, 207, 4),
		array(208, 217, 5),array(217, 208, 5),
		array(205, 206, 28),array(206, 205, 28),
		array(210, 213, 9),array(213, 210, 9),
		array(210, 211, 6),array(211, 210, 6),
		array(210, 209, 2),array(209, 210, 2),
		array(208, 209, 2),array(209, 208, 2),
		array(205, 214, 29),array(214, 205, 29),
		array(206, 214, 17),array(214, 206, 17),
		array(217, 214, 16),array(214, 217, 16)
/*		array(224, 'lift', 20),array('lift', 224, 20),
		array(206, 'tunnel', 9),array('tunnel', 206, 9),
		array(226, 'nova_uks', 13),array('nova_uks', 226, 13)
*/		);

		

		if ($Functions->numberDoesExist($startnumber, $points) and $Functions->numberDoesExist($finishnumber, $points))
		{

			$matrixWidth = 700;
		
			/*$points = array(
			array(0,1,4),
			array(0,2,I),
			array(1,2,5),
			array(1,3,5),
			array(2,3,5),
			array(3,4,5),
			array(4,5,5),
			array(4,5,5),
			array(2,10,30),
			array(2,11,40),
			array(5,19,20),
			array(10,11,20),
			array(12,13,20),
			);*/
		
			$ourMap = array();
 
 
			// Read in the points and push them into the map
		 
			for ($i=0,$m=count($points); $i<$m; $i++) {
			$x = $points[$i][0];
			$y = $points[$i][1];
			$c = $points[$i][2];
			$ourMap[$x][$y] = $c;
			$ourMap[$y][$x] = $c;
			}
		 
			// ensure that the distance from a node to itself is always zero
			// Purists may want to edit this bit out.
		 
			for ($i=0; $i < $matrixWidth; $i++) {
				for ($k=0; $k < $matrixWidth; $k++) {
					if ($i == $k) $ourMap[$i][$k] = 0;
				}
			}
		 
		 
			// initialize the algorithm class
			$dijkstra = new Dijkstra($ourMap, I,$matrixWidth);
			 
			// $dijkstra->findShortestPath(0,13); to find only path from field 0 to field 13...
			
			
			$dijkstra->findShortestPath($startnumber,$finishnumber); 
			 
			// Display the results
			 
			echo '<pre>';
			//echo "the map looks like:\n\n";
			//echo $dijkstra -> printMap($ourMap);
			echo "\n\n<h2>".$startnumber. " ----> " .$finishnumber."</h2>\n\n";
			echo $dijkstra -> getResults((int)$finishnumber);
			
				
			echo '</pre>';
			
			

		}
		else
		{
			
			echo "sellist Klassi pole";
			
		}
		
		
		
	}

?>



	<H1>TLÜ GPS</H1>
	
	<H2>Kus asud ?</H2>
	<form method="POST">
	<input name="start" placeholder="Start" value="<?php echo $start;?>" type="text"><br><?php echo $startError; echo $startFloorError;?>
<?php
	$mostUsed = $Functions->mostUsed("start");
	
	$html = "<table>";	
	$html .= "<tr>";
	foreach ($mostUsed as $p) {
			
			
				$html .= "<th>".$p->start."&nbsp;</th>";
			
		}
		$html .= "</tr>";
		$html .= "</table>";
	echo $html;
?>
	
	
	<br>
	
	<H2>Kuhu soovid minna ?</H2>
	<input name="finish" placeholder="Finish" value="<?php echo $finish;?>" type="text"><br><?php echo $finishError; echo $finishFloorError;?>
<?php
	$mostUsed = $Functions->mostUsed("finish");
		$html = "<table>";	
		$html .= "<tr>";
		foreach ($mostUsed as $p) {
			
				$html .= "<th>".$p->start."&nbsp;</th>";
				
			
		}
		$html .= "</tr>";
		$html .= "</table>";
	echo $html;
?>
	<br><br>
	
	<input type="submit" value="Otsi">
	</form>

	<br>

	
<H2>Otsingute tabel</H2>
<?php


	
	if(isset($_GET["q"])){

		$q =$_GET["q"];
		
	}else{
		//ei otsi
		$q="";
	
	}
	$sort = "start";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])){
		
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	
	
	$orderId = "ASC";
	$arr= "&darr;";
	if (isset($_GET["order"]) && $_GET["order"]== "ASC" && $_GET["sort"]=="start"){
			$orderId = "DESC";
			$arr= "&uarr;";
	}
	if (isset($_GET["order"]) && $_GET["order"]== "ASC" && $_GET["sort"]=="finish"){
			$orderId = "DESC";
			$arr= "&uarr;";
	}
	if (isset($_GET["order"]) && $_GET["order"]== "ASC" && $_GET["sort"]=="kogus"){
			$orderId = "DESC";
			$arr= "&uarr;";
	}
	

	if (isset ($_GET["start"]) && ($_GET["finish"])){
		
		$start=$_GET["start"];
		$finish=$_GET["finish"];
		$Functions->deleteButton($start,$finish);
	}
	if (isset ($_GET["success"])){
		
		
		echo "Kustutasin teekonna ";
		
?>
	 <br>
	 
<?php
		
	}
	
	
	
	
	$startTable = $Functions->startTable($q , $sort , $order);
	
		$html = "<table class='table table-striped table-condensed'>";
	
		$html .= "<tr>";
			$html .= "<th><a href='?q=".$q."&sort=start&order=".$orderId."'>start".$arr."</th>";
			
			$html .= "<th><a href='?q=".$q."&sort=finish&order=".$orderId."'>finish".$arr."</th>";
				
			$html .= "<th><a href='?q=".$q."&sort=kogus&order=".$orderId."'>Kogus".$arr."</th>";
			
			$html .= "<th>Edit</th>";

		$html .= "</tr>";
		
		//iga liikme kohta massiivis
		foreach ($startTable as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->start."</td>";
				$html .= "<td>".$p->finish."</td>";
				$html .= "<td>".$p->count."</td>";
				$html .= "<td><a href='test.php?start=".$p->start."&finish=".$p->finish."'> nupp</a></td>";
 
			$html .= "</tr>";
		
		}
		
		$html .= "</table>";
	
	echo $html;
?>
	
<?php include('footer.php');?>