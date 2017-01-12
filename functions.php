<?php
    require_once("../config.php");
    session_start();

    $database = "kodu";

    function signup($email, $name, $password){
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO users (email, name, password) VALUE (?, ?, ?)");
        $stmt->bind_param("sss", $email, $name, $password);
        if ( $stmt->execute() ) {
			echo "Kasutaja loomine õnnestus";
		}
        $stmt->close();
  		$mysqli->close();
    }

    function login($email, $password){
        $notice = "";
        $passwordHash = hash("sha512", $password);
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT id, email, password, name 
                                FROM users WHERE email = ? and password = ?");
        $stmt->bind_param("ss", $email, $passwordHash);
        $stmt->bind_result($id, $emailFromDB, $pwFromDB, $name);
        $stmt->execute();
        if($stmt->fetch()){
            $_SESSION["userID"]=$id;
            $_SESSION["userEmail"]=$emailFromDB;
            $_SESSION["userName"]=$name;
            header("Location: home.php");
        }else{
            $notice = "Valed andmed";
        }
        $stmt->close();
  		$mysqli->close();

        return $notice;
    }
    function saveText($text) {
        $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO todo (text) VALUE (?)");
        echo $mysqli->error;
        $stmt->bind_param("s", $text);
        if ( $stmt->execute() ) {
            echo "Kirje salvestamine õnnestus";
        } else {
            echo "ERROR ".$stmt->error;
        }
        $stmt->close();
  		$mysqli->close();

    }
    function textDone($id) {
        $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("UPDATE todo SET done=1 where id=?");
        $stmt->bind_param("i", $id);
        if ( $stmt->execute() ) {
            echo "Kirje lõpetatud";
        } else {
            echo "ERROR ".$stmt->error;
        }
        $stmt->close();
  		$mysqli->close();

    }
    function getSingleText($id){
        $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT id, text, created FROM todo where id=?");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id, $text, $created);
        $stmt->execute();
        //results = array();
        $todo = new StdClass();
        if($stmt->fetch()) {
            $todo->id = $id;
            $todo->text = $text;
            $todo->created = $created;
        }
        $stmt->close();
  		$mysqli->close();
        return $todo;
    }
    function updateWork($id, $text){
        $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("UPDATE todo SET text=? where id=?");
        $stmt->bind_param("si", $text, $id);
        if($stmt->execute()){
  			// õnnestus
  			echo "salvestus õnnestus!";
  		}
        $stmt->close();
  		$mysqli->close();
    }
    function getSTexts($otsing, $sort, $dir){
        $results = array();
        $orderBy = "ASC";
        if($dir == "descending"){
            $orderBy = "DESC";
        }

        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($otsing == ""){
            $stmt = $mysqli->prepare("SELECT id, text, created FROM todo where done=0 ORDER BY $sort $orderBy");
        }else{
            $searchword = "%".$otsing."%";
            $stmt = $mysqli->prepare("SELECT id, text, created FROM todo where done=0 AND ('text' LIKE ? OR created LIKE ?) ORDER BY $sort $orderBy");
            $stmt->bind_param("ss", $searchword, $searchword);
        }
        
        $stmt->bind_result($id, $text, $created);
        $stmt->execute();

        //results = array();

        while ($stmt->fetch()) {

            $todo = new StdClass();
            $todo->id = $id;
            $todo->text = $text;
            $todo->created = $created;


            //echo $color."<br>";
            array_push($results, $todo);

        }
        $stmt->close();
  		$mysqli->close();
        return $results;

    }
