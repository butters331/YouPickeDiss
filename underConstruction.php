<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <title>youpickeddiss</title>
    <link rel="icon" type="image/x-icon" href="/Pictures/ypd.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="youPickeDiss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

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

<body>
    <?php 
        session_start();
        //first check that user hasn't already logged in
        if (!isset($_SESSION['loggedIn'])){
            $_SESSION['loggedIn'] = 0;
        }
        //if logged in go to correct page
        else if ($_SESSION['loggedIn'] === 1) {
            header('Location: index.php');
        }
    ?>
    <!-- <div>
        <div id="topRightEnterPass">
            // enter password form
            <iframe name="passSending"></iframe>
            <div class="signUpForm" id="passPageForm">
                <form action="enterPassword.php" method="post" target="passSending">
                    <div style="display:table-cell;"><input name="password" type="password" class="form-control" id="passwordEnter" placeholder="4 access" aria-describedby="passHelp"></div>
                    <div style="display:table-cell; padding:2px;"><button type="submit" class="btn btn-success" style="margin-left: 0%; justify-content: left;">Enter</button></div>
                </form>
            </div>
        </div> -->
    <div>
        <img src="Pictures/ypd.png" alt="YouPickedDiss" style=" display: block; width: 20%; height: auto; margin-left: auto; margin-right: auto;">
    </div>
<!--         
        
    </div> -->
    <div class="pageLayout">
        <h1 id="loading" style="color:rgba(0,175,80,255);">
            Sign Up 4 early access!
        </h1>
        <!-- sign up to mailing list form -->
        <iframe name="formSending"></iframe>
        <div class="signUpForm" id="constPageForm">
            <form action="signUpForMailing.php" method="post" target="formSending">
                <!--<label for="landingSignUp" class="form-label">Be the first to know when we launch!</label>-->
                <input name="email" type="email" class="form-control" id="landingSignUp" placeholder="4 your email" aria-describedby="emailHelp">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                <br>
                <button type="submit" class="btn btn-success" style="margin-left: 0%; justify-content: left;">Click diss to sign up</button>
            </form>
        </div>

        <!-- connect to db and pull imgs -->
        <?php
            include_once 'dbConnect.php';
            $getImages = "SELECT * FROM AboutPageImgs";
            $images = mysqli_query($conn, $getImages);
            $noOfImages = mysqli_num_rows($images);
        ?>

         <!-- Carousel with photos on the front page -->
         <div class="container" style="padding-top: 1em;">
            <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                        for ($count = 0; $count < $noOfImages; $count++){
                            if ($count == 0) {
                                echo '
                    <button type="button" data-bs-target="#landingCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                            }
                            else {
                                echo '
                    <button type="button" data-bs-target="#landingCarousel" data-bs-slide-to="'.$count.'" aria-label="Slide '.($count + 1).'"></button>';
                            }
                        }
                    ?>
                </div>
                <div class="carousel-inner">
                <?php
                    for ($count = 0; $count < $noOfImages; $count++){
                        $imageArray = mysqli_fetch_assoc($images);
                        if ($count == 0) {
                            echo '
                    <div class="carousel-item active">
                        <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="...">
                    </div>';
                        }
                        else {
                            echo '
                    <div class="carousel-item">
                        <img src="'.$imageArray["Path"].'" class="d-block w-100" alt="...">
                    </div>';
                        }
                    }
                ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- footer import was here -->
    <div class="mt-auto" style="padding-top:1em;">
        
        <footer class="bg-dark mt-auto" style="color: rgba(255,255,255,.55); padding:1em;">
            <div class="container" style="text-align:center;">
                <img class="footerLogo" src="Pictures/ypd.png" />
                <!-- <img class="footerLogo" src="Pictures/4tp.png" /> -->
            </div>
            <div class="container" style="text-align:center;">
                <section class="mb4">
                    <!--facebook-->
                    <!-- <a class="btn btn-link btn-lg m-1 basket"
                    href="#"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-facebook"></i>
                    </a> -->

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="https://twitter.com/YPD4TP"
                    role="button"
                    target="_blank"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-twitter"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="https://www.tiktok.com/@ypd4tp"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-tiktok"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="https://www.instagram.com/ypd4tp/"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a class="btn btn-link btn-lg m-1 basket"
                    href="mailto: info@ypd4tp.co.uk"
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