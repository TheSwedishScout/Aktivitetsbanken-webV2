<?
echo "hej";

/*
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
	print_r($resultsrait); //skriver ut svaret från $responserait (email namn ...)
	print_r($responserait);//--------------------test rad---------------
}
*/
?>