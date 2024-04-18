let seanse;
fetch('times.php') // take data from file
    .then(function (response) {
        return response.json()
    }).then(function (data) {
        seanse = data;

        fetch('films.php') // take data from file
            .then(function (response) {
                return response.json()
            }).then(function (data) {
// data has the movie info from database
// seanse has the screeing info from database
                for (let i = 0; i < data.length; i++) {
                    // div creation to put content
                    let divWithFilm = document.createElement("div");
                    let img = document.createElement("img"); //img element creation
                    let divForTimes = document.createElement("div");
                    let divDirect=document.createElement("div");
                    let divDuration=document.createElement("div")
                    let divProduction=document.createElement("div");

                    
                    divForTimes.classList.add("divForTimes");//add style class to div that contains screening date

                   
                    
                    img.classList.add("film-img");//add style class to img 
                    img.src = "./img/films/" + data[i].image;//add attribute src the image file name                    ;
                    //add content to div for films using data
                    divWithFilm.innerHTML = "<p>" + data[i].title + "</p>";
                    divDirect.innerHTML = "<p>Director: " + data[i].director + "</p>";
                    divDuration.innerHTML = "<p>Duration: " + data[i].duration + "</p>";
                    divProduction.innerHTML = "<p>Production Date: " + data[i].production_date + "</p>";
                    
                    divWithFilm.appendChild(img);//add image to film div

                    for (let z = 0; z < seanse.length; z++) {
                        if (seanse[z].movie_id == data[i].movie_id) { // check the right movie to put the link for the booking
                            let a = document.createElement("a");//create link element

                            a.innerHTML = "<span>" + seanse[z].hour + "</span><span>" + seanse[z].date + "</span>";//add content to link
                            a.href = "seats.php?id=" + seanse[z].screening_id;//add the right id to link for the seats.js
                            
                            divForTimes.appendChild(a);//add date to div
                        }
                    }

                    divWithFilm.classList.add("film");
                    //add all elements to film div
                    divWithFilm.appendChild(divForTimes);
                    divWithFilm.appendChild(divDirect);
                    divWithFilm.appendChild(divDuration);
                    divWithFilm.appendChild(divProduction);
                    //add film div to the div in index.php for display
                    document.getElementById("films").appendChild(divWithFilm);
                }
                
                
                
                    document.getElementById("searchbar").addEventListener("keypress",function(e) {
                    if (e.key === 'Enter') {//when you press enter 
                        let input = document.getElementById('searchbar').value//take whatever is in the searchbar
                        input=input.toLowerCase();//make it lowcase

                        for (t = 0; t < data.length; t++) {   
                            if (data[t].title.toLowerCase().includes(input)) {//if the title has any part of the iput 
                                document.getElementById("films").children[t].style.display="block";//show it
                            }
                            else{
                                document.getElementById("films").children[t].style.display="none";//hide it    
                         }
                        }
                      }
                    

                })

            })
    })