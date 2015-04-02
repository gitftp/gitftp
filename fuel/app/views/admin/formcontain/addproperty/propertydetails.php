<!--Entry String value-->
<?php
$field = 0;
for ($i = 0; $i < 5; $i++) {
    ?>
    <div class="row addrow-row">
        <!-- /.col-lg-12 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label>Type:</label>
                <!-- <input class="form-control" name="project_type_<?php // echo $i; ?>" id="project_type_<?php echo $i; ?>" placeholder="Type"> -->

                <select class="form-control" name="project_type_<?php echo $i; ?>" id="project_type_<?php echo $i; ?>">
                    <option value="Resisdent">Resisdent</option>
                    <option value="Commercial">Commercial</option>
                </select>

                <input class="form-control" type="hidden" name="project_details_id_<?php echo $i; ?>" placeholder="Type" value="novalue">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>BHK: </label>
                <select class="form-control bhk" name="bhk_<?php echo $i; ?>" id="bhk_<?php echo $i; ?>" placeholder="">
                    <option value="">-select-</option>
                    <?php
                    foreach ($room as $key => $value) {
                        echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
                    }
                    ?>
                </select>   
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Size:</label>
                <input class="form-control calculate-size" name="size_<?php echo $i; ?>" id="size_<?php echo $i; ?>" placeholder="">                     
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Price/Per:</label>
                <input class="form-control calculate-price" name="price_per_<?php echo $i; ?>" id="price_per_<?php echo $i; ?>" placeholder="">                     
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>Total:</label>
                <input class="form-control calculate-total" name="total_<?php echo $i; ?>" id="total_<?php echo $i; ?>" placeholder="">                     
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group">
                <label>Visibility:</label>
                <input type="checkbox" name="property_visibility_<?php echo $i; ?>" id="property_visibility_<?php echo $i; ?>" value="Yes">
            </div>
        </div>
    </div>
    <?php
}
?>

<!--<button class="addrow btn btn-primary">Add row</button>-->
<script>
    window.adminpropertydetails = true;
</script>