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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript" src="cart.js"></script>

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
    <?php include_once 'dbConnect.php';?>
    <!-- code to include header menu-->
    <?php include_once 'headerAndMenu.php';?>
     
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>

    <div class="container" style="height:100%;">
        <table style="width:100%;min-height:450px;">

            <tr style="height:70%;">
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
                        $catName = "Vest";
                        break;
                    case 2:
                        $catName = "Hoodie";
                        break;
                    case 3:
                        $catName = "Joggers";
                        break;
                    case 4:
                        $catName = "Tank Top";
                        break;
                    case 5:
                        $catName = "Hat";
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
                        $imgSQL = "SELECT Path FROM ProductImgs WHERE prodID=".$productId." ORDER BY Priority ASC;";
                        $prodImgs = mysqli_query($conn, $imgSQL);
                        $prodImgArray = mysqli_fetch_all($prodImgs);
                        $noOfImgs = mysqli_num_rows($prodImgs);
                        $soldOut = '';

                        //if everything out of stock
                        if ($row['stockXS'] == 0 && $row['stockS'] == 0 && $row['stockM'] == 0 && $row['stockL'] == 0 && $row['stockXL'] == 0 && $row['stockXXL'] == 0 && $row['stockXXXL'] == 0){
                            $soldOut = '<br><span style="color:rgba(0,175,80,255);font-size:22px;">Sold Out</span>';
                        }
                        if ($noOfImgs != 0){
                            
                            echo '<td style="width:100%;">
                                <div class="container">
                                    <div id="product'.$productId.'Indicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">';

                            for ($index = 0; $index < $noOfImgs; $index++){
                                if ($index == 0){
                                    echo '<button type="button" data-bs-target="#product'.$productId.'Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                                }
                                else {
                                    echo '<button type="button" data-bs-target="#product'.$productId.'Indicators" data-bs-slide-to="'.$index.'" aria-label="Slide '.($index+1).'"></button>';
                                }
                                
                            }

                            echo '</div>
                            <div class="carousel-inner">';

                            for ($index = 0; $index < $noOfImgs; $index++){
                                $imgPath = $prodImgArray[$index][0];
                                if ($index == 0){
                                    echo '<div class="carousel-item active">';
                                }
                                else {
                                    echo '<div class="carousel-item">';
                                }

                                echo '
                                    <a href="productPage.php?productID='.$productId.'">
                                        <img src="'.$imgPath.'" class="d-block w-100 productThumbnailImage" alt="...">
                                    </a>
                                    </div>';

                            }
                            echo '</div>';

                            echo '<button class="carousel-control-prev" type="button" data-bs-target="#product'.$productId.'Indicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#product'.$productId.'Indicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>';

                            echo '      
                                </div>
                                <div class="productSubtext">'.$row['name'].' - '.$row['Colour'].'<br>£'.$row['price'].$soldOut
                            .'  </div>
                                
                            </td>';

                            // <button type="button" class="btn btn-outline-success" onclick="addToBasket(1, [DUMMY] Black Mens Hoodie, 30.99, 1, Pictures/Stock Hoodies/1Back.jpg))">Add To Basket</button>

                                echo '</tr><tr style="height:70%;">';
                                $productCount++;

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
    <?php include_once "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>