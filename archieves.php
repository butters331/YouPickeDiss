<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouPickeDiss</title>
    <link rel="icon" type="image/x-icon" href="/Pictures/ypd.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="youPickeDiss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100" onload="populateBasket()">
    <!-- code to include header menu-->
    <div w3-include-html="headerAndMenu.html"></div>
    <script src="w3-include-HTML.js"></script>
    <script type="text/javascript" src="cart.js"></script>

    <?php
        include_once 'dbConnect.php';
        $getImages = "SELECT * FROM ArchiveImgs ORDER BY DateAdded DESC";
        $images = mysqli_query($conn, $getImages);
        $noOfImages = mysqli_num_rows($images);

        if($noOfImages > 0){
            for($count = 0; $count < $noOfImages - 1; $count++){
                $imageArray = mysqli_fetch_assoc($images);
                echo '
    <div class="container pageInfo">
        <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..." data-bs-toggle="modal" data-bs-target="#picture'.$count.'Modal" />
    </div>';
                echo '
    <div class="modal fade" id="picture'.$count.'Modal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
            <div class="modal-content"><div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..." />
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>';
            }
            $imageArray = mysqli_fetch_assoc($images);
            echo '
    <div class="container pageInfo" style="padding-bottom: 1em;">
        <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..." data-bs-toggle="modal" data-bs-target="#picture'.($noOfImages-1).'Modal" />
    </div>';
            echo '
    <div class="modal fade" id="picture'.($noOfImages-1).'Modal" tabindex="-1" aria-labelledby="" aria-hidden="true">
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
    </div>';
        }
    ?>

    <!-- footer import was here -->
    <div class="mt-auto" style="padding-top:1em;">
        
        <footer class="bg-dark mt-auto" style="color: rgba(255,255,255,.55); padding:1em;">
            <div class="container" style="text-align:center;">
                <img class="footerLogo" src="Pictures/ypd.png" />
                <img class="footerLogo" src="Pictures/4tp.png" />
            </div>
            <div class="container" style="text-align:center;">
                <section class="mb4">
                    <!--facebook-->
                    <a class="btn btn-link btn-lg m-1 basket"
                    href="#"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="#"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-twitter"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="#"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="mailto: divine@youpickediss.com"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </section>
            </div>
            <div class="text-center" >
                © Copyright all rights reserved
            </div>

        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>