<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="../style/style.css">
   
</head>

<body>
    <header>
        <?php
        //check if the logged user is admin and then show the admin panel
            session_start();
            if ($_SESSION["admin"] == 1) {
                echo '<a href="../adminpanel.php" class="adminpanel">ADMIN PANEL</a>';
            }
        ?>
        <a href="../index.php">PointOfView</a>  <!--the title of the site is also a link to go in the movies page-->
        <a href="../logout.php" class="logout">Log out</a>   <!--when the user is logged in this link appear to end the session and log him out-->
    </header>

    <main>
        <h3>Delete reservations</h3>

        <div class="deletereservation">
            <form method="POST">
                <label for="selectreservation">Select reservation:</label>
                <select name="selectreservation" id="selectreservation">
                <?php
                    include "../database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
                    //get all data from the reservation table
                    $sql = "SELECT * FROM `reservation`";
                    $res = $conn->query($sql);
                    
                    //store the data in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    
                    //show all the data
                    for ($i = 0; $i < count($response); $i++) {
                        $reservation_value = $response[$i]['reservation_id']."|".$response[$i]['row']."|".$response[$i]['seat']."|".$response[$i]['movie_id'];
                        $reservation_text = $response[$i]['reservation_id']." | ".$response[$i]['row']." | ".$response[$i]['seat']." | ".$response[$i]['movie_id'];
                        echo '<option value="'.$reservation_value.'">'.$reservation_text.'</option>';
                    }
                    $conn->close();           
                ?>
                </select>

                <input type="submit" value="Delete reservation"></input>
            </form>
            OR
            <a href="delete_all_reservations.php?all=true">Delete all reservations</a>

            <?php
            //check if reservation was successfully deleted
                if (isset($_SESSION["deleted"])) {
                    if ($_SESSION["deleted"]) {
                        echo "Reservation deleted";
                    } else {
                        echo "There was an error";
                    }
                    unset($_SESSION["deleted"]);
                }
            ?>

            <?php
                //if delete all reservations was selected
                if (isset($_GET['all'])) {
                    include "./database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');

                    //delete all reservations 
                    $sql = "DELETE FROM `reservation`";
                    $res = $conn->query($sql);
                    
                    //check if all reservations was successfully deleted
                    if ($res==null){
                        $_SESSION["deleted"] = false;
                        header("Location: delete_all_reservations.php");
                    } else {
                        $_SESSION["deleted"] = true;
                        header("Location: delete_all_reservations.php");
                    }
                    $conn->close();
                }
            ?>

            <?php
                include "../database/DatabaseData.php";
                
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                
                //check if a reservation was selected
                if (isset($_POST['selectreservation'])) {
                    $reservation = $_POST['selectreservation'];
                    $reservation = explode("|", $reservation);
                    
                    //delete the selected reservation from the table
                    $sql = "DELETE FROM `reservation` WHERE `reservation_id` = $reservation[0] AND `row` = $reservation[1] AND `seat` = $reservation[2] AND `movie_id` = $reservation[3]";
                    $res = $conn->query($sql);
                    
                    //check if selected reservation was successfully deleted
                    if ($res==null){
                        $_SESSION["deleted"] = false;
                        header("Location: delete_all_reservations.php");
                    } else {
                        $_SESSION["deleted"] = true;
                        header("Location: delete_all_reservations.php");
                    }
                    $conn->close();
                }
            ?>
        </div>
    </main>

    <?php
        //check if user is logged in
        if (!isset($_SESSION["username"])) {
            header("Location: login_check.php");
            $_SESSION["logged"] = false;
            exit();
        } else {
            if ($_SESSION["admin"] != "1") {
                header("Location: index.php");
                exit();
            } else {
                $_SESSION["logged"] = true;
            }
        }
    ?>
</body>

</html>