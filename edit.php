<?php 
    require("functions.php");
    if(isSet($_REQUEST["id"])){
        $text = getSingleText($_REQUEST["id"]);
    }
    if(isSet($_REQUEST["text"])){
        updateWork($_REQUEST["id"],$_REQUEST["text"]);
        header("Location: home.php");
    }
?>

<html>
<head>
    <title>Sisselogimise leht</title>
</head>
<body>
<h1>To Do </h1>
    <p>Oled sisse loginud kui <b><?=$_SESSION["userName"];?></b> <a href="?logout=1">logi valja </a></p>
    <p><a href="home.php">Home</a></p>
<br>
<h2>To Do Muutmine - <?=$_REQUEST["id"];?></h2>
<form method="POST" >
    <input type="text" name="id" value="<?php echo $text->id;?>" disabled><br>
	<label>Tekst</label><br>
	<input name="text" type="text" value="<?php echo $text->text;?>">
	<input type="submit" value="Uuenda">
</form>

</body>
</html>