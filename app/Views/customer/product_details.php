<section class="py-md-5 py-4">
    <div class="container">
        <div class="row g-4 gx-lg-5">
            <div class="col-md-6">
                <div class="zoom-wrapper-container">
                    <div style="--swiper-navigation-color: #000; --swiper-pagination-color: #000;" class="swiper product-main-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                            <div class="swiper-slide">
                                <img
                                    class="drift-img"
                                    src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>"
                                    data-zoom="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" />
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <!-- Thumbnail Slider -->
                <div class="swiper thumb-slider mt-3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                        <div class="swiper-slide"><img src="<?= base_url('assets/customer/images/sdffffwf.webp') ?>" /></div>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/drift-basic.min.css" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/Drift.min.js"></script>
                <script>
                    let drift; // Declare globally to manage instance

                    const thumbSwiper = new Swiper(".thumb-slider", {
                        spaceBetween: 10,
                        slidesPerView: 3,
                        freeMode: true,
                        watchSlidesProgress: true,
                        breakpoints: {
                            640: {
                                slidesPerView: 3
                            },
                            768: {
                                slidesPerView: 4
                            },
                            1024: {
                                slidesPerView: 5
                            },
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
                            init: function() {
                                initDriftZoom();
                            },
                            slideChangeTransitionEnd: function() {
                                initDriftZoom();
                            },
                        },
                    });

                    function initDriftZoom() {
                        // Destroy previous zoom if exists
                        if (drift) {
                            drift.disable();
                            document.querySelector(".drift-zoom-pane")?.remove();
                        }

                        const activeImage = document.querySelector(
                            ".product-main-slider .swiper-slide-active .drift-img"
                        );

                        const paneContainer = document.querySelector(".zoom-wrapper-container");

                        if (activeImage && paneContainer) {
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
                <h1 class="h2 mb-2">Core Dryer 2 Ton</h1>
                <div class="mb-2 d-flex items-center gap-2">
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
                </div>
                <p>Ground Trolley Core Dryer 2 Ton, Drying of Sand Cores, Drying of Foundry Tools, Preheating of Cores Ground Trolley Core Dryer 2 Ton, Drying of Sand Cores, Drying of Foundry Tools, Preheating of Cores</p>
                <div class="p-3 rounded-10 border d-flex align-items-center gap-3 mb-3">
                    <i style="line-height: 0;">
                        <img src="<?= base_url('assets/customer/images/ener.webp') ?>" class="rounded-10 object-fit-cover" width="80" height="80">
                    </i>
                    <div>
                        <div class="d-flex align-items-center gap-1">
                            <h5 class="m-0">Enerzi Microwave India Pvt. Ltd.</h5>
                            <button type="button" class="btnico" data-bs-toggle="popover" data-bs-title="Popover title" data-bs-content="And here’s some amazing content. It’s very engaging. Right?">
                                <svg width="18" height="18" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 21C16.299 21 21 16.299 21 10.5C21 4.70108 16.299 0 10.5 0C4.70098 0 0 4.70103 0 10.5C0 16.299 4.70098 21 10.5 21ZM10.5 2.10002C15.1318 2.10002 18.9 5.86825 18.9 10.5C18.9 15.1318 15.1318 18.9 10.5 18.9C5.8682 18.9 2.10002 15.1318 2.10002 10.5C2.10002 5.86825 5.8682 2.10002 10.5 2.10002ZM9.1852 14.7C9.1852 13.9387 9.7395 13.3875 10.4893 13.3875C11.2695 13.3875 11.8102 13.9387 11.8102 14.7146C11.8102 15.4602 11.2549 16.0125 10.4893 16.0125C9.7395 16.0125 9.1852 15.4602 9.1852 14.7ZM11.5477 11.55H9.44773V5.25001H11.5477V11.55Z" fill="#1F58BD"/>
                                </svg>
                            </button>
                        </div>
                        <small class="d-block mb-1">Detroit, Michigan, USA</small>
                        <div class="d-flex items-center gap-2">
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
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-primary d-inline-flex gap-2">
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
    </div>
</section>