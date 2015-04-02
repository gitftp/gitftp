<div class="modal" style="display:block">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="$('.modal').remove()" class="close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $title ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Details1
                        </th>
                        <th>
                            Details2
                        </th>
                    </tr>
                    <?php
                    if (empty($details)) {
                        echo '<tr><td colspan="2"><strong>NO DETAILS.</strong></td></tr>';
                    } else {

                        foreach ($details as $key => $value) {
                            ?>
                            <tr>
                                <td>
                                    <strong>Property id:</strong> <?php echo $value['property_id'] ?> <br>
                                    <strong>Property type:</strong> <?php echo $value['type'] ?> <br>
                                    <strong>BHK:</strong> <?php $floor = idconvert::get_floor($value['bhk']);                    echo $floor[0]['floor_name']; ?> <br>
                                    <strong>Area:</strong> <?php echo $value['size'] ?> sqft.<br>
                                </td>
                                <td>
                                    <strong>Price per:</strong> <?php echo $value['priceper'] ?> Rs.<br>
                                    <strong>Total price:</strong> <?php echo $value['totalprice'] ?> <br>
                                    <strong>Visibility:</strong> <?php echo $value['visibility'] ?> <br>
                                    <strong>create date:</strong> <?php echo date("d-M-Y H:m", strtotime($value['create_date'])); ?> <br>

                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>

            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->