<section class="py-md-5 py-4">
    <div class="container">
        <div class="row g-4 gx-lg-5">
            <div class="col-md-6">
                <div class="zoom-wrapper-container">
                    <div style="--swiper-navigation-color: #000; --swiper-pagination-color: #000;" class="swiper product-main-slider">
                        <div class="swiper-wrapper">
                            <?php if(!empty($resp['image'])){
                                foreach($resp['images'] as $row){
                            ?>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url($row['image']) ?>"
                                    data-zoom="<?= base_url($row['image']) ?>" />
                            </div>
                            <?php } } ?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <!-- Thumbnail Slider -->
                <div class="swiper thumb-slider mt-3">
                    <div class="swiper-wrapper">
                        <?php if(!empty($resp['image'])){
                            foreach($resp['images'] as $row){
                            ?>
                        <div class="swiper-slide"><img src="<?= base_url($row['image']) ?>" width="100" height="100" /></div>
                        <?php } } ?>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/drift-basic.min.css" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/Drift.min.js"></script>
                <script>
                    let drift;

                    const thumbSwiper = new Swiper(".thumb-slider", {
                        spaceBetween: 10,
                        slidesPerView: 3,
                        freeMode: true,
                        watchSlidesProgress: true,
                        breakpoints: {
                            640: { slidesPerView: 3 },
                            768: { slidesPerView: 4 },
                            1024: { slidesPerView: 5 },
                        },
                    });

                    const mainSwiper = new Swiper(".product-main-slider", {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        thumbs: {
                            swiper: thumbSwiper,
                        },
                        on: {
                            init: function () {
                                initDriftZoom();
                            },
                            slideChangeTransitionEnd: function () {
                                setTimeout(() => {
                                    initDriftZoom();
                                }, 100);
                            }
                        }
                    });

                    function initDriftZoom() {
                        // Remove old zoom pane if it exists
                        const oldPane = document.querySelector(".drift-zoom-pane");
                        if (oldPane) oldPane.remove();

                        // Select new active image
                        const activeImage = document.querySelector(".product-main-slider .swiper-slide-active .drift-img");
                        const paneContainer = document.querySelector(".zoom-wrapper-container");

                        if (activeImage && paneContainer) {
                            // Recreate new Drift instance
                            drift = new Drift(activeImage, {
                                paneContainer: paneContainer,
                                inlinePane: 768,
                                zoomFactor: 2,
                                containInline: true,
                            });
                        }
                    }
                </script>
            </div>
            <div class="col-md-6">
                <div class="stkysec position-sticky" style="top: 100px;">
                    <h1 class="h2 mb-2"><?= $resp['name']; ?></h1>
                    <div class="mb-2 d-flex items-center gap-2">
                        <?php
                            $rating = $resp['total_rating_percent']; 
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                            $starSvg = function($fill) {
                                $color = match($fill) {
                                    'full' => '#F6AB27',
                                    'half' => 'url(#halfGradient)',
                                    'empty' => '#E0E0E0',
                                };
                                return <<<SVG
                            <svg width="16" height="16" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <defs> <linearGradient id="halfGradient"> <stop offset="50%" stop-color="#F6AB27"/> <stop offset="50%" stop-color="#E0E0E0"/> </linearGradient></defs>
                            <path d="M50 5L61 35H95L67 57L78 90L50 70L22 90L33 57L5 35H39L50 5Z" fill="$color"/>
                            </svg>
                            SVG;
                            };
                        ?>
                            <i style="display: flex; gap: 2px; line-height: 0;">
                                <?php
                                for ($i = 0; $i < $fullStars; $i++) echo $starSvg('full');
                                if ($halfStar) echo $starSvg('half');
                                for ($i = 0; $i < $emptyStars; $i++) echo $starSvg('empty');
                                ?>
                            </i>
                        <small style="color: #666;"><?= $resp['total_rating_percent'] ?> (<?= $resp['total_customer_review'] ?> reviews)</small>
                    </div>
                    <p><?= $resp['description']; ?></p>
                    <?php if(!empty($resp['brand'])){ ?>
                    <div class="p-3 rounded-10 border d-flex align-items-center gap-3 mb-3">
                        
                        <i style="line-height: 0;">
                            <img src="<?= base_url('assets/customer/images/ener.webp') ?>" class="rounded-10 object-fit-cover" width="80" height="80">
                        </i>
                        <div>
                            
                            <div class="d-flex align-items-center gap-1">
                                <h5 class="m-0"><?= $resp['brand'] ?></h5>
                                <button type="button" class="btnico" data-bs-toggle="popover" data-bs-title="Popover title" data-bs-content="And here’s some amazing content. It’s very engaging. Right?">
                                    <svg width="18" height="18" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 21C16.299 21 21 16.299 21 10.5C21 4.70108 16.299 0 10.5 0C4.70098 0 0 4.70103 0 10.5C0 16.299 4.70098 21 10.5 21ZM10.5 2.10002C15.1318 2.10002 18.9 5.86825 18.9 10.5C18.9 15.1318 15.1318 18.9 10.5 18.9C5.8682 18.9 2.10002 15.1318 2.10002 10.5C2.10002 5.86825 5.8682 2.10002 10.5 2.10002ZM9.1852 14.7C9.1852 13.9387 9.7395 13.3875 10.4893 13.3875C11.2695 13.3875 11.8102 13.9387 11.8102 14.7146C11.8102 15.4602 11.2549 16.0125 10.4893 16.0125C9.7395 16.0125 9.1852 15.4602 9.1852 14.7ZM11.5477 11.55H9.44773V5.25001H11.5477V11.55Z" fill="#1F58BD"/>
                                    </svg>
                                </button>
                            </div>
                            <small class="d-block mb-1">Detroit, Michigan, USA</small>
                            
                            <!-- <div class="d-flex items-center gap-2">
                                <i style="line-height: 0;">
                                    <svg width="100" height="16" viewBox="0 0 100 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.03371 15.8625L4.32255 9.99755L0 6.05281L5.71052 5.531L7.93128 0L10.152 5.531L15.8626 6.05281L11.54 9.99755L12.8288 15.8625L7.93128 12.7526L3.03371 15.8625Z" fill="#F6AB27"/>
                                        <path d="M24.1839 15.8625L25.4727 9.99755L21.1501 6.05281L26.8607 5.531L29.0814 0L31.3022 5.531L37.0127 6.05281L32.6902 9.99755L33.979 15.8625L29.0814 12.7526L24.1839 15.8625Z" fill="#F6AB27"/>
                                        <path d="M45.3335 15.8625L46.6224 9.99755L42.2998 6.05281L48.0103 5.531L50.2311 0L52.4518 5.531L58.1624 6.05281L53.8398 9.99755L55.1286 15.8625L50.2311 12.7526L45.3335 15.8625Z" fill="#F6AB27"/>
                                        <path d="M66.4839 15.8625L67.7727 9.99755L63.4502 6.05281L69.1607 5.531L71.3815 0L73.6022 5.531L79.3128 6.05281L74.9902 9.99755L76.279 15.8625L71.3815 12.7526L66.4839 15.8625Z" fill="#F6AB27"/>
                                        <path d="M87.1712 15.8625L88.46 9.99755L84.1375 6.05281L89.848 5.531L92.0687 0L94.2895 5.531L100 6.05281L95.6775 9.99755L96.9663 15.8625L92.0687 12.7526L87.1712 15.8625Z" fill="#F6AB27"/>
                                    </svg>
                                </i>
                                <span style="color:#666">(4.2) 12 Reviews</span>
                            </div> -->
                        </div>
                        
                    </div>
                    <?php } ?>
                    <div class="d-flex gap-3">
                        <button class="btn btn-primary d-inline-flex gap-2" data-bs-toggle="modal" data-bs-target="#requestAQuote">
                            <i style="line-height: 0;">
                                <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.9273 14.1883L9.73663 11.7164C9.48038 11.1883 9.14913 10.8039 8.57725 11.0383L7.44913 11.457C6.546 11.8758 6.096 11.457 5.64288 10.8258L3.61163 6.2039C3.35538 5.67577 3.48975 5.17889 4.06163 4.94452L5.63975 4.31327C6.21163 4.07577 6.121 3.58202 5.86475 3.05389L4.51163 0.535145C4.25538 0.00702 3.73038 -0.121105 3.1585 0.11327C2.01475 0.585145 1.06788 1.32577 0.452254 2.42265C-0.297746 3.76327 0.0772543 5.62889 0.227254 6.41327C0.377254 7.19765 0.902254 8.57265 1.58038 9.98202C2.2585 11.3945 2.85225 12.5039 3.38663 13.132C3.91788 13.7601 5.19288 15.4789 6.771 15.8633C8.06475 16.1758 9.46163 15.9133 10.6054 15.4414C11.1804 15.2164 11.1804 14.7195 10.9273 14.1883Z" fill="white"/>
                                </svg>
                            </i>
                            <span>Request A Quote</span>
                        </button>
                        <button class="btn bg-white text-dark d-inline-flex gap-2 border">
                            <i style="line-height: 0;">
                                <svg width="16" height="16" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0889 8.15V1C10.0889 0.734784 9.9835 0.48043 9.79597 0.292893C9.60843 0.105357 9.35408 0 9.08886 0C8.82364 0 8.56929 0.105357 8.38175 0.292893C8.19422 0.48043 8.08886 0.734784 8.08886 1V8.15L5.86886 5.374C5.78841 5.2669 5.68725 5.17706 5.57141 5.10981C5.45557 5.04256 5.32739 4.99926 5.1945 4.9825C5.0616 4.96573 4.92669 4.97584 4.79777 5.01221C4.66886 5.04859 4.54856 5.11049 4.44403 5.19425C4.3395 5.27801 4.25286 5.38192 4.18926 5.49981C4.12565 5.61769 4.08638 5.74716 4.07378 5.88051C4.06117 6.01387 4.07548 6.1484 4.11586 6.27611C4.15625 6.40383 4.22188 6.52213 4.30886 6.624L8.30886 11.624C8.40256 11.7408 8.5213 11.8351 8.6563 11.8998C8.7913 11.9646 8.93913 11.9982 9.08886 11.9982C9.2386 11.9982 9.38642 11.9646 9.52142 11.8998C9.65643 11.8351 9.77516 11.7408 9.86886 11.624L13.8689 6.624C13.9558 6.52213 14.0215 6.40383 14.0619 6.27611C14.1022 6.1484 14.1166 6.01387 14.1039 5.88051C14.0913 5.74716 14.0521 5.61769 13.9885 5.49981C13.9249 5.38192 13.8382 5.27801 13.7337 5.19425C13.6292 5.11049 13.5089 5.04859 13.3799 5.01221C13.251 4.97584 13.1161 4.96573 12.9832 4.9825C12.8503 4.99926 12.7222 5.04256 12.6063 5.10981C12.4905 5.17706 12.3893 5.2669 12.3089 5.374L10.0889 8.15Z" fill="#4B4D56"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.74587 12.874L4.44687 10H2.08887C1.55843 10 1.04973 10.2107 0.674654 10.5858C0.299581 10.9609 0.0888672 11.4696 0.0888672 12V16C0.0888672 16.5304 0.299581 17.0391 0.674654 17.4142C1.04973 17.7893 1.55843 18 2.08887 18H16.0889C16.6193 18 17.128 17.7893 17.5031 17.4142C17.8782 17.0391 18.0889 16.5304 18.0889 16V12C18.0889 11.4696 17.8782 10.9609 17.5031 10.5858C17.128 10.2107 16.6193 10 16.0889 10H13.7309L11.4309 12.874C11.1498 13.2253 10.7933 13.5089 10.3879 13.7037C9.98237 13.8986 9.53825 13.9998 9.08837 13.9998C8.63849 13.9998 8.19436 13.8986 7.78888 13.7037C7.38339 13.5089 7.02693 13.2253 6.74587 12.874ZM14.0889 13C13.8237 13 13.5693 13.1054 13.3818 13.2929C13.1942 13.4804 13.0889 13.7348 13.0889 14C13.0889 14.2652 13.1942 14.5196 13.3818 14.7071C13.5693 14.8946 13.8237 15 14.0889 15H14.0989C14.3641 15 14.6184 14.8946 14.806 14.7071C14.9935 14.5196 15.0989 14.2652 15.0989 14C15.0989 13.7348 14.9935 13.4804 14.806 13.2929C14.6184 13.1054 14.3641 13 14.0989 13H14.0889Z" fill="#4B4D56"/>
                                </svg>
                            </i>
                            <span>Download Brochure</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card text-bg-dark m-0">
                    <h5 class="card-header">Product Description</h5>
                    <div class="card-body listStyle">
                        <?= $resp['html_description']; ?>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card text-bg-dark m-0 fadeUp">
                    <h5 class="card-header">Customer Reviews</h5>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3 mb-4">
                            <?php if(!empty($reviews)){
                                foreach($reviews as $row){
                                ?>
                            <div class="bg-light p-3 rounded-10">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <i style="line-height: 0;">
                                            <img src="<?= base_url($row['customer_image']) ?>" alt="" class="rounded-circle" height="60" width="60">
                                        </i>
                                        <div class="">
                                            <strong class="d-block"><?= $row['customer_name'] ?></strong>
                                            <?php
                                                $rating = $row['rating']; 
                                                $fullStars = floor($rating);
                                                $halfStar = ($rating - $fullStars) >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                                                $starSvg = function($fill) {
                                                    $color = match($fill) {
                                                        'full' => '#F6AB27',
                                                        'half' => 'url(#halfGradient)',
                                                        'empty' => '#E0E0E0',
                                                    };
                                                    return <<<SVG
                                                <svg width="16" height="16" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <defs> <linearGradient id="halfGradient"> <stop offset="50%" stop-color="#F6AB27"/> <stop offset="50%" stop-color="#E0E0E0"/> </linearGradient></defs>
                                                <path d="M50 5L61 35H95L67 57L78 90L50 70L22 90L33 57L5 35H39L50 5Z" fill="$color"/>
                                                </svg>
                                                SVG;
                                                };
                                            ?>
                                                <i style="display: flex; gap: 2px; line-height: 0;">
                                                    <?php
                                                    for ($i = 0; $i < $fullStars; $i++) echo $starSvg('full');
                                                    if ($halfStar) echo $starSvg('half');
                                                    for ($i = 0; $i < $emptyStars; $i++) echo $starSvg('empty');
                                                    ?>
                                                </i>
                                        </div>
                                    </div>
                                    <small>2 Weeks ago</small>
                                </div>
                                <div><?= $row['review'] ?></div>
                            </div>
                            <?php } } ?>
                        </div>
                        <div class="text-center fadeUp">
                            <button class="btn btn-primary d-inline-flex gap-2"  data-bs-toggle="modal" data-bs-target="#giveReviewModal">
                                <span>Sign in to leave a Review</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h2 class="mb-3">You Might Also Like</h2>
                <div class="px-3 position-relative fadeUp">
                    <div class="swiper slide4">
                        <div class="swiper-wrapper">
                            <?php if(!empty($product)){ 
                            foreach($product as $row){
                                if($row['uid'] == $resp['uid']){
                                    continue;
                                }
                            ?>
                            <div class="swiper-slide">
                                <a href="<?= base_url('product-details/'.$row['uid']) ?>" class="h-100 rounded-10 border bg-white overflow-hidden d-block">
                                    <img src="<?= base_url($row['image']) ?>" alt="" class="w-100 object-fit-cover" style="height:250px;">
                                    <div class="p-lg-3 p-2">
                                        <h5 class="mb-1" style="height:50px;">
                                            <?= substr(strip_tags($row['name']), 0, 40) ?><?= strlen(strip_tags($row['name'])) > 40 ? '...' : '' ?>
                                        </h5>
                                        <small class="d-flex align-items-center gap-1">
                                            <span class="fw-600">Verified</span>
                                            <i style="line-height: 0;">
                                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69883 1.04935C9.56974 0.843073 9.37955 0.682175 9.15473 0.589057C8.92992 0.495939 8.68167 0.475233 8.44454 0.529821L6.76156 0.916427C6.58908 0.956072 6.40986 0.956072 6.23739 0.916427L4.5544 0.529821C4.31727 0.475233 4.06902 0.495939 3.84421 0.589057C3.6194 0.682175 3.42921 0.843073 3.30012 1.04935L2.38281 2.5134C2.28921 2.66317 2.16284 2.78955 2.01308 2.88409L0.549128 3.80146C0.343218 3.93044 0.182567 4.12034 0.0894753 4.34478C-0.00361686 4.56922 -0.0245326 4.81708 0.0296313 5.05395L0.416212 6.73891C0.455711 6.9111 0.455711 7.09 0.416212 7.26219L0.0296313 8.94621C-0.0247431 9.18322 -0.00393263 9.43128 0.0891696 9.65592C0.182272 9.88055 0.34304 10.0706 0.549128 10.1996L2.01308 11.117C2.16284 11.2106 2.28921 11.337 2.38375 11.4868L3.30106 12.9508C3.56502 13.373 4.0686 13.5817 4.5544 13.4703L6.23739 13.0837C6.40986 13.0441 6.58908 13.0441 6.76156 13.0837L8.44548 13.4703C8.68247 13.5247 8.93052 13.5039 9.15514 13.4108C9.37976 13.3177 9.56979 13.1569 9.69883 12.9508L10.6161 11.4868C10.7097 11.337 10.8361 11.2106 10.9859 11.117L12.4508 10.1996C12.6569 10.0704 12.8175 9.88015 12.9105 9.65534C13.0034 9.43052 13.024 9.18233 12.9693 8.94528L12.5837 7.26219C12.544 7.0897 12.544 6.91046 12.5837 6.73798L12.9703 5.05395C13.0247 4.81704 13.004 4.56905 12.9111 4.34442C12.8182 4.1198 12.6576 3.9297 12.4517 3.80052L10.9868 2.88315C10.8372 2.78937 10.7108 2.66296 10.6171 2.5134L9.69883 1.04935ZM9.228 4.9126C9.2859 4.80613 9.30024 4.68136 9.26802 4.56453C9.23579 4.44771 9.15951 4.34793 9.05523 4.28621C8.95094 4.22448 8.82678 4.20561 8.70887 4.23358C8.59096 4.26154 8.48849 4.33415 8.42302 4.43613L5.9753 8.57927L4.4973 7.1639C4.45346 7.11887 4.40099 7.08314 4.34304 7.05883C4.28508 7.03452 4.22283 7.02214 4.15998 7.02241C4.09714 7.02269 4.03499 7.03562 3.97725 7.06043C3.91951 7.08524 3.86736 7.12143 3.82391 7.16683C3.78045 7.21224 3.74659 7.26593 3.72434 7.32471C3.70208 7.38348 3.69189 7.44614 3.69437 7.50894C3.69686 7.57174 3.71196 7.6334 3.73878 7.69023C3.76561 7.74707 3.80361 7.79792 3.85051 7.83976L5.75439 9.6642C5.80535 9.71292 5.86665 9.74951 5.93373 9.77122C6.00081 9.79292 6.07192 9.7992 6.14176 9.78957C6.21161 9.77994 6.27837 9.75465 6.33707 9.7156C6.39577 9.67655 6.44488 9.62473 6.48075 9.56403L9.228 4.9126Z" fill="#3A9F6C"/>
                                                </svg>
                                            </i>
                                        </small>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <i style="line-height: 0;">                           
                                                <svg width="71" height="11" viewBox="0 0 71 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.49975 8.87749L3.07605 10.4062C2.96898 10.4776 2.85705 10.5081 2.74024 10.498C2.62344 10.4878 2.52123 10.447 2.43363 10.3757C2.34603 10.3043 2.27789 10.2152 2.22922 10.1084C2.18055 10.0016 2.17082 9.88177 2.20002 9.74887L2.84244 6.85956L0.696159 4.91806C0.598822 4.82633 0.538084 4.72177 0.513944 4.60436C0.489804 4.48695 0.497007 4.3724 0.535553 4.2607C0.574098 4.149 0.632501 4.05727 0.71076 3.98553C0.789019 3.91378 0.89609 3.86791 1.03197 3.84794L3.86449 3.58805L4.95953 0.866897C5.0082 0.744598 5.08373 0.652874 5.18613 0.591724C5.28853 0.530575 5.39307 0.5 5.49975 0.5C5.60643 0.5 5.71097 0.530575 5.81337 0.591724C5.91577 0.652874 5.9913 0.744598 6.03997 0.866897L7.13502 3.58805L9.96753 3.84794C10.1038 3.86832 10.2109 3.91418 10.2887 3.98553C10.3666 4.05687 10.425 4.14859 10.4639 4.2607C10.5029 4.37281 10.5103 4.48756 10.4861 4.60497C10.462 4.72238 10.4011 4.82674 10.3033 4.91806L8.15706 6.85956L8.79948 9.74887C8.82868 9.88136 8.81895 10.0012 8.77028 10.1084C8.72161 10.2156 8.65348 10.3047 8.56587 10.3757C8.47827 10.4466 8.37607 10.4874 8.25926 10.498C8.14246 10.5086 8.03052 10.478 7.92345 10.4062L5.49975 8.87749Z" fill="#EEA723"/>
                                                <path d="M20.4998 8.87749L18.0761 10.4062C17.969 10.4776 17.857 10.5081 17.7402 10.498C17.6234 10.4878 17.5212 10.447 17.4336 10.3757C17.346 10.3043 17.2779 10.2152 17.2292 10.1084C17.1806 10.0016 17.1708 9.88177 17.2 9.74887L17.8424 6.85956L15.6962 4.91806C15.5988 4.82633 15.5381 4.72177 15.5139 4.60436C15.4898 4.48695 15.497 4.3724 15.5356 4.2607C15.5741 4.149 15.6325 4.05727 15.7108 3.98552C15.789 3.91378 15.8961 3.86791 16.032 3.84794L18.8645 3.58805L19.9595 0.866897C20.0082 0.744598 20.0837 0.652874 20.1861 0.591724C20.2885 0.530575 20.3931 0.5 20.4998 0.5C20.6064 0.5 20.711 0.530575 20.8134 0.591724C20.9158 0.652874 20.9913 0.744598 21.04 0.866897L22.135 3.58805L24.9675 3.84794C25.1038 3.86832 25.2109 3.91418 25.2887 3.98552C25.3666 4.05687 25.425 4.14859 25.4639 4.2607C25.5029 4.37281 25.5103 4.48756 25.4861 4.60497C25.462 4.72238 25.4011 4.82674 25.3033 4.91806L23.1571 6.85956L23.7995 9.74887C23.8287 9.88136 23.819 10.0012 23.7703 10.1084C23.7216 10.2156 23.6535 10.3047 23.5659 10.3757C23.4783 10.4466 23.3761 10.4874 23.2593 10.498C23.1425 10.5086 23.0305 10.478 22.9234 10.4062L20.4998 8.87749Z" fill="#EEA723"/>
                                                <path d="M35.4998 8.87749L33.0761 10.4062C32.969 10.4776 32.857 10.5081 32.7402 10.498C32.6234 10.4878 32.5212 10.447 32.4336 10.3757C32.346 10.3043 32.2779 10.2152 32.2292 10.1084C32.1806 10.0016 32.1708 9.88177 32.2 9.74887L32.8424 6.85956L30.6962 4.91806C30.5988 4.82633 30.5381 4.72177 30.5139 4.60436C30.4898 4.48695 30.497 4.3724 30.5356 4.2607C30.5741 4.149 30.6325 4.05727 30.7108 3.98553C30.789 3.91378 30.8961 3.86791 31.032 3.84794L33.8645 3.58805L34.9595 0.866897C35.0082 0.744598 35.0837 0.652874 35.1861 0.591724C35.2885 0.530575 35.3931 0.5 35.4998 0.5C35.6064 0.5 35.711 0.530575 35.8134 0.591724C35.9158 0.652874 35.9913 0.744598 36.04 0.866897L37.135 3.58805L39.9675 3.84794C40.1038 3.86832 40.2109 3.91418 40.2887 3.98553C40.3666 4.05687 40.425 4.14859 40.4639 4.2607C40.5029 4.37281 40.5103 4.48756 40.4861 4.60497C40.462 4.72238 40.4011 4.82674 40.3033 4.91806L38.1571 6.85956L38.7995 9.74887C38.8287 9.88136 38.819 10.0012 38.7703 10.1084C38.7216 10.2156 38.6535 10.3047 38.5659 10.3757C38.4783 10.4466 38.3761 10.4874 38.2593 10.498C38.1425 10.5086 38.0305 10.478 37.9234 10.4062L35.4998 8.87749Z" fill="#EEA723"/>
                                                <path d="M50.4998 8.87749L48.0761 10.4062C47.969 10.4776 47.857 10.5081 47.7402 10.498C47.6234 10.4878 47.5212 10.447 47.4336 10.3757C47.346 10.3043 47.2779 10.2152 47.2292 10.1084C47.1806 10.0016 47.1708 9.88177 47.2 9.74887L47.8424 6.85956L45.6962 4.91806C45.5988 4.82633 45.5381 4.72177 45.5139 4.60436C45.4898 4.48695 45.497 4.3724 45.5356 4.2607C45.5741 4.149 45.6325 4.05727 45.7108 3.98553C45.789 3.91378 45.8961 3.86791 46.032 3.84794L48.8645 3.58805L49.9595 0.866897C50.0082 0.744598 50.0837 0.652874 50.1861 0.591724C50.2885 0.530575 50.3931 0.5 50.4998 0.5C50.6064 0.5 50.711 0.530575 50.8134 0.591724C50.9158 0.652874 50.9913 0.744598 51.04 0.866897L52.135 3.58805L54.9675 3.84794C55.1038 3.86832 55.2109 3.91418 55.2887 3.98553C55.3666 4.05687 55.425 4.14859 55.4639 4.2607C55.5029 4.37281 55.5103 4.48756 55.4861 4.60497C55.462 4.72238 55.4011 4.82674 55.3033 4.91806L53.1571 6.85956L53.7995 9.74887C53.8287 9.88136 53.819 10.0012 53.7703 10.1084C53.7216 10.2156 53.6535 10.3047 53.5659 10.3757C53.4783 10.4466 53.3761 10.4874 53.2593 10.498C53.1425 10.5086 53.0305 10.478 52.9234 10.4062L50.4998 8.87749Z" fill="#EEA723"/>
                                                <path d="M63.1921 9.3186L65.4999 7.85666L67.8077 9.33784L67.2033 6.56784L69.2364 4.72117L66.5623 4.4711L65.4999 1.85499L64.4376 4.45187L61.7635 4.70193L63.7966 6.56784L63.1921 9.3186ZM65.4999 8.76229L62.8405 10.4489C62.7623 10.4894 62.6898 10.5059 62.6229 10.4982C62.5565 10.49 62.4917 10.4658 62.4287 10.4258C62.3652 10.3848 62.3174 10.3268 62.2851 10.2519C62.2529 10.177 62.25 10.0952 62.2764 10.0065L62.9841 6.84407L60.6433 4.71271C60.5774 4.65628 60.5339 4.58883 60.5129 4.51034C60.4919 4.43186 60.4965 4.35671 60.5268 4.2849C60.5571 4.21308 60.5974 4.15409 60.6477 4.10792C60.6985 4.0633 60.7669 4.03303 60.8528 4.01713L63.9416 3.73397L65.1461 0.739297C65.1793 0.654659 65.2272 0.593616 65.2897 0.556169C65.3522 0.518723 65.4223 0.5 65.4999 0.5C65.5776 0.5 65.6479 0.518723 65.7109 0.556169C65.7739 0.593616 65.8216 0.654659 65.8538 0.739297L67.0582 3.73397L70.1463 4.01713C70.2328 4.03252 70.3014 4.06304 70.3522 4.10869C70.403 4.15383 70.4435 4.21257 70.4738 4.2849C70.5036 4.35671 70.508 4.43186 70.487 4.51034C70.466 4.58883 70.4225 4.65628 70.3566 4.71271L68.0158 6.84407L68.7235 10.0065C68.7509 10.0942 68.7482 10.1758 68.7155 10.2512C68.6827 10.3266 68.6346 10.3845 68.5711 10.4251C68.5086 10.4661 68.4439 10.4905 68.377 10.4982C68.3106 10.5059 68.2383 10.4894 68.1601 10.4489L65.4999 8.76229Z" fill="#EEA723"/>
                                                </svg>
                                            </i>
                                            <small style="color: #666;">4.2 (24 reviews)</small>
                                        </div>
                                        <div class="my-1" style="color: #666;">
                                            <?= substr(strip_tags($row['description']), 0, 95) ?><?= strlen(strip_tags($row['description'])) > 95 ? '...' : '' ?>
                                        </div>
                                        <!-- <div class="text-dark fw-600">Enerzi Microwave India Pvt. Ltd.</div> -->
                                    </div>
                                </a>
                            </div>
                            <?php } } ?>       
                        </div>
                    </div>
                    <div class="slide4Swiper-button-next position-absolute top-50 translate-middle-y end-0" style="z-index: 1;">
                        <svg width="40" height="40" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_126_1253)">
                            <rect x="4" y="3" width="44" height="44" rx="10" fill="white"/>
                            <path d="M34.2148 25L34.6079 24.5822L35 25L34.6079 25.4178L34.2148 25ZM17.5553 25.5902C17.408 25.5902 17.2668 25.528 17.1626 25.4173C17.0585 25.3066 17 25.1565 17 25C17 24.8435 17.0585 24.6934 17.1626 24.5827C17.2668 24.472 17.408 24.4098 17.5553 24.4098V25.5902ZM27.9442 17.5L34.6079 24.5822L33.8216 25.4178L27.1578 18.3357L27.9442 17.5ZM34.6079 25.4178L27.9442 32.5L27.1578 31.6643L33.8216 24.5822L34.6079 25.4178ZM34.2148 25.5902H17.5553V24.4098H34.2148V25.5902Z" fill="#1C2730"/>
                            </g>
                            <defs>
                            <filter id="filter0_dd_126_1253" x="0" y="0" width="52" height="52" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feMorphology radius="1" operator="dilate" in="SourceAlpha" result="effect1_dropShadow_126_1253"/>
                            <feOffset dy="1"/>
                            <feGaussianBlur stdDeviation="1.5"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_126_1253"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="1"/>
                            <feGaussianBlur stdDeviation="1"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0"/>
                            <feBlend mode="normal" in2="effect1_dropShadow_126_1253" result="effect2_dropShadow_126_1253"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_126_1253" result="shape"/>
                            </filter>
                            </defs>
                        </svg>
                    </div>
                    <div class="slide4Swiper-button-prev position-absolute top-50 translate-middle-y start-0" style="z-index: 1;">
                        <svg width="40" height="40" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_126_1251)">
                            <rect x="48" y="47" width="44" height="44" rx="10" transform="rotate(-180 48 47)" fill="white"/>
                            <path d="M17.7852 25L17.3921 25.4178L17 25L17.3921 24.5822L17.7852 25ZM34.4447 24.4098C34.592 24.4098 34.7332 24.472 34.8374 24.5827C34.9415 24.6934 35 24.8435 35 25C35 25.1565 34.9415 25.3066 34.8374 25.4173C34.7332 25.528 34.592 25.5902 34.4447 25.5902V24.4098ZM24.0558 32.5L17.3921 25.4178L18.1784 24.5822L24.8422 31.6643L24.0558 32.5ZM17.3921 24.5822L24.0558 17.5L24.8422 18.3357L18.1784 25.4178L17.3921 24.5822ZM17.7852 24.4098H34.4447V25.5902H17.7852V24.4098Z" fill="#1C2730"/>
                            </g>
                            <defs>
                            <filter id="filter0_dd_126_1251" x="0" y="0" width="52" height="52" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feMorphology radius="1" operator="dilate" in="SourceAlpha" result="effect1_dropShadow_126_1251"/>
                            <feOffset dy="1"/>
                            <feGaussianBlur stdDeviation="1.5"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_126_1251"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="1"/>
                            <feGaussianBlur stdDeviation="1"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.3 0"/>
                            <feBlend mode="normal" in2="effect1_dropShadow_126_1251" result="effect2_dropShadow_126_1251"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_126_1251" result="shape"/>
                            </filter>
                            </defs>
                        </svg>
                    </div>
                </div>
                
                <script>
                    var swiper = new Swiper(".slide4", {
                        slidesPerView: 1,
                        loop: true,
                        navigation: {
                            nextEl: ".slide4Swiper-button-next",
                            prevEl: ".slide4Swiper-button-prev",
                        },
                        breakpoints: {
                        640: {
                            slidesPerView: 1,
                            spaceBetween: 10,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                        },
                    }); 
                </script>
            </div>
        </div>
    </div>
</section>

<!--=================Request A Quote Modal=================-->
<?php if(!empty($customerDetails)){ ?>
<div class="modal fade" id="requestAQuote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="#" method="post" class="modal-content" onsubmit="submitQuote(event)">
            <div class="modal-header">
                <h5 class="modal-title">Request A Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-3">
                    <div>Please fill out the form below and our team will get back to you with a customized quote tailored to your needs.</div>
                    <input type='hidden' name="productId" id="productId" value="<?= $resp['uid'] ?>">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Name*" value="<?php if(!empty($customerDetails)){ echo $customerDetails['name']; } ?>" readonly>
                    </div>
                    <div class="position-relative">
                        <input type="email" class="form-control" placeholder="Email id*" value="<?php if(!empty($customerDetails)){ echo $customerDetails['email']; } ?>" readonly>
                    </div>
                    <div class="position-relative">
                        <input type="tel" class="form-control" placeholder="Phone Number*" value="<?php if(!empty($customerDetails)){ echo $customerDetails['phone']; } ?>" readonly>
                    </div>
                    <div class="position-relative">
                        <textarea class="form-control" rows="3" placeholder="Message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100 justify-content-center">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php }else{ ?>
<div class="modal fade" id="requestAQuote" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content review-form">
            <div class="modal-header">
                <h5 class="modal-title">Give Your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Actual review form -->
                <div id="loginFirst">
                    Please login first to submit a review.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100 justify-content-center" onclick="openLoginModal1()">OK</button>
            </div>
        </form>
    </div>
</div>

<?php } ?>
<!--=================Leave a Review Modal=================-->

<?php if(!empty($customerDetails)){ ?>
<div class="modal fade" id="giveReviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content review-form" onsubmit="submitReview(event)">
            <div class="modal-header">
                <h5 class="modal-title">Leave a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type='hidden' name="productUid" id="productUid" value="<?= $resp['uid'] ?>">
                <div class="d-flex flex-column gap-3">
                    <div class="position-relative">
                        <div class="star-rating">
                            <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                            <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                            <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                            <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                            <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
                        </div>
                        <div id="rating-error" class="text-danger small mt-1"></div>
                    </div>

                    <div class="position-relative">
                        <textarea class="form-control" name="details" rows="3" placeholder="Message"></textarea>
                        <div id="details-error" class="text-danger small mt-1"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100 justify-content-center">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php }else{ ?>
<div class="modal fade" id="giveReviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content review-form">
            <div class="modal-header">
                <h5 class="modal-title">Give Your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Actual review form -->
                <div id="loginFirst">
                    Please login first to submit a review.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100 justify-content-center" onclick="openLoginModal()">OK</button>
            </div>
        </form>
    </div>
</div>

<?php } ?>
<script>
    const BASE_URL1 = "<?= base_url(); ?>";
    function submitReview(event) {
        event.preventDefault();
        document.getElementById('rating-error').textContent = '';
        document.getElementById('details-error').textContent = '';
        const productUid = document.getElementById('productUid')?.value;
        const rating = document.querySelector('input[name="rating"]:checked');
        const detailsInput = document.querySelector('textarea[name="details"]');
        const details = detailsInput.value.trim();
        let hasError = false;
        if (!rating) {
            document.getElementById('rating-error').textContent = "Please select a rating.";
            hasError = true;
        }
        if (!details) {
            document.getElementById('details-error').textContent = "Please write a review message.";
            hasError = true;
        }
        if (hasError) return;

        const data = {
            productId: productUid,
            rating: rating.value,
            review: details
        };

        fetch(`${BASE_URL1}customer/api/rating/created`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    // Show error message from API response
                    MessError.fire({
                        icon: 'error',
                        title: data.message || 'Something went wrong',
                    });
                    throw new Error(data.message || 'Request failed');
                });
            }
            return response.json();
        })
        .then(result => {
            // Success feedback
            MessSuccess.fire({
                icon: 'success',
                title: 'Review submitted successfully!',
            });
            window.location.reload();
        })
        .catch(error => {
            console.error(error);
            document.getElementById('details-error').textContent = "Failed to submit review. Please try again.";
        });
    }
    function openLoginModal() {
        // Hide the review modal
        const reviewModalEl = document.getElementById('giveReviewModal');
        const reviewModal = bootstrap.Modal.getInstance(reviewModalEl);
        reviewModal.hide();

        // Show the login modal
        const loginModalEl = document.getElementById('loginRegisterModal'); // make sure the ID matches
        const loginModal = new bootstrap.Modal(loginModalEl);
        loginModal.show();
    }
    function openLoginModal1() {
        // Hide the review modal
        const reviewModalEl = document.getElementById('requestAQuote');
        const reviewModal = bootstrap.Modal.getInstance(reviewModalEl);
        reviewModal.hide();

        // Show the login modal
        const loginModalEl = document.getElementById('loginRegisterModal'); // make sure the ID matches
        const loginModal = new bootstrap.Modal(loginModalEl);
        loginModal.show();
    }

    function submitQuote(event) {
        event.preventDefault();
        const productId = document.getElementById('productId').value;
        const message = document.querySelector('textarea[placeholder="Message"]').value;
        // console.log("Quote Request Data:", {
        //     productId,
        //     message
        // });

        fetch(`${BASE_URL1}customer/api/request/created`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                productId,
                message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                MessSuccess.fire({
                    icon: 'success',
                    title: 'Request submitted successfully!',
                });
                window.location.reload();
            } else {
                MessError.fire({
                    icon: 'error',
                    title: data.message || 'Failed to submit quote request.',
                });
            }
        })
        .catch(error => {
            console.error("API Error:", error);
            MessError.fire({
                icon: 'error',
                title: 'Something went wrong. Please try again.',
            });
        });
    }
</script>
<script>
    var MessSuccess = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    var MessError = Swal.mixin({
        toast: true,
        icon: 'error',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    setTimeout(function() {
        let alertBox = document.getElementById("flashAlert");
        if (alertBox) {
            let bsAlert = new bootstrap.Alert(alertBox);
            bsAlert.close();
        }
    }, 3000);
    
</script>
  