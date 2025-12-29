<div id="right-container">
 
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
      <?php if($this->session->flashdata('message_display')){?>
    	 <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>	
     <?php } ?>
        <form class="site-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <div class="table-responsive make_users chips_data">
            <table class="table table-striped table-data mar0">
              <thead>
                <tr>  
                  <th>ID</th>                
                  <th> User </th>
                  <th> Activity </th>
                  <th> Date </th>
                  <th> Data </th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i =1;
                foreach($results as $value){
                    $oldValues = json_decode($value['old_value'],true);
                    $newValues = json_decode($value['new_value'],true);
                    $changes = compareArrays($oldValues, $newValues);
                    ?>
                    <tr> 
                        <td><?php echo $value['id'];?></td>                   
                        <td><?php echo $value['user_id'];?></td>
                        <td><?php echo $value['activity'];?></td>
                        <td><?php echo $value['date'];?></td> 
                        <td>
                        <table class="table" style="font-size: 12px;border: 1px solid #ccc;">
                            <tr>
                                <th>Field Name</th>
                                <th>Old</th>
                                <th>New</th>
                            </tr>
                            <?php 
                                // echo '<pre>';
                                // print_r($changes);
                                // echo '</pre>';
                                foreach($changes as $field_name => $values){?>
                                  
                                    <tr>
                                        <td><?php echo $field_name;?></td>
                                        <td><?php echo $values['old'];?></td>
                                        <td><?php echo $values['new'];?></td>
                                    </tr>
                                   
                                <?php }
                            ?>
                            </table>
                        </td>
                                            
                    </tr> 
                <?php }?>
               </tbody>
            </table>
          </div>
        </form>
      </section>
    </div>
  </div>
</div>

<!-- right container start here -->
<script>
function confirmSubmit() {
    var isConfirmed = confirm("Are you sure you want to submit the form?");
    return isConfirmed;
}
</script>