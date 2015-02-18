<?php 
include 'javaScript/funktions.php';
include 'php/funktions1.php';
$token = 'e5b373adcf'; // Mer att göra  (hämta från google)

?>
<head>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Aktivitetsbank</title>
<!--<link rel="stylesheet" href="styles/style.css">-->
<script src="https://apis.google.com/js/client:platform.js" async defer></script>
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<div style=" position:absolute; left:0; top:0;">
<a href="index.php"><img src="img/aktivitetsbanken_android_icon.png" alt="" width="100"/></a>
</div>
<table class="center" width="300px">
    <tr>
        <td>
            <form  method="get">
            <table>
            	<tr>
                <td></td>
                <td><input type="search" id="searchBar" name="sokfras" value="<?php if (isset($_GET["sokfras"])) { echo $_GET["sokfras"]; } else { echo "sök ord";} ?> "  
				<?php if (!isset($_GET["sokfras"])) {echo 'onClick="searchfor()"';} ?>></td>
                <td><input type="submit"></td>
                </tr>
                <tr>
                <td>Min ålder</td>
                <td><input type="range" style="width: 200px !important " name="age_1" min="0" max="40" value="0" onchange="updateTextInput1(this.value);"></td>
                <td><div id="textInput1">0 </div></td>
                </tr>
                <tr>
                <td>Max ålder</td>
                <td><input type="range" style="width: 200px !important " name="age_2" min="0" max="40" value="0" onchange="updateTextInput2(this.value);"> </td>
                <td><div id="textInput2">0 </div></td>
                </tr>
                <tr>
                <td colspan="3">
                  sidor
                </td>
                </tr>
                </table>
            </form>
        </td>
        <td>
            <span id="signinButton">
              <span
                class="g-signin"
                data-callback="signinCallback"
                data-clientid="139070892429-g1q9l9jcntanab94duoe9ae01dd5kub7.apps.googleusercontent.com"
                data-cookiepolicy="single_host_origin"
                data-requestvisibleactions="http://schema.org/AddAction"
                data-scope="https://www.googleapis.com/auth/plus.login">
              </span>
            </span>
        </td>
    </tr>
</table>
<?php 
if (isset($_GET["sokfras"])){ ?>
<div class="center" style="width:300px;">
    <form method="get">
        <input type="hidden" name="sokfras" value="<?php  echo $_GET['sokfras']; ?>">
        <input type="hidden" name="age_1" value="<?php  echo $_GET['age_1']; ?>">
        <input type="hidden" name="age_2" value="<?php  echo $_GET['age_2']; ?>">
        <input type="hidden" name="page" value="<?php  if (isset($page) or isset($_GET['pageNav'])) {
			if ($_GET['pageNav'] == "next")
	{
		
		$page = $_GET['page'];
		$page ++;
	}
			if ($_GET['pageNav'] == "pre")
	{
		
		$page = $_GET['page'];
		$page --;
	}
			echo $page;} else {echo 2;} ?>">
        <input type="submit" value="pre" name="pageNav" title="pre">
        <input type="submit" value="next" name="pageNav" title="next">
    </form>
</div>

<?php
}

if (isset($_GET["sokfras"])){
	$sok = trim ($_GET["sokfras"]);
	$url ="activities?text=".$sok;
	//$url2 ="http://devscout.mikaelsvensson.info:10081/api/v1/activities/18/rating";
	//$url3 ="http://devscout.mikaelsvensson.info:10081/api/v1/favourites";
	//$url4 ="http://devscout.mikaelsvensson.info:10081/api/v1/users/profile";
	
	//echo '<br>';
	// Initialize the cURL session with the request URL
	if (isset($token)){
		$response = getInfo($url,$token);
	}else{
		$response = getInfoNoTokens($url);
	}
	
	//echo '<br>';
	//print_r($response);//-------------------------TEST RAD-------------------------------------------------------
	//echo '<br>';


} else if ((isset($token))) {
		$url = 'activities?my_favourites=true';
    	$response = getInfo($url,$token);
} else {
	// visa 10 random	
	$url = 'activities?random=10';
	$response = getInfoNoTokens($url);
	
}

$my_array = json_decode($response);
printResult($my_array);

if (isset($_GET["sokfras"])){
?>
<div class="center" style="width:300px;">
    <form method="get">
        <input type="hidden" name="sokfras" value="<?php  echo $_GET['sokfras']; ?>">
        <input type="hidden" name="age_1" value="<?php  echo $_GET['age_1']; ?>">
        <input type="hidden" name="age_2" value="<?php  echo $_GET['age_2']; ?>">
        <input type="hidden" name="page" value="<?php  if (isset($page) or isset($_GET['pageNav'])) {
			if ($_GET['pageNav'] == "next")
	{
		
		$page = $_GET['page'];
		$page ++;
	}
			if ($_GET['pageNav'] == "pre")
	{
		
		$page = $_GET['page'];
		$page --;
	}
			echo $page;} else {echo 2;} ?>">
        <input type="submit" value="pre" name="pageNav" title="pre">
        <input type="submit" value="next" name="pageNav" title="next">
    </form>
</div>
<br>
<?php
}
?>
</body>