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
        
        <h3>Add new image</h3>
        <div class="addnewimage">
            <form method="POST" action="upload_file.php" enctype="multipart/form-data">
                <label for="addnewimage">Upload file:</label>
                <input type="file" name="addnewimage" id="addnewimage">
                
                <input type="submit" name= "submit" value="Add"></input>
            </form>
            
            

            <?php
            //check if image was successfully uploaded
                if (isset($_SESSION['fileuploaded'])) {
                    if ($_SESSION["fileuploaded"] == "true") {
                        echo 'File '.$_SESSION["filename"].' succesfuly uploaded';
                        unset($_SESSION["filename"]);
                        unset($_SESSION["fileuploaded"]);
                    } else {
                        echo 'There was an error uploading file';
                        unset($_SESSION["filename"]);
                        unset($_SESSION["fileuploaded"]);
                    }
                }
            ?>
        </div>
    </div>

    
    <?php
    // check if user is logged in 
    if (!isset($_SESSION["username"])) {
        header("Location: login_ckeck.php");
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