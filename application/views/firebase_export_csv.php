<?php
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=firebase_export_csv'.date('m-d-y').'.csv');  
$output = fopen("php://output", "w"); 
$column[] = 'ID';
$column[] = 'Make';
$column[] = 'Model';
$column[] = 'Year';
$column[] = 'Generation Name';
$column[] = 'Generation Year Range';
$column[] = 'Keyed Ignition';
$column[] = 'Keyed Ignition Year Range';
$column[] = 'Push to Start';
$column[] = 'Push to Start Year Range';

$column[] = 'Mechanical Keys';
$column[] = 'Mechanical KeysImg';
$column[] = 'Mechanical Keys- CodeSeries';
$column[] = 'Mechanical Keys- Depths';
$column[] = 'Mechanical Keys- Ignition';
$column[] = 'Mechanical Keys- MACS';
$column[] = 'Mechanical Keys- Spaces';
$column[] = 'Mechanical Keys- Reserved';

$column[] = 'Transponder Key';
$column[] = 'Transponder Key-Img';
$column[] = 'Transponder Key-chip';
$column[] = 'Transponder Key-Reuseable';
$column[] = 'Transponder Key-Cloneable';
$column[] = 'Transponder Key-Test Blade';
$column[] = 'Transponder Key-Reserved';

$column[] = 'Key Programming Machine LITE';
$column[] = 'Key Programming Machine FULL';
$column[] = 'Key Programming Machine BASIC';
$column[] = 'Key Programming Machine G2';
$column[] = 'Key Programming Machine G2T';
$column[] = 'Key Programming Machine CORE';
$column[] = 'Key Programming Machine EVOLUTION';
$column[] = 'Key Programming Machine PRIME';
$column[] = 'Key Programming Machine RESERVED';
$column[] = 'Key Programming Add Keys';
$column[] = 'Key Programming All Keys Lost';
$column[] = 'Key Programming Notes';
$column[] = 'Key Programming System';
$column[] = 'Key Programming Reserved';
$column[] = 'Vehicle System';
fputcsv($output,$column);

$all_vehciles = get_Firebase_vehicles_year_vehicleInfo1();
$vehicle_info_array = array();	
$data = array();
foreach($all_vehciles as $vehciles){
    $mach_keys_uuids = '';
    $code_series ='';
    $depth = '';
    $ignition = '';
    $macs = '';
    $spaces = '';
    $reserved = '';
    $mach_image = '';
    if($vehciles['Mechanical_Key_UUID'] ==""){
        $mach_keys_uuids ='Coming Soon';
        $get_machkey_info = get_machkey_info($mach_keys_uuids);
        if(count($get_machkey_info) > 0){
            $code_series = $get_machkey_info[0]['code_series'].',';
            $depth = $get_machkey_info[0]['depth'].',';
            $ignition = $get_machkey_info[0]['ignition'].',';
            $macs = $get_machkey_info[0]['macs'].',';
            $spaces = $get_machkey_info[0]['spaces'].',';
            $reserved = $get_machkey_info[0]['reserved'].',';
            $mach_image = $get_machkey_info[0]['image'].' ';
        }
    }else{								
        $mach_keys_array = explode(',',$vehciles['Mechanical_Key_UUID']);        
        for($i = 0; $i < count($mach_keys_array); $i++ ){
            $information = array();
            $get_key_name = get_key_name($mach_keys_array[$i]);
            if($get_key_name[0]['Key_Name'] !=""){
                $get_machkey_info = get_machkey_info($get_key_name[0]['Key_Name']);
                if(count($get_machkey_info) > 0){
                    $code_series .= $get_machkey_info[0]['code_series'].',';
                    $depth .= $get_machkey_info[0]['depth'].',';
                    $ignition .= $get_machkey_info[0]['ignition'].',';
                    $macs .= $get_machkey_info[0]['macs'].',';
                    $spaces .= $get_machkey_info[0]['spaces'].',';
                    $reserved .= $get_machkey_info[0]['reserved'].',';
                    $mach_image .= $get_machkey_info[0]['image'].' ';
                }
                $mach_keys_uuids .= $get_key_name[0]['Key_Name'].',';
            }
        }
    }    

    $transponder_chip_keys_uuids = '';
    $trans_chip = '';
    $trans_reuseable = '';
    $trans_cloneable = '';
    $trans_test_blade = '';
    $trans_reserved = '';
    $trans_image = '';
    if($vehciles['Chip_Key_UUID'] ==""){
        $transponder_chip_keys_uuids = 'Coming Soon';
        $get_machkey_info = get_transkey_info($transponder_chip_keys_uuids );
        $trans_chip = $get_machkey_info[0]['chip'].',';
        $trans_reuseable = $get_machkey_info[0]['reuseable'].',';
        $trans_cloneable = $get_machkey_info[0]['cloneable'].',';
        $trans_test_blade = $get_machkey_info[0]['test_blade'].',';
        $trans_reserved = $get_machkey_info[0]['reserved'].',';
        $trans_image = $get_machkey_info[0]['image'].' ';
    }else{								
        $transponder_chip_keys_array =  explode(',',$vehciles['Chip_Key_UUID']);
        $information = array();
        for($i = 0; $i < count($transponder_chip_keys_array); $i++ ){
            $information = array();
            $get_key_name = get_key_name($transponder_chip_keys_array[$i]);
            if($get_key_name[0]['Key_Name'] !=""){
                $get_machkey_info = get_transkey_info($get_key_name[0]['Key_Name']);
                if(count($get_machkey_info) > 0){
                    $trans_chip .= $get_machkey_info[0]['chip'].',';
                    $trans_reuseable .= $get_machkey_info[0]['reuseable'].',';
                    $trans_cloneable .= $get_machkey_info[0]['cloneable'].',';
                    $trans_test_blade .= $get_machkey_info[0]['test_blade'].',';
                    $trans_reserved .= $get_machkey_info[0]['reserved'].',';
                    $trans_image .= $get_machkey_info[0]['image'].' ';
                }
                $transponder_chip_keys_uuids .=  $get_key_name[0]['Key_Name'].','; 
            }
        }
              
    }
    $programmer_information = programmer_information($vehciles['Make_Name'],$vehciles['Model_Name'],$vehciles['Years']);       

    $data['id'] = $vehciles['id'];
    $data['Make'] = $vehciles['Make_Name'];
    $data['Model'] = $vehciles['Model_Name'];
    $data['Year'] = $vehciles['Years'];
    $data['Generation Name'] = $vehciles['Generation_Name'];
    $data['Generation Year Range'] = $vehciles['Generation_YearRange'] ;
    $data['Keyed Ignition'] = $vehciles['Keyed_Ignition'];
    $data['Keyed Ignition Year Range'] = $vehciles['Keyed_IgnitionYear'];
    $data['Push to Start'] = $vehciles['Push_Start'];
    $data['Push to Start Year Range'] = $vehciles['Push_StartYear'];

    //mach
    $data['Mechanical Keys'] = rtrim($mach_keys_uuids,',');
    $data['Mechanical KeysImg'] = rtrim($mach_image,',');
    $data['Mechanical Keys- CodeSeries'] = rtrim($code_series,',');
    $data['Mechanical Keys- Depths'] = rtrim($depth,',');
    $data['Mechanical Keys- Ignition'] = rtrim($ignition,',');
    $data['Mechanical Keys- MACS'] = rtrim($macs,',');
    $data['Mechanical Keys- Spaces'] = rtrim($spaces,',');
    $data['Mechanical Keys- Reserved'] = rtrim($reserved,',');

    // Transponder
    $data['Transponder Key Chip'] = rtrim($transponder_chip_keys_uuids,',');
    $data['Transponder Key ChipImg'] = rtrim($trans_image,',');
    $data['Transponder Key Chip- chip'] = rtrim($trans_chip,',');
    $data['Transponder Key Chip- Reuseable'] = rtrim($trans_reuseable,',');
    $data['Transponder Key Chip- Cloneable'] = rtrim($trans_cloneable,',');
    $data['Transponder Key Chip- Test Blade'] = rtrim($trans_test_blade,',');
    $data['Transponder Key Chip- Reserved'] = rtrim($trans_reserved,',');

    $data['Key Programming Machine LITE'] = $programmer_information[0]['LITE'];
    $data['Key Programming Machine FULL'] = $programmer_information[0]['FULL'];
    $data['Key Programming Machine BASIC'] = $programmer_information[0]['BASIC'];
    $data['Key Programming Machine G2'] = $programmer_information[0]['G2'];
    $data['Key Programming Machine G2T'] = $programmer_information[0]['G2T'];
    $data['Key Programming Machine CORE'] = $programmer_information[0]['CORE'];
    $data['Key Programming Machine EVOLUTION'] = $programmer_information[0]['EVOLUTION'];
    $data['Key Programming Machine PRIME'] = $programmer_information[0]['PRIME'];
    $data['Key Programming Machine RESERVED'] = $programmer_information[0]['RESERVED'];
    $data['Key Programming Add Keys'] =  $vehciles['APP_Add_Keys'];
    $data['Key Programming All Keys Lost'] = $vehciles['APP_All_Keys_Lost'];
    $data['Key Programming Notes'] = $vehciles['APP_Notes'];
    $data['Key Programming System'] = $vehciles['APP_System'];
    $data['Key Programming Reserved'] = $vehciles['Key_ProgrammingReserved'];
    $data['Vehicle System'] = $vehciles['Vehicle_System'];
    fputcsv($output, $data);
   
}
fclose($output);
//print_r($data);

?>
