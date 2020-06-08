<?php
/**
 * Author: IMendoza
 * Date: 8/06/2020
 */
    require_once("config.php");    
    require_once("owm.class.php");  

    //Sanitize and parse incoming string
    if(isset($_GET["city"])){
           $city = $_GET["city"];
    }else{
        $city = "Mar del Plata,AR"; 
    }

    if(isset($_GET["type"])){
        if($_GET["type"]=="forecast"){    //forecast 7 next days
            echo OWM_Adapter::getForecast($city);
        }elseif($_GET["type"]=="history"){   //get historical 5 days data

        }
    }else{
        echo OWM_Adapter::getCurrent($city);  //get current weather
    }
?>
