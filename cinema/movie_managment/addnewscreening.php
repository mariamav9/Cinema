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
    <div class="top-panel">
        <?php
        //check if the logged user is admin and then show the admin panel
            session_start();
            if ($_SESSION["admin"] == 1) {
                echo '<a href="../adminpanel.php" class="adminpanel">ADMIN PANEL</a>';
            }
        ?>
        <a href="../index.php">PointOfView</a>  <!--the title of the site is also a link to go in the movies page-->
        <a href="../logout.php" class="logout">Log out</a>   <!--when the user is logged in this link appear to end the session and log him out-->
    </div>
    <div class="bottom-panel">
        
        <h3>Add new Screeing Date</h3>
        <div class="addnewscreening">
            <form method="POST">
                <label for="selectfilm">Select film:</label>
                <select name="selectfilm" id="selectfilm">
                <?php
                    include "../database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
                    //get the titles of the movies in the database 
                    $sql = "SELECT title FROM `movie`";
                    $res = $conn->query($sql);
                    
                    //store the titles in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    var_dump($response); 
                    
                    //show the titles
                    for ($i = 0; $i < count($response); $i++) {
                        $film = $response[$i]['title'];
                        echo '<option value="'.$film.'">'.$film.'</option>';
                    }
                    $conn->close();           
                ?>
                </select>
                
                <label for="choosedate">Choose date:</label>
                <input type="date" name="choosedate" id="choosedate"></input>
                <label for="choosetime">Choose time:</label>
                <input type="time" name="choosetime" id="choosetime"></input>

                <input type="submit" value="Add"></input>
            </form>

            <?php
                include "../database/DatabaseData.php";
                
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                
                //check if all fields are filled
                if (isset($_POST['choosedate'], $_POST['choosetime'], $_POST['selectfilm'])) {
                    
                    //get the id of the movie that user choose
                    $sql = "SELECT movie_id FROM `movie` WHERE title = '".$_POST['selectfilm']."'";
                    $res = $conn->query($sql);
                    
                   //store the data in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    
                    $id_film = $response[0]['movie_id'];  //extract the movie_id value from the first row in the array
                    $date = $_POST['choosedate'];
                    $time = $_POST['choosetime'];
                    $film = $_POST['selectfilm'];
                    
                    //insert the data in the database
                    $sql = "INSERT INTO screening (`screening_id`, `movie_id`, `date`, `hour`) VALUES ('0','$id_film','$date','$time:00')";
                    $res = $conn->query($sql);
                    
                    //check if the data inserted successfully
                    if ($res==null){
                        header("Location: addnewscreening.php");
                    } else {
                        echo "Screening added";
                    }
                    $conn->close();
                } else {
                    echo "Fill all fields";
                }
            ?>


        </div>
    </div>
    
    <?php
        //check if user is logged in
        if (!isset($_SESSION["username"])) {
            header("Location: login_check.php");
            $_SESSION["logged"] = false;
            exit();
        } else {
            if ($_SESSION["admin"] != 1) {
                header("Location: index.php");
                exit();
            } else {
                $_SESSION["logged"] = true;
            }
        }
    ?>
</body>

</html>