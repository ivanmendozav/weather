<?php
/**
 * Author: IMendoza
 * Date: 8/06/2020
 * Description: Proxy to manage AJAX requests
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
            $data = OWM_Adapter::getForecast($city);
        }elseif($_GET["type"]=="history"){   //get historical 5 days data
            $data = OWM_Adapter::getHistorical($city, 5);               
        }elseif($_GET["type"]=="days"){   //get together: forecast 7 next days & get historical 5 days data
            $data = OWM_Adapter::getDays($city);               
        }
    }else{
        $data = OWM_Adapter::getCurrent($city);  //get current weather
    }

    echo json_encode($data); //enconde as JSON and send to response
?>
