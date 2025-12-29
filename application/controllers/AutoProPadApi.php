<?php error_reporting(0);
if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library
require (APPPATH.'/libraries/REST_Controller.php');
require (APPPATH."/libraries/Format.php");
use Restserver\Libraries\REST_Controller;

class AutoProPadApi extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        
        //load user model
        $this->load->model('api');
    }
    public function getMakes_get($id = 0) {
        $data = $this->api->getMakes($id); 
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function getmodel_get($id = 0) {
        $data = $this->api->getmodel($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function getyears_get($id = 0) {
        $data = $this->api->getyears($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function vehicle_info_get($id = 0){
        $data = $this->api->get_vehicle_info($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
  
/*------------------- ScanXtoolApi -------------------------------*/

    public function getscanxtoolmake_get(){
        $data = $this->api->getScanXtoolMakes($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function getscanxtoolmodel_get($id){
        $data = $this->api->getscanxtoolmodel($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function getscanxtoolyears_get($id,$table){
        $data = $this->api->getscanxtoolyears($id,$table);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function scan_xtool_vehicle_info_get($table="",$model="",$year=""){
        $data = $this->api->scan_xtool_vehicle_info($table,$model,$year);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function product_vehicle_info_post($make="",$model="",$year=""){		
		$data = $this->api->product_vehicle_info($make,$model,$year);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
	}
	public function product_vehicle_detail_get($id = 0){
		$data = $this->api->product_vehicle_detail($id);
        if(!empty($data)){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No Rrcord were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
	}
    
}
