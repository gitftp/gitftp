<form role="form" method="POST" action="" name="propertyaddform" id="propertyaddform" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-3">
        <label>Builder Name</label>
        <select class="form-control" name="builder_name" placeholder="Property Bed">
            <option value="">-select-</option>
            <?php
            foreach ($builder as $key => $value) {
                if ($pt_data['builder_id'] == $value['builder_id']) {
                    echo '<option selected="selected" value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>';
                } else {
                    echo '<option value="' . $value['builder_id'] . '">' . $value['builder_name'] . '</option>';
                }
            }
            ?>
        </select>                      
    </div>

    <div class="col-lg-3">
        <label>Property Name</label>
        <input class="form-control" name="property_name" placeholder="Property Name" value="<?php echo $pt_data['property_name']; ?>">
    </div>

    <div class="col-lg-3">
        <label>Property Status</label>
        <select class="form-control" name="property_conduction" placeholder="Property Bed" >
            <option value="">-select-</option>
            <option value="5">Furnished</option>
            <option value="6">Semi Furnished</option>
            <option value="7">Fully Furnished</option>      
        </select>                              
    </div>

    <div class="col-lg-3">
        <label>Property Type</label>
        <select class="form-control" name="property_type" placeholder="Property Bed">
            <option value="">-select-</option>
            <option value="1">Flat</option>
            <option value="2">Project</option>
            <option value="3">Bunglow</option>
            <option value="4">Commerical</option>
        </select> 
    </div>

</div>
<div style="height: 10px;"></div>
<div class="row">
    <div class="form-group">
        <div class="col-lg-3">
            <label>Property Location</label>
            <select class="form-control" name="location" placeholder="Property Bed">
                <option value="">-select-</option>
                <?php
                foreach ($location as $key => $value) {
                    if ($pt_data['location'] == $value['location_Id']) {
                        echo '<option selected="selected" value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                    } else {

                        echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
                    }
                }
                ?>
            </select>                    
        </div>

        <div class="col-lg-3">
            <label>Property Address</label>
            <textarea class="form-control" name="property_address" placeholder="Property Address"><?php echo $pt_data['property_address']; ?></textarea>
        </div>
        <div class="col-lg-3">
            <label>Sector</label>
            <input class="form-control" name="property_sector" placeholder="Sector" value="<?php echo $pt_data['sector']; ?>">                     
        </div>
        <div class="col-lg-3">
            <label>Property Desc</label>
            <textarea class="form-control" name="property_desc" placeholder="Property Desc"><?php echo $pt_data['property_desc']; ?></textarea>
        </div>

    </div>
</div>

<div style="height: 10px;"></div>
<div class="row">
    <div class="form-group">

        <div class="col-lg-3">
            <label>Project Details</label>
            <input class="form-control" name="project_details" placeholder="Project Details Ex 1 BHK, 2 BHK" value="<?php echo $pt_data['project_details']; ?>">                     
        </div>
        <!--        <div class="col-lg-3">
                    <label>Floor No</label>
                    <select class="form-control" name="floorno" placeholder="Property Bed">
                        <option value="">-select-</option>
                        <option>Ground Floor</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>                      
                </div>-->
        <div class="col-lg-3">
            <label>Price</label><br>
            <input type="text" name="property_price" class="form-control" value="<?php echo $pt_data['property_price']; ?>">
        </div>

    </div>
</div>
<div style="height: 10px;"></div>
<div class="row">
    <div class="form-group">

        <div class="col-lg-3">
            <label>No of Bedroom</label>
            <select class="form-control" name="bedrooms" placeholder="Property Bed">
                <option value="">-select-</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>                      
        </div>
        <div class="col-lg-3">
            <label>No of Bathroom</label>
            <select class="form-control" name="bathrooms" placeholder="Property Bed">
                <option value="">-select-</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>                      
        </div>
        <div class="col-lg-3">
            <label>Floor no</label>
            <input type="text" name="floor_no" class="form-control" value="<?php echo $pt_data['floorno']; ?>">       
        </div>
        <div class="col-lg-3">
            <label>Building Floor</label>
            <input type="text" name="building_floors" class="form-control" value="<?php echo $pt_data['building_floors']; ?>">      
        </div>
    </div>
</div>