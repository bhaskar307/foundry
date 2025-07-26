<div class="content-body p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Product Details</h5>
        <!-- <a href="<?= base_url('vendor/edit-profile') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-fill"></i> Edit Profile
        </a> -->
    </div>
    <div class="card p-4 shadow-sm">
        <!-- Header with title and edit button -->
        
        <div class="row g-4 align-items-center">
            <!-- Vendor Profile Image -->
            <div class="col-md-3">
                <img src="<?= base_url($resp['image']) ?>" 
                    alt="Vendor Image" 
                    class="img-fluid rounded w-100">
            </div>

            <!-- Vendor Details -->
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-md-12">
                        <strong>Product Name:</strong> <?= esc($resp['name'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-12">
                        <strong>Category:</strong> <?= esc($resp['category_name'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-12">
                        <strong>Vendor Name:</strong> <?= esc($resp['vendor_name'] ?? 'N/A') ?>
                    </div>
                    <!-- Add more fields if needed -->
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="row g-3">
                    <div class="col-md-12">
                        <strong>Description:</strong> <?= esc($resp['description'] ?? 'N/A') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row g-4">
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
            <div class="col-md-4 col-lg-3">
                <img src="<?= base_url($resp['image']) ?>" alt="" class="w-100 rounded">
            </div>
        </div> -->


    </div>
    
</die>


