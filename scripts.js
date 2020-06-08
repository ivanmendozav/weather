function loadWeather() {
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

$(document).ready(function() {
    loadWeather();
});