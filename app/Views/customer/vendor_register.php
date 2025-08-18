 <section class="py-5">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-md-6">
                 <form id="vendorForm" enctype="multipart/form-data" action="#" method="post">
                     <div class="d-flex flex-column gap-3">
                         <div class="position-relative p-4 rounded-10 bg-light border overflow-hidden text-center">

                             <div class="d-inline-flex mb-1">
                                 <img id="avatarPreviewVendor" src="<?= base_url('assets/customer/images/upload-image.svg') ?>" alt="Avatar Preview" class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                             </div>
                             <strong class="d-block mb-1">Upload Logo*</strong>
                             <small class="d-block" style="color:#666">Choose a clear Logo to help others recognize you. JPG, PNG, or GIF formats are supported. Max size: 2MB.</small>
                             <input style="opacity: 0;"
                                 class="form-control position-absolute start-0 end-0 top-0 bottom-0"
                                 name="image"
                                 type="file"
                                 id="avatarInputVendor"
                                 accept="image/*" required>

                         </div>

                         <div class="position-relative">
                             <input type="text" name="name" class="form-control" placeholder="Name*" required>
                         </div>
                         <div class="position-relative">
                             <input type="email" name="email" class="form-control" placeholder="Email id*" required>
                         </div>
                         <div class="position-relative">
                             <input type="tel" name="mobile" class="form-control" placeholder="Phone Number*" required>
                         </div>
                         <div class="position-relative">
                             <input type="text" name="company" class="form-control" placeholder="Company Name*" required>
                         </div>
                         <div class="position-relative">
                             <input type="number" name="gst" class="form-control" placeholder="GST/Tax ID">
                         </div>
                         <div class="position-relative">
                             <input type="url" name="website" class="form-control" placeholder="Website" required>
                         </div>

                         <div class="position-relative">
                             <input type="text" name="country" class="form-control" placeholder="Country*" required>
                         </div>
                         <div class="position-relative">
                             <input type="text" name="states" class="form-control" placeholder="State*" required>
                         </div>
                         <div class="position-relative">
                             <input type="text" name="city" class="form-control" placeholder="City*" required>
                         </div>
                         <div class="position-relative">
                             <textarea name="address" class="form-control" rows="3" placeholder="Address*" required></textarea>
                         </div>


                         <!-- <div class="position-relative">
                              <input type="password" name="password" class="form-control" placeholder="Password">
                         </div> -->
                         <!-- <div class="form-check">
                             <input class="form-check-input" type="checkbox" value="" id="Remember" checked>
                             <label class="form-check-label" for="Remember">Remember me</label>
                         </div> -->
                         <button id="vendorRegisterBtn" type="submit" class="btn btn-primary justify-content-center w-100">Register</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </section>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     document.getElementById("avatarInputVendor").addEventListener("change", function(event) {
         console.log("input");

         const file = event.target.files[0];
         if (file && file.type.startsWith("image/")) {
             const reader = new FileReader();
             reader.onload = function(e) {
                 document.getElementById("avatarPreviewVendor").src = e.target.result;
             };
             reader.readAsDataURL(file);
         }
     });
     document.getElementById("vendorForm").addEventListener("submit", function(e) {
         e.preventDefault();

         let form = document.getElementById("vendorForm");
         let submitBtn = document.getElementById("vendorRegisterBtn");

         // Disable the button
         submitBtn.disabled = true;
         submitBtn.textContent = "Please wait...";

         let formData = new FormData(form);

         fetch("https://devs.v-xplore.com/foundry/admin/api/created-vendor", {
                 method: "POST",
                 body: formData
             })
             .then(async (response) => {
                 const res = await response.json();

                 if (response.ok && res.success) {
                     Swal.fire({
                         title: 'Success!',
                         text: 'Thank you for registering with Foundry as a vendor.',
                         icon: 'success',
                         confirmButtonText: 'OK'
                     });
                     setTimeout(function() {
                         window.location.href = "https://devs.v-xplore.com/foundry/";
                     }, 2000);

                 } else {
                     alert("Error: " + (res.message || "Failed to create vendor."));
                     // Re-enable the button
                     submitBtn.disabled = false;
                     submitBtn.textContent = "Register";
                 }
             })
             .catch(error => {
                 console.error("Request error:", error);
                 alert("Something went wrong. Please try again.");

                 // Re-enable the button
                 submitBtn.disabled = false;
                 submitBtn.textContent = "Register";
             });
     });
 </script>