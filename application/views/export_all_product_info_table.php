<?php 
error_reporting(0);
$i=1;
$column = array();
$column[] = 'id';
$column[] = 'Make';
$column[] = 'Model';
$column[] = 'Year';
$column[] = 'Product_id';

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export_product_make_model_year_info_'.date('m-d-y').'.csv');  
$output = fopen("php://output", "w");  
fputcsv($output,$column); 
$data = array();
foreach($getAllVehiclesDataCSV as $value){
    $data['id'] = $value['id'];
	$data['Make'] = $value['Make'];
	$data['Model'] = $value['Model'];
	$data['Year'] = $value['Year'];
    $data['Product_id'] = $value['Product_id'];	    
    fputcsv($output, $data); 
}
fclose($output);  

//print_r($getAllVehiclesDataCSV );
?>