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
        <h3>User to admin</h3>

        <div class="addnewscreening">
            <form method="POST">
                <label for="selectuser">Select username:</label>
                <select name="selectuser" id="selectuser">

                <?php
                    include "../database/DatabaseData.php";
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
                    //get all the usernames from the table user
                    $sql = "SELECT username FROM `user`";
                    $res = $conn->query($sql);
                    
                    //store the usernames in an array
                    $response = array();
                    while ($row = mysqli_fetch_assoc($res)) {
                        $response[] = $row;
                    }
                    //show all the usernames
                    var_dump($response);  
                    for ($i = 0; $i < count($response); $i++) {
                        $user= $response[$i]['username'];
                        echo '<option value="'.$user.'">'.$user.'</option>';
                    }
                    $conn->close();           
                ?>
                </select>

                <input type="submit" value="Make admin"></input>
            </form>

            <?php
                //check if user changed successfully to admin and inform the admin
                if (isset($_SESSION["changed"])) {
                    if ($_SESSION["changed"] == "true") {
                        echo "User became admin";
                    } else {
                        echo "There was an error";
                    }
                    unset($_SESSION["changed"]);
                }
            ?>

            <?php
                include "../database/DatabaseData.php";
                require "../functions.php";  //this file entails functios that do checks and we use below
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                
                //check if admin selected a user
                if (isset($_POST['selectuser'])) {
                    $user = $_POST['selectuser'];
                    
                    //call the function isAdmin() from functions.php, to infrom the admin if the selected user is already an admin
                    if (isAdmin($conn, $user)){
                        echo "User is already an admin";
                    }else{
                    
                    //if the selected user is not an admin then we update the table
                    $sql = "UPDATE `user` SET `admin` =1 WHERE `username` ='$user'";
                    $res = $conn->query($sql);
                    
                    //check if selected user was successfully changed to admin and set session variable
                    if ($res==null){
                        $_SESSION["changed"] = "false";
                        header("Location: user_to_admin.php");
                    } else {
                        $_SESSION["changed"] = "true";
                        header("Location: user_to_admin.php");
                    }
                    $conn->close();
                    }
                }
            ?>
        </div>
    </div>
  
    
    <?php
        //check if user is loogged in
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