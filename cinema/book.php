<?php

    session_start();

    include "./database/DatabaseData.php";//connection to database
    $conn = new mysqli($servername, $username, $password, $database);//make the connaction

    if ($conn->connect_errno) die('Error MySQL');
    $ran = json_decode($_POST['choosen']);//give the values of choosen in array using json

    for ($i = 0; $i < sizeof($ran); $i++) {
        $reservation_id = $ran[$i]->{'reservation_id'};//insert values in variables
        $row = $ran[$i]->{'row'};
        $seat = $ran[$i]->{'seat'};
        $movie_id = $ran[$i]->{'movie_id'};//insert variables in database
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO reservation (`reservation_id`, `row`, `seat`, `movie_id`,`user_id`) VALUES ('$reservation_id', '$row', '$seat','$movie_id','$user_id')";
        $result = $conn->query($sql);
    }
    $conn->close();//close conneection
?>