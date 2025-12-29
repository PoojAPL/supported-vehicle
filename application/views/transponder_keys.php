<div id="right-container">
  <div class="site-form form-inline">
    <div class="row">
    <div class="col-sm-3">
          <form method="post" action="<?php echo adm_base_url();?>vehicles/exportdata">
              <input type="hidden" name="table_name" value="transponder_key_information" />
              <button class="btn btn-info" type="submit">Export Data</button>
          </form>
      </div>
      <div class="col-sm-9">
          <form method="post" onsubmit="return confirmSubmit();" action="<?php echo adm_base_url();?>vehicles/importdata" enctype="multipart/form-data">
              <input type="hidden" name="table_name" value="transponder_key_information" />
              <input type="hidden" name="redirect" value="vehicles/transponder_keys" />
              <input style="width:250px !important;" type="file" required class="form-control" name="import_file" />
              <button type="submit" class="btn btn-success" type="submit">Import Data</button>
          </form>
      </div>
      <div class="col-sm-12">
        <div class="form-group addCodeSeries">          
          <a href="<?php echo adm_base_url();?>vehicles/add_transponder_keys" class="btn btn-danger"  title="Sign Out">Add New Key</a>        
        </div>
      </div>
    </div>
</div>
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
                  <th></th>              
                  <th> Name </th>
                  <th> Chip </th>
                  <th> Reuseable </th>
                  <th> Cloneable </th>
                  <th> Test Blade </th>
                  <th> Reserved </th>
                  <th style="width: 137px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i =1;
                foreach($results as $value){?>
                    <tr> 
                        <td><?php echo $value['id'];?></td>  
                        <td>
                        <?php if($value['image'] !=""){
                            $file_path = $value['image'];
                            $mime_type = mime_content_type($file_path);
                            if ($mime_type === 'image/svg+xml') {
                                echo $value['image'];
                            }else{?>
                            <img width="100" src="<?php echo $value['image'];?>" alt="">
                            <?php } 
                          }?>
                        </td>                  
                        <td><?php echo $value['name'];?></td>
                        <td><?php echo $value['chip'];?></td>
                        <td><?php echo $value['reuseable'];?></td>
                        <td><?php echo $value['cloneable'];?></td>
                        <td><?php echo $value['test_blade'];?></td>
                        <td><?php echo $value['reserved'];?></td>
                        <td>
                        <a  href="<?php echo adm_base_url();?>vehicles/edit_transponder_keys/<?php echo $value['id'];?>" type="button" class="btn btn-success">Edit</a> 
                        <a  href="javascript:void(0)" onClick="DeleteKeytype(<?php echo $value['id'];?>, '<?php echo adm_base_url();?>vehicles/delete_transponder_keys/')" type="button"class="btn btn-danger">Delete</a>        </td>
                     
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