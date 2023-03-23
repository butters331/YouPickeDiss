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
    if (!$alreadyStored && !empty($email)){
        $storeQuery = "INSERT INTO MailList(email) VALUES (?)";
        $stmt = mysqli_stmt_init($conn);
        if(! mysqli_stmt_prepare($stmt, $storeQuery)){
            die(mysqli_error($conn));
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            echo '<script>alert("Sign up Successful"); location.assign(underConstruction.php)</script>';
        }
    }
    else if ($alreadyStored){
        echo '<script>alert("Youve already signed up!")</script>';
    }
    else {
        echo '<script>alert("Enter an email to sign up")</script>';
    }


?>