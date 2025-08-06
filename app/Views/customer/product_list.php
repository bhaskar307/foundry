<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 col-lg-3">
                <div class="rounded-10 border d-flex flex-column overflow-hidden">
                    <div class="p-3 bg-light d-flex align-items-center gap-1 accordion-button shadow-none" style="border-radius: 10px 10px 0 0;" data-bs-toggle="collapse" data-bs-target="#productFilter">
                        <i style="line-height: 0">
                            <svg height="16" viewBox="0 0 511 511.99982" width="16" xmlns="http://www.w3.org/2000/svg">
                                <path d="m492.476562 0h-471.976562c-11.046875 0-20 8.953125-20 20 0 55.695312 23.875 108.867188 65.503906 145.871094l87.589844 77.851562c15.1875 13.5 23.898438 32.898438 23.898438 53.222656v195.03125c0 15.9375 17.8125 25.492188 31.089843 16.636719l117.996094-78.660156c5.5625-3.710937 8.90625-9.953125 8.90625-16.640625v-116.367188c0-20.324218 8.710937-39.722656 23.898437-53.222656l87.585938-77.851562c41.628906-37.003906 65.503906-90.175782 65.503906-145.871094 0-11.046875-8.953125-20-19.996094-20zm-72.082031 135.972656-87.585937 77.855469c-23.71875 21.085937-37.324219 51.378906-37.324219 83.113281v105.667969l-77.996094 51.996094v-157.660157c0-31.738281-13.605469-62.03125-37.324219-83.117187l-87.585937-77.851563c-28.070313-24.957031-45.988281-59.152343-50.785156-95.980468h429.386719c-4.796876 36.828125-22.710938 71.023437-50.785157 95.976562zm0 0" />
                            </svg>
                        </i>
                        <h5 class="m-0">Filters</h5>
                    </div>
                    <div class="accordion-collapse collapse show" id="productFilter">
                        <div class="d-flex flex-column gap-4 p-3">
                            <div class="">
                                <!-- <h6 class="mb-2">Filter by Price</h6>
                                <div class="price-filter">
                                    <input type="text" id="priceRange" name="priceRange" />
                                </div> -->
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/css/ion.rangeSlider.min.css" />
                                <script src="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/js/ion.rangeSlider.min.js"></script>
                                <script>
                                    let priceRange = {
                                        from: <?= isset($priceFrom) ? $priceFrom : 1000 ?>,
                                        to: <?= isset($priceTo) ? $priceTo : 50000 ?>
                                    };

                                    $(document).ready(function() {
                                        $("#priceRange").ionRangeSlider({
                                            type: "double",
                                            min: 0,
                                            max: 100000,
                                            from: priceRange.from,
                                            to: priceRange.to,
                                            step: 100,
                                            prefix: "₹",
                                            grid: true,
                                            onFinish: function(data) {
                                                priceRange.from = data.from;
                                                priceRange.to = data.to;
                                                handleCategoryChange(); // Call same function on price change
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="">
                                <h6 class="mb-2">Categories</h6>
                                <div class="d-flex flex-column gap-1">
                                    <?php
                                    if ($category) {
                                        foreach ($category as $row) {
                                            $catId = $row['uid'];
                                            // Check if this UID is selected
                                            $isChecked = (isset($categoryUid) && in_array($catId, $categoryUid)) ? 'checked' : '';
                                    ?>
                                            <div class="form-check m-0">
                                                <input
                                                    class="form-check-input category-checkbox"
                                                    type="checkbox"
                                                    value="<?= $catId ?>"
                                                    id="category<?= $catId ?>"
                                                    onclick="handleCategoryChange(this)"
                                                    <?= $isChecked ?>>
                                                <label class="form-check-label" for="category<?= $catId ?>">
                                                    <?= $row['title']; ?>
                                                </label>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="">
                                <h6 class="mb-2">All Brands</h6>
                                <div class="d-flex flex-column gap-1">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="Siemens">
                                        <label class="form-check-label" for="Siemens">Siemens</label>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="ABB">
                                        <label class="form-check-label" for="ABB">ABB</label>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="schneiderElectric">
                                        <label class="form-check-label" for="schneiderElectric">Schneider Electric</label>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="">
                                <h6 class="mb-2">Filter by Rating</h6>
                                <div class="d-flex flex-column gap-1">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="5star">
                                        <label class="form-check-label" for="5star">★★★★★ 5 Stars</label>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="4star">
                                        <label class="form-check-label" for="4star">★★★★ 4+ Stars</label>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="3star">
                                        <label class="form-check-label" for="3star">★★★ 3+ Stars</label>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            if (window.innerWidth <= 768) {
                                const collapseDiv = document.getElementById("productFilter");
                                const headerDiv = document.querySelector('[data-bs-target="#productFilter"]');

                                if (collapseDiv && headerDiv) {
                                    collapseDiv.classList.remove("show");
                                    headerDiv.classList.add("collapsed");
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb m-0" style="font-size: 12px;">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Industrial Equipment</li>
                                    </ol>
                                </nav>
                                <h1 class="m-0 h4">Industrial Equipment</h1>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group m-0">
                                    <span class="input-group-text">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <path d="M225.474,0C101.151,0,0,101.151,0,225.474c0,124.33,101.151,225.474,225.474,225.474
                                                c124.33,0,225.474-101.144,225.474-225.474C450.948,101.151,349.804,0,225.474,0z M225.474,409.323
                                                c-101.373,0-183.848-82.475-183.848-183.848S124.101,41.626,225.474,41.626s183.848,82.475,183.848,183.848
                                                S326.847,409.323,225.474,409.323z" />
                                            <path d="M505.902,476.472L386.574,357.144c-8.131-8.131-21.299-8.131-29.43,0c-8.131,8.124-8.131,21.306,0,29.43l119.328,119.328
                                                c4.065,4.065,9.387,6.098,14.715,6.098c5.321,0,10.649-2.033,14.715-6.098C514.033,497.778,514.033,484.596,505.902,476.472z" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search.." style="height:40px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($product)) {
                        foreach ($product as $row) {
                    ?>
                            <div class="col-lg-4 col-6">
                                <a href="<?= base_url('product-details/' . $row['uid']) ?>" class="h-100 rounded-10 border bg-white overflow-hidden d-block">
                                    <img src="<?= base_url($row['image']) ?>" alt="" class="w-100 object-fit-cover" style="height:250px;">
                                    <div class="p-lg-3 p-2">
                                        <h5 class="mb-1" style="height:50px;">
                                            <?= substr(strip_tags($row['name']), 0, 40) ?><?= strlen(strip_tags($row['name'])) > 40 ? '...' : '' ?>
                                        </h5>
                                        <small class="d-flex align-items-center gap-1">
                                            <!-- <span class="fw-600">Price: <?= $row['price']; ?></span> // vendor_name -->
                                            <span class="fw-600">Supllier Name: <?= $row['vendor_name']; ?></span>
                                        </small>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <?php
                                            $rating = $row['total_rating_percent'];
                                            $fullStars = floor($rating);
                                            $halfStar = ($rating - $fullStars) >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                                            $starSvg = function ($fill) {
                                                $color = match ($fill) {
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
                                            <small style="color: #666;"><?= $row['total_rating_percent'] ?> (<?= $row['total_customer_review'] ?> reviews)</small>
                                        </div>
                                        <div class="my-1" style="color: #666;">
                                            <?= substr(strip_tags($row['description']), 0, 95) ?><?= strlen(strip_tags($row['description'])) > 95 ? '...' : '' ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                    <!-- <div class="col-12">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a href="#" class="page-link">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active">
                                <a class="page-link" href="#" aria-current="page">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function handleCategoryChange(checkbox) {
        const selected = [];
        document.querySelectorAll('.category-checkbox:checked').forEach(cb => {
            selected.push(cb.value);
        });

        const filterData = {
            categories: selected,
            price: {
                from: priceRange.from,
                to: priceRange.to
            }
        };

        const jsonStr = JSON.stringify(filterData);
        const base64 = btoa(jsonStr);
        const url = "<?= base_url('product-list?filter=') ?>" + encodeURIComponent(base64);
        window.location.href = url;
        //anotherFunction(selected);
    }

    function anotherFunction(categories) {
        // Example use: send data via AJAX or update UI
        console.log('Calling another function with:', categories);
    }
</script>