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
                    <strong>id:</strong> <?php echo $value['distance_id'] ?> <br>
                    <strong>Hospital distance:</strong> <?php echo $value['hospital_dis'] ?> <br>
                    <strong>School distance:</strong> <?php echo $value['school_dis'] ?> <br>
                    <strong>Railway distance:</strong> <?php echo $value['railway_dis'] ?> <br>
                    <strong>Airport distance:</strong> <?php echo $value['airport_dis'] ?> <br>
                </td>
                <td>
                    <strong>City center:</strong> <?php echo $value['city_center'] ?> <br>
                    <strong>Bus depot:</strong> <?php echo $value['bus_depot'] ?> <br>
                    <strong>location desc:</strong> <?php echo $value['location_desc'] ?> <br>
                    <strong>property id:</strong> <?php echo $value['property_id'] ?> <br>
                    <strong>Created on:</strong> <?php echo date("d-M-Y H:m", strtotime($value['create_date'])); ?> <br>
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