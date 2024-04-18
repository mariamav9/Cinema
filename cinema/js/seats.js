let choosen = [];
let toDelete = [];
let id = getIdOfFilm();
let $_GET = giveGet();//get the id in form: "id=number"
let id_film = $_GET.id;//get the number id of the film
let reserved;

console.log(id_film);

function delete_reservation() {
    let formData = new FormData();
    formData.append('toDelete', JSON.stringify(toDelete))

    if (toDelete.length > 0) {//use to delete the seat that has color green from database
        fetch('./delete_reservation.php', {
            method: 'POST',
            body: formData,
            
        })
            .then((res) => {//is used to deal with asynchronous tasks such as an API call
                location.reload();//reload the document
            })
    }
}

document.getElementById("book").addEventListener("click", () => { // when the element is is clicked do something
    let formData = new FormData(); // create object of FormData type
    formData.append('choosen', JSON.stringify(choosen)) 

    if (choosen.length > 0) {
        fetch('./book.php', { //get data from book.php file
            method: 'POST',
            body: formData
        })
            .then(() => {//is used to deal with asynchronous tasks such as an API call
                location.reload();//reload the document
            })
    }
})

fetch('get_reservations.php') //get data from get_reservations.php file
    .then((response) => {
        return response.json()//takes a response stream and reads it to completion to return a promise which resolves with the result of parsing the body text as JSON.

    }).then((data) => {
        reserved = data;

        fetch('films.php')
            .then((response) => {
                return response.json()
            //reserved has all the reservations
            //choosen has all the seats that you will click, but now its empty
            }).then(() => {
                for (let i = 0; i < 15; i++) { // create the box that displays the seats
                    let row = document.createElement("div"); //create div for row
                    row.classList.add("row"); //add style class to row div

                    let rowNumber = document.createElement("div"); //create div 
                    rowNumber.classList.add("rowNumber"); //add style class 
                    rowNumber.append(i + 1);// number of the row
                    row.appendChild(rowNumber);// display it putting it in the div row

                    for (let z = 0; z < 20; z++) {
                        let isReserved = false;
                        let div = document.createElement("div");
                        div.setAttribute("row", i);
                        div.setAttribute("seat", z);
                        div.className = "seat";//add style class

                        if (reserved) {
                            for (let f = 0; f < reserved.length; f++) {
                                

                                if ((reserved[f].reservation_id == id || id == 1) && id_film == reserved[f].movie_id && i == reserved[f].row && z == reserved[f].seat) {
                                    div.style.backgroundColor = "green";//if the seat is not booked change seat colour to green to book it
                                    break;
                                } else if (reserved[f].reservation_id!= id && id_film == reserved[f].movie_id && i == reserved[f].row && z == reserved[f].seat) {
                                    div.style.backgroundColor = "red";//if the seat is booked change seat colour to red, you cant book it
                                    isReserved = true;
                                    break;
                                } else {
                                    div.style.backgroundColor = "white";// leave it unbooked
                                }
                            }
                        } else {
                            div.style.backgroundColor = "white"; // leave it unbooked
                        }

                        //e.target=get the element where the event occured

                        if (isReserved == false) {
                            div.addEventListener("click", function (e) {//when you click on the div
                                if (e.target.style.backgroundColor == "white") {
                                    e.target.style.backgroundColor = "yellow";//mark selected seat
                                    choosen.push({ //put them to the end of array choosen
                                        reservation_id: id,
                                        row: e.target.getAttribute("row"),
                                        seat: e.target.getAttribute("seat"),
                                        movie_id: id_film
                                    })
                                } else if (e.target.style.backgroundColor == "yellow") {
                                    e.target.style.backgroundColor = "white"//unmark selected seat
                                    for (let i = 0; i < choosen.length; i++) {
                                        if (choosen[i].row == e.target.getAttribute("row") && choosen[i].seat == e.target.getAttribute("seat")) {
                                            choosen.splice(i, 1);//remove one element of the array that has the index of i
                                        }
                                    }
                                } else if (e.target.style.backgroundColor == "green") {
                                    toDelete.push({ //put them to the end of array toDelete
                                        reservation_id: id,
                                        row: e.target.getAttribute("row"),
                                        seat: e.target.getAttribute("seat"),
                                        movie_id : id_film
                                    })
                                    delete_reservation();
                                }
                            })
                        }
                        row.appendChild(div);// put div to the row div
                    }

                    let rightFill = document.createElement("div");
                    rightFill.classList.add("rowNumber");
                    row.appendChild(rightFill);

                    document.getElementById("seats").appendChild(row);// display everything that row has inside by inserting it to seats div
                }
            })
    })