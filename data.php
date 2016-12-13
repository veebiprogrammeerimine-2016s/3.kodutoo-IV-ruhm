<?php
    //yhendan sessiooniga
    require("functions.php");

    //kui ei ole sisseloginud, suunan login lehele
    if(!isset($_SESSION["userId"])) {
      header("Location: login.php");
      exit();
    }

    //kas aadressireal on logout
    if (isset($_GET["logout"])) {

      session_destroy();

      header("Location: login.php");
      exit();
    }

    if ( isset($_POST["author"]) &&
   isset($_POST["artist"]) &&
   isset($_POST["songname"]) &&
   isset($_POST["created"]) &&
   isset($_POST["duration"]) &&
   isset($_POST["album"]) &&
   isset($_POST["genre"]) &&
   isset($_POST["comment"]) &&
   !empty($_POST["author"]) &&
   !empty($_POST["artist"]) &&
   !empty($_POST["songname"]) &&
   !empty($_POST["created"]) &&
   !empty($_POST["duration"]) &&
   !empty($_POST["album"]) &&
   !empty($_POST["genre"]) &&
   !empty($_POST["comment"])

  ) {

  //$color = cleanInput($_POST["color"]);
  //$age = cleanInput($_POST["age"]);
  $author= cleanInput($_POST["author"]);
  $artist= cleanInput($_POST["artist"]);
  $songname= cleanInput($_POST["songname"]);
  $created= cleanInput($_POST["created"]);
  $duration= cleanInput($_POST["duration"]);
  $album= cleanInput($_POST["album"]);
  $genre= cleanInput($_POST["genre"]);
  $comment= cleanInput($_POST["comment"]);

  saveSong($author, $artist, $songname, $created, $duration, $album, $genre, $comment);

  }

  $songs = getAllSongs();

  /*echo "<pre>";
  var_dump($songs[5]);
  echo "</pre>";*/

?>


<h1>Data</h1>

<p>

    Tere tulemast <?=$_SESSION["userEmail"];?>!
    <a href="?logout=1">logi välja</a>

</p>

    <h2>Salvesta oma teos </h2>

    <form method = "POST" >

      <label> Autor </label><br>
      <input name="author" type="text">

      <br><br>

      <label> Esitaja </label><br>
      <input name="artist" type="text">

      <br><br>

      <label> Pealkiri </label><br>
      <input name="songname" type="text">

      <br><br>

      <label> Loomise aasta </label><br>
      <input name="created" type="number">

      <br><br>

      <label> Kestvus </label><br>
      <input name="duration" type="time">

      <br><br>

      <label> Plaat </label><br>
      <input name="album" type="text">

      <br><br>

      <label> Žanr </label><br>
      <input name="genre" type="text">

      <br><br>

      <label> Kommentaar </label><br>
      <input name="comment" type="text">

      <br><br>

	    <input type="submit" value="Salvesta">

</form>

<h2> Kõik salvestatud teosed </h2>

<?php


    $html = "<table>";

      $html .= "<tr>";
        $html .= "<th>ID</th>";
        $html .= "<th>Autor</th>";
        $html .= "<th>Esitaja</th>";
        $html .= "<th>Pealkiri</th>";
        $html .= "<th>Loomise aasta</th>";
        $html .= "<th>Kestvus</th>";
        $html .= "<th>Plaat</th>";
        $html .= "<th>Žanr</th>";
        $html .= "<th>Kommentaar</th>";
      $html .= "</tr>";

      foreach ($songs as $s)  {

        $html .= "<tr>";
          $html .= "<td>".$s->id."</td>";
          $html .= "<td>".$s->author."</td>";
          $html .= "<td>".$s->artist."</td>";
          $html .= "<td>".$s->songname."</td>";
          $html .= "<td>".$s->created."</td>";
          $html .= "<td>".$s->duration."</td>";
          $html .= "<td>".$s->album."</td>";
          $html .= "<td>".$s->genre."</td>";
          $html .= "<td>".$s->comment."</td>";
        $html .= "</tr>";


      }

    $html .= "</table>";

    echo $html;


?>

<!--
 <h2>Player test</h2>



<audio controls>
  <source src="" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
-->
