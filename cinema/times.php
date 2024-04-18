<?php
    include "./database/DatabaseData.php";//connect to database
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_errno) die('Error MySQL');


    $sql = "SELECT * FROM `screening`";//take all fields of array screeing from database
    $res = $conn->query($sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {//set the data in json format in json string
        $json[] = [
            "screening_id" => $row["screening_id"],
            "movie_id" => $row["movie_id"],
            "date" => $row["date"],
            "hour" => $row["hour"],
        ];
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;

    $conn->close();
?>