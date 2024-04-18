<?php
    include "./database/DatabaseData.php";//connection to database
    $conn = new mysqli($servername, $username, $password, $database);//make the connection
    if ($conn->connect_errno) die('Error MySQL');


    $sql = "SELECT * FROM `reservation`"; // take all fields from array reservation
    $res = $conn->query($sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $json[] = [//insert values sof reservation in jason format
            "reservation_id" => $row["reservation_id"],
            "row" => $row["row"],
            "seat" => $row["seat"],
            "movie_id" => $row["movie_id"],
        ];
    }

    $jsonstring = json_encode($json);//put them in jsonstring
    echo $jsonstring;

    $conn->close();
?>