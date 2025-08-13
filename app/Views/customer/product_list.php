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
                            <div class="d-flex flex-column gap-1">
                                <?php if (!empty($category)) : ?>
                                    <?php foreach ($category as $row): ?>
                                        <?php
                                        $catId = $row['uid'];
                                        $isChecked = (isset($categoryUid) && in_array($catId, $categoryUid)) ? 'checked' : '';
                                        ?>
                                        <!-- Main Category -->
                                        <div class="form-check m-0">
                                            <input
                                                class="form-check-input category-checkbox"
                                                type="checkbox"
                                                value="<?= $catId ?>"
                                                id="category<?= $catId ?>"
                                                onclick="handleCategoryChange(this)"
                                                <?= $isChecked ?>>
                                            <label class="form-check-label" for="category<?= $catId ?>">
                                                <?= esc($row['title']); ?>
                                            </label>
                                        </div>

                                        <!-- Subcategories -->
                                        <?php if (!empty($row['subcategories'])): ?>
                                            <?php foreach ($row['subcategories'] as $sub): ?>
                                                <?php
                                                $subId = $sub['uid'];
                                                $subChecked = (isset($categoryUid) && in_array($subId, $categoryUid)) ? 'checked' : '';
                                                ?>
                                                <div class="form-check m-0 ps-5">
                                                    <input
                                                        class="form-check-input category-checkbox"
                                                        type="checkbox"
                                                        value="<?= $subId ?>"
                                                        id="category<?= $subId ?>"
                                                        onclick="handleCategoryChange(this)"
                                                        <?= $subChecked ?>>
                                                    <label class="form-check-label" for="category<?= $subId ?>">
                                                        <?= esc($sub['title']); ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="">
                                <h6 class="mb-2">All Country</h6>
                                <div class="d-flex flex-column gap-1">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="india" id="india" checked>

                                        <label class="form-check-label" for="india">India</label>
                                    </div>
                                </div>
                            </div>

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
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search.." style="height:40px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="productContainer" class="row">
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
                                            <!--  verify components -->
                                            <?= view('components/verify_badge', ['is_verify' => $row['is_verify']]) ?>
                                            <small class="d-flex align-items-center gap-1">

                                                <!-- <span class="fw-600">Price: <?= $row['price']; ?></span> // vendor_name -->
                                                <span class="fw-600">Supplier Name: <?= $row['vendor_name']; ?></span>
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
                                            <div class="text-dark fw-600 d-flex gap-2 justify-content-between align-items-center">
                                                <span><?= $row['vendor_company'] ?></span>
                                                <?php if (!empty($row['is_vendor_verify']) && $row['is_vendor_verify'] == 1): ?>
                                                    <small class="d-flex align-items-center gap-1">
                                                        <span class="fw-600">Verified</span>
                                                        <i style="line-height: 0;">
                                                            <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69883 1.04935C9.56974 0.843073 9.37955 0.682175 9.15473 0.589057C8.92992 0.495939 8.68167 0.475233 8.44454 0.529821L6.76156 0.916427C6.58908 0.956072 6.40986 0.956072 6.23739 0.916427L4.5544 0.529821C4.31727 0.475233 4.06902 0.495939 3.84421 0.589057C3.6194 0.682175 3.42921 0.843073 3.30012 1.04935L2.38281 2.5134C2.28921 2.66317 2.16284 2.78955 2.01308 2.88409L0.549128 3.80146C0.343218 3.93044 0.182567 4.12034 0.0894753 4.34478C-0.00361686 4.56922 -0.0245326 4.81708 0.0296313 5.05395L0.416212 6.73891C0.455711 6.9111 0.455711 7.09 0.416212 7.26219L0.0296313 8.94621C-0.0247431 9.18322 -0.00393263 9.43128 0.0891696 9.65592C0.182272 9.88055 0.34304 10.0706 0.549128 10.1996L2.01308 11.117C2.16284 11.2106 2.28921 11.337 2.38375 11.4868L3.30106 12.9508C3.56502 13.373 4.0686 13.5817 4.5544 13.4703L6.23739 13.0837C6.40986 13.0441 6.58908 13.0441 6.76156 13.0837L8.44548 13.4703C8.68247 13.5247 8.93052 13.5039 9.15514 13.4108C9.37976 13.3177 9.56979 13.1569 9.69883 12.9508L10.6161 11.4868C10.7097 11.337 10.8361 11.2106 10.9859 11.117L12.4508 10.1996C12.6569 10.0704 12.8175 9.88015 12.9105 9.65534C13.0034 9.43052 13.024 9.18233 12.9693 8.94528L12.5837 7.26219C12.544 7.0897 12.544 6.91046 12.5837 6.73798L12.9703 5.05395C13.0247 4.81704 13.004 4.56905 12.9111 4.34442C12.8182 4.1198 12.6576 3.9297 12.4517 3.80052L10.9868 2.88315C10.8372 2.78937 10.7108 2.66296 10.6171 2.5134L9.69883 1.04935ZM9.228 4.9126C9.2859 4.80613 9.30024 4.68136 9.26802 4.56453C9.23579 4.44771 9.15951 4.34793 9.05523 4.28621C8.95094 4.22448 8.82678 4.20561 8.70887 4.23358C8.59096 4.26154 8.48849 4.33415 8.42302 4.43613L5.9753 8.57927L4.4973 7.1639C4.45346 7.11887 4.40099 7.08314 4.34304 7.05883C4.28508 7.03452 4.22283 7.02214 4.15998 7.02241C4.09714 7.02269 4.03499 7.03562 3.97725 7.06043C3.91951 7.08524 3.86736 7.12143 3.82391 7.16683C3.78045 7.21224 3.74659 7.26593 3.72434 7.32471C3.70208 7.38348 3.69189 7.44614 3.69437 7.50894C3.69686 7.57174 3.71196 7.6334 3.73878 7.69023C3.76561 7.74707 3.80361 7.79792 3.85051 7.83976L5.75439 9.6642C5.80535 9.71292 5.86665 9.74951 5.93373 9.77122C6.00081 9.79292 6.07192 9.7992 6.14176 9.78957C6.21161 9.77994 6.27837 9.75465 6.33707 9.7156C6.39577 9.67655 6.44488 9.62473 6.48075 9.56403L9.228 4.9126Z" fill="#3A9F6C"></path>
                                                            </svg>
                                                        </i>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        <?php }
                        } ?>
                    </div>

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
    // Render products
    const productsData = <?= json_encode($product) ?>;

    function renderProducts(list) {
        const container = document.getElementById('productContainer');
        container.innerHTML = ''; // clear old content

        // if (list.length === 0) {
        //     container.innerHTML = '<div class="col-12 text-center text-muted">No products found</div>';
        //     return;
        // }

        list.forEach(row => {
            // Rating logic
            const rating = row.total_rating_percent || 0;
            const fullStars = Math.floor(rating);
            const halfStar = (rating - fullStars) >= 0.5;
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

            const starSvg = (fill) => {
                const color = {
                    full: '#F6AB27',
                    half: 'url(#halfGradient)',
                    empty: '#E0E0E0'
                } [fill];
                return `
        <svg width="16" height="16" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="halfGradient">
                    <stop offset="50%" stop-color="#F6AB27"/>
                    <stop offset="50%" stop-color="#E0E0E0"/>
                </linearGradient>
            </defs>
            <path d="M50 5L61 35H95L67 57L78 90L50 70L22 90L33 57L5 35H39L50 5Z" fill="${color}"/>
        </svg>
        `;
            };

            // Build stars HTML
            let starsHtml = '';
            for (let i = 0; i < fullStars; i++) starsHtml += starSvg('full');
            if (halfStar) starsHtml += starSvg('half');
            for (let i = 0; i < emptyStars; i++) starsHtml += starSvg('empty');

            // Append product card
            container.innerHTML += `
        <div class="col-lg-4 col-6">
            <a href="product-details/${row.uid}" class="h-100 rounded-10 border bg-white overflow-hidden d-block">
                <img src="${row.image}" alt="" class="w-100 object-fit-cover" style="height:250px;">
                <div class="p-lg-3 p-2">
                    <h5 class="mb-1" style="height:50px;">
                        ${row.name.length > 40 ? row.name.slice(0, 40) + '...' : row.name}
                    </h5>
                    
                    ${row.is_verify ? `<span class="badge bg-success">Verified</span>` : ''}

                    <small class="d-flex align-items-center gap-1">
                        <span class="fw-600">Supplier Name: ${row.vendor_name}</span>
                    </small>

                    <div class="d-flex align-items-center justify-content-between">
                        <i style="display: flex; gap: 2px; line-height: 0;">${starsHtml}</i>
                        <small style="color: #666;">${rating} (${row.total_customer_review} reviews)</small>
                    </div>

                    <div class="my-1" style="color: #666;">
                        ${row.description.length > 95 ? row.description.slice(0, 95) + '...' : row.description}
                    </div>

                    <div class="text-dark fw-600 d-flex gap-2 justify-content-between align-items-center">
                        <span>${row.vendor_company}</span>
                        ${row.is_vendor_verify == 1 ? `
                            <small class="d-flex align-items-center gap-1">
                                <span class="fw-600">Verified</span>
                                <i style="line-height: 0;">
                                    <!-- Vendor Verify Icon -->
                                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69883 1.04935C9.56974 0.843073 9.37955 0.682175 9.15473 0.589057C8.92992 0.495939 8.68167 0.475233 8.44454 0.529821L6.76156 0.916427C6.58908 0.956072 6.40986 0.956072 6.23739 0.916427L4.5544 0.529821C4.31727 0.475233 4.06902 0.495939 3.84421 0.589057C3.6194 0.682175 3.42921 0.843073 3.30012 1.04935L2.38281 2.5134C2.28921 2.66317 2.16284 2.78955 2.01308 2.88409L0.549128 3.80146C0.343218 3.93044 0.182567 4.12034 0.0894753 4.34478C-0.00361686 4.56922 -0.0245326 4.81708 0.0296313 5.05395L0.416212 6.73891C0.455711 6.9111 0.455711 7.09 0.416212 7.26219L0.0296313 8.94621C-0.0247431 9.18322 -0.00393263 9.43128 0.0891696 9.65592C0.182272 9.88055 0.34304 10.0706 0.549128 10.1996L2.01308 11.117C2.16284 11.2106 2.28921 11.337 2.38375 11.4868L3.30106 12.9508C3.56502 13.373 4.0686 13.5817 4.5544 13.4703L6.23739 13.0837C6.40986 13.0441 6.58908 13.0441 6.76156 13.0837L8.44548 13.4703C8.68247 13.5247 8.93052 13.5039 9.15514 13.4108C9.37976 13.3177 9.56979 13.1569 9.69883 12.9508L10.6161 11.4868C10.7097 11.337 10.8361 11.2106 10.9859 11.117L12.4508 10.1996C12.6569 10.0704 12.8175 9.88015 12.9105 9.65534C13.0034 9.43052 13.024 9.18233 12.9693 8.94528L12.5837 7.26219C12.544 7.0897 12.544 6.91046 12.5837 6.73798L12.9703 5.05395C13.0247 4.81704 13.004 4.56905 12.9111 4.34442C12.8182 4.1198 12.6576 3.9297 12.4517 3.80052L10.9868 2.88315C10.8372 2.78937 10.7108 2.66296 10.6171 2.5134L9.69883 1.04935ZM9.228 4.9126C9.2859 4.80613 9.30024 4.68136 9.26802 4.56453C9.23579 4.44771 9.15951 4.34793 9.05523 4.28621C8.95094 4.22448 8.82678 4.20561 8.70887 4.23358C8.59096 4.26154 8.48849 4.33415 8.42302 4.43613L5.9753 8.57927L4.4973 7.1639C4.45346 7.11887 4.40099 7.08314 4.34304 7.05883C4.28508 7.03452 4.22283 7.02214 4.15998 7.02241C4.09714 7.02269 4.03499 7.03562 3.97725 7.06043C3.91951 7.08524 3.86736 7.12143 3.82391 7.16683C3.78045 7.21224 3.74659 7.26593 3.72434 7.32471C3.70208 7.38348 3.69189 7.44614 3.69437 7.50894C3.69686 7.57174 3.71196 7.6334 3.73878 7.69023C3.76561 7.74707 3.80361 7.79792 3.85051 7.83976L5.75439 9.6642C5.80535 9.71292 5.86665 9.74951 5.93373 9.77122C6.00081 9.79292 6.07192 9.7992 6.14176 9.78957C6.21161 9.77994 6.27837 9.75465 6.33707 9.7156C6.39577 9.67655 6.44488 9.62473 6.48075 9.56403L9.228 4.9126Z" fill="#3A9F6C"></path>
                                    </svg>
                                </i>
                            </small>
                        ` : ''}
                    </div>
                </div>
            </a>
        </div>
    `;
        });

    }

    // Local search filter
    function filterProducts(searchTerm) {
        const lowerSearch = searchTerm.toLowerCase();
        const filtered = productsData.filter(p =>
            (p.name && p.name.toLowerCase().includes(lowerSearch)) ||
            (p.description && p.description.toLowerCase().includes(lowerSearch))
        );
        console.log("Filtered Products:", filtered);
        
        renderProducts(filtered);
    }

    // Event listener for search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterProducts(this.value);
        console.log("Search Input Value:", this.value);
        
    });

    // Initial render
    renderProducts(productsData);
</script>
<script>
    console.log("============productsData", productsData);

    // Category change function
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
            },

        };

        const jsonStr = JSON.stringify(filterData);
        const base64 = btoa(jsonStr);
        const url = "<?= base_url('product-list?filter=') ?>" + encodeURIComponent(base64);
        window.location.href = url;
    }

    // function handleCategoryChange(checkbox) {
    //     const selected = [];
    //     document.querySelectorAll('.category-checkbox:checked').forEach(cb => {
    //         selected.push(cb.value);
    //     });

    //     const filterData = {
    //         categories: selected,
    //         price: {
    //             from: priceRange.from,
    //             to: priceRange.to
    //         },
    //         // name: searchNameFileter // will now have latest typed value
    //     };


    //     console.log("============filterData", filterData);


    //     const jsonStr = JSON.stringify(filterData);
    //     const base64 = btoa(jsonStr);
    //     const url = "<?= base_url('product-list?filter=') ?>" + encodeURIComponent(base64);
    //     window.location.href = url;
    // }


    function anotherFunction(categories) {
        // Example use: send data via AJAX or update UI
        console.log('Calling another function with:', categories);
    }
</script>