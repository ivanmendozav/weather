<?php
/**
 * Author: IMendoza
 * DAte: 8/06/2020
 */
     require_once("config.php");    

    //parse coming string
    if(isset($_GET["city"])){
           $city = $_GET["city"];
    }else{
        $city = "Mar del Plata,AR"; 
    }

    $prepared_url = OWM_URL."?q=".$city."&APPID=".OWM_API_KEY."&lang=".OWM_LANGUAGE;
    $response = file_get_contents($prepared_url); 
    //$response = '{"coord":{"lon":-58.38,"lat":-34.61},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"base":"stations","main":{"temp":290.01,"feels_like":289.51,"temp_min":289.82,"temp_max":290.37,"pressure":1014,"humidity":72},"visibility":8000,"wind":{"speed":1.5,"deg":270},"clouds":{"all":75},"dt":1591640323,"sys":{"type":1,"id":8224,"country":"AR","sunrise":1591613762,"sunset":1591649374},"timezone":-10800,"id":3435910,"name":"Buenos Aires","cod":200}';
    $data = json_decode($response,true);
    
    // OWM response to array
    // Example: Array ( [coord] => Array ( [lon] => -57.56 [lat] => -38 ) [weather] => Array ( [0] => Array ( [id] => 500 [main] => Rain [description] => light rain [icon] => 10d ) ) [base] => stations [main] => Array ( [temp] => 287.55 [feels_like] => 284.68 [temp_min] => 287.04 [temp_max] => 288.15 [pressure] => 1014 [humidity] => 87 ) [visibility] => 10000 [wind] => Array ( [speed] => 5.1 [deg] => 320 ) [rain] => Array ( [1h] => 0.25 ) [clouds] => Array ( [all] => 75 ) [dt] => 1591636911 [sys] => Array ( [type] => 1 [id] => 8305 [country] => AR [sunrise] => 1591614106 [sunset] => 1591648636 ) [timezone] => -10800 [id] => 3430863 [name] => Mar del Plata [cod] => 200 );

    $description = $data["weather"][0]["description"];
    $icon = $data["weather"][0]["icon"];
    $temp = $data["main"]["temp"];
    $temp_min = $data["main"]["temp_min"];
    $temp_max = $data["main"]["temp_max"];
    $humidity = $data["main"]["humidity"];
    echo '{"description":"'.$description.'","icon":"'.$icon.'","temp_min":'.$temp_min.',"temp_max":'.$temp_max.',"temp":'.$temp.',"humidity":'.$humidity.'}';
?>
