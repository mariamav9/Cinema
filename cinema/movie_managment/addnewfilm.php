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
        <h3>Add new film</h3>

        <div class="addnewfilm">
            <form method="POST">

                <label for="filmname">Insert title:</label>
                <input type="text" name="filmname" id="filmname"></input>

                <label for="filmdirector">Insert director:</label>
                <input type="text" name="filmdirector" id="filmdirector"></input>

                <label for="filmduration">Insert duration:</label>
                <input type="text" name="filmduration" id="filmduration"></input>

                <label for="filmproduction">Insert production year:</label>
                <input type="text" name="filmproduction" id="filmproduction"></input>

                <label for="selectimage">Choose film image:</label>
                <select name="selectimage" id="selectimage">

                <?php
                //show the available images on the img/films file
                    $images = scandir('../img/films');
                    for ($i = 2; $i < count($images); $i++) {
                        echo '<option value="'.$images[$i].'">'.$images[$i].'</option>';
                    }
                ?>
                </select>

                <input type="submit" value="Add"></input>
            </form>

            <?php
                include "../database/DatabaseData.php";
                
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                
                //check if all fields are filled
                if (isset($_POST['filmname'], $_POST['selectimage'],$_POST['filmdirector'],$_POST['filmduration'],$_POST['filmproduction'])) {
                    $filmname = $_POST['filmname'];
                    $filmdirector = $_POST['filmdirector'];
                    $filmduration = $_POST['filmduration'];
                    $filmproduction = $_POST['filmproduction'];
                    $selectimage = $_POST['selectimage'];
                    
                    //insert new data in the database
                    $sql = "INSERT INTO `movie` (`movie_id`, `title`, `director`, `duration`, `production_date`, `image`) VALUES ('0','$filmname','$filmdirector','$filmduration','$filmproduction','$selectimage')";
                    $res = $conn->query($sql);
                    
                    //check if the data inserted successfully
                    if ($res==null){
                        header("Location: addnewfilm.php");
                    } else {
                        echo "Film added";
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