<?php 
$chip_value = "";
if(isset($this->session->userdata['chips_filter_session'])){
	$session_data = $this->session->userdata('chips_filter_session');
	$chip_value = $session_data['chips_filter_val'];
}
$show_chips_filter_array = array('all' => 'All Chips', '1' => 'Standard Chips Only','2' => 'Cloning Chip Only');
?>
<div id="right-container">
<div class="site-form form-inline">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <div class="row">
      <!--<div class="col-sm-6">
      	<div class="form-group">
        	 <label>Show</label>
             <select class="form-control show_chips_filter" style="width: auto;">
             	<?php foreach($show_chips_filter_array as $chip_key => $chips){
					if($chip_value == $chip_key){
						$selected = 'selected';
					}else{
						$selected = '';
					}?>
                <option value="<?php echo $chip_key;?>" <?php echo $selected;?>><?php echo $chips;?></option>
                <?php }?>
             </select>
      	</div>
      </div>
      <div class="col-sm-6">
        <form method="post" id="globalSearchKyes">
            <div class="form-group">                     
                  <input type="text" name="search_global_key" class="form-control search_global_key">
                  <button type="submit" class="btn btn-primary custom-button" name="search" value="chips">Search</button>
            </div>
        </form>
      </div>-->
      <div class="col-sm-24">
        <div class="form-group pull-right">          
          <a href="<?php echo adm_base_url();?>home/add_key_blade" class="btn btn-danger"  title="Add key Blade">Add key Blade</a>        
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
      <?php if($this->session->flashdata('message_display')){?>
    	<?php echo $this->session->flashdata('message_display');?>
     <?php } ?>
        <form class="site-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <div class="table-responsive chips_data">
            <table class="table table-striped table-data mar0">
              <thead>
                <tr>
				  <th style="width:137px">Action</th>
                  <th>ID</th>                                  
                  <th> Name 
                  <!--  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom chips_sorting" data-by="Key_Blade_name" data_id="DESC"></a>-->
                  </th>
                  <th>Images 
                  <!--  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom chips_sorting" data-by="Key_Blade_Image_url" data_id="DESC"></a>-->
                  </th>                 
                  
                  <th>Description
                 <!-- <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom chips_sorting" data-by="Key_Blade_dec" data_id="DESC"></a>-->
                  </th>              
                  
                </tr>
              </thead>
              <tbody>
              <?php 
			  $i =1;
			  foreach($getAllKeyBladeDetail as $value){?>
                    <tr>					                     
                       <td><a  href="<?php echo adm_base_url();?>home/edit_key_blade/<?php echo $value['id'];?>" type="button" class="btn btn-success" >Edit</a>   
                      <a  href="javascript:void(0)" onclick="DeleteChipsFunction(<?php echo $value['id'];?>, '<?php echo adm_base_url();?>home/deletekeyblade/')" type="button"class="btn btn-danger" >Delete</a></td>
					    <td><?php echo $value['id'];?></td>     
					   
                                     
                      <td>
					  <span class="td_data"><?php echo $value['Key_Blade_name'];?></span>
          
                      </td>
                      <td>
                      <?php
						  $images = $value['Key_Blade_Image_url'];
						  if($images ==""){					  
						  }else{
							echo '<span class="td_data"><img class="customImage" src ="'.aks_img_url().$images.'"></span>';
						  }					  
					  ?>
                    
                  	</td>    
                      <td><span class="td_data"><?php echo $value['Key_Blade_dec'];?></span>
                      </td>
                      
                      </tr>
                    </tr> 
				<?php }?>
               </tbody>
            </table>
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
