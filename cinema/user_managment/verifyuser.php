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
        <h3>Verify Users</h3>

        <div class="addnewscreening">
            <form method="POST">
                <label for="selectuser">Verify User:</label>
                <select name="selectuser" id="selectuser">

                <?php
                    include "../database/DatabaseData.php";
                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);
                    //check connection
                    if ($conn->connect_errno) die('Error MySQL');
                    
                    //get all the usernames from the table user
                    $sql = "SELECT username FROM `user` WHERE verified=0";
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

                <input type="submit" value="Verify User"></input>
            </form>


            <?php
                include "../database/DatabaseData.php";
                require "../functions.php";  //this file entails functios that do checks and we use below
                //create new connection
                $conn = new mysqli($servername, $username, $password, $database);
                //check connection
                if ($conn->connect_errno) die('Error MySQL');
                
                //update database 
                if (isset($_POST['selectuser'])) {
                    $user = $_POST['selectuser'];
                    
                    $sql = "UPDATE `user` SET `verified` =1 WHERE `username` ='$user'";
                    $res = $conn->query($sql);

                    
                    //check if selected user was successfully verified and set session variable
                    if ($res==null){
                        echo "There was an error";
                    } else {
                        echo "User verified";
                    }
                
                    $conn->close();
                }    
            ?>

        

        </div>
    </div>
  
    
   
</body>

</html>