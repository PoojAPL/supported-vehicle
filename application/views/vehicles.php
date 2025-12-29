<?php 
error_reporting(0);
$advanced_hide = '';
$advanced_checked = '';
 if(isset($_COOKIE['Advanced_cookie'])){ 
	 $cookieValue = $_COOKIE['Advanced_cookie'];
	 if( $cookieValue == 1){
		$advanced_hide = 'hide';
		$advanced_checked = 'checked';
	 }else{
		$machine_hide = '';
		$advanced_checked = '';
	 }
} 
$prolok_hide = '';
$prolok_checked = '';
 if(isset($_COOKIE['Prolok_cookie'])){ 
	 $cookieValue = $_COOKIE['Prolok_cookie'];
	 if( $cookieValue == 1){
		$prolok_hide = 'hide';
		$prolok_checked = 'checked';
	 }else{
		$prolok_hide = '';
		$prolok_checked = '';
	 }
 }
 
$code_keyInfo_hide = '';
$code_keyInfo_checked = '';
 if(isset($_COOKIE['code_keyInfo_cookie'])){ 
	 $cookieValue = $_COOKIE['code_keyInfo_cookie'];
	 if( $cookieValue == 1){
		$code_keyInfo_hide = 'hide';
		$code_keyInfo_checked = 'checked';
	 }else{
		$code_keyInfo_hide = '';
		$code_keyInfo_checked = '';
	 }
 }

$autopropad_hide = '';
$autopropad_checked = '';
 if(isset($_COOKIE['autopropad_cookie'])){ 
	 $cookieValue = $_COOKIE['autopropad_cookie'];
	 if( $cookieValue == 1){
		$autopropad_hide = 'hide';
		$autopropad_checked = 'checked';
	 }else{
		$autopropad_hide = '';
		$autopropad_checked = '';
	 }
 }
 
$hotwire_hide = '';
$hotwire_checked = '';
 if(isset($_COOKIE['hotwire_cookie'])){ 
	 $cookieValue = $_COOKIE['hotwire_cookie'];
	 if( $cookieValue == 1){
		$hotwire_hide = 'hide';
		$hotwire_checked = 'checked';
	 }else{
		$hotwire_hide = '';
		$hotwire_checked = '';
	 }
 }
$tko_sdd_hide = '';
$tko_sdd_checked = '';
 if(isset($_COOKIE['tko_sdd_cookie'])){ 
	 $cookieValue = $_COOKIE['tko_sdd_cookie'];
	 if( $cookieValue == 1){
		$tko_sdd_hide = 'hide';
		$tko_sdd_checked = 'checked';
	 }else{
		$tko_sdd_hide = '';
		$tko_sdd_checked = '';
	 }
 }

$dmaxcheckbox_hide = '';
$dmaxcheckbox_checked = '';
 if(isset($_COOKIE['dmaxcheckbox_cookie'])){ 
	 $cookieValue = $_COOKIE['dmaxcheckbox_cookie'];
	 if( $cookieValue == 1){
		$dmaxcheckbox_hide = 'hide';
		$dmaxcheckbox_checked = 'checked';
	 }else{
		$dmaxcheckbox_hide = '';
		$dmaxcheckbox_checked = '';
	 }
 } 
$hideimage_hide = '';
$hideimage_checked = '';
 if(isset($_COOKIE['hideimage_cookie'])){ 
	 $cookieValue = $_COOKIE['hideimage_cookie'];
	 if( $cookieValue == 1){
		$hideimage_hide = 'hide';
		$hideimage_checked = 'checked';
	 }else{
		$hideimage_hide = '';
		$hideimage_checked = '';
	 }
 } 
$hideParts_hide = '';
$hideParts_checked = '';
 if(isset($_COOKIE['hideParts_cookie'])){ 
	 $cookieValue = $_COOKIE['hideParts_cookie'];
	 if( $cookieValue == 1){
		$hideParts_hide = 'hide';
		$hideParts_checked = 'checked';
	 }else{
		$hideParts_hide = '';
		$hideParts_checked = '';
	 }
 }

$hideTypes_hide = '';
$hideTypes_checked = '';
 if(isset($_COOKIE['hideTypes_cookie'])){ 
	 $cookieValue = $_COOKIE['hideTypes_cookie'];
	 if( $cookieValue == 1){
		$hideTypes_hide = 'hide';
		$hideTypes_checked = 'checked';
	 }else{
		$hideTypes_hide = '';
		$hideTypes_checked = '';
	 }
 }   
 
$user_data = $this->session->userdata('login_user');
$user_username = $user_data['username'];


//$update_v_types = update_v_types(); 
//$insert_v_types = insert_v_types(); 

if(isset($this->session->userdata['vehicle_filter_type'])){
	$session_data = $this->session->userdata('vehicle_filter_type');
	$vehicle_type = $session_data['vehicle_type'];
}else{
	$vehicle_type = "";
}
 if(isset($_SESSION['search_key'])){
	 $search_key =  $_SESSION['search_key'];
 }else{
	 $search_key = "";
 }
 if(isset($_SESSION['make_id'])){	
	$make_id = $_SESSION['make_id'];
}else{
	$make_id = "";
}
 
?>
<script src="https://www.gstatic.com/firebasejs/3.6.3/firebase.js"></script>
<script src="<?php echo asset_url(); ?>admin/js/md5.js"></script>  
<!--<div class="fixedButton">
	<button class="btn btn-success">Vehicle Button</button>
</div>-->
<div id="right-container">
  <div class="site-form form-inline">
    <div class="row">
    	<div class="col-sm-5">
      	<div class="form-group">
        	 <label>Show Make</label>
             <select class="form-control select-field filterVehicleByMake">
             	<option value="All">All Make</option>
                <?php foreach($getAllMakeNames as $makes){
						if($makes['UUID'] == $make_id){
        					$selected = 'selected';
							echo $_SESSION['makeid'] = $makes['UUID'];
        				}else{
        					$selected = '';
							$_SESSION['makeid'] = "";
        			}?>
					<option value="<?php echo $makes['UUID'];?>" <?php echo $selected;?>><?php echo $makes['Make_Name'];?></option>
				<?php }	?>
             </select>
      	</div>
      </div>
      <div class="col-sm-5">
      	<div class="form-group ">
        	 <label>Show Model</label>
             <span class="getModels filterVehicleByModel">
             <select class="form-control select-field model">
				<?php
				if($make_id =='All'){}else{
					 $makeId =  $make_id;
					$getmodel = getmodel($makeId);					
						echo "<option value=''>Select model</option>";
						foreach($getmodel as $model){						
							if($model['UUID'] == $_SESSION['model_id']){
								$selected = 'selected';
							}else{
								$selected = '';
							}  
				?>
				<option value="<?php echo $model['UUID'];?>" <?php echo $selected;?>> <?php echo $model['Model_Name'];?></option>
						<?php } } ?>
				
             </select>
            </span>
      	</div>
      </div>
      <div class="col-sm-5">
      	<div class="form-group ">
        	 <label>Show Type</label>
             <select class="form-control select-field show_vehicle_by_type">
             	<option value="All">All Vehicles</option>
             	  <?php 
        				$vtype_array = vehicle_type_array();
        				foreach($vtype_array as $types){
        					if($types['UUID'] == $vehicle_type){
        						$selected = 'selected';
        					}else{
        						$selected = '';
        					}?>
                	<option value="<?php echo $types['UUID'];?>" <?php echo $selected;?>><?php echo $types['type'];?></option>
                <?php  } ?>             	
             </select>
            </span>
      	</div>
      </div>
      <div class="col-sm-7">
            <form method="post" id="searchVehicles">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="form-group">                     
                     <input type="text" name="search_key" class="form-control search_key" style="width: 200px;" placeholder="Enter at least 3 characters for searching"  value="<?php echo $search_key;?>" />
                     <button type="submit" class="btn btn-primary custom-button" >Search</button>
                </div>
            </form>
      </div>
    	<div class="col-sm-2">
        <div class="form-group addCodeSeries">          
          <a href="<?php echo adm_base_url();?>vehicles/add_vehicle" class="btn btn-danger" >Add New Vehicle</a>        
        </div>
      </div>      
    </div><br>
    <div class="row">
      <div class="col-sm-5">
        <div class="form-group">          
          <a href="javascript:void(0)" class="btn btn-primary showMissingCodeSeries">Show All Missing Code Series</a>    
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">          
          <a href="javascript:void(0)" class="btn btn-danger ShowAutoProPADOnly">Show AutoProPAD Only</a>    
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">          
          <a href="javascript:void(0)" class="btn btn-info showMissingImages">Show All Missing Images</a>    
        </div>
      </div>
      <div class="col-sm-3">
          <div class="form-group">          
            <a href="<?php echo adm_base_url();?>home/export_vehicles_info" target="_blank" class="btn btn-primary">Export to CSV</a>    
          </div>
      </div>
      <div class="col-sm-8">
          <form method="post" onsubmit="return confirmSubmit();" action="<?php echo adm_base_url();?>vehicles/import_vehicles_info" enctype="multipart/form-data">
              <input style="width:250px !important;" type="file" required="" class="form-control" name="import_file">
              <button type="submit" class="btn btn-success">Import Vehicle Data</button>
          </form>
      </div>
    </div>
    <br>
  </div>
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box vehicles_checkbox">
      <?php if($this->session->flashdata('message_display')){?>
    	<?php echo $this->session->flashdata('message_display');?>
     <?php }  ?>
        <input type="checkbox" class="HideAutoProPAD" <?php echo $autopropad_checked;?> /> Hide AutoProPAD &nbsp; &nbsp;
        <br /><br />
         <div class="site-form">
          <div class="table-responsive chips_data vehiclesData" style="overflow:visible"> 
            <table class="table table-bordered table-data mar0 tab-con">
              <thead>
                <tr> 
                  <th rowspan="2">Action</th>
                  <th class="Types <?php echo $hideTypes_hide;?>" rowspan="2">Type</th>
                  <th class="HImage <?php echo $hideimage_hide;?>" rowspan="2">Image
                  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="Vehicle_Image" data_id="DESC"></a>
                  </th>	 
                  <th rowspan="2">Make <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Makes.Make_Name" data_id="DESC"></a></th> 
                  <th rowspan="2">Model <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Models.Model_Name" data_id="DESC"></a></th> 
                  <th rowspan="2">Year <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Years" data_id="DESC"></a></th>

                  <th rowspan="2">Gen Years <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Generation_YearRange" data_id="DESC"></a></th>
                  <th rowspan="2">Gen Name  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Generation_Name" data_id="DESC"></a></th>
                  
				   
                  <th rowspan="2">Mechanical Key <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="Mechanical_Key_UUID" data_id="DESC"></a></th>
                  <th rowspan="2">Transponder Key <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="Chip_Key_UUID" data_id="DESC"></a></th>

                  <th rowspan="2">Keyed Ign  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Keyed_Ignition" data_id="DESC"></a></th>
                  <th rowspan="2">Keyed Ign Years  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Keyed_IgnitionYear" data_id="DESC"></a></th>
                  <th rowspan="2">Push to Start  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Push_Start" data_id="DESC"></a></th>
                  <th rowspan="2">PTS Years  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Push_StartYear" data_id="DESC"></a></th>
                  <th rowspan="2">Immo System Name <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="t_Vehicles.Vehicle_System" data_id="DESC"></a></th>
                  
				          <th rowspan="2">Youtube Title / URL</th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>" colspan="9">AutoProPAD </th>
                </tr>
                <tr>               
                  
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">System
                  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="APP_System" data_id="DESC"></a>
                  </th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Add-A-Key
                   <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="APP_Add_Keys" data_id="DESC"></a>
                  </th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">All-Keys-Lost
                  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="APP_All_Keys_Lost" data_id="DESC"></a>
                  </th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">PIN Read 
                  <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="PIN_Read" data_id="DESC"></a>
                  </th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Programs Remotes</th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Resync Available</th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Key Blade</th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Transponder Chip</th>
                  <th class="AutoProPAD <?php echo $autopropad_hide;?>">Notes
                   <a href="javascript:void(0)" type="button" class="glyphicon glyphicon-triangle-bottom vehicle_sort_retainer" data-by="APP_Notes" data_id="DESC"></a>
                  </th>                  
                                     
                </tr>
              </thead>
              <tbody>			  
                <?php 	
                  $_SESSION['pageNumber'] = $page;
                  if(isset($_SESSION['LastUpdatedDatavehicle'])){
                    $lastupdate_val = $_SESSION['LastUpdatedDatavehicle'];
                  }else{
                    $lastupdate_val = "";
                  }
                  //print_r($_SESSION['search_key']);
                  if($results){
                  foreach($results as $value){      					
                    if( $value['Image_UUID'] == ""){
                        $img_uuid = gen_uuid();
                    }else{ 
                      $img_uuid = $value['Image_UUID']; 
                    } 
                    
                    if($value['id'] == $lastupdate_val){
                      $bgcolor = "style='background: #badffd;'";
                    }else{
                      $bgcolor ="";
                    }
                    
                  ?>
                	<tr <?php echo $bgcolor;?>>
                    	<td>
                        <a  href="<?php echo adm_base_url();?>/vehicles/edit_vehicles/<?php echo $value['id'];?>" type="button" class="btn btn-success">Edit</a>
                        <a  href="<?php echo adm_base_url();?>/vehicles/copy_vehicle/<?php echo $value['id'];?>" type="button" class="btn btn-info">Copy</a>                            
                        <a  href="javascript:void(0)" onclick="DeleteCodeFunction(<?php echo $value['id'];?>, '<?php echo adm_base_url();?>/vehicles/delete_vehicles/')" type="button"class="btn btn-danger" >Delete</a>
                       </td>
                        <td class="Types <?php echo $hideTypes_hide;?>">
          							<?php
          							$vehicle_Type_UUID_info = vehicle_Type_UUID_info($value['Vehicle_Type_UUID']);
          							echo $vehicle_Type_UUID_info[0]['type'];
          							?>							
                        </td> 
                    	<td class="HImage <?php echo $hideimage_hide;?>" style="padding:0">
                     <div class="vh_value_holder">
                        <?php if($value['image_url'] !=""){?>
                          <img src="<?php echo '/vh-admin/assets/vehicleImages/150/'.$value['image_url'];?>" width="150"  />
                        <?php }?>
                          </div>
                        </td>                   	
                        <td> <?php 	echo $value['Make_Name'];?></td>
                        <td>
                        	<div class="vh_value_holder"> 
                            <span class="td_data"><?php echo $value['Model_Name'];?></span>
                        	<span class="glyphicon glyphicon-pencil edit_vh_dropbox" aria-hidden="true" data-val="<?php echo $value['Model_UUID'];?>" data-id="<?php echo $value['id'];?>" data-col="Model_UUID" data-key="Model_UUID" data-type="Model_UUID"></span><div class="get_column_data"></div>     
                            </div>                     
                        </td>
                        <td> 
                        <div class="vh_value_holder">                                       
							         <?php
                            $years = explode(',',$value['Years']); 
                            if($years[0] == $years[count($years)-1]){?>
                                 <span class="td_data"><?php echo $years[0];?></span>
                            <?php }else{?>
                                 <span class="td_data"><?php echo $years[0];?>-<?php echo $years[count($years)-1];?></span>
                            <?php } ?>
                        <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Years'];?>" data-id="<?php echo $value['id'];?>" data-col="Years"></span><div class="get_column_data"></div>
                        </div>
                        </td> 
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Generation_YearRange'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Generation_YearRange'];?>" data-id="<?php echo $value['id'];?>" data-col="Generation_YearRange" data-key="Generation_YearRange" data-type="Generation_YearRange"></span><div class="get_column_data"></div>     
                                </div> 
                            </div>
                        </td>
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Generation_Name'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Generation_Name'];?>" data-id="<?php echo $value['id'];?>" data-col="Generation_Name" data-key="Generation_Name" data-type="Generation_Name"></span><div class="get_column_data"></div>     
                                </div> 
                            </div>
                        </td>
						          <td> 
                        <div class="vh_value_holder">                                       
							        <?php
            								$mach_keys_uuids = "";								
            								$mach_keys_array = explode(',',$value['Mechanical_Key_UUID']);
            								for($i = 0; $i < count($mach_keys_array); $i++ ){
            									$get_key_name = get_key_name($mach_keys_array[$i]);
            									$mach_keys_uuids .=  $get_key_name[0]['Key_Name'].'<br>';
            								}
            							?>
										<span class="td_data"><?php echo $mach_keys_uuids;?></span>      
                        <span class="glyphicon glyphicon-pencil edit_vh_programmers_box" aria-hidden="true" data-val="<?php echo $value['Mechanical_Key_UUID'];?>" data-id="<?php echo $value['id'];?>" data-col="Mechanical_Key_UUID" data-key="Mechanical Key" data-type="Keys"></span><div class="get_column_data"></div>
                        </div>
                        </td>
						<td class="code_keyInfo <?php echo $code_keyInfo_hide;?>">
                        <div class="vh_value_holder">
                       		 <?php
              								$chip_keys_uuids = "";								
              								$chip_keys_array = explode(',',$value['Chip_Key_UUID']);
              								for($i = 0; $i < count($chip_keys_array); $i++ ){
              									$get_key_name = get_key_name($chip_keys_array[$i]);
              									$chip_keys_uuids .=  $get_key_name[0]['Key_Name'].'<br>';
              								}
              							?>
                            <span class="td_data"><?php echo $chip_keys_uuids;?></span>                            
                        	<span class="glyphicon glyphicon-pencil edit_vh_multiple_box" aria-hidden="true" data-val="<?php echo $value['Chip_Key_UUID'];?>" data-id="<?php echo $value['id'];?>" data-col="Chip_Key_UUID" data-key="Transponder Key" data-type="Keys"></span><div class="get_column_data" ></div>
                           </div> 
                        </td>

                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Keyed_Ignition'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Keyed_Ignition'];?>" data-id="<?php echo $value['id'];?>" data-col="Keyed_Ignition" data-key="Keyed_Ignition" data-type="Keyed_Ignition"></span><div class="get_column_data"></div>     
                                </div> 
                            </div>
                        </td>
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Keyed_IgnitionYear'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Keyed_IgnitionYear'];?>" data-id="<?php echo $value['id'];?>" data-col="Keyed_IgnitionYear" data-key="Keyed_IgnitionYear" data-type="Keyed_IgnitionYear"></span><div class="get_column_data"></div>     
                                </div>
                            </div> 
                        </td>
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Push_Start'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Push_Start'];?>" data-id="<?php echo $value['id'];?>" data-col="Push_Start" data-key="Push_Start" data-type="Push_Start"></span><div class="get_column_data"></div>     
                                </div> 
                            </div>
                        </td>
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Push_StartYear'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Push_StartYear'];?>" data-id="<?php echo $value['id'];?>" data-col="Push_StartYear" data-key="Push_StartYear" data-type="Push_StartYear"></span><div class="get_column_data"></div>     
                                </div> 
                            </div>
                        </td>
                        <td>
                            <div class="vh_value_holder">
                              <span class="td_data"><?php echo $value['Vehicle_System'];?></span>
                              <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Vehicle_System'];?>" data-id="<?php echo $value['id'];?>" data-col="Vehicle_System" data-key="Vehicle_System" data-type="Vehicle_System"></span><div class="get_column_data"></div>     
                                </div>
                            </div> 
                        </td>

                        <td class="code_keyInfo <?php echo $code_keyInfo_hide;?>"> 
                        	<div class="vh_value_holder" >
                            <?php echo $value['APP_Youtube_Title'];?><br>
                        		<?php echo $value['APP_Youtube_URL'];?>
                            </div>
                        </td>
                        
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder notes-holder">
                          <span class="td_data"><?php echo $value['APP_System'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_System'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_System"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data"><?php echo $value['APP_Add_Keys'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_Add_Keys'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_Add_Keys"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                           <span class="td_data"><?php echo $value['APP_All_Keys_Lost'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_All_Keys_Lost'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_All_Keys_Lost"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                           <span class="td_data"><?php echo $value['PIN_Read'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['PIN_Read'];?>" data-id="<?php echo $value['id'];?>" data-col="PIN_Read"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data"><?php echo $value['APP_Programs_Remote'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_Programs_Remote'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_Programs_Remote"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data"><?php echo $value['APP_Resync_Available'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_Resync_Available'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_Resync_Available"></span><div class="get_column_data"></div>
                          </div>
                          </td>
						   <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data"><?php echo $value['Key_Blade'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Key_Blade'];?>" data-id="<?php echo $value['id'];?>" data-col="Key_Blade"></span><div class="get_column_data"></div>
                          </div>
                          </td>
						   <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data"><?php echo $value['Transponder_Chip'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['Transponder_Chip'];?>" data-id="<?php echo $value['id'];?>" data-col="Transponder_Chip"></span><div class="get_column_data"></div>
                          </div>
                          </td>
                          <td class="AutoProPAD <?php echo $autopropad_hide;?>">
                          <div class="vh_value_holder">
                          <span class="td_data notes-holder"><?php echo $value['APP_Notes'];?></span>
                          <span class="glyphicon glyphicon-pencil edit_vh_inputs" aria-hidden="true" data-val="<?php echo $value['APP_Notes'];?>" data-id="<?php echo $value['id'];?>" data-col="APP_Notes"></span><div class="get_column_data"></div>
                          </div>
                          </td>                          
                          
                    </tr>
				<?php } } else{
					echo "<div class='alert alert-danger'>Not Found</div>";
				} ?>
              </tbody>
            </table>
            <?php 		
            if($_SESSION['search_key'] !="" ){
              $sesshide = "hide";
            }elseif($make_id  == "All"){
              $sesshide = "";
            }elseif($vehicle_type =="All"){
              $sesshide = "";
            }else{
              $sesshide = "";
            }
            if($totalrows2 > 0){
              $count = $totalrows2;
            }else{
              $count = $totalrows;
            }
            if($count > 50){?>
                <nav class="site-pg <?php echo $sesshide;?>">
                      <ul class="pagination">               
                      <?php foreach ($links as $link) {
                          echo '<li>'. $link.'</li>';
                      } ?>	
                    </ul>
              </nav>
            <?php } ?>  
          </div>
        </div>          
      </section>
    </div>
  </div>
</div>
