<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 col-lg-3">
                <div class="rounded-10 border d-flex flex-column overflow-hidden">
                    <div class="p-3 bg-light d-flex align-items-center gap-1 accordion-button shadow-none" style="border-radius: 10px 10px 0 0;" data-bs-toggle="collapse" data-bs-target="#productFilter">
                        <i style="line-height: 0">
                            <svg height="16" viewBox="0 0 511 511.99982" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m492.476562 0h-471.976562c-11.046875 0-20 8.953125-20 20 0 55.695312 23.875 108.867188 65.503906 145.871094l87.589844 77.851562c15.1875 13.5 23.898438 32.898438 23.898438 53.222656v195.03125c0 15.9375 17.8125 25.492188 31.089843 16.636719l117.996094-78.660156c5.5625-3.710937 8.90625-9.953125 8.90625-16.640625v-116.367188c0-20.324218 8.710937-39.722656 23.898437-53.222656l87.585938-77.851562c41.628906-37.003906 65.503906-90.175782 65.503906-145.871094 0-11.046875-8.953125-20-19.996094-20zm-72.082031 135.972656-87.585937 77.855469c-23.71875 21.085937-37.324219 51.378906-37.324219 83.113281v105.667969l-77.996094 51.996094v-157.660157c0-31.738281-13.605469-62.03125-37.324219-83.117187l-87.585937-77.851563c-28.070313-24.957031-45.988281-59.152343-50.785156-95.980468h429.386719c-4.796876 36.828125-22.710938 71.023437-50.785157 95.976562zm0 0"/></svg>
                        </i>
                        <h5 class="m-0">Filters</h5>
                    </div>
                    <div class="accordion-collapse collapse show" id="productFilter">
                        <div class="d-flex flex-column gap-4 p-3">
                            <div class="">
                                <h6 class="mb-2">Filter by Price</h6>
                                <div class="price-filter">
                                    <input type="text" id="priceRange" name="priceRange" />
                                </div>
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/css/ion.rangeSlider.min.css"/>
                                <script src="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/js/ion.rangeSlider.min.js"></script>
                                <script>
                                    let priceRange = { 
                                        from: <?= isset($priceFrom) ? $priceFrom : 1000 ?>, 
                                        to: <?= isset($priceTo) ? $priceTo : 50000 ?>
                                    };

                                    $(document).ready(function () {
                                        $("#priceRange").ionRangeSlider({
                                            type: "double",
                                            min: 0,
                                            max: 100000,
                                            from: priceRange.from,
                                            to: priceRange.to,
                                            step: 100,
                                            prefix: "₹",
                                            grid: true,
                                            onFinish: function (data) {
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
                                            <?= $isChecked ?>
                                        >
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
                        document.addEventListener("DOMContentLoaded", function () {
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
                                                S326.847,409.323,225.474,409.323z"/>
                                            <path d="M505.902,476.472L386.574,357.144c-8.131-8.131-21.299-8.131-29.43,0c-8.131,8.124-8.131,21.306,0,29.43l119.328,119.328
                                                c4.065,4.065,9.387,6.098,14.715,6.098c5.321,0,10.649-2.033,14.715-6.098C514.033,497.778,514.033,484.596,505.902,476.472z"/>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search.." style="height:40px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($product)){ 
                    foreach($product as $row){
                    ?>
                    <div class="col-lg-4 col-6">
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
                            </div>
                        </a>
                    </div>
                    <?php } } ?>  
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