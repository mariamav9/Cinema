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
        
    <h3>Delete film image</h3>
        <div class="deletefilmimage">
            <form method="POST">
                <label for="selectimage">Choose image:</label>
                <select name="selectimage" id="selectimage">
                <?php
                //show the available images on the img/films file
                    $images = scandir('../img/films');
                    for ($i = 2; $i < count($images); $i++) {
                        echo '<option value="'.$images[$i].'">'.$images[$i].'</option>';
                    }
                ?>
                </select>

                <input type="submit" value="Delete"></input>
            </form>

            <?php
                //check if admin selected an image
                if (isset($_POST['selectimage'])) {
                    $selectimage = $_POST['selectimage'];
                    
                    //check if image was successfully deleted from img/files and inform the user
                    if (unlink('../img/films/'.$selectimage)) {            //unlink to delete the image
                        echo 'The file ' . $selectimage . ' was deleted successfully!';
                    } else {
                        echo 'There was a error deleting the file ' . $selectimage;
                    }
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