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
    <?php include_once 'headerAndMenu.php';?>
     
    <script type="text/javascript" src="cart.js"></script>
    <script type="text/javascript" src="search.js"></script>

    <div class="container" style="height:100%;">
        <div id="topInfo">
            <h4>Shipping & Delivery</h4>
            <div id="shippingInfo">
                All orders are shipped via Royal Mail/DPD tracked delivery. Please bare with us as we prepare & pack your order, as a result we aim to have products shipped within 4-6 weeks.
                <br>We appreciate your patience and assure you the wait is worth it & over time this will improve so come along and join us on our journey.
                <br><br>YPD Community.
            </div>
        </div>
        <div id="bottomInfo" style="display: flex;">
            <div id="infoLeft">
                <h4>Returns</h4>
                <ul>
                    <li>All sales are final</li>
                    <li>No refunds, exchanges, or changes</li>
                    <li>Unless your item arrives damaged or faulty</li>
                </ul>
            </div>
            <div id="infoCentre">
                <h4>Care</h4>
                <ul>
                    <li>Machine wash cold</li>
                    <li>Do not tumble dry</li>
                    <li>Do not dry clean</li>
                </ul>
            </div>
            <div id="infoRight">
                <h4>Sizing</h4>
                Oversized fit <br>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sizingModal">
                    Size Chart
                </button>
                <div class="modal fade" id="sizingModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="Pictures/dummysizechart.jpg" class="d-block w-100" alt="..." />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding-top: 3em; text-align: center;">
            <h3>Made in the UK</h3>
        </div>
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