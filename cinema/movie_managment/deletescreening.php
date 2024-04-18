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
        <h3>Delete Screening Date</h3>

        <div class="deletescreening">
            <form method="POST" action="deletescreening.php">
            <?php
                //if admin wants to change the selected movie unset the session of the selected movie
                if (isset($_GET['other'])) {
                    unset($_SESSION['isfilmselected']);
                    unset($_SESSION['film']);
                }
                //check if admin selected a movie
                if (!isset($_SESSION['isfilmselected'])) {
                    $_SESSION['isfilmselected'] = false;
                } 
                //check if admin selected a movie
                if (isset($_POST['selectfilm'])) {
                    $_SESSION['isfilmselected'] = true;
                }
                
                //if admin hasn't selected a movie
                if ($_SESSION['isfilmselected'] == false) {
                    include "../database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');

                    echo '<label for="selectfilm">Select movie:</label>';
                    echo '<select name="selectfilm" id="selectfilm">';
                    
                    //get the title of every movie
                    $sql = "SELECT title FROM `movie`";
                    $res = $conn->query($sql);
                    
                    //store the titles in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    //show the titles
                    var_dump($response);  
                    for ($i = 0; $i < count($response); $i++) {
                        $film = $response[$i]['title'];
                        echo '<option value="'.$film.'">'.$film.'</option>';
                    }
                    $conn->close();  
                    
                    echo "</select>";
                }
            ?>
            <?php
             //if admin selected a movie
                if ($_SESSION['isfilmselected'] == true) {  
                    echo $_POST['selectfilm'];
                    if (!isset($_SESSION['film'])) {
                        $_SESSION['film'] = $_POST['selectfilm'];
                    }

                    include "../database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');

                    echo '<label for="selectscreening">Select date:</label>';
                    echo '<select name="selectscreening" id="selectscreening">';
                    
                    //get the data of the screening by the movie_id
                    $sql = "SELECT * FROM `screening` where movie_id = (SELECT movie_id FROM `movie` WHERE title = '".$_POST['selectfilm']."')";
                    $res = $conn->query($sql);
                    
                    //store the data in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    
                    //show the data of the screening
                    var_dump($response);  
                    for ($i = 0; $i < count($response); $i++) {
                        $date = $response[$i]['date'];
                        $hour = $response[$i]['hour'];
                        echo '<option value="'.$date.'|'.$hour.'">'.$date.' '.$hour.'</option>';
                    }
                    $conn->close();  
                    
                    echo "</select>";

                    echo '<input type="submit" value="Delete Screening"></input>';
                } else {
                    echo '<input type="submit" value="Next"></input>';
                }
            ?>
            </form>

            <?php
                //check if admin selected a movie
                if (isset($_POST['selectfilm'])) {
                    $_SESSION['isfilmselected'] = true;
                    echo "OR";
                    //give option to change movie
                    echo '<a href="deletescreening.php?other=true"">Choose other film</a>';
                }
            ?>

            <?php
            //check if a message for a deleted screening is stored in the session
                if (isset($_SESSION['deletescreeninginfo'])) {
                    echo $_SESSION['deletescreeninginfo'];
                    unset($_SESSION['deletescreeninginfo']);
                }
            ?>

            <?php
                
                if (isset($_POST['selectscreening'])) {
                    //extract the date,hour from the selected screening
                    $date = explode("|", $_POST['selectscreening'])[0];
                    $hour = explode("|", $_POST['selectscreening'])[1];

                    include "./database/DatabaseData.php";
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    //check connection
                    if ($conn->connect_errno) die('Error SQL');
                    
                    //delete selected screening 
                    $sql = "DELETE FROM `screening` WHERE date = '".$date."' AND hour = '".$hour."' AND movie_id = (SELECT movie_id FROM `movie` WHERE title = '".$_SESSION['film']."')";
                    $res = $conn->query($sql);
                    echo $sql;
                    $conn->close();

                    unset($_SESSION['isfilmselected']);
                    $_SESSION['deletescreeninginfo'] = "screening deleted";
                    unset($_SESSION['film']);

                    header("Location: deletescreening.php");
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