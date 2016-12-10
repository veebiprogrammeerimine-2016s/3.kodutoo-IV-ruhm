<?php
	
	require("functions.php");
	
	if (!isset ($_SESSION["userId"])) {
		header("Location: HOME_page.php");
		exit();	
	}
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: MAIN_page.php");
		exit();
	}

?>

<html>
Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href="?logout=1">Logi välja</a>

<style>
	
	.cat_col{
		color:#A11F2F;
		font-weight: 600;
	}
</style>

<body>
	<h2>Tee uue postituse</h2>
	<form method="POST">
	<!--KATEGOORIA-->
	<p><label for="category">Vali eriala:</label><br>
	<select name="category" id="category" size="4" required>
	<option value="BMKKI" disabled="" class="cat_col">Balti filmi, meedia, kunstide ja kommunikatsiooni instituut</option>
	<option value="Ajakirjadnus">Ajakirjandus</option>
	<option value="Kunst,Muusika,Multimeedia">Kunst,Muusika,Multimeedia</option>
	<option value="Koreograafia">Koreograafia</option>
	<option value="Audiovisuaalne meedia">Audiovisuaalne meedia</option>
	<option value="Reklaam ja imagoloogia">Reklaam ja imagoloogia</option>
	<option value="Ristmeedia filmis ja televisioonis">Ristmeedia filmis ja televisioonis</option>
	<option value="Suhtekorraldus">Suhtekorraldus</option>
	<option value="Reklaam ja imagoloogia">Reklaam ja imagoloogia</option>
	<option value="" disabled="DI" class="cat_col">Digitehnoloogiate instituut</option>
	<option value="Informaatika">Informaatika</option>
	<option value="Infoteadus">Infoteadus</option>
	<option value="Infoteadus">Matemaatika</option>
	<option value="" disabled="HTI" class="cat_col">Haridusteaduste instituut</option>
	<option value="Alushariduse pedagoog">Alushariduse pedagoog</option>
	<option value="Andragoogika">Andragoogika</option>
	<option value="Eripedagoogika">Eripedagoogika</option>
	<option value="Klassiopetaja">Klassiopetaja</option>
	<option value="Kutsepadagoogika">Kutsepadagoogika</option>
	<option value="Noorsootoo">Noorsootoo</option>
	<option value="Pedagoogika">Pedagoogika</option>

	
	</select>
	<br><br>
	<!--pealkiri-->
	<label for="headline">Teema pealkiri</label><br>
	<input name="headline">
	<br>
	<!--Kommentaar-->
	<textarea rows="4" cols="50" name="comment">Comment...</textarea>
	<br><br>
	<input type="submit" value="postita">
	
</form>
</body>		
</html>