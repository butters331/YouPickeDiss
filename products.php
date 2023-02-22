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
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="cart.js"></script>
</head>
<body class="d-flex flex-column min-vh-100" onload="populateBasket()">
    <?php include_once 'dbConnect.php';?>
    <!-- code to include header menu-->
    <?php include_once 'headerAndMenu.php';?>
    <script src="w3-include-HTML.js"></script>
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>

    <div class="container" style="height:100%;">
        <table style="width:100%;min-height:450px;">

            <tr style="height:40%;">
                <?php
                $_SESSION["productID"] = 666;

                $category = $_GET["category"];
                $newReleases = FALSE;
                $catName = "";

                switch($category){
                    case 0: //new release
                        $newReleases = TRUE;
                        break;
                    case 1:
                        $catName = "T-Shirt";
                        break;
                    case 2:
                        $catName = "Hoodie";
                        break;
                    case 3:
                        $catName = "Joggers";
                        break;
                    case 4:
                        $catName = "Shorts";
                        break;
                    default:
                        $newReleases = TRUE;
                }

                //get products from db and count of them
                $getProductsSQL = "";
                if ($newReleases){
                    $getProductsSQL = 'SELECT * FROM Products ORDER BY dateAdded DESC;';
                }
                else{
                    $getProductsSQL = 'SELECT * FROM Products WHERE category="'.$catName.'" ORDER BY dateAdded DESC;';
                }
                
                $products = mysqli_query($conn, $getProductsSQL);
                $noOfProducts = mysqli_num_rows($products);

                //init global variables
                $productCount = 0;
                $imgPath = '';

                //if we havented pasted all the products
                if($newReleases && $noOfProducts > 5){
                    $noOfProducts = 5;
                }
                while ($productCount !== $noOfProducts){
                    if ($row = mysqli_fetch_assoc($products)){
                        $productId = $row['prodID'];
                        $imgSQL = "SELECT Path FROM ProductImgs WHERE prodID=".$productId.";";
                        $prodImgs = mysqli_query($conn, $imgSQL);
                        $prodImgArray = mysqli_fetch_all($prodImgs);
                        $noOfImgs = mysqli_num_rows($prodImgs);
                        $imgCounter = 0;
                        if ($noOfImgs != 0){
                            echo '<td style="width:33%;">
                                <div class="container productContainer">
                                    <div id="product'.$productCount.'" class="carousel carousel-dark slide productThumbnail" data-bs-ride="carousel" style="width:100%;">
                                        <div class="carousel-indicators">';
                            
                            for ($y=0; $y < $noOfImgs; $y++){
                                if ($y == 0){
                                    echo '  <button type="button" data-bs-target="#product'.$productCount.'" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                                }
                                else{
                                    echo '  <button type="button" data-bs-target="#product'.$productCount.'" data-bs-slide-to="'.$y.'" aria-label="Slide '.($y+1).'"></button>';
                                }
                            }
                            echo '      </div>
                                        <div class="carousel-inner">';
                            while ($imgCounter != $noOfImgs){
                                $imgPath = "".$prodImgArray[$imgCounter][0];
                                if ($imgCounter == 0){
                                    echo '  <div class="carousel-item active">
                                                <a href="productPage.php?productID='.$productId.'">
                                                    <img src="';
                                }//if first img
                                else {
                                    echo '  <div class="carousel-item">
                                                <a href="productPage.php?productID='.$productId.'">
                                                    <img src="';
                                }
                                echo ''.$imgPath.'" class="d-block w-100 productThumbnailImage" alt="...">
                                                </a>
                                            </div>';
                                $imgCounter++;
                            }//while imgs to paste in carousel

                            

                            echo '      </div>
                                    </div>
                                </div>
                                <div class="productSubtext">'.$row['name'].'<br>£'.$row['price'].'<br>'.$row['Colour']
                            .'  </div>
                                
                            </td>';

                            // <button type="button" class="btn btn-outline-success" onclick="addToBasket(1, [DUMMY] Black Mens Hoodie, 30.99, 1, Pictures/Stock Hoodies/1Back.jpg))">Add To Basket</button>


                            $productCount++;
                            if ($productCount % 3 == 0){
                                echo '
                        </tr>
                        <tr style="height:40%;">';
                            }

                        }//if
                    }//if

                    /* Need to print no img msg*/

                }//while

                mysqli_close($conn);
                ?>
            </tr>
        </table>

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
    
                    <!-- <a class="btn btn-link btn-lg m-1 basket"
                    href="#"
                    role="button"
                    data-mdb-ripple-color="light">
                        <i class="bi bi-twitter"></i>
                    </a> -->
    
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
                <a class="btn btn-link m-1 basket"
                    href="info.php"
                    role="button"
                    data-mdb-ripple-color="light">
                         Read Diss
                    </a>
            </div>
            <div class="text-center" >
                © Copyright all rights reserved
            </div>
    
        </footer>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>







