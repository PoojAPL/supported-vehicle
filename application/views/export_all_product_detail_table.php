<?php 
error_reporting(0);
$i=1;
$column = array();
$column[] = 'id';
$column[] = 'Product_id';
$column[] = 'Product_SKU';
$column[] = 'Product_Title';
$column[] = 'Product_Tags';
$column[] = 'Image';

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export_product_detail_'.date('m-d-y').'.csv');  
$output = fopen("php://output", "w");  
fputcsv($output,$column); 
$data = array();
foreach($getAllProductDetailCSV as $value){
    $data['id'] = $value['id'];
	$data['Product_id'] = $value['Product_id'];
	$data['Product_SKU'] = $value['Product_SKU'];
	$data['Product_Title'] = $value['Product_Title'];
    $data['Product_Tags'] = $value['Product_Tags'];
	$data['Image'] = $value['Image'];	
    fputcsv($output, $data); 
}
fclose($output);  

//print_r($getAllVehiclesDataCSV );
?>