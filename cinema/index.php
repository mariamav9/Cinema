<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
    <link rel="stylesheet" href="./style/style.css">
    
</head>

<body>
    <header>
        <?php
             session_start();
             if (isset($_SESSION["username"])) {//check if there is a user logged in
                echo '<a href="logout.php" class="logout">Log out</a> ';//appear log out link
                if ($_SESSION["admin"] == 1) {//check if that user is an admin
                   echo '<a href="adminpanel.php" class="adminpanel">ADMIN PANEL</a>';//appear admin panel
                }
            }  
        ?>
        <a href="index.php" class="cinemaLink">PointOfView</a>
        <!--search bar-->
        <input id="searchbar"  type="text"
        name="search" placeholder="Search movies..">

       
      
    </header>

    <main>
        <h3>Films</h3>
        <div id="films"></div><!--this div we use in cinema.js to add films in the interface-->
    </main>


    <script src="./js/cinema.js"></script><!--we link this html file with cinema.js-->
   
   
</body>

</html>