<?php


//check if Email exists in DB
function emailExistInDB($conn, $email) {
    
    //set query
    $query = "SELECT COUNT(*) FROM user WHERE email = ?";

    //prepare the query, bind the variable and execute
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    
    //grab the result
    $stmt->bind_result($numRows);
    $stmt->fetch();
    
    //check if email exists
    if ($numRows>0){
        return TRUE;
    }else{
        return FALSE;
    }

}


//check if Username exists in DB
function usernameExistInDB($conn, $username) {
    
    //set query
    $query = "SELECT COUNT(*) FROM user WHERE username = ?";

    //prepare the query, bind the variable and execute
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    
    //grab the result
    $stmt->bind_result($numRows);
    $stmt->fetch();
    
    //check if username exists
    if ($numRows>0){
        return TRUE;
    }else{
        return FALSE;
    }

}


// Check if user is admin by his username
function isAdmin($conn, $username) {
    
    // Set query
    $query = "SELECT admin FROM user WHERE username = ?";

    // Prepare the query, bind the variable and execute
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    
    // Grab the resul
    $stmt->bind_result($admin);
    $stmt->fetch();
    
    // Check if is admin
    if ($admin==1){
        return TRUE;
    }else{
        return FALSE;
    }

}
  