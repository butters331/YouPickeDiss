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
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>
    <!-- code to include header menu-->
    <?php include_once 'headerAndMenu.php';?>
     
    <?php
    include_once 'dbConnect.php';
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
                echo '
                <div class="carousel-indicators">';
                for($imgCount = 0; $imgCount < $noOfImgs; $imgCount++){
                    if ($imgCount == 0){
                        echo '
                    <button type="button" data-bs-target="#productBigCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                    }
                    else{
                        echo '
                    <button type="button" data-bs-target="#productBigCarousel" data-bs-slide-to="'.$imgCount.'" aria-label="Slide '.($imgCount+1).'"></button>';
                    }
                }

                echo '
                </div>';
                echo '
                <div class="carousel-inner">';

                for($count = 0; $count < $noOfImgs; $count++){
                    if ($count == 0){
                        echo '
                    <div class="carousel-item active">';
                    }
                    else{
                        echo '
                        <div class="carousel-item">';
                    }
                    $productImgsArray = mysqli_fetch_array($productImgs,MYSQLI_NUM);
                    echo '  <img src="'.$productImgsArray[0].'" class="d-block w-100 productLargeImg" alt="...">';
                    echo '
                        </div>';
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
                <br>
                <div class="selectSize">
                    <select id="sizeSelector" class="form-select" aria-label="Select size">
                        <option value="XS">X-Small</option>
                        <option value="S">Small</option>
                        <option value="M" selected>Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">X-Large</option>
                        <option value="XXL">XX-Large</option>
                    </select>
                </div>
                <div class="preAddToBasket">
                    <?php 
                    //need gto do something here to check size with php - reckon send all to JS as below, then have a function deal with a switch.
                        echo '<button type="button" class="btn btn-outline-success" onclick="addToBasket('.$productInfoArray['prodID'].',`'.$productInfoArray['name'].'`,'.$productInfoArray['price'].',`'.$productImgsArray[0].'`, getPreBasket(), getSize(), setCorrectSizeID(getSize(), `'.$productInfoArray['sizeXS'].'`, `'.$productInfoArray['sizeS'].'`, `'.$productInfoArray['sizeM'].'`, `'.$productInfoArray['sizeL'].'`, `'.$productInfoArray['sizeXL'].'`, `'.$productInfoArray['sizeXXL'].'`))">Basket Diss</button>';
                        mysqli_close($conn);
                    ?>  
                    <br />
                    <br />
                </div>

            </div>
        </div>

    <!-- footer import was here -->
    <?php include_once "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>