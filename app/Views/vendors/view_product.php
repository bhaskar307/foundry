<?= view('vendors/templates/html_editor.php'); ?>
<div class="content-body p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Product Details</h5>
        <!-- <a href="<?= base_url('vendor/edit-profile') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-fill"></i> Edit Profile
        </a> -->
    </div>
    <div class="card p-4 shadow-sm">
        <!-- Header with title and edit button -->


        <!-- Vendor Profile Image -->

        <button type="button" id="editBtn" class="btn btn-primary btn-sm position-absolute" style="top: 10px; right: 10px;">
            Edit
        </button>

        <form id="productForm" method="post" enctype="multipart/form-data">
            <div class="row g-3 align-items-center">
                <?php
                // First, make an array of all images without changing backend variables
                $allImages = [];

                // Vendor image first (only if exists)
                if (!empty($resp['image'])) {
                    $allImages[] = [
                        'image' => $resp['image'],
                        'isVendor' => true
                    ];
                }

                // Then product images (only if exists)
                if (!empty($images) && is_array($images)) {
                    foreach ($images as $img) {
                        $allImages[] = [
                            'image' => $img['image'],
                            'isVendor' => false
                        ];
                    }
                }
                ?>
                <!-- Images -->
                <div class="row">
                    <?php foreach ($allImages as $index => $imgData) : ?>
                        <div class="col-md-3 text-center mb-3 mb-md-0 image-col">
                            <!-- Clickable Image -->
                            <a href="<?= base_url($imgData['image']) ?>" target="_blank">
                                <img src="<?= base_url($imgData['image']) ?>"
                                    alt="<?= $imgData['isVendor'] ? 'Vendor Image' : 'Product Image' ?>"
                                    class="img-fluid <?= $imgData['isVendor'] ? 'rounded-circle' : 'rounded' ?> border border-3 border-primary shadow"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </a>

                            <!-- Upload Input -->
                            <input type="file"
                                name="image_upload_<?= $index ?>"
                                accept="image/*"
                                class="form-control mt-2"
                                onchange="">
                        </div>
                    <?php endforeach; ?>
                </div>


                <!-- Product Details -->
                <div class="col-md-9">
                    <div class="row g-3">
                        <!-- Product Name -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?= esc($resp['name'] ?? '') ?>" readonly>
                                <label for="name">Product Name</label>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-control" name="category" id="category" disabled>
                                    <option value="">Select category</option>
                                    <?php if (!empty($category)) {
                                        foreach ($category as $key) { ?>
                                            <option value="<?= $key['uid']; ?>"
                                                <?= ($resp['category_id'] ?? '') == $key['uid'] ? 'selected' : '' ?>>
                                                <?= $key['title']; ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                                <label for="category">Category</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-control" name="subcategory" id="subcategory_id" disabled>
                                    <option value="">Select Sub category</option>
                                </select>
                                <label for="subcategory">Sub Category<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control" name="description" id="description" style="height: 120px;" readonly><?= esc($resp['description'] ?? '') ?></textarea>
                                <label for="description">Description</label>
                            </div>
                        </div>
                    </div>
                </div>
                <textarea name="content" id="content" rows="10" cols="90" class="form-control documentTextEditor"><?= esc($resp['html_description'] ?? '') ?> disabled
                     </textarea>

            </div>
            <button type="button" id="" class="btn btn-primary btn-sm position-absolute">
                Update
            </button>
        </form>



    </div>


    <script>
        document.getElementById('editBtn').addEventListener('click', function() {
            let form = document.getElementById('productForm');
            let inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(el => {
                if (el.hasAttribute('readonly') || el.hasAttribute('disabled')) {
                    el.removeAttribute('readonly');
                    el.removeAttribute('disabled');
                } else {
                    el.setAttribute('readonly', true);
                    if (el.tagName.toLowerCase() === 'select') el.setAttribute('disabled', true);
                }
            });

            this.textContent = this.textContent === 'Edit' ? 'Lock' : 'Edit';
        });


        $(document).ready(function() {
            $('#category').on('change', function() {
                let categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: BASE_URL + "/vendor/api/get-subcategories",
                        type: "GET",
                        data: {
                            categoryId: categoryId
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#subcategory_id').empty().append('<option value="">Select Sub category</option>');

                            if (res.success && res.data && res.data.data.length > 0) {
                                res.data.data.forEach(function(subcat) {
                                    $('#subcategory_id').append(
                                        `<option value="${subcat.uid}">${subcat.title}</option>`
                                    );
                                });
                            } else {
                                $('#subcategory_id').append('<option value="">No subcategories found</option>');
                            }
                        },
                        error: function() {
                            alert("Error loading subcategories.");
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append('<option value="">Select Sub category</option>');
                }
            });

        });
    </script>