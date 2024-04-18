<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        p{
            color:aliceblue;
            font-size:20px;
        }
    </style>
</head>

<body>
    <div class="top-panel">
        <?php
            session_start();//we use it for the $_SESSION to work
            if ($_SESSION["admin"] == 1) {//check if the user is admin or not
                echo '<a href="../adminpanel.php" class="adminpanel">ADMIN PANEL</a>';//if yes appear the admin panel link
            }
        ?>
        <a href="../index.php">PointOfView</a>  <!--the title of the site is also a link to go in the movies page-->
        <a href="../logout.php" class="logout">Log out</a>   <!--when the user is logged in this link appear to end the session and log him out-->
    </div>
    <div class="bottom-panel">
        <h3>Add new user</h3>

        <div class="signup">
            <form method="POST">
                <div>
                  <div>
                    <label >Username:</label>        
                    <input type="text" placeholder="Enter Username" name="username" min="3"required />
                  </div>
                  <div >
                    <label>Password:</label>
                    <input type="password" placeholder="Enter Password" name="password" min="3" required />
                 </div>
                </div>
                

                <div>
                    <div >
                     <label  for="name">Name</label>
                     <input  type="text" placeholder="Enter Name" name="name" required>
                    </div>
                    <div >
                     <label for="name">Last Name</label>
                     <input  type="text" placeholder="Enter Last-Name" name="lastname" required.>
                    </div>
                    <div>
                     <label for="text">Email</label>
                     <input  type="text" placeholder="Enter Email" name="email" required.>
                    </div>
                </div>

                <div >
                    <div> 
                    <label for="text">Coutry</label>
                       <input type="text" placeholder="Enter Coutry" name="counrty" required>
                    </div>
                    <div >
                        <label  for="text">City</label>
                        <input  type="text" placeholder="Enter City" name="city" required>
                    </div>
                    <div >
                    <label  for="text">Address</label>
                    <input  type="text" placeholder="Enter Address" name="address" required> 
                    </div>
                </div>
            
                    
                <input type="submit" value="Sumbit"></input><!--make new user-->
            </form>

           
        </div>
        


        <?php
        include "../database/DatabaseData.php"; //connection with the database
        require "../functions.php"; //this file entails functios that do checks and we use below
        
        //create new connection
        $conn = new mysqli($servername, $username, $password, $database);
        
        //check connection
        if ($conn->connect_errno) die('Error MySQL');
        
        //we check if they have a value
        if (isset($_POST['username'], $_POST['password'], $_POST['email'],$_POST['name'], $_POST['lastname'], $_POST['counrty'],$_POST['city'], $_POST['address'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $lastname = $_POST['lastname'];
        $name = $_POST['name'];
        $counrty = $_POST['counrty'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $user_id=0;
        $admin=0;
        $verified=1;

        //we check if the value is already in the database for some values
        if(usernameExistInDB($conn, $_POST['username'])){
            echo "<p>Username already exists</p>";

        }elseif (emailExistInDB($conn, $_POST['email'])){
                echo "<p>Email already exists</p>";
    
        }elseif ( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo "<p>Valid email is required!</p>";

        }elseif(strlen($password)>2&&strlen($username)>2){
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);//we encrypt the password
                
                //insert new data in database
                $stmt = $conn->prepare("INSERT INTO user (user_id, username, password, email, name, lastname, counrty, city, address, admin, verified) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("issssssssdd", $user_id, $username, $password, $email, $name, $lastname, $counrty, $city, $address, $admin, $verified);
                $stmt->execute();
                
                
                if ($stmt->error) {
                    die("SQL error: " . $stmt->error);
                }
              
                echo"<p>User was added</p>";
                
            }else{
                echo"<p>Username and Password must be more than 2 digits.</p>";
            }
        }else{
            echo "<p>Fill all the fields</p>";
        }
        
        ?>


    <?php
        if (!isset($_SESSION["username"])) {//if you are not logged in go to the page you log in 
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