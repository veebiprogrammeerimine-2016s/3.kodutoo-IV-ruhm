<?php
	//andmete salvestamine/näitamine mvp idee järgi.

	//ühendan sessiooniga
	require("functions.php");
	

	//kui ei ole sisse loginud, suunan login lehele.
	if(!isset($_SESSION["userId"])) {
		header("Location: Login.php");
	}
	
	
	//kas aadressireal on logout
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: Login.php");
		
	}
	
	// otsib
	if (isset($_POST["Otsi"])) {
		
		$q = $_GET["q"];
	
	} else {
		//ei otsi
		$q = "";
	}
	
	$sort = "videokaart";
	$order = "ASC";
	
		if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
			if(ISSET($_POST["sisesta"])){
				echo "sisesta töötas";
				if(ISSET($_POST["Videokaart"])) /*&&
				isset($_POST["Mälutyyp"]) &&
				isset($_Post["Mälukiirus"]) &&
				isset($_POST["Videomälu"]) && 
				isset($_POST["Mäluliidese_laius"]) &&
				isset($_POST["Hind"])){*/{
					$vc = $_POST["Videokaart"];
					$mt = $_POST["Mälutyyp"];
					$mk = $_POST["Mälukiirus"];
					$vm = $_POST["Videomälu"];
					$mll = $_POST["Mäluliidese_laius"];
					$H = $_POST["Hind"];
					$Event->saveEvent($vc, $mt, $mk, $vm, $mll, $H);
				}
			}
	$videocards = $Event->getAllVideocards($q, $sort, $order);
	$videocardsPlus = $Event->getAllVideocardsPlus();
/*echo "<pre>";
	var_dump($people);
echo "</pre>";*/
?>
<h1>Data</h1>



<p>
	Tere tulemast <a><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

	<p>
	<br><br>
		<form method="POST">
				<input name="Videokaart" type="text" placeholder="Videokaardi nimi"> 
				
				<br><br>
				
				<input name="Mälutyyp" placeholder="Mälutüüp" type="text"> 
				
				<br><br>
				
				<input name="Mälukiirus" type = "number" placeholder = "Mälukiirus">
				
				<br><br>
				
				<input name="Videomälu" type= "number" placeholder = "Videomälu GB" step="1" min="1">
				
				<br><br>
				
				<input name="Mäluliidese_laius" type= "number" placeholder = "Mäluliidese laius" step="32">
				
				<br><br>
				
				<input name="Hind" type= "number" placeholder = "Hind" >
				
				<br><br>
				
				<input type="submit" name="sisesta" value="sisesta andmed" >
				
		</form>
		
	</p>
	
	<h2>Arhiiv</h2>
	<form method="POST">
	
	<input type="submit" name="Jah" value="Näita kustutatuid kirjeid";><br><br>
	<input type="submit" name="Ei" value="Peida kustutatuid kirjeid";><br><br>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
	
	</form>
	<?php
			$kustutatud= "Ei";
	
	if (isset($_POST["Jah"])) {

			$html = "<table>";
				$html .= "<tr>";
					$html .= "<th>Videokaart</th>";
					$html .= "<th>Mälutüüp</th>";
					$html .= "<th>Mälukiirus</th>";
					$html .= "<th>Videomälu</th>";
					$html .= "<th>Mäluliidese laius</th>";
					$html .= "<th>Hind</th>";
				$html .="</tr>";
			
			
			foreach ($videocardsPlus as $v) {
				
				$html .= "<tr>";
					$html .= "<td>".$v->vc."</td>";
					$html .= "<td>".$v->mt."</td>";
					$html .= "<td>".$v->mk."</td>";
					$html .= "<td>".$v->vm."GB"."</td>";
					$html .= "<td>".$v->mll."</td>";
					$html .= "<td>".$v->h."</td>";
					$html .= "<td><a href='edit.php?id=".$v->id."'>edit.php</a></td>";
				$html .= "</tr>";
			}
			$html .= "</table>";			
		
		echo $html;
		
		} else {
			
			$html = "<table>";
				$html .= "<tr>";
					$ordervideokaart = "ASC";
					$arr="&darr;";
					if (isset($_GET["order"]) && 
						$_GET["order"] == "ASC" &&
						$_GET["sort"] == "videokaart" ) {
						$ordervideokaart = "DESC";
						$arr="&uarr;";
					}
						$html .= "<th> <a href='?q=".$q."&sort=videokaart&order=".$ordervideokaart."'>Videokaart".$arr."</a>
					</th>";
					$html .= "<th>Mälutyyp</th>";
					$html .= "<th>Mälukiirus</th>";
					$ordervideomalu = "ASC";
					if (isset($_GET["order"]) && 
					$_GET["order"] == "ASC" &&
					$_GET["sort"] == "videomalu" ) {
					
						$ordervideomalu = "DESC";
					}					
					$html .= "<th><a href='?q=".$q."&sort=videomalu&order=".$ordervideomalu."'>Videomälu</a></th>";
					$html .= "<th>Mäluliidese laius</th>";
					$html .= "<th>Hind</th>";
				$html .="</tr>";
			
			
			
			foreach ($videocards as $v) {
				
				$html .= "<tr>";
					$html .= "<td>".$v->vc."</td>";
					$html .= "<td>".$v->mt."</td>";
					$html .= "<td>".$v->mk."</td>";
					$html .= "<td>".$v->vm."</td>";
					$html .= "<td>".$v->mll."</td>";
					$html .= "<td>".$v->h."</td>";
					$html .= "<td><a href='edit.php?id=".$v->id."'>edit.php</a></td>";
				$html .= "</tr>";
			}
			$html .= "</table>";			
		
		echo $html;
				
		}
	
	?>