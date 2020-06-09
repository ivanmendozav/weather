//Get current weather
function loadCurrentWeather() {
    let url = 'services.php?city=' + $("#city").val();
    $.getJSON(url, function(data) {
        $(".today .temp").html(data.temp);
        $(".today .temp_min").html(data.temp_min);
        $(".today .temp_max").html(data.temp_max);
        $(".today .humidity").html(data.humidity);
        $(".today .icon").html(data.icon + ".png");
        $(".today .description").html(data.description);
    });
}
//Get forecast of 7 days
function loadForecast() {
    let url = 'services.php?type=forecast&city=' + $("#city").val();
    $.getJSON(url, function(data) {
        let x;
        let index = 1;
        for (x of data) {
            $(".forecast-" + index + " .temp").html(x.temp);
            $(".forecast-" + index + " .icon").html(x.icon + ".png");
            $(".forecast-" + index + " .date").html(x.date);
            index++;
        }
    });
}
//Get history of the 5 previous days
function loadHistorical() {
    let url = 'services.php?type=history&city=' + $("#city").val();
    $.getJSON(url, function(data) {
        let x;
        let index = 1;
        for (x of data) {
            $(".history-" + index + " .temp").html(x.temp + "°");
            $(".history-" + index + " .icon").html(x.icon + ".png");
            $(".history-" + index + " .date").html(x.date);
            index++;
        }
    });
}
//Call all requests
function loadReports() {
    loadCurrentWeather();
    loadForecast();
    loadHistorical();
}
//on page loading
$(document).ready(function() {
    loadReports();
});