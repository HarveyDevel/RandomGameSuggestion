<html> 

<head> 
	<title>Random Game Picker</title> 
</head> 

<body> 

<?php
    
	error_reporting(0);
	echo "<form action=\"index.php\" method=\"get\">\n";
	echo "Enter SteamID: <input type=\"text\" name=\"id\"><br>\n";
	echo "<input type=\"submit\"><br>\n";
	echo "</form>\n";

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	# Replace with your Steam API key.
    $key = 'insert_your_steam_api_key_here';

    $vanitytosteamid64 = file_get_contents('http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=' . $key . '&vanityurl=' . $id . '&format=json');
    $Steam64 = explode("\"", $vanitytosteamid64);
	
	$GetGamesOwned = file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=' . $key . '&include_appinfo=1' . '&steamid=' . $Steam64[5] . '&format=json');
	$GamesOwned = explode("appid", $GetGamesOwned);

	$decoded_object=json_decode($GetGamesOwned);
	foreach($decoded_object->response->games as $game){
			$array_build[]=$game->name."<br />";
	
	}
        if(count($array_build)>0){
	         echo "Or roll again<br>\n";
             echo "<form action=\"index.php?id=$id\" method=\"post\">\n";
	         echo "<input type=\"submit\" value=\"Re-Roll\"><br>\n";
        }
	
} 

if(count($array_build)>0){
        echo "<br> Random Game Picker says go play:<br>";
        shuffle($array_build);
		echo array_pop($array_build);
}
	# Replace with link to your Terms of service which is in itself required by Steam ToS - Be sure to read up on steam requirements.
	echo "<br><br><br>By using this program you agree to our <a href=\"https://link-to-your-tos.html\">Terms of Service</a><br><br>";
	echo "<a href=\"http://steampowered.com\" target=\"_blank\">Powered by Steam</a><br>";
?>

</body> 

</html>