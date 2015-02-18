<?php
include 'javaScript/funktions.php';
include 'php/funktions1.php';

if (isset($_GET["id"])){
	$id = (int)$_GET["id"];
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


if (isset($id)and isset($token)){ // Token
	$url = "activities?id=".$id;
	$response = getInfo($url,$token);
	//echo rait(2,$token,18);
	$results = json_decode($response);
	$post = $results[0];
	//print_r($results);

	echo '<div class="result center" >'; // startar en div med id $x vilket är antalet gånger som det loppas

			?>
<table>
  <tr>
    <td><!-- Name (titel) --> 
      <?php echo "<h1 class='bold_link'> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>"; // skriver ut aktivitetens namn med aktivitets idn som id ?></td>
    <td><!-- age group -->
      
      <?php
                echo " Från ".$post->age_min; // skriver rekomenderad min older
                echo " till ".$post->age_max."år"; // skriver rekomenderad max ålder
				
				//if (($value > 1 && $value < 10) || ($value > 20 && $value < 40))
				
                ?></td><!-- age group stop -->
    <td><!--rait start-->
    	medel rait: <?php echo round($post->ratings_average); ?>
        baserat på <?php echo round($post->ratings_count); ?> röst(er)
    	<?php foreach(range(1,5) as $raiting): ?>
    			<a href="rait.php?activity=<?php echo $id; ?>&raiting=<?php echo $raiting; ?>" ><?php echo $raiting; ?></a>
    	<?php endforeach; ?>
        din rait: <?php echo round($post->my_rating);?>
   <!-- img src="img/rait/largeoutlinestar.png">-->
    </td><!--rait stop-->
    <td> 
    
    	<?php if(isFavourit($id,$token) === true){ ?>
        <a href="unfav.php?activity=<?php echo $id; ?>" >ta bort från fav</a>
    	<?php }else {?>
        <a href="fav.php?activity=<?php echo $id; ?>" >favorisera</a>
		<?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="4"><!-- descr_introduction -->
		<?php
            echo $post->descr_introduction; // skriver ut en kort beskrevning av aktiviteten
        ?></td>
  </tr>
  <tr>
    <td><h2>Material</h2>
      <p> </td>
    <td colspan="3"><?php
        if (strlen($post->descr_material)> 0){
			$material = $post->descr_material;
			//$material = str_replace(",", "<li>", $material);
			echo $material;
		} else {
			echo "Inget material behövs.";
		}
		echo "</p>";
		?></td>
  </tr>
  <tr>
    <td colspan="4"><!-- descr_introduction -->
      <?php
                    $text = $post->descr_main; // skriver ut en beskrevning av aktiviteten
					$text = str_replace("# Att tänka på", "</p><h2>Att tänka på</h2><p> Att tänka på", $post->descr_main);
					$text = str_replace("#", "<br> #", $text);
					$text = str_replace("*", "<li>", $text);
					echo $text;
                ?></td>
  </tr>
  <tr>
    <td><?php
        $media_items = count($post->media_files);// Start För bilder och sånt 
		if ($media_items > 0){
			echo "<h2>Bilder och sånt</h2><p>"; 
			foreach ($post->media_files as $media){
				switch ($media->mime_type) {
					case "application/pdf":
						echo "<a href='$media->uri'>$media->uri</a>";
						break;
					case "application/msword":
						echo "<a href='$media->uri'>Download</a>";
						break;
					case "image/jpeg":
						echo "<img src='$media->uri'>";
						break;
					case "image/png":
						echo "<img src='$media->uri'>";
						break;
						/*"application/vnd.openxmlformats-officedocument.presentationml.presentation"
						application/vnd.openxmlformats-officedocument.wordprocessingml.document
						"text/plain"
						application/zip
						*/
				}
			}
			echo "</p>"; 
		}// Slut för bilder och sånt
        ?></td>
  </tr>
  <tr>
    <td><?php
        //start Mer information
		if (isset ($post->references) && count($post->references)> 0){
			echo "<h2>Mer Info</h2><p>";
			foreach($post->references as $ref){
				if (isset($ref->description)){
					echo $ref->description;
				}
				if (isset($ref->uri)){
					//echo $ref->uri;
					echo "<a href='$ref->uri'>$ref->uri</a>";
				}	
			}
		}//Slut Mer Information
        ?></td>
  </tr>
  <tr>
    <td colspan="4"><?php
		$categories_items = count($post->categories);// Start Kategorier
		if ($categories_items > 0){
			echo "<h2> Kategorier</h2><p>";
			foreach ($post->categories as $cat){
				//echo $cat->name;
				if (isset ($cat->media_file->uri)){
					echo "<a href='category.php?category=$cat->id'>";
				echo '<img src="'.$cat->media_file->uri.'" title="'.$cat->name.'" width="60px">';
				echo "</a>";
//			/category/{id}
				}else{
					echo $cat->name;
				}
			}
			echo "</p>";
		}//Slut Kategorier
		?></td>
  </tr>
</table>
<?php
    echo "</div>";
}else{ //no token
	$url = "activities?id=".$id;
	echo getInfoNoTokens($url);
	echo "no token";
}
?>
</body>
</html>