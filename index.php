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
<body>
    <!-- code to include header menu-->
    <div w3-include-html="headerAndMenu.html"></div>
    <script src="w3-include-HTML.js"></script>

    <div class="container pageInfo">
        <h1 class="pageFormat">Our Message</h1>
        <p class="pageFormat">
            From the streets 4our the people, this isn’t just a brand, we are a community of friends and family. Combining the best of
            African & British culture and bringing people together to have fun and express themselves. We thank you for picking us and
            ask you to stay with us through our journey.
            <br>
            <br>
            YPD Community
        </p>

        <!-- connect to db and pull imgs -->
        <?php
            include_once 'dbConnect.php';
            $getImages = "SELECT * FROM AboutPageImgs";
            $images = mysqli_query($conn, $getImages);
            $noOfImages = mysqli_num_rows($images);
        ?>

        <!-- Carousel with photos on the front page -->
        <div class="container">
            <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                        for ($count = 0; $count < $noOfImages; $count++){
                            if ($count == 0) {
                                echo '<button type="button" data-bs-target="#landingCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                            }
                            else {
                                echo '<button type="button" data-bs-target="#landingCarousel" data-bs-slide-to="'.$count.'" aria-label="Slide '.($count + 1).'"></button>';
                            }
                        }
                    ?>
                </div>
                <div class="carousel-inner">
                <?php
                    for ($count = 0; $count < $noOfImages; $count++){
                        $imageArray = mysqli_fetch_assoc($images);
                        if ($count == 0) {
                            echo '<div class="carousel-item active"><img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..."></div>';
                        }
                        else {
                            echo '<div class="carousel-item"><img src="'.$imageArray["Path"].'" class="d-block w-100" alt="..."></div>';
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
    <div w3-include-html="footer.html" style="padding-top:1em;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
 