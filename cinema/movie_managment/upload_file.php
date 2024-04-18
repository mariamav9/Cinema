<?php
    session_start();

    //set the target directory for uploaded images
    $target_dir = "../img/films/";
    
    //combine the target directory with the base name of the uploaded file to create the full file path.
    $target_file = $target_dir . basename($_FILES["addnewimage"]["name"]);
    
    //a flag to indicate whether the image can be uploaded or not
    $uploadOk = 1;
    
    //get the file extension of the uploaded image and convert it to lowercase
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
    if(isset($_POST["submit"])) {
        //check if the uploaded file is a valid image
        $check = getimagesize($_FILES["addnewimage"]["tmp_name"]);
        
        //if the file is a valid image display a message and set the flag to indicate that the image can be uploaded
        if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        
        //if the file isn't a valid image display a message and set the flag to indicate that the image can't be uploaded
        } else {
        echo "File is not an image.";
        $uploadOk = 0;
        }
    }

    //check if image already exists in target file and set flag=0
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // check if the image can be uploaded
    if ($uploadOk == 0) {
        //if the image can't be uploaded, set session variable
        $_SESSION["fileuploaded"] = "false";
        header("Location: addfilmimage.php");
        
    } else {
        //if the image can be uploaded, move the uploaded image to the target director 
        if (move_uploaded_file($_FILES["addnewimage"]["tmp_name"], $target_file)) {
            
            //if image was successfully uploaded, set session variables
            $_SESSION["fileuploaded"] = "true";
            $_SESSION["filename"] = basename( $_FILES["addnewimage"]["name"]);
            header("Location: addfilmimage.php");
        } else {
            
            //if image wasn't uploaded, set session variable
            $_SESSION["fileuploaded"] = "false";
            header("Location: addfilmimage.php");
        }
    }

?>