<?php

      //see fail peab olema seotud k6igiga kus
      //tahame sessiooni kasutada
      //saab kasutada nyyd $_SESSION muutujat
      require("../../config.php");

      session_start();

      $database = "if16_taankomm";
      //functions.php

        function signup($signupEmail, $password, $firstname, $lastname, $birthdate,
    		$gender, $profession, $hobbies) {

          //loon yhenduse

      		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
      		$GLOBALS["database"]);

      		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname,
          lastname, birthdate, gender, profession, hobbies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
          echo $mysqli->error;
      		//asendan kysim2rgid
      		//iga m2rgi kohta tuleb lisada yks t2ht - mis tyypi muutuja on
      		//s - string
      		//i - int
      		//d - double
      		$stmt->bind_param("ssssssss", $signupEmail, $password, $firstname, $lastname, $birthdate,
      		$gender, $profession, $hobbies);

      		if ($stmt->execute()) {
      			echo "Õnnestus! Logi nüüd sisse ka!";

      		} else {
      			echo "ERROR ".$stmt->error;

      		}

        }

        function login($email, $password) {

          $notice = " ";

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
      		$GLOBALS["database"]);

      		$stmt = $mysqli->prepare("SELECT id, email, password, created
          FROM user_sample
          WHERE email = ?
          ");

      		echo $mysqli->error;

          //asendan kysim2rgi
          $stmt->bind_param("s", $email);

          //rea kohta tulba v22rtus
          $stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);

          $stmt->execute();

          //ainult SELECTi puhul
          if($stmt->fetch()) {
              //oli olemas, rida k2es
              //kasutaja sisestad sisselogimiseks
              $hash = hash("sha512", $password);

              if ($hash == $passwordFromDb) {
                echo "Kasutaja $id logis sisse";

                $_SESSION["userId"] = $id;
                $_SESSION["userEmail"] = $emailFromDb;

                header("Location: data.php");
                exit();

              } else {
                $notice = "Parool vale";
              }
          } else {

            //ei olnud yhtegi rida
            $notice = "Sellise emailiga $email kasutajat ei ole olemas";
          }

          return $notice;

        }


        function saveSong($author, $artist, $songname, $created, $duration, $album, $genre, $comment) {

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
          $GLOBALS["database"]);

          $stmt = $mysqli->prepare("INSERT INTO songregister (author, artist, songname, created, duration,
            album, genre, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
          echo $mysqli->error;

          $stmt->bind_param("sssiisss", $author, $artist, $songname, $created, $duration, $album, $genre, $comment);

          if ($stmt->execute()) {
            echo "Õnnestus!";
          } else {
            echo "ERROR ".$stmt->error;

          }

        }

        function getAllSongs() {

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
          $GLOBALS["database"]);

          $stmt = $mysqli->prepare("SELECT id, author, artist, songname, created, duration, album, genre, comment FROM songregister
          WHERE deleted IS NULL");

          $stmt->bind_result($id, $author, $artist, $songname, $created, $duration, $album, $genre, $comment);
          $stmt->execute();

          $results = array();
          //tsykli sisu tehakse nii mitu korda, mitu rida
          //SQL lausega tuleb
          while ($stmt->fetch()) {

            $songs = new StdClass();
            $songs->id = $id;
            $songs->author = $author;
            $songs->artist = $artist;
            $songs->songname = $songname;
            $songs->created = $created;
            $songs->duration = $duration;
            $songs->album = $album;
            $songs->genre = $genre;
            $songs->comment = $comment;

            //ec$songsge."<br>";
            //echo $color."<br>";
            array_push($results, $songs);
          }

          return $results;
        }

        function cleanInput($input) {

          $input = trim($input);

          $input = stripslashes($input);

          $input = htmlspecialchars($input);


          return $input;

        }

        function deleteSong($id){

          $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
          $GLOBALS["database"]);

            $stmt = $mysqli->prepare("UPDATE songregister SET deleted=NOW() WHERE id=? AND deleted IS NULL");
            $stmt->bind_param("i",$id);

            if($stmt->execute()){

              echo "Õnnestus!";
            }

            $stmt->close();

          }

          function getSingleSongData($edit_id){

            $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
            $GLOBALS["database"]);

            $stmt = $mysqli->prepare("SELECT id, author, artist, songname, created, duration, album, genre, comment
              FROM songregister
              WHERE id=? AND deleted IS NULL");

            $stmt->bind_param("i", $edit_id);
            $stmt->bind_result($id, $author, $artist, $songname, $created, $duration, $album, $genre, $comment);
            $stmt->execute();

            //tekitan objekti
            $s = new Stdclass();

            //saime ühe rea andmeid
            if($stmt->fetch()){
              // saan siin alles kasutada bind_result muutujaid
              $s->id = $id;
              $s->author = $author;
              $s->artist = $artist;
              $s->songname = $songname;
              $s->created = $created;
              $s->duration = $duration;
              $s->album = $album;
              $s->genre = $genre;
              $s->comment = $comment;


            }else{
              // ei saanud rida andmeid kätte
              // sellist id'd ei ole olemas
              // see rida võib olla kustutatud
              header("Location: data.php");
              exit();
            }

            $stmt->close();

            return $s;

          }

          function updateSong($id, $author, $artist, $songname, $created, $duration, $album, $genre, $comment){

            $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
            $GLOBALS["database"]);

            $stmt = $mysqli->prepare("UPDATE songregister SET author=?, artist=?, songname=?, created=?, duration=?,
              album=?, genre=?, comment=? WHERE id=? AND deleted IS NULL");

            $stmt->bind_param("sssissssi", $author, $artist, $songname, $created, $duration, $album, $genre, $comment, $id);

            // kas õnnestus salvestada
            if($stmt->execute()){
              // õnnestus
              echo "Salvestus õnnestus!";
            }

            $stmt->close();

          }




 ?>
