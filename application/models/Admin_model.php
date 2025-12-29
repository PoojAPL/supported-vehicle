<?php
error_reporting(1);
class Admin_model extends CI_Model {
	public function __construct(){
			$this->load->database();
	}
	public function checkuser($username,$password ){			 
			$query = $this->db->select("*")->where('email', $username)->where('password', md5($password))->where('APP_switcher', 1)->get('admin');
			if($query->num_rows() > 0){
			return $query->result_array();
			}else{
			$password = hash("sha256", $password); 
			$query = $this->db->select("*")->where('email', $username)->where('password', $password)->where('APP_switcher', 1)->get('admin');
			return $query->result_array();
			} 			 
	}	
	public function usersInInfo($user_email){
		$query = $this->db->select("UserID,user_name,type,email,password,Company,User_uid,APP_switcher")->where('email',$user_email)->get('admin');
		return $query->result_array();
	}	
	/*public function getAllVehiclesRows(){
		return $this->db->count_all("t_Vehicles");
	}*/
	
	public function getAllVehiclesRows(){
		$query = $this->db->query("SELECT t_Vehicles.id FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
		LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID ");	
		return $query->num_rows();
	}
	
	public function getAllVehiclesData($limit,$limt_start){
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID 	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID   ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ");
		return $query->result_array();
	}
	public function getAllMakeNames(){
		$query = $this->db->select("id,Make_Name,UUID")->order_by('Make_Name','asc')->get('t_Makes');
		return $query->result_array();
	}
	public function get_AllMakes(){
		$query = $this->db->query("SELECT * FROM t_Makes ORDER BY Make_Name ");	
		return $query->result_array();
	}
	public function get_models(){
		$makeId = $this->input->post('makeId');
		if($makeId =='All'){return 0;}else{
		$query = $this->db->query("SELECT * FROM t_Models WHERE Make_UUID = ? ORDER BY Model_Name",array($makeId));
		return $query->result_array();
		}
	}
	public function getAllmakesRows($makeId){
		if($makeId =='All'){
			$where = "";
		}else{
			$where = "WHERE t_Makes.UUID='".$makeId."'";
		}		
		$query = $this->db->query("SELECT t_Vehicles.PIN_Read FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
		LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID ".$where."");
		return $query->num_rows();
	}
		
	public function getfiltermakes($makeId,$limit,$limt_start){
		if( isset($_SESSION['sort_column']) && $_SESSION['sort_column'] != ""){
			$sort_column = $_SESSION['sort_column'];
		}else{
			$sort_column ='t_Makes.Make_Name,t_Models.Model_Name';
		}
		
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL , t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Makes.UUID=?   ORDER BY ".$sort_column." LIMIT  ".(int)$limt_start.", ".(int)$limit." ",array($makeId));
		return $query->result_array();
	}
	public function vehicle_sort_by_make($limit,$limt_start){	
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}	
		$makeId = $this->input->post('makeId');			
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL, t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Makes.UUID = ?  ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ",array($makeId));
		return $query->result_array();
	}
	public function filter_vehicle_by_model(){
		$modelId = $this->input->post('modelId');
		if($modelId!=""){
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL, t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Models.UUID=? ORDER BY t_Makes.Make_Name LIMIT  0, 50 ",array($modelId));		
		return $query->result_array();
			return $query->result_array();
		}		
	}
	public function getmakemodelfilter($limit,$limt_start,$modelId, $makeId){
		$makes_id = "";	
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		if($makeId =='All'){
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
		LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID   ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ");
		}else{
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
		LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Vehicles.Model_UUID=? AND t_Models.Make_UUID=?   ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ", array($modelId, $makeId));
		}
		return $query->result_array();
	}
	public function show_vehicle_by_type_count($type){
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID FROM t_Makes JOIN  t_Models ON t_Makes.UUID = t_Models.Make_UUID JOIN t_Vehicles ON  t_Models.UUID = t_Vehicles.Model_UUID WHERE t_Models.Vehicle_Type_UUID = ? ORDER BY t_Makes.Make_Name,t_Models.Model_Name ",array($type));
		return $query->num_rows();
	}

	public function show_vehicle_by_type($limit,$limt_start){
		$type = $this->input->post('type');
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		if($type == 'All'){
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL ,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ");	
		}else{
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE  t_Models.Vehicle_Type_UUID = ? ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ",array($type));
		}		
		return $query->result_array();
	}

	public function show_missing_code_series_count(){
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE Code_Series_UUID IS NULL OR Code_Series_UUID=? OR Code_Series_UUID=? ",array('','|'));		
		return $query->num_rows();
	}

	public function show_missing_code_series($limit,$limt_start){
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL ,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE Code_Series_UUID IS NULL OR Code_Series_UUID=? OR Code_Series_UUID=? ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ",array('','|'));		
		return $query->result_array();
	}

	public function show_missing_images_count(){
		$query = $this->db->query("SELECT Vehicle_Image FROM t_Vehicles WHERE Vehicle_Image IS NULL OR Vehicle_Image=? OR Vehicle_Image=? ",array('','|'));		
		return $query->num_rows();
	}
	public function show_missing_images($limit,$limt_start){	
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE Vehicle_Image IS NULL OR Vehicle_Image=? OR Vehicle_Image=? ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ",array('','|'));		
		return $query->result_array();
	}
	public function search_vehicles(){
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$search_key = trim($this->input->post('search_key'));
		$mm_query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Makes.Make_Name LIKE '%$search_key%' OR t_Models.Model_Name LIKE '%$search_key%'  ORDER BY ".$global_sorting."");
		if($mm_query->num_rows() > 0){
			return $mm_query->result_array();
		}
	}
	public function getAllVehiclesRows2_Rows($vehicle_type){
		$query = $this->db->query("SELECT * FROM t_Vehicles JOIN  t_Models ON t_Models.UUID = t_Vehicles.Model_UUID JOIN t_Vehicle_Types ON  t_Vehicle_Types.UUID = t_Models.Vehicle_Type_UUID WHERE t_Vehicle_Types.UUID = ? ", array($vehicle_type));
		return $query->num_rows();
	}
	public function getAllVehiclesData2($limit,$limt_start,$vehicle_type){
		$query = $this->db->query("SELECT * ,t_Vehicles.id  AS id FROM t_Vehicles JOIN  t_Models ON t_Models.UUID = t_Vehicles.Model_UUID JOIN t_Vehicle_Types ON  t_Vehicle_Types.UUID = t_Models.Vehicle_Type_UUID WHERE t_Vehicle_Types.UUID = ? LIMIT  ".(int)$limt_start.", ".(int)$limit." ", array($vehicle_type));
		return $query->result_array();
	}
	public function getSearchItem($limit,$limt_start,$search_key){
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$makes_id = "";
		$modal_ids = "";
		
		$make_query = $this->db->query("SELECT * FROM t_Makes WHERE Make_Name LIKE '%$search_key%'");
		$make_query1 = $make_query->result_array();
		
		$model_query = $this->db->query("SELECT * FROM t_Models WHERE Model_Name LIKE '%$search_key%'");
		$model_query1 = $model_query->result_array();		
		
		$t_code_series_query = $this->db->query("SELECT * FROM t_Code_Series WHERE Code_Series_Name LIKE '%$search_key%'");
		$t_code_series_query1 = $t_code_series_query->result_array();
		
		if($make_query->num_rows() > 0){
			$makes_id2 = $make_query1[0]['UUID'];
			$model_query22 = $this->db->query("SELECT * FROM t_Models WHERE Make_UUID =? ",array($makes_id2));
			$model_query12 = $model_query22->result_array();
			foreach($model_query12 as $model_idss){
				//$modal_ids = $model_query12[0]['UUID'];
				$modal_ids .= "'". $model_idss['UUID']."',";
			}
			$modal_ids2 = rtrim($modal_ids,",");			
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID 	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Vehicles.Model_UUID IN($modal_ids2)   ORDER BY ".$global_sorting." ");
	

		}else if($model_query->num_rows() > 0){
			$modal_ids22 = "";
			foreach($model_query1 as $model_idss){				
				//$modal_ids = $model_query12[0]['UUID'];
				$modal_ids22 .= "'". $model_idss['UUID']."',";
			}
			$modal_ids2 = rtrim($modal_ids22,",");			
			//$query = $this->db->query("SELECT * FROM t_Vehicles WHERE Model_UUID IN($modal_ids2) ");
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID 	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE t_Vehicles.Model_UUID IN($modal_ids2)   ORDER BY ".$global_sorting." ");
		}else if($t_code_series_query->num_rows() > 0){
			$modal_ids22 = "";
			$where = "";
			foreach($t_code_series_query1 as $model_idss){				
				//$modal_ids = $model_query12[0]['UUID'];
				$code_uuid = rtrim($model_idss['UUID'],'|');
				$modal_ids22 .= "'". $code_uuid."',";
				$where .= "t_Vehicles.Code_Series_UUID LIKE '%$code_uuid%' OR ";
			}
			$where2 = substr($where,0,-3);
			$modal_ids2 = rtrim($modal_ids22,",");	
			//$query = $this->db->query("SELECT * FROM t_Vehicles WHERE ".$where2."");
			$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Makes JOIN  t_Models ON t_Makes.UUID = t_Models.Make_UUID JOIN t_Vehicles ON  t_Models.UUID = t_Vehicles.Model_UUID WHERE ".$where2." ORDER BY ".$global_sorting." ");
		}else{	
			$query =$this->db->query("SELECT * FROM t_Remotes WHERE Remote_Name LIKE '%$search_key%' OR Products LIKE '%$search_key%' OR FCCID LIKE '%$search_key%'  ");
		}
		return $query->result_array();
	}
	public function getAllVehiclesRows_Missing_Rows($vehicle_type){
		$query = $this->db->query("SELECT t_Vehicles.id FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID
		LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE ".$vehicle_type." IS NULL OR ".$vehicle_type."='' OR ".$vehicle_type."='|'");	
		return $query->num_rows();
	}
	public function getAllVehiclesRows_Missing($limit,$limt_start,$vehicle_type){
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}	
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID 	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE ".$vehicle_type." IS NULL OR ".$vehicle_type."='' OR ".$vehicle_type."='|'  ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit." ");	
		return $query->result_array();
	}
	public function get_all_vehicles2(){
		$query = $this->db->query("SELECT * FROM t_Vehicles ORDER BY id DESC");
		return $query->result_array();
	}
	public function get_t_code_series(){		
		$query = $this->db->query("SELECT * FROM t_Code_Series ORDER BY Code_Series_Name ");
		return $query->result_array();
	}
	public function get_vehicles(){		
		$modelId = $this->input->post('ModelId');
		$query = $this->db->query("SELECT * FROM t_Vehicles WHERE Model_UUID = ? ",  array($modelId));
		return $query->result_array();
	}
	public function getModelInfo2($model_uuid){
		$query = $this->db->query("SELECT * FROM t_Models WHERE UUID = ? ",array($model_uuid));
		return $query->result_array();
	}
	
	public function getMakeInfo2($make_uuid){
		$query = $this->db->query("SELECT * FROM t_Makes WHERE UUID = ? ",array($make_uuid));
		return $query->result_array();
	}
	public function save_vehicle($file_name){	
		$this->db->cache_delete('admpro', 'vehicles');
		$series_val = "";
		if($this->input->post('toYear') != ""){
			$year = $this->input->post('fromYear').','. $this->input->post('toYear');
		}else{
			$year = $this->input->post('fromYear');
		}	
		$machanical_keys_val = "";
		$machanical_keys_val1  = "";	
		if( isset($_POST['Mechanical_Key_UUID'])){
			foreach( $_POST['Mechanical_Key_UUID'] as $machanical_keys){
				$machanical_keys_val .= $machanical_keys.',';
			}
		}
		$machanical_keys_val1 = rtrim($machanical_keys_val,',');
		
		$Chip_Key_UUID_val  = "";	
		if( isset($_POST['Chip_Key_UUID'])){
			foreach( $_POST['Chip_Key_UUID'] as $Chip_Key_UUID){
				$Chip_Key_UUID_val .= $Chip_Key_UUID.',';
			}
		}
		$Chip_Key_UUID_val1 = rtrim($Chip_Key_UUID_val,',');
		if($file_name == ""){
		$data = array(
				'UUID' => md5(uniqid(mt_rand(), true)),				
				'Model_UUID' => $this->input->post('Model_UUID'),
				'Years' => $year,
				'Vehicle_Image' => $this->input->post('Vehicle_Image_copy'),
				'image_url' => $this->input->post('Vehicle_Image_copy'),
				'APP_System' => $this->input->post('APP_System'),
				'APP_Add_Keys' => $this->input->post('APP_Add_Keys'),
				'APP_All_Keys_Lost' => $this->input->post('APP_All_Keys_Lost'),
				'APP_10-Minute_Bypass' => $this->input->post('APP_10-Minute_Bypass'),
				'APP_Notes' => $this->input->post('APP_Notes'),
				'APP_Programs_Remote' => $this->input->post('APP_Programs_Remote'),
				'APP_Resync_Available' => $this->input->post('APP_Resync_Available'),
				'APP_Confirmed_Working' => $this->input->post('APP_Confirmed_Working'),
				'APP_Youtube_URL' => $this->input->post('APP_Youtube_URL'),
				'Key_Blade' => $this->input->post('Key_Blade'),
				'Transponder_Chip' => $this->input->post('Transponder_Chip'),
				'Mechanical_Key_UUID' => $machanical_keys_val1,
				'Chip_Key_UUID' => $Chip_Key_UUID_val1,
				'APP_Youtube_Title' => $this->input->post('APP_Youtube_Title'),
		);	
	}else{
		$data = array(
			'UUID' => md5(uniqid(mt_rand(), true)),				
			'Model_UUID' => $this->input->post('Model_UUID'),
			'Years' => $year,
			'Vehicle_Image' => $file_name,
			'image_url' => $file_name,
			'APP_System' => $this->input->post('APP_System'),
			'APP_Add_Keys' => $this->input->post('APP_Add_Keys'),
			'APP_All_Keys_Lost' => $this->input->post('APP_All_Keys_Lost'),
			'APP_10-Minute_Bypass' => $this->input->post('APP_10-Minute_Bypass'),
			'APP_Notes' => $this->input->post('APP_Notes'),
			'APP_Programs_Remote' => $this->input->post('APP_Programs_Remote'),
			'APP_Resync_Available' => $this->input->post('APP_Resync_Available'),
			'APP_Confirmed_Working' => $this->input->post('APP_Confirmed_Working'),
			'APP_Youtube_URL' => $this->input->post('APP_Youtube_URL'),
			'Key_Blade' => $this->input->post('Key_Blade'),
			'Transponder_Chip' => $this->input->post('Transponder_Chip'),
			'Mechanical_Key_UUID' => $machanical_keys_val1,
			'Chip_Key_UUID' => $Chip_Key_UUID_val1,
			'APP_Youtube_Title' => $this->input->post('APP_Youtube_Title'),
	);	
	}	
		$data = $this->security->xss_clean($data);
		$this->db->insert('t_Vehicles', $data);
		return true;
	}
	
	public function getVehiclesInfo($id){
		$query = $this->db->query("SELECT * FROM t_Vehicles WHERE id =? ", array($id));
		return $query->result_array();
	}
	
	public function update_vehicle($file_name){
		$this->db->cache_delete('admpro', 'vehicles');
		$programm_val = "";
		$vehicleId = $this->input->post('vehicleId');
		if($this->input->post('toYear') != ""){
			$year = $this->input->post('fromYear').','. $this->input->post('toYear');
		}else{
			$year = $this->input->post('fromYear');
		}
		$machanical_keys_val = "";
		$machanical_keys_val1  = "";	
		if( isset($_POST['Mechanical_Key_UUID'])){
			foreach( $_POST['Mechanical_Key_UUID'] as $machanical_keys){
				$machanical_keys_val .= $machanical_keys.',';
			}
		}
		$machanical_keys_val1 = rtrim($machanical_keys_val,',');
		
		$Chip_Key_UUID_val  = "";	
		if( isset($_POST['Chip_Key_UUID'])){
			foreach( $_POST['Chip_Key_UUID'] as $Chip_Key_UUID){
				$Chip_Key_UUID_val .= $Chip_Key_UUID.',';
			}
		}
		$Chip_Key_UUID_val1 = rtrim($Chip_Key_UUID_val,',');
		$extra_field = '';
		if($file_name != ""){		
		$data = array(						
				'Model_UUID' => $this->input->post('Model_UUID'),
				'Years' => $year,
				'Vehicle_Image' => $file_name,
				'image_url' => $file_name,
				'APP_System' => $this->input->post('APP_System'),
				'APP_Add_Keys' => $this->input->post('APP_Add_Keys'),
				'APP_All_Keys_Lost' => $this->input->post('APP_All_Keys_Lost'),
				'APP_10-Minute_Bypass' => $this->input->post('APP_10-Minute_Bypass'),
				'APP_Notes' => $this->input->post('APP_Notes'),
				'PIN_Read' => $this->input->post('PIN_Read'),
				'APP_Programs_Remote' => $this->input->post('APP_Programs_Remote'),
				'APP_Resync_Available' => $this->input->post('APP_Resync_Available'),
				'APP_Confirmed_Working' => $this->input->post('APP_Confirmed_Working'),
				'APP_Youtube_URL' => $this->input->post('APP_Youtube_URL'),
				'Key_Blade' => $this->input->post('Key_Blade'),
				'Transponder_Chip' => $this->input->post('Transponder_Chip'),
				'Mechanical_Key_UUID' => $machanical_keys_val1,
				'Chip_Key_UUID' => $Chip_Key_UUID_val1,
				'APP_Youtube_Title' => $this->input->post('APP_Youtube_Title'),
				'Generation_Name' => $this->input->post('Generation_Name'),
				'Generation_YearRange' => $this->input->post('Generation_YearRange'),
				'Keyed_Ignition' => $this->input->post('Keyed_Ignition'),
				'Keyed_IgnitionYear' => $this->input->post('Keyed_IgnitionYear'),
				'Push_Start' => $this->input->post('Push_Start'),
				'Push_StartYear' => $this->input->post('Push_StartYear'),
				'Vehicle_System' => $this->input->post('Vehicle_System'),
		);
		$extra_field = 'Vehicle_Image,image_url,';
		}else{
			$data = array(						
				'Model_UUID' => $this->input->post('Model_UUID'),
				'Years' => $year,
				'APP_System' => $this->input->post('APP_System'),
				'APP_Add_Keys' => $this->input->post('APP_Add_Keys'),
				'APP_All_Keys_Lost' => $this->input->post('APP_All_Keys_Lost'),
				'APP_10-Minute_Bypass' => $this->input->post('APP_10-Minute_Bypass'),
				'APP_Notes' => $this->input->post('APP_Notes'),
				'PIN_Read' => $this->input->post('PIN_Read'),
				'APP_Programs_Remote' => $this->input->post('APP_Programs_Remote'),
				'APP_Resync_Available' => $this->input->post('APP_Resync_Available'),
				'APP_Confirmed_Working' => $this->input->post('APP_Confirmed_Working'),
				'APP_Youtube_URL' => $this->input->post('APP_Youtube_URL'),
				'Key_Blade' => $this->input->post('Key_Blade'),
				'Transponder_Chip' => $this->input->post('Transponder_Chip'),
				'Mechanical_Key_UUID' => $machanical_keys_val1,
				'Chip_Key_UUID' => $Chip_Key_UUID_val1,
				'APP_Youtube_Title' => $this->input->post('APP_Youtube_Title'),
				'Generation_Name' => $this->input->post('Generation_Name'),
				'Generation_YearRange' => $this->input->post('Generation_YearRange'),
				'Keyed_Ignition' => $this->input->post('Keyed_Ignition'),
				'Keyed_IgnitionYear' => $this->input->post('Keyed_IgnitionYear'),
				'Push_Start' => $this->input->post('Push_Start'),
				'Push_StartYear' => $this->input->post('Push_StartYear'),
				'Vehicle_System' => $this->input->post('Vehicle_System'),
		);
		}
		//echo $vehicleId;
		
		$query = $this->db->query("SELECT Model_UUID,Years,".$extra_field." APP_System,APP_Add_Keys,APP_All_Keys_Lost,`APP_10-Minute_Bypass`,APP_Notes,PIN_Read,APP_Programs_Remote,APP_Resync_Available,APP_Confirmed_Working,APP_Youtube_URL,Key_Blade,Transponder_Chip,Mechanical_Key_UUID,Chip_Key_UUID,APP_Youtube_Title,Generation_Name,Generation_YearRange,Keyed_Ignition,Keyed_IgnitionYear,Push_Start,Push_StartYear,Vehicle_System FROM t_Vehicles WHERE id =".$vehicleId."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($vehicleId,$old_values,$new_values,'Vehicle','t_vehicles_logs');		
		$this->db->where('id', $vehicleId);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Vehicles', $data);	
	}
	
	public function delete_vehicles($id){
		$this->db->cache_delete('admpro', 'vehicles');
		$this->db->where('id', $id);
		$this->db->delete('t_Vehicles');
	}
	public function vh_input_update(){
		$this->db->cache_delete('admpro', 'vehicles');
		$column_name = $this->input->post('columnName');
		foreach($_POST[$column_name] as $key => $val) {
			if($column_name == 'Years'){
				$data = array($column_name => str_replace('-', ',', $val));
			}else{
				$data = array($column_name => $val);
			}

			$query = $this->db->query("SELECT ".$column_name." FROM t_Vehicles WHERE id =".$key."");
			$old_values =  $query->first_row();
			$old_values = json_decode(json_encode($old_values), true);
			$new_values = $data;
			$add_activity_log = add_activity_log($key,$old_values,$new_values,'Vehicle','t_vehicles_logs');	

			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Vehicles', $data);
		}			
		if(isset($val)){
			if($column_name == 'Years'){
				return str_replace(',', '-', $val);
			}if($column_name == 'OBD_Location_Image'){
				return '<a href="'.$val.'" target="_blank"><img src="'.$val.'" style="width:50px;"></a>';
			}else{
				return $val;
			}
		}else{
			return '';
		}
	}
	
	public function update_vehicle_image1(){
		$this->db->cache_delete('admpro', 'vehicles');
		$column_name = $this->input->post('columnName');
		$id = $this->input->post('id');
		$val = $this->input->post('image_name');
		$data = array($column_name => $val);
		
		$query = $this->db->query("SELECT ".$column_name." FROM t_Vehicles WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Vehicle','t_vehicles_logs');

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Vehicles', $data);
		return $val;
	}
	public function vehicle_common_sorting_count($vehicle_type,$makeId,$modelId,$vehicle_type_missing){
		$where = "";
		if($makeId !="" && $makeId !="All" && $modelId !="" && $modelId !="All"){
			$where = "AND t_Makes.UUID='".$makeId."' AND t_Models.Make_UUID='".$modelId."'";
		}else if($makeId !="" && $makeId !="All"){
			$where = "AND t_Makes.UUID='".$makeId."'";
		}
		if($vehicle_type !="" && $vehicle_type !="All"){
			$where .= " AND t_Models.Vehicle_Type_UUID='".$vehicle_type."'";
		}
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE 1 ".$where." ");	
		return $query->num_rows();
	}
	public function vehicle_common_sorting($limit,$limt_start,$vehicle_type,$makeId,$modelId,$vehicle_type_missing){		
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');
		$where = "";
		if($makeId !="" && $makeId !="All" && $modelId !="" && $modelId !="All"){
			$where = "AND t_Makes.UUID='".$makeId."' AND t_Models.UUID='".$modelId."'";
		}else if($makeId !="" && $makeId !="All"){
			$where = "AND t_Makes.UUID='".$makeId."'";
		}
		if($vehicle_type !="" && $vehicle_type !="All"){
			$where .= " AND t_Models.Vehicle_Type_UUID='".$vehicle_type."'";
		}		
		if(isset($_SESSION['global_sorting']) && $_SESSION['global_sorting'] !=""){
			$global_sorting = $_SESSION['global_sorting'];
		}else{
			$global_sorting = "t_Makes.Make_Name, t_Models.Model_Name";
		}
		$query = $this->db->query("SELECT t_Models.Vehicle_Type_UUID,t_Vehicles.image_url,t_Makes.Make_Name,t_Vehicles.UUID,t_Models.Model_Name,t_Vehicles.id,t_Vehicles.Model_UUID,t_Vehicles.Years,t_Vehicles.Code_Series_UUID,t_Vehicles.Retainer_UUID,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Remote_UUID,t_Vehicles.RHK_UUID,t_Vehicles.SmartKey_UUID,t_Vehicles.MVP_System,t_Vehicles.MVP_Dongle_UUID,t_Vehicles.MVP_SmartCard,t_Vehicles.MVP_Software,t_Vehicles.MVP_PIN_Required,t_Vehicles.MVP_PIN_Read,t_Vehicles.ProLok_Tool_UUID,t_Vehicles.ProLok_Linkage,t_Vehicles.Vehicle_Image,t_Vehicles.Image_UUID,t_Vehicles.MVP_Notes,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Notes,t_Vehicles.HW_Key_Prog,t_Vehicles.HW_Remote_Prog,t_Vehicles.HW_Misc_Prog,t_Vehicles.TKOSDD_System,t_Vehicles.TKOSDD_SDD_Adapter,t_Vehicles.TKOSDD_SDD_Cable,t_Vehicles.TKOSDD_TKO_Cable,t_Vehicles.TKOSDD_Notes,t_Vehicles.APP_Confirmed_Working,t_Vehicles.DMax_System,t_Vehicles.DMax_Method,t_Vehicles.Parts_Ignition,t_Vehicles.Parts_Door,t_Vehicles.Parts_Accessories,t_Vehicles.Vehicle_Type,t_Vehicles.Tumblers,t_Vehicles.OBD_Location_Text,t_Vehicles.OBD_Location_Image,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.APP_Youtube_URL,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Youtube_Title,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Keyed_Ignition ,t_Vehicles.Generation_YearRange,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System FROM t_Vehicles JOIN t_Models ON t_Models.UUID = t_Vehicles.Model_UUID	LEFT JOIN t_Makes ON t_Makes.UUID = t_Models.Make_UUID WHERE 1 ".$where." ORDER BY ".$global_sorting." LIMIT  ".(int)$limt_start.", ".(int)$limit."");	
		return $query->result_array();
	}

/*--------------------------------- Code Series ------------------------------------*/

	public function getAllCodeSeriesRows(){
		return $this->db->count_all("t_Code_Series");
	}
	public function getAllCodeSeriesData($limit, $limt_start){
		$query = $this->db->select("*")->order_by('Code_Series_Name','asc')->limit($limit,$limt_start)->get('t_Code_Series');
		return $query->result_array();
	}
	public function getAllCodeSeries(){
		$query = $this->db->select("*")->order_by('Code_Series_Name','asc')->get('t_Code_Series');
		return $query->result_array();
	}
	public function getAllkeyStyles(){
		$query = $this->db->select("UUID,Key_Style_Name,id")->order_by('Key_Style_Name','asc')->get('t_Key_Styles');
		return $query->result_array();
	}
	public function filter_cs_by_kstyle(){	
		$keyStyleID = $this->input->post('keyStyleID');	
		if($keyStyleID == 'all'){
			$query = $this->db->select("*")->order_by('Code_Series_Name','asc')->get('t_Code_Series');
		}else{	
			$query = $this->db->select("*")->order_by('Code_Series_Name','asc')->where('Key_Style_UUID',$keyStyleID)->get('t_Code_Series');
		}
		return $query->result_array();
	}
	
	public function search_code_series(){
		$search_key = trim($this->input->post('search_key'));
		$tool_type_id = "";	
		$manufacturers_query = $this->db->select("*")->like('Manufacturer_Name',$search_key)->get('t_Manufacturers');
		$manufacturers_query1 = $manufacturers_query->result_array();
		
		$tool_type_query = $this->db->select("*")->like('Tool_Name',$search_key)->get('t_Tools');
		$tool_type_query1 = $tool_type_query->result_array();
		
		if($manufacturers_query->num_rows() > 0){
			$manufacturerer_id = "";
			foreach($manufacturers_query1 as $manufacturerer){
				$manufacturerer_id .= "'". $manufacturerer['UUID']."',";
			}
			$manufacturerer_id2 = rtrim($manufacturerer_id,",");
			$query = $this->db->select("*")->where_in('Lishi_UUID',$manufacturerer_id2)->get('t_Code_Series');
		}else if($tool_type_query->num_rows() > 0){
			foreach($tool_type_query1 as $tool_type){
				$tool_type_id .= "'". $tool_type['UUID']."',";
			}
			$tool_type2 = rtrim($tool_type_id,",");
			$query = $this->db->select("*")->where_in('SDKeys_UUID',$tool_type2)->or_where_in('TryOutKeys_UUID',$tool_type2)->get('t_Code_Series');
		}else{	
			$sql = "SELECT * FROM  t_Code_Series WHERE Code_Series_Name LIKE ? OR HPC_Blitz_Card LIKE  ? OR HPC_Punch_Card LIKE ?";
			$query = $this->db->query($sql, array($search_key, $search_key, $search_key));
		}			
		return $query->result_array();
	}
	

	public function getCodeSeries($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_Code_Series');
		return $query->result_array();
	}
	public function EditcodeSeries(){
		$this->db->cache_delete('admpro', 'vehicles');
		$codeId = $this->input->post('codeid');		
		$data = array(
				'Code_Series_Name' => $this->input->post('name'),
				'Spaces'=> $this->input->post('spaces'),
				'Depths'=> $this->input->post('depth'),
				'MACS' => $this->input->post('MACS'),
				'Key_Style_UUID' =>$this->input->post('key_style')
		);		
		$this->db->where('id', $codeId);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Code_Series', $data);
		return true;		
	}	
	public function DeleteCodeSeries($id){
		$this->db->cache_delete('admpro', 'vehicles');
		$query = $this->db->select("UUID")->where('id',(int)$id)->get('t_Code_Series');
		$return = $query->result_array();
		$code_series_uuid = $return[0]['UUID'];
		$query = $this->db->select("Code_Series_UUID")->where('Code_Series_UUID',$code_series_uuid)->get('t_Vehicles');
		if($query->num_rows() > 0){
			return 2;
		}else{
			$this->db->where('id', $id);
			$this->db->delete('t_Code_Series');
		}  
	}
	public function AddCode(){		
		$try_out_keys_UUID = "";
		$this->db->cache_delete('admpro', 'vehicles');
		foreach( $this->input->post('TryOutKeys_UUID') as $TryOutKeys_UUID){
			$try_out_keys_UUID .= $TryOutKeys_UUID.',';
		}
		$code_series_name = $this->input->post('code_series_name');
		$data = array(
					'UUID' => md5(uniqid(mt_rand(), true)),
					'Code_Series_Name' => $this->input->post('code_series_name'),
					
					'Spaces' => $this->input->post('space'),
					
					'Depths' => $this->input->post('depth'),
					
					'MACS' => $this->input->post('macs'),
					
					'Key_Style_UUID' => $this->input->post('key_style_uuid'),
										
					'First_Cut' => $this->input->post('first_cut'),
					
					'Space_Between_Cuts' => $this->input->post('space_between_cuts'),
					
					'Code_Series_Notes' => $this->input->post('notes'),
					
					'Determinator_UUID' => $this->input->post('determinator_uuid'),
					
					'Lishi_UUID' => $this->input->post('lishi_uuid'),	
										
					'Accu-Reader_UUID' => $this->input->post('accu_reader_uuid'),
					
					'EEZ-Reader_UUID' => $this->input->post('eez_reader_uuid'),
					
					'SDKeys_UUID' => $this->input->post('sd_keys_uuid'),	
									
					'HPC_Blitz_Card' => $this->input->post('HPC_Blitz_Card'),
					
					'HPC_Blitz_Cutter' => $this->input->post('HPC_Blitz_Cutter'),
					
					'HPC_Blitz_Position' => $this->input->post('HPC_Blitz_Position'),
					
					'HPC_Blitz_Side' => $this->input->post('HPC_Blitz_Side'),
					
					'Silca_Card' => $this->input->post('Silca_Card'),	
							
					'Silca_Cutter' => $this->input->post('Silca_Cutter'),
					
					'HPC_Blitz_Notes' => $this->input->post('HPC_Blitz_Notes'),
										
					'HPC_Punch_Card' => $this->input->post('HPC_Punch_Card'),
					
					'HPC_Punch_Punch' => $this->input->post('HPC_Punch_Punch'),
					
					'HPC_Punch_Side' => $this->input->post('HPC_Punch_Side'),
					
					'HPC_Punch_Notes' => $this->input->post('HPC_Punch_Notes'),
										
					'HPC_CodeMax_DSD' => $this->input->post('HPC_CodeMax_DSD'),
					
					'HPC_CodeMax_Side' => $this->input->post('HPC_CodeMax_Side'),
					
					'HPC_CodeMax_Position' => $this->input->post('HPC_CodeMax_Position'),
					
					'HPC_CodeMax_Cutter' => $this->input->post('HPC_CodeMax_Cutter'),
					
					'HPC_CodeMax_Notes' => $this->input->post('HPC_CodeMax_Notes'),	
											
					'ITL_ID' => $this->input->post('ITL_ID'),
					
					'ITL_Insert' => $this->input->post('ITL_Insert'),
					
					'ITL_Notes' => $this->input->post('ITL_Notes'),
										
					'Curtis_CamSet' => $this->input->post('Curtis_CamSet'),
					'Curtis_Carriage' => $this->input->post('Curtis_Carriage'),
					'Curtis_Cutter' => $this->input->post('Curtis_Cutter'),
					'Curtis_Notes' => $this->input->post('Curtis_Notes'),
					'Keyline_Ninja_Vice' => $this->input->post('Keyline_Ninja_Vice'),
					'Keyline_Ninja_Side' => $this->input->post('Keyline_Ninja_Side'),
					'Keyline_Ninja_Position' => $this->input->post('Keyline_Ninja_Position'),
					'Keyline_Ninja_Cutter' => $this->input->post('Keyline_Ninja_Cutter'),
					'Pak_QCKit' => $this->input->post('Pak_QCKit'),
					'Pak_Vise' => $this->input->post('Pak_Vise'),
					'Pak_Punch' => $this->input->post('Pak_Punch'),
					'Pak_Die' => $this->input->post('Pak_Die'),
					'Framon_Block' => $this->input->post('Framon_Block'),
					'Framon_Cutter' => $this->input->post('Framon_Cutter'),
					'Framon_FirstCut' => $this->input->post('Framon_FirstCut'),
					'Framon_BetweenCuts' => $this->input->post('Framon_BetweenCuts'),
					'Framon_Notes' => $this->input->post('Framon_Notes'),
					'SW2_SpaceRod' => $this->input->post('SW2_SpaceRod'),
					'SW2_DepthRod' => $this->input->post('SW2_DepthRod'),
					'SW2_Cutter' => $this->input->post('SW2_Cutter'),
					'SW2_Guide' => $this->input->post('SW2_Guide'),
					'SW2_ViseSet' => $this->input->post('SW2_ViseSet'),
					'SW2_Stop' => $this->input->post('SW2_Stop'),
					'LKP_3DX_DSD' => $this->input->post('LKP_3DX_DSD'),
					'LKP_3DX_Jaw' => $this->input->post('LKP_3DX_Jaw'),
					'LKP_3DX_Cutter' => $this->input->post('LKP_3DX_Cutter'),
					'Keyline_994_Vise' => $this->input->post('Keyline_994_Vise'),
					'Keyline_994_Side' => $this->input->post('Keyline_994_Side'),
					'Keyline_994_Position' => $this->input->post('Keyline_994_Position'),
					'Keyline_994_Cutter' => $this->input->post('Keyline_994_Cutter'),
					'Silca_Futura_SSN' => $this->input->post('Silca_Futura_SSN'),
					'Silca_Futura_Card' => $this->input->post('Silca_Futura_Card'),
					'Determinator_UUID' => $this->input->post('Determinator_UUID'),
					'Lishi_UUID' => $this->input->post('Lishi_UUID'),
					'Accu-Reader_UUID' => $this->input->post('Accu-Reader_UUID'),
					'EEZ-Reader_UUID' => $this->input->post('EEZ-Reader_UUID'),
					'SDKeys_UUID' => $this->input->post('SDKeys_UUID'),
					'TryOutKeys_UUID' => $try_out_keys_UUID,
					'A1AutoPicks_UUID' => $this->input->post('A1AutoPicks_UUID'),
					'BuildAKey_UUID' => $this->input->post('BuildAKey_UUID'),
					'LKP_3DX_JawClamp' => $this->input->post('LKP_3DX_JawClamp'),
					'LKP_3DX_Stop' => $this->input->post('LKP_3DX_Stop'),
					'LKP_3DX_Notes' => $this->input->post('LKP_3DX_Notes'),
					'Condor_KeyName' => $this->input->post('Condor_KeyName'),
					'Condor_Cutter' => $this->input->post('Condor_Cutter'),
					'Condor_Jaw' => $this->input->post('Condor_Jaw'),
					'Condor_JawSide' => $this->input->post('Condor_JawSide'),
					'Condor_Stop' => $this->input->post('Condor_Stop'),
					'Condor_Notes' => $this->input->post('Condor_Notes')
		);	
		$exist_query = $this->db->select("*")->where('Code_Series_Name',$code_series_name)->get('t_Code_Series');		
		if($exist_query->num_rows() > 0){
				return false;				
		}else{	
			$data = $this->security->xss_clean($data);	
			$this->db->insert('t_Code_Series', $data);				
		  return  $this->db->insert_id();
		}
	}
	
	public function update_code_series(){
		$this->db->cache_delete('admpro', 'vehicles');
		$code_series_id = $this->input->post('code_series_id');
		$try_out_keys_UUID = "";
		foreach( $this->input->post('TryOutKeys_UUID') as $TryOutKeys_UUID){
			$try_out_keys_UUID .= $TryOutKeys_UUID.',';
		}
		$data = array(					
					'Code_Series_Name' => $this->input->post('code_series_name'),
					
					'Spaces' => $this->input->post('space'),
					
					'Depths' => $this->input->post('depth'),
					
					'MACS' => $this->input->post('macs'),
					
					'Key_Style_UUID' => $this->input->post('key_style_uuid'),
										
					'First_Cut' => $this->input->post('first_cut'),
					
					'Space_Between_Cuts' => $this->input->post('space_between_cuts'),
					
					'Code_Series_Notes' => $this->input->post('notes'),
					
					'Determinator_UUID' => $this->input->post('determinator_uuid'),
					
					'Lishi_UUID' => $this->input->post('lishi_uuid'),	
										
					'Accu-Reader_UUID' => $this->input->post('accu_reader_uuid'),
					
					'EEZ-Reader_UUID' => $this->input->post('eez_reader_uuid'),
					
					'SDKeys_UUID' => $this->input->post('sd_keys_uuid'),	
									
					'HPC_Blitz_Card' => $this->input->post('HPC_Blitz_Card'),
					
					'HPC_Blitz_Cutter' => $this->input->post('HPC_Blitz_Cutter'),
					
					'HPC_Blitz_Position' => $this->input->post('HPC_Blitz_Position'),
					
					'HPC_Blitz_Side' => $this->input->post('HPC_Blitz_Side'),
					
					'Silca_Card' => $this->input->post('Silca_Card'),	
							
					'Silca_Cutter' => $this->input->post('Silca_Cutter'),
					
					'HPC_Blitz_Notes' => $this->input->post('HPC_Blitz_Notes'),
										
					'HPC_Punch_Card' => $this->input->post('HPC_Punch_Card'),
					
					'HPC_Punch_Punch' => $this->input->post('HPC_Punch_Punch'),
					
					'HPC_Punch_Side' => $this->input->post('HPC_Punch_Side'),
					
					'HPC_Punch_Notes' => $this->input->post('HPC_Punch_Notes'),
										
					'HPC_CodeMax_DSD' => $this->input->post('HPC_CodeMax_DSD'),					
					'HPC_CodeMax_Side' => $this->input->post('HPC_CodeMax_Side'),					
					'HPC_CodeMax_Position' => $this->input->post('HPC_CodeMax_Position'),					
					'HPC_CodeMax_Cutter' => $this->input->post('HPC_CodeMax_Cutter'),					
					'HPC_CodeMax_Notes' => $this->input->post('HPC_CodeMax_Notes'),											
					'ITL_ID' => $this->input->post('ITL_ID'),					
					'ITL_Insert' => $this->input->post('ITL_Insert'),					
					'ITL_Notes' => $this->input->post('ITL_Notes'),										
					'Curtis_CamSet' => $this->input->post('Curtis_CamSet'),
					'Curtis_CamSet' => $this->input->post('Curtis_CamSet'),
					'Curtis_Carriage' => $this->input->post('Curtis_Carriage'),
					'Curtis_Cutter' => $this->input->post('Curtis_Cutter'),
					'Curtis_Notes' => $this->input->post('Curtis_Notes'),
					'Keyline_Ninja_Vice' => $this->input->post('Keyline_Ninja_Vice'),
					'Keyline_Ninja_Side' => $this->input->post('Keyline_Ninja_Side'),
					'Keyline_Ninja_Position' => $this->input->post('Keyline_Ninja_Position'),
					'Keyline_Ninja_Cutter' => $this->input->post('Keyline_Ninja_Cutter'),
					'Pak_QCKit' => $this->input->post('Pak_QCKit'),
					'Pak_Vise' => $this->input->post('Pak_Vise'),
					'Pak_Punch' => $this->input->post('Pak_Punch'),
					'Pak_Die' => $this->input->post('Pak_Die'),
					'Framon_Block' => $this->input->post('Framon_Block'),
					'Framon_Cutter' => $this->input->post('Framon_Cutter'),
					'Framon_FirstCut' => $this->input->post('Framon_FirstCut'),
					'Framon_BetweenCuts' => $this->input->post('Framon_BetweenCuts'),
					'Framon_Notes' => $this->input->post('Framon_Notes'),
					'SW2_SpaceRod' => $this->input->post('SW2_SpaceRod'),
					'SW2_DepthRod' => $this->input->post('SW2_DepthRod'),
					'SW2_Cutter' => $this->input->post('SW2_Cutter'),
					'SW2_Guide' => $this->input->post('SW2_Guide'),
					'SW2_ViseSet' => $this->input->post('SW2_ViseSet'),
					'SW2_Stop' => $this->input->post('SW2_Stop'),
					'LKP_3DX_DSD' => $this->input->post('LKP_3DX_DSD'),
					'LKP_3DX_Jaw' => $this->input->post('LKP_3DX_Jaw'),
					'LKP_3DX_Cutter' => $this->input->post('LKP_3DX_Cutter'),
					'Keyline_994_Vise' => $this->input->post('Keyline_994_Vise'),
					'Keyline_994_Side' => $this->input->post('Keyline_994_Side'),
					'Keyline_994_Position' => $this->input->post('Keyline_994_Position'),
					'Keyline_994_Cutter' => $this->input->post('Keyline_994_Cutter'),
					'Silca_Futura_SSN' => $this->input->post('Silca_Futura_SSN'),
					'Silca_Futura_Card' => $this->input->post('Silca_Futura_Card'),
					'Determinator_UUID' => $this->input->post('Determinator_UUID'),
					'Lishi_UUID' => $this->input->post('Lishi_UUID'),
					'Accu-Reader_UUID' => $this->input->post('Accu-Reader_UUID'),
					'EEZ-Reader_UUID' => $this->input->post('EEZ-Reader_UUID'),
					'SDKeys_UUID' => $this->input->post('SDKeys_UUID'),
					'TryOutKeys_UUID' => $try_out_keys_UUID,
					'A1AutoPicks_UUID' => $this->input->post('A1AutoPicks_UUID'),
					'BuildAKey_UUID' => $this->input->post('BuildAKey_UUID'),
					'LKP_3DX_JawClamp' => $this->input->post('LKP_3DX_JawClamp'),
					'LKP_3DX_Stop' => $this->input->post('LKP_3DX_Stop'),
					'LKP_3DX_Notes' => $this->input->post('LKP_3DX_Notes'),
					'Condor_KeyName' => $this->input->post('Condor_KeyName'),
					'Condor_Cutter' => $this->input->post('Condor_Cutter'),
					'Condor_Jaw' => $this->input->post('Condor_Jaw'),
					'Condor_JawSide' => $this->input->post('Condor_JawSide'),
					'Condor_Stop' => $this->input->post('Condor_Stop'),
					'Condor_Notes' => $this->input->post('Condor_Notes')
				);
			$this->db->where('id', $code_series_id);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Code_Series', $data);
	}
	public function code_series_sort(){	
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');		
		$query = $this->db->query("SELECT * FROM t_Code_Series ORDER BY $sorting_by $sort");
		return $query->result_array();
	}
	public function csinput_update(){
		$this->db->cache_delete('admpro', 'vehicles');
			$column_name = $this->input->post('columnName');
			foreach($_POST[$column_name] as $key => $val) {
				$data = array($column_name => $val);
				$this->db->where('id', $key);
				$data = $this->security->xss_clean($data);
				$this->db->update('t_Code_Series', $data);
			}			
			if(isset($val)){
				return $val;
			}else{
				return '';
			}
	}
	
	public function cs_keys_data_update(){
			$this->db->cache_delete('admpro', 'vehicles');
			$columnName = $this->input->post('columnName');
			foreach($_POST[$columnName] as $key => $val) {
				$data = array($columnName => $val);
				$this->db->where('id', $key);
				$data = $this->security->xss_clean($data);
				$this->db->update('t_Code_Series', $data);
			}
			$query = $this->db->query("SELECT * FROM  t_Tools WHERE UUID = ? ",array($val));
			$return = $query->result_array();
			if(isset($return[0]['Tool_Name'])){
				return $return[0]['Tool_Name'];
			}else{
				return '';
			}			
	}	
	public function update_machine_data(){			
		$columnName = $this->input->post('columnName');
		foreach($_POST[$columnName] as $key => $val) {
			$data = array($columnName => $val);
			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Code_Series', $data);
		}
		$query = $this->db->query("SELECT * FROM  t_Machines_Info WHERE UUID = ? ",array($val));
		$return = $query->result_array();
		if(isset($return[0]['Name'])){
			return $return[0]['Name'];
		}else{
			return '';
		}			
	}
	public function update_key_style_data(){
		$columnName = $this->input->post('columnName');
		foreach($_POST[$columnName] as $key => $val) {
			$data = array($columnName => $val);
			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Code_Series', $data);
		}
		$query = $this->db->query("SELECT * FROM  t_Key_Styles WHERE UUID = ? ",array($val));
		$return = $query->result_array();
		if(isset($return[0]['Key_Style_Name'])){
			return $return[0]['Key_Style_Name'];
		}else{
			return '';
		}	
	}

/*------------------------ Makes ----------------------------------------------*/

	public function getAllMakeNamesRows(){		
		return $this->db->count_all("t_Makes");	
	}
	public function getAllMakeNamesDetail($limit,$limt_start){
		$query = $this->db->select("*")->order_by('Make_Name','asc')->limit($limit,$limt_start)->get('t_Makes');
		return $query->result_array();
	}
	public function MakesName(){
		$makeUsername = $this->input->post('make_name');
		$uuid =  $this->input->post('uuid');
			$data = array(
				'Make_Name' => $this->input->post('make_name'),
				'UUID'	 => $this->input->post('uuid'),
			);
			$this->db->cache_delete('admpro', 'vehicles');	
			$query = $this->db->select('Make_Name')->where('Make_Name',$makeUsername)->where('UUID',$uuid)->get('t_Makes');
			if($query->num_rows() > 0){
				$this->session->set_flashdata('message_display', 'Email already exits.');	
				return false;				
			}else{
				$data = $this->security->xss_clean($data);
				$this->db->insert('t_Makes', $data);					
				return true;		
			}
	}
	public function deleteMake($id){
		$this->db->cache_delete('admpro', 'vehicles');
		$query = $this->db->select("*")->where('id',$id)->get('t_Makes');
		$return = $query->result_array();
		$make_uuid = $return[0]['UUID'];
		$query = $this->db->select("*")->where('Make_UUID',$make_uuid)->get('t_Models');
		if($query->num_rows() > 0){
			$this->db->where('Make_UUID', $make_uuid);
			$this->db->delete('t_Models');
			$this->db->where('id', $id);
			$this->db->delete('t_Makes');
		}else{
			$this->db->where('id', $id);
			$this->db->delete('t_Makes');
		} 
	}
	
	
	public function getMakeInfo($id){
		$query = $this->db->select("*")->where('id',$id)->get('t_Makes');
		return $query->result_array();
	}
	
	
	public function EditMAkesNAme(){
		$this->db->cache_delete('admpro', 'vehicles');
		$make_nameid = $this->input->post('makeID');
		$this->db->cache_delete('admpro', 'vehicles');		
		$data = array(
			'Make_Name' => $this->input->post('make_name')
		);	
		
		$query = $this->db->query("SELECT Make_Name FROM t_Makes WHERE id =".$make_nameid."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($make_nameid,$old_values,$new_values,'Make','t_make_logs');		

		$this->db->where('id', $make_nameid);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Makes', $data);
		return true;		
	}
	public function MakeSortList($orderby){
		$query = $this->db->select("*")->order_by('Make_Name',$orderby)->get('t_Makes');
		return $query->result_array();
	}

/*--------------------------------------- Models -----------------------------------------*/	
	public function getAllModel($limit, $limt_start){
		$query = $this->db->select("*")->order_by('Model_Name','asc')->limit($limit,$limt_start)->get('t_Models');
		return $query->result_array();
	}		
	public function getAllModelRows(){
		return $this->db->count_all("t_Models");
	}
	public function getModelInfo($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_Models');
		return $query->result_array();
	}
	public function EditModel(){
		$this->db->cache_delete('admpro', 'vehicles');	
		$modelId = $this->input->post('modelID');						
		$data = array(
			'Model_Name' => $this->input->post('model_name'),
			'Make_UUID' => $this->input->post('make_name'),
			'Vehicle_Type_UUID' => $this->input->post('vehicle_type'),			
		);
		
		$query = $this->db->query("SELECT Model_Name,Make_UUID,Vehicle_Type_UUID FROM t_Models WHERE id =".$modelId."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($modelId,$old_values,$new_values,'Make','t_model_logs');	
		
		$this->db->where('id' ,(int)$modelId);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Models', $data);
		return true;	
	}
	public function deleteModel($id){
		$this->db->cache_delete('admpro', 'vehicles');
		$this->db->where('id', $id);
		$this->db->delete('t_Models'); 
	}
	public function modelName(){
		$this->db->cache_delete('admpro', 'vehicles');
		$modelId = $this->input->post('model_name');
		$makes = $this->input->post('make_name');
			$data = array(
				'Model_Name' => $this->input->post('model_name'),
				'Make_UUID' => $this->input->post('make_name'),
				'UUID' => md5(uniqid(mt_rand(), true)),
				'Vehicle_Type_UUID' =>$this->input->post('vehicle_type')
			);		
			$query = $this->db->select("*")->where('Model_Name',$modelId)->where('Make_UUID',$makes)->get('t_Models');		
			if($query->num_rows() > 0){
				return false;				
			}else{
				$data = $this->security->xss_clean($data);
				$this->db->insert('t_Models', $data);
				return true;		
			}
	}	
	public function makenamesorting($orderby){
		$query = $this->db->select("*")->order_by('Make_UUID',$orderby)->get('t_Models');	
		return $query->result_array();
	}
	public function getallmakes(){
			$query = $this->db->select("*")->get('t_Makes');
		 return $query->result_array();
	}
	public function filter_by_makes(){
		$make_uuid = $this->input->post('make_uuid');
		if( $make_uuid == 'all'){
			if(isset($this->session->userdata['pagination_per_page'])){
				$per_page = $this->session->userdata['pagination_per_page']; 
				$limit = $per_page['per_page'];
			}else{
				$limit = 50;
			}
			$query = $this->db->select("*")->limit($limit)->get('t_Models');
		}else{
			$query = $this->db->select("*")->where('Make_UUID',$make_uuid)->get('t_Models');
		}
		return $query->result_array();
	}
	public function search_makes(){
		$makes_id = "";
		$search_key = $this->input->post('search_key');	
		$make_query = $this->db->select("*")->like('Make_Name',$search_key)->get('t_Makes');
		$make_query1 = $make_query->result_array();
		if($make_query->num_rows() > 0){
			foreach($make_query1 as $makes){
				$makes_id .= "'". $makes['UUID']."',";
			}
			$makes_id2 = rtrim($makes_id,",");
			$query = $this->db->select("*")->where_in('Make_UUID',$makes_id2)->get('t_Models');
		}else{	
			$query = $this->db->select("*")->like('Model_Name',$search_key)->get('t_Models');
		}
		return $query->result_array();
	}
	public function vehicle_types(){
		$query = $this->db->query("SELECT * FROM t_Vehicle_Types ");
		return $query->result_array();
	}

	public function getUsersInfo($id){
		$query = $this->db->select('*')->where('UserID',$id)->get('admin');
		return $query->result_array();
	}
	public function UpdateUser(){
		$this->db->cache_delete('admpro', 'manage_user');
		$this->db->cache_delete('admpro', 'account');
		$userid = $this->input->post('userId');
		$password = $this->input->post('password');
		$password_encoded = hash("sha256", $password);
		
		if($this->input->post('admin_access') == 'on'){
			$admin_access = 1;
		}else{
			$admin_access = 0;
		}
		if( $password  == ""){
			$data = array(
				'user_name' => $this->input->post('user_name'),
				'type' => $this->input->post('select_admin'),
				'email' => $this->input->post('email'),					
				'Company' => $this->input->post('company'),
				'APP_switcher' => $admin_access
			);	
		}else{
			$data = array(
				'user_name' => $this->input->post('user_name'),
				'type' => $this->input->post('select_admin'),
				'email' => $this->input->post('email'),
				'password' => $password_encoded,
				'Company' => $this->input->post('company'),
				'APP_switcher' => $admin_access
			);	
		}
		$this->db->where('UserID', $userid);
		$data = $this->security->xss_clean($data);
		$this->db->update('admin', $data);
	}
	public function deleteAllModel($id){
		$this->db->where('id', $id);
		$this->db->delete('t_Models');
	}
	public function deleteAllMakes($id){
		$query = $this->db->select("*")->where('id',$id)->get('t_Makes');
		$return = $query->result_array();
		$make_uuid = $return[0]['UUID'];
		$query = $this->db->select("*")->where('Make_UUID',$make_uuid)->get('t_Models');
		if($query->num_rows() > 0){
			$this->db->where('Make_UUID', $make_uuid);
			$this->db->delete('t_Models');
			$this->db->where('id', $id);
			$this->db->delete('t_Makes');
		}else{
			$this->db->where('id', $id);
			$this->db->delete('t_Makes');
		} 
	}
/*------------------------------------------------ Keys Module ----------------------------------------*/	
	public function getAllKyesRows(){
		return $this->db->count_all("t_Keys");
	}
	public function getsearchkey($search_key){
		$makes_id = "";		
		$make_query = $this->db->query("SELECT * FROM t_Chips WHERE Chip_Name LIKE '%$search_key%'");
		$make_query1 = $make_query->result_array();
		
		if($make_query->num_rows() > 0){
			foreach($make_query1 as $makes){
				$makes_id .= "'". $makes['UUID']."',";
			}
			$makes_id2 = rtrim($makes_id,",");
			$query = $this->db->query("SELECT * FROM t_Keys WHERE Chip_UUID IN($makes_id2)");
		}else{	
			$query = $this->db->query("SELECT * FROM t_Keys WHERE Key_Name LIKE '%$search_key%' OR Products LIKE '%$search_key%'  OR Alt_Ilco LIKE '%$search_key%' OR Alt_Axxess LIKE '%$search_key%' OR Alt_Hillman LIKE '%$search_key%' OR Alt_Curtis LIKE '%$search_key%' OR Alt_ESP LIKE '%$search_key%' OR Alt_JMA LIKE '%$search_key%' OR Alt_Jet LIKE '%$search_key%' OR Alt_Strattec LIKE '%$search_key%' OR Alt_Silca LIKE '%$search_key%' OR Alt_Taylor LIKE '%$search_key%' OR Alt_OEM LIKE '%$search_key%' OR Alt_Other LIKE '%$search_key%' ");
		}
		return $query->result_array();
	}
	public function getAlkeys($limit,$limt_start){
		$query = $this->db->select("*")->order_by('Key_Name' ,'asc')->limit($limit,$limt_start)->get('t_Keys');
		return $query->result_array();
	}
	public function getlockerfilter($typeUuid){			
		$query = $this->db->query("SELECT * FROM t_Keys WHERE lock_type = ? ",array($typeUuid));
		return $query->result_array();
	}
	public function show_session_keysby_types($value_key){
		$typeUuid = $value_key;	
		if($typeUuid == 'all'){
			$query = $this->db->select("*")->order_by('Key_Name' ,'asc')->get('t_Keys');
		}else{		
			$query = $query = $this->db->select("*")->where('Key_Type_UUID' ,$typeUuid)->get('t_Keys');
		}
		return $query->result_array();
	}
	
	public function getkeys(){
		$query = $this->db->select("*")->order_by('Key_Name' ,'asc')->get('t_Keys');
		return $query->result_array();
	}
	public function getAllChips(){
		$query = $this->db->select("*")->order_by('Chip_Name','asc')->get('t_Chips');
		return $query->result_array();
	}
	public function getkeysInfo($id){
		$query = $this->db->select("*")->where('id' ,(int)$id)->get('t_Keys');
		return $query->result_array();
	}
	public function save_key($file_name){
		$substitute_vals = "";
		$this->db->cache_delete('admpro', 'keys');
		$this->db->cache_delete('admpro', 'edit_key');
				
		$data = array(
				'UUID' => md5(uniqid(mt_rand(), true)),
				'Chip_UUID' => $this->input->post('chips'),
				'Key_Name' => $this->input->post('key_name'),
				'Key_Image' => $file_name,
				'Key_Image_CDN' => '',
				'Key_Type_UUID' => $this->input->post('key_type'),
				'Products' => $this->input->post('products'),
				'Alt_Ilco' => $this->input->post('Alt_Ilco'),
				'Alt_Axxess' => $this->input->post('Alt_Axxess'),
				'Alt_Hillman' => $this->input->post('Alt_Hillman'),
				'Alt_Curtis' => $this->input->post('Alt_Curtis'),
				'Alt_ESP' => $this->input->post('Alt_ESP'),
				'Alt_JMA' => $this->input->post('Alt_JMA'),
				'Alt_Jet' => $this->input->post('Alt_Jet'),
				'Alt_Strattec' => $this->input->post('Alt_Strattec'),
				'Alt_Silca' => $this->input->post('Alt_Silca'),
				'Alt_Taylor' => $this->input->post('Alt_Taylor'),
				'Alt_OEM' => $this->input->post('Alt_OEM'),				
				'Alt_Other' => $this->input->post('Alt_Other'),				
				'Replacement_blade' => $this->input->post('Replacement_blade'),
				'Key_Head_UUID' => $this->input->post('Key_Head_UUID'),
				'Key_Blade_UUID' => $this->input->post('Key_Blade_UUID'),
				'Alt_MFK' => $this->input->post('Alt_MFK')
		);	
		$data = $this->security->xss_clean($data);	
		$this->db->insert('t_Keys', $data);
		return true;
	}
	/*======================== Key page - Alternative Keys=========================================*/
	
	public function get_substitute_keys(){
		$key_Type_UUID = $this->input->post('key');
		$query = $this->db->query("SELECT * FROM  t_Keys WHERE Key_Type_UUID = ? ORDER BY Key_Name",array($key_Type_UUID));
		return $query->result_array();
	}
	public function update_key($file_name){
		$this->db->cache_delete('admpro', 'keys');
		$this->db->cache_delete('admpro', 'edit_key');
		$keyid = $this->input->post('keyid');
	
		$extra_field = "";
		if($file_name == ""){
			$data = array(				
				'Chip_UUID' => $this->input->post('chips'),
				'Key_Name' => $this->input->post('key_name'),							
				'Key_Type_UUID' => $this->input->post('key_type'),
				'Products' => $this->input->post('products'),				
				'Alt_Ilco' => $this->input->post('Alt_Ilco'),
				'Alt_Axxess' => $this->input->post('Alt_Axxess'),
				'Alt_Hillman' => $this->input->post('Alt_Hillman'),
				'Alt_Curtis' => $this->input->post('Alt_Curtis'),
				'Alt_ESP' => $this->input->post('Alt_ESP'),
				'Alt_JMA' => $this->input->post('Alt_JMA'),
				'Alt_Jet' => $this->input->post('Alt_Jet'),
				'Alt_Strattec' => $this->input->post('Alt_Strattec'),
				'Alt_Silca' => $this->input->post('Alt_Silca'),
				'Alt_Taylor' => $this->input->post('Alt_Taylor'),
				'Alt_OEM' => $this->input->post('Alt_OEM'),
				
				'Alt_Other' => $this->input->post('Alt_Other'),				
				'Replacement_blade' => $this->input->post('Replacement_blade'),
				'Key_Head_UUID' => $this->input->post('Key_Head_UUID'),
				'Key_Blade_UUID' => $this->input->post('Key_Blade_UUID'),
				'Alt_MFK' => $this->input->post('Alt_MFK')				
			);					
		}else{
			$data = array(				
				'Chip_UUID' => $this->input->post('chips'),
				'Key_Name' => $this->input->post('key_name'),
				'Key_Image' => $file_name,				
				'Key_Type_UUID' => $this->input->post('key_type'),
				'Products' => $this->input->post('products'),				
				'Alt_Ilco' => $this->input->post('Alt_Ilco'),
				'Alt_Axxess' => $this->input->post('Alt_Axxess'),
				'Alt_Hillman' => $this->input->post('Alt_Hillman'),
				'Alt_Curtis' => $this->input->post('Alt_Curtis'),
				'Alt_ESP' => $this->input->post('Alt_ESP'),
				'Alt_JMA' => $this->input->post('Alt_JMA'),
				'Alt_Jet' => $this->input->post('Alt_Jet'),
				'Alt_Strattec' => $this->input->post('Alt_Strattec'),
				'Alt_Silca' => $this->input->post('Alt_Silca'),
				'Alt_Taylor' => $this->input->post('Alt_Taylor'),
				'Alt_OEM' => $this->input->post('Alt_OEM'),				
				'Alt_Other' => $this->input->post('Alt_Other'),				
				'Replacement_blade' => $this->input->post('Replacement_blade'),
				'Key_Head_UUID' => $this->input->post('Key_Head_UUID'),
				'Key_Blade_UUID' => $this->input->post('Key_Blade_UUID'),
				'Alt_MFK' => $this->input->post('Alt_MFK')
			);
			$extra_field = 'Key_Image,';
		}
		
		$query = $this->db->query("SELECT Chip_UUID,Key_Name,".$extra_field." Key_Type_UUID,Products,Alt_Ilco,Alt_Axxess,Alt_Hillman,Alt_Curtis,Alt_ESP,Alt_JMA,Alt_Jet,Alt_Strattec,Alt_Silca,Alt_Taylor,Alt_OEM,Alt_Other,Replacement_blade,Key_Head_UUID,Key_Blade_UUID,Alt_MFK FROM t_Keys WHERE id =".$keyid."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($keyid,$old_values,$new_values,'Part> Key','t_keys_logs');		

		$this->db->where('id', $keyid);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Keys', $data);
	}
	public function delete_key($id){
		$this->db->cache_delete('admpro', 'keys');
		$this->db->where('id', $id);
		$this->db->delete('t_Keys');
	}
	public function show_keysby_types(){
		$typeUuid = $this->input->post('typeUuid');	
		if($typeUuid == 'all'){
			$query = $this->db->select("*")->order_by('Key_Name' ,'asc')->get('t_Keys');
		}else{		
			$query = $this->db->select("*")->where('Key_Type_UUID' ,$typeUuid)->get('t_Keys');
		}
		return $query->result_array();
	}
	public function show_keysby_lock_types(){
		$typeUuid = $this->input->post('typeUuid');	
		$keybytype = $this->input->post('keybytype');
		if($keybytype !="" &&  $typeUuid !=''){
			if($keybytype == 'all'){
				$query = $this->db->select("*")->where('lock_type' ,$typeUuid)->get('t_Keys');
			}else{
				$query = $query = $this->db->select("*")->where('lock_type' ,$typeUuid)->where('Key_Type_UUID',$keybytype)->get('t_Keys');
			}			
		}elseif($typeUuid == 'all'){
			$query = $this->db->select("*")->order_by('Key_Name' ,'asc')->get('t_Keys');
		}else{		
			$query = $this->db->select("*")->where('lock_type' ,$typeUuid)->get('t_Keys');
		}
		return $query->result_array();
	}
	public function search_kyes(){
		$makes_id = "";
		 $search_key = trim($this->input->post('search_key'));		
		$make_query = $query = $this->db->select("*")->like('Chip_Name' ,$search_key)->get('t_Chips');
		$make_query1 = $make_query->result_array();		
		if($make_query->num_rows() > 0){
			foreach($make_query1 as $makes){
				$makes_id .= "". $makes['UUID'].",";
			}
			$makes_id2 = rtrim($makes_id,",");
			$query = $query = $this->db->select("*")->where_in('Chip_UUID' ,explode(',',$makes_id2))->get('t_Keys');
		}else{	
			$query = $this->db->query("SELECT * FROM t_Keys WHERE Key_Name LIKE '%".$search_key."%' OR Products LIKE '%".$search_key."%'  OR Alt_Ilco LIKE '%".$search_key."%' OR Alt_Axxess LIKE '%".$search_key."%' OR Alt_Hillman LIKE '%".$search_key."%' OR Alt_Curtis LIKE '%".$search_key."%' OR Alt_ESP LIKE '%".$search_key."%' OR Alt_JMA LIKE '%".$search_key."%' OR Alt_Jet LIKE '%".$search_key."%' OR Alt_Strattec LIKE '%".$search_key."%' OR Alt_Silca LIKE '%".$search_key."%' OR Alt_Taylor LIKE '%".$search_key."%' OR Alt_OEM LIKE '%".$search_key."%' OR Alt_Other LIKE '%".$search_key."%' ");
		}
		return $query->result_array();
	}
	public function keys_sorting(){
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');	
		$keytype = $this->input->post('keytype');
		$keylocktype = $this->input->post('keylocktype');	
		$searchkey = $this->input->post('searchkey');
		if($keytype =='all' && $keylocktype == 'all'){
			$query = $this->db->select("*")->order_by($sorting_by ,$sort)->get('t_Keys');
		}else if(($keylocktype !="") && ($keytype !="")){
			$query = $this->db->select("*")->where('lock_type' ,$keylocktype)->order_by($sorting_by ,$sort)->get('t_Keys');
		}elseif(($keytype !="") && ($searchkey !="")){			
			$query = $this->db->select("*")->where('Key_Name' ,$searchkey)->order_by($sorting_by ,$sort)->get('t_Keys');
		}elseif($keytype !='all'){
			$query = $this->db->select("*")->where('Key_Type_UUID' ,$keytype)->order_by($sorting_by ,$sort)->get('t_Keys');
		}else{
			$query = $this->db->select("*")->order_by($sorting_by ,$sort)->get('t_Keys');
		}
		return $query->result_array();	
	}
	/*================================= Keys Page Editing ================================================*/
	
	public function keys_input_update(){
		$this->db->cache_delete('admpro', 'keys');
		$column_name = $this->input->post('columnName');
		foreach($_POST[$column_name] as $key => $val) {
			$data = array($column_name => $val);

			$query = $this->db->query("SELECT ".$column_name." FROM t_Keys WHERE id =".$key."");
			$old_values =  $query->first_row();
			$old_values = json_decode(json_encode($old_values), true);
			$new_values = $data;
			$add_activity_log = add_activity_log($key,$old_values,$new_values,'Part> Key','t_keys_logs');	

			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Keys', $data);
		}			
		if(isset($val)){
			if($column_name == 'Key_Image'){
				return '<img class="customImage" src ="'.aks_img_url().$val.' ">';
			}else{
				return $val;
			}
		}else{
			return '';
		}
	}
	
	public function keys_dropbox_update(){
		$this->db->cache_delete('admpro', 'keys');
		$columnName = $this->input->post('columnName');
		$tableName = $this->input->post('tableName');
		$tableColName = $this->input->post('tableColName');
		foreach($_POST[$columnName] as $key => $val) {
			$data = array($columnName => $val);

			$query = $this->db->query("SELECT ".$columnName." FROM t_Keys WHERE id =".$key."");
			$old_values =  $query->first_row();
			$old_values = json_decode(json_encode($old_values), true);
			$new_values = $data;
			$add_activity_log = add_activity_log($key,$old_values,$new_values,'Part> Key','t_keys_logs');

			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Keys', $data);
		}
		$query = $this->db->query("SELECT * FROM ".$tableName." WHERE UUID = ? " ,array($val));
		$return = $query->result_array();
		if(isset($return[0][$tableColName])){
			return $return[0][$tableColName];
		}else{
			return '';
		}
	}
	
	public function getAllkeyBlade(){
		$query = $this->db->select("*")->order_by('Key_Blade_name','DESC')->get('t_key_blade');
		return $query->result_array();
	}
	public function getAllkeyHead(){
		$query = $this->db->select("*")->order_by('key_Head_Name','DESC')->get('t_key_head');
		return $query->result_array();
	}
	
/*--------------------------------------- Chip Module-------------------------------------*/
	public function getAllChipsRows(){
  		return $this->db->count_all("t_Chips");	
	}
	public function getAllChipsByFilter($chip_value){
		$chip = $chip_value;	
		if($chip == 2){	
			$query = $this->db->select("*")->where('CloningChip' ,1)->get('t_Chips');
		}else if($chip == 1){	
			$query = $this->db->select("*")->where('CloningChip' ,0)->get('t_Chips');
		}else{
			$query = $this->db->select("*")->order_by('Chip_Name' ,'asc')->get('t_Chips');
		}
		return $query->result_array();
	}
	public function getAllChipsDetail($limit,$limt_start){
		$query = $this->db->select("*")->order_by('Chip_Name','asc')->limit($limit,$limt_start)->get('t_Chips');
		return $query->result_array();
	}
	public function ChipsAdd($file_name){
		$this->db->cache_delete('admpro', 'Chips');
		$name = $this->input->post('name');		
		$cloneable = $this->input->post('cloneable');
		$reusable = $this->input->post('reusable');
		$cloning_chip = $this->input->post('cloning_chip');
		$products= $this->input->post('products');
		$products= $this->input->post('products');
		$Clone_With = $this->input->post('Clone_With');
		$clone_With_data = "";
		if( $this->input->post('Clone_With') != ""){
			foreach($Clone_With  as $clone_with){
			     $clone_With_data .= $clone_with.',';
			}			 
		}
		$clone_With_data2 = rtrim($clone_With_data,",");
		
		$Cloning_Machine = $this->input->post('Cloning_Machine');
		$Cloning_Machine_data = "";
		if( $this->input->post('Cloning_Machine') != ""){
			foreach($Cloning_Machine  as $clone_with1){
			     $Cloning_Machine_data .= $clone_with1.',';
			}			 
		}
		$Cloning_Machine_data2 = rtrim($Cloning_Machine_data,",");
		
		$data = array(
				'Chip_Name' => $this->input->post('name'),
				'Chip_Image_Url' => trim($file_name),
				'Clonable' => $this->input->post('cloneable'),
				'Reusable' => $this->input->post('reusable'),				
				'Products' => $this->input->post('products'),
				'UUID' => md5(uniqid(mt_rand(), true)),				
				
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('t_Chips', $data);
		return true;
		
	}
	public function getallChipsInfo($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_Chips');
		return $query->result_array();
	}
	public function Update_ChipsEdit($file_name){
		$this->db->cache_delete('admpro', 'Chips');
		$chipsId = $this->input->post('chipsid');
		$Clone_With = $this->input->post('Clone_With');
		$clone_With_data = "";
		if( $this->input->post('Clone_With') != ""){
			foreach($Clone_With  as $clone_with){
			     $clone_With_data .= $clone_with.',';
			}			 
		}
		$clone_With_data2 = rtrim($clone_With_data,",");
		
		$Cloning_Machine = $this->input->post('Cloning_Machine');
		$Cloning_Machine_data = "";
		if( $this->input->post('Cloning_Machine') != ""){
			foreach($Cloning_Machine  as $clone_with1){
			     $Cloning_Machine_data .= $clone_with1.',';
			}			 
		}
		$Cloning_Machine_data2 = rtrim($Cloning_Machine_data,",");
		$extra_field = '';
		if($file_name == ""){
			$data = array(
				'Chip_Name' => $this->input->post('name'),					
				'Clonable' => $this->input->post('cloneable'),
				'Reusable' => $this->input->post('reusable'),					
				'Products' => $this->input->post('Products')
			);
		}else{
			$data = array(
				'Chip_Name' => $this->input->post('name'),
				'Chip_Image_Url' => trim($file_name),
				'Clonable' => $this->input->post('cloneable'),
				'Reusable' => $this->input->post('reusable'),				
				'Products' => $this->input->post('Products')
			);
			$extra_field = 'Chip_Image_Url,';
		}

		$query = $this->db->query("SELECT Chip_Name,".$extra_field." Clonable,Reusable,Products FROM t_Chips WHERE id =".$chipsId."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($chipsId,$old_values,$new_values,'Part> Chips','t_chips_logs');	

		$this->db->where('id', $chipsId);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Chips', $data);
		return true;
	}
	public function Deletechips($id){
		$this->db->cache_delete('admpro', 'Chips');
		$this->db->where('id', $id);
		$this->db->delete('t_Chips'); 
	}
	public function show_chips_filter(){
		$chip = $this->input->post('chip');	
		if($chip == 2){	
			$query = $this->db->select("*")->where('CloningChip' ,1)->get('t_Chips');
		}else if($chip == 1){	
			$query = $this->db->select("*")->where('CloningChip' ,0)->get('t_Chips');
		}else{
			$query = $this->db->select("*")->order_by('Chip_Name' ,'asc')->get('t_Chips');
		}
		return $query->result_array();
	}
	public function search_chips(){
		$search_key = trim($this->input->post('search_global_key'));	
		$query = $this->db->query("SELECT * FROM t_Chips WHERE Chip_Name LIKE '%".$search_key."%' OR Products LIKE '%".$search_key."%' OR Cloning_type LIKE '%".$search_key."%'");
		return $query->result_array();
	}
	public function chips_sorting(){
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');			
		$query = $this->db->select("*")->order_by($sorting_by ,$sort)->get('t_Chips');
		return $query->result_array();	
	}
	
	/*=============================== Page Editing Functions ===============================================*/
	
	public function chips_input_update(){
		$this->db->cache_delete('admpro', 'Chips');
		$column_name = $this->input->post('columnName');
		$dataTable = $this->input->post('dataTable');
		$image = $this->input->post('image');
		foreach($_POST[$column_name] as $key => $val) {
			$data = array($column_name => $val);

			if($dataTable == 't_Makes'){
				$query = $this->db->query("SELECT Make_Name FROM t_Makes WHERE id =".$key."");
				$old_values =  $query->first_row();
				$old_values = json_decode(json_encode($old_values), true);
				$new_values = $data;
				$add_activity_log = add_activity_log($key,$old_values,$new_values,'Make','t_make_logs');		
			}
			if($dataTable == 't_Chips'){
				$query = $this->db->query("SELECT Chip_Name FROM t_Chips WHERE id =".$key."");
				$old_values =  $query->first_row();
				$old_values = json_decode(json_encode($old_values), true);
				$new_values = $data;
				$add_activity_log = add_activity_log($key,$old_values,$new_values,'Part> Chips','t_chips_logs');		
			}
			if($dataTable == 't_Key_Types'){
				$query = $this->db->query("SELECT Key_Type_Name FROM t_Key_Types WHERE id =".$key."");
				$old_values =  $query->first_row();
				$old_values = json_decode(json_encode($old_values), true);
				$new_values = $data;
				$add_activity_log = add_activity_log($key,$old_values,$new_values,'Part> Key Type','t_key_types_logs');
			}

			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update($dataTable, $data);
		}			
		if(isset($val)){
			if($column_name == $image){
				return '<img class="customImage" src ="'.aks_img_url().$val.' ">';
			}elseif(($column_name == 'Clonable') || ( $column_name == 'Reusable') || ( $column_name == 'CloningChip')){
				if($val == 1){
					return 'Yes';
				}elseif($val == 0){
					return 'No';
				}
			}else{
					return $val;
			}
		}else{
			return '';
		}
	}
	
	public function table_dropbox_update(){
		$this->db->cache_delete('admpro', 'Chips');
		$columnName = $this->input->post('columnName');
		$tableName = $this->input->post('tableName');
		$tableColName = $this->input->post('tableColName');
		$dataTable = $this->input->post('dataTable');		
		foreach($_POST[$columnName] as $key => $val) {
			$data = array($columnName => $val);
			$this->db->where('id', $key);
			$data = $this->security->xss_clean($data);
			$this->db->update($dataTable, $data);
		}
		$query = $this->db->query("SELECT * FROM ".$tableName." WHERE UUID = ? ", array($val));
		$return = $query->result_array();
		if(isset($return[0][$tableColName])){
			return $return[0][$tableColName];
		}else{
			return '';
		}
	}
	public function vh_dropbox_update(){
		$this->db->cache_delete('admpro', 'vehicles');
		$columnName = $this->input->post('columnName');
		$tableName = $this->input->post('tableName');
		$tableColName = $this->input->post('tableColName');
		if($columnName == 'Code_Series_UUID'){
			//print_r($_POST['Code_Series_UUID']);
			$series_val = "";
			foreach( $_POST['Code_Series_UUID'] as $key_id => $series){
				$series_val .= $series.',';	
			}	
			$series_val1 = rtrim($series_val,',');		
			$data = array($columnName => $series_val1);

			$id = $this->input->post('vehicle_id');
			$query = $this->db->query("SELECT ".$columnName." FROM t_Vehicles WHERE id =".$id."");
			$old_values =  $query->first_row();
			$old_values = json_decode(json_encode($old_values), true);
			$new_values = $data;
			$add_activity_log = add_activity_log($id,$old_values,$new_values,'Vehicle','t_vehicles_logs');


			$this->db->where('id', $this->input->post('vehicle_id'));
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Vehicles', $data);
			$got_series_data = explode(',',$series_val1);
			for( $cs = 0; $cs <= count($got_series_data); $cs++ ){
				$got_series_val = explode('|',$got_series_data[$cs]);
				$code_series_id = $got_series_val[0];
				$code_series_note = $got_series_val[1];
				$get_Code_Series_name = get_Code_Series_name($code_series_id);
				if($code_series_note !=""){
					echo $get_Code_Series_name[0]['Code_Series_Name'].' ('.$code_series_note.')<br>';
				}else{
					echo $get_Code_Series_name[0]['Code_Series_Name'].'<br>';
				}				
			}		
		}else{		
			foreach($_POST[$columnName] as $key => $val) {
				$data = array($columnName => $val);

				$id = $key;
				$query = $this->db->query("SELECT ".$columnName." FROM t_Vehicles WHERE id =".$id."");
				$old_values =  $query->first_row();
				$old_values = json_decode(json_encode($old_values), true);
				$new_values = $data;
				$add_activity_log = add_activity_log($id,$old_values,$new_values,'Vehicle','t_vehicles_logs');

				$this->db->where('id', $key);
				$data = $this->security->xss_clean($data);
				$this->db->update('t_Vehicles', $data);
			}
			$query = $this->db->query("SELECT * FROM ".$tableName." WHERE UUID =? ",array($val));
			$return = $query->result_array();
			if(isset($return[0][$tableColName])){
				return $return[0][$tableColName];
			}else{
				return '';
			}
		}
	}
/*--------------------------------------- Key Blade Module-------------------------------------*/
	public function getAllKeyBladeRows(){
  		return $this->db->count_all("t_key_blade");	
	}
	public function getAllKeyBladeDetail($limit,$limt_start){
		$query = $this->db->select("*")->order_by('Key_Blade_name','asc')->limit($limit,$limt_start)->get('t_key_blade');
		return $query->result_array();
	}
	public function save_key_blade($file_name){		
		$data = array(
			'Key_Blade_name' => $this->input->post('Key_Blade_name'),
			'Key_Blade_Image_url' => trim($file_name),			
			'Key_Blade_dec' => $this->input->post('Key_Blade_dec'),
			'UUID' => md5(uniqid(mt_rand(), true)),
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('t_key_blade', $data);
		return true;
	}
	public function getallKeysBladeInfo($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_key_blade');
		return $query->result_array();
	}
	public function update_key_blade($file_name,$id){
		$extra_field = '';
		if($file_name !=""){
			$data = array(
				'Key_Blade_name' => $this->input->post('Key_Blade_name'),
				'Key_Blade_Image_url' => trim($file_name),			
				'Key_Blade_dec' => $this->input->post('Key_Blade_dec'),
				'UUID' => md5(uniqid(mt_rand(), true)),
			);
			$extra_field = "Key_Blade_Image_url,";
		}else{
			$data = array(
				'Key_Blade_name' => $this->input->post('Key_Blade_name'),						
				'Key_Blade_dec' => $this->input->post('Key_Blade_dec'),
				'UUID' => md5(uniqid(mt_rand(), true))
			);
		}

		$query = $this->db->query("SELECT Key_Blade_name,".$extra_field." Key_Blade_dec FROM t_key_blade WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Part> Key Blade','t_key_blade_logs');


		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_key_blade', $data);
		return true;
	}
	public function deletekeyblade($id){		
		$this->db->where('id', $id);
		$this->db->delete('t_key_blade'); 
	}
/*-------------------------------------- key Head-----------------------*/
	public function getAllKeyHeadRows(){
		return $this->db->count_all("t_key_head");	
	}
	public function getAllKeyHeadDetail($limit,$limt_start){
		$query = $this->db->select("*")->order_by('key_Head_Name','asc')->limit($limit,$limt_start)->get('t_key_head');
		return $query->result_array();
	}
	public function save_key_head($file_name){
		$data = array(
			'key_Head_Name' => $this->input->post('key_Head_Name'),
			'Key_Head_Image_url' => trim($file_name),			
			'key_Head_Dec' => $this->input->post('key_Head_Dec'),
			'UUID' => md5(uniqid(mt_rand(), true)),
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('t_key_head', $data);
		return true;
	}
	public function getallKeysHeadInfo($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_key_head');
		return $query->result_array();
	}
	public function update_key_Head($file_name,$id){
		$extra_field = '';
		if($file_name !=""){
			$data = array(
				'key_Head_Name' => $this->input->post('key_Head_Name'),
				'Key_Head_Image_url' => trim($file_name),			
				'key_Head_Dec' => $this->input->post('key_Head_Dec'),
				'UUID' => md5(uniqid(mt_rand(), true)),
			);
			$extra_field = 'Key_Head_Image_url,';
		}else{
			$data = array(
				'key_Head_Name' => $this->input->post('key_Head_Name'),					
				'key_Head_Dec' => $this->input->post('key_Head_Dec'),
				'UUID' => md5(uniqid(mt_rand(), true)),
			);
		}

		$query = $this->db->query("SELECT key_Head_Name,".$extra_field." key_Head_Dec FROM t_key_head WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Part> Key Head','t_key_head_logs');

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_key_head', $data);
		return true;
	}
	public function deletekeyhead($id){
		$this->db->where('id', $id);
		$this->db->delete('t_key_head'); 
		return true;
	}
/*---------------------------------------------Key Type---------------------------------------*/
	public function getAllkeyType(){
		$query = $this->db->select("*")->order_by('Key_Type_Name','asc')->get('t_Key_Types');
		return $query->result_array();
	}
	public function keyTypeAdd(){
		$this->db->cache_delete('admpro', 'keyType');
		$name = $this->input->post('name');
		$data = array(
				'Key_Type_Name' => $this->input->post('name'),
				'UUID' => md5(uniqid(mt_rand(), true))
		);		
		$query = $this->db->select("Key_Type_Name")->where('Key_Type_Name',$name)->get('t_Key_Types');		
		if($query->num_rows() > 0){
			$this->session->set_flashdata('message_display', ' key type already exits.');	
			return false;				
		}else{
			$data = $this->security->xss_clean($data);
			$this->db->insert('t_Key_Types', $data);
			return true;		
		}
	}
	public function getKeyTypeInfo($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('t_Key_Types');
		return $query->result_array();
	}
	public function update_keytype(){
		$this->db->cache_delete('admpro', 'keyType');
		$keytypeId = $this->input->post('keyId');
		$key_type =	$this->input->post('keystyle');
		$data = array(
			'Key_Type_Name' => $this->input->post('keystyle')
		);
		
		$query = $this->db->query("SELECT Key_Type_Name FROM t_Key_Types WHERE id =".$keytypeId."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($keytypeId,$old_values,$new_values,'Part> Key Type','t_key_types_logs');
		
		$query = $this->db->select("Key_Type_Name")->where('Key_Type_Name',$key_type)->get('t_Key_Types');		
		if($query->num_rows() > 0){
			return false;	
		}else{			
			$this->db->where('id', $keytypeId);
			$data = $this->security->xss_clean($data);
			$this->db->update('t_Key_Types', $data);
			return true;
		}
	}
	public function deletetypekey($id){
		$this->db->cache_delete('admpro', 'keyType');
		$this->db->where('id', $id);
		$this->db->delete('t_Key_Types'); 
	}
	public function key_type_sorting(){
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');		
		$query = $this->db->select("*")->order_by($sorting_by,$sort)->get('t_Key_Types');
		return $query->result_array();
	}
	public function getRetainers(){
		$query = $this->db->select("*")->order_by('Retainer_Name','asc')->get('t_Retainers');
		return $query->result_array();
	}
		public function vh_multiple_dropbox_update(){
		$this->db->cache_delete('admpro', 'vehicles');
		$id = $this->input->post('id');
		$columnName =  $this->input->post('columnName');
		$type =  $this->input->post('type');
		$machanical_keys_val  = "";	
		if( isset($_POST[$columnName])){
			foreach( $_POST[$columnName] as $machanical_keys){
				$machanical_keys_val .= $machanical_keys.',';
			}
		}
		$machanical_keys_val1 = rtrim($machanical_keys_val,',');
		$data = array($columnName => $machanical_keys_val1);

		$id = $id;
		$query = $this->db->query("SELECT ".$columnName." FROM t_Vehicles WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Vehicle','t_vehicles_logs');

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Vehicles', $data);
		$mach_keys_uuids = "";
		if($type == 'Keys'){						
			$mach_keys_array = explode(',',$machanical_keys_val1);
			for($i = 0; $i < count($mach_keys_array); $i++ ){
				$value = $mach_keys_array[$i];
				$query2 = $this->db->query("SELECT * FROM t_Keys WHERE UUID = ?  ORDER BY Key_Name",array($value)); 
				$return = $query2->result_array();
				$mach_keys_uuids .=  $return[0]['Key_Name'].'<br>';
			}
		}else if($type == 'Remotes'){
			$mach_keys_uuids = "";								
			$mach_keys_array = explode(',',$machanical_keys_val1);
			for($i = 0; $i < count($mach_keys_array); $i++ ){
				$value = $mach_keys_array[$i];
				$query2 = $this->db->query("SELECT * FROM t_Remotes WHERE UUID = ? ORDER BY Remote_Name" ,array($value)); 
				$return = $query2->result_array();
				$mach_keys_uuids .=  $return[0]['Remote_Name'].'<br>';
			}
		}			
		return $mach_keys_uuids;
	}
	public function vh_programmers_dropbox_update(){
		$this->db->cache_delete('admpro', 'vehicles');
		$id = $this->input->post('id');
		$machanical_keys_val  = "";	
		if( isset($_POST['Mechanical_Key_UUID'])){
			foreach( $_POST['Mechanical_Key_UUID'] as $machanical_keys){
				$machanical_keys_val .= $machanical_keys.',';
			}
		}
		$machanical_keys_val1 = rtrim($machanical_keys_val,',');
		$data = array('Mechanical_Key_UUID' => $machanical_keys_val1);

		$id = $id;
		$query = $this->db->query("SELECT Mechanical_Key_UUID FROM t_Vehicles WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Vehicle','t_vehicles_logs');

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('t_Vehicles', $data);
		$mach_keys_uuids = "";								
		$mach_keys_array = explode(',',$machanical_keys_val1);
		for($i = 0; $i < count($mach_keys_array); $i++ ){
			$value_uuid = $mach_keys_array[$i];
			$get_key_name = $this->db->query("SELECT * FROM t_Keys WHERE UUID = ? ",array($value_uuid));//get_key_name($mach_keys_array[$i]);
			$return = $get_key_name->result_array();
			$mach_keys_uuids .=  $return[0]['Key_Name'].'<br>';
		}		
		return $mach_keys_uuids;
	} 

	public function function_tables(){
		$result = $this->db->query("SHOW TABLES LIKE '%ServerFunc%'");
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}else {
			return array();
		}
	}

	public function check_if_tble_exists($table_name){
		$result = $this->db->query("SHOW TABLES LIKE '".$table_name."'");
		if ($result->num_rows() > 0) {
			return 'true';
		}else {
			return 'false';
		}
	}

	public function create_import_table($table_name, $fields){
		$sql = $this->db->query("CREATE TABLE $table_name (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY," . implode(', ', $fields) . ')');
		
	}
	public function empty_import_table($table_name){
		$this->db->empty_table($table_name);
	}

	public function insert_table_data($table_name,$data,$fields_name){
		$sql = $this->db->query("INSERT INTO $table_name ($fields_name) values($data)");
	}

	public function getAllVehiclesDataCSV(){
		$query = $this->db->query("SELECT t_Vehicles.id,t_Makes.Make_Name,t_Models.Model_Name,t_Vehicles.Years,t_Vehicles.Generation_YearRange ,t_Vehicles.Generation_Name,t_Vehicles.Mechanical_Key_UUID,t_Vehicles.Chip_Key_UUID,t_Vehicles.Keyed_Ignition,t_Vehicles.Keyed_IgnitionYear,t_Vehicles.Push_Start,t_Vehicles.Push_StartYear,t_Vehicles.Key_ProgrammingReserved,t_Vehicles.Vehicle_System,t_Vehicles.APP_Youtube_Title,t_Vehicles.APP_Youtube_URL,t_Vehicles.APP_System,t_Vehicles.APP_Add_Keys,t_Vehicles.APP_All_Keys_Lost,t_Vehicles.APP_Confirmed_Working,t_Vehicles.Vehicle_Type,t_Vehicles.APP_Programs_Remote,t_Vehicles.APP_Resync_Available,t_Vehicles.PIN_Read,t_Vehicles.Key_Blade,t_Vehicles.Transponder_Chip,t_Vehicles.APP_Notes FROM t_Makes JOIN  t_Models ON t_Makes.UUID = t_Models.Make_UUID JOIN t_Vehicles ON  t_Models.UUID = t_Vehicles.Model_UUID ORDER BY t_Vehicles.id");
		return $query->result_array();
	}
	public function export_all_product_info_table(){
		$query = $this->db->select("*")->order_by('id' ,'asc')->get('product_vehicle_info');
		return $query->result_array();
	}
	public function import_product_info_to_database(){
		 $file_data = $this->csvimport->get_array($_FILES["import_csv_file"]["tmp_name"]);		 
		 if( $file_data !=""){
			$data =  array();	
			$count = 0;		  
			foreach($file_data as $value){
				if($value['Make'] !="" &&  $value['Model'] !="" &&  $value['Year'] !=""){
					$id =  $value['id'];									
					$Product_id="";
					if($value['Product_id'] !=""){				
						$Product_id = ",Product_id='".trim($value['Product_id'])."' ";
					}							
					$query.$count = "UPDATE product_vehicle_info SET 
									Make='".$value['Make']."' ,
									Model='".$value['Model']."' ,
									Year='".$value['Year']."' 								
									".$Product_id."								
									WHERE id='".(int)$value['id']."'";	
					$this->db->query($query.$count);
					$produt_query = $this->db->query("SELECT Make FROM product_vehicle_info WHERE id ='".(int)$value['id']."'");
					if($produt_query->num_rows() > 0 ){}else{
						$Make =  $value['Make'];
						$Model =  $value['Model'];
						$Year =  $value['Year'];
						$Product_id =  $value['Product_id'];						
						$query2 =	"INSERT INTO product_vehicle_info (Make,Model, Year, Product_id)
						VALUES ('$Make','$Model','$Year','$Product_id')";
						$this->db->query($query2);						
					}
					$count++;	
				}else{
					return 0;
				}				
			}
			return 1;
		}else{
			return 0;
		}
		
	}
	public function export_all_product_detail_table(){
		$query = $this->db->select("*")->order_by('id' ,'asc')->get('product_detail');
		return $query->result_array();
	}
	public function import_product_detail_to_database(){
		 $file_data = $this->csvimport->get_array($_FILES["prod_detail_import_csv_file"]["tmp_name"]);		 
		 if( $file_data !=""){
			$data =  array();	
			$count = 0;		  
			foreach($file_data as $value){
				if(isset($value['Product_SKU']) || isset($value['Product_Title']) || isset($value['Image'])){				
					$id =  $value['id'];									
					$Product_id="";
					if($value['Product_id'] !=""){				
						$Product_id = ",Product_id='".trim($value['Product_id'])."' ";
					}							
					$query.$count = "UPDATE product_detail SET 
									Product_SKU='".$value['Product_SKU']."' ,
									Product_Title='".$value['Product_Title']."' ,
									Product_Tags='".$value['Product_Tags']."',
									Image='".$value['Image']."'	
									".$Product_id."								
									WHERE id='".(int)$value['id']."'";	
					$this->db->query($query.$count);
					$produt_query = $this->db->query("SELECT Product_id FROM product_detail WHERE id ='".(int)$value['id']."'");
					if($produt_query->num_rows() > 0 ){}else{
						$product_id =  $value['Product_id'];
						$Product_SKU =  $value['Product_SKU'];
						$Product_Title =  $value['Product_Title'];
						$Product_Tags =  $value['Product_Tags'];
						$Image =  $value['Image'];
						$query2 =	"INSERT INTO product_detail (Product_id,Product_SKU, Product_Title, Product_Tags,Image)
						VALUES ('$product_id','$Product_SKU','$Product_Title','$Product_Tags','$Image')";
						$this->db->query($query2);						
					}
					
					$count++;
				}else{
					return 0;
				}				
			}
			return 1;
		}else{
			return 0;
		}		
	}
/*------------------------------------Machanical Keys -------------------------------------------*/
	public function machanical_keys(){
		$query = $this->db->select("*")->order_by('id' ,'asc')->get('mechanical_key_information');
		return $query->result_array();
	}	

	public function save_machanical_keys($file_name){
		$data = array(
			'name' => $this->input->post('name'),
			'code_series' => $this->input->post('code_series'),			
			'depth' => $this->input->post('depth'),
			'ignition' => $this->input->post('ignition'),
			'macs' => $this->input->post('macs'),
			'spaces' => $this->input->post('spaces'),
			'reserved' => $this->input->post('reserved'),
			'image' => $file_name
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('mechanical_key_information', $data);
		return true;
	}
	public function machanical_keys_info($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('mechanical_key_information');
		return $query->result_array();
	}
	public function update_machanical_keys($id,$file_name){
		$data = array(
			'name' => $this->input->post('name'),
			'code_series' => $this->input->post('code_series'),			
			'depth' => $this->input->post('depth'),
			'ignition' => $this->input->post('ignition'),
			'macs' => $this->input->post('macs'),
			'spaces' => $this->input->post('spaces'),
			'reserved' => $this->input->post('reserved'),
			'image' => $file_name
		);

		$query = $this->db->query("SELECT `name`,code_series,depth,ignition,macs,spaces,reserved,image FROM mechanical_key_information WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Machanical Keys','mechanical_key_information_logs');	

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('mechanical_key_information', $data);
		return true;
	}
	public function delete_machanical_keys($id){
		$this->db->where('id', $id);
		$this->db->delete('mechanical_key_information'); 
		return true;
	}

/*------------------------------------Transponder Keys -------------------------------------------*/
	public function transponder_keys(){
		$query = $this->db->select("*")->order_by('id' ,'asc')->get('transponder_key_information');
		return $query->result_array();
	}	

	public function save_transponder_keys($file_name){
		$data = array(
			'name' => $this->input->post('name'),
			'chip' => $this->input->post('chip'),			
			'reuseable' => $this->input->post('reuseable'),
			'cloneable' => $this->input->post('cloneable'),
			'reserved' => $this->input->post('reserved'),
			'test_blade' => $this->input->post('test_blade'),
			'image' => $file_name
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('transponder_key_information', $data);
		return true;
	}
	public function transponder_keys_info($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('transponder_key_information');
		return $query->result_array();
	}
	public function update_transponder_keys($id,$file_name){
		$data = array(
			'name' => $this->input->post('name'),
			'chip' => $this->input->post('chip'),			
			'reuseable' => $this->input->post('reuseable'),
			'cloneable' => $this->input->post('cloneable'),
			'reserved' => $this->input->post('reserved'),
			'test_blade' => $this->input->post('test_blade'),
			'image' => $file_name
		);

		$query = $this->db->query("SELECT `name`,chip,reuseable,cloneable,reserved,test_blade,image FROM transponder_key_information WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Transponder Keys','transponder_key_information_logs');	

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('transponder_key_information', $data);
		return true;
	}
	public function delete_transponder_keys($id){
		$this->db->where('id', $id);
		$this->db->delete('transponder_key_information'); 
		return true;
	}

/*------------------------------------Programmer Info -------------------------------------------*/
	public function programmer_information(){
		$query = $this->db->select("*")->order_by('id' ,'asc')->get('programmer_information');
		return $query->result_array();
	}	

	public function save_programmer_information(){
		$data = array(
			'make' => $this->input->post('make'),
			'model' => $this->input->post('model'),			
			'year' => $this->input->post('year'),
			'LITE' => $this->input->post('LITE'),
			'FULL' => $this->input->post('FULL'),
			'BASIC' => $this->input->post('BASIC'),
			'G2' => $this->input->post('G2'),
			'G2T' => $this->input->post('G2T'),
			'CORE' => $this->input->post('CORE'),
			'EVOLUTION' => $this->input->post('EVOLUTION'),
			'PRIME' => $this->input->post('PRIME'),
			'RESERVED' => $this->input->post('RESERVED'),
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('programmer_information', $data);
		return true;
	}
	public function programmer_information_info($id){
		$query = $this->db->select("*")->where('id',(int)$id)->get('programmer_information');
		return $query->result_array();
	}
	public function update_programmer_information($id){
		$data = array(
			'make' => $this->input->post('make'),
			'model' => $this->input->post('model'),			
			'year' => $this->input->post('year'),
			'LITE' => $this->input->post('LITE'),
			'FULL' => $this->input->post('FULL'),
			'BASIC' => $this->input->post('BASIC'),
			'G2' => $this->input->post('G2'),
			'G2T' => $this->input->post('G2T'),
			'CORE' => $this->input->post('CORE'),
			'EVOLUTION' => $this->input->post('EVOLUTION'),
			'PRIME' => $this->input->post('PRIME'),
			'RESERVED' => $this->input->post('RESERVED'),
		);

		$query = $this->db->query("SELECT make,model,`year`,LITE,FULL,`BASIC`,G2,G2T,CORE,EVOLUTION,PRIME,RESERVED FROM programmer_information WHERE id =".$id."");
		$old_values =  $query->first_row();
		$old_values = json_decode(json_encode($old_values), true);
		$new_values = $data;
		$add_activity_log = add_activity_log($id,$old_values,$new_values,'Programmer Info','programmer_information_logs');	

		$this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('programmer_information', $data);
		return true;
	}
	public function delete_programmer_information($id){
		$this->db->where('id', $id);
		$this->db->delete('programmer_information'); 
		return true;
	}


	public function bulletin_board_data(){
		$query = $this->db->select("*")->where('id',1)->get('bulletin_board');
		return $query->result_array();
	}
	public function save_bulletin_board(){
		$start_date = $_POST['sdate'];
		$start_date_column =  key($start_date);
		$start_date_val = $start_date[$start_date_column];

		$end_date = $_POST['edate'];
		$end_date_column =  key($end_date);
		$end_date_val = $end_date[$end_date_column];

		$mesg = $_POST['mesg'];
		$mesg_column =  key($mesg);
		$mesg_val = $mesg[$mesg_column];
		
		$data = array(
			$start_date_column => date('Y-m-d', strtotime($start_date_val)),
			$end_date_column => date('Y-m-d', strtotime($end_date_val)),
			$mesg_column => $mesg_val,
		);
		$id = 1;

		$this->db->where('id',$id);
		$q = $this->db->get('bulletin_board');
		if ( $q->num_rows() > 0 ){
			$this->db->where('id',$id);
			$this->db->update('bulletin_board',$data);
		} else {
			$this->db->set('id', $id);
			$this->db->insert('bulletin_board',$data);
		}
	}

	
/*------------------------------------- Admins ------------------------------------*/	
	public function admins(){
		$query = $this->db->select("*")->order_by('UserID' ,'desc')->get('admin');
		return $query->result_array();
	}	

	public function save_admins(){
		$data = array(
			'user_name' => $this->input->post('user_name'),
			'type' => $this->input->post('type'),			
			'email' => $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'Company' => $this->input->post('Company'),
			'pages_access' => json_encode($this->input->post('pages_access')),
			'APP_switcher' => 1
		);
		$data = $this->security->xss_clean($data);	
		$this->db->insert('admin', $data);
		return true;
	}
	public function admins_info($id){
		$query = $this->db->select("*")->where('UserID',(int)$id)->get('admin');
		return $query->result_array();
	}
	public function update_admins($id){
		if($this->input->post('password') !=""){
			$data = array(
				'user_name' => $this->input->post('user_name'),
				'type' => $this->input->post('type'),			
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'Company' => $this->input->post('Company'),
				'pages_access' => json_encode($this->input->post('pages_access')),
			);
		}else{
			$data = array(
				'user_name' => $this->input->post('user_name'),
				'type' => $this->input->post('type'),			
				'email' => $this->input->post('email'),
				'Company' => $this->input->post('Company'),
				'pages_access' => json_encode($this->input->post('pages_access')),
			);
		}
		$this->db->where('UserID', $id);
		$data = $this->security->xss_clean($data);
		$this->db->update('admin', $data);
		return true;
	}
	public function delete_admins($id){
		$this->db->where('UserID', $id);
		$this->db->delete('admin'); 
		return true;
	}

	public function insert_batch_update($table_name,$data) {
        //$this->db->insert_batch($table_name,$data, true);
		foreach ($data as $row) {
            $this->db->replace($table_name, $row);
        }
    }

	public function activity_logs($table){
		//echo $table;
		$query = $this->db->select("*")->order_by('id' ,'desc')->get($table);
		return $query->result_array();
	}


	public function import_vehicles_info($table_name,$data) {
        //$this->db->insert_batch($table_name,$data, true);
		foreach ($data as $row) {
			$vid = $row['id'];
			if($vid > 0){
			$make = $row['Make_Name'];
			$query_make = $this->db->query("SELECT * FROM t_Makes WHERE Make_Name = '$make' ");
			$query_make_data = $query_make->result_array();
			$make_uuid = $query_make_data[0]['UUID'];

			$Model_Name = $row['Model_Name'];
			$query_model = $this->db->query("SELECT * FROM t_Models WHERE Make_UUID = '$make_uuid' AND Model_Name ='$Model_Name' ");
			$query_model_data = $query_model->result_array();
			$model_uuid = $query_model_data[0]['UUID'];

			$mach_keys_uuids = "";	
									
			$mach_keys_array = explode(',',$row['Mechanical_Key_UUID']);
			
			for($i = 0; $i < count($mach_keys_array); $i++ ){
				$value_uuid = trim($mach_keys_array[$i]);
				$get_key_name = $this->db->query("SELECT * FROM t_Keys WHERE Key_Name = '$value_uuid'");
				$get_key_name_d = $get_key_name->result_array();
				$mach_keys_uuids .=  $get_key_name_d[0]['UUID'].',';
			}
			$row['Mechanical_Key_UUID'] = rtrim($mach_keys_uuids,',');

			$chip_keys_uuids = "";								
			$chip_keys_array = explode(',',$row['Chip_Key_UUID']);
			for($i = 0; $i < count($chip_keys_array); $i++ ){
				$value_uuid = trim($chip_keys_array[$i]);
				$get_key_name1 = $this->db->query("SELECT * FROM t_Keys WHERE Key_Name = '$value_uuid'");
				$get_key_name_d = $get_key_name1->result_array();
				$chip_keys_uuids .=  $get_key_name_d[0]['UUID'].',';
			}
			$row['Chip_Key_UUID'] = rtrim($chip_keys_uuids,',');			

			$row['Model_UUID'] = $model_uuid;

			unset($row['Make_Name']);
			unset($row['Model_Name']);
			
			
			//echo "SELECT id FROM t_Vehicles WHERE id = ".$vid."";
			
			$id_exist = $this->db->query("SELECT id FROM t_Vehicles WHERE id = ".$vid."");
			//echo $id_exist->num_rows();
			
			
			if($id_exist->num_rows() > 0){	
				unset($row['id']);			
				// echo '<pre>';
				// print_r($row);
				// echo '<br><br>';
				$this->db->where('id', $vid);
				$this->db->update($table_name, $row);
			}else{
				// echo 'ELSE<pre>';
				// print_r($row);
				// echo '<br><br>';
				$row['UUID'] = time();
				$this->db->set('id', $vid);
            	$this->db->insert($table_name, $row);				
			}
						
        }
	}
		//die();
		
    }
}				
?>