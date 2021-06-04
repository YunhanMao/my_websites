//create a seperate function named ajax() that will make a request to the api

function ajax(endpoint, returnFunction) {
	let req = new XMLHttpRequest;
	req.open("GET", endpoint);
	req.send();
	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			if (req.status == 200) {
				returnFunction(req.responseText);
			} else {
				console.log(req.status);
			}
		}
	}
}

//first display the now playing movies
let endpoint = "https://api.themoviedb.org/3/movie/now_playing?api_key=7709dcc0f718689adea942370b3732a2&page=1";
ajax(endpoint, display);

document.querySelector("#search-form").onsubmit = function(event) {
	event.preventDefault();
	let parameter = document.querySelector("#search-id").value.trim();
	let endpoint = "https://api.themoviedb.org/3/search/movie?api_key=7709dcc0f718689adea942370b3732a2&query=" + parameter + "&page=1";
	ajax(endpoint, display);
}


function display(results) {
	let movies = document.querySelector("#movie-section");
	while (movies.hasChildNodes()) {
		movies.removeChild(movies.lastChild);
	}
	let resultlist = JSON.parse(results);
	let numResults = resultlist.results.length;
	let totalResults = resultlist.total_results;
	document.querySelector("#total-cnt").innerHTML = totalResults;
	document.querySelector("#result-cnt").innerHTML = numResults;


	//no result case
	if (totalResults == 0) {
		alert("No result!!! What the HECK you just entered!! Please get serious and enter a new one!!")
	} 

	// if result is not zero
	else {
		for (let i = 0; i < numResults; i++) {
			//make sure to use createElement
			let div1 = document.createElement("div");
			div1.classList.add("col-6");
			div1.classList.add("col-md-4");
			div1.classList.add("col-lg-3");
			div1.classList.add("my-2");

		//put everything under div1 and div1 is son of one div and ancestor for divs below
			document.querySelector("#movie-section").appendChild(div1);
		

			let div2 = document.createElement("div");
			div2.classList.add("card");
			div2.classList.add("border-white");
			div2.style.width = "200px";
			div1.appendChild(div2);


			let imgHandler = document.createElement("img");
			imgHandler.classList.add("card-img-top");
			let imgSrc = resultlist.results[i].poster_path;

			if (imgSrc != null) {
				imgHandler.src = "http://image.tmdb.org/t/p/w185" + imgSrc;
				imgHandler.alt = resultlist.results[i].title;
			}
			 else {
				imgHandler.src = "notfound.png";
				imgHandler.alt = resultlist.results[i].title;
			}


			let div3 = document.createElement("div");
			div3.classList.add("img-container");
			div2.appendChild(div3);

			div3.appendChild(imgHandler);

			//make the cover div for the hover effects
			let cover = document.createElement("div");
			cover.classList.add("cover");
			div3.appendChild(cover);

			//display voters
			let voters = document.createElement("p");
			voters.classList.add("movie-info");
			voters.innerHTML = "VoterCount: " + resultlist.results[i].vote_count;
			cover.appendChild(voters);

			//display ratings
			let rating = document.createElement("p");
			rating.classList.add("movie-info");
			rating.innerHTML = "Rating: " + resultlist.results[i].vote_average;
			cover.appendChild(rating);
		

			//content section
			let synopsis= document.createElement("p");
			let content = resultlist.results[i].overview;
			//if the movie's synopsis is over 200 chars, append ... at the end

			if (content.length > 200) {
				content = content.substring(0, 200); // get the first 200 chars
				content += "...";
			}
			
			synopsis.classList.add("movie-info");
			synopsis.innerHTML = content;
			cover.appendChild(synopsis);


			//title and date section for a movie

			let movieinfo = document.createElement("div");
			movieinfo.classList.add("card-body");
			div2.appendChild(movieinfo);

			//we can take advantage of the card design from bootstrap, which will let us put text under
			let movieTitle = document.createElement("p");
			movieTitle.classList.add("card-text");
			movieTitle.classList.add("text-center");
			movieTitle.innerHTML = resultlist.results[i].title;
			movieinfo.appendChild(movieTitle);

			let releaseDate = document.createElement("p");
			releaseDate.classList.add("card-text");
			releaseDate.classList.add("text-center");
			releaseDate.innerHTML = resultlist.results[i].release_date;
			movieinfo.appendChild(releaseDate);
		}
	}
}



