<?php
require("functions.php");
if(!isset($_SESSION["userID"])){
    header("Location: index.php");
}
//kas aadressireal on logout
if(isset($_GET["logout"])) {
  session_destroy();
  header("Location: index.php");
}
if ( isset($_SESSION["userID"]) && isset($_POST["text"]) &&
   !empty($_POST["text"])
){
  saveText($_POST["text"]);
}
if(isset($_GET["done"])&& !empty($_GET["done"])) {
  textDone($_GET["done"]);
}
if(isSet($_REQUEST["sort"]) && isSet($_REQUEST["dir"])){
    $sort =$_REQUEST["sort"];
    $dir = $_REQUEST["dir"];
}else{
    $sort = "id";
 	$dir = "ascending";
}
if(isset($_REQUEST["otsing"])){
    $otsing = trim($_REQUEST["otsing"]);
 	$texts2 = getSTexts($otsing, $sort, $dir);
} else {
 	$otsing = "";
 	$texts2 = getSTexts($otsing, $sort, $dir);
}
?>
<h1>To Do</h1>
<p>Oled sisse loginud kui <b><?=$_SESSION["userName"];?></b> <a href="?logout=1">logi valja </a></p>
<br>
<h2>To Do lisamine</h2>
<form method="POST" >
	<label>Tekst</label><br>
	<input name="text" type="text">
	<input type="submit" value="Salvesta">
</form>
<br>
<h2>To Do List </h2>
<form>
 <input type="search" name="otsing" value="<?=$otsing;?>">
 	<input type="submit" class="btn btn-success" value="Otsi">
 </form>
<?php
    $dir = "ascending";
    if(isSet($_REQUEST["dir"]) && $_REQUEST["dir"]== "ascending"){
        $dir = "descending";
    }
 $html = "";
  $html .= "<table border='1px'>";

  $html .= "<tr>";
    $html .= "<th><a href='?otsing=".$otsing."&sort=id&dir=".$dir."'>id</a></th>";
    $html .= "<th><a href='?otsing=".$otsing."&sort=text&dir=".$dir."'>Text</a></th>";
    $html .= "<th><a href='?otsing=".$otsing."&sort=created&dir=".$dir."'>Tehtud</a></th>";
    $html .= "<th></th>";
  $html .= "</tr>";

  foreach ($texts2 as $text2) {
    $html .= "<tr>";
      $html .= "<td>".$text2->id."</td>";
      $html .= "<td>".$text2->text."</td>";
      $html .= "<td>".$text2->created."</td>";
      $html .= "<td><a href='?done=".$text2->id."'><input type='button' value='Tehtud'></a></td>";
      $html .= "<td><a href='edit.php?id=".$text2->id."'><input type='button' value='Edit'></a></td>";
    $html .= "</tr>";

  }
  $html .= "</table>";
  echo $html;
?>