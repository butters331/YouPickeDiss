<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youpickeddiss</title>
    <link rel="icon" type="image/x-icon" href="/Pictures/ypd.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="youPickeDiss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
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
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>