<?php
$all_vehciles = get_Firebase_vehicles_year_vehicleInfo1();
$vehicle_info_array = array();	
foreach($all_vehciles as $vehciles){
    $mach_keys_uuids = array();
    if($vehciles['Mechanical_Key_UUID'] ==""){
        $mach_keys_uuids[]=  array('Name' => 'Coming Soon', 'information'=>'N/A');
    }else{								
        $mach_keys_array = explode(',',$vehciles['Mechanical_Key_UUID']);        
        for($i = 0; $i < count($mach_keys_array); $i++ ){
            $information = array();
            $get_key_name = get_key_name($mach_keys_array[$i]);
            $get_machkey_info = get_machkey_info($get_key_name[0]['Key_Name']);
            if(count($get_machkey_info) > 0){
                $information[] = array('CodeSeries' =>$get_machkey_info[0]['code_series'],
                                    'Depths' =>$get_machkey_info[0]['depth'],
                                    'Ignition' =>$get_machkey_info[0]['ignition'],
                                    'MACS' =>$get_machkey_info[0]['macs'],
                                    'Spaces' =>$get_machkey_info[0]['spaces'],
                                    'Reserved' =>$get_machkey_info[0]['reserved'],
                                    'image' => $get_machkey_info[0]['image'],
                                );
            }
            $mach_keys_uuids[] =  array('Name' => $get_key_name[0]['Key_Name'],'information'=>$information);
        }
    }

    $transponder_chip_keys_uuids = array();
    if($vehciles['Chip_Key_UUID'] ==""){
        $transponder_chip_keys_uuids=  array('Name' => 'Coming Soon', 'information'=>'N/A');
    }else{								
        $transponder_chip_keys_array = explode(',',$vehciles['Chip_Key_UUID']);
        $information = array();
        for($i = 0; $i < count($transponder_chip_keys_array); $i++ ){
            $information = array();
            $get_key_name = get_key_name($transponder_chip_keys_array[$i]);
            if($get_key_name[0]['Key_Name'] !=""){
                $get_machkey_info = get_transkey_info($get_key_name[0]['Key_Name']);
                if(count($get_machkey_info) > 0){
                    $information[] = array('chip' =>$get_machkey_info[0]['chip'],
                                        'Reuseable' =>$get_machkey_info[0]['reuseable'],
                                        'Cloneable' =>$get_machkey_info[0]['cloneable'],
                                        'Test Blade' =>$get_machkey_info[0]['test_blade'],
                                        'Reserved' =>$get_machkey_info[0]['reserved'],
                                        'image' => $get_machkey_info[0]['image'],
                                    );
                }
                $transponder_chip_keys_uuids =  array('Name' => $get_key_name[0]['Key_Name'],'information'=>$information); 
            }  
        }//end for     
    }
    $programmer_information = programmer_information($vehciles['Make_Name'],$vehciles['Model_Name'],$vehciles['Years']);
    $vehicle_info_array[$vehciles['id']] = array('Make' =>  $vehciles['Make_Name'],
                                'Model' =>  $vehciles['Model_Name'],
                                'Year' =>  $vehciles['Years'],
                                'Generation Name' =>  $vehciles['Generation_Name'],
                                'Generation Year Range' =>  $vehciles['Generation_YearRange'],
                                'Keyed Ignition' =>  $vehciles['Keyed_Ignition'],
                                'Keyed Ignition Year Range' =>  $vehciles['Keyed_IgnitionYear'],
                                'Push to Start' =>  $vehciles['Push_Start'],
                                'Push to Start Year Range' =>  $vehciles['Push_StartYear'],
                                'Mechanical Keys' =>  $mach_keys_uuids,
                                'Transponder Key Chip' => $transponder_chip_keys_uuids,
                                'Key Programming Machine LITE' =>  $programmer_information[0]['LITE'],
                                'Key Programming Machine FULL' =>  $programmer_information[0]['FULL'],
                                'Key Programming Machine BASIC' =>  $programmer_information[0]['BASIC'],
                                'Key Programming Machine G2' =>  $programmer_information[0]['G2'],
                                'Key Programming Machine G2T' =>  $programmer_information[0]['G2T'],
                                'Key Programming Machine CORE' =>  $programmer_information[0]['CORE'],
                                'Key Programming Machine EVOLUTION' =>  $programmer_information[0]['EVOLUTION'],
                                'Key Programming Machine PRIME' =>  $programmer_information[0]['PRIME'],
                                'Key Programming Machine RESERVED' =>  $programmer_information[0]['RESERVED'],
                                'Key Programming Add Keys' =>  $vehciles['APP_Add_Keys'],
                                'Key Programming All Keys Lost' =>  $vehciles['APP_All_Keys_Lost'],
                                'Key Programming Notes' =>  $vehciles['APP_Notes'],
                                'Key Programming System' =>  $vehciles['APP_System'],
                                'Key Programming Reserved' =>  $vehciles['Key_ProgrammingReserved'],
                                'Vehicle System' =>  $vehciles['Vehicle_System'],

                            );
}
// echo '<pre>';
// print_r($vehicle_info_array);

if( count($vehicle_info_array) > 0){                
    $data = json_encode($vehicle_info_array);				
    $options['auth'] = '4767WlHwndShZCOUszcVj55BrA8O9nEJpFOl63xc';//'PomxyBl1zWE3q6fUAlVL6BhpntIWGwFmD47NlWbe';						
    $cSession = curl_init(); 				
    //curl_setopt($cSession,CURLOPT_URL,"https://autoproapp2017.firebaseio.com/vehicle1.json?". http_build_query($options));
    curl_setopt($cSession,CURLOPT_URL,"https://supported-vehicle-default-rtdb.firebaseio.com/vdata.json?". http_build_query($options));
    curl_setopt($cSession, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));	
    curl_setopt($cSession, CURLOPT_CUSTOMREQUEST, "PATCH");						
    curl_setopt($cSession, CURLOPT_POSTFIELDS,$data); 
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);	
    curl_setopt($cSession,CURLOPT_SSL_VERIFYPEER,false);
    $result_output = curl_exec($cSession);
    $httpcode = curl_getinfo($cSession, CURLINFO_HTTP_CODE);
    //print_r($result_output);						
    $curl_error = curl_error($cSession);
    if( $httpcode == 200){
        header("Location: https://supportedvehicles.com/vh-admin/home/firebase_api");
    }else if( $httpcode == 400){
        echo 'HTTP 400 Bad Request, please try again';
    }else if( !empty($curl_error)){
        echo $curl_error;
    }else{
        echo 'Something went wrong, please try again';
    }						
    curl_close($cSession);
}else{
    header("Location: https://supportedvehicles.com/vh-admin/home/firebase_api");
}

?>
