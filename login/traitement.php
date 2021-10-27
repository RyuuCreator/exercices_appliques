<?php
    // Initialize the session
    session_start();

    // Include config file
    require_once "config.php";

    $username = $_SESSION['username'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(empty(trim($_POST["data"]))){
            $alert = "Veuillez signés.";
        } else{
            
            $data = $_POST["data"];

            $sql = "UPDATE users SET signature = '$data' WHERE username = '$username'";
            mysqli_query($link, $sql);
            $stmt = mysqli_prepare($link, $sql);
            
            if(mysqli_stmt_execute($stmt)){
                // envoi reponse json
                $myJSON = json_encode('OK');
                echo $myJSON;
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            mysqli_stmt_close($stmt);
        }
    }
?>