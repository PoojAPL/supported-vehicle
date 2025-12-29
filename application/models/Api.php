<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('user_helper'));
        //load database library
        $this->load->database();
        //$this->admin_db = $this->load->database('dev_db', true);
    }

    public function getMakes(){
        $sql = "SELECT mk.Make_Name as name,mk.id,mk.UUID FROM t_Makes as mk JOIN t_Models md ON mk.UUID = md.Make_UUID JOIN t_Vehicles vh ON md.UUID = vh.Model_UUID ORDER BY mk.Make_Name";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
             $array_unique = array_unique($result->result_array(), SORT_REGULAR);
             $res[] = $array_unique;
        } else {
            $res['error'] = true;
            $res['message'] = 'No result found.';
        }
        return $res; 
    }
    public function getmodel($mk_id){
        if($mk_id > 0){
            $make_result = $this->db->select('UUID')->from('t_Makes')->where('id', $mk_id)->get();
            if ($make_result->num_rows() > 0) {
                $make_row = $make_result->result_array();
                $make_uuid = $make_row[0]['UUID'];
                $sql = "SELECT md.Model_Name as name,md.id FROM t_Makes as mk JOIN t_Models md ON mk.UUID = md.Make_UUID JOIN t_Vehicles vh ON md.UUID = vh.Model_UUID WHERE md.Make_UUID='".$make_uuid."' ORDER BY md.Model_Name";
                $result = $this->db->query($sql);
                if ($result->num_rows() > 0) {
                    $array_unique = array_unique($result->result_array(), SORT_REGULAR);
                    $res[] = $array_unique;
                } else {
                    $res[] = array();
                }
            }else {
                $res[] = array();
            }
        }else {
            $res[] = array();
        }
        return $res;
    }
    public function getyears($mk_id){
        if($mk_id > 0){
            $make_result = $this->db->select('UUID')->from('t_Models')->where('id', $mk_id)->get();
            if ($make_result->num_rows() > 0) {            
                $make_row = $make_result->result_array();
                $make_uuid = $make_row[0]['UUID'];
                $sql = "SELECT id,Years as year FROM t_Vehicles WHERE Model_UUID='".$make_uuid."' ORDER BY Years";
                $result = $this->db->query($sql);
                if ($result->num_rows() > 0) {
                    $years_result = $result->result_array();
                    //print_r($years_result);
                    $year_array = array();
                    foreach($years_result as $value){
                        //echo $value['Years'];
                        $years = explode(',',$value['year']); 
                        if($years[0] == $years[count($years)-1]){
                            $year_val = $years[0];
                        }else{
                            $year_val = $years[0].'-'.$years[count($years)-1];
                        }
                        $year_array[] = array('id' => $value['id'],'year' => $year_val);
                    }
                    $array_unique = array_unique($year_array, SORT_REGULAR);
                    $res[] = $array_unique;
                } else {
                    $res[] = array();
                }
            } else {
                $res[] = array();
            } 
        }else {
            $res[] = array();
        }        
        return $res;
    }

    public function get_vehicle_info($vh_id){
        $sql = "SELECT ( select tk.Chip_UUID FROM t_Keys tk WHERE tk.UUID = vh.Chip_Key_UUID) as Chip_UUIDs,( select tc.Chip_Name FROM t_Chips tc WHERE tc.UUID = Chip_UUIDs) as Transponder_Chip,
         vh.Model_UUID as MUUID,mk.UUID as MKUUID, vh.Vehicle_Image,vh.image_url,mk.Make_Name,md.Model_Name,vh.Years,vh.APP_System,vh.APP_Add_Keys,vh.APP_All_Keys_Lost,vh.APP_Notes,vh.APP_Confirmed_Working,vh.APP_Programs_Remote,vh.APP_Resync_Available,vh.PIN_Read,vh.APP_Youtube_URL ,vh.Key_Blade,vh.Mechanical_Key_UUID,vh.APP_Youtube_Title as Transponder_Chip2 FROM t_Makes as mk JOIN t_Models md ON mk.UUID = md.Make_UUID JOIN t_Vehicles vh ON md.UUID = vh.Model_UUID WHERE vh.id = ".$vh_id."";       
        $result = $this->db->query($sql);
        $result_data = $result->result_array();

        $Mechanical_Key_UUID = $result_data[0]['Mechanical_Key_UUID'];
        $mach_keys_array = explode(',',$Mechanical_Key_UUID);
        $get_rows = "";
        for($i = 0; $i < count($mach_keys_array); $i++ ){
            $value_uuid = $mach_keys_array[$i];
            $get_result = $this->db->query("SELECT Alt_MFK,Key_Name FROM t_Keys WHERE UUID ='".$value_uuid."' ");  
            $get_rows = $get_result->result_array();

           /* if(count($get_rows) > 0){
                $Alt_MFK .= $get_rows[0]['Alt_MFK'].',';                     
            }*/
        }
        /*$Alt_MFK = rtrim($Alt_MFK,',');product_vehicle_info
        $Alt_MFK_arr = array('MFK' =>  $Alt_MFK);*/

        if ($result->num_rows() > 0) {
            return array_merge($result->result_array(),$get_rows);
        }else{
            return array();
        }    
    }


/*------------------- ScanXtoolApi -------------------------------*/
    public function getScanXtoolMakes(){
        $make_array = array();
        $result = $this->db->query("SHOW TABLES LIKE '%ServerFunc%'");
		if ($result->num_rows() > 0) {
            $function_tables = $result->result_array();
            return $function_tables;
		}else{
			return array();
		}
    }

    public function getscanxtoolmodel($id){
        $sql = $this->db->query("SELECT vehilce_menu as name,id FROM ".$id." GROUP BY vehilce_menu");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }else{
			return array();
		}
    }
    public function getscanxtoolyears($id,$table){
        $sql = $this->db->query("SELECT year,id FROM ".$table." WHERE id='".$id."' ORDER BY year");
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }else{
			return array();
		}
    }
    public function scan_xtool_vehicle_info($table,$model,$year){
        if($model !="" && $year !=""){
            $model_sql = $this->db->query("SELECT vehilce_menu FROM ".$table." WHERE id='".$model."' ORDER BY vehilce_menu");
            $model_sql_data = $model_sql->result_array();
            $model2 = $model_sql_data[0]['vehilce_menu'];
            $year_sql = $this->db->query("SELECT year FROM ".$table." WHERE id='".$year."' ORDER BY year");
            $year_sql_data = $year_sql->result_array();
            $year2 = $year_sql_data[0]['year'];
            $sql = $this->db->query("SELECT * FROM ".$table." WHERE year='".$year2."' and vehilce_menu='".$model2."' ORDER BY vehilce_menu");
        }else if($model !="" && $year ==""){
            $model_sql = $this->db->query("SELECT vehilce_menu FROM ".$table." WHERE id='".$model."' ORDER BY vehilce_menu");
            $model_sql_data = $model_sql->result_array();
            $model2 = $model_sql_data[0]['vehilce_menu'];
            $sql = $this->db->query("SELECT * FROM ".$table." WHERE vehilce_menu='".$model2."' ORDER BY year");
        }else if($model =="" && $year ==""){
            $sql = $this->db->query("SELECT * FROM ".$table." ORDER BY brand");
        }else{
            $sql = $this->db->query("SELECT * FROM ".$table." ORDER BY brand");
        }       
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }else{
			return array();
		}
    }
    public function product_vehicle_info($make,$model,$year){
		$make =  $this->input->post('make');
		$model =  $this->input->post('model');
		$year =  $this->input->post('year');
		$sql = "SELECT  Product_id from product_vehicle_info where Make = '".$make."' and Model='".$model."'  and Year='".$year."'";
        $result = $this->db->query($sql);
        $php_arr_data_ids = "";
        if ($result->num_rows() > 0) {
            foreach($result->result_array() as $pid_arr){
                $php_arr = $pid_arr['Product_id'];                
                $php_arr = str_replace('~','~,',$php_arr);
                $php_arr_data = explode(',', $php_arr);
                $php_arr_data = array_filter($php_arr_data);
                foreach($php_arr_data as $pid){
                    if($pid !="")
                         $php_arr_data_ids .= "'".$pid."',";
                }
            }
            $php_arr_data_ids =  rtrim($php_arr_data_ids,',');
            $model_sql = $this->db->query("SELECT Product_id,Product_Title,Image FROM product_detail WHERE Product_id IN(".$php_arr_data_ids.")");
            if ($model_sql->num_rows() > 0) {
                $res[] = $model_sql->result_array();
            }else {
                $res['error'] = true;
                $res['message'] = 'No result found.';
            }
        } else {
            $res['error'] = true;
            $res['message'] = 'No result found.';
        }
        return $res; 
		
	}
	public function product_vehicle_detail($id){
		$prod_id = 0;
		if($id !=""){
			$prod_id = $id.'~';
		}
		 $sql = "SELECT Product_id,Product_Title,Image from product_detail where Product_id  = '".$prod_id."'";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {            
             $res[] = $result->result_array();
        } else {
            $res['error'] = true;
            $res['message'] = 'No result found.';
        }
        return $res; 
	}
    
}
