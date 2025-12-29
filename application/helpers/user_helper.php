<?php
function admin_makeNameInfo($make_id){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Makes WHERE UUID = '$make_id' ");;       
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   return $result;
   }else{
	   return false;
   }
}

function asset_url(){
    return base_url().'assets/';
}
function adm_base_url(){
return base_url();
}
function aks_img_url(){
   return base_url().'upload/';
}
function  get_admin_deatils($email){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM admin WHERE email = '$email' ");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
function  all_admin_deatils(){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM admin ");
	if($query->num_rows() > 0){
	 	return $query->num_rows();
  	}else{
	   return false;
    }
}
function getmodel($makeId){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database   
   $query = $ci->db->query("SELECT * FROM t_Models WHERE Make_UUID = '$makeId' ORDER BY Model_Name");;       
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   return $result;
   }else{
	   return false;
   }
}
function vehicle_type_array(){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Vehicle_Types");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }	
}
function gen_uuid() {
    return md5(uniqid(mt_rand(), true));
}
function vehicle_Type_UUID_info($v_type_uuid){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Vehicle_Types WHERE UUID = '$v_type_uuid' ");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
function get_Code_Series_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Code_Series WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_make_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Models WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
		 $result =  $query->result_array();
		 $value_uuid2 =  $result[0]['Make_UUID'];
		 $query2 = $ci->db->query("SELECT * FROM t_Makes WHERE UUID = '$value_uuid2' ORDER BY Make_Name"); 
		 return $query2->result_array();	
  	}else{
	   return false;
    }
}
function get_models_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Models WHERE UUID = '$value_uuid' ORDER BY Model_Name");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_model_makes($makes_uuid){
	$ci =& get_instance();       
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Models WHERE Make_UUID = '$makes_uuid' ORDER BY Model_Name");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function admin_KeyNameInfo($key_id){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Key_Styles WHERE UUID = '$key_id' ");;       
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   return $result;
   }else{
	   return false;
   }
}
function get_t_machines_info2($value_uuid){
	$ci =& get_instance();       
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Machines_Info_Types WHERE Machines_Info_Type_Name = '$value_uuid'");
	if($query->num_rows() > 0){
		 return $query->result_array();	
  	}else{
	   return false;
    }
}
function get_machines_info($value_uuid){
	$ci =& get_instance();       
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Machines_Info WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_tools_determinater( $value) {	
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Manufacturers WHERE Manufacturer_Name = '$value' ORDER BY Manufacturer_Name");   
      
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   $manu_uuid =  $result[0]['UUID'];
	   $query2 = $ci->db->query("SELECT * FROM t_Tools WHERE Manufacturer_UUID = '$manu_uuid' ORDER BY Tool_Name"); 
	   return $query2->result_array();
   }else{
	   return false;
   }
}
function get_tools_type_tools( $value) {	
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Tool_Types WHERE Tool_Type_Name = '$value' ORDER BY Tool_Type_Name");   
      
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   $manu_uuid =  $result[0]['UUID'];
	   $query2 = $ci->db->query("SELECT * FROM t_Tools WHERE Tool_Type_UUID = '$manu_uuid' ORDER BY Tool_Name"); 
	   return $query2->result_array();
   }else{
	   return false;
   }
}


function get_tools_determinater2($manu_fact , $tool_type){
   $ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Manufacturers WHERE Manufacturer_Name = '$manu_fact' ORDER BY Manufacturer_Name"); 
   
   $query2 = $ci->db->query("SELECT * FROM t_Tool_Types WHERE Tool_Type_Name = '$tool_type' ORDER BY Tool_Type_Name");    
   if($query->num_rows() > 0){
	   $result = $query->result_array();	   
	   $manu_uuid =  $result[0]['UUID'];
	   
	   $result2 = $query2->result_array();
	   $tool_type_uuid =  $result2[0]['UUID'];
	   $query2 = $ci->db->query("SELECT * FROM t_Tools WHERE Manufacturer_UUID = '$manu_uuid' AND Tool_Type_UUID = '$tool_type_uuid' ORDER BY Tool_Name"); 
	   return $query2->result_array();
   }else{
	   return false;
   }
}


function get_manufactyrer_by_uuid( $value_uuid ){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	 $query = $ci->db->query("SELECT * FROM t_Tools WHERE UUID = '$value_uuid'");
   if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}

function get_toolType_by_uuid($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Tool_Types WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}


function get_toolName_by_uuid($value_uuid){
	$ci =& get_instance();       
   //load databse library
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Tools WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_t_machines_info($value_uuid){
	$ci =& get_instance();       
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Machines_Info_Types WHERE Machines_Info_Type_Name = '$value_uuid'");
	if($query->num_rows() > 0){
		 $result =  $query->result_array();
		 $value_uuid2 =  $result[0]['UUID'];
		 $query2 = $ci->db->query("SELECT * FROM t_Machines_Info WHERE Type = '$value_uuid2' ORDER BY Name "); 
		 return $query2->result_array();	
  	}else{
	   return false;
    }
}
/*function all_vehicles(){
	$ci =& get_instance();
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Vehicles");
	return $query->num_rows();
}*/

function all_vehicles(){
	$ci =& get_instance();
    $ci->load->database(); 
	$query = $ci->db->query("SELECT t_Vehicles.id FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID");
	return $query->num_rows();
}

function all_makes(){
	$ci =& get_instance();
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Makes");
	return $query->num_rows();
}
function all_model(){
    $ci =& get_instance();
    $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Models");
	return $query->num_rows();
}
function users_type(){
	return array('Administrator','American Key Supply','AutoProAPP Moderator','KeyLogic','Laser Key Products','LogiKey','WH Software','XTool');
	//return array('Admin','Mediator','Expert','Contributor','Newbie','Override Expert','Override Contributor');
}
function get_lock_types(){
	return array('Automotive/Motorcycle', 'Mailbox', 'Combination', 'Flat Steel', 'Locker', 'Office/Other' );
}
function get_key_type($uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Key_Types WHERE UUID = '$uuid' ");      
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   return $result;
   }else{
	   return false;
   }
}
function get_chips($uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database();       
   //get data from database
   $query = $ci->db->query("SELECT * FROM t_Chips WHERE UUID = '$uuid' ");      
   if($query->num_rows() > 0){
	   $result = $query->result_array();
	   return $result;
   }else{
	   return false;
   }
}
function get_key_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Keys WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_machanical_keys($value){
	$ci =& get_instance();       
  	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Key_Types WHERE Key_Type_Name = '$value'");
	
	if($query->num_rows() > 0){
	 $result =  $query->result_array();
	 $value_uuid =  $result[0]['UUID'];
	 $query2 = $ci->db->query("SELECT * FROM t_Keys WHERE Key_Type_UUID = '$value_uuid'  ORDER BY Key_Name"); 
	 return $query2->result_array();
  	}else{
	   return false;
    }
}
function get_machanical_test_keys($value1, $value2){
	$ci =& get_instance();       
  	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Key_Types WHERE Key_Type_Name = '$value1' OR Key_Type_Name = '$value2' ");	
	if($query->num_rows() > 0){
	 $result =  $query->result_array();
	 $value_uuid =  $result[0]['UUID'];
	 $query2 = $ci->db->query("SELECT * FROM t_Keys WHERE Key_Type_UUID = '$value_uuid'  ORDER BY Key_Name"); 
	 return $query2->result_array();
  	}else{
	   return false;
    }
}

function get_key_type_by_key($key_uuid){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Keys WHERE UUID = '$key_uuid'");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
function get_substitute_keys($Key_Type_UUID){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Keys WHERE Key_Type_UUID = '$Key_Type_UUID' ORDER BY Key_Name");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
//chip
function get_clonabnle_chips(){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Chips WHERE Clonable = '1' ORDER BY Chip_Name");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
function get_clonabnle_tools(){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_Tools WHERE Tool_Type_UUID = '628cfeab-a8a0-11e7-b079-525400df8778' ORDER BY Tool_Name");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}
function get_key_blade_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_key_blade WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function get_key_head_name($value_uuid){
	$ci =& get_instance();       
   //load databse library
   $ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM t_key_head WHERE UUID = '$value_uuid'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return false;
    }
}
function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}


function get_Firebase_vehicles_year_vehicleInfo1(){
	$ci =& get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("SELECT t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.Generation_Name,t_Vehicles.APP_Youtube_Title,t_Vehicles.Transponder_Chip,
	
	t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Keyed_Ignition,t_Vehicles.Push_Start ,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_StartYear,t_Vehicles.Push_Start,t_Vehicles.Key_ProgrammingReserved ,t_Vehicles.Push_StartYear,t_Vehicles.Vehicle_System ,t_Vehicles.Key_ProgrammingReserved FROM t_Makes JOIN  t_Models ON t_Makes.UUID = t_Models.Make_UUID JOIN t_Vehicles ON  t_Models.UUID = t_Vehicles.Model_UUID   ORDER BY t_Makes.Make_Name,t_Models.Model_Name LIMIT 5");
	if($query->num_rows() > 0){
	 	return $query->result_array();
  	}else{
	   return false;
    }
}

function get_machkey_info($name){
	$ci =& get_instance(); 
   	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM mechanical_key_information WHERE name = '$name'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return array();
    }
}

function get_transkey_info($name){
	$ci =& get_instance(); 
   	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM transponder_key_information WHERE name = '$name'");
	if($query->num_rows() > 0){
	 return $query->result_array();
  	}else{
	   return array();
    }
}

function programmer_information($make,$model,$year){
	$ci =& get_instance(); 
	$ci->load->database(); 
	$query = $ci->db->query("SELECT * FROM programmer_information WHERE make = '$make' AND model = '$model' AND year = '$year' ");
	if($query->num_rows() > 0){
	return $query->result_array();
	}else{
		return 0;
	}
}


function pages_access(){
	return array(
	'Vehicle' => array(
	 'vehicles/vehicle' =>  'Vehicles',
	 'vehicles/makes' =>  'Makes',
	 'vehicles/model' =>  'Model',
	 'vehicles/machanical_keys' =>  'Machanical Keys',
	 'vehicles/transponder_keys' =>  'Transponder Keys',
	 'vehicles/programmer_information' =>  'Programer Info',
	),	
	'Part' => array(
	 'home/keys' => 'Keys',
	 'home/Chips' => 'Chips',
	 'home/keyType' => 'Key Type',
	 'home/key_blade' => 'Key Blade',
	 'home/key_head' => 'Key Head',
   ),
	'home/bulletin_board' => 'Bulletin Board',
	'home/export_product_info' => 'Export CSV',
	'home/firebase_api' => 'Firebase API',
	'home/admins' => 'Admins',
   );
 }

 function add_activity_log($changed_data_id,$old_values,$new_values,$module,$log_table){
	$ci =& get_instance(); 
	$ci->load->database();
	$user_data = $ci->session->userdata('login_user');
	$email = $user_data['email'];
	$get_admin_deatils = get_admin_deatils($email);
	$userId = $get_admin_deatils[0]['UserID'];

	$changes_detected = false;
    foreach ($old_values as $column => $old_value) {
        if ($old_value !== $new_values[$column]) {
            $changes_detected = true;
            break;
        }
    }
	if ($changes_detected) {
        $activity = "User updated ".$module." ID: <b>".$changed_data_id."</b>";
		$data = array(
			'user_id' => $userId,
			'changed_data_id'	 => $changed_data_id,
			'old_value'	 => json_encode($old_values),
			'new_value'	 => json_encode($new_values),
			'activity'	 => $activity,
		);
        $ci->db->insert($log_table, $data);	
    }
 }

 function compareArrays($oldValues, $newValues)
{
    $changes = [];

    foreach ($oldValues as $key => $oldValue) {
        $newValue = $newValues[$key];

        if ($oldValue !== $newValue) {
			// if($newValue !="")
			if($key == 'Make_UUID'){
				$getmodel_old = admin_makeNameInfo($oldValue);
				$oldValue = $getmodel_old[0]['Make_Name'];
				$getmodel_new = admin_makeNameInfo($oldValue);
				$newValue = $getmodel_new[0]['Make_Name'];
			}
			if($key == 'Model_UUID'){
				$getmodel_old = get_models_name($oldValue);
				$oldValue = $getmodel_old[0]['Model_Name'];
				$getmodel_new = get_models_name($newValue);
				$newValue = $getmodel_new[0]['Model_Name'];
			}
			if($key == 'Vehicle_Type_UUID'){
				$getmodel_old = vehicle_Type_UUID_info($oldValue);
				$oldValue = $getmodel_old[0]['type'];
				$getmodel_new = vehicle_Type_UUID_info($newValue);
				$newValue = $getmodel_new[0]['type'];
			}
			if($key == 'Key_Type_UUID'){
				$getmodel_old = get_key_type($oldValue);
				$oldValue = $getmodel_old[0]['Key_Type_Name'];
				$getmodel_new = get_key_type($newValue);
				$newValue = $getmodel_new[0]['Key_Type_Name'];
			}
			if($key == 'Chip_UUID'){
				$getmodel_old = get_chips($oldValue);
				$oldValue = $getmodel_old[0]['Chip_Name'];
				$getmodel_new = get_chips($newValue);
				$newValue = $getmodel_new[0]['Chip_Name'];
			}
			if($key == 'TestKey_UUID'){
				$getmodel_old = get_key_name($oldValue);
				$oldValue = $getmodel_old[0]['Key_Name'];
				$getmodel_new = get_key_name($newValue);
				$newValue = $getmodel_new[0]['Key_Name'];
			}
			
			
			if($key == 'Mechanical_Key_UUID' || $key == 'Chip_Key_UUID'){
				$mach_keys_array_old = explode(',',$oldValue);
				for($i = 0; $i < count($mach_keys_array_old); $i++ ){
					$value_uuid = $mach_keys_array_old[$i];
					$get_result = $ci->db->query("SELECT Key_Name FROM t_Keys WHERE UUID ='".$value_uuid."' "); 
					$get_rows = $get_result->result_array();
					if(count($get_rows) > 0){
						$Key_Name_old .= rtrim($get_rows[0]['Key_Name'],',').',';                     
					}
				}
				$Key_Name_old = rtrim($Key_Name_old, ",");
				$oldValue = $Key_Name_old;

				$mach_keys_array_new = explode(',',$newValue);
				for($i = 0; $i < count($mach_keys_array_new); $i++ ){
					$value_uuid = $mach_keys_array_new[$i];
					$get_result = $ci->db->query("SELECT Key_Name FROM t_Keys WHERE UUID ='".$value_uuid."' "); 
					$get_rows = $get_result->result_array();
					if(count($get_rows) > 0){
						$Key_Name_new .= rtrim($get_rows[0]['Key_Name'],',').',';                     
					}
				}
				$Key_Name_old = rtrim($Key_Name_new, ",");
				$newValue = $Key_Name_old;
			}
			if($key == 'Chip_Key_UUID'){
				$mach_keys_array_old = explode(',',$oldValue);
				for($i = 0; $i < count($mach_keys_array_old); $i++ ){
					$value_uuid = $mach_keys_array_old[$i];
					$get_result = $ci->db->query("SELECT Key_Name FROM t_Keys WHERE UUID ='".$value_uuid."' "); 
					$get_rows = $get_result->result_array();
					if(count($get_rows) > 0){
						$Key_Name_old .= rtrim($get_rows[0]['Key_Name'],',').',';                     
					}
				}
				$Key_Name_old = rtrim($Key_Name_old, ",");
				$oldValue = $Key_Name_old;
				$mach_keys_array_new = explode(',',$newValue);
				for($i = 0; $i < count($mach_keys_array_new); $i++ ){
					$value_uuid = $mach_keys_array_new[$i];
					$get_result = $ci->db->query("SELECT Key_Name FROM t_Keys WHERE UUID ='".$value_uuid."' "); 
					$get_rows = $get_result->result_array();
					if(count($get_rows) > 0){
						$Key_Name_new .= rtrim($get_rows[0]['Key_Name'],',').',';                     
					}
				}
				$Key_Name_old = rtrim($Key_Name_new, ",");
				$newValue = $Key_Name_old;
			}
			$changes[$key] = [
				'old' => $oldValue,
				'new' => $newValue,
			];
        }
    }

    return $changes;
}
?>
