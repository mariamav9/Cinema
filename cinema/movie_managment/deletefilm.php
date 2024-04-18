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
        
       <h3>Delete Film</h3>
        <div class="deletefilmimage">
            <form method="POST">
                <label for="selectfilm">Select film:</label>
                <select name="selectfilm" id="selectfilm">
                <?php
                    include "../database/DatabaseData.php";
                    
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
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
                ?>
                </select>

                <input type="submit" value="Delete"></input>
            </form>

            <?php
            //check if selected movie was successfully deleted and infrom the user
                if (isset($_SESSION["deleted"])) {
                    if ($_SESSION["deleted"] == "true") {
                        echo "Film deleted";
                    } else {
                        echo "There was an error";
                    }
                    unset($_SESSION["deleted"]);
                }
            ?>

            <?php
                include "../database/DatabaseData.php";
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                 
                //check if admin selected a movie
                if (isset($_POST['selectfilm'])) {
                    $film = $_POST['selectfilm'];
                    
                    //delete the selected movie
                    $sql = "DELETE FROM `movie` WHERE title = '$film'";
                    $res = $conn->query($sql);
                    
                    //check if selected movie was successfully deleted
                    if ($res==null){
                        $_SESSION["deleted"] = "false";
                        header("Location: deletefilm.php");
                    } else {
                        $_SESSION["deleted"] = "true";
                        header("Location: deletefilm.php");
                    }
                    $conn->close();
                }
            ?>
        </div>
    </div>
  
    
    <?php
        //check if user is logged in
        session_start();
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