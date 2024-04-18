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
        include "./database/DatabaseData.php";//connection to databse
        $conn = new mysqli($servername, $username, $password, $database);//make the connection

        if ($conn->connect_errno) die('Error MySQL');
        if (isset($_POST['username'], $_POST['password'])) {//check if the inputs had values
            $login = $_POST['username'];
            $pass = $_POST['password'];
            $sql = "SELECT * FROM `user` WHERE username='$login' ";//check if the username exixts
            
            $res = $conn->query($sql);
            
            if ($res==null){
                header("Location: sign_in.php");
            }
            $response = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $response[] = $row;
            }
            
            if (!empty($response) && password_verify($pass, $response[0]['password']) && $login==$response[0]['username']) {//check if the username and //password are correct
                session_start();

                $_SESSION['username'] = $_POST['username']; // make SESSION variables to checks across the site 

                $_SESSION['admin'] = $response[0]['admin'];
               
                $_SESSION['verified'] = $response[0]['verified'];

                $_SESSION['user_id'] = $response[0]['user_id'];
                header("Location: index.php");//after successful sign in we go to index to choose films
                
            }else{ 
                
               echo "<p>Wrong password or username</p>";
                
            }

            $conn->close();
        }?>
       <!--html for sign in-->
        <div class="signin">
            <form method="POST">
                
                <label>Username:</label>
                <input type="text" name="username" required />
                
                <label>Password:</label>
                <input type="password" name="password" required />

                <input type="submit" value="Sign in"></input>
            </form>
            OR
            <a href="sign_up.php">Sign up</a>
        </div>
    </main>
</body>

</html>