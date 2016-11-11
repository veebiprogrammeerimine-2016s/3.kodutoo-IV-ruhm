<?php
	//edit.php
	require("functions.php");

	
	//kas kasutaja uuendab andmeid
	/**if(isset($_POST["delete"])){
		
		deleteSubmission(cleanInput($_POST["id"]));
		
		header("Location: data.php?id=".$_POST["id"]."&deleted=true");
        exit();	
		
	}**/
	//saadan kaasa id
	$deleteid = $_GET["id"];
	/*if(isset($_POST["kustuta"])){
		
		deletePerson($_POST["id"]);
		
		//header("Location: edit.php");
        exit();	
		
	}*/
	

	if(isset($_GET["delete"])){
		deleteSubmission($deleteid);
		header("Location: data.php?deleted=true");
		exit();
	
	
	
	}
	//saadan kaasa id
	
	//var_dump($p);

	

?>



<br><br>
<a href="data.php"><h3><span style="color:green">← Tagasi eelmisele lehele </span></h3></a>
<br><br><br><br>
<h1>Oled kindel, et tahad kustutada?</h2>
  
  
  <h3><a style="color:red;" href="?id=<?=$_GET["id"];?>&delete=true">Jah, olen kindel</a></h3> 

  
