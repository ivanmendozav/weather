//Get current weather
function loadCurrentWeather() {
    let city = $("#city").val();
    let url = 'owm.proxy.php?city=' + city;
    $.getJSON(url, function(data) {
        $(".today .temp").html(data.temp+"°");
        $(".today .temp_min").html("min:"+data.temp_min + "°");
        $(".today .temp_max").html("max"+data.temp_max + "°");
        $(".today .humidity").html("humedad:"+data.humidity+"%");
        $(".today .date").html(data.date);
        /* check icons in https://openweathermap.org/weather-conditions */
        $(".today > ul").css('background-image','url(http://openweathermap.org/img/wn/'+data.icon+'@2x.png)');
        $(".today .description").html(data.description);
        $(".today .city").html(city);
    });
}
//Get forecast of 7 days
function loadForecast() {
    let url = 'owm.proxy.php?type=forecast&city=' + $("#city").val();
    $.getJSON(url, function(data) {
        let x;
        let index = 1;
        for (x of data) {
            $(".forecast-" + index + " .temp").html(x.temp);
            $(".forecast-" + index + " div.forecast").addClass(x.icon);
            $(".forecast-" + index + " .date").html(x.date);
            index++;
        }
    });
}
//Get history of the 5 previous days
function loadHistorical() {
    let url = 'owm.proxy.php?type=history&city=' + $("#city").val();
    $.getJSON(url, function(data) {
        let x;
        let index = 1;
        for (x of data) {
            $(".history-" + index + " .temp").html(x.temp + "°");
            /* check icons in https://openweathermap.org/weather-conditions */
            $(".history-" + index + " div.history").addClass(x.icon );
            $(".history-" + index + " .date").html(x.date);
            index++;
        }
    });
}
//Note: if decide to make one single call for: Getting forecast of 7 days & Getting history of the 5 previous days
function loadDays() {
    $(".forecast .temp,.history .temp").html("<span class='loading'>loading..</span>");
    let url = 'owm.proxy.php?type=days&city=' + $("#city").val();
    let previous_days = 5;
    $.getJSON(url, function(data) {
        let x;
        let index = 1;
        for (x of data) {            
            if(index > previous_days){
                let forecast_index = index - previous_days;
                $(".forecast-" + forecast_index + " .temp").html(x.temp + "°");
                $(".forecast-" + forecast_index + " div.forecast").css('background-image','url(http://openweathermap.org/img/wn/'+x.icon+'@2x.png)');
                $(".forecast-" + forecast_index + " .date").html(x.date);                
            }else{
                $(".history-" + index + " .temp").html(x.temp + "°");
                /* check icons in https://openweathermap.org/weather-conditions */
                $(".history-" + index + " div.history").css('background-image','url(http://openweathermap.org/img/wn/'+x.icon+'@2x.png)');
                $(".history-" + index + " .date").html(x.date);
            }
            index++;
        }
    });
}

//Call all requests
function loadReports() {
    loadCurrentWeather();
    loadDays();
}
