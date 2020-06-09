<?php
/**
 * Author: IMendoza
 * Date: 8/06/2020
 * Description: Manage requests to OWM (Open weather map)
 */
class OWM_Adapter{
    /**
     * Get current weather from OWM 
     */
    public static function getCurrent($city){
        $prepared_url = OWM_URL."?q=".$city."&APPID=".OWM_API_KEY."&units=metric&lang=".OWM_LANGUAGE;
        $response = file_get_contents($prepared_url); 
        //$response = '{"coord":{"lon":-58.38,"lat":-34.61},"weather":[{"id":803,"main":"Clouds","description":"nubes rotas","icon":"04d"}],"base":"stations","main":{"temp":290.01,"feels_like":289.51,"temp_min":289.82,"temp_max":290.37,"pressure":1014,"humidity":72},"visibility":8000,"wind":{"speed":1.5,"deg":270},"clouds":{"all":75},"dt":1591640323,"sys":{"type":1,"id":8224,"country":"AR","sunrise":1591613762,"sunset":1591649374},"timezone":-10800,"id":3435910,"name":"Buenos Aires","cod":200}';
        $data = json_decode($response,true);
        
        // OWM response to array
        $weather_array["date"] = OWM_Adapter::formatDate($data["dt"]);
        $weather_array["description"] = $data["weather"][0]["description"];
        $weather_array["icon"] = $data["weather"][0]["icon"];
        $weather_array["temp"] = round($data["main"]["temp"],1);
        $weather_array["temp_min"] = round($data["main"]["temp_min"],1);
        $weather_array["temp_max"] = round($data["main"]["temp_max"],1);
        $weather_array["humidity"] = $data["main"]["humidity"];
        return $weather_array;
    }

    /**
     * _Allows retrieving both forecasted and historical data at once
     */
    public static function getDays($city){
        $previous_days_array = OWM_Adapter::getHistorical($city,5);
        $next_days_array = OWM_Adapter::getForecast($city);
        return array_merge($previous_days_array,$next_days_array);
    }

    /**
     * Get forecast for next days from OWM 
     */
    public static function getForecast($city){
        $location = OWM_Adapter::GeoCodeSimple($city); //static coordinates
        $prepared_url = OWM_FORECAST_URL."?lat=".$location["lat"]."&lon=".$location["lon"]."&APPID=".OWM_API_KEY."&units=metric&exclude=hourly,minutely,current&lang=".OWM_LANGUAGE;
        $response = file_get_contents($prepared_url); 
        //$response = '{"lat":-38,"lon":-57.58,"timezone":"America/Argentina/Buenos_Aires","timezone_offset":-10800,"current":{"dt":1591647614,"sunrise":1591614111,"sunset":1591648641,"temp":15.57,"feels_like":13.94,"pressure":1012,"humidity":72,"dew_point":10.55,"uvi":1.59,"clouds":20,"visibility":10000,"wind_speed":2.6,"wind_deg":290,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"rain":{}},"daily":[{"dt":1591628400,"sunrise":1591614111,"sunset":1591648641,"temp":{"day":15.57,"min":12.11,"max":15.57,"night":12.11,"eve":14.87,"morn":15.57},"feels_like":{"day":14.22,"night":9.97,"eve":13.41,"morn":14.22},"pressure":1012,"humidity":72,"dew_point":10.55,"wind_speed":2.2,"wind_deg":294,"weather":[{"id":801,"main":"Clouds","description":"algo de nubes","icon":"02d"}],"clouds":20,"uvi":1.59},{"dt":1591714800,"sunrise":1591700541,"sunset":1591735033,"temp":{"day":14.51,"min":10.23,"max":15.3,"night":10.23,"eve":12.45,"morn":10.56},"feels_like":{"day":9.85,"night":5.2,"eve":8.7,"morn":6.97},"pressure":1014,"humidity":51,"dew_point":4.63,"wind_speed":4.91,"wind_deg":264,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.65},{"dt":1591801200,"sunrise":1591786970,"sunset":1591821427,"temp":{"day":15.96,"min":10.27,"max":16.87,"night":12.27,"eve":13.68,"morn":10.27},"feels_like":{"day":9.98,"night":7.73,"eve":10,"morn":3.72},"pressure":1011,"humidity":51,"dew_point":6.05,"wind_speed":7.18,"wind_deg":283,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":4,"uvi":1.67},{"dt":1591887600,"sunrise":1591873398,"sunset":1591907822,"temp":{"day":14.62,"min":11.02,"max":16.45,"night":12.96,"eve":13.87,"morn":11.05},"feels_like":{"day":9.87,"night":6.13,"eve":10.02,"morn":6.43},"pressure":1012,"humidity":71,"dew_point":9.56,"wind_speed":6.63,"wind_deg":332,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.73},{"dt":1591974000,"sunrise":1591959824,"sunset":1591994220,"temp":{"day":14,"min":11.26,"max":16.88,"night":11.26,"eve":13.6,"morn":11.9},"feels_like":{"day":10.55,"night":4.25,"eve":10.62,"morn":8.57},"pressure":1006,"humidity":81,"dew_point":10.81,"wind_speed":5.3,"wind_deg":340,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10d"}],"clouds":98,"rain":0.38,"uvi":1.73},{"dt":1592060400,"sunrise":1592046248,"sunset":1592080619,"temp":{"day":10.69,"min":5.88,"max":10.69,"night":5.88,"eve":7.71,"morn":8.38},"feels_like":{"day":3.45,"night":-1.3,"eve":-0.31,"morn":0.92},"pressure":1017,"humidity":57,"dew_point":2.62,"wind_speed":8.08,"wind_deg":220,"weather":[{"id":501,"main":"Rain","description":"lluvia moderada","icon":"10d"}],"clouds":58,"rain":3.58,"uvi":1.5},{"dt":1592146800,"sunrise":1592132671,"sunset":1592167019,"temp":{"day":8.92,"min":4.91,"max":10.37,"night":6.17,"eve":8.57,"morn":4.94},"feels_like":{"day":4.72,"night":0.23,"eve":4.23,"morn":-1.2},"pressure":1028,"humidity":58,"dew_point":1.15,"wind_speed":3.41,"wind_deg":247,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.76},{"dt":1592233200,"sunrise":1592219093,"sunset":1592253422,"temp":{"day":10.5,"min":5.6,"max":12.75,"night":12,"eve":11.34,"morn":5.6},"feels_like":{"day":2.8,"night":3.73,"eve":2.9,"morn":-1.48},"pressure":1023,"humidity":56,"dew_point":2.27,"wind_speed":8.63,"wind_deg":355,"weather":[{"id":800,"main":"Clear","description":"cielo claro","icon":"01d"}],"clouds":0,"uvi":1.63}]}';
        $data = json_decode($response,true);

        // OWM response to array
        $forecast_array = $data["daily"];
        array_shift($forecast_array); //remove first element (today), only preserve future data
        foreach($forecast_array as $key => $day) {
            $day_array["date"] = OWM_Adapter::formatDate($day["dt"]);
            $day_array["temp"] = round($day["temp"]["day"],1);
            $day_array["icon"] = $day["weather"][0]["icon"];
            $days_array[] = $day_array;
        }
        return $days_array;
    }
    
    /**
     * Get historical weather data for cities via History API from OWM 
     * $city : cityname as stated in <select>
     * $days in history to get data
     */
    public static function getHistorical($city, $days=5){
        $unix_timestamp = time();  //timestamp of current day
        $seconds_in_day = 60*60*24;
        $days_in_history = $days; //query last 5 days
        while($days_in_history > 0){
            $unix_timestamp -= $seconds_in_day; //timestamp of previous day
            $days_array[] = OWM_Adapter::getForDay($city, $unix_timestamp);
            $days_in_history--;                
        }         
        return array_reverse($days_array);
    }

    /**
     * Get historical weather data for one date
     * $city : cityname as stated in <select>
     * $unix_timestamp: of date within 5 days of historical data (86,400 seconds a day)
     */
    private static function getForDay($city, $unix_timestamp){
        $location = OWM_Adapter::GeoCodeSimple($city); //static coordinates
        $prepared_url = OWM_HISTORY_URL."?lat=".$location["lat"]."&lon=".$location["lon"]."&APPID=".OWM_API_KEY."&units=metric&lang=".OWM_LANGUAGE;
        $prepared_url .= "&dt=".$unix_timestamp;
        $response = file_get_contents($prepared_url); 
        //$response = '{"lat":-38,"lon":-57.58,"timezone":"America/Argentina/Buenos_Aires","timezone_offset":-10800,"current":{"dt":1591572058,"sunrise":1591527680,"sunset":1591562250,"temp":13.51,"feels_like":13.78,"pressure":1014,"humidity":100,"dew_point":13.51,"uvi":1.78,"clouds":90,"visibility":300,"wind_speed":1.19,"wind_deg":152,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},"hourly":[{"dt":1591488000,"temp":12.42,"feels_like":10.92,"pressure":1015,"humidity":100,"dew_point":12.42,"clouds":0,"visibility":700,"wind_speed":3.22,"wind_deg":65,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},{"dt":1591491600,"temp":12.78,"feels_like":11.75,"pressure":1014,"humidity":100,"dew_point":12.78,"clouds":19,"visibility":900,"wind_speed":2.71,"wind_deg":61,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},{"dt":1591495200,"temp":12.06,"feels_like":10.26,"pressure":1014,"humidity":100,"dew_point":12.06,"clouds":59,"visibility":2400,"wind_speed":3.48,"wind_deg":60,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50n"}]},{"dt":1591498800,"temp":12.78,"feels_like":12.59,"pressure":1014,"humidity":100,"dew_point":12.78,"clouds":66,"visibility":1600,"wind_speed":1.5,"wind_deg":240,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50n"}]},{"dt":1591502400,"temp":13.42,"feels_like":13.16,"pressure":1014,"humidity":100,"dew_point":13.42,"clouds":90,"visibility":1900,"wind_speed":1.9,"wind_deg":66,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50n"}]},{"dt":1591506000,"temp":13.43,"feels_like":13.54,"pressure":1014,"humidity":100,"dew_point":13.43,"clouds":90,"visibility":1000,"wind_speed":1.38,"wind_deg":60,"weather":[{"id":301,"main":"Drizzle","description":"llovizna","icon":"09n"},{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10n"},{"id":701,"main":"Mist","description":"niebla","icon":"50n"}],"rain":{"1h":0.51}},{"dt":1591509600,"temp":13.65,"feels_like":13.84,"pressure":1014,"humidity":100,"dew_point":13.65,"clouds":90,"visibility":800,"wind_speed":1.36,"wind_deg":60,"weather":[{"id":301,"main":"Drizzle","description":"llovizna","icon":"09n"},{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10n"},{"id":701,"main":"Mist","description":"niebla","icon":"50n"}],"rain":{"1h":0.25}},{"dt":1591513200,"temp":13.92,"feels_like":14.25,"pressure":1014,"humidity":100,"dew_point":13.92,"clouds":90,"visibility":400,"wind_speed":1.29,"wind_deg":68,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10n"},{"id":741,"main":"Fog","description":"bruma","icon":"50n"}],"rain":{"1h":0.38}},{"dt":1591516800,"temp":14.02,"feels_like":14.96,"pressure":1014,"humidity":100,"dew_point":14.02,"clouds":90,"visibility":400,"wind_speed":0.47,"wind_deg":73,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10n"},{"id":741,"main":"Fog","description":"bruma","icon":"50n"}],"rain":{"1h":0.25}},{"dt":1591520400,"temp":14.07,"feels_like":15.18,"pressure":1014,"humidity":100,"dew_point":14.07,"clouds":90,"visibility":550,"wind_speed":0.25,"wind_deg":135,"weather":[{"id":500,"main":"Rain","description":"lluvia ligera","icon":"10n"},{"id":741,"main":"Fog","description":"bruma","icon":"50n"}],"rain":{"1h":0.25}},{"dt":1591524000,"temp":14.07,"feels_like":14.94,"pressure":1014,"humidity":100,"dew_point":14.07,"clouds":100,"visibility":700,"wind_speed":0.6,"wind_deg":109,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},{"dt":1591527600,"temp":14.07,"feels_like":15.08,"pressure":1015,"humidity":100,"dew_point":14.07,"clouds":100,"visibility":200,"wind_speed":0.4,"wind_deg":39,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},{"dt":1591531200,"temp":14.07,"feels_like":14.97,"pressure":1015,"humidity":100,"dew_point":14.07,"clouds":90,"visibility":150,"wind_speed":0.55,"wind_deg":38,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50d"}]},{"dt":1591534800,"temp":15.03,"feels_like":15.96,"pressure":1015,"humidity":100,"dew_point":15.03,"clouds":90,"visibility":1500,"wind_speed":1,"wind_deg":110,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50d"}]},{"dt":1591538400,"temp":15.06,"feels_like":15.65,"pressure":1015,"humidity":100,"dew_point":15.06,"clouds":90,"visibility":7000,"wind_speed":1.5,"wind_deg":290,"weather":[{"id":804,"main":"Clouds","description":"nubes","icon":"04d"}]},{"dt":1591542000,"temp":15.31,"feels_like":15.99,"pressure":1015,"humidity":100,"dew_point":15.31,"clouds":90,"visibility":8000,"wind_speed":1.5,"wind_deg":250,"weather":[{"id":804,"main":"Clouds","description":"nubes","icon":"04d"}]},{"dt":1591545600,"temp":15.47,"feels_like":15.8,"pressure":1014,"humidity":93,"dew_point":14.34,"clouds":75,"visibility":2000,"wind_speed":1.5,"wind_deg":110,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50d"}]},{"dt":1591549200,"temp":15.36,"feels_like":15.65,"pressure":1015,"humidity":93,"dew_point":14.24,"clouds":90,"visibility":5000,"wind_speed":1.5,"wind_deg":140,"weather":[{"id":701,"main":"Mist","description":"niebla","icon":"50d"}]},{"dt":1591552800,"temp":15.51,"feels_like":15.49,"pressure":1014,"humidity":100,"dew_point":15.51,"clouds":90,"visibility":800,"wind_speed":2.6,"wind_deg":140,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50d"}]},{"dt":1591556400,"temp":15.29,"feels_like":15.73,"pressure":1014,"humidity":93,"dew_point":14.17,"clouds":90,"visibility":3000,"wind_speed":1.26,"wind_deg":184,"weather":[{"id":300,"main":"Drizzle","description":"llovizna ligera","icon":"09d"},{"id":701,"main":"Mist","description":"niebla","icon":"50d"}]},{"dt":1591560000,"temp":14.49,"feels_like":15.22,"pressure":1013,"humidity":100,"dew_point":14.49,"clouds":90,"visibility":800,"wind_speed":1,"wind_deg":110,"weather":[{"id":300,"main":"Drizzle","description":"llovizna ligera","icon":"09d"},{"id":741,"main":"Fog","description":"bruma","icon":"50d"}]},{"dt":1591563600,"temp":14.33,"feels_like":15.01,"pressure":1014,"humidity":100,"dew_point":14.33,"clouds":90,"visibility":1500,"wind_speed":1,"wind_deg":180,"weather":[{"id":300,"main":"Drizzle","description":"llovizna ligera","icon":"09n"},{"id":701,"main":"Mist","description":"niebla","icon":"50n"}]},{"dt":1591567200,"temp":14.16,"feels_like":14.43,"pressure":1014,"humidity":100,"dew_point":14.16,"clouds":96,"visibility":600,"wind_speed":1.5,"wind_deg":70,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]},{"dt":1591570800,"temp":13.49,"feels_like":13.75,"pressure":1014,"humidity":100,"dew_point":13.49,"clouds":90,"visibility":300,"wind_speed":1.19,"wind_deg":152,"weather":[{"id":741,"main":"Fog","description":"bruma","icon":"50n"}]}]}';
        $data = json_decode($response,true);

        // OWM response to array
        $forecast_array = $data["hourly"];
        foreach($forecast_array as $key => $day) {
            $day_array["date"] = OWM_Adapter::formatDate($day["dt"]);
            $day_array["temp"] = round($day["temp"],1);
            $day_array["icon"] = $day["weather"][0]["icon"];
        }
        return $day_array;
    }    

    /**
     * One Call API on OWM used lat/lon coordinates instead of City names
     */
    private static function GeoCodeSimple($city){
        return GEOCODE_CITIES[$city];
    }
    /**
     * Used first time to retrieve latitude/longitude 
     * (Obsolethe)
    */
    private static function GeoCode($city){
        $geocode_url = "https://geocode.xyz/";
        $prepared_url = $geocode_url.$city."?json=1&&auth=706002883024838650940x6200";
        $response = file_get_contents($prepared_url);         
        //{"standard" : {"addresst" : {},"city" : "Cuenca Ec", "prov" : "EC","countryname" : "Ecuador","postal" : {},"confidence" : "0.3"   },   "longt" : "-79.01269",   "alt" : {},   "elevation" : {},   "latt" : "-2.89942"}
        $data = json_decode($response,true);
        $longitude = $data["longt"];
        $latitude = $data["latt"];
        return array("lon" => $longitude, "lat" => $latitude);
    }
    /**
     * Dates in spanish language
     */
    private static function formatDate($timestamp){
        $string = date("D d M", $timestamp);
        foreach(DAYS as $english => $spanish){
            $string = str_replace($english, $spanish, $string);
        }
        foreach(MONTHS as $english => $spanish){
            $string = str_replace($english, $spanish, $string);
        }
        return $string;
    }
}
?>