<?php 
error_reporting(0);
$i=1;
$column = array();
foreach($getAllVehiclesDataCSV as $key => $vehciles){
  
    foreach($vehciles as $key1 => $vehciles1){
      if($i > 1){
          break;
      }else{
         $column[] = $key1; 
       } 
       
    } 
     $i++;
}
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=AutoProPAD_'.date('m-d-y').'.csv');  
$output = fopen("php://output", "w");  
fputcsv($output,$column); 
foreach($getAllVehiclesDataCSV as $vehciles){
  $got_series_data = explode(',',$vehciles['Code_Series_UUID']);
  if( count($got_series_data) > 1){
      for( $cs = 0; $cs <= count($got_series_data); $cs++ ){
        $got_series_val = explode('|',$got_series_data[$cs]);
        $code_series_id = $got_series_val[0];
        $code_series_note = $got_series_val[1];
        $get_Code_Series_name = get_Code_Series_name($code_series_id);
       $Code_Series_Name2 .= $get_Code_Series_name[0]['Code_Series_Name'].',';
      }
      $Code_Series_Name = rtrim($Code_Series_Name2, ',') ;
   }else{
    $got_series_val = explode('|',$got_series_data[0]);
    $code_series_id = $got_series_val[0];
    $code_series_note = $got_series_val[1];
    $get_Code_Series_name = get_Code_Series_name($code_series_id);
    $Code_Series_Name = $get_Code_Series_name[0]['Code_Series_Name'];
  }
  $vehciles['Years'] = str_replace(',','-',$vehciles['Years']);
  $vehciles['Code_Series_UUID'] = '"' . $Code_Series_Name. '"';
  $vehciles['Code_Series_UUID'] = str_replace('"',' ',$vehciles['Code_Series_UUID']);

  $mach_keys_uuids = "";	
  if($vehciles['Mechanical_Key_UUID'] !=""){							
    $mach_keys_array = explode(',',$vehciles['Mechanical_Key_UUID']);
    for($i = 0; $i < count($mach_keys_array); $i++ ){
      $get_key_name = get_key_name($mach_keys_array[$i]);
      $mach_keys_uuids .=  $get_key_name[0]['Key_Name'].', ';
    }
  }
  $vehciles['Mechanical_Key_UUID'] = rtrim($mach_keys_uuids,',');

  
  $chip_keys_uuids = "";		
  if($vehciles['Chip_Key_UUID'] !=""){				
    $chip_keys_array = explode(',',$vehciles['Chip_Key_UUID']);
    for($i = 0; $i < count($chip_keys_array); $i++ ){
      $get_key_name = get_key_name($chip_keys_array[$i]);
      $chip_keys_uuids .=  $get_key_name[0]['Key_Name'].', ';
    }
  }
  $vehciles['Chip_Key_UUID'] = rtrim($chip_keys_uuids,', ');

  fputcsv($output, $vehciles); 
}
fclose($output);  

//print_r($getAllVehiclesDataCSV
