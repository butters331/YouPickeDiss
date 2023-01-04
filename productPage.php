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
    <script type="text/javascript" src="cart.js"></script>
    <!-- code to include header menu-->
    <div w3-include-html="headerAndMenu.html"></div>
    <script src="w3-include-HTML.js"></script>
    <?php
    include_once 'dbConnect.php';
    session_start();
    $_SESSION['productID'] = $_GET['productID'];
    

    $prodID = $_SESSION['productID'];
    $productInfoSQL = 'SELECT * FROM Products WHERE prodID='.$prodID;
    $productImgsSQL = 'SELECT Path From ProductImgs Where prodID='.$prodID;
    $productInfo = mysqli_query($conn, $productInfoSQL);
    $productImgs = mysqli_query($conn, $productImgsSQL);
    $noOfImgs = mysqli_num_rows($productImgs);

    $productInfoArray = mysqli_fetch_assoc($productInfo);
    ?>

    <div class="container pageInfo">

        <!-- Carousel with photos on the front page -->
        <div class="container">
            <div id="productBigCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <?php 
            if($noOfImgs == 0){
                echo "Error, Image not found";
            }
            else{
                echo '<div class="carousel-indicators">';
                for($imgCount = 0; $imgCount < $noOfImgs; $imgCount++){
                    if ($imgCount == 0){
                        echo '<button type="button" data-bs-target="#productBigCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                    }
                    else{
                        echo '<button type="button" data-bs-target="#productBigCarousel" data-bs-slide-to="'.$imgCount.'" aria-label="Slide '.($imgCount+1).'"></button>';
                    }
                }

                echo '</div>';
                echo '<div class="carousel-inner">';

                for($count = 0; $count < $noOfImgs; $count++){
                    if ($count == 0){
                        echo '<div class="carousel-item active">';
                    }
                    else{
                        echo '<div class="carousel-item">';
                    }
                    $productImgsArray = mysqli_fetch_array($productImgs,MYSQLI_NUM);
                    echo '<img src="'.$productImgsArray[0].'" class="d-block w-100 productLargeImg" alt="...">';
                    echo '</div>';
                }//for
            }//else
            
            ?>

                    <button class="carousel-control-prev" type="button" data-bs-target="#productBigCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productBigCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <h1 class="pageFormat"><?php echo $productInfoArray['name'];?></h1>
        <p class="pageFormat">
            <?php echo $productInfoArray['description'];?>
            <br />
            <br />
        </p>
        <h4><?php echo '£'.$productInfoArray['price'].'<br>'.$productInfoArray['Colour'];?></h4>
            <div class="quantityButton">
                <?php 
                    echo '<button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementPreBasket()">-</button><div id="productQuantity">  1  </div><button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementPreBasket()">+</button>';
                ?>

            </div>
            <div class="preAddToBasket">
                <?php 
                    echo '<button type="button" class="btn btn-outline-success" onclick="addToBasket('.$productInfoArray['prodID'].',`'.$productInfoArray['name'].'`,'.$productInfoArray['price'].',`'.$productImgsArray[0].'`, getPreBasket())">Add To Basket</button>';
                    mysqli_close($conn);
                ?>  
                <br />
                <br />
            </div>

        </div>
    </div>

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