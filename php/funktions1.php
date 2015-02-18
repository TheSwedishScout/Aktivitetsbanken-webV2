<?php


function rait($value,$token,$id){
	
	$url ="http://devscout.mikaelsvensson.info:10081/api/v1/activities/".$id."/rating";

	// The data to send to the API
	$postData = 
		'{
			"rating": "'.$value.'"
		}';
	$rait = curl_init($url); 
	// Set the HTTP request authentication headers
	$headers = array(
			'Authorization: Token token="'.$token.'"',
			'Content-Type: application/json'
		);
		
	curl_setopt($rait, CURLOPT_HTTPHEADER, $headers); //skickar i headern $headers
	curl_setopt($rait, CURLOPT_RETURNTRANSFER, true); // förväntar sig ett svar 
	curl_setopt($rait, CURLOPT_POSTFIELDS, $postData);// skickar iväg $postData till apit
			
	$responserait = curl_exec($rait); //utför $rait
	curl_close($rait); // stänger kontakten

	$resultsrait = json_decode($responserait); //avkådar svaret från json 
	//print_r($resultsrait); //skriver ut svaret från $responserait (email namn ...)
	//print_r($responserait);//--------------------test rad---------------
	return ("din rait är satt till ".$value);
}
function isFavourit($id,$token){
	$urlOldFav ="favourites" ;
	$old_fav = getInfo($urlOldFav,$token);
	$new_fav = $id;
	$fav = json_decode($old_fav);
	if (in_array($new_fav,$fav)){
		return true;
	}else{
		return false;
	}
}

function addFavourit($id,$token){
	
	$urlOldFav ="favourites" ;
	$old_fav = getInfo($urlOldFav,$token);
	$new_fav = $id;
	$fav = json_decode($old_fav);
	$fav[] = $new_fav; 
	
	$users_fav = '['.implode(",",$fav).']';
	
	$postData = 
		'{
			"id": '.$users_fav.'
		}';	
	$url ="http://devscout.mikaelsvensson.info:10081/api/v1/favourites";
	
	$con = curl_init($url);
	$headers = array(
		'Authorization: Token token="'.$token.'"',
		'Content-Type: application/json'
	);
	curl_setopt($con, CURLOPT_HTTPHEADER, $headers); //skickar i headern $headers
	curl_setopt($con, CURLOPT_RETURNTRANSFER, true); // förväntar sig ett svar 
	curl_setopt($con, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($con, CURLOPT_POSTFIELDS, $postData);// skickar iväg $postData till apit

	return $responserait = curl_exec($con); //utför $con
	curl_close($con); // stänger kontakten
	// $postData;
}
function removeFavourit($id,$token){
	
	$urlOldFav ="favourites" ;
	$old_fav = getInfo($urlOldFav,$token);
	$new_fav = $id;
	$fav = json_decode($old_fav);
	if (in_array($new_fav,$fav)){
		if (($key = array_search($new_fav, $fav)) !== false) {
			unset($fav[$key]);
		}
	}
	
	$users_fav = '['.implode(",",$fav).']';
	
	$postData = 
		'{
			"id": '.$users_fav.'
		}';	
	$url ="http://devscout.mikaelsvensson.info:10081/api/v1/favourites";
	
	$con = curl_init($url);
	$headers = array(
		'Authorization: Token token="'.$token.'"',
		'Content-Type: application/json'
	);
	curl_setopt($con, CURLOPT_HTTPHEADER, $headers); //skickar i headern $headers
	curl_setopt($con, CURLOPT_RETURNTRANSFER, true); // förväntar sig ett svar 
	curl_setopt($con, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($con, CURLOPT_POSTFIELDS, $postData);// skickar iväg $postData till apit

	return $responserait = curl_exec($con); //utför $con
	curl_close($con); // stänger kontakten
	// $postData;
}

function getInfo($url,$token) {
	$session = curl_init("http://devscout.mikaelsvensson.info:10081/api/v1/".$url); 
	
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
	return $response;
}
function getInfoNoTokens($url){
	$session = curl_init("http://devscout.mikaelsvensson.info:10081/api/v1/".$url); 
	
	// Set the HTTP request authentication headers
	$headers = array(
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
	return $response;
}
function str_starts_with($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}
/*
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
}*/
function printResult ($my_array){
			usort($my_array, function($a, $b) { return $a->id - $b->id; });
			$x= 0;
			foreach ($my_array as $post){//loppar results och lägger det temp i $post  
		
			if (count($my_array) <= 10){
		
			echo '<div id="'.$x.'"class="result center" >'; // startar en div med id $x vilket är antalet gånger som det loppas

			?>
            <table>
                <tr>
                    <td> <!-- Name (titel) -->
                    			<?php echo "<h1 class='bold_link'> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>"; // skriver ut aktivitetens namn med aktivitets idn som id ?>
                    </td>
                
                    <td> <!-- age group -->
            			<?php
                        echo " Från ".$post->age_min; // skriver rekomenderad min older
						echo " till ".$post->age_max."år"; // skriver rekomenderad max ålder
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><!-- descr_introduction -->
                    	<?php
							echo $post->descr_introduction; // skriver ut en kort beskrevning av aktiviteten
						?>
                    </td>
                </tr>
			</table>
		<?php
			$x++;  // lägger till 1 på $x för nästa ativitet
			//print_r($post); // -------------------------------------------test rad----------------------------------------
			echo "</div>";
			}
			
			
			if (count($my_array) >= 11){
		
			echo '<div id="'.$x.'"class="result center" >'; // startar en div med id $x vilket är antalet gånger som det loppas

			?>
            <table>
                <tr>
                    <td> <!-- Name (titel) -->
                    			<?php echo "<h1 class='bold_link'> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>"; // skriver ut aktivitetens namn med aktivitets idn som id ?>
                    </td>
                
                    <td> <!-- age group -->
            			<?php
                        echo " Från ".$post->age_min; // skriver rekomenderad min older
						echo " till ".$post->age_max."år"; // skriver rekomenderad max ålder
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><!-- descr_introduction -->
                    	<?php
							echo $post->descr_introduction; // skriver ut en kort beskrevning av aktiviteten
						?>
                    </td>
                </tr>
			</table>
		<?php
			$x++;  // lägger till 1 på $x för nästa ativitet
			//print_r($post); // -------------------------------------------test rad----------------------------------------
			echo "</div>";
			}
			
			
		}

}
?>