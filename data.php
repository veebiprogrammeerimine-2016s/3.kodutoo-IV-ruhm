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

    $author = "";
  	$authorError = "*";


  	if (isset ($_POST["author"])) {


  		if (empty ($_POST["author"])) {

  			$authorError = "* Autori nime oleks siiski vaja teada!";

  		} else { $author = cleanInput($_POST["author"]);

  		}

  	}

    $artist = "";
    $artistError = "*";


    if (isset ($_POST["artist"])) {


      if (empty ($_POST["artist"])) {

        $artistError = "* Esitaja nime oleks siiski vaja teada!";

      } else { $artist = cleanInput($_POST["artist"]);

      }

    }

    $songname = "";
    $songnameError = "*";


    if (isset ($_POST["songname"])) {


      if (empty ($_POST["songname"])) {

        $songnameError = "* Pealkiri on kohustuslik!";

      } else { $songname = cleanInput($_POST["songname"]);

      }

    }

    $created = "";
    $createdError = "*";


    if (isset ($_POST["created"])) {


      if (empty ($_POST["created"])) {

        $createdError = "* No millal lugu valmis sai!?";

      } else { $created = cleanInput($_POST["created"]);
      }

    }

    $duration = "";
    $durationError = "*";


    if (isset ($_POST["duration"])) {


      if (empty ($_POST["duration"])) {

        $durationError = "* Kaua lugu kestab? Pane kasvõi umbkaudne aeg :)";

      } else { $duration = cleanInput($_POST["duration"]);
      }

    }

    $album = "";

    if (isset ($_POST["album"])) {
      $album = cleanInput($_POST["album"]);
    }

    $genre = "";
    if (isset ($_POST["genre"])) {
      $genre = cleanInput($_POST["genre"]);
    }

    $comment = "";
    if (isset ($_POST["comment"])) {
      $comment = cleanInput($_POST["comment"]);
    }

    if ( isset($_POST["author"]) &&
   isset($_POST["artist"]) &&
   isset($_POST["songname"]) &&
   isset($_POST["created"]) &&
   isset($_POST["duration"]) &&
   !empty($_POST["author"]) &&
   !empty($_POST["artist"]) &&
   !empty($_POST["songname"]) &&
   !empty($_POST["created"]) &&
   !empty($_POST["duration"])

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
    header("Location: data.php");

  }

  if(isset($_GET["q"])) {
		$q = $_GET["q"];

	} else {
		//ei otsi
		$q = "";
	}

  $sort = "id";
	$order = "ASC";

	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];

	}

  $songs = getAllSongs($q, $sort, $order);


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Pirate radio...arrr, matey!</title>
	</head>
  <body>

<h1>Pirate radio</h1>
<h3>Arrr, matey!</h3>

<p>

    Tere <?=$_SESSION["userFirstname"];?>!
    <br>
    <a href="?logout=1">Logi välja</a>

</p>

    <h2>Salvesta oma teos </h2>

    <form method = "POST" >

      <label> Autor </label><br>
      <input name="author" type="text" value="<?=$author;?>"> <?php echo $authorError; ?>

      <br><br>

      <label> Esitaja </label><br>
      <input name="artist" type="text" value="<?=$artist;?>"> <?php echo $artistError; ?>

      <br><br>

      <label> Pealkiri </label><br>
      <input name="songname" type="text" value="<?=$songname;?>"> <?php echo $songnameError; ?>

      <br><br>

      <label> Loomise aasta </label><br>
      <input name="created" type="number" value="<?=$created;?>"> <?php echo $createdError; ?>

      <br><br>

      <label> Kestvus </label><br>
      <input name="duration" type="time" value="<?=$duration;?>"> <?php echo $durationError; ?>

      <br><br>

      <label> Plaat </label><br>
      <input name="album" type="text" value="<?=$album?>">

      <br><br>

      <label> Žanr </label><br>
      <input name="genre" type="text" value="<?=$genre;?>">

      <br><br>

      <label> Kommentaar </label><br>
      <input name="comment" type="textbox" value="<?=$comment;?>">

      <br><br>

	    <input type="submit" value="Salvesta">

</form>

<h2>Otsing </h2>

<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>


<h2>Salvestatud teosed </h2>

<?php


    $html = "<table>";


    //IDga seotud
    $orderId = "ASC";
    $arr="&#8597;";
    if (isset($_GET["order"]) &&
    $_GET["order"] == "ASC" &&
    $_GET["sort"] == "id") {

      $orderId = "DESC";
      $arr="&#8597;";
    }


      $html .= "<th>
      <a href='?q=".$q."&sort=id&order=".$orderId."'>

      ID ".$arr."

      </a>

      </th>";

      //Autoriga seotud

      $orderAuthor = "ASC";
      $arr="&#8597;";
      if (isset($_GET["order"]) &&
      $_GET["order"] == "ASC" &&
      $_GET["sort"] == "author") {

        $orderAuthor = "DESC";
        $arr="&#8597;";
      }

        $html .= "<th>
        <a href='?q=".$q."&sort=author&order=".$orderAuthor."'>

        Autor ".$arr."

        </a>

        </th>";

      //Esitaja
      $orderArtist = "ASC";
      $arr="&#8597;";
      if (isset($_GET["order"]) &&
      $_GET["order"] == "ASC" &&
      $_GET["sort"] == "artist") {

        $orderArtist = "DESC";
        $arr="&#8597;";
      }

        $html .= "<th>
        <a href='?q=".$q."&sort=artist&order=".$orderArtist."'>

        Esitaja ".$arr."

        </a>

        </th>";
      //Pealkiri
      $orderSongname = "ASC";
      $arr="&#8597;";
      if (isset($_GET["order"]) &&
      $_GET["order"] == "ASC" &&
      $_GET["sort"] == "songname") {

        $orderSongname = "DESC";
        $arr="&#8597;";
      }

        $html .= "<th>
        <a href='?q=".$q."&sort=songname&order=".$orderSongname."'>

        Pealkiri ".$arr."

        </a>

        </th>";

        //Loomise aastaga seotud

        $orderCreated = "ASC";
        $arr="&#8597;";
        if (isset($_GET["order"]) &&
        $_GET["order"] == "ASC" &&
        $_GET["sort"] == "created") {

          $orderCreated= "DESC";
          $arr="&#8597;";
        }

          $html .= "<th>
          <a href='?q=".$q."&sort=created&order=".$orderCreated."'>

          Loomise aasta ".$arr."

          </a

          </th>";


          //Kestvus
          $orderDuration = "ASC";
          $arr="&#8597;";
          if (isset($_GET["order"]) &&
          $_GET["order"] == "ASC" &&
          $_GET["sort"] == "duration") {

            $orderDuration= "DESC";
            $arr="&#8597;";
          }

            $html .= "<th>
            <a href='?q=".$q."&sort=duration&order=".$orderDuration."'>

            Kestvus ".$arr."

            </a

            </th>";
            //Plaat
            $orderAlbum = "ASC";
            $arr="&#8597;";
            if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "album") {

              $orderAlbum= "DESC";
              $arr="&#8597;";
            }

              $html .= "<th>
              <a href='?q=".$q."&sort=album&order=".$orderAlbum."'>

              Plaat ".$arr."

              </a

              </th>";
              //žanr
              $orderGenre= "ASC";
              $arr="&#8597;";
              if (isset($_GET["order"]) &&
              $_GET["order"] == "ASC" &&
              $_GET["sort"] == "genre") {

                $orderGenre= "DESC";
                $arr="&#8597;";
              }

                $html .= "<th>
                <a href='?q=".$q."&sort=genre&order=".$orderGenre."'>

                Žanr ".$arr."

                </a

                </th>";

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
          $html .= "<td>
  							<a href='edit.php?id=".$s->id."'>
  							Edit
  							</a>
  							</td>";
        $html .= "</tr>";


      }

    $html .= "</table>";

    echo $html;


?>

</body>
</html>
<!--
 <h2>Player test</h2>



<audio controls>
  <source src="" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
