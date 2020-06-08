<?php
/**
 * Author: IMendoza
 * Date: 8/06/2020
 */
class OWM_Adapter{
    /**
     * Get forecast for next days from OWM 
     */
    public static function getForecast($city){
        $location = OWM_Adapter::GeoCode($city);
        $prepared_url = OWM_FORECAST_URL."?lat=".$location["lat"]."&lon=".$location["lon"]."&APPID=".OWM_API_KEY."&units=metric&exclude=hourly,minutely,current&lang=".OWM_LANGUAGE;
        $response = file_get_contents($prepared_url); 
        //$response = '{"lat":-38,"lon":-57.58,"timezone":"America/Argentina/Buenos_Aires","timezone_offset":-10800,"current":{"dt":1591647614,"sunrise":1591614111,"sunset":1591648641,"temp":15.57,"feels_like":13.94,"pressure":1012,"humidity":72,"dew_point":10.55,"uvi":1.59,"clouds":20,"visibility":10000,"wind_speed":2.6,"wind_deg":290,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"rain":{}},"daily":[{"dt":1591628400,"sunrise":1591614111,"sunset":1591648641,"temp":{"day":15.57,"min":12.11,"max":15.57,"night":12.11,"eve":14.87,"morn":15.57},"feels_like":{"day":14.22,"night":9.97,"eve":13.41,"morn":14.22},"pressure":1012,"humidity":72,"dew_point":10.55,"wind_speed":2.2,"wind_deg":294,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"clouds":20,"uvi":1.59},{"dt":1591714800,"sunrise":1591700541,"sunset":1591735033,"temp":{"day":14.51,"min":10.23,"max":15.3,"night":10.23,"eve":12.45,"morn":10.56},"feels_like":{"day":9.85,"night":5.2,"eve":8.7,"morn":6.97},"pressure":1014,"humidity":51,"dew_point":4.63,"wind_speed":4.91,"wind_deg":264,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.65},{"dt":1591801200,"sunrise":1591786970,"sunset":1591821427,"temp":{"day":15.96,"min":10.27,"max":16.87,"night":12.27,"eve":13.68,"morn":10.27},"feels_like":{"day":9.98,"night":7.73,"eve":10,"morn":3.72},"pressure":1011,"humidity":51,"dew_point":6.05,"wind_speed":7.18,"wind_deg":283,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":4,"uvi":1.67},{"dt":1591887600,"sunrise":1591873398,"sunset":1591907822,"temp":{"day":14.62,"min":11.02,"max":16.45,"night":12.96,"eve":13.87,"morn":11.05},"feels_like":{"day":9.87,"night":6.13,"eve":10.02,"morn":6.43},"pressure":1012,"humidity":71,"dew_point":9.56,"wind_speed":6.63,"wind_deg":332,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.73},{"dt":1591974000,"sunrise":1591959824,"sunset":1591994220,"temp":{"day":14,"min":11.26,"max":16.88,"night":11.26,"eve":13.6,"morn":11.9},"feels_like":{"day":10.55,"night":4.25,"eve":10.62,"morn":8.57},"pressure":1006,"humidity":81,"dew_point":10.81,"wind_speed":5.3,"wind_deg":340,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10d"}],"clouds":98,"rain":0.38,"uvi":1.73},{"dt":1592060400,"sunrise":1592046248,"sunset":1592080619,"temp":{"day":10.69,"min":5.88,"max":10.69,"night":5.88,"eve":7.71,"morn":8.38},"feels_like":{"day":3.45,"night":-1.3,"eve":-0.31,"morn":0.92},"pressure":1017,"humidity":57,"dew_point":2.62,"wind_speed":8.08,"wind_deg":220,"weather":[{"id":501,"main":"Rain","description":"lluvia moderada","icon":"10d"}],"clouds":58,"rain":3.58,"uvi":1.5},{"dt":1592146800,"sunrise":1592132671,"sunset":1592167019,"temp":{"day":8.92,"min":4.91,"max":10.37,"night":6.17,"eve":8.57,"morn":4.94},"feels_like":{"day":4.72,"night":0.23,"eve":4.23,"morn":-1.2},"pressure":1028,"humidity":58,"dew_point":1.15,"wind_speed":3.41,"wind_deg":247,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.76},{"dt":1592233200,"sunrise":1592219093,"sunset":1592253422,"temp":{"day":10.5,"min":5.6,"max":12.75,"night":12,"eve":11.34,"morn":5.6},"feels_like":{"day":2.8,"night":3.73,"eve":2.9,"morn":-1.48},"pressure":1023,"humidity":56,"dew_point":2.27,"wind_speed":8.63,"wind_deg":355,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.63}]}';
        $data = json_decode($response,true);

        // OWM response to array
        // Example: {"lat":-38,"lon":-57.58,"timezone":"America/Argentina/Buenos_Aires","timezone_offset":-10800,"current":{"dt":1591647614,"sunrise":1591614111,"sunset":1591648641,"temp":15.57,"feels_like":13.94,"pressure":1012,"humidity":72,"dew_point":10.55,"uvi":1.59,"clouds":20,"visibility":10000,"wind_speed":2.6,"wind_deg":290,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"rain":{}},"daily":[{"dt":1591628400,"sunrise":1591614111,"sunset":1591648641,"temp":{"day":15.57,"min":12.11,"max":15.57,"night":12.11,"eve":14.87,"morn":15.57},"feels_like":{"day":14.22,"night":9.97,"eve":13.41,"morn":14.22},"pressure":1012,"humidity":72,"dew_point":10.55,"wind_speed":2.2,"wind_deg":294,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"clouds":20,"uvi":1.59},{"dt":1591714800,"sunrise":1591700541,"sunset":1591735033,"temp":{"day":14.51,"min":10.23,"max":15.3,"night":10.23,"eve":12.45,"morn":10.56},"feels_like":{"day":9.85,"night":5.2,"eve":8.7,"morn":6.97},"pressure":1014,"humidity":51,"dew_point":4.63,"wind_speed":4.91,"wind_deg":264,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.65},{"dt":1591801200,"sunrise":1591786970,"sunset":1591821427,"temp":{"day":15.96,"min":10.27,"max":16.87,"night":12.27,"eve":13.68,"morn":10.27},"feels_like":{"day":9.98,"night":7.73,"eve":10,"morn":3.72},"pressure":1011,"humidity":51,"dew_point":6.05,"wind_speed":7.18,"wind_deg":283,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":4,"uvi":1.67},{"dt":1591887600,"sunrise":1591873398,"sunset":1591907822,"temp":{"day":14.62,"min":11.02,"max":16.45,"night":12.96,"eve":13.87,"morn":11.05},"feels_like":{"day":9.87,"night":6.13,"eve":10.02,"morn":6.43},"pressure":1012,"humidity":71,"dew_point":9.56,"wind_speed":6.63,"wind_deg":332,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.73},{"dt":1591974000,"sunrise":1591959824,"sunset":1591994220,"temp":{"day":14,"min":11.26,"max":16.88,"night":11.26,"eve":13.6,"morn":11.9},"feels_like":{"day":10.55,"night":4.25,"eve":10.62,"morn":8.57},"pressure":1006,"humidity":81,"dew_point":10.81,"wind_speed":5.3,"wind_deg":340,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10d"}],"clouds":98,"rain":0.38,"uvi":1.73},{"dt":1592060400,"sunrise":1592046248,"sunset":1592080619,"temp":{"day":10.69,"min":5.88,"max":10.69,"night":5.88,"eve":7.71,"morn":8.38},"feels_like":{"day":3.45,"night":-1.3,"eve":-0.31,"morn":0.92},"pressure":1017,"humidity":57,"dew_point":2.62,"wind_speed":8.08,"wind_deg":220,"weather":[{"id":501,"main":"Rain","description":"lluvia moderada","icon":"10d"}],"clouds":58,"rain":3.58,"uvi":1.5},{"dt":1592146800,"sunrise":1592132671,"sunset":1592167019,"temp":{"day":8.92,"min":4.91,"max":10.37,"night":6.17,"eve":8.57,"morn":4.94},"feels_like":{"day":4.72,"night":0.23,"eve":4.23,"morn":-1.2},"pressure":1028,"humidity":58,"dew_point":1.15,"wind_speed":3.41,"wind_deg":247,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.76},{"dt":1592233200,"sunrise":1592219093,"sunset":1592253422,"temp":{"day":10.5,"min":5.6,"max":12.75,"night":12,"eve":11.34,"morn":5.6},"feels_like":{"day":2.8,"night":3.73,"eve":2.9,"morn":-1.48},"pressure":1023,"humidity":56,"dew_point":2.27,"wind_speed":8.63,"wind_deg":355,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.63}]}
        
        $forecast_array = $data["daily"];
        foreach($forecast_array as $key => $day) {
            $day_array["date"] = gmdate("Y-m-d", $day["dt"]);
            $day_array["temp"] = $day["temp"]["day"];
            $day_array["icon"] = $day["weather"][0]["icon"];
            $days_array[] = $day_array;
        }
        return json_encode($days_array);
    }
    /**
     * Get current weather from OWM 
     */
    public static function getCurrent($city){
        $prepared_url = OWM_URL."?q=".$city."&APPID=".OWM_API_KEY."&units=metric&lang=".OWM_LANGUAGE;
        $response = file_get_contents($prepared_url); 
        //$response = '{"coord":{"lon":-58.38,"lat":-34.61},"weather":[{"id":803,"main":"Clouds","description":"nubes rotas","icon":"04d"}],"base":"stations","main":{"temp":290.01,"feels_like":289.51,"temp_min":289.82,"temp_max":290.37,"pressure":1014,"humidity":72},"visibility":8000,"wind":{"speed":1.5,"deg":270},"clouds":{"all":75},"dt":1591640323,"sys":{"type":1,"id":8224,"country":"AR","sunrise":1591613762,"sunset":1591649374},"timezone":-10800,"id":3435910,"name":"Buenos Aires","cod":200}';
        $data = json_decode($response,true);
        
        // OWM response to array
        // Example: Array ( [coord] => Array ( [lon] => -57.56 [lat] => -38 ) [weather] => Array ( [0] => Array ( [id] => 500 [main] => Rain [description] => light rain [icon] => 10d ) ) [base] => stations [main] => Array ( [temp] => 287.55 [feels_like] => 284.68 [temp_min] => 287.04 [temp_max] => 288.15 [pressure] => 1014 [humidity] => 87 ) [visibility] => 10000 [wind] => Array ( [speed] => 5.1 [deg] => 320 ) [rain] => Array ( [1h] => 0.25 ) [clouds] => Array ( [all] => 75 ) [dt] => 1591636911 [sys] => Array ( [type] => 1 [id] => 8305 [country] => AR [sunrise] => 1591614106 [sunset] => 1591648636 ) [timezone] => -10800 [id] => 3430863 [name] => Mar del Plata [cod] => 200 );
    
        $weather_array["description"] = $data["weather"][0]["description"];
        $weather_array["icon"] = $data["weather"][0]["icon"];
        $weather_array["temp"] = $data["main"]["temp"];
        $weather_array["temp_min"] = $data["main"]["temp_min"];
        $weather_array["temp_max"] = $data["main"]["temp_max"];
        $weather_array["humidity"] = $data["main"]["humidity"];
        return json_encode($weather_array);
    }

    public static function GeoCode($city){
        $geocode_url = "https://geocode.xyz/";
        $prepared_url = $geocode_url.$city."?json=1&&auth=706002883024838650940x6200";
        $response = file_get_contents($prepared_url);         
        //{"standard" : {"addresst" : {},"city" : "Cuenca Ec", "prov" : "EC","countryname" : "Ecuador","postal" : {},"confidence" : "0.3"   },   "longt" : "-79.01269",   "alt" : {},   "elevation" : {},   "latt" : "-2.89942"}
        $data = json_decode($response,true);
        $longitude = $data["longt"];
        $latitude = $data["latt"];
        return array("lon" => $longitude, "lat" => $latitude);
    }
}
?>