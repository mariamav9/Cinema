<?php
    include "./database/DatabaseData.php";//connection to database
    $conn = new mysqli($servername, $username, $password, $database);//make the connection
    if ($conn->connect_errno) die('Error MySQL');

    $sql = "SELECT * FROM `movie`";//take all the fields from array movie
    $res = $conn->query($sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $json[] = [//put the values in json forman and then in json string
            "movie_id" => $row["movie_id"],
            "title" => $row["title"],
            "director" => $row["director"],
            "duration" => $row["duration"],
            "production_date" => $row["production_date"],
            "image" => $row["image"]
        ];
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;

    $conn->close();//close the connection
?>