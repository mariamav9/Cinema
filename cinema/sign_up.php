<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        p{
            color:aliceblue;
            font-size:20px;
        }
    </style>
</head>

<body>
    <header>
        <a href="index.php" class="cinemaLink">PointOfView</a>
    </header>

    <main>
        <?php
        include "./database/DatabaseData.php";//connection to database
        require "functions.php";//use function from this file
        

        $conn = new mysqli($servername, $username, $password, $database);//make connection

        if ($conn->connect_errno) die('Error MySQL');
       //check if the inputs had values
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
        //check if values were already in database
        if(usernameExistInDB($conn, $_POST['username'])){
            echo "<p>Username already exists</p>";

        }elseif (emailExistInDB($conn, $_POST['email'])){
                echo "<p>Email already exists</p>";
    
        }elseif ( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo "<p>Valid email is required!</p>";

        }elseif(strlen($password)>2&&strlen($username)>2){
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                
                //insert user to database
                $stmt = $conn->prepare("INSERT INTO user (user_id, username, password, email, name, lastname, counrty, city, address, admin) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("issssssssd", $user_id, $username, $password, $email, $name, $lastname, $counrty, $city, $address, $admin);//we use i for number s for string d for double
                $stmt->execute();
                
                
                if ($stmt->error) {
                    die("SQL error: " . $stmt->error);
                }

                header("Location: sign_in.php");
                
            }else{
                echo"<p>Username and Password must be more than 2 digits.</p>";
            }
        }else{
            echo "<p>Fill all the fields</p>";
        }
        
        ?>
        <!--html for the sign up form-->
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
                
            
                  <div class="widthmaster">
                       <div >
                          <label  for="name">Name:</label>
                          <input  type="text" placeholder="Enter Name" name="name" required>
                        </div>
                        <div >
                          <label for="name">Last Name:</label>
                          <input  type="text" placeholder="Enter Last-Name" name="lastname" required.>
                        </div>
                        <div>
                          <label for="text">Email:</label>
                          <input  type="text" placeholder="Enter Email" name="email" required.>
                        </div>
                    </div>

                    <div class="widthmaster">
                        <div> 
                           <label for="text">Coutry:</label>
                           <input type="text" placeholder="Enter Coutry" name="counrty" required>
                        </div>
                        <div >
                            <label  for="text">City:</label>
                            <input  type="text" placeholder="Enter City" name="city" required>
                        </div>
                        <div >
                          <label  for="text">Address:</label>
                          <input  type="text" placeholder="Enter Address" name="address" required> 
                        </div>
                    </div>
                
                    
                <input type="submit" value="Sign up"></input>
            </form>
            OR
            <a href="sign_in.php">Sign in</a>
        </div>
    </main>
    
</body>
</html>
