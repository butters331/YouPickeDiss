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

    <?php
        include_once 'password.php';

        session_start();

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
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>
    <!-- code to include header menu-->
    <?php include_once 'headerAndMenu.php';?>
     
    <?php
    include_once 'dbConnect.php';
    $_SESSION['productID'] = $_GET['productID'];
    

    $prodID = $_SESSION['productID'];
    $productInfoSQL = 'SELECT * FROM Products WHERE prodID='.$prodID;
    $productImgsSQL = 'SELECT Path From ProductImgs Where prodID='.$prodID.' ORDER BY Priority ASC';
    $productInfo = mysqli_query($conn, $productInfoSQL);
    $productImgs = mysqli_query($conn, $productImgsSQL);
    $noOfImgs = mysqli_num_rows($productImgs);

    $productInfoArray = mysqli_fetch_assoc($productInfo);
    $completelyOutOfStock = $productInfoArray['stockXS'] == 0 && $productInfoArray['stockS'] == 0 && $productInfoArray['stockM'] == 0 && $productInfoArray['stockL'] == 0 && $productInfoArray['stockXL'] == 0 && $productInfoArray['stockXXL'] == 0 && $productInfoArray['stockXXXL'] == 0;
    ?>

    <script>fbq('track', 'ViewContent');</script>

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

                $firstImg = " ";
                for($count = 0; $count < $noOfImgs; $count++){
                    $productImgsArray = mysqli_fetch_array($productImgs,MYSQLI_NUM);
                    if ($count == 0){
                        $firstImg = $productImgsArray[0];
                        echo '
                    <div class="carousel-item active">';
                    }
                    else{
                        echo '
                        <div class="carousel-item">';
                    }
                    
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
                <div class="preAddToBasket">
                    <?php 
                        if (!$completelyOutOfStock){
                            if ($prodID == 5){
                                echo '<button type="button" id="productBasketDiss" class="btn btn-outline-success" onclick="addToBasket('.$productInfoArray['prodID'].',`'.$productInfoArray['name'].'`,'.$productInfoArray['price'].',`'.$firstImg.'`, getPreBasket(), `M`, setCorrectSizeID(`M`, `'.$productInfoArray['sizeXS'].'`, `'.$productInfoArray['sizeS'].'`, `'.$productInfoArray['sizeM'].'`, `'.$productInfoArray['sizeL'].'`, `'.$productInfoArray['sizeXL'].'`, `'.$productInfoArray['sizeXXL'].'`))">Basket Diss</button>';
                            }
                            else{
                                echo '<button type="button" id="productBasketDiss" class="btn btn-outline-success" onclick="addToBasket('.$productInfoArray['prodID'].',`'.$productInfoArray['name'].'`,'.$productInfoArray['price'].',`'.$firstImg.'`, getPreBasket(), getSize(), setCorrectSizeID(getSize(), `'.$productInfoArray['sizeXS'].'`, `'.$productInfoArray['sizeS'].'`, `'.$productInfoArray['sizeM'].'`, `'.$productInfoArray['sizeL'].'`, `'.$productInfoArray['sizeXL'].'`, `'.$productInfoArray['sizeXXL'].'`, `'.$productInfoArray['sizeXXXL'].'`))">Basket Diss</button>';
                            }
                        }
                        else {
                            echo '<button type="button" class="btn btn-outline-success">Sold Out</button>';
                        }
                    ?>  
                    <br />
                    <br />
                </div>
                <div id="stockLists" style="display: none;">
                    <?php
                        echo '['.$productInfoArray['stockXS'].','.$productInfoArray['stockS'].','.$productInfoArray['stockM'].','.$productInfoArray['stockL'].','.$productInfoArray['stockXL'].','.$productInfoArray['stockXXL'].','.$productInfoArray['stockXXXL'].']';
                    ?>
                </div>
                <div class="quantityButton">
                    <?php 
                        echo '<button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementPreBasket()">-</button><div id="productQuantity">  1  </div><button type="button" class="btn btn-outline-secondary btn-xs" id="incrementButton" onclick="incrementPreBasket()">+</button>';
                        mysqli_close($conn);
                    ?>

                </div>
                <br>

                <?php if($prodID != 5): ?>
                <div class="selectSize">
                    <select id="sizeSelector" class="form-select" aria-label="Select size" onChange="reEnableIncrement()">
                        <?php 
                            if($productInfoArray['stockXS'] <= 0){
                                echo '<option value="XS" disabled>X-Small - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="XS">X-Small</option>';
                            }
                            if($productInfoArray['stockS'] <= 0){
                                echo '<option value="S" disabled>Small - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="S">Small</option>';
                            }
                            if($productInfoArray['stockM'] <= 0){
                                echo '<option value="M" disabled>Medium - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="M">Medium</option>';
                            }
                            if($productInfoArray['stockL'] <= 0){
                                echo '<option value="L" disabled>Large - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="L">Large</option>';
                            }
                            if($productInfoArray['stockXL'] <= 0){
                                echo '<option value="XL" disabled>X-Large - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="XL">X-Large</option>';
                            }
                            if($productInfoArray['stockXXL'] <= 0){
                                echo '<option value="XXL" disabled>XX-Large - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="XXL">XX-Large</option>';
                            }
                            if($productInfoArray['stockXXXL'] <= 0){
                                echo '<option value="XXXL" disabled>XXX-Large - Out of Stock</option>';
                            }
                            else {
                                echo '<option value="XXXL">XXX-Large</option>';
                            }
                        ?>
                    </select>
                </div>
                <br>
                <?php endif; ?>
        

                <h1 class="pageFormat"><?php echo $productInfoArray['name'].' - '.$productInfoArray['Colour'];?></h1>
                <h4><?php echo '£'.$productInfoArray['price'].'<br>';?></h4>
                <p class="pageFormat">
                    <?php echo $productInfoArray['description'];?>
                    <!-- <br />
                    <br /> -->
                    
                </p>

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sizingModalPP">
                    Size Chart
                </button>
                <div class="modal fade" id="sizingModalPP" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-fullscreen-lg-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="Pictures\Products\SIZE CHART\0001.jpg" class="d-block w-100" alt="..." />
                                <img src="Pictures\Products\SIZE CHART\0002.jpg" class="d-block w-100" alt="..." />
                                <img src="Pictures\Products\SIZE CHART\0003.jpg" class="d-block w-100" alt="..." />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    <!-- footer import was here -->
    <?php include_once "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>