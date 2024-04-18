<?php
    session_start();
    unset($_SESSION['isfilmselected']);
    unset($_SESSION['film']);
    unset($_SESSION['deletescreeninginfo']);
?>
<head>
    <title>Cinema</title>
    <link rel="stylesheet" href="./style/style.css"><!--we link our css style-->
   
</head>

<body>
    <div class="top-panel">
        <?php
            if ($_SESSION["admin"] == 1) {//if the user is an admin he has access to the admin panel
                echo '<a href="adminpanel.php" class="adminpanel">ADMIN PANEL</a>';
            }
        ?>
        <a href="index.php">PointOfView</a>
        <a href="logout.php" class="logout">Log out</a><!--lnk to log out-->
    </div>
    <div class="bottom-panel">
        <h3>Movies Managment</h3>
        <div id="options"><!--links that lead to movie management pages that use php-->
            <a href="movie_managment/addfilmimage.php">Add film image</a>
            <a href="movie_managment/addnewfilm.php">Add new film</a>
            <a href="movie_managment/updatefilm.php">Update film info</a>
            <a href="movie_managment/addnewscreening.php">Add new screening date</a>
            <a href="movie_managment/deletescreening.php">Delete screening date</a>
            <a href="movie_managment/deletefilm.php">Delete film</a>
            <a href="movie_managment/deletefilmimage.php">Delete film image</a>
            <a href="movie_managment/delete_all_reservations.php">Delete reservations</a>
            <a href="index.php" class="gotofilms">Check films</a>
        </div>

        <h3>Users Managment</h3>
        <div id="options"><!--links that lead to user management pages that use php-->
            <a href="user_managment/verifyuser.php">Verify Users</a>
            <a href="user_managment/viewusers.php">View All Users</a>
            <a href="user_managment/adduser.php">Add User</a>
            <a href="user_managment/updateuser.php">Update User</a>
            <a href="user_managment/deleteuser.php">Delete User</a>
            <a href="user_managment/user_to_admin.php">User to admin</a>
          
        </div>
    </div>

    
    <?php
        if (!isset($_SESSION["username"])) {
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

</html>