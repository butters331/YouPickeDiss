<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youpickeddiss</title>
    <link rel="icon" type="image/x-icon" href="/Pictures/ypd.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    <link rel="stylesheet" href="youPickeDiss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="cart.js"></script>
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
                if (session_status() === PHP_SESSION_NONE){
                    session_start();
                } 
                $_SESSION["productID"] = 666;

                $query = $_GET["query"];
                $queryArray = explode(" ", urldecode($query));


                //get products from db and count of them
                $getProductsSQL = 'SELECT * FROM Products WHERE (lower(name) LIKE lower("';
                $noOfWords = count($queryArray);
                for ($wordNo = 0; $wordNo < $noOfWords; $wordNo ++){
                    //add modulo to front and end of every word
                    $queryArray[$wordNo] = "%".$queryArray[$wordNo]."%";
                    if ($wordNo == $noOfWords - 1){
                        $getProductsSQL = $getProductsSQL.($queryArray[$wordNo].'"))');
                    }
                    else {
                        $getProductsSQL = $getProductsSQL.($queryArray[$wordNo].'")) OR (lower(name) LIKE lower("');
                    }
                }
                $getProductsSQL = $getProductsSQL.(' OR (lower(description) LIKE lower("');
                for ($wordNo = 0; $wordNo < $noOfWords; $wordNo ++){
                    if ($wordNo == $noOfWords - 1){
                        $getProductsSQL = $getProductsSQL.($queryArray[$wordNo].'"))');
                    }
                    else {
                        $getProductsSQL = $getProductsSQL.($queryArray[$wordNo].'")) OR (lower(description) LIKE lower("');
                    }
                }
                
                $products = mysqli_query($conn, $getProductsSQL);
                $noOfProducts = mysqli_num_rows($products);

                //init global variables
                $productCount = 0;
                $imgPath = '';

                if ($noOfProducts == 0){
                    echo 'No results found';
                }

                while ($productCount !== $noOfProducts){
                    if ($row = mysqli_fetch_assoc($products)){
                        $productId = $row['prodID'];
                        $imgSQL = "SELECT Path FROM ProductImgs WHERE prodID=".$productId." ORDER BY Priority ASC;";
                        $prodImgs = mysqli_query($conn, $imgSQL);
                        $prodImgArray = mysqli_fetch_all($prodImgs);
                        $noOfImgs = mysqli_num_rows($prodImgs);
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
                                <div class="productSubtext">'.$row['name'].' - '.$row['Colour'].'<br>£'.$row['price']
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