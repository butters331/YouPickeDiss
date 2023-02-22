<script src="https://js.stripe.com/v3/"></script>
<?php
    include_once 'dbConnect.php';
    require_once('../vendor/autoload.php');
    \Stripe\Stripe::setApiKey('sk_test_51MYzE2IJdJ7IL9xJVx14pBNJSJK9K77iKiylzPui332pQq4quld4POkl93KTgAKshleAj37wosUKWF74oCzjpHuu00cNf9HoOZ');

    $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
        'currency' => 'gbp',
        'product_data' => [
            'name' => '[DUMMY] Black Mens Hoodie',
        ],
        'unit_amount' => 2000,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://www.ypd4tp.co.uk/index.php',
    'cancel_url' => 'http://www.ypd4tp.co.uk/',
    ]);
    ?>

    <div id="sessionIdDiv" style="display: none;">
        <?php
            echo $session->id;
        ?>
    </div>

    <!--logo import to top of page-->
    <div>
        <a href="index.php"><img class="logo" src="Pictures/ypdName.png" alt="YouPickedDiss"></a>
    </div>
    
    <nav class="navbar sticky-top navbar-dark bg-dark">
        <div class="container">

            <div class="offcanvas offcanvas-start bg-dark justify-content-center" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="navbarNav">
                <div class="offcanvas-header">
                    <img id="navbarLogoL" src="Pictures/ypd.png" />
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body">
                    <ul>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link text-light" style="font-size: 20px;">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="products.php?category=0" class="nav-link text-light" style="font-size: 20px;">
                                New Releases
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-light" id="menDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="font-size: 20px;">
                                Shop
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="menDropdown" style="position:relative;">
                                <!-- <li>
                                    <a href="products.php?category=1" class="dropdown-item text-light" style="font-size: 20px;">T-Shirts</a>
                                </li> -->
                                <li>
                                    <a href="products.php?category=2" class="dropdown-item text-light" style="font-size: 20px;">Hoodies</a>
                                </li>
                                <li>
                                    <a href="products.php?category=3" class="dropdown-item text-light" style="font-size: 20px;">Joggers</a>
                                </li>
                                <!-- <li>
                                    <a href="products.php?category=4" class="dropdown-item text-light" style="font-size: 20px;">Shorts</a>
                                </li> -->
                            </ul>
                        </li>
                        <div>
                        <li class="nav-item">
                            <a href="archieves.php" class="nav-link text-light" style="font-size: 20px;">
                                Archives
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="message.html" class="nav-link text-light" style="font-size: 20px;">
                                Our Message
                            </a>
                        </li>
                        </div>
                    </ul>
                </div>
            </div>

            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" class="navbar-toggler"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="initialSearchButton">
                <a class="btn basket position-relative" href="#" role="button" id="searchDropdown" onclick="replaceSearchButton()">
                    <i class="bi bi-search"></i>
                </a>
            </div>
            
            <a id="basketButton" class="btn basket navbar-toggler" type="button" href="#" data-bs-toggle="offcanvas" data-bs-target="#basketOffcanvas" aria-controls="basketOffcanvas">
                <i class="bi bi-bag-check-fill"></i>
            </a>

            <div class="offcanvas offcanvas-end bg-dark justify-content-center" tabindex="-1" id="basketOffcanvas" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header text-light">
                  <h5 id="offcanvasRightLabel">Basket</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body text-light">
                    <ul id="basketList" aria-labelledby="basketOffcanvas">
                    </ul>
                </div>
            </div>

        </div>
    </nav>
    