<!DOCTYPE html>
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

    <div class="container pageInfo">
        <!-- <div style="overflow:hidden;">
            <div style="width:50%;float:left;padding-bottom:30px;">
                <a href="products.php?category=0" title="Shop"><img class="landingLinkImgs" src="Pictures/ypd.png"></a>
            </div>
            <div style="width:50%;float:right;padding-bottom:30px;">
                <a href="" title="Archieves"><img class="landingLinkImgs" src="Pictures/4tp.png"></a>
                
            </div>
        </div> -->

        <!-- connect to db and pull imgs -->
        <?php
            include_once 'dbConnect.php';
            if(isset($_GET['success'])){
                echo "<h1 id='boughtDiss' style='text-align:center;color:rgb(0, 175, 80);' onload='clearBasket()'>You Bought Diss!</h1>";
            }
            $getImages = "SELECT * FROM AboutPageImgs";
            $images = mysqli_query($conn, $getImages);
            $noOfImages = mysqli_num_rows($images);
        ?>

        <script>
            let boughtSuccess = document.getElementById('boughtDiss');
            if (document.body.contains(boughtSuccess)){
                clearBasket();
            }
        </script>

        <!-- Carousel with photos on the front page -->
        <div class="container">
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

        <!-- buy diss button to take to new releases page, as like pressing ypd -->
        <div id="homepageShopBtnDiv">
            <a id="homepageShopBtn" role="button" href="products.php?category=0" class="btn btn-success">Buy Diss</a>
        </div>

        <!-- sign up to mailing list form -->
        <iframe name="formSending"></iframe>
        <div class="signUpForm">
            <form action="signUpForMailing.php" method="post" target="formSending">
                <label for="landingSignUp" class="form-label">Join the community for updates</label>
                <input name="email" type="email" class="form-control" id="landingSignUp" placeholder="4 your email" aria-describedby="emailHelp">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                <br>
                <button type="submit" class="btn btn-success">Click diss to sign up</button>
            </form>
        </div>

        <!-- <script>
            var form = document.getElementById("landingSignUp");
            function submitForm(event) {
                event.preventDefault();
                form.style.display = "none";
            }
            form.addEventListener('submit', submitForm);
        </script> -->
    </div>

    <!-- footer import was here -->
    <?php include_once "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
     
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>
</body>
</html>