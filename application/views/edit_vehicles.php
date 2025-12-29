<?php 
error_reporting(0);
if(isset($_SESSION['pageNumber'])){
	$page_id =  $_SESSION['pageNumber'];
}else{
	$page_id = "";
}
$_SESSION['LastUpdatedDatavehicle'] = $vehicleId;
$user_data = $this->session->userdata('login_user');
$user_username = $user_data['username'];
$outputs1 = $this->session->userdata('login_firebase_user');
$user_type = $getUsersInfo[0]['type'];
  if( ($user_type == 0) || ($user_type == 1) || ($user_type == 2) ){
	  $status = 'approved';
  }else{
	  $status = 'pending';
  }
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-24 col-md-24">
	
      <section class="innerUserlogin white-box">
	   <a  href="<?php echo adm_base_url();?>/vehicles/vehicle/<?php echo $page_id ;?>" class="btn btn-primary" style="float:right;">BACK</a>
      <?php if($this->session->flashdata('message_display')){?>
      <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>
       <?php } echo $_SESSION['search_key'];?>
       <?php if($this->session->flashdata('errors')){?>
      <div class="alert alert-danger"><?php echo $this->session->flashdata('errors');?></div>
      <?php }   ?>

      <form class="site-form " method ="post" id="AddVehicleForm" action="<?php echo adm_base_url();?>/vehicles/update_vehicle" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <!--<h2 class="titleheadng">Add Model</h2>-->
        <input type="hidden" name="vehicleId" id="vehicle_id" value="<?php echo $vehicleId;?>" />
        <input type="hidden" value="<?php echo $getUsersInfo[0]['User_uid'];?>" id="user_uuid" />
        <input type="hidden" id="i_email" value="<?php echo $getUsersInfo[0]['email'];?>" />
        <input type="hidden" id="i_password" value="<?php echo $outputs1['password'];?>" />
        <input type="hidden" id="status" value="<?php echo $status;?>" />
        <?php if( $getVehiclesInfo[0]['Image_UUID'] == ""){?> 
        	<input type="hidden" id="UUID" value="<?php echo gen_uuid();?>" />
        <?php }else{ ?>
        	<input type="hidden" id="UUID" value="<?php echo $getVehiclesInfo[0]['Image_UUID'];?>" />
        <?php } ?>
        <?php $vtype_array = vehicle_type_array();?>
        <!--<div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Vehicle Type</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <select class="form-control" name="Vehicle_Type">
              	<option value="">Select type</option>
                <?php foreach($vtype_array as $types){
					if($types['type'] == $getVehiclesInfo[0]['Vehicle_Type']){
						$selected = 'selected';
					}else{
						$selected = '';
					}?>
                	<option <?php echo $selected;?>><?php echo $types['type'];?></option>
                <?php  } ?>
              </select>
            </div>
          </div>
        </div>-->
        <?php $get_make_name = get_make_name($getVehiclesInfo[0]['Model_UUID']);
		  $get_make_name[0]['UUID'];?>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Make</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <select class="form-control selectModels" name="Make_UUID">
              	<option value="">Select make</option>
                <?php foreach($getAllMakeNames as $makes){
					if($get_make_name[0]['UUID'] == $makes['UUID']){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					?>
                	<option value="<?php echo $makes['UUID'];?>" <?php echo $selected;?>><?php echo $makes['Make_Name'];?></option>
                <?php  } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Model</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol getModels">
              <select class="form-control" name="Model_UUID">
              	<option value="">Select model</option>
                <?php $get_model_makes =  get_model_makes($get_make_name[0]['UUID']);
				foreach($get_model_makes as $models){
					if($getVehiclesInfo[0]['Model_UUID'] == $models['UUID']){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					?>
					<option value="<?php echo $models['UUID'];?>" <?php echo $selected;?>> <?php echo $models['Model_Name'];?></option>	
				<?php }	?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Years</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <?php 
			  if(strrchr($getVehiclesInfo[0]['Years'], '-')){
				 $yaers_data = str_replace('-', ',', $getVehiclesInfo[0]['Years']);
			  }else{
				$yaers_data = $getVehiclesInfo[0]['Years'];	 
			  }			  
			  $years = explode(',',$yaers_data);?>
              <input type="number" class="custom-input" placeholder="From" name="fromYear" value="<?php echo $years[0];?>">
              <input type="number" class="custom-input" placeholder="To" name="toYear" value="<?php if(isset($years[count($years)-1])){echo $years[count($years)-1];}?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Vehicle Image ( Dim: 500x500)</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="inputcol vehicle_image">
		    	 <input type="file" name="Vehicle_Image" id="imagename" class="form-control">
             <div id="imageProgress"> <div id="imageBar" class="progress-bar-striped"></div> </div>         
            </div>
          </div>
       <!--   <div class="col-sm-2"><button type="button" id="btn" class="btn btn-info vehicle_images">Upload</button></div>-->
          <div class="col-sm-2"> <img  src="<?php echo $getVehiclesInfo[0]['Vehicle_Image'];?>" id="image_vale" style="width: 80px;height: 46px;" /> </div>  
         <div class="col-sm-2"> <img src="/vh-admin/assets/vehicleImages/150/<?php echo $getVehiclesInfo[0]['Vehicle_Image'];?>" style="width: 80px;height: 46px;"/></div>           
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Youtube Title</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <input type="text" class="form-control" name="APP_Youtube_Title" value="<?php echo $getVehiclesInfo[0]['APP_Youtube_Title'];?>"  />
            </div>
          </div>
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Youtube URL</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <input type="text" class="form-control" name="APP_Youtube_URL" value="<?php echo $getVehiclesInfo[0]['APP_Youtube_URL'];?>"  />
            </div>
          </div>
        </div>
		 <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Mechanical Key</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <select class="form-control" name="Mechanical_Key_UUID[]" multiple="multiple" style="height:200px">
              	<option value="">Select Mechanical Key</option>
                <?php 
                  $programm_array = explode(',',$getVehiclesInfo[0]['Mechanical_Key_UUID']);
                  $get_machanical_keys = get_machanical_keys('Mechanical Key');
                  foreach($get_machanical_keys as $keys){
                    if( in_array($keys['UUID'], $programm_array) ){
                        $selected = 'selected';
                      }else{
                        $selected = '';
                      }
                    ?>
                	<option value="<?php echo $keys['UUID'];?>" <?php echo $selected;?>><?php echo $keys['Key_Name'];?></option>
                <?php  } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label">Transponder Key</label>
            </div>
          </div>
          <div class="col-sm-10">
            <div class="inputcol">
              <select class="form-control" name="Chip_Key_UUID[]" multiple="multiple" style="height:200px;">
              	<option value="">Select Transponder Key</option>
                <?php
				$programm_array = explode(',',$getVehiclesInfo[0]['Chip_Key_UUID']);
				$get_machanical_keys = get_machanical_keys('Transponder Key'); 
				foreach($get_machanical_keys as $keys){
					if( in_array($keys['UUID'], $programm_array) ){
						  $selected = 'selected';
					  }else{
						  $selected = '';
					  }
					?>
                	<option value="<?php echo $keys['UUID'];?>" <?php echo $selected;?>><?php echo $keys['Key_Name'];?></option>
                <?php  } ?>
                <?php
				$programm_array = explode(',',$getVehiclesInfo[0]['Chip_Key_UUID']); 
				$get_machanical_keys2 = get_machanical_keys('VATS Key');
				foreach($get_machanical_keys2 as $keys){
					if( in_array($keys['UUID'], $programm_array) ){
						  $selected = 'selected';
					  }else{
						  $selected = '';
					  }
					?>
                	<option value="<?php echo $keys['UUID'];?>" <?php echo $selected;?>><?php echo $keys['Key_Name'];?></option>
                <?php  } ?>
              </select>
            </div>
          </div>
        </div> 
        <fieldset>
          <legend>AutoProPAD</legend>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">System</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_System" value="<?php echo $getVehiclesInfo[0]['APP_System'];?>"  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Add Keys</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_Add_Keys" value="<?php echo $getVehiclesInfo[0]['APP_Add_Keys'];?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">All Keys Lost</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_All_Keys_Lost" value="<?php echo $getVehiclesInfo[0]['APP_All_Keys_Lost'];?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">PIN Read</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="PIN_Read" value="<?php echo $getVehiclesInfo[0]['PIN_Read'];?>" />
                </div>
              </div>
            </div>
			      <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Programs Remote</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_Programs_Remote"  value="<?php echo $getVehiclesInfo[0]['APP_Programs_Remote'];?>"/>
                </div>
              </div>
            </div>
			      <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Resync Available</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_Resync_Available"  value="<?php echo $getVehiclesInfo[0]['APP_Resync_Available'];?>"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">10-Min Bypass</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_10-Minute_Bypass" value="<?php echo $getVehiclesInfo[0]['APP_10-Minute_Bypass'];?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Confirmed</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_Confirmed_Working" value="<?php echo $getVehiclesInfo[0]['APP_Confirmed_Working'];?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Notes</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="APP_Notes" value="<?php echo $getVehiclesInfo[0]['APP_Notes'];?>" />
                </div>
              </div>
            </div>
			      <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Key Blade </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Key_Blade"  value="<?php echo $getVehiclesInfo[0]['Key_Blade'];?>" readonly="readonly"/>
                </div>
              </div>
            </div>
			  	  <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Transponder Chip </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Transponder_Chip"  value="<?php echo $getVehiclesInfo[0]['Transponder_Chip'];?>" readonly="readonly"/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Generation Name </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Generation_Name"  value="<?php echo $getVehiclesInfo[0]['Generation_Name'];?>"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Generation Year Range </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Generation_YearRange"  value="<?php echo $getVehiclesInfo[0]['Generation_YearRange'];?>"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Keyed Ignition</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Keyed_Ignition"  value="<?php echo $getVehiclesInfo[0]['Keyed_Ignition'];?>"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Keyed Ignition Year</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Keyed_IgnitionYear"  value="<?php echo $getVehiclesInfo[0]['Keyed_IgnitionYear'];?>"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Push Start</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Push_Start"  value="<?php echo $getVehiclesInfo[0]['Push_Start'];?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Push Start Year</label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Push_StartYear"  value="<?php echo $getVehiclesInfo[0]['Push_StartYear'];?>"/>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Key Programming Reserved </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Key_ProgrammingReserved"  value="<?php echo $getVehiclesInfo[0]['Key_ProgrammingReserved'];?>" />
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class=" col-sm-4 ">
                <div class="labelcol">
                  <label class="control-label">Immo System Name </label>
                </div>
              </div>
              <div class="col-sm-10">
                <div class="inputcol">
                  <input type="text" class="form-control" name="Vehicle_System"  value="<?php echo $getVehiclesInfo[0]['Vehicle_System'];?>" />
                </div>
              </div>
            </div>
        </fieldset>
        
        <hr>
        <div class="row">
          <div class=" col-sm-4 ">
            <div class="labelcol">
              <label class="control-label"></label>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary" name="post">Submit</button>
            <a href="<?php echo adm_base_url();?>/vehicles/vehicle/<?php echo $page_id ;?>" class="btn btn-danger">Cancel</a> </div>
        </div>
          <input type="hidden" id="getError" />
          <input type="hidden" name="pageId" value="<?php echo $getVehiclesInfo[0]['id']?>" />
      </form>
    </div>
  </div>
</div>
 <canvas id="mcanvas" height="500" width="500" style="display:none"></canvas>
<script src="https://www.gstatic.com/firebasejs/3.6.3/firebase.js"></script>
<script src="<?php echo asset_url(); ?>admin/js/md5.js"></script>
<script >
/*------------------------- Firebase Function JS -------------------------------------*/
load();
var gCanvas;
var gCtx;
function load(){
  console.log("loaded");
  gCanvas = document.getElementById("mcanvas");
 
  if (gCanvas.getContext){
	gCtx = gCanvas.getContext("2d");
  } else console.log("no Canvas?");
}
var uuid = document.getElementById('UUID').value; 

var bse_url = "/";
 var config = {
    apiKey: "AIzaSyDBwhVzLZRZVf4tFRqRQa6dD0KgUl1IBj4",
    authDomain: "autopro-75ac3.firebaseapp.com",
    databaseURL: "https://autopro-75ac3.firebaseio.com",
    storageBucket: "autopro-75ac3.appspot.com",
    messagingSenderId: "905741934132"
  };

/*var config = {
    apiKey: "AIzaSyAOGEGaxRqauTKn14rrg7NsfSpgAgqmWQ4",
    authDomain: "american-key.firebaseapp.com",
    databaseURL: "https://american-key.firebaseio.com",
    storageBucket: "american-key.appspot.com",
    messagingSenderId: "699615089846"
  };*/
/*firebase.initializeApp(config);
const auth = firebase.auth();
const ref2 = firebase.storage().ref('/vehicle-images/'+uuid+'');
var imageAddButton = document.getElementById('imagename');
imageAddButton.addEventListener('change' , e => {
	var file_path = e.target.value;
	var storageRef = firebase.storage().ref();
	document.getElementById('image_vale').src = file_path;
	
})*/
firebase.initializeApp(config);
var imageAddButton = document.getElementById('imagename');
imageAddButton.addEventListener('change' , e => {
  var file_path = e.target.value.replace(/^.*\\/, "/vh-admin/assets/vehicleImages/150/");
	document.getElementById('image_vale').src = file_path;
	
})

const loginEmail = document.getElementById('i_email');
const loginPassword = document.getElementById('i_password');

var vehicleImageButton = document.getElementById('btn');
vehicleImageButton.addEventListener('click' , e => {
		document.getElementById("loader").className = ""; 
		var file_path = e.target.value;
		var storageRef = firebase.storage().ref();
		var sampleImage = document.getElementById('image_vale'),
		img_canvas_path1 = doProcess(sampleImage);
		console.log(img_canvas_path1);
		var img_canvas_path = img_canvas_path1.replace("data:image/png;base64,", "");
		 //var uInt8Array = new Uint8Array(img_canvas_path);
		console.log(img_canvas_path1);	
	    const i_email = loginEmail.value;
		const i_password = loginPassword.value;
		const auth = firebase.auth();
		const encrypt_passw = calcMD5(i_password);		
		const encrypt_64 = Base64.encode(encrypt_passw);
		// Sign In
		const returnPromise = auth.signInWithEmailAndPassword(i_email, encrypt_64);
		returnPromise.catch( e =>  document.getElementById('getError').value = e.message);		
		setTimeout(function(){ 
			var error = document.getElementById('getError').value;
			if(error === ""){
					var d = new Date();
   var modifieddate = d.getFullYear()+'/'+d.getMonth()+'/'+d.getDate()+' '+d.getHours()+'-'+d.getMinutes()+'-'+d.getSeconds()+':'+d.toString().match(/([A-Z]+[\+-][0-9]+)/)[1];
				    var updates = {}; 
					var uploader = document.getElementById('uploader');
					var folderName = document.getElementById('vehicle_id').value;
					var userID = document.getElementById('user_uuid').value;
					var correctionId = '';
					var file_name = '';
					var title = '';
					var status = document.getElementById('status').value;
					//alert(folderName)
					var storageRef =  firebase.storage().ref('/vehicle-info/'+folderName+'/'+folderName+'_image.png');
					//var storageRef =  firebase.storage().ref('images/'+folderName+'/'+file.name); 
					var task = storageRef.putString(img_canvas_path,'base64');
					var fireBaseRef = firebase.database().ref("/vehicle-info/"+folderName+'/images/'+uuid);
					
					var data = {correctionID: correctionId, imagePath: 'images/'+folderName+'/'+folderName+'_image.png', status:status,userID: userID,title: title}
					updates["/vehicle-info/"+folderName+'/images/'+uuid] = data;
					// var fireBaseRef = firebase.database().ref("/users/"+folderName+'/images/');
				    const returnPromise = firebase.database().ref().update(updates);
					var fireBaseRef4 = firebase.database().ref("/vehicle-info/"+folderName+'/images/'+uuid+'/management');
					fireBaseRef4.update( {userID:userID, date: modifieddate}, function(error) {
					})
					document.getElementById("loader").className = "hide"; 
			}else{
				alert('You are not allowed to add Image');
				document.getElementById("loader").className = "hide"; 
			}
			
		}, 2000);	
})

function doProcess(f){	
	var o=[];
	var reader = new FileReader();
	reader.onload = (function(theFile) {
		var img = new Image();
		img.src = theFile;
		img.onload = function(){
		  gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);
		  gCtx.drawImage(img,0,0);
		}
		return;
	})(f);
	//console.log(reader);
    return convertCanvasToImage(gCanvas);
	//console.log(img_canvas_path1)
}
function convertCanvasToImage(gCanvas) {
	//console.log(gCanvas)
	var image = new Image();
	image.src = gCanvas.toDataURL("image/png");
	//return image;
	return gCanvas.toDataURL("image/png");
}

function imageUpload(){
    var error = document.getElementById('getError').value;
    if(error === ""){
          document.getElementById("loader").className = "";
          const i_email = loginEmail.value;
          const i_password = loginPassword.value;
          const auth = firebase.auth();
          const encrypt_passw = calcMD5(i_password);    
          const encrypt_64 = Base64.encode(encrypt_passw);
          // Sign In
          const returnPromise = auth.signInWithEmailAndPassword(i_email, encrypt_64);
          returnPromise.catch( e =>  document.getElementById('getError').value = e.message);  
          const file = document.querySelector('#photo').files[0]
          const name = (+new Date()) + '-' + file.name;
          const metadata = {
            contentType: file.type
          };
          const task = ref2.child(name).put(file, metadata);
          task.then((snapshot) => {
            const url = snapshot.downloadURL;
            //console.log(url);
            document.querySelector('#someImageTagID').value = url;
            document.getElementById("loader").className = "hide";
          }).catch((error) => {
            console.error(error);
          });
    }else{
        alert('User does not have permission to access the object');
        document.getElementById("loader").className = "hide"; 
      }
  }
</script>