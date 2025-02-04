<?php
require_once('loader.inc');
if(isset($_POST['categories'])){
   // print_r($_POST['categories']);exit;
    $find_categories = find("all", SUBFILTER, '*', "WHERE subcat IN (".implode(',',$_POST['categories']).") ", array());
    //print_r($find_categories);exit;
}

foreach($find_categories as $subcategories){
    $subfilterdetails = find("first", SUBFILTER, '*', "WHERE id = '".$subcategories['id']."' ", array());
	$findfiler = find("first", FILTER, '*', "WHERE id = '".$subfilterdetails['filter']."' ", array());
    echo('
    <option value="'.$subcategories['id'].'" >'.$subcategories['name'].' ( '.$findfiler['name'].' )</option>
    ');
}
?>