<?php
class Helper {

function cleanInput ($input) 
	{
// kustutab alguses ja lõpus olevad tühikud ära
		$input = trim($input);
// kustutab \ tagurpidi kaldkriipsud
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
// SAMA return htmlspecialchars(stripslashes($input(trim)));
		return $input;

	}

}
?>