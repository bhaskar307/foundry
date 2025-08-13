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
            <div class="datefield filterfield">
                <div class="input-group">
                    <input type="text" class="form-control establDate" id="search_date" aria-label="Search" aria-describedby="basic-addon1" name="dob" placeholder="yyyy-mm-dd" value="<?= $date ?>">
                    <script>
                        $(function() {
                            $('.establDate').datetimepicker({
                                timepicker: false,
                                format: 'Y-m-d',
                            });
                        });
                    </script>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="mt-4 rounded-10 bg-white border">
        <div class="p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="m-0 h5 fw-600">List of Requests</div>
            </div>
        </div>
        <div class="px-3 pb-3">
            <table class="dataTableNoSearch display border">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Date</th>
                        <th>Message</th>
                        <th>Status</th>
                        <!-- <th>Actions</th> -->
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
                                    <div ><?= $row['product_name']; ?></div>
                                </td>    
                                <td>
                                     <?= date('d M Y, h:i A', strtotime($row['created_at'])); ?>
                                </td>
                                <td><?= $row['message'] ?></td>
                                <td>
                                    <?php
                                        $bgColor = ($row['status'] === 'Active') ? '#FFE4E3' : '#D1FAE5';
                                        $textColor = ($row['status'] === 'Active') ? '#AB3D3C' : '#065F46';
                                    ?>
                                    <button class="btn rounded-pill" style="background-color: <?= $bgColor ?>; color: <?= $textColor ?>;">
                                        <?= $row['status']; ?>
                                    </button>
                                </td>
                                <!-- <td style="max-width: 120px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="<?php echo base_url('vendor/view-product/'.$row['uid']) ?>" class="btnico">
                                            <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 8C22 7.52133 21.7567 7.208 21.27 6.57867C19.4889 4.28 15.5605 0 11 0C6.43945 0 2.51106 4.28 0.729989 6.57867C0.24333 7.208 0 7.52133 0 8C0 8.47867 0.24333 8.792 0.729989 9.42133C2.51106 11.72 6.43945 16 11 16C15.5605 16 19.4889 11.72 21.27 9.42133C21.7567 8.792 22 8.47867 22 8ZM11 12C11.998 12 12.9551 11.5786 13.6607 10.8284C14.3664 10.0783 14.7628 9.06087 14.7628 8C14.7628 6.93913 14.3664 5.92172 13.6607 5.17157C12.9551 4.42143 11.998 4 11 4C10.002 4 9.04495 4.42143 8.33928 5.17157C7.63361 5.92172 7.23717 6.93913 7.23717 8C7.23717 9.06087 7.63361 10.0783 8.33928 10.8284C9.04495 11.5786 10.002 12 11 12Z" fill="#0D9488" />
                                            </svg>
                                        </a>
                                    </div>
                                </td> -->
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Common handler function
            function handleFilterChange() {
                const customer = $('#search_customer').val();
                const product = $('#search_product').val();
                const date = $('#search_date').val();

                window.location.href = `<?= base_url('vendor/requests') ?>?customer=${customer}&product=${product}&date=${date}`;

            }

            $('#search_customer').on('change', handleFilterChange);
            $('#search_product').on('change', handleFilterChange);
            $('#search_date').on('change', handleFilterChange);// for manual input or date picker
        });
    </script>

