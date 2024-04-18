<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        p {
            color: aliceblue;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="top-panel">
        <?php
        session_start(); //we use it for the $_SESSION to work
        if ($_SESSION["admin"] == 1) { //check if the user is admin or not
            echo '<a href="../adminpanel.php" class="adminpanel">ADMIN PANEL</a>'; //if yes appear the admin panel link
        }
        ?>
        <a href="../index.php">PointOfView</a> <!--the title of the site is also a link to go in the movies page-->
        <a href="../logout.php" class="logout">Log out</a>
        <!--when the user is logged in this link appear to end the session and log him out-->
    </div>



    <div class="bottom-panel">
        <h3>Update user</h3>
        <div class="signup">
            <form method="POST">

                <h5>Select the user you want to update:</h5>

                <select class="updateselect" name="selectuser" id="selectuser">

                    <?php
                    include "../database/DatabaseData.php";

                    //create new connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    //check connection
                    if ($conn->connect_errno)
                        die('Error MySQL');

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
                        $user = $response[$i]['username'];
                        echo '<option value="' . $user . '">' . $user . '</option>';
                    }
                    $conn->close();
                    ?>
                </select>


                <div>
                    <div>
                        <label>Username:</label>
                        <input type="text" placeholder="Enter Username" name="username" min="3" />
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" placeholder="Enter Password" name="password" min="3" />
                    </div>
                </div>


                <div>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" placeholder="Enter Name" name="name">
                    </div>
                    <div>
                        <label for="name">Last Name</label>
                        <input type="text" placeholder="Enter Last-Name" name="lastname">
                    </div>
                    <div>
                        <label for="text">Email</label>
                        <input type="text" placeholder="Enter Email" name="email">
                    </div>
                </div>

                <div>
                    <div>
                        <label for="text">Coutry</label>
                        <input type="text" placeholder="Enter Coutry" name="counrty">
                    </div>
                    <div>
                        <label for="text">City</label>
                        <input type="text" placeholder="Enter City" name="city">
                    </div>
                    <div>
                        <label for="text">Address</label>
                        <input type="text" placeholder="Enter Address" name="address">
                    </div>
                </div>


                <input type="submit" value="Update"></input><!--update user-->


            </form>


        </div>



        <?php
        include "../database/DatabaseData.php"; //connection with the database
        require "../functions.php"; //this file entails functios that do checks and we use below
        
        //create new connection
        $conn = new mysqli($servername, $username, $password, $database);

        //check connection
        if ($conn->connect_errno)
            die('Error MySQL');

        //get the selected user from the form
        if (isset($_POST['selectuser'])) {
            $user = $_POST['selectuser'];
            $res = null;

            //check and update the changed data
            if (!empty($_POST['username']) || !empty($_POST['email']) || !empty($_POST['name']) || !empty($_POST['lastname']) 
                || (!empty($_POST['country']) || !empty($_POST['city']) || !empty($_POST['address']) || !empty($_POST['password']))) {

                if (!empty($_POST['username'])) {
                    $username = $_POST['username'];
                    if (usernameExistInDB($conn, $username)) {
                        echo "<p>Username already exists</p>";
                    } else {
                        $sql = "UPDATE user SET username='$username' WHERE username='$user'";
                        $res = $conn->query($sql);
                    }
                }

                if (!empty($_POST['email'])) {
                    $email = $_POST['email'];
                    if (emailExistInDB($conn, $email)) {
                        echo "<p>Email already exists</p>";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<p>Valid email is required!</p>";
                    } else {
                        $sql = "UPDATE user SET email='$email' WHERE username='$user'";
                        $res = $conn->query($sql);
                    }
                }
                if (!empty($_POST['lastname'])) {
                    $lastname = $_POST['lastname'];
                    $sql = "UPDATE user SET lastname='$lastname' WHERE username='$user'";
                    $res = $conn->query($sql);
                }

                if (!empty($_POST['name'])) {
                    $name = $_POST['name'];
                    $sql = "UPDATE user SET name='$name' WHERE username='$user'";
                    $res = $conn->query($sql);
                }
                if (!empty($_POST['counrty'])) {
                    $counrty = $_POST['counrty'];
                    $sql = "UPDATE user SET country='$country' WHERE username='$user'";
                    $res = $conn->query($sql);
                }
                if (!empty($_POST['city'])) {
                    $city = $_POST['city'];
                    $sql = "UPDATE user SET city='$city' WHERE username='$user'";
                    $res = $conn->query($sql);
                }
                if (!empty($_POST['address'])) {
                    $address = $_POST['address'];
                    $sql = "UPDATE user SET address='$address' WHERE username='$user'";
                    $res = $conn->query($sql);
                }
                if (!empty($_POST['password'])) {
                    $password = $_POST['password'];
                    if (strlen($password) > 2) {
                        $password = password_hash($password, PASSWORD_DEFAULT); //we encrypt the password
                        $sql = "UPDATE user SET password='$password' WHERE username='$user'";
                        $res = $conn->query($sql);
                    } else {
                        echo "<p>Password must be at least 3 digits!</p>";
                    }

                }

                if ($res != null) {
                    echo "<p>Record updated successfully.</p>";
                } else {
                    echo "<p>Record wasn't updated</p> " . $conn->error;
                }
            } else {
                echo "<p> You must fill at least one field!</p>";
            }
        }
        ?>


        <?php
        if (!isset($_SESSION["username"])) { //if you are not logged in go to the page you log in 
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