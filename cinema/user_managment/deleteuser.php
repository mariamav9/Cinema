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
        <h3>Delete User By Name</h3>

        <div class="addnewscreening">
            <form method="POST">
                <label for="selectuser">Select the username you want to delete:</label>
                <select name="selectuser" id="selectuser">

                <?php
                    include "../database/DatabaseData.php";
            
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
                    //get all usernames from the table user
                    $sql = "SELECT username FROM `user`";
                    $res = $conn->query($sql);
                    $response = array();
                    
                    //store the usernames in an array
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    //show all usernames 
                    var_dump($response);  
                    for ($i = 0; $i < count($response); $i++) {
                        $user= $response[$i]['username'];
                        echo '<option value="'.$user.'">'.$user.'</option>';
                    }
                    $conn->close();           
                ?>
                </select>

                <input type="submit" value="Delete user"></input>
            </form>

            <?php
                //check if user was successfully deleted and inform the admin
                if (isset($_SESSION["deleted"])) {
                    if ($_SESSION["deleted"] == "true") {
                        echo "User deleted";
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
                
                //check if admin chose a user 
                if (isset($_POST['selectuser'])) {
                    $user = $_POST['selectuser'];
                    
                    //delete selected user
                    $sql = "DELETE FROM `user` WHERE username = '$user'";
                    $res = $conn->query($sql);
                    
                    //check if user was successfully deleted and set session variable
                    if ($res==null){
                        $_SESSION["deleted"] = "false";
                        header("Location: deleteuser.php");
                    } else {
                        $_SESSION["deleted"] = "true";
                        header("Location: deleteuser.php");
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