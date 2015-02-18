<?php
include 'javaScript/funktions.php';
include 'php/funktions1.php';

$token = '07f2e0edb17cd1bba91be67ca2b7343428c973a7'; // Mer att göra  (hämta från google)


if (isset($_GET['activity'],$_GET['raiting'])){
	
	$activity = (int)$_GET['activity'];
	$raiting = (int)$_GET['raiting'];
	
	if (in_array($raiting, [1,2,3,4,5])){
		rait($raiting,$token,$activity);
	}

header('Location: mer.php?id='.$activity);
	
}

?>
