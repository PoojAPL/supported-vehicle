<div id="right-container">
  <form class="site-form form-inline">
    <div class="row">      
      <div class="col-sm-24">
        <div class="form-group addmakesButton">          
          <a href="<?php echo adm_base_url();?>/vehicles/add_makes" class="btn btn-danger"  title="Sign Out">Add New Make</a>        
        </div>
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
      <?php if($this->session->flashdata('message_display')){?>
    		<?php echo $this->session->flashdata('message_display');?>
     <?php } ?>
	 <div class="return_msg"></div>
        <form class="site-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <div class="table-responsive make_users chips_data">
            <table class="table table-striped table-data mar0">
              <thead>
                <tr> 
				<th>Sr.no</th> 
					<th></th>                
                 <th> Name <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom " data_id="DESC" id="sortlist" data-angle ="bottom" ></a> </th>
                  <th style="width: 137px;">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
			  $i =1;
			  foreach($getAllMakeNames as $users){?>
                    <tr>
					<td style="width:3px"><?php  echo $i++;?></td>
					 <td style="width:50px" >				
					  <label class="i-checks">
						<input type="checkbox" class="delete_checkbox_makes" value="<?php echo $users['id'];?>"><i></i> 
					  </label>					
					</td>
                     <td>
                     	<span class="td_data"><?php echo $users['Make_Name'];?></span>
                    	<span class="glyphicon glyphicon-pencil edit_chips_inputs" aria-hidden="true" data-val="<?php echo $users['Make_Name'];?>" data-id="<?php echo $users['id'];?>" data-col="Make_Name" data-table="t_Makes" data-img=""></span><div class="get_column_data"></div>
                     </td>
                      <td><a  href="<?php echo adm_base_url();?>/vehicles/edit_MakeName/<?php echo $users['id'];?>" type="button" class="btn btn-success" >Edit</a>   
                      <a  href="javascript:void(0)" onclick="DeleteMakeName(<?php echo $users['id'];?>, '<?php echo adm_base_url();?>/vehicles/deletemakesname/')" type="button"class="btn btn-danger" >Delete</a>
                      </td>
                    </tr>
			  <?php }  ?>                
               </tbody>
            </table><br>
			<div><a  href="javascript:void(0)" id="delete_all_makes" type="button" name="delete_all_makes"  class="btn btn-danger">Delete All</a></div>
			<?php if(isset($links)){?>
			  <nav class="site-pg">
				 <ul class="pagination">               
					<?php foreach ($links as $link) {
							echo '<li>'. $link.'</li>';
					} ?>	
				   </ul>
				   </nav>
			<?php }?>	
          </div>
        </form>
      </section>
    </div>
  </div>
</div>

<!-- right container start here -->
