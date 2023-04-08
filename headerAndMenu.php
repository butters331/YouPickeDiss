<?php session_start();?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="cart.js"></script>
<script>
    window.onload = function(){
        populateBasket();
        const offCanvas = new bootstrap.Offcanvas(document.getElementById("basketOffcanvas"));
        if (localStorage.getItem("hidden") === null){
            localStorage.setItem("hidden", "true");
        }
        else {
            if (localStorage.getItem("hidden") === "true"){
                offCanvas.hide();
                console.log("hide")
            }
            else {
                offCanvas.show();
                console.log("show")
            }
        }
    }
    
</script>

<?php
    include_once 'dbConnect.php';
    include_once 'shippingVariables.php';
    require_once('../vendor/autoload.php');

    $basketData = null;
    $basket = null;

    $lineItemArray = [];
    $shippingOptions = 
    [
        [
            'shipping_rate_data' => 
            [
                'type' => 'fixed_amount',
                'fixed_amount' => ['amount' => $ukShipping, 'currency' => 'gbp'],
                'display_name' => 'UK Shipping',
                'delivery_estimate' => 
                [
                    'minimum' => ['unit' => 'week', 'value' => 4],
                    'maximum' => ['unit' => 'week', 'value' => 6],
                ],
            ],
        ],
        [
            'shipping_rate_data' => 
            [
                'type' => 'fixed_amount',
                'fixed_amount' => ['amount' => $EUshipping, 'currency' => 'gbp'],
                'display_name' => 'European Shipping',
                'delivery_estimate' => 
                [
                    'minimum' => ['unit' => 'week', 'value' => 4],
                    'maximum' => ['unit' => 'week', 'value' => 6],
                ],
            ],
            ],
        [
            'shipping_rate_data' => 
            [
                'type' => 'fixed_amount',
                'fixed_amount' => ['amount' => $RoWshipping, 'currency' => 'gbp'],
                'display_name' => 'Rest of the World Shipping',
                'delivery_estimate' => 
                [
                    'minimum' => ['unit' => 'week', 'value' => 4],
                    'maximum' => ['unit' => 'week', 'value' => 6],
                ],
            ],
        ],
    ];

    if(isset($_SESSION['basket'])){
        $basketData = json_decode($_SESSION['basket']);
        $basket = json_decode($basketData->basket);
        // var_dump($basket);
        $lineItemArray = [];
        $totalCostOfBasket = 0.0;
        
        for ($item = 0; $item < count($basket); $item++){
            // echo $basket[$item][6];
            $itemArray = [
                'price' => $basket[$item][6],
                'quantity' => $basket[$item][4],
            ];
            array_push($lineItemArray, $itemArray);
            $totalCostOfBasket += ($basket[$item][2] * $basket[$item][4]);
        }

        if ($totalCostOfBasket >= $freeOver){
            $shippingOptions = [
                [
                    'shipping_rate_data' => 
                    [
                        'type' => 'fixed_amount',
                        'fixed_amount' => ['amount' => 0, 'currency' => 'gbp'],
                        'display_name' => 'Free Shipping',
                        'delivery_estimate' => 
                        [
                            'minimum' => ['unit' => 'week', 'value' => 4],
                            'maximum' => ['unit' => 'week', 'value' => 6],
                        ],
                    ],
                ]
            ];
        }
        
    }
    else{
        $lineItemArray = [[
            'price' => 'price_1Mtpi3IJdJ7IL9xJDy8SoaYI',
            'quantity' => 1,
        ]];
    }

    \Stripe\Stripe::setApiKey($stripeKey);

    $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'shipping_address_collection' => ['allowed_countries' => $shippingCountries],
    'shipping_options' => $shippingOptions,
    'line_items' => $lineItemArray,
    'mode' => 'payment',
    'currency' => 'gbp',
    'success_url' => 'http://www.ypd4tp.co.uk/index.php?success=1',
    'cancel_url' => 'http://www.ypd4tp.co.uk/index.php',
    ]);

    ?>

    <div id="sessionIdDiv" style="display: none;">
        <?php
            echo $session->id;
        ?>
    </div>

    <!--logo import to top of page-->
    <div>
        <a href="index.php"><img class="logo" src="Pictures/ypd.png" alt="YouPickedDiss"></a>
    </div>
    
    <nav class="navbar sticky-top navbar-dark bg-dark">
        <div class="container">

            <div class="offcanvas offcanvas-start bg-dark justify-content-center" data-bs-scroll="true" tabindex="-1" id="navbarNav" data-bs-backdrop="false">
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
                            <a href="community.php" class="nav-link text-light" style="font-size: 20px;">
                                Community
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="message.php" class="nav-link text-light" style="font-size: 20px;">
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
            
            <a id="basketButton" class="btn basket navbar-toggler" type="button" href="#" onclick="toggleHidden()" data-bs-toggle="offcanvas" data-bs-target="#basketOffcanvas" aria-controls="basketOffcanvas">
                <i class="bi bi-bag-check-fill"></i>
            </a>

            <div class="offcanvas offcanvas-end bg-dark justify-content-center" data-bs-backdrop="static" tabindex="-1" id="basketOffcanvas" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header text-light">
                  <h5 id="offcanvasRightLabel">Basket</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" onclick="setHidden()" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body text-light">
                    <ul id="basketList" aria-labelledby="basketOffcanvas">
                    </ul>
                </div>
            </div>
        </div>
    </nav>    