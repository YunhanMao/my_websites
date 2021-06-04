function GetWeather() {
    $.ajax({
        method: "GET",
        url: "https://api.weatherbit.io/v2.0/current",
        data:
            {
            key: "7df9cc0705014d938adda00baa5efd6d",
            lang: "en",
            units: "I",
            country: "US",
            state: "California" ,         
            city: "Los Angeles"
        }
    })
        .done(function (results)
        {
            $("#temp").text(results.data[0].temp); 
            $("#description").text(results.data[0].weather.description);
            $("#app-temp").text(results.data[0].app_temp);
        })
}

GetWeather();
