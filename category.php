<?php
include 'javaScript/funktions.php';
include 'php/funktions1.php';

if (isset($_GET["category"])){
	$cat = (int)$_GET["category"];
}
$token = 'e5b373adcf'; // MER ATT GÖRA
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="https://apis.google.com/js/client:platform.js" async defer></script>
<link rel="stylesheet" type="text/css" href="styles/style.css">

</head>

<body>
<div style=" position:absolute; left:0; top:0;">
<a href="index.php"><img src="img/aktivitetsbanken_android_icon.png" alt="" width="100"/></a>
</div>
<table class="center" width="300px">
  <tr>
    <td><form action="index.php" method="get">
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
            <td><input type="range" style="width: 200px !important " name="age_2" min="0" max="40" value="0" onchange="updateTextInput2(this.value);"></td>
            <td><div id="textInput2">0 </div></td>
          </tr>
          <tr>
            <td colspan="3"> sidor </td>
          </tr>
        </table>
      </form></td>
    <td><span id="signinButton"> 
    	<span	class="g-signin"
                data-callback="signinCallback"
                data-clientid="139070892429-g1q9l9jcntanab94duoe9ae01dd5kub7.apps.googleusercontent.com"
                data-cookiepolicy="single_host_origin"
                data-requestvisibleactions="http://schema.org/AddAction"
                data-scope="https://www.googleapis.com/auth/plus.login">
        </span> </span></td>
  </tr>
</table>
<?php
$url = "activities?categories=".$cat;

//print_r (getInfoNoTokens($url));
$response = getInfoNoTokens($url);
	


$my_array = json_decode($response);
printResult($my_array);


?>

</body>
</html>