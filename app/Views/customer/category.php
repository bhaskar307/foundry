<section class="py-md-5 py-4">
    <div class="container">
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
            <?php if ($category) {
                foreach ($category as $row) {
                    $uid = $row['uid'];
            ?>
                <div class="col-6 col-lg-3">
                    <a 
                        href="javascript:void(0);" 
                        class="position-relative rounded-10 overflow-hidden d-block topCatThmb" 
                        onclick="handleCategoryClick(this)"
                        data-uid="<?= $uid ?>"
                    >
                        <img src="<?= base_url($row['image']) ?>" alt="" class="w-100 object-fit-cover" style="height: 350px;">
                        <div class="position-absolute rounded-10 p-3 text-center topCatmask">
                            <h5 class="mb-2"><?= $row['title'] ?></h5>
                            <div class="btn btn-primary h-auto">Explore Category</div>
                        </div>
                    </a>
                </div>
            <?php 
                } 
            } 
            ?>    
        </div>
    </div>
</section>

<script>
function handleCategoryClick(element) {
    const uid = element.getAttribute('data-uid');

    const categoryData = [uid];

    const filterData = {
        categories: categoryData,
        price: {
            from: '0',
            to: '50000'
        }
    };

    const jsonStr = JSON.stringify(filterData);
    const base64 = btoa(jsonStr);
    const url = "<?= base_url('product-list?filter=') ?>" + encodeURIComponent(base64);
    window.location.href = url;
}
</script>
