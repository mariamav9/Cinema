<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="../style/style.css">
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
            //check if user is admin and then show admin panel
            session_start();
            if ($_SESSION["admin"] == 1) {
                echo '<a href="../adminpanel.php" class="adminpanel">ADMIN PANEL</a>';
            }
        ?>
        <a href="../index.php">PointOfView</a>  <!--the title of the site is also a link to go in the movies page-->
        <a href="../logout.php" class="logout">Log out</a>   <!--when the user is logged in this link appear to end the session and log him out-->
    </div>
    <div class="bottom-panel">
        <h3>Users List</h3>

        <div class="viewusers">
            <form method="GET">

    
    <?php
        include "../database/DatabaseData.php";
        //create new connection
        $conn = new mysqli($servername, $username, $password, $database);
        //check connection
        if ($conn->connect_errno) die('Error MySQL');
        
        //get data from the table users
        $sql = "SELECT user_id,username,email,name,lastname,counrty,city,address,admin,verified FROM `user`";
        $res = $conn->query($sql);
        
        //store the data in an array
        $response = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $response[] = $row;
        }
        
        //display user info as a table
        echo '<table>';
        
        //print the header row of the table 
        echo '<tr><th>User id</th><th>Username</th><th>Email</th><th>Name</th><th>Lastname</th><th>Country</th><th>City</th><th>Address</th><th>Admin</th><th>Verified</th></tr>';
        
        //loop through the $response array and print each user's information in a new table row
        foreach ($response as $user) {
            echo '<tr>';
            echo '<td>' . $user['user_id'] . '</td>';
            echo '<td>' . $user['username'] . '</td>';
            echo '<td>' . $user['email'] . '</td>';
            echo '<td>' . $user['name'] . '</td>';
            echo '<td>' . $user['lastname'] . '</td>';
            echo '<td>' . $user['counrty'] . '</td>';
            echo '<td>' . $user['city'] . '</td>';
            echo '<td>' . $user['address'] . '</td>';
            echo '<td>' . $user['admin'] . '</td>';
            echo '<td>' . $user['verified'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
            
    ?>  