<?php
	//edit.php
	require("functions.php");


	if(isset($_GET["delete"]) && isset($_GET["id"])) {

		  deleteSong($_GET["id"]);
			header("Location: data.php");
			exit();
		}

	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){

		updateSong(cleaninput($_POST["id"]), cleaninput($_POST["author"]), cleaninput($_POST["artist"]),
		cleaninput($_POST["songname"]), cleaninput($_POST["created"]), cleaninput($_POST["duration"]),
		cleaninput($_POST["album"]), cleaninput($_POST["genre"]), cleaninput($_POST["comment"]));

		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();

	}

	//saadan kaasa id
	$s = getSingleSongData($_GET["id"]);
	//var_dump($s);

?>

<html>
	<body>

<br>
<a href="data.php"> Tagasi </a>

<h2>Muuda <?=$s->songname;?> infot</h2>

  <form method="POST">
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" >

  	<label for="author" >Autor</label><br>
	<input id="author" name="author" type="text" value="<?=$s->author;?>" ><br><br>

  	<label for="artist" >Esitaja</label><br>
	<input id="artist" name="artist" type="text" value="<?=$s->artist;?>"><br><br>

		<label for="songname" >Pealkiri</label><br>
	<input id="songname" name="songname" type="text" value="<?=$s->songname;?>"><br><br>

		<label for="created" >Loomise aasta</label><br>
	<input id="created" name="created" type="year" value="<?=$s->created;?>"><br><br>

		<label for="duration" >Kestvus</label><br>
	<input id="duration" name="duration" type="time" value="<?=$s->duration;?>"><br><br>

		<label for="album" >Plaat</label><br>
	<input id="album" name="album" type="text" value="<?=$s->album;?>"><br><br>

		<label for="genre" >Žanr</label><br>
	<input id="genre" name="genre" type="text" value="<?=$s->genre;?>"><br><br>

		<label for="comment" >Kommentaar</label><br>
	<input id="comment" name="comment" type="text" value="<?=$s->comment;?>"><br><br>

	<input type="submit" name="update" value="Salvesta">
  </form>

<br>

<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta lugu</a>

</body>
</html>
