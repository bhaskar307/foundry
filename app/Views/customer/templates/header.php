
<?php
    $uri = service('uri');
    $totalSegments = $uri->getTotalSegments();
    $lastSegment = $totalSegments > 0 ? $uri->getSegment($totalSegments) : null;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.2/swiper-bundle.css" rel="stylesheet">
    <link href="<?= base_url('assets/customer/css/custom.css') ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.2/swiper-bundle.min.js"></script>
    <script src="<?= base_url('assets/customer/js/custom.js') ?>"></script>
</head> 
<body>
    <header class="header pt-3 position-fixed top-0 start-0 w-100">
      <div class="container">
            <div class="headerBg p-3 rounded-10">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <a href="">
                        <img src="<?= base_url('assets/customer/images/logo.svg') ?>" alt="" width="141" height="36">
                    </a>
                    <nav class="d-none d-lg-block">
                        <ul class="mainMenu">
                            <li>
                                <a href="" class="active">Home</a>
                            </li>
                            <li>
                                <a href="">Shop</a>
                            </li>
                            <li>
                                <a href="">Podcast</a>
                            </li>
                            <li>
                                <a href="">Skool</a>
                            </li>
                            <li>
                                <a href="">Register</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="d-flex gap-4 align-items-center justify-content-end">
                        <button class="btn btn-primary h-auto">
                            <i>
                                <svg fill="#fff" width="16" height="16" viewBox="0 0 434 434" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M369.635 228.813C367.804 227.295 365.619 226.087 363.208 225.261C360.796 224.434 358.206 224.006 355.588 224C352.97 223.994 350.376 224.411 347.959 225.227C345.542 226.043 343.349 227.241 341.508 228.751C339.667 230.261 338.215 232.054 337.236 234.024C336.258 235.994 335.772 238.103 335.809 240.227C335.845 242.351 336.401 244.448 337.446 246.396C338.491 248.343 340.003 250.103 341.895 251.571C358.631 264.935 371.91 280.876 380.951 298.459C389.992 316.042 394.614 334.914 394.545 353.966C394.545 373.544 325.383 401.987 217 401.987C108.617 401.987 39.4553 373.53 39.4553 353.934C39.3889 335.013 43.9486 316.269 52.8705 298.787C61.7925 281.305 74.8994 265.432 91.4325 252.088C93.3025 250.609 94.7918 248.843 95.8141 246.893C96.8365 244.943 97.3714 242.848 97.388 240.729C97.4045 238.61 96.9023 236.509 95.9105 234.549C94.9187 232.588 93.4571 230.807 91.6104 229.309C89.7637 227.811 87.5686 226.625 85.1526 225.82C82.7366 225.015 80.1478 224.608 77.5362 224.621C74.9246 224.634 72.3422 225.069 69.939 225.898C67.5358 226.728 65.3595 227.936 63.5363 229.453C43.3243 245.767 27.3014 265.172 16.3955 286.545C5.48952 307.918 -0.0828713 330.834 0.000931352 353.966C0.000931352 405.95 111.795 434 217 434C322.205 434 433.999 405.95 433.999 353.966C434.087 330.678 428.438 307.611 417.385 286.119C406.332 264.626 390.098 245.143 369.635 228.813Z"/>
                                    <path d="M216.499 224C238.702 224 260.406 217.431 278.866 205.125C297.327 192.818 311.716 175.326 320.212 154.861C328.709 134.395 330.932 111.876 326.601 90.1499C322.269 68.4241 311.577 48.4676 295.878 32.8041C280.178 17.1406 260.176 6.47364 238.399 2.1521C216.623 -2.16945 194.052 0.0485277 173.539 8.52554C153.027 17.0026 135.494 31.3579 123.159 49.7762C110.824 68.1945 104.24 89.8485 104.24 112C104.275 141.694 116.113 170.161 137.158 191.158C158.203 212.155 186.737 223.966 216.499 224ZM216.499 32C232.358 32 247.861 36.692 261.047 45.4825C274.233 54.273 284.511 66.7673 290.58 81.3854C296.649 96.0035 298.237 112.089 295.143 127.607C292.049 143.126 284.412 157.38 273.198 168.569C261.984 179.757 247.696 187.376 232.142 190.463C216.588 193.55 200.465 191.965 185.814 185.91C171.162 179.855 158.639 169.602 149.828 156.446C141.017 143.29 136.314 127.823 136.314 112C136.339 90.7904 144.795 70.4566 159.827 55.4591C174.859 40.4616 195.24 32.025 216.499 32Z"/>
                                </svg>
                            </i>
                            <span>Sign in</span>
                        </button>
                        <button class="btnico d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffCanvas">
                            <svg fill="#fff" enable-background="new 0 0 512 512" height="26" viewBox="0 0 512 512" width="26" xmlns="http://www.w3.org/2000/svg"><path d="m128 102.4c0-14.138 11.462-25.6 25.6-25.6h332.8c14.138 0 25.6 11.462 25.6 25.6s-11.462 25.6-25.6 25.6h-332.8c-14.138 0-25.6-11.463-25.6-25.6zm358.4 128h-460.8c-14.138 0-25.6 11.463-25.6 25.6 0 14.138 11.462 25.6 25.6 25.6h460.8c14.138 0 25.6-11.462 25.6-25.6 0-14.137-11.462-25.6-25.6-25.6zm0 153.6h-230.4c-14.137 0-25.6 11.462-25.6 25.6 0 14.137 11.463 25.6 25.6 25.6h230.4c14.138 0 25.6-11.463 25.6-25.6 0-14.138-11.462-25.6-25.6-25.6z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php if (!empty($lastSegment)): ?>
        <div class="py-lg-5 py-4">
            <!-- Inner page content -->
        </div>
    <?php endif; ?>
