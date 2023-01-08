<?php
    $email = $_POST["email"];
    include_once 'dbConnect.php';

    $validationSQL = "SELECT email FROM MailList";
    $validationResults = mysqli_query($conn, $validationSQL);
    
    $alreadyStored = false;
    
    //only perform check if table isnt empty
    if ($validationResults){
        //checks that email isn't already on mailing list
        $emailsArray = mysqli_fetch_array($validationResults, MYSQLI_NUM);
        foreach($emailsArray as &$storedEmail){
            if (strcmp($email, $storedEmail) == 0){
                $alreadyStored = true;
            }
            if($alreadyStored){
                break;
            }
        }
    }

    //if not in the db
    if (!$alreadyStored){
        $storeQuery = "INSERT INTO MailList(email) VALUES ('".$email."')";
        $stmt = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stmt, $storeQuery)){
            die(mysqli_error($conn));
        }
        else{
            mysqli_stmt_execute($stmt);
            echo '<script>alert("Sign up Successful")</script>';
        }
    }
    else{
        echo '<script>alert("Youve already signed up!")</script>';
    }


?>