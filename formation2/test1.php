<?php
$link = mysqli_connect('localhost', 'root', 'root','library') or die('Could not connect: ' . mysql_error());
header("Content-Type: text/xml");
// verification du chemin de l�URL
$path = $_SERVER['PATH_INFO'];
if ($path != null) {
	$path_params = explode ("/", $path);
}
//V�rifie le type de la method de requete
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//Un parametre est il pass� dans la requ�te pour obtenir un livre en particulier
	if ($path_params[1] != null) {
		settype($path_params[1], 'integer');
		$query = "SELECT b.id, b.name, b.author, b.isbn FROM book as b WHERE b.id = $path_params[1]";
	} else {
		$query = "SELECT b.id, b.name, b.author, b.isbn FROM book as b";
	}
	$result = mysqli_query($link,$query) or die('Query failed: ' . mysql_error());
	//Recuperation des resultants au format xml
	echo "<books>";
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		echo "<book>";
		foreach ($line as $key => $col_value) {
			echo "<$key>$col_value</$key>";
		}
		echo "</book>";
	}
	echo "</books>";
	mysqli_free_result($result);
}
mysqli_close($link);
?>
