<form class="form-inline">
    <label>Search</label>
    &nbsp;
    &nbsp;
    <div class="form-group">
        <select name="property_sale_type" id="property_sale_type" class="form-control">
            <option value="1">Sale</option>
            <option value="2">Rent</option>
        </select>
    </div>
    <div class="form-group">
        <select name="location" id="location" class="form-control" >
            <option value="">Location</option>
            <?php
            foreach (idconvert::get_nav_details('location') as $key => $value) {
                echo '<option value="' . $value['location_Id'] . '">' . $value['locality_name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="bedrooms" id="bedrooms" class="form-control">
            <option value="">BHK</option>
            <?php
            foreach (idconvert::get_floor() as $key => $value) {
                echo '<option value="' . $value['floor_id'] . '">' . $value['floor_name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="property_price" id="property_price" class="form-control">
            <option value="">Price</option>
            <?php foreach (idconvert::get_budget(1) as $key => $value) { ?>
                <?php echo '<option value="' . $value['budget_id'] . '">' . $value['budget'] . '</option>'; ?>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <select name="property_type" id="property_type" class="form-control">
            <option value="">Property Type</option>
            <?php
            $property_type = idconvert::get_data_model(array('table' => 'property_type'));
            foreach ($property_type as $key => $value) {
                echo '<option value="' . $value['type_id'] . '">' . $value['type_name'] . '</option>';
            }
            ?>  
        </select>
    </div>
    <div class="form-group">
        <select name="property_conduction[]" id="property_conduction" class="form-control">
            <option value="">Property Conduction</option>
            <?php
            $property_type = idconvert::get_data_model(array('table' => 'property_conduction'));
            foreach ($property_type as $key => $value) {
                echo '<option value="' . $value['conduction_id'] . '">' . $value['conduction_name'] . '</option>';
            }
            ?>  
        </select>
    </div>
    <button type="submit" class="btn btn-warning pull-right">Search</button>
</form>