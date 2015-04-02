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
        <?php // print_r($details); ?>
        <?php 

            if(empty($details)){
                echo '<tr><td colspan="2"><strong>NO DETAILS.</strong></td></tr>';
            }else{
                
            foreach ($details as $key => $value) {
         ?>
            <tr>
                <td>
                    <strong>Contact name:</strong> <?php echo $value['contact_name'] ?> <br>
                    <strong>Contact no.:</strong> <?php echo $value['contact_no'] ?> <br>
                    <strong>Contact address:</strong> <?php echo $value['contact_address'] ?> <br>
                    <strong>Contact other:</strong> <?php echo $value['contact_other'] ?> <br>
                    <strong>Property id:</strong> <?php echo $value['property_id'] ?> <br>
                </td>
                <td>
                    <strong>Created date:</strong> <?php echo $value['create_date'] ?> <br>
                </td>
            </tr>
        <?php 
            }}
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