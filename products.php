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
    <?php include_once 'dbConnect.php';?>
    <!-- code to include header menu-->
    <div w3-include-html="headerAndMenu.html"></div>
    <script src="w3-include-HTML.js"></script>

    <div class="container pageInfo">
        <table width="100%">

            <tr>
                <?php
                //get products from db and count of them
                $getProductsSQL = 'SELECT * FROM Products;';
                $products = mysqli_query($conn, $getProductsSQL);
                $noOfProducts = mysqli_num_row($products);

                //init global variables
                $count = 0;
                $imgPath = '';

                //if we havented pasted all the products
                while ($count !== $noOfProducts){
                    if ($row = mysqli_fetch_assoc($products)){
                        $productId = $row['prodID'];
                        $imgSQL = "SELECT Path FROM ProductImgs WHERE prodID=".$productId.";";
                        $prodImgs = mysqli_query($conn, $imgSQL);
                        $prodImgArray = mysqli_fetch_all($prodImgs);
                        $noOfImgs = mysqli_num_row($prodImgs);
                        $imgCounter = 0;
                        if ($noOfImgs != 0){
                            echo '<td width="25%"><div class="container productContainer"><div id="product'.$count.'" class="carousel carousel-dark slide productThumbnail" data-bs-ride="carousel"><div class="carousel-indicators">';
                            
                            for ($x=0; $x < $noOfProducts; $x++){
                                if ($x == 0){
                                    echo '<button type="button" data-bs-target="#product'.$count.'" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                                }
                                else{
                                    echo '<button type="button" data-bs-target="#product'.$count.'" data-bs-slide-to="'.$x.'" aria-label="Slide '.($x+1).'"></button>';
                                }
                            }
                            echo '</div><div class="carousel-inner">';
                            while ($imgCounter != $noOfImgs){
                                $imgPath = "".$prodImgArray[$imgCounter][0];
                                if ($imgCounter == 0){
                                    echo '<div class="carousel-item active"><a href="productPage.html"><img src="';
                                }//if first img
                                else {
                                    echo '<div class="carousel-item"><a href="productPage.html"><img src="';
                                }
                                echo ''.$imgPath.'" class="d-block w-100 productThumbnailImage" alt="..."></a></div>';
                                $imgCounter++;
                            }//while imgs to paste in carousel
                            echo '</div></div></div><div class="productSubtext">'.$row['name'].'<br /> £'.$row['price'].'</div><div class="productAddToBasket"><button type="button" class="btn btn-outline-success">Add To Basket</button></div></td>';
                            $count++;
                            if (count % 4 == 0){
                                echo '</tr><tr>';
                            }

                        }//if
                    }//if

                    /* Need to print no img msg*/

                }//while
                ?>
            </tr>
        </table>

    </div>


    <div w3-include-html="footer.html" style="padding-top:1em;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>