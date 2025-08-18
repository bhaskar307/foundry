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


        <div class="row g-3 align-items-center">
            <?php

            $allImages = [];


            if (!empty($images) && is_array($images)) {
                foreach ($images as $img) {
                    $allImages[] = [
                        'uid' => $img['uid'],
                        'image' => $img['image'],
                        'mainImage' => ($img['main_image'] == 1) ? true : false,
                    ];
                }
            }
            ?>

            <div class="row">
                <?php foreach ($allImages as $index => $imgData) : ?>

                    <div class="col-md-3 text-center mb-3 mb-md-0 image-col">
                        <!-- Clickable Image -->
                        <a href="<?= base_url($imgData['image']) ?>" target="_blank">
                            <img src="<?= base_url($imgData['image']) ?>"
                                alt=""
                                class="img-fluid <?= $imgData['mainImage'] ? 'rounded-circle' : 'rounded' ?> border border-3 border-primary shadow"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        </a>


                        <button class="btn btn-danger btn-sm w-100"
                            onclick="productImageDelete('<?= $imgData['uid'] ?>')">
                            Delete
                        </button>

                    </div>
                <?php endforeach; ?>
            </div>
            <form id="productForm" method="post" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <label for="company_logo">Uploaded Product Image</label>
                    <input type="file" name="images[]" id="imageInput" class="form-control" accept="image/*" multiple disabled>
                </div>
                <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>
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
        <button type="button" id="submitProductinputs" class="">
            Update
        </button>
        </form>



    </div>





    <script>
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        let selectedImages = [];

        imageInput.addEventListener('change', (event) => {
            const files = Array.from(event.target.files);

            files.forEach((file) => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const imageUrl = e.target.result;

                    const wrapper = document.createElement('div');
                    wrapper.className = 'position-relative';
                    wrapper.style.width = '100px';
                    wrapper.style.height = '100px';

                    const img = document.createElement('img');
                    img.src = imageUrl;
                    img.className = 'img-thumbnail';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.onclick = () => {
                        previewContainer.removeChild(wrapper);
                        selectedImages = selectedImages.filter(i => i !== file);
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                    selectedImages.push(file);
                };

                reader.readAsDataURL(file);
            });

            imageInput.value = ''; // reset to allow re-selecting same file
        });

        // Submit logic
        document.getElementById('submitProductinputs').addEventListener('click', function() {
            const formData = new FormData();
            console.log("formData:", formData);

            formData.append('uid', '<?= $resp['uid'] ?? "" ?>'); // ensure uid is sent


            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('content', document.getElementById('content').value);
            formData.append('category', document.getElementById('category').value);
            formData.append('subcategory', document.getElementById('subcategory_id').value);

            selectedImages.forEach((file) => {
                formData.append('images[]', file);
            });

            $.ajax({
                url: BASE_URL + "/vendor/api/product/edit-product",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert("Product updated successfully.");
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function() {
                    alert("An error occurred while updating the product.");
                }
            });
        });
    </script>

    <script>
        function productImageDelete(imageID) {
            console.log("Deleting image with ID:", imageID);

            if (confirm("Are you sure you want to delete this image?")) {
                $.ajax({
                    url: BASE_URL + "/vendor/api/product/image-delete",
                    type: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        uid: imageID
                    }),
                    success: function(response) {
                        if (response.success) {
                            alert("Image deleted successfully.");
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert("Error deleting image: " + response.message);
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the image.");
                    }
                });
            }

        }
    </script>

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