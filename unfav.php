<?php
include 'javaScript/funktions.php';
include 'php/funktions1.php';

$token = '07f2e0edb17cd1bba91be67ca2b7343428c973a7'; // Mer att göra  (hämta från google)


if (isset($_GET['activity'])){
	
	$activity = (int)$_GET['activity'];

		removeFavourit($activity,$token);

header('Location: mer.php?id='.$activity);
	
}

?>
