<?php 
include 'javaScript/funktions.php';
include 'php/funktions1.php';
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


<table class="center" width="300px">
    <tr>
        <td>
            <form  method="get">
            <table>
            	<tr>
                <td></td>
                <td><input type="search" id="searchBar" name="sokfras" value="<?php if (isset($_GET["sokfras"])) { echo $_GET["sokfras"]; } else { echo "sök ord";} ?> "  onClick="searchfor()"></td>
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
//echo $ost;
$url ="http://devscout.mikaelsvensson.info:10081/api/v1/activities?text=".$_GET["sokfras"];
$url2 ="http://devscout.mikaelsvensson.info:10081/api/v1/activities/18/rating";
$url3 ="http://devscout.mikaelsvensson.info:10081/api/v1/favourites";
$url4 ="http://devscout.mikaelsvensson.info:10081/api/v1/users/profile";
$token = '07f2e0edb17cd1bba91be67ca2b7343428c973a7'; 
//rait(5,$token,18);

echo '<br>';
// Initialize the cURL session with the request URL
$session = curl_init($url); 
	
	// Set the HTTP request authentication headers
	$headers = array(
		'Authorization: Token token="'.$token.'"',
		'Content-Type: application/json'
	);
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
	//curl_setopt($session, CURLOPT_URL, $url);
	//curl_setopt($session, CURLOPT_POST, true);
	//curl_setopt($session, CURLOPT_POSTFIELDS, $token);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	
	//curl --output scoutapi.flat --header "Authorization: Token token=\"85df3deb58\"" http://devscout.mikaelsvensson.info:10081/api/v1/activities?age_1=8&age_2=9
	
	// Execute cURL on the session handle
	$response = curl_exec($session);
// Close the cURL session
curl_close($session);

echo '<br>';
//print_r($response);//-------------------------TEST RAD-------------------------------------------------------
echo '<br>';

$results = json_decode($response);


$my_array = $results;
usort($my_array, 'custom_sort');
function custom_sort($a, $b) {
  // The < and > operators used on strings check whether a string is alphabetically greater or less than another value
  if($a->id > $b->id) {
    // A is greater than B
    return 1;
  } else if( $a < $b ) {
    // A is less than B
    return -1;
  } else {
    // A and B have the same value
    return 0;
  }
}

//print_r($my_array);
rait(5,$token,18);

$resultcount = count($results); // räknar antalet ynd
		$sidcount = ($resultcount-1)/10; // -1 för att jag vill börga på 0 och inte 1 sedan delar det på 10 då det är antalt resultat per sida
		$sidcount = ceil($sidcount); //avrundar upp (4.1 blir 5) för att alla resultat ska visas
	
	
	
		//echo $sokOrd;
		$x=0; // nollställer x till 0
		foreach ($my_array as $post){//loppar results och lägger det temp i $post  
			echo '<div id="'.$x.'"class="result center" >'; // startar en div med id $x vilket är antalet gånger som det loppas
			echo "<h1> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>"; // skriver ut aktivitetens namn med aktivitets idn som id
			echo " Från ".$post->age_min; // skriver rekomenderad min older
			echo " till ".$post->age_max."år"; // skriver rekomenderad max ålder
			echo "<br/>";
			echo $post->descr_introduction; // skriver ut en kort beskrevning av aktiviteten
			$x++;  // lägger till 1 på $x för nästa ativitet
			echo "<br/>";
			echo "<br/>";
			echo "<br/>";
			print_r($post); // -------------------------------------------test rad----------------------------------------
			echo "</div>";
			
	}


	
	
	
	
	
?></body>