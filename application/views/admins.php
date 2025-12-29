<div id="right-container">
  <form class="site-form form-inline">
    <div class="row">
      
      <div class="col-sm-24">
        <div class="form-group addCodeSeries">          
          <a href="<?php echo adm_base_url();?>home/add_admins" class="btn btn-danger"  title="Sign Out">Add New Admin</a>        
        </div>
      </div>
    </div>
  </form>
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
                  <th> Username </th>
                  <th> Email </th>
                  <th> Company </th>
                  <th> Active </th>
                  <th style="width: 137px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i =1;
                foreach($results as $value){?>
                    <tr> 
                        <td><?php echo $value['UserID'];?></td>                   
                        <td><?php echo $value['user_name'];?></td>
                        <td><?php echo $value['email'];?></td>
                        <td><?php echo $value['Company'];?></td>
                        <td><?php echo $value['APP_switcher'];?></td>
                        <td>
                            <a  href="<?php echo adm_base_url();?>home/edit_admins/<?php echo $value['UserID'];?>" type="button" class="btn btn-success">Edit</a> 
                            <a  href="javascript:void(0)" onClick="DeleteKeytype(<?php echo $value['UserID'];?>, '<?php echo adm_base_url();?>home/delete_admins/')" type="button"class="btn btn-danger">Delete</a>        
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
