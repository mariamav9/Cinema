<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="./style/style.css"><!--link our style shit with this file-->

</head>

<body>
    <?php
       session_start();
        if (!isset($_SESSION['logged'])) {//check if $_SESSION['logged'] has a value
          $_SESSION['logged'] = false;
      } else {
           if (!$_SESSION['logged']) {  // check what value that is
               $_SESSION['logged'] = false;
           } else {
               $_SESSION['logged'] = true;
           }
       }
        unset($_SESSION['isfilmselected']);
        unset($_SESSION['film']);
       unset($_SESSION['deletescreeninginfo']);
    ?>

   <header>
        <a href="index.php" class="cinemaLink">PointOfView</a>
        <?php
        if ($_SESSION["logged"] == true) {
            echo '<a href="logout.php" class="logout">Log out</a>'; //if yes appear the log out link
        }
        ?>
    </header>



    <main>
        <div class="index">
        <?php
            if ($_SESSION["logged"] == false) { //if not bring him to this page to view his sign in options
                echo '<a href="sign_in.php">Sign in</a>';
                echo 'OR';
                echo '<a href="sign_up.php">Sign up</a>';
            } else {
                echo '<a href="index.php" class="gotofilms">Go to films</a>';//if he he is logged lead him to the movies page
            }
        ?>        
        </div>
    </main>


</body>