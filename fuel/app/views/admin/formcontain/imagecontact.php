<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Images</h1>
    </div>
</div>
<div class="form-group">
    <div class="row addimageshere">
        <div class="col-lg-12">
            <h4>Main Image</h4>
        </div>
        <div class="col-lg-4">
            <img src="<?php echo Uri::base(false) . 'assets/img/property/' . $property_id . '-1.jpg'; ?>" style="width: 100%;"/>
            <div style="height: 10px;"></div>
            <input type="file" name="imageup1" id="imageup1" class="form-control">
        </div>
    </div>
    <hr>
    <div class="row addimageshere">
        <div class="col-lg-12">
            <h4>Project Details</h4>
        </div>
        <?php foreach ($pt_img_detail as $key => $value) { ?>
            <div class="col-lg-3">
                <img src="<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name']; ?>" style="width: 100%;"/>
                <a data-id="<?php echo $value['img_gall_id']; ?>" data-filename="<?php echo $value['img_name']; ?>" class="admin-deleteimage" href="#">&times; Delete</a>
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <div style="height: 10px"></div>
            <p class="text-info">Add new images</p>
            <input type="file" name="imageup2[]" multiple="" id="imageup2" class="form-control">
        </div>
    </div>
    <hr>
    <div class="row addimageshere">
        <div class="col-lg-12">
            <h4>Floor Plan</h4>
        </div>
        <?php foreach ($pt_img_floor as $key => $value) { ?>
            <div class="col-lg-3">
                <img src="<?php echo Uri::base(false) . 'assets/img/property/' . $value['img_name']; ?>" style="width:100%;"/>
                <a data-id="<?php echo $value['img_gall_id']; ?>" data-filename="<?php echo $value['img_name']; ?>" class="admin-deleteimage" href="#">&times; Delete</a>
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <div style="height: 10px"></div>
            <p class="text-info">Add new images</p>
            <input type="file" name="imageup3[]" multiple="" id="imageup3" class="form-control">
        </div>
    </div>
</div>
<div style="height: 10px;"></div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Video</h1>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-4">
            <input type="url" name="Video1" id="Video1" class="form-control" placeholder="Ex: youtube.com/watch?v=ID4_TQCH-QI">
            <p>Add youtube URL followed by youtube.com</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Contact</h1>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-3">
            <label>Contact Name</label>
            <input class="form-control" name="contact_name" placeholder="Contact Name" value="">  
        </div>
        <div class="col-lg-3">
            <label>Contact No</label>
            <input class="form-control" name="contact_no" placeholder="Contact No" value="">  
        </div>
    </div>
</div>
