<!--property Details start-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Property Details</h1>
    </div>
</div>
<?php
$count = 0;
foreach ($pt_details as $key => $value) {
    ?>
    <div class="row addrow-row">
        <!-- /.col-lg-12 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label>Type:</label>
                <!-- <input class="form-control" name="project_type_<?php echo $count; ?>" placeholder="Type" value="<?php echo $value['type']; ?>"> -->
                
                <select class="form-control" name="" id="project_type_<?php echo $count; ?>">
                    <option value="Resisdent" <?php if($value['type'] == 'Resisdent'){ echo 'checked';} ?>>Resisdent</option>
                    <option value="Commercial" <?php if($value['type'] == 'Commercial'){ echo 'checked';} ?>>Commercial</option>
                </select>

                <input class="form-control id" type="hidden" name="project_details_id_<?php echo $count; ?>" placeholder="Type" value="<?php echo $value['property_details_id']; ?>">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>BHK: </label>
                <select class="form-control bhk" name="bhk_<?php echo $count; ?>" placeholder="">
                            <option value="">-select-</option>
                    <?php
                    foreach ($room as $key2 => $value2) {
                        if ($value['bhk'] == $value2['floor_id']) {
                            echo '<option selected="selected" value="' . $value2['floor_id'] . '">' . $value2['floor_name'] . '</option>';
                        } else {
                            echo '<option value="' . $value2['floor_id'] . '">' . $value2['floor_name'] . '</option>';
                        }
                    }
                    ?>
                </select>   
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Size:</label>
                <input class="form-control calculate-size" name="size_<?php echo $count; ?>" placeholder="" value="<?php echo $value['size']; ?>">                     
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Rent/Month:</label>
                <input class="form-control calculate-price" name="price_per_<?php echo $count; ?>" placeholder="" value="<?php echo $value['priceper']; ?>">                     
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Total:</label>
                <input class="form-control calculate-total" name="total_<?php echo $count; ?>" placeholder="" value="<?php echo $value['totalprice']; ?>">                     
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group">
                <label>Visibility:</label>
                <input type="checkbox" name="property_visibility_<?php echo $count; ?>">
            </div>
        </div>
    </div>
    <?php
    ++$count;
}
?>
<!--property details ends-->
<!--Entry String value-->

<!--<button class="addrow btn btn-primary">Add row</button>-->
<script>
    window.adminpropertydetails = true;
</script>