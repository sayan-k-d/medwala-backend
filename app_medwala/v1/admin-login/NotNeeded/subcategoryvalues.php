<?php
require_once('loader.inc');
if(isset($_POST['categories'])){
   // print_r($_POST['categories']);exit;
    $find_categories = find("all", CATAGORY, '*', "WHERE parent IN (".implode(',',$_POST['categories']).") ", array());
    //print_r($find_categories);exit;
}

foreach($find_categories as $subcategories){
    echo('
    <option value="'.$subcategories['id'].'" >'.$subcategories['name'].'</option>
    ');
}
?>