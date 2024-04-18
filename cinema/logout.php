<?php
    session_start();
    session_destroy();//end session
    header("Location: sign_in.php");//go to sign in page
?>
