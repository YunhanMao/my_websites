
	//set up initial city
	const BJ = {
		city: "Beijing",
		state: "Beijing",
		country:"CN"
	};

	if (localStorage.storedInfo) { //if we have stored the info before
		//then we parse it back and load it
		$("#city-list").val(JSON.parse(localStorage.storedInfo).city);
		GetWeather(JSON.parse(localStorage.storedInfo));
	} 
	else {
		GetWeather(BJ);
	}


function GetWeather(inputInfo) {
	$.ajax({
		method: "GET",
		url: "https://api.weatherbit.io/v2.0/current",
		data: {
			city: inputInfo.city,
			state: inputInfo.state,
			country: inputInfo.country,
			units: "I",
			key: "7df9cc0705014d938adda00baa5efd6d"
		}
	})
	.done(function(results){
		$("#temp").text(results.data[0].temp); 
        $("#description").text(results.data[0].weather.description);
        $("#app-temp").text(results.data[0].app_temp);
		// console.log(results.data[0].temp);
		// console.log(results.data[0]);
	})
	.fail(function() {
		alert("error in fetching temp info! Please check your internet connection!");
	});
}


//set toggle weather function
$("#city-list").change(function(){
	const newOption = {
        city: $("#city-list").val(),
        state: $("#city-list").data("state"),
        country: $("city-list").data("country"),
    };
    GetWeather(newOption);
	//save as a string
	localStorage.setItem("storedInfo", JSON.stringify(newOption));
});


$("#plus").on("click", function(){
	$("#form").slideToggle("normal");
});

$("#to-do-items").on("click", ".square", function(){
	$(this).parent().fadeOut("normal", function(){
		$(this).remove();
	});
});

$("#to-do-items").on("click", ".input-text", function(){
	if ($(this).css("color")=="rgb(0, 0, 0)"){ //if black, then we change it.
		$(this).css("color", "gray");
		$(this).css("text-decoration", "line-through");
	} 
	else{
		$(this).css("color", "black");
		$(this).css("text-decoration", "none");
	}
});

$("#form").on("submit", function(event){
	event.preventDefault();
	$("#to-do-items").append("<li><span class='square'><i class='far fa-square'></i></span> <span class='input-text'>" + $("#input-box").val().trim() + "</span></li>");
	$("#input-box").val(""); //clears out the inputbox after each input
});







