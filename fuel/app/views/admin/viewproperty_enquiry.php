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
                      <th></th>
                        <th>
                            Details1
                        </th>
                        <th>
                            Details2
                        </th>
                    </tr>
                    <?php // print_r($details); ?>
                    <?php
                    if (empty($details)) {
                        echo '<tr><td colspan="3"><strong>NO DETAILS.</strong></td></tr>';
                    } else {

                        foreach ($details as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td>
                                    <strong>Name:</strong> <?php echo $value['name'] ?> <br>
                                    <strong>Mobile no.:</strong> <?php echo $value['mobileno'] ?> <br>
                                    <strong>Email:</strong> <?php echo $value['email'] ?> <br>
                                    <strong>Customer type:</strong> <?php echo $value['customer_type'] ?> <br>
                                </td>
                                <td>
                                    <strong>Status:</strong> <?php echo $value['status'] ?> <br>
                                    <strong>Comments:</strong> <?php echo $value['comments'] ?> <br>
                                    <strong>Date:</strong> <?php echo $value['enquiry_date'] ?> <br>
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