<div class="row">
    <div class="col-md-3 text-center">
        <img src="<?= base_url(esc($details['employee']->profile_image ?? 'assets/images/default.png')) ?>" 
             alt="Profile Image" 
             class="img-fluid rounded-circle" 
             style="max-width: 150px;">
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <strong>Name:</strong> <?= esc($details['employee']->name ?? 'N/A') ?>
            </div>

            <div class="col-md-6 mt-2">
                <strong>Email:</strong> <?= esc($details['employee']->email ?? 'N/A') ?>
            </div>
    
            <div class="col-md-6 mt-2">
                <strong>Mobile:</strong> <?= esc($details['employee']->mobile ?? 'N/A') ?>
            </div>

            <div class="col-md-6 mt-2">
                <strong>Date of Birth:</strong> <?= esc($details['employee']->dob ?? 'N/A') ?>
            </div>

            <div class="col-md-6 mt-2">
                <strong>Country:</strong> <?= esc($details['employee']->country ?? 'N/A') ?>
            </div>
        </div>
    </div>   
</div>
