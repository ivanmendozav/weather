<?php
    define("OWM_URL", "http://api.openweathermap.org/data/2.5/weather");
    define("OWM_FORECAST_URL", "http://api.openweathermap.org/data/2.5/onecall");
    define("OWM_HISTORY_URL", "http://api.openweathermap.org/data/2.5/onecall/timemachine");   
    define("OWM_API_KEY", "20344198a7062242c147c3de4fa967ad");
    define("OWM_LANGUAGE", "es");
    define("GEOCODE_CITIES", array(
        "Cuenca,EC" => array("lat" => -2.89942, "lon" => -79.01269),        
        "Buenos Aires,AR" => array("lat" => -34.60988, "lon" => -58.45221),        
        "Mar del Plata,AR" => array("lat" => -38.00443 , "lon" => -57.57773),        
        "Guayaquil,EC" => array("lat" => -2.17489 , "lon" => -79.91608),        
        "Lovaina,BE" => array("lat" =>  50.88289 , "lon" => 4.70972),
        "Caracas,VE" => array("lat" =>  10.48505 , "lon" => -66.88310),
        "Miami,US" => array("lat" =>   25.77427 , "lon" => -80.19366),
        "Mendoza,AR" => array("lat" =>   -32.88097 , "lon" => -68.89916),
        "Santiago,CL" => array("lat" =>   -33.46238 , "lon" => -70.64911),
        "New York City,US" => array("lat" =>   40.68908 , "lon" => -73.95860)
        )
    );    
    define("DAYS", array(
        "Mon" => "Lun",        
        "Tue" => "Mar",        
        "Wed" => "Mie",        
        "Thu" => "Jue",        
        "Fri" => "Vie",
        "Sat" => "Sab",
        "Sun" => "Dom",
        )
    );   
    define("MONTHS", array(
        "Jan" => "Ene",        
        "Feb" => "Feb",        
        "Mar" => "Mar",        
        "Apr" => "Abr",        
        "May" => "May",
        "Jun" => "Jun",
        "Jul" => "Jul",
        "Aug" => "Ago",
        "Sep" => "Sep",
        "Oct" => "Oct",
        "Nov" => "Nov",
        "Dec" => "Dic",
        )
    );   
?>