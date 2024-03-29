﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <title>youpickeddiss</title>
    <link rel="icon" type="image/x-icon" href="/Pictures/ypd.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    <link rel="stylesheet" href="youPickeDiss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <?php      
        session_start();
        include_once 'password.php';

        //check password has been entered
        if($_SESSION['passHash'] != $password){
            header('Location:underConstruction.php');
        }
    ?>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '253009220485017');
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none" 
        src="https://www.facebook.com/tr?id=253009220485017&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>
<body class="d-flex flex-column min-vh-100" onload="populateBasket()">
    <!-- code to include header menu-->
    <?php include_once 'headerAndMenu.php';?>
     
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>

    <div class="container pageInfo">
    <table style="width:100%;min-height:450px;">
        <tr style="height:40%;">
        <?php
        include_once 'dbConnect.php';
        $getImages = "SELECT * FROM ArchiveImgs ORDER BY DateAdded DESC";
        $images = mysqli_query($conn, $getImages);
        $noOfImages = mysqli_num_rows($images);

        if($noOfImages > 0){
            
            for($count = 0; $count < $noOfImages; $count++){ 
                $imageArray = mysqli_fetch_assoc($images);
                //paste IMGs
                echo '
            <td style="width:33%;">
                <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..." data-bs-toggle="modal" data-bs-target="#picture'.$count.'Modal" />
                <div class="modal fade" id="picture'.$count.'Modal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..." />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>';
                if (($count % 3 == 2) && ($count != $noOfImages - 1)){
                    echo '</tr><tr style="height:40%;">';
                }
            }//for
        }
        ?>
        </tr>
    </table>
    </div>
    <!-- footer import was here -->
    <?php include_once "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>