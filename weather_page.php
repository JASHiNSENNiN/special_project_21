<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Weather Update | DRDSNHS</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="css/weather_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <video autoplay muted loop id="myVideo">
        <source src="img/bg-weather.mp4" type="video/mp4">
    </video>
    <h1>Weather Update</h1>
    <div class="container">
        <!--       <div class="weather-input">
        <h3>Enter a City Name</h3>
        <input class="city-input" type="text" placeholder="E.g., New York, London, Tokyo">
        <button class="search-btn">Search</button>
        <div class="separator"></div>
        <button class="location-btn">Use Current Location</button>
      </div> -->
        <div class="weather-data">

            <div class="current-weather">
                <iframe width="100%" height="450" src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=default&metricTemp=default&metricWind=default&zoom=5&overlay=wind&product=ecmwf&level=surface&lat=11.824&lon=120.762&detailLat=15.662&detailLon=120.766&detail=true&pressure=true" frameborder="0"></iframe>
            </div>
            <div class="days-forecast">
                <!-- <h2>5-Day Forecast</h2>
                <ul class="weather-cards">
                    <li class="card">
                        <h3>( ______ )</h3>
                        <h6>Temp: __C</h6>
                        <h6>Wind: __ M/S</h6>
                        <h6>Humidity: __%</h6>
                    </li>
                    <li class="card">
                        <h3>( ______ )</h3>
                        <h6>Temp: __C</h6>
                        <h6>Wind: __ M/S</h6>
                        <h6>Humidity: __%</h6>
                    </li>
                    <li class="card">
                        <h3>( ______ )</h3>
                        <h6>Temp: __C</h6>
                        <h6>Wind: __ M/S</h6>
                        <h6>Humidity: __%</h6>
                    </li>
                    <li class="card">
                        <h3>( ______ )</h3>
                        <h6>Temp: __C</h6>
                        <h6>Wind: __ M/S</h6>
                        <h6>Humidity: __%</h6>
                    </li>
                    <li class="card">
                        <h3>( ______ )</h3>
                        <h6>Temp: __C</h6>
                        <h6>Wind: __ M/S</h6>
                        <h6>Humidity: __%</h6>
                    </li>
                </ul> -->
            </div>
        </div>
    </div>

</body>

</html>