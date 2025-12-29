<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url' ,'user_helper'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->library('pagination');
		$this->load->helper("file");
		$this->load->helper('email');
		$this->load->library('csvimport');
	}
	public function index(){
		$data['subTitle'] = 'Dashboard';
        if(isset($this->session->userdata['login_user'])){	
                $session_data = $this->session->userdata('login_user');
                $data['user_name'] = $session_data['username'];	
                $data['total_users'] = 1;				 
                $user_email = $session_data['email'];
                $data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);	
                $this->load->view('layout/header',$data);
                $this->load->view('dashboard',$data);
                $this->load->view('layout/footer',$data);
        }else{			     
                $this->load->view('index', $data);
        }	
	}
	public function dashboard(){
		$data =array();
		$data['subTitle'] = 'Dashboard';
		$username = $this->input->post('user_name');
		$password = $this->input->post('password');	
		$data['total_users'] = 1;//$this->admin_model->get_aks_users_rows();
	
		$this->form_validation->set_rules('user_name', 'Valid Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[20]');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message_display', validation_errors());	
			redirect('index',$data);
		}
		if(isset($this->session->userdata['login_user'])){
				$session_data = $this->session->userdata('login_user');
				$data['username'] = $session_data['username'];
				$user_email = $session_data['email'];
				$data['getUsersInfo'] = $this->admin_model->usersInInfo($user_email);
				$this->load->view('layout/header',$data);
				$this->load->view('dashboard.php',$data);
				$this->load->view('layout/footer',$data);
		  }else{					
				$check_user = $this->admin_model->checkuser($username,$password);
				if($check_user == true){
                    $session_data = array('username' => $check_user[0]['user_name'], 'password' => $check_user[0]['password'],'user_type' =>  $check_user[0]['type'], 'email' => $check_user[0]['email'],'pages_access' => $check_user[0]['pages_access']);
					$this->session->set_userdata('login_user', $session_data);
					$this->load->view('layout/header',$data);
					$this->load->view('dashboard.php',$data);						
					$this->load->view('layout/footer',$data);
				}else{	
					$this->session->set_flashdata('message_display', "Sorry, your details doesn't match.");	
					redirect('index',$data);
				}
		 }
    }
    
    public function logout(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
		$data['subTitle'] = 'Manage User';
		$session_data = array('username' => '', 'password' => '');
		$this->session->unset_userdata('login_user',$session_data);
		session_destroy();
		$this->db->cache_delete_all();
		$this->load->view('index', $data);
		}else{			     
			  $this->load->view('index');
        }
	}  
	
	public function edit_users($id){
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update User';
			$data['id'] = $id;
			$data['getUsersInfo'] = $this->admin_model->getUsersInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_users', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function update_user2(){
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update User';
			$id = $this->input->post('userId');
			$password = $this->input->post('password');
			$this->form_validation->set_rules('email', 'Valid Email', 'trim|required|valid_email');
			if( $password  != ""){
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[20]');
			}
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message_display', validation_errors());	
				redirect('edit_users/'.$id);
			}	
			$update = $this->admin_model->UpdateUser();			
			$this->session->set_flashdata('message_display', 'Data updated successfully');
			redirect('edit_users/'.$id);
		}else{
			redirect('index');
		}
	}
/*------------------------------------------------ Keys Module ----------------------------------------*/

	public function keys(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > <strong>Keys</strong>';
			$config = array();
			$config["base_url"] = base_url() . "home/keys";
			$total_row = $this->admin_model->getAllKyesRows();
			$config["total_rows"] = $total_row;
			//$data['getAllMakeNames'] = $this->admin_model->getAllToolsRows();
			if(isset($this->session->userdata['keys_pagination'])){
				$per_page = $this->session->userdata['keys_pagination']; 
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
			$data["totalrows"] = $this->admin_model->getAllKyesRows();
			$data['page'] = $page;
			$_SESSION['keys_page_number'] = $page;
			if(isset($_SESSION['search_keys'])){
				unset($_SESSION['lock_types']);
				$result =   $this->admin_model->getsearchkey($_SESSION['search_keys']);	
				$data["results"] =  $this->admin_model->getsearchkey($_SESSION['search_keys']);	
				$data["totalrows"] = count($result);
			}elseif(isset($_SESSION['lock_types'])){
				if($_SESSION['lock_types'] == 'all'){
					$data["results"] = $this->admin_model->getAlkeys($config["per_page"],$limt_start);
				}else{	
				$data["results"] = $this->admin_model->getlockerfilter($_SESSION['lock_types']);
				}
			}elseif(isset($this->session->userdata['show_keysby_types'])){
				$value_key1 = $this->session->userdata['show_keysby_types'];
				$value_key =  $value_key1['key_types'];
				if($value_key == 'all'){
					$data["results"] = $this->admin_model->getAlkeys($config["per_page"],$limt_start);
				}else{
					$data["results"] = $this->admin_model->show_session_keysby_types($value_key);
				}
			}else{
				$data["results"] = $this->admin_model->getAlkeys($config["per_page"],$limt_start);
			}			
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );	
			//$data['getkeys'] = $this->admin_model->getkeys();	
			$data['getAllkeyType'] = $this->admin_model->getAllkeyType();		
			$this->load->view('layout/header',$data);
			$this->load->view('keys', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function add_key(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > <strong>Add New Key</strong>';
			$data['getkeys'] = $this->admin_model->getkeys();
			$data['getAllChips'] = $this->admin_model->getAllChips();
			$data['getAllkeyType'] = $this->admin_model->getAllkeyType();
			$data['getAllkeyBlade'] = $this->admin_model->getAllkeyBlade();
			$data['getAllkeyHead'] = $this->admin_model->getAllkeyHead();
			$this->load->view('layout/header',$data);
			$this->load->view('add_key', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function save_key(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$pre_file_name = $_FILES['key_image']['name'];			
			if(empty($pre_file_name)){
				$file_name = $this->input->post('keyimage');
			}else{
				
				$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
				$upload_folder = 'upload/';
				$config['upload_path'] = $upload_folder;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $new_file_name;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);			
				if($this->upload->do_upload('key_image')){
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
				}
			}
			$query = $this->admin_model->save_key($file_name);
			$this->session->set_flashdata('message_display', 'Data added successfully');
			redirect('home/add_key');
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	public function edit_key($id){
		$data['keyid'] = $id;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > <strong>Update Key</strong>';
			$data['getkeysInfo'] = $this->admin_model->getkeysInfo($id);
			$data['getAllChips'] = $this->admin_model->getAllChips();
			$data['getAllkeyType'] = $this->admin_model->getAllkeyType();
			$data['result'] = $this->admin_model->get_substitute_keys();
			$data['getAllkeyBlade'] = $this->admin_model->getAllkeyBlade();
			$data['getAllkeyHead'] = $this->admin_model->getAllkeyHead();			
			$this->load->view('layout/header',$data);
			$this->load->view('edit_key', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
		public function update_key(){
		$data =array();
		if(isset($_SESSION['keys_page_number'])){
		$page_id =  $_SESSION['keys_page_number'];
		}else{
			$page_id ="";
		}
		if(isset($this->session->userdata['login_user'])){
		if(!empty($_FILES['key_image']['name'])){			
			$pre_file_name = $_FILES['key_image']['name'];
			$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
			$upload_folder = 'upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('key_image')){
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}	
		}else{
			$file_name ="";
		}			
			$query = $this->admin_model->update_key($file_name);
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data updated successfully</div>');
			redirect('home/keys/'.$page_id);
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	public function delete_key($id){		
		$result = $this->admin_model->delete_key($id);	
		$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		redirect('home/keys');		
	}
	public function copy_key($id){
		$data['keyid'] = $id;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > <strong>Update Key</strong>';
			$data['getkeysInfo'] = $this->admin_model->getkeysInfo($id);
			$data['getAllChips'] = $this->admin_model->getAllChips();
			$data['getAllkeyType'] = $this->admin_model->getAllkeyType();			
			$this->load->view('layout/header',$data);
			$this->load->view('copy_key', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function show_keysby_types(){
		unset($_SESSION['lock_types']);
		$keyresult = $this->admin_model->show_keysby_types();
		if($keyresult){
			$session_data = array('key_types' => $this->input->post('typeUuid'));
			$this->session->set_userdata('show_keysby_types', $session_data);
		}else{
			$session_data = array('key_types' => '');
			$this->session->unset_userdata('show_keysby_types', $session_data);
		}
		$data['getkeys'] = $this->admin_model->show_keysby_types();
		$this->load->view('show_keysby_types',$data);	
	}
	public function show_keysby_lock_types(){
		unset($_SESSION['search_keys']);		
		$data['getkeys'] = $this->admin_model->show_keysby_types();		
		$typeUuid = $this->input->post('typeUuid');
		$locktyperesult = $this->admin_model->show_keysby_lock_types();
		if($locktyperesult){
			$_SESSION['lock_types'] = $typeUuid;
		}else{
			unset($_SESSION['lock_types']);
		}
		$data['getkeys'] = $this->admin_model->show_keysby_lock_types();
		$this->load->view('show_keysby_types',$data);	
	}
	public function search_kyes(){
		$search_key = $this->input->post('search_key');
		$result = $this->admin_model->search_kyes();
		if($result){
			$_SESSION['search_keys'] = $search_key;
			$data['getkeys'] = $this->admin_model->search_kyes();
			$this->load->view('search_kyes',$data);
		}else{
			unset($_SESSION['search_keys']);
			$data['getkeys'] = $this->admin_model->search_kyes();
			$this->load->view('search_kyes',$data);
		}
	}
	public function keys_pagination(){		
		 $session_data = array('per_page' => $this->input->post('searching'));
		 $this->session->set_userdata('keys_pagination', $session_data);
	}
	public function keys_sorting(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');		
		$data['results'] = $this->admin_model->keys_sorting();
		$this->load->view('keys_sorting',$data);	
	}
	/*================================= Keys Page Editing ================================================*/
	
	public function edit_keys_inputs(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$this->load->view('edit_keys_inputs',$data);
	}	
	
	public function keys_input_update(){
		echo $results = $this->admin_model->keys_input_update();
	}	
	
	public function edit_keys_dropbox(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['key'] = $this->input->post('key');
		$data['type'] = $this->input->post('type');
		$data['getkeys'] = $this->admin_model->getkeys();
		$data['getAllChips'] = $this->admin_model->getAllChips();
		$data['getAllkeyType'] = $this->admin_model->getAllkeyType();	
		$this->load->view('edit_keys_dropbox',$data);
	}
	
	public function keys_dropbox_update(){
		echo $results = $this->admin_model->keys_dropbox_update();
	}
/*--------------------------------------------Chips------------------------------------------------------*/

	public function Chips(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Chips';
			$config = array();
			$config["base_url"] = base_url() . "home/Chips";
			$total_row = $this->admin_model->getAllChipsRows();			
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
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );	
		if(isset($this->session->userdata['chips_filter_session'])){
			$session_data = $this->session->userdata('chips_filter_session');
			 $chip_value = $session_data['chips_filter_val'];
			$data['getAllChips'] = $this->admin_model->getAllChipsByFilter($chip_value);
		}else{
			$data['getAllChips'] = $this->admin_model->getAllChipsDetail($config["per_page"],$limt_start);
		}
		$this->load->view('layout/header',$data);
		$this->load->view('chips', $data);
		$this->load->view('layout/footer');
		}else{			     
		     $this->load->view('index', $data);
		}
	}
	public function add_chips(){
	     $data =array();
	 	if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Chips > <strong> Add New Chip</strong> ';
			$this->load->view('layout/header',$data);
			$this->load->view('add_chips');
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
			}
	}
	public function Chips_added(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			if(!empty($_FILES['profileImage']['name'])){
			$pre_file_name = $_FILES['profileImage']['name'];
			$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
			$upload_folder = 'upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('profileImage')){
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
			}else{
				$file_name ="";
			}			
			
		$add_chips = $this->admin_model->ChipsAdd($file_name);	
		if($add_chips == true){
		      $this->session->set_flashdata('message_display', 'Data added successfully');
		}else{
			$this->session->set_flashdata('message_display', 'Error in adding data! ');							 
		}							
		redirect('home/add_chips');
		}else{			     
				  $this->load->view('index', $data);
			}	
	}
	public function edit_chips($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update Chips';
			$data['id'] = $id;
			$data['getallChipsInfo'] = $this->admin_model->getallChipsInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_chips', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function Update_ChipsEdit(){
		$id ="";
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'UpdateChips';
			$data['id'] = $id;
			if(!empty($_FILES['profileImage']['name'])){
			$pre_file_name = $_FILES['profileImage']['name'];
			$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
			$upload_folder = 'upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('profileImage')){
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
			}else{
				$file_name ="";
			}
			$update = $this->admin_model->Update_ChipsEdit($file_name);
			if($update == true){
			    $this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  added successfully </div>');
			}else{
					$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Error  data updated</div>');							 
			}							
				redirect('home/Chips');
		}else{			     
				  $this->load->view('index', $data);
			}
	}
	public function deletechips($id){		
		$result = $this->admin_model->Deletechips($id);		
		if($result == 2){
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Data cannot be deleted!</div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		}
		redirect('home/Chips');	
	}
	public function show_chips_filter(){
		$value = $this->input->post('chip');
		$session_data = array('chips_filter_val' => $value);
		$this->session->set_userdata('chips_filter_session', $session_data);
		$data['sorting'] = 'DESC';
		$data['sorting_by'] = 'Chip_Name';				
		$data['getAllChips'] = $this->admin_model->show_chips_filter();
		$this->load->view('chips_sorting',$data);	
	}
	public function search_global_key(){
		$search_key = trim($this->input->post('search_global_key'));
		if($this->input->post('search') == 'chips'){
			$_SESSION['search_chips'] = $search_key;
			$data['sorting'] = '';
			$data['getAllChips'] = $this->admin_model->search_chips();
			$this->load->view('chips_sorting',$data);
		}
	}
	public function chips_sorting(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');				
		$data['getAllChips'] = $this->admin_model->chips_sorting();
		$this->load->view('chips_sorting',$data);	
	}
	/*=============================== Page Editing Functions ===============================================*/
	
	public function edit_chips_inputs(){
		$data['UUID'] = $this->input->post('uuId');
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['dataTable'] = $this->input->post('dataTable');
		$data['image'] = $this->input->post('image');
		$this->load->view('edit_chips_inputs',$data);
	}
	
	public function chips_input_update(){
		echo $results = $this->admin_model->chips_input_update();
	}
	
	public function edit_table_dropbox(){		
		$data['dataId'] = $this->input->post('dataId');
		$data['column'] = $this->input->post('column');
		$data['value'] = $this->input->post('value');
		$data['dataTable'] = $this->input->post('dataTable');
		$data['dataType'] = $this->input->post('dataType');
		$data['image'] = $this->input->post('image');
		$data['getMachinesTypes'] = $this->admin_model->getMachinesTypes();	
		$data['getallmakes'] = $this->admin_model->getallmakes();		
		$this->load->view('edit_table_dropbox',$data);
	}
	
	public function table_dropbox_update(){
		echo $results = $this->admin_model->table_dropbox_update();
	}
/*---------------------------------------- Key Blade-----------*/
	public function key_blade(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Key Blade';
			$config = array();
			$config["base_url"] = base_url() . "home/key_blade";
			$total_row = $this->admin_model->getAllKeyBladeRows();			
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
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );	
			$data['getAllKeyBladeDetail'] = $this->admin_model->getAllKeyBladeDetail($config["per_page"],$limt_start);
			$this->load->view('layout/header',$data);
			$this->load->view('key_blade', $data);
			$this->load->view('layout/footer');
		}else{			     
		     $this->load->view('index', $data);
		}
		
	}
	public function add_key_blade(){
		 $data =array();
	 	if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Key Blade > <strong> Add New Key Blade</strong> ';
			$this->load->view('layout/header',$data);
			$this->load->view('add_key_blade');
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
			}
	}
	public function save_key_blade(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			if(!empty($_FILES['image']['name'])){
				$pre_file_name = $_FILES['image']['name'];
				$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
				$upload_folder = 'upload/';
				$config['upload_path'] = $upload_folder;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $new_file_name;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);			
				if($this->upload->do_upload('image')){
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
				}	
			}else{
				$file_name ="";
			}			
			
		$add_chips = $this->admin_model->save_key_blade($file_name);	
		if($add_chips == true){
		      $this->session->set_flashdata('message_display', 'Data added successfully');
		}else{
			$this->session->set_flashdata('message_display', 'Error in adding data! ');							 
		}							
		redirect('home/add_key_blade');
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	public function edit_key_blade($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update Key Blade';
			$data['id'] = $id;
			$data['getallKeysBladeInfo'] = $this->admin_model->getallKeysBladeInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_key_blade', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function update_key_blade(){
		$data =array();
		$data['subTitle'] = 'UpdateChips';
			$id =  $this->input->post('keyBladeId');
			if(!empty($_FILES['image']['name'])){
				$pre_file_name = $_FILES['image']['name'];
				$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
				$upload_folder = 'upload/';
				$config['upload_path'] = $upload_folder;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $new_file_name;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);			
				if($this->upload->do_upload('image')){
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
				}
			}else{
				$file_name ="";
			}
			$update = $this->admin_model->update_key_blade($file_name,$id);
			if($update == true){
			    $this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  updated successfully</div>');
					redirect('home/key_blade');
			}else{
					$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Error  data updated</div>');
				 redirect('home/edit_key_blade/'.$id);					
			}							
				
	}
	public function deletekeyblade($id){
		$result = $this->admin_model->deletekeyblade($id);		
		if($result == 2){
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Data cannot be deleted!</div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		}
		redirect('home/key_blade');	
	}
/*---------------------------------------- Key Head-----------*/
	public function key_head(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Key Head';
			$config = array();
			$config["base_url"] = base_url() . "home/key_head";
			$total_row = $this->admin_model->getAllKeyHeadRows();			
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
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );	
			$data['getAllKeyHeadDetail'] = $this->admin_model->getAllKeyHeadDetail($config["per_page"],$limt_start);
			$this->load->view('layout/header',$data);
			$this->load->view('key_head', $data);
			$this->load->view('layout/footer');
		}else{			     
		     $this->load->view('index', $data);
		}
	}
	public function add_key_head(){
		$data =array();
	 	if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Key Head > <strong> Add New Key Head</strong> ';
			$this->load->view('layout/header',$data);
			$this->load->view('add_key_head');
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function save_key_head(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			if(!empty($_FILES['image']['name'])){
				$pre_file_name = $_FILES['image']['name'];
				$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
				$upload_folder = 'upload/';
				$config['upload_path'] = $upload_folder;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $new_file_name;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);			
				if($this->upload->do_upload('image')){
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
				}
			}else{
				$file_name ="";
			}				
			
		$add_chips = $this->admin_model->save_key_head($file_name);	
		if($add_chips == true){
		      $this->session->set_flashdata('message_display', '<div class="alert alert-info">Data added successfully</div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Error in adding data!</div> ');							 
		}							
			redirect('home/key_head');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function edit_key_head($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update Key Head';
			$data['id'] = $id;
			$data['getallKeysHeadInfo'] = $this->admin_model->getallKeysHeadInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_key_head', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('index');
		}
	}
	public function update_key_Head(){
		$data =array();
		$data['subTitle'] = 'UpdateChips';
			$id =  $this->input->post('keyHeadId');
			if(!empty($_FILES['image']['name'])){
			$pre_file_name = $_FILES['image']['name'];
			$new_file_name = str_replace(' ', '_'.date('m-d'), $pre_file_name);
			$upload_folder = 'upload/';
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $new_file_name;
			$config['overwrite'] = FALSE;
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);			
			if($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
			}else{
				$file_name ="";
			}
			$update = $this->admin_model->update_key_Head($file_name,$id);
			if($update == true){
			    $this->session->set_flashdata('message_display', '<div class="alert alert-info">Data updated successfully</div>');
					redirect('home/key_head');
			}else{
					$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Error  data updated</div>');
				 redirect('home/edit_key_head/'.$id);					
			}			
	}
	public function deletekeyhead($id){
		$result = $this->admin_model->deletekeyhead($id);		
		if($result == true){
			$this->session->set_flashdata('message_display', '<div class="alert alert-success">Data deleted successfully</div>');
		}else{
			$this->session->set_flashdata('message_display', '<div class="alert alert-danger">Data cannot be deleted!</div>');
		}
		 redirect('home/key_head');	
	}
/*----------------------------------------------------------Key Type ----------------------------*/


	public function keyType(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
		$data['subTitle'] = 'Parts ><strong> Key Types</strong>';
		$data['getAllkeyType'] = $this->admin_model->getAllkeyType();
		$this->load->view('layout/header',$data);
		$this->load->view('key_type', $data);
		$this->load->view('layout/footer');
		}else{			     
		     $this->load->view('index', $data);
		}
	}
	public function addKeytype(){
	     $data =array();
	 	if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Parts > Key Types ><strong> Add New Key Type</strong>';
			$this->load->view('layout/header',$data);
			$this->load->view('add_key_type');
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function keyTypeAdd(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){	
		$add_name = $this->admin_model->keyTypeAdd();	
		if($add_name == true){
		      $this->session->set_flashdata('message_display', 'Data added successfully');
		}else{
			$this->session->set_flashdata('message_display', 'Error in adding user! ');							 
		}							
		redirect('home/addKeytype');
		}else{			     
				  $this->load->view('index', $data);
			}	
		}
	public function edit_keytype($id){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Parts > Key Types > <strong>Update Key Type</strong>';
			$data['id'] = $id;
			$data['getKeyTypeInfo'] = $this->admin_model->getKeyTypeInfo($id);
			$this->load->view('layout/header',$data);
			$this->load->view('edit_keytype', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('admpro/index');
		}
	}
	public function update_keytype(){
		$id ="";
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update Key Type';
			$data['id'] = $id;
			$update = $this->admin_model->update_keytype();
			if($update == true){
			 		$this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  added successfully </div>');
			}else{
					$this->session->set_flashdata('message_display', '<div class="alert alert-danger"> Name already exits</div>');							 
			}							
				redirect('home/keyTYpe');
		}else{			     
			  $this->load->view('index', $data);
			}
	}
	public function deletekeytype($id){
		$this->session->set_flashdata('message_display','<div class="alert alert-success">Data deleted successfully </div>');
		$result = $this->admin_model->deletetypekey($id);	
		redirect('home/keyType');	
	}
	public function key_type_sorting(){
		$data['sorting'] = $this->input->post('sorting');
		$data['sorting_by'] = $this->input->post('sorting_by');		
		$data['getAllkeyType'] = $this->admin_model->key_type_sorting();
		$this->load->view('key_type_sorting',$data);	
	}

	public function import_xls(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Nitro Scan Tool > <strong>Import Xls</strong>';
			$data['function_tables'] = $this->admin_model->function_tables();
			$this->load->view('layout/header',$data);
			$this->load->view('import_xls', $data);
			$this->load->view('layout/footer');
		}else{
			redirect('admpro/index');
		}
	}
	public function save_import_file(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Update Key Type';
			//print_r($_FILES);
			if($_FILES["file"]["size"] > 0){
				$filename = $_FILES["file"]["tmp_name"];
				$table_name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
				$check_if_tble_exists = $this->admin_model->check_if_tble_exists($table_name);				
				$file = fopen($filename, "r");
				$fields_name = fgetcsv($file, 10000, ",");
				$fields = array();
				$field_count = 0;
				$fields_name_data = "";
				for($i=0;$i<count($fields_name); $i++) {
					$f = strtolower(trim($fields_name[$i]));
					if ($f) {
						$f = substr(preg_replace ('/[^0-9a-z]/', '_', $f), 0, 20);
						$f = rtrim($f,'_');
						$f = ltrim($f,'_');
						$field_count++;
						if($f == ""){
							$fields[] = 'col_'.$i.' VARCHAR(500)';
							$f = 'col_'.$i;
						}else{
							$fields[] = $f.' VARCHAR(500)';
						}						
						$fields_name_data .= $f.',';
					}
				}
				$fields_name_data = rtrim($fields_name_data,',');
				$field_count = count($fields);
				if($check_if_tble_exists === 'false'){				
					$create_table = $this->admin_model->create_import_table($table_name, $fields);
					$s = 0;
					while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
						$data = "";
						for($i=0;$i<count($emapData); $i++) {
							if($field_count == $i){}else{
								if($emapData[$i] == '√'){
									$emapData[$i] = 'Yes';
								}
								$data .= "'".addslashes($emapData[$i])."',";
							}							
						}
						$data2 = rtrim($data,',');
						$insert_table_data = $this->admin_model->insert_table_data($table_name,$data2,$fields_name_data);
					}
				}else{
					$empty_table = $this->admin_model->empty_import_table($table_name);
					$s = 0;
					while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
						$data = "";
						for($i=0;$i<count($emapData); $i++) {
							if($field_count == $i){}else{
								if($emapData[$i] == '√'){
									$emapData[$i] = 'Yes';
								}
								$data .= "'".addslashes($emapData[$i])."',";
							}							
						}
						$data2 = rtrim($data,',');
						$insert_table_data = $this->admin_model->insert_table_data($table_name,$data2,$fields_name_data);
					}
				}
				fclose($file);
				$this->session->set_flashdata('message_display', '<div class="alert alert-info">Data  added successfully </div>');
				redirect('home/import_xls');
			}else{
				$this->session->set_flashdata('message_display', '<div class="alert alert-info">Invalid File:Please Upload XLS File</div>'); 
				redirect('home/import_xls');
			}		
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function export_csv(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){			
			$data['subTitle'] = '<strong>Export CSV</strong>';
			$this->load->view('layout/header',$data);
			$this->load->view('export_csv', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	public function export_vehicles_info(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){			
			$data['subTitle'] = '<strong>Update Users With AKS</strong>';
			$data['getAllVehiclesDataCSV'] = $this->admin_model->getAllVehiclesDataCSV();
			$this->load->view('export_vehicles_info', $data);
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function export_product_info(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){			
			$data['subTitle'] = '<strong>Export CSV</strong>';
			$this->load->view('layout/header',$data);
			$this->load->view('export_product_info', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}	
	}
	public function export_all_product_info_table(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){		
			$data['getAllVehiclesDataCSV'] = $this->admin_model->export_all_product_info_table();			
			$this->load->view('export_all_product_info_table', $data);
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function import_product_info_to_database(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){		
			$data['subTitle'] = 'Parts > <strong>Import Keys to Database</strong>';
			$data = $this->admin_model->import_product_info_to_database();			
			if($data == 1){
				$this->session->set_flashdata('import_msg','The imported file has been imported successfully. ');
				redirect('home/export_product_info', $data);
			}else if($data == 0){
				$this->session->set_flashdata('error_import_msg','The imported file has been not imported successfully ');
				redirect('home/export_product_info', $data);
			}				
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function export_all_product_detail_table(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){		
			$data['getAllProductDetailCSV'] = $this->admin_model->export_all_product_detail_table();			
			$this->load->view('export_all_product_detail_table', $data);
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function import_product_detail_to_database(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){			
			$data = $this->admin_model->import_product_detail_to_database();
			if($data == 1){
				$this->session->set_flashdata('prod_detail_import_msg','The imported file has been imported successfully. ');
				redirect('home/export_product_info', $data);	
			}else if($data == 0){
				$this->session->set_flashdata('prod_detail_error_import_msg','The imported file has been not imported successfully ');
				redirect('home/export_product_info', $data);	
			}else{
				redirect('home/export_product_info', $data);	
			}
						
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function firebase_api(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Firebase';
			$this->load->view('layout/header',$data);
			$this->load->view('firebase_api', $data);
			$this->load->view('layout/footer');				
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function firebase_api_update(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){		
			$this->load->view('firebase_api_update', $data);
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function bulletin_board(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Bulletin Board';
			$data['result'] = $this->admin_model->bulletin_board_data();		
			$this->load->view('layout/header',$data);
			$this->load->view('bulletin_board', $data);
			$this->load->view('layout/footer');				
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_bulletin_board(){
		$query = $this->admin_model->save_bulletin_board();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('home/bulletin_board');
	}
/*--------------------------------- Multiple Admins ---------------------------------*/
	public function admins(){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Admins';				
			$data['results'] = $this->admin_model->admins();						
			$this->load->view('layout/header',$data);
			$this->load->view('admins', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function add_admins($us_id = ""){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['subTitle'] = 'Add Admin';						
			$this->load->view('layout/header',$data);
			$this->load->view('add_admins', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}

	public function save_admins(){
		$query = $this->admin_model->save_admins();
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('home/admins');
	}

	public function edit_admins($id){
		$data = array();;
		if(isset($this->session->userdata['login_user'])){	
			$data['id'] = $id;
			$data['subTitle'] = 'Update Admin';	
			$data['result'] = $this->admin_model->admins_info($id);					
			$this->load->view('layout/header',$data);
			$this->load->view('edit_admins', $data);
			$this->load->view('layout/footer');
		}else{			     
			$this->load->view('index', $data);
		}
	}
	public function update_admins($id){
		$query = $this->admin_model->update_admins($id);
		$this->session->set_flashdata('message_display', 'Data added successfully');
		redirect('home/admins');
	}

	public function delete_admins($id){
		$result = $this->admin_model->delete_admins($id);	
		$this->session->set_flashdata('message_display', 'Data deleted successfully');
		redirect('home/admins');	
	}

	public function firebase_export_csv(){
		$data =array();
		if(isset($this->session->userdata['login_user'])){
			$data['subTitle'] = 'Firebase';
			$this->load->view('firebase_export_csv', $data);			
		}else{			     
			$this->load->view('index', $data);
		}
	}
	
}
