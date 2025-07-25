<div class="content-body p-3">
    <div class="mt-4 rounded-10 bg-white border">
        <div class="d-flex align-items-center p-3 gap-4">
            <div class="filterdropdown filterfield">
                <div class="input-group">
                    <select class="form-select" id="search_customer" aria-label="Default select example">
                        <option value=''>All Customer</option>
                        <?php if(!empty($customer)){
                            foreach ($customer as $key){
                        ?>
                            <option value='<?= $key['uid'] ?>' <?php if($key['uid'] == $customerUid){ ?> selected <?php } ?>><?= $key['name'] ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="filterdropdown filterfield">
                <div class="input-group">
                    <select class="form-select" id="search_product" aria-label="Default select example">
                        <option value=''>All Products</option>
                        <?php if(!empty($product)){
                            foreach ($product as $key){
                        ?>
                            <option value='<?= $key['uid'] ?>' <?php if($key['uid'] == $productUid){ ?> selected <?php } ?>><?= $key['name'] ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
           
        </div>
    </div>
    
    <div class="mt-4 rounded-10 bg-white border">
        <div class="p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="m-0 h5 fw-600">List of Ratings</div>
            </div>
        </div>
        <div class="px-3 pb-3">
            <table class="dataTableNoSearch display border">
                <thead>
                    <tr>
                        <th>Customer Details</th>
                        <th>Product Name</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resp)) {
                        foreach ($resp as $row) {
                    ?>
                            <tr>
                                <td>
                                    <div class="fw-600 h6 m-0">
                                        <div class="d-flex align-items-center">
                                            <div class="text-nowrap">
                                                <strong><?= $row['customer_name']; ?></strong>
                                                <br><small class="text-muted">Eml: <?= $row['customer_email']; ?></small>
                                                <br><small class="text-muted">Mob: <?= $row['customer_mobile']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><?= $row['product_name']; ?></div>
                                </td> 
                                <td>
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
                                </td>  
                                <td>
                                    <div><?= $row['review']; ?></div>
                                </td>    
                                <td>
                                    <?= date('d M Y, h:i A', strtotime($row['created_at'])); ?>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function handleFilterChange() {
                const customer = $('#search_customer').val();
                const product = $('#search_product').val();
                window.location.href = `<?= base_url('admin/ratings') ?>?customer=${customer}&product=${product}`;
            }

            $('#search_customer').on('change', handleFilterChange);
            $('#search_product').on('change', handleFilterChange);
        });
    </script>

