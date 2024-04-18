<?php
    include "../database/DatabaseData.php";
    
    //create new connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    //check connection
    if ($conn->connect_errno) die('Error MySQL');
    
    //decode the JSON string received in the 'toDelete' parameter 
    $ran = json_decode($_POST['toDelete']);

    //loop through each object in the decoded JSON arra
    for ($i = 0; $i < sizeof($ran); $i++) {
        $id = $ran[$i]->{'reservation_id'};
        $row = $ran[$i]->{'row'};
        $seat = $ran[$i]->{'seat'};
        $id_film = $ran[$i]->{'movie_id'};
        
        //delete the reservation based on the reservation_id, row, seat and movie_id
        if ($id == 1) {
            $sql = "DELETE FROM reservation WHERE row=$row AND seat=$seat AND movie_id=$id_film;";
        } else {
            $sql = "DELETE FROM reservation WHERE reservation_id=$id AND row=$row AND seat=$seat AND movie_id=$id_film;";
        }
        $result = $conn->query($sql);
    }
    $conn->close();
?>