<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        table{
            color:aliceblue;
            border:3px solid aliceblue;
            text-align:center;
            font-size:20px;
        }
        th{
            border:2px solid aliceblue;
            padding:0px 10px 5px;

        }
        td{
            border:2px solid aliceblue;
            padding:0px 10px 0px;

        }
    </style>
</head>

<body>
<div class="top-panel">
        <?php
            session_start();
            if ($_SESSION["admin"] == 1) {
                echo '<a href="adminpanel.php" class="adminpanel">ADMIN PANEL</a>';
            }
        ?>
        <a href="index.php">PointOfView</a>
        <a href="logout.php" class="logout">Log out</a>
    </div>
    <div class="bottom-panel">
        <h3>All My Reservations</h3>

        <div class="viewusers">
            <form method="GET">

    

    
    <?php
    
        include "./database/DatabaseData.php";
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_errno) die('Error MySQL');

        $sql = "SELECT m.title,r.row,seat,r.user_id,s.date,s.hour FROM reservation r, screening s, movie m where r.movie_id=screening_id and s.movie_id=m.movie_id";
        $res = $conn->query($sql);
        $response = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $response[] = $row;
     }   


echo '<table>';
echo '<tr><th>Film</th><th>Row</th><th>Seat</th><th>Date</th><th>Hour</th>';
foreach ($response as $reservation) {
   if ($reservation['user_id'] == $_SESSION['user_id']){
        echo '<tr>';
        echo '<td>' . $reservation['title'] . '</td>';
        echo '<td>' . $reservation['row'] . '</td>';
        echo '<td>' . $reservation['seat'] . '</td>';
        echo '<td>' . $reservation['date'] . '</td>';
        echo '<td>' . $reservation['hour'] . '</td>';
        echo '</tr>';
   } 
}
echo '</table>';
echo '<a href="index.php" class="goB">Go back</a>'   ;       
        ?>  

   </div>