<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicles extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url' ,'user_helper'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->library('pagination');
		$this->load->helper("file");
		$this->load->helper('email');
		$this->load->library('csvreader');
	}	
	public function makes(){
		$data =array();	
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Makes</strong> ';
			$config = array();
			$config["base_url"] = base_url() . "vehicles/makes";
			$total_row = $this->admin_model->getAllMakeNamesRows();
			
			$config["total_rows"] = $total_row;						
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['cur_tag_open'] = '<a class="current">';
			$config['cur_tag_close'] = '</a>';
			$config['per_page'] = 50;
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';		
			$this->pagination->initialize($config);
			if($this->uri->segment(3)){
				$page = ($this->uri->segment(3));
				$limt_start = ($page - 1)  * $config["per_page"];
			}else{
				$page = 1;
				$limt_start = 0;
			}			
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNamesDetail($config["per_page"],$limt_start);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );				
			$this->load->view('layout/header',$data);
			$this->load->view('makes_user', $data);
			$this->load->view('layout/footer');
		}else{			     
			  $this->load->view('index', $data);
		}
	}	
	public function model(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Vehicles > <strong>Models</strong> ';
			$config = array();
			$config["base_url"] = base_url() . "vehicles/model";
			$total_row = $this->admin_model->getAllModelRows();
			$config["total_rows"] = $total_row;
			$data['getAllMakeNames'] = $this->admin_model->getAllMakeNames();
			if(isset($this->session->userdata['pagination_per_page'])){
				$per_page = $this->session->userdata['pagination_per_page']; 
				$config["per_page"] = $per_page['per_page'];
			}else{
				$config["per_page"] = 50;
			}		
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['cur_tag_open'] = '<a class="current">';
			$config['cur_tag_close'] = '</a>';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';		
			$this->pagination->initialize($config);
			if($this->uri->segment(3)){
				$page = ($this->uri->segment(3));
				$limt_start = ($page - 1)  * $config["per_page"];
			}else{
				$page = 1;
				$limt_start = 0;
			}
			$data["totalrows"] = $this->admin_model->getAllModelRows();
			$data['page'] = $page;
			$data["results"] = $this->admin_model->getAllModel($config["per_page"],$limt_start);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			$this->load->view('layout/header',$data);
			$this->load->view('manage_model', $data);
			$this->load->view('layout/footer');
		}else{			     
			  $this->load->view('index', $data);
		}	
	}
	
/*--------------------------------------------------Add Makes user-------------------------*/
	
	public function add_makes(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
	    $data['subTitle'] = 'Vehicles > Makes > <strong>Add New Make</strong>';
		$this->load->view('layout/header',$data);
		$this->load->view('add_makes');
		$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function makes_user_add(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
		$add_makename = $this->admin_model->MakesName();	
		if($add_makename == true){
		      $this->session->set_flashdata('message_display', 'Data added successfully');
		}else{
			$this->session->set_flashdata('message_display', 'Error in adding user! ');							 
		}							
			redirect('vehicles/add_makes');
		}else{			     
				  $this->load->view('index', $data);
			}	
	}
	
/*------------------------Delete Makes Name---------------------------*/


	public function deletemakesname($id){		
		$result = $this->admin_model->deleteMake($id);		
		if($result == 2){
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Data cannot be deleted!</div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		}
		redirect('vehicles/makes');	
	}
	
	
/*---------------------------Edit Makes name-----------------------------------------------------*/

	public function edit_MakeName($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Vehicles > Makes > <strong>Update Make</strong>';
			$data['id'] = $id;
			$data['getMakeInfo'] = $this->admin_model->getMakeInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_makesname', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function MakesName(){
		$id ="";
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Edit user';
			$data['id'] = $id;
			$update = $this->admin_model->EditMAkesNAme();
			if($update == true){
			 $this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  added successfully </div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Make name already exits</div>');							 
		}							
				redirect('vehicles/makes');
		}else{			     
				  $this->load->view('index', $data);
			}	
	}
	
	
	
/*--------------------------- Sort List-------------------------------------*/

	public function makeSortList(){
		   $orderby = $this->input->post('sorting');
		   $angle = $this->input->post('angle');
		   $data['sorting'] = $orderby ;
		   $data['angle'] = $angle ;
		  $makeSortList =$this->admin_model->MakeSortList($orderby);
		  $data['data'] = $makeSortList;
		  $this->load->view('makes_sort',$data);
		 
	 }
	 
	 
/*-------------------------------Edit model name----------------------------------------------*/



	public function edit_model($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Vehicles > Models > <strong>Update Model</strong>';
			$data['id'] = $id;
			$data['getallmakes'] = $this->admin_model->getallmakes();
			$data['results'] = $this->admin_model->vehicle_types();
			$data['getModelInfo'] = $this->admin_model->getModelInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_model', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function ModelName(){
		$id ="";
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Edit Model';
			$data['id'] = $id;
			$update = $this->admin_model->EditModel();
			if($update == true){
			 	$this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  added successfully </div>');
			}else{
				$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Model name and Make name already exits</div>');							 
			}
				redirect('vehicles/model');
			}else{					
					redirect('index');
		    }
	}
/*------------------------------------------------------------------------------Delete Model Name-------------------------------------------*/

	public function deleteModel($id){	
		$this->session->set_flashdata('message_display','<div class="alert alert-success">Data deleted successfully </div>');
		$result = $this->admin_model->deleteModel($id);	
		redirect('vehicles/model');	
	}
/*------------------------------------------------------------------------------ Add Manage Model-----------------------------------------------*/
	public function add_model(){
	     $data = array();;
	 	if(isset($this->session->userdata['login_user'])){	
		
	    $data['subTitle'] = 'Vehicles > Models > <strong>Add New Model</strong>';
		$data['getAllMakeNames'] = $this->admin_model->getAllMakeNames();
		$data['results'] = $this->admin_model->vehicle_types();
		$this->load->view('layout/header',$data);
		$this->load->view('add_model');
		$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function model_add(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
		$add_name = $this->admin_model->vehicle_types();	
		$add_name = $this->admin_model->modelName();	
		if($add_name == true){
		      $this->session->set_flashdata('message_display', 'Data added successfully');
		}else{
			$this->session->set_flashdata('message_display', 'Error in adding user! ');							 
		}							
			redirect('vehicles/add_model');
		}else{			     
				  $this->load->view('index', $data);
			}	
		}

/*------------------------------------------ model makenameSort List---------------------------------*/

	public function MakeNamesSorting(){
		   $orderby = $this->input->post('sorting');
		   $angle = $this->input->post('angle');
		   $data['sorting'] = $orderby ;
		   $data['angle'] = $angle ;
		  $makeSortList1 =$this->admin_model->makenamesorting($orderby);
		  $data['data'] = $makeSortList1;
		  $this->load->view('model_makename_sorting',$data);
	 }	


	
	
/*=========================================== Filter ==============================================*/	

	public function filter_by_makes(){		
		$data['filter_data'] = $this->admin_model->filter_by_makes();
		$this->load->view('filter_by_makes',$data);
	}  
	
	
	public function search_makes(){			
		$data['filter_data'] = $this->admin_model->search_makes();
		$this->load->view('filter_by_makes',$data);
	}
	
	public function code_sorting(){
		$data['sorting'] = $this->input->post('sorting');
		$data['getAllCodeSeries'] = $this->admin_model->code_sorting();
		$this->load->view('code_sorting',$data);
	}
	
	
	public function get_try_out_keys(){
		$this->load->view('get_try_out_keys');
	}


/*=============================================== Vahicle Module ============================================*/
	
	/*public function vehicles_test(){
		$data['subTitle'] = 'Vehicles > <strong>Vehicles</strong>';	
		$data["results"] = $this->admin_model->getAllvehicles_testData();	
		$this->load->view('layout/header',$data);
		$this->load->view('vehicles_test', $data);
		$this->load->view('layout/footer');
	}*/
	
	public function vehicle($id = ""){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			if($id !="" && preg_match('/id_/',$id)){
				$data =array();		
				$data['subTitle'] = 'Vehicles > <strong>Vehicles</strong>';		
				$vehicle_id = str_replace('id_','', $id);
				$data["results"] = $this->admin_model->getAllVehiclesDataInfo($vehicle_id);
			}else{
				$data =array();		
				$data['subTitle'] = 'Vehicles > <strong>Vehicles</strong>';		
				$config = array();
				$config["base_url"] = base_url() . "vehicles/vehicle";
				if(isset($this->session->userdata['vehicle_filter_missing'])){
					$session_data = $this->session->userdata('vehicle_filter_missing');
					$vehicle_type = $session_data['vehicle_type'];
					if($vehicle_type == ''){
						$total_row = $this->admin_model->getAllVehiclesRows();
					}elseif($vehicle_type == 'All'){
						$total_row = $this->admin_model->getAllVehiclesRows();
					}else{
						$total_row  = $this->admin_model->getAllVehiclesRows_Missing_Rows($vehicle_type);
					}
				}elseif(isset($this->session->userdata['vehicle_filter_type'])){
					$session_data = $this->session->userdata('vehicle_filter_type');
					$vehicle_type = $session_data['vehicle_type'];
					if($vehicle_type == ''){
						$total_row = $this->admin_model->getAllVehiclesRows();
					}elseif($vehicle_type == 'All'){
						$total_row = $this->admin_model->getAllVehiclesRows();
					}else{
						$total_row = $this->admin_model->getAllVehiclesRows2_Rows($vehicle_type);
					}
				}elseif(isset($_SESSION['make_id']) && $_SESSION['make_id'] !=""){	
					$makeId = $_SESSION['make_id'];													
					if($makeId == 'All'){
						$total_row = $this->admin_model->getAllVehiclesRows();
					}else{										
						$total_row = $this->admin_model->getAllmakesRows($makeId);						
					}										
				}else{
					$total_row = $this->admin_model->getAllVehiclesRows();
				}		
				$config["total_rows"] = $total_row;			
				if(isset($this->session->userdata['vehicles_pagination'])){
					$per_page = $this->session->userdata['vehicles_pagination']; 
					$config["per_page"] = $per_page['per_page'];
				}else{
					$config["per_page"] = 50;
				}		
				$config['use_page_numbers'] = TRUE;
				$config['num_links'] = $total_row;
				$config['cur_tag_open'] = '<a class="current">';
				$config['cur_tag_close'] = '</a>';
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';		
				$this->pagination->initialize($config);
				if($this->uri->segment(3)){
					$page = ($this->uri->segment(3));
					$limt_start = ($page - 1)  * $config["per_page"];
				}else{
					$page = 1;
					$limt_start = 0;
				}
				$data["totalrows"] = $this->admin_model->getAllVehiclesRows();
				
				$data['page'] = $page;
				if(isset($_SESSION['search_key']) && $_SESSION['search_key'] !=""){				
						$data["results"] =  $this->admin_model->getSearchItem($config["per_page"],$limt_start,$_SESSION['search_key']);	
				}elseif(isset($_SESSION['model_id']) && isset($_SESSION['make_id']) && $_SESSION['model_id'] !="" && $_SESSION['make_id'] !=""){					
					$makeId = $_SESSION['make_id'];				
					$modelId =$_SESSION['model_id'];
					if($modelId !=""){
						$data["results"] = $this->admin_model->getmakemodelfilter($config["per_page"],$limt_start,$modelId, $makeId);
					}else{
						$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}					
				}elseif(isset($_SESSION['make_id']) && $_SESSION['make_id'] !=""){						
					$makeId = $_SESSION['make_id'];									
					if($makeId == 'All'){
						$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}else{										
						$data["results"] = $this->admin_model->getfiltermakes($makeId,$config["per_page"],$limt_start);							
					}										
				}elseif(isset($this->session->userdata['vehicle_filter_missing'])){
					$session_data = $this->session->userdata('vehicle_filter_missing');
					$vehicle_type = $session_data['vehicle_type'];
					if($vehicle_type == ''){
						$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}elseif($vehicle_type == 'All'){
						  $data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}else{
						$data["results"] = $this->admin_model->getAllVehiclesRows_Missing($config["per_page"],$limt_start,$vehicle_type);
					}
				}elseif(isset($this->session->userdata['vehicle_filter_type'])){
					$session_data = $this->session->userdata('vehicle_filter_type');
					$vehicle_type = $session_data['vehicle_type'];
					if($vehicle_type == ''){
						$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}elseif($vehicle_type == 'All'){
						  $data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
					}else{
						$data["results"] = $this->admin_model->getAllVehiclesData2($config["per_page"],$limt_start,$vehicle_type);
					}
				}else{
					$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);
				}
			}
		
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			//$data['all_makes'] = $this->admin_model->get_AllMakes2($config["per_page"],$limt_start);			
			$data['all_makes'] = $this->admin_model->get_AllMakes();		
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );			
			$this->load->view('layout/header',$data);
			$this->load->view('vehicles', $data);
			$this->load->view('layout/footer');
		}else{			     
		     $this->load->view('index', $data);
		}
	}
	
	public function add_vehicle(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Vehicles > Vehicles > <strong>Add New Vehicle</strong>';
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			//$data["get_all_vehicles"] = $this->admin_model->get_all_vehicles2();	
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$data['get_t_code_series'] = $this->admin_model->get_t_code_series();	
			//$data['getRetainers'] =	$this->admin_model->getRetainers();
			$this->load->view('layout/header',$data);
			$this->load->view('add_vehicle', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	
	public function get_models(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$this->load->view('get_models', $data);
	}
	
	public function get_vehicle_models(){
		unset($_SESSION['search_key']);
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$makeId = $this->input->post('makeId');			
		$_SESSION['make_id'] = $makeId;
		$config = array();
		$config["base_url"] = base_url() . "vehicles/vehicle";
		$total_row = $this->admin_model->getAllmakesRows($makeId);
		$config["total_rows"] = $total_row;	
		if(isset($this->session->userdata['vehicles_pagination'])){
			$per_page = $this->session->userdata['vehicles_pagination']; 
			$config["per_page"] = $per_page['per_page'];
		}else{
			$config["per_page"] = 50;
		}	
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';	
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3));
			$limt_start = ($page - 1)  * $config["per_page"];
		}else{
			$page = 1;
			$limt_start = 0;
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links);
		$data["totalrows"] = $total_row;	
		if($makeId =='All'){
			$data["results"] = $this->admin_model->getAllVehiclesData($config["per_page"],$limt_start);			
		}else{
			$data['results'] = $this->admin_model->vehicle_sort_by_make($config["per_page"],$limt_start);
		}		
		$this->load->view('get_vehicle_models', $data);
	}
	
	
	
	public function save_vehicle(){
		if($this->input->post('toYear') != ""){
			$year = $this->input->post('fromYear').'-'. $this->input->post('toYear');
		}else{
			$year = $this->input->post('fromYear');
		}
		$make_uuid = $this->input->post('Make_UUID');
		$model_uuid = $this->input->post('Model_UUID');
		$getModelInfo = $this->admin_model->getModelInfo2($model_uuid);
		$getMakeInfo = $this->admin_model->getMakeInfo2($make_uuid);
		
		$file_name="";
			    $config['upload_path'] ='./assets/vehicleImages/150';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 1024;
				$config['max_width'] = 500;
				$config['max_height'] = 500; 
				$this->load->library('upload', $config);
		if($_FILES['Vehicle_Image']['name'] !=""){
			if ( ! $this->upload->do_upload('Vehicle_Image')){
				$this->session->set_flashdata('errors',  'image: '.$this->upload->display_errors());
				redirect('vehicles/add_vehicle');
			}else{
				$filedata = $this->upload->data();
				$file_name = $filedata['file_name'];
			}
		}
		/*else{
			$this->session->set_flashdata('errors',  'Please upload image');
			redirect('vehicles/add_vehicle');
		} */		
		$update = $this->admin_model->save_vehicle($file_name);
			
		$this->session->set_flashdata('message_display', 'Added the new <strong>'.$year.' '.$getMakeInfo[0]['Make_Name'].' '.$getModelInfo[0]['Model_Name'].'</strong> vehicle');
		redirect('vehicles/add_vehicle');
	}
	
	
	public function edit_vehicles($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['vehicleId'] = $id ;
			$data['subTitle'] = 'Vehicles > Vehicles > <strong>Update Vehicle</strong>';
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();	
			$data['get_t_code_series'] = $this->admin_model->get_t_code_series();	
			//$data['getRetainers'] =	$this->admin_model->getRetainers();
			$data['getVehiclesInfo'] =	$this->admin_model->getVehiclesInfo($id);
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$this->load->view('layout/header',$data);
			$this->load->view('edit_vehicles', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	
	public function copy_vehicle($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['vehicleId'] = $id ;
			$data['subTitle'] = 'Vehicles > Vehicles > <strong>Update Vehicle</strong>';
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();	
			//$data['get_t_code_series'] = $this->admin_model->get_t_code_series();	
			//$data['getRetainers'] =	$this->admin_model->getRetainers();
			$data['getVehiclesInfo'] =	$this->admin_model->getVehiclesInfo($id);
			//$data["get_all_vehicles"] = $this->admin_model->get_all_vehicles2();
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$this->load->view('layout/header',$data);
			$this->load->view('copy_vehicle', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	
	public function update_vehicle(){
		if(isset($_SESSION['pageNumber'])){
			$page_id =  $_SESSION['pageNumber'];
		}else{
			$page_id = "";
		}
	   $pageId = $this->input->post('pageId');
		$file_name="";
			    $config['upload_path'] ='./assets/vehicleImages/150';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 1024;
				$config['max_width'] = 500;
				$config['max_height'] = 500; 
				$this->load->library('upload', $config);
		if($_FILES['Vehicle_Image']['name'] !=""){
			if ( ! $this->upload->do_upload('Vehicle_Image')){
				$this->session->set_flashdata('errors',  'image: '.$this->upload->display_errors());
				redirect('vehicles/edit_vehicles/'.$pageId );

			}else{
				$filedata = $this->upload->data();
				$file_name = $filedata['file_name'];
			}
		}
	/*	else{
			$this->session->set_flashdata('errors',  'Please upload image');
			redirect('vehicles/edit_vehicles/'.$page_id);
		} 	*/
		$update = $this->admin_model->update_vehicle($file_name);
		$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data updated successfully</div>');
		redirect('vehicles/vehicle/'.$page_id);
	}
	
	public function delete_vehicles($id){
		$this->session->set_flashdata('message_display','<div class="alert alert-success">Data deleted successfully </div>');
		$result = $this->admin_model->delete_vehicles($id);	
		redirect('vehicles/vehicle');
	}
	
	public function filter_vehicle_by_model(){		
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = '';
		$modelId = $this->input->post('modelId');
		$result = $this->admin_model->filter_vehicle_by_model();
		if($result){
			$_SESSION['model_id'] = $modelId;
			$data['results'] = $this->admin_model->filter_vehicle_by_model();
			$this->load->view('vehicle_sorting_make',$data);
		}else{
			unset($_SESSION['model_id']);
			$data['results'] = $this->admin_model->filter_vehicle_by_model();
			$this->load->view('vehicle_sorting_make',$data);
		}
	}
	
	public function search_vehicles(){
		$search_key = trim($this->input->post('search_key'));
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = '';
		$result = $this->admin_model->search_vehicles();
		if($result){
			$_SESSION['search_key'] = $search_key;			
		}else{
			unset($_SESSION['search_key']);
		}
		$data['results'] = $result;
		$this->load->view('vehicle_sorting_make',$data);
	}

	public function searchAvailableVehicles(){
		$data['get_all_vehicles'] = $this->admin_model->search_vehicles();
		$this->load->view('searchAvailableVehicles',$data);	
	}

	public function searchAvailableVehiclesMethod(){
		$data['get_all_vehicles'] = $this->admin_model->search_vehicles();
		$this->load->view('searchAvailableVehiclesMethod',$data);	
	}

	public function limitVehicleTransponder(){
		$data['get_all_vehicles'] = $this->admin_model->limitVehicleTransponder();
		$this->load->view('limitVehicleTransponder',$data);	
	}

	public function searchAvailableVehicles2(){
		$data['get_all_vehicles'] = $this->admin_model->search_vehicles2();
		$this->load->view('searchAvailableVehicles2',$data);	
	}
	
	public function get_determinator(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['key'] = $this->input->post('key');
		$this->load->view('get_determinators',$data);
	}	
	
	public function update_determinator(){
		echo $results = $this->admin_model->update_determinator();
	}	
	
	public function HideMachineInfo(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "MachineInfo_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideDecoders(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "Decoders_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	
	public function get_cs_column_data(){
		$data['input_val'] = $this->input->post('value');
		$data['input_id']= $this->input->post('dataId');
		$data['input_column'] = $this->input->post('ColumnName');
		$this->load->view('get_cs_column_data',$data);
	}
	
	public function csinput_update(){
		echo $results = $this->admin_model->csinput_update();
	}
	
	
	public function get_cs_keys_data(){
		$data['input_val'] = $this->input->post('value');
		$data['input_id']= $this->input->post('dataId');
		$data['input_column'] = $this->input->post('ColumnName');
		$data['key1'] = $this->input->post('key1');
		$data['key2'] = $this->input->post('key2');
		$this->load->view('get_cs_keys_data',$data);
	}
	public function cs_keys_data_update(){
		echo $results = $this->admin_model->cs_keys_data_update();
	}
	
	public function get_machine_data(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['key'] = $this->input->post('key');
		$this->load->view('get_machine_data',$data);
	}
	
	public function update_machine_data(){
		echo $results = $this->admin_model->update_machine_data();
	}
	
	public function get_key_style_data(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');	
		$data['getAllKeyStyles'] = $this->admin_model->getAllkeyStyles();	
		$this->load->view('get_key_style_data',$data);
	}
	
	public function update_key_style_data(){
		echo $results = $this->admin_model->update_key_style_data();
	}

/*=========================== Vehicle Page Editing ==========================================*/
	
	public function edit_vh_inputs(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$this->load->view('edit_vh_inputs',$data);
	}
	
	public function edit_image_inputs(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['img_uuid'] = $this->input->post('img_uuid'); 
		$user_data = $this->session->userdata['login_user'];
		$user_email = $user_data['email'];				
		$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
		$this->load->view('edit_image_inputs',$data);
	}
	
	public function vh_input_update(){
		echo $results = $this->admin_model->vh_input_update();
	}
	
	public function update_vehicle_image1(){
		echo $results = $this->admin_model->update_vehicle_image1();
	}
	
	public function edit_vh_dropbox(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['key'] = $this->input->post('key');
		$data['type'] = $this->input->post('type');
		$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();	
		$data['get_t_code_series'] = $this->admin_model->get_t_code_series();	
		//$data['getRetainers'] =	$this->admin_model->getRetainers();
		$this->load->view('edit_vh_dropbox',$data);
	}
	
	public function vh_dropbox_update(){
		echo $results = $this->admin_model->vh_dropbox_update();
	}
	
	public function edit_vh_programmers_box(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['key'] = $this->input->post('key');
		$data['type'] = $this->input->post('type');		
		$this->load->view('edit_vh_programmers_box',$data);
	}
	
	public function edit_vh_multiple_box(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['key'] = $this->input->post('key');
		$data['type'] = $this->input->post('type');		
		$this->load->view('edit_vh_multiple_box',$data);
	}
	
	public function vh_multiple_dropbox_update(){
		echo $results = $this->admin_model->vh_multiple_dropbox_update();
	}
	
	public function vh_programmers_dropbox_update(){
		echo $results = $this->admin_model->vh_programmers_dropbox_update();
	}	
	
	public function HideAdvancedign(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "Advanced_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideProlok(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "Prolok_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideCcode_keyInfo(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "code_keyInfo_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideAutoProPAD(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "autopropad_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideHotWire(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "hotwire_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideTKOSDD(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "tko_sdd_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
/*==================== OBD: options ===================================================*/

	public function obp_options(){
		$data = array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>OBP: Options</strong>';	
			$data['results'] = $this->admin_model->get_obp_options();	
			$data['image_types'] = $this->admin_model->get_image_types();			
			$this->load->view('layout/header',$data);
			$this->load->view('obp_options', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function add_obp_option(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add New Option</strong>';			
			$data['get_image'] = $this->admin_model->get_image();	
			$data['obp_option_categories'] = $this->admin_model->get_obp_option_categories();			
			$this->load->view('layout/header',$data);
			$this->load->view('add_obp_option', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function save_obp_options(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->save_obp_options();
			$this->session->set_flashdata('message_display', 'Data added successfully');
			redirect('vehicles/add_obp_option');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function edit_obp_options($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;	
			$data['subTitle'] = 'Vehicles > <strong>Add New Option</strong>';
			$data['obp_options_info'] = $this->admin_model->get_obp_options_info($id);			
			$data['get_image'] = $this->admin_model->get_image();	
			$data['obp_option_categories'] = $this->admin_model->get_obp_option_categories();			
			$this->load->view('layout/header',$data);
			$this->load->view('edit_obp_options', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function update_obp_options(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->update_obp_options();
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data updated successfully</div>');
			redirect('vehicles/obp_options');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function delete_obp_options($id){
		$result = $this->admin_model->delete_obp_options($id);	
		$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		redirect('vehicles/obp_options');
	}
	
	public function obp_options_sorting(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sort_by'] = $this->input->post('sortby');		
		$data['results'] = $this->admin_model->obp_options_sorting();	
		$this->load->view('obp_options_sorting',$data);
	}
	
	
/*============================ OBP Options Categories ==================================*/
	
	public function obp_options_categories(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>OBP: Options Category</strong>';	
			$data['results'] = $this->admin_model->get_obp_option_categories();			
			$this->load->view('layout/header',$data);
			$this->load->view('obp_options_categories', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function add_obp_options_categories(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add New Category</strong>';					
			$this->load->view('layout/header',$data);
			$this->load->view('add_obp_options_categories', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function save_obp_options_category(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->save_obp_options_category();
			$this->session->set_flashdata('message_display', 'Data added successfully');
			redirect('vehicles/add_obp_options_categories');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function edit_obp_options_cat($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){
			$data['id'] = $id;	
			$data['subTitle'] = 'Vehicles > <strong>Add New Category</strong>';	
			$data['obp_option_cat_info'] = $this->admin_model->get_obp_option_cat_info($id);						
			$this->load->view('layout/header',$data);
			$this->load->view('edit_obp_options_cat', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function update_obp_options_category(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->update_obp_options_category();
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data updated successfully</div>');
			redirect('vehicles/obp_options_categories');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function delete_obp_options_cat($id){
		$result = $this->admin_model->delete_obp_options_cat($id);	
		$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		redirect('vehicles/obp_options_categories');
	}
	
	
	public function obp_opt_cateogry_sort(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');
		$data['results'] = $this->admin_model->obp_opt_cateogry_sort();
		$this->load->view('obp_opt_cateogry_sort',$data);	
	}


/*============================ OBP remotes ==================================*/
	
	public function obp_remotes(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>OBP: Remotes</strong>';	
			$data['results'] = $this->admin_model->get_obp_remotes();			
			$this->load->view('layout/header',$data);
			$this->load->view('obp_remotes', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}	
	
	public function add_obp_remotes(){		
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>OBP: Remotes</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data['obp_option_categories']	= $this->admin_model->get_obp_option_categories();	
			$this->load->view('layout/header',$data);
			$this->load->view('add_obp_remotes', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}	
	
	public function get_obp_models(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$this->load->view('get_obp_models', $data);
	}
	
	public function get_obp_models2(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$this->load->view('get_obp_models2', $data);
	}
	
	public function get_obp_vehicles(){
		$data['get_vehicles'] = $this->admin_model->get_vehicles();	
		$data['modelId'] = $this->input->post('ModelId');	
		$this->load->view('get_obp_vehicles', $data);
	}
	
	public function get_obp_vehicles2(){
		$data['get_vehicles'] = $this->admin_model->get_vehicles();	
		$data['modelId'] = $this->input->post('ModelId');	
		$this->load->view('get_obp_vehicles2', $data);
	}
	
	public function get_obp_ptions(){
		$data['get_obp_ptions'] = $this->admin_model->get_obp_ptions();	
		$data['catId'] = $this->input->post('catId');	
		$this->load->view('get_obp_options', $data);
	}	
	
	public function get_obp_image(){
		$data['get_obp_ptions'] = $this->admin_model->get_obp_image();	
		$data['catId'] = $this->input->post('catId');	
		$this->load->view('get_obp_image', $data);
	}
	
	public function change_obp_image(){
		$data['get_obp_ptions'] = $this->admin_model->change_obp_image();	
		$data['Image_Type_UUID'] = $this->input->post('Image_Type_UUID');	
		$this->load->view('change_obp_image', $data);
	}
	
	public function get_image_deafult_text(){
		$data['get_obp_ptions'] = $this->admin_model->get_image_deafult_text();	
		$data['Default_Image_UUID'] = $this->input->post('Default_Image_UUID');	
		$this->load->view('get_image_deafult_text', $data);
	}
	
	public function add_another_procedure(){
		$data['procedure'] = $this->input->post('procedure');
		$data['obp_option_categories']	= $this->admin_model->get_obp_option_categories();		
		$this->load->view('get_another_procedure', $data);	
	}
	
	public function save_obp_remote(){
		$data = array();
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->save_obp_remote();
			$this->session->set_flashdata('message_display', 'Data added successfully');
			redirect('vehicles/add_obp_remotes');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function edit_obp_remotes($uuid){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){
			$data['id'] = $uuid;	
			$data['subTitle'] = 'Vehicles > <strong>OBP: Remotes</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data['obp_option_categories']	= $this->admin_model->get_obp_option_categories();	
			$data['obp_remote_info']	= $this->admin_model->get_obp_remote_info($uuid);	
			$this->load->view('layout/header',$data);
			$this->load->view('edit_obp_remotes', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

/*---------------------------- Add Vehicle Images -----------------------------------------------*/

	public function v_images(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'User Submissions > <strong>Images</strong>';
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data["get_all_vehicles"] = $this->admin_model->get_all_vehicles();	
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);					
			$this->load->view('layout/header',$data);
			$this->load->view('vehicle_images', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function vehicle_images($id=""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Vehicle Images</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data["get_all_vehicles_images"] = $this->admin_model->get_all_vehicles_images();	
			$data["id"] = $id;							
			$this->load->view('layout/header',$data);
			$this->load->view('vehicles_images', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function add_vehicles_images( $id="" ){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add Vehicle Images</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data["get_all_vehicles_images"] = $this->admin_model->get_all_vehicles_images();
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$data["id"] = $id;							
			$this->load->view('layout/header',$data);
			$this->load->view('add_vehicles_images', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}


	public function save_vehicle_images(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->save_vehicle_images();
			$this->session->set_flashdata('message_display', 'Data added successfully');
			redirect('vehicles/add_vehicles_images');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function edit_vehicle_image($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Upadte Vehicle Images</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data["vehicles_images_info"] = $this->admin_model->get_vehicles_images_info($id);
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$data["id"] = $id;							
			$this->load->view('layout/header',$data);
			$this->load->view('edit_vehicle_image', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}

	public function copy_vehicle_image($id){
		$data = array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Upadte Vehicle Images</strong>';	
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$data["vehicles_images_info"] = $this->admin_model->get_vehicles_images_info($id);
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
			$data["id"] = $id;							
			$this->load->view('layout/header',$data);
			$this->load->view('copy_vehicle_image', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}

	public function update_vehicle_images(){
		$data = array();
		if(isset($this->session->userdata['login_user'])){	
			$query = $this->admin_model->update_vehicle_images();
			$this->session->set_flashdata('message_display', 'Data updated successfully');
			redirect('vehicles/vehicle_images');
		}else{			     
			$this->load->view('index', $data);
		}	
	}

	public function delete_vehicle_image($id){
		$query = $this->admin_model->delete_vehicle_image($id);
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/vehicle_images');
	}
	
	public function add_vh_images(){
		$data = array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'User Submissions > <strong>Images</strong>';			
			$data['get_dev_customer'] = $this->admin_model->get_dev_customer();
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);						
			$this->load->view('layout/header',$data);
			$this->load->view('add_vh_images', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function vehicles_image_filter_data(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$data['modelId'] = $this->input->post('modelId');
		$data['type'] = $this->input->post('type');
		$type =  $this->input->post('type');
		$data['get_years'] = $this->admin_model->filter_vehicle_by_model();	
		if($type == 'modal'){
			$data['get_all_vehicles_images'] = $this->admin_model->vehicles_image_filter_data_make();
		}else if($type =='years'){	
			$data['get_all_vehicles_images'] = $this->admin_model->vehicles_image_filter_data_model();
		}else{
			$data['get_all_vehicles_images'] = $this->admin_model->vehicles_image_filter_data_year();	
		}
		$this->load->view('vehicles_image_filter_data', $data);
	}

	public function searchVehicleImage(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$data['modelId'] = $this->input->post('modelId');
		$data['type'] = $this->input->post('type');
		$data['get_years'] = $this->admin_model->filter_vehicle_by_model();
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = 'Score';
		$data['get_all_vehicles_images'] = $this->admin_model->vehicles_image_filter_data();				
		$this->load->view('vehicles_image_filter_data', $data);
	}

	public function firebase_update_vehicles_images(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){			
			$data['subTitle'] = 'Firebase > <strong>Update Vehicle Images</strong>';	
			$data['vehicles_images'] = $this->admin_model->get_all_vehicles_images();			
			$this->load->view('layout/header',$data);
			$this->load->view('firebase_update_vehicles_images', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

/*================================= Add Another Code Series ===============================================*/

	public function get_more_code_series(){
		$data['get_t_code_series'] = $this->admin_model->get_t_code_series();
		$this->load->view('get_more_code_series', $data);
	}
	
	public function update_vehicle_image(){		
		$query = $this->admin_model->update_vehicle_image();
		$this->session->set_flashdata('message_display', 'Data added successfully');
	}





/*--------------------------- Code Series Sorting------------------------------------------*/

	public function code_series_sort(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');
		$data['results'] = $this->admin_model->code_series_sort();
		$this->load->view('code_series_sorting',$data);
	}
	
	public function code_series_uuid_sort(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');
		$data['results'] = $this->admin_model->code_series_uuid_sort();
		$this->load->view('code_series_sorting',$data);
	}
	
	public function HideDMaxcheckbox(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "dmaxcheckbox_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideImage(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "hideimage_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideParts(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "hideParts_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function HideTypes(){
		$cookies_values = $_POST['remember']; 
		$cookie_name = "hideTypes_cookie"; 
		if($_POST['remember'] == 1){
			setcookie($cookie_name, $cookies_values, time() + (86400 * 30), "/");
		}else{
			setcookie($cookie_name,'', time() + (86400 * 30), "/");
		}
	}
	
	public function show_vehicle_by_type(){
		unset($_SESSION['search_key']);
		unset($_SESSION['model_id']);		
		unset($_SESSION['make_id']);		
		$value = $this->input->post('type');		
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = '';

		$config = array();
		$config["base_url"] = base_url() . "vehicles/vehicle";
		$total_row = $this->admin_model->show_vehicle_by_type_count($value);
		$config["total_rows"] = $total_row;	
		if(isset($this->session->userdata['vehicles_pagination'])){
			$per_page = $this->session->userdata['vehicles_pagination']; 
			$config["per_page"] = $per_page['per_page'];
		}else{
			$config["per_page"] = 50;
		}	
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';	
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3));
			$limt_start = ($page - 1)  * $config["per_page"];
		}else{
			$page = 1;
			$limt_start = 0;
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links);
		$data["totalrows"] = $total_row;

		$result = $this->admin_model->show_vehicle_by_type($config["per_page"],$limt_start);
		if($result){
			$session_data = array('vehicle_type' => $value);
			$this->session->set_userdata('vehicle_filter_type', $session_data);
			$data['results'] = $result;
			$this->load->view('vehicle_sorting_make',$data);
		}else{
			$session_data = array('vehicle_type' => '');
			$this->session->unset_userdata('vehicle_filter_type', $session_data);
			$this->load->view('vehicle_sorting_make',$data);
		}
		
		
	}

	public function show_missing_code_series(){
		$value = $this->input->post('type');
		$session_data = array('vehicle_type' => $value);
		$this->session->set_userdata('vehicle_filter_missing', $session_data);
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = '';

		$config = array();
		$config["base_url"] = base_url() . "vehicles/vehicle";
		$total_row = $this->admin_model->show_missing_code_series_count();
		$config["total_rows"] = $total_row;	
		if(isset($this->session->userdata['vehicles_pagination'])){
			$per_page = $this->session->userdata['vehicles_pagination']; 
			$config["per_page"] = $per_page['per_page'];
		}else{
			$config["per_page"] = 50;
		}	
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';	
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3));
			$limt_start = ($page - 1)  * $config["per_page"];
		}else{
			$page = 1;
			$limt_start = 0;
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links);
		$data["totalrows"] = $total_row;
		$data['results'] = $this->admin_model->show_missing_code_series($config["per_page"],$limt_start);
		$this->load->view('vehicle_sorting_make',$data);
	}

	public function show_missing_images(){
		$value = $this->input->post('type');
		$session_data = array('vehicle_type' => $value);
		$this->session->set_userdata('vehicle_filter_missing', $session_data);
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = '';
		$config = array();
		$config["base_url"] = base_url() . "vehicles/vehicle";
		$total_row = $this->admin_model->show_missing_images_count();
		$config["total_rows"] = $total_row;	
		if(isset($this->session->userdata['vehicles_pagination'])){
			$per_page = $this->session->userdata['vehicles_pagination']; 
			$config["per_page"] = $per_page['per_page'];
		}else{
			$config["per_page"] = 50;
		}	
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';	
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3));
			$limt_start = ($page - 1)  * $config["per_page"];
		}else{
			$page = 1;
			$limt_start = 0;
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links);
		$data["totalrows"] = $total_row;
		$data['results'] = $this->admin_model->show_missing_images($config["per_page"],$limt_start);
		$this->load->view('vehicle_sorting_make',$data);
	}
	
	public function vehicle_types(){
		$data['subTitle'] = 'Vehicle > <strong>Vehicle Types</strong>';
		$data['results'] = $this->admin_model->vehicle_types();						
		$this->load->view('layout/header',$data);
		$this->load->view('vehicle_types', $data);
		$this->load->view('layout/footer');	
	}
	
	public function add_vehicle_type(){
		$data['subTitle'] = 'Vehicle > <strong>Add Vehicle Types</strong>';
		$data['results'] = $this->admin_model->vehicle_types();						
		$this->load->view('layout/header',$data);
		$this->load->view('add_vehicle_type', $data);
		$this->load->view('layout/footer');	
	}
	
	public function save_vehicle_type(){
		$query = $this->admin_model->save_vehicle_type();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/add_vehicle_type');
	}
	
	public function edit_vehicle_type($id){
		$data['subTitle'] = 'Vehicle > <strong>Update Vehicle Types</strong>';
		$data['id'] = $id;
		$data['vehicle_types_info'] = $this->admin_model->vehicle_types_info($id);						
		$this->load->view('layout/header',$data);
		$this->load->view('edit_vehicle_type', $data);
		$this->load->view('layout/footer');	
	}
	
	public function update_vehicle_type(){
		$query = $this->admin_model->update_vehicle_type();
		$this->session->set_flashdata('message_display', 'Data updated successfully');
		redirect('vehicles/vehicle_types');	
	}
	
	public function delete_vehicle_type($id){
		$query = $this->admin_model->delete_vehicle_type($id);
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/vehicle_types');
	}
	
/*------------------------- OBP Remotes Vehciles----------------------------------------------*/

	public function get_obp_remote_vehicle(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){
			$data["getAllMakeNames"] = $this->admin_model->getAllMakeNames();		
			$this->load->view('get_obp_remote_vehicle', $data);		
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	
	public function select_obp_more_Models(){
		$data['get_models'] = $this->admin_model->get_models();
		$data['makeId'] = $this->input->post('makeId');
		$this->load->view('get_obp_more_Models', $data);
	}

	/*----------------------------- Tips Tricks Section -----------------------------*/

	public function tip_tricks(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Tips & Tricks</strong>';
			$config = array();
			$config["base_url"] = base_url() . "vehicles/tip_tricks";
			$total_row = $this->admin_model->getAllTipsTricksRows();
			$config["total_rows"] = $total_row;
			if(isset($this->session->userdata['pagination_per_page2'])){
				$per_page = $this->session->userdata['pagination_per_page2']; 
				$config["per_page"] = $per_page['per_page'];
			}else{
				$config["per_page"] = 20;
			}
				
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['cur_tag_open'] = '<a class="current">';
			$config['cur_tag_close'] = '</a>';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';		
			$this->pagination->initialize($config);
			if($this->uri->segment(3)){
				$page = ($this->uri->segment(3));
				$limt_start = ($page - 1)  * $config["per_page"];
			}else{
				$page = 1;
				$limt_start = 0;
			}
			$data["totalrows"] = $this->admin_model->getAllTipsTricksRows();
			$data['page'] = $page;	
			$data['results'] = $this->admin_model->get_tip_tricks($config["per_page"],$limt_start);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );	
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);					
			$this->load->view('layout/header',$data);
			$this->load->view('tip_tricks', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}

	public function add_tip_tricks($us_id = ""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add Tips & Tricks</strong>';
			$data['us_id'] = $us_id;	
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);						
			$this->load->view('layout/header',$data);
			$this->load->view('add_tip_tricks', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_tip_tricks(){
		$query = $this->admin_model->save_tip_tricks();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/tip_tricks');
	}
	
	public function edit_tip_tricks($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Add Tips & Tricks</strong>';	
			$data['method_info'] = $this->admin_model->get_tip_tricks_info($id);
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);						
			$this->load->view('layout/header',$data);
			$this->load->view('edit_tip_tricks', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
	public function copy_tip_tricks($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Add Tips & Tricks</strong>';	
			$data['method_info'] = $this->admin_model->get_tip_tricks_info($id);
			$user_data = $this->session->userdata['login_user'];
			$user_email = $user_data['email'];				
			$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);						
			$this->load->view('layout/header',$data);
			$this->load->view('copy_tip_tricks', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}

	public function update_tip_tricks(){
		$query = $this->admin_model->update_tip_tricks();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/tip_tricks');
	}
	
	public function delete_tip_tricks($id){
		$result = $this->admin_model->delete_tip_tricks($id);	
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/tip_tricks');	
	}

	public function search_tips_tricks(){
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = 'Score';
		$data['results'] = $this->admin_model->vehicles_tipTricks_filter_data();				
		$this->load->view('search_tips_tricks', $data);
	}

	public function tips_tricks_sorting(){
		$data['results'] = $this->admin_model->tips_tricks_sorting();
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');	
		$this->load->view('search_tips_tricks', $data);	
	}

	public function tipTrick_score_order(){
		$order = $this->input->post('order');
		$id = $this->input->post('id');				
		$data['results'] = $this->admin_model->tipTrick_score_order($order,$id);
	}

	public function searhAksUser(){
		$data['get_all_aks_users'] = $this->admin_model->searhAksUser();
		$this->load->view('searhAksUser',$data);
	}	

	public function vehicle_common_sorting(){
		$data = array();
		$vehicle_type = "";
		$makeId = "";
		$modelId = "";
		$vehicle_type_missing = "";
		if(isset($this->session->userdata['vehicle_filter_type'])){
			$session_data = $this->session->userdata('vehicle_filter_type');
			$vehicle_type = $session_data['vehicle_type'];
		}	
		if(isset($_SESSION['make_id']) && $_SESSION['make_id'] !=""){	
			$makeId = $_SESSION['make_id'];
		}	
		if(isset($_SESSION['model_id']) && isset($_SESSION['make_id']) && $_SESSION['model_id'] !="" && $_SESSION['make_id'] !=""){					
			$makeId = $_SESSION['make_id'];				
			$modelId =$_SESSION['model_id'];
		}
		if(isset($this->session->userdata['vehicle_filter_missing'])){
			$session_data = $this->session->userdata('vehicle_filter_missing');
			$vehicle_type_missing = $session_data['vehicle_type'];
		}
		//echo $makeId.'---'.$modelId;
		$config = array();
		$config["base_url"] = base_url() . "vehicles/vehicle";
		if($this->input->post('search_key') !=""){
			$total_row = 20;
		}else{
			
			 $total_row = $this->admin_model->vehicle_common_sorting_count($vehicle_type,$makeId,$modelId,$vehicle_type_missing);
		
		}	
		$config["total_rows"] = $total_row;		
		if(isset($this->session->userdata['vehicles_pagination'])){
			$per_page = $this->session->userdata['vehicles_pagination']; 
			$config["per_page"] = $per_page['per_page'];
		}else{
			$config["per_page"] = 50;
		}		
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';		
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3));
			$limt_start = ($page - 1)  * $config["per_page"];
		}else{
			$page = 1;
			$limt_start = 0;
		}
		$data['totalrows'] = $total_row;
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');
		$sort = $this->input->post('sorting');
		$sorting_by = $this->input->post('sorting_by');
		$_SESSION['global_sorting'] = $sorting_by." ".$sort;		
		if($this->input->post('search_key') !=""){
			$data['results'] = $this->admin_model->search_vehicles();
		}else{
			$data['results'] = $this->admin_model->vehicle_common_sorting($config["per_page"],$limt_start,$vehicle_type,$makeId,$modelId,$vehicle_type_missing);
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );	
		$this->load->view('vehicle_sorting_make',$data);
	}
	public function deleteAllModel(){
		if($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');
			for($count = 0; $count < count($id); $count++){
				$this->admin_model->deleteAllModel($id[$count]);
			}
		}
	}
	public function deleteAllMakes(){
		if($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');
			for($count = 0; $count < count($id); $count++){
				$this->admin_model->deleteAllMakes($id[$count]);
			}
		}
	}

/*******************************Mchanical Keys *********************************** */
	public function machanical_keys(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Mechanical  Keys</strong>';				
			$data['results'] = $this->admin_model->machanical_keys();						
			$this->load->view('layout/header',$data);
			$this->load->view('machanical_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function add_machanical_keys($us_id = ""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add Mechanical Keys</strong>';						
			$this->load->view('layout/header',$data);
			$this->load->view('add_machanical_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_machanical_keys(){
		$pre_file_name = $_FILES['image']['name'];			
		if(empty($pre_file_name)){
			$file_name = $this->input->post('keyimage');
		}else{			
			$new_file_name = str_replace(' ', '_key_'.time(), $pre_file_name);
			$upload_folder = 'assets/key_upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png|svg';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$file_name = 'https://supportedvehicles.com/vh-admin/assets/key_upload/'. $upload_data['file_name'];
			}
		}
		$query = $this->admin_model->save_machanical_keys($file_name);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/machanical_keys');
	}
	
	public function edit_machanical_keys($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Update Mechanical Keys</strong>';	
			$data['result'] = $this->admin_model->machanical_keys_info($id);					
			$this->load->view('layout/header',$data);
			$this->load->view('edit_machanical_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	

	public function update_machanical_keys($id){
		$pre_file_name = $_FILES['image']['name'];			
		if(empty($pre_file_name)){
			$file_name = $this->input->post('keyimage');
		}else{			
			$new_file_name = str_replace(' ', '_key_'.time(), $pre_file_name);
			$upload_folder = 'assets/key_upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png|svg';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$file_name = 'https://supportedvehicles.com/vh-admin/assets/key_upload/'. $upload_data['file_name'];
			}
		}
		$query = $this->admin_model->update_machanical_keys($id, $file_name);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/machanical_keys');
	}
	
	public function delete_machanical_keys($id){
		$result = $this->admin_model->delete_machanical_keys($id);	
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/machanical_keys');	
	}

/*******************************Transponder Keys *********************************** */
	public function transponder_keys(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Transponder Keys</strong>';				
			$data['results'] = $this->admin_model->transponder_keys();						
			$this->load->view('layout/header',$data);
			$this->load->view('transponder_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function add_transponder_keys($us_id = ""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add Transponder Keys</strong>';						
			$this->load->view('layout/header',$data);
			$this->load->view('add_transponder_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_transponder_keys(){
		$pre_file_name = $_FILES['image']['name'];			
		if(empty($pre_file_name)){
			$file_name = $this->input->post('keyimage');
		}else{			
			$new_file_name = str_replace(' ', '_key_'.time(), $pre_file_name);
			$upload_folder = 'assets/key_upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png|svg';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$file_name = 'https://supportedvehicles.com/vh-admin/assets/key_upload/'. $upload_data['file_name'];
			}
		}
		$query = $this->admin_model->save_transponder_keys($file_name);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/transponder_keys');
	}
	
	public function edit_transponder_keys($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Update Transponder Keys</strong>';	
			$data['result'] = $this->admin_model->transponder_keys_info($id);					
			$this->load->view('layout/header',$data);
			$this->load->view('edit_transponder_keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	

	public function update_transponder_keys($id){
		$pre_file_name = $_FILES['image']['name'];			
		if(empty($pre_file_name)){
			$file_name = $this->input->post('keyimage');
		}else{			
			$new_file_name = str_replace(' ', '_key_'.time(), $pre_file_name);
			$upload_folder = 'assets/key_upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png|svg';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$file_name = 'https://supportedvehicles.com/vh-admin/assets/key_upload/'. $upload_data['file_name'];
			}
		}
		$query = $this->admin_model->update_transponder_keys($id,$file_name);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/transponder_keys');
	}
	
	public function delete_transponder_keys($id){
		$result = $this->admin_model->delete_transponder_keys($id);	
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/transponder_keys');	
	}

/******************************* Programmer Info *********************************** */
	public function programmer_information(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Programmer Information</strong>';				
			$data['results'] = $this->admin_model->programmer_information();						
			$this->load->view('layout/header',$data);
			$this->load->view('programmer_information', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function add_programmer_information($us_id = ""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Vehicles > <strong>Add Programmer Information</strong>';						
			$this->load->view('layout/header',$data);
			$this->load->view('add_programmer_information', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_programmer_information(){
		$query = $this->admin_model->save_programmer_information();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/programmer_information');
	}
	
	public function edit_programmer_information($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Vehicles > <strong>Update Programmer Information</strong>';	
			$data['result'] = $this->admin_model->programmer_information_info($id);					
			$this->load->view('layout/header',$data);
			$this->load->view('edit_programmer_information', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	

	public function update_programmer_information($id){
		$query = $this->admin_model->update_programmer_information($id);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('vehicles/programmer_information');
	}
	
	public function delete_programmer_information($id){
		$result = $this->admin_model->delete_programmer_information($id);	
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('vehicles/programmer_information');	
	}



/*------------------------- Export Data --------------------------*/
	
	public function exportdata(){
		$table_name = $this->input->post('table_name');
		$this->load->dbutil();		
		$query = $this->db->get($table_name);
		// print_r($query->result_array());
		// die();
		$data = $this->dbutil->csv_from_result($query);	
		
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$table_name.'_exported_data_'.time().'.csv"');
		echo $data;
	}
	// controllers/YourController.php

public function importdata(){
	$redirect = $this->input->post('redirect');
	$table_name = $this->input->post('table_name');
    if ($_FILES['import_file']['name']) {
        $config['upload_path']   = './csv-import/';
        $config['allowed_types'] = 'csv';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('import_file')) {
            $fileData = $this->upload->data();
            $filePath = $fileData['full_path'];
            $data = $this->csvreader->parse_file($filePath);
			// echo '<pre>';
			// print_r( $data);
            $this->admin_model->insert_batch_update($table_name, $data);
			$this->session->set_flashdata('message_display', 'Data imported successfully');            
        } else {
            $error = array('error' => $this->upload->display_errors());
			print_r($error);
			$this->session->set_flashdata('message_display', 'There is an error while importing CSV, please try again.');
        }
    }
	redirect($redirect);
}

public function activity_logs($table){
	$data = array();
	if(isset($this->session->userdata['login_user'])){	
		$data['id'] = $id;
		$data['subTitle'] = 'Vehicles > <strong>Activity Logs</strong>';	
		$data['results'] = $this->admin_model->activity_logs($table);					
		$this->load->view('layout/header',$data);
		$this->load->view('activity_logs', $data);
		$this->load->view('layout/footer');
	}else{			     
		$this->load->view('index', $data);
	}
}

public function import_vehicles_info(){
	$redirect = adm_base_url().'vehicles/vehicle';
	$table_name = 't_Vehicles';
    if ($_FILES['import_file']['name']) {
        $config['upload_path']   = './csv-import/';
        $config['allowed_types'] = 'csv';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('import_file')) {
            $fileData = $this->upload->data();
            $filePath = $fileData['full_path'];
            $data = $this->csvreader->parse_file($filePath);
			// echo '<pre>';
			// print_r( $data);
            $this->admin_model->import_vehicles_info($table_name, $data);
			$this->session->set_flashdata('message_display', '<div class="alert alert-success"> Data imported successfully </div>');            
        } else {
            $error = array('error' => $this->upload->display_errors());
			print_r($error);
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger"> There is an error while importing CSV, please try again.</div>');
        }
    }
	redirect('vehicles/vehicle');
}

	
}
?>