<?php
$user_data = $this->session->userdata('login_user');
$user_username = $user_data['username'];
$email = $user_data['email'];
$get_admin_deatils = get_admin_deatils($email);
$user_type = $get_admin_deatils[0]['type'];
$userId = $get_admin_deatils[0]['UserID'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo str_replace('>','|', strip_tags($subTitle));?> | AutoProPad Admin</title>
    <!-- Bootstrap -->
    <link href="<?php echo asset_url(); ?>admin/css/futurico.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>admin/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo asset_url(); ?>admin/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>admin/css/app.css" rel="stylesheet" type="text/css">
    
	  <link href="<?php echo asset_url(); ?>admin/css/style.css?v=<?php echo time();?>" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo asset_url(); ?>admin/js/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo asset_url(); ?>admin/js/bootstrap.min.js"></script>
  </head>
 <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" id="site-nav">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo adm_base_url();?>/dashboard" title="AutoPro"><img src="<?php echo asset_url(); ?>admin/images/logo.png" alt="AutoPro"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        	<div class="nav navbar-nav">
            	<h1 class="pg-heading1"><?php echo $subTitle;?></h1>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <p>Logged in as <?php echo $user_username;?></p>
			        <!-- <a href="<?php echo adm_base_url();?>clear_cache" title="Account">Clear Cache</a>  -->
              <!-- <i class="spritor">|</i> -->
              <a href="<?php echo adm_base_url();?>edit_users/<?php echo $userId;?>" title="Account">Account</a> 
              <i class="spritor">|</i> 
              <a href="<?php echo adm_base_url();?>logout" title="Sign Out">Sign Out</a>
          </ul>
       </div>
      </div>
    </nav>
<?php 
$get_url = explode('/',$_SERVER["REQUEST_URI"]);
$get_last = explode('?',$get_url[count($get_url)-1]);
$url = $get_last[0];
?>
    <!--site nav end here-->
    <!--site main-con start here-->
    <main id="main-con">
    	<div class="container-fluid">
        <!--sidebar start here-->
          <section class="sidebar">
             <ul class="nav nav-sidebar"> 
             <li class="<?php echo ($url == 'index' )|| ($url=='dashboard')?'active':"";?>">
                <a href="<?php echo adm_base_url();?>dashboard" title="Vehicles " >Dashboard</a>
             </li>              
             <li>
                	<a title="Vehicles" href="#collapsedropdown5" aria-expanded="false" aria-controls="collapsedropdown5" data-toggle="collapse">Vehicles
                     <span class="glyphicon glyphicon-triangle-bottom pull-right"  href="#collapsedropdown5" aria-expanded="false" aria-controls="collapsedropdown5"></span>
                   </a>
                   <ul class="collapse <?php echo ($url == 'transponder_keys' ) ||($url == 'programmer_information' ) ||($url == 'machanical_keys' ) ||($url == 'makes' ) || ($url == 'add_makes') || ($url == 'model') || ($url =='add_model' ) || ($url =='codeseries') || ($url=='add_code')||($url == 'retainers' )||($url=='add_retainer')||($url=='vehicle')||($url=='add_vehicle')||($url=='obp_options')|| ($url=='add_obp_option')||($url == 'obp_options_categories' )|| ($url=='add_obp_options_categories')||($url=='obp_remotes')||($url=='add_obp_remotes')||($url == 'vehicle_types' )||($url == 'add_vehicle_type')||($url == 'keymaking_methods')||($url=='add_method')||($url=='tip_tricks')||($url == 'vehicle_images' )|| ($url=='add_vehicles_images')?'in':"";?>" id="collapsedropdown5">
                     
                        <li class="<?php echo ($url == 'vehicle' )|| ($url=='add_vehicle')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/vehicle" title="Vehicles " >Vehicles</a>
                        </li>                   
                        
                        <li class="<?php echo ($url == 'makes' )|| ($url=='add_makes')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/makes" title="Makes">Makes</a>
                        </li>
                        <li class="<?php echo ($url == 'model' )|| ($url=='add_model')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/model" title="Model">Models</a>
                        </li> 
                        <li class="<?php echo ($url=='machanical_keys')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/machanical_keys" title="Mechanical">Mechanical Keys</a>
                        </li> 
                        <li class="<?php echo ($url=='transponder_keys')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/transponder_keys" title="Transponder">Transponder Keys</a>
                        </li> 
                        <li class="<?php echo  ($url=='programmer_information')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>vehicles/programmer_information" title="Programmer">Programmer Info</a>
                        </li> 

                    </li> 
						
                   </ul>
                 </li>
					      <li class="separator">
                	<a title="Parts" href="#collapsedropdown2" aria-expanded="false" aria-controls="collapsedropdown2" data-toggle="collapse">
                      Parts
                     <span class="glyphicon glyphicon-triangle-bottom pull-right"  href="#collapsedropdown2" aria-expanded="false" aria-controls="collapsedropdown2"></span>
                   </a>
                   <ul class="collapse <?php echo ($url == 'keyStyle' )|| ($url == 'Chips')|| ($url == 'keyType')|| ($url == 'addKeytype')|| ($url == 'addKeyStyle')|| ($url == 'add_chips')||($url=='add_key_blade')||($url=='key_blade')||($url=='keys')||($url=='add_key')||($url=='key_head')||($url=='add_key_head')||($url=='remote_types')||($url=='add_remote_type')||($url == 'buttons')||($url=='add_buttons') || ($url == 'locks_types')||($url=='add_part_types')||($url == 'locks')||($url=='add_parts')?'in':"";?>" id="collapsedropdown2">
                   		 
                        <li class="<?php echo ($url == 'keys')||($url=='add_key')?'active':"";?>"><a href="<?php echo adm_base_url();?>home/keys" title="Keys">Keys</a></li>   
                                  
                      <li class="<?php echo ($url == 'add_chips')||($url=='Chips')?'active':"";?>">
                                    <a href="<?php echo adm_base_url();?>home/Chips" title="Chips">Chips</a></li>
                      
                      <li class="<?php echo ($url == 'keyType')||($url=='addKeytype')?'active':"";?>">
                                    <a href="<?php echo adm_base_url();?>home/keyType" title="key Type">Key Type</a></li>
                      
                      <li class="<?php echo ($url == 'add_key_blade')||($url=='key_blade')?'active':"";?>">
                                    <a href="<?php echo adm_base_url();?>home/key_blade" title="Key Blade">Key Blade</a></li>

                      <li class="<?php echo ($url == 'add_key_head')||($url=='key_head')?'active':"";?>">
                            <a href="<?php echo adm_base_url();?>home/key_head" title="Key Head">Key Head</a></li>
                    </ul>
                </li>
                <li class="<?php echo  ($url=='bulletin_board')?'active':"";?>">
                    <a href="<?php echo adm_base_url();?>home/bulletin_board" title="Bulletin Board " >Bulletin Board</a>
                </li>
                <li class="<?php echo  ($url=='export_product_info')?'active':"";?>">
                    <a href="<?php echo adm_base_url();?>home/export_product_info" title="Product Info " >Export Product Info</a>
                </li> 
                <li class="<?php echo  ($url=='firebase_api')?'active':"";?>">
                  <a href="<?php echo adm_base_url();?>home/firebase_api" title="Firebase" >Firebase API</a>
                </li>
                <li class="<?php echo  ($url=='admins')?'active':"";?>">
                  <a href="<?php echo adm_base_url();?>home/admins" title="Firebase" ><i class="glyphicon glyphicon-user" aria-hidden="true"></i> Admins</a>
                </li>
                <!----------------- Logs--------------------------------- -->
                <li class="separator">
                  <a title="Parts" href="#collapsedropdownLogs" aria-expanded="false" aria-controls="collapsedropdownLogs" data-toggle="collapse">
                        Activity Logs
                      <span class="glyphicon glyphicon-triangle-bottom pull-right"  href="#collapsedropdownLogs" aria-expanded="false" aria-controls="collapsedropdownLogs"></span>
                  </a>
                  <ul class="collapse <?php echo ($url == 't_vehicles_logs' )|| ($url == 't_make_logs' )|| ($url == 't_model_logs' )|| ($url == 'mechanical_key_information_logs' )|| ($url == 'transponder_key_information_logs' )|| ($url == 'programmer_information_logs' )|| ($url == 't_keys_logs' )|| ($url == 't_chips_logs' )|| ($url == 't_key_types_logs' )|| ($url == 't_key_blade_logs' )|| ($url == 't_key_head_logs' )|| ($url == 't_vehicles_logs' )|| ($url == 't_vehicles_logs' )?'in':"";?>" id="collapsedropdownLogs">                     
                      <li class="<?php echo ($url == 't_vehicles_logs' )?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_vehicles_logs" title="Vehicles " >Vehicles Logs</a>
                      </li>                         
                      <li class="<?php echo ($url == 't_make_logs' )?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_make_logs" title="Makes">Makes Logs</a>
                      </li>
                      <li class="<?php echo ($url == 't_model_logs' )?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_model_logs" title="Model">Models Logs</a>
                      </li> 
                      <li class="<?php echo ($url=='mechanical_key_information_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/mechanical_key_information_logs" title="Mechanical">Mechanical Keys Logs</a>
                      </li> 
                      <li class="<?php echo ($url=='transponder_key_information_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/transponder_key_information_logs" title="Transponder">Transponder Keys Logs</a>
                      </li> 

                      <li class="<?php echo  ($url=='t_keys_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_keys_logs" >Part> Key Logs</a>
                      </li> 
                      <li class="<?php echo  ($url=='t_chips_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_chips_logs" >Part> Chip Logs</a>
                      </li> 
                      <li class="<?php echo  ($url=='t_key_types_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_key_types_logs" >Part> Key Type Logs</a>
                      </li> 
                      <li class="<?php echo  ($url=='t_key_blade_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_key_blade_logs" >Part> Key Blade Logs</a>
                      </li> 
                      <li class="<?php echo  ($url=='t_key_head_logs')?'active':"";?>">
                          <a href="<?php echo adm_base_url();?>vehicles/activity_logs/t_key_head_logs" >Part> Key Head Logs</a>
                      </li>						
                  </ul>
                </li>
            </ul>
            <!-- <p class="affix affix-bottom">
                © <?php echo date('Y');?><br>
                American Key Supply, Inc.<br>
                All rights reserved.<br>
            </p> -->
          </section>
         <!--sidebar start here--> 
         <div class="loading hide"></div>
         <div class="hide" id="loader"></div>
         <div class="updatingLoading hide">
           <div class="progress" style="margin: 10px 10px 10px 200px;">
              <div id="myBar" class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
         </div>
<?php
$currentURL = uri_string();
$pages_access = $user_data['pages_access'];
if($pages_access !=""){
  $users_access_pages = json_decode($pages_access,true); 
}else{
  $users_access_pages = array(); 
}                            
//print_r($users_access_pages);
$user_type = $user_data['user_type'];

if(in_array('vehicles/vehicle', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/edit_vehicles", "vehicles/copy_vehicle","vehicles/add_vehicle");
}
if(in_array('vehicles/makes', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/add_makes", "vehicles/edit_MakeName");
}
if(in_array('vehicles/model', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/add_model", "vehicles/edit_model");
}
if(in_array('vehicles/machanical_keys', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/add_machanical_keys", "vehicles/edit_machanical_keys");
}
if(in_array('vehicles/transponder_keys', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/add_transponder_keys", "vehicles/edit_transponder_keys");
}
if(in_array('vehicles/programmer_information', $users_access_pages)){ 
  array_push($users_access_pages, "vehicles/add_programmer_information", "vehicles/edit_programmer_information");
}
if(in_array('home/keys', $users_access_pages)){ 
  array_push($users_access_pages, "home/add_key", "home/edit_key","home/copy_key");
}
if(in_array('home/Chips', $users_access_pages)){ 
  array_push($users_access_pages, "home/add_chips", "home/edit_chips");
}
if(in_array('home/keyType', $users_access_pages)){ 
  array_push($users_access_pages, "home/addKeytype", "home/edit_keytype");
}
if(in_array('home/key_blade', $users_access_pages)){ 
  array_push($users_access_pages, "home/add_key_blade", "home/edit_key_blade");
}
if(in_array('home/key_head', $users_access_pages)){ 
  array_push($users_access_pages, "home/add_key_head", "home/edit_key_head");
}
if(in_array('home/admins', $users_access_pages)){ 
  array_push($users_access_pages, "home/add_admins", "home/edit_admins");
}
//print_r($users_access_pages);
$currentURL = preg_replace("/[0-9]/", "", $currentURL);
echo $currentURL = rtrim($currentURL,'/');
if(($currentURL =="index" || $currentURL =="dashboard")){
}elseif($user_type > 0 && !in_array($currentURL, $users_access_pages)){
  echo '<h2 style="padding-left: 30px;margin-left: 12%;">You do not have permission to access this page!</h2>';
  die();
}
?>