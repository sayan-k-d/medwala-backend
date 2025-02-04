<?php
session_start();
require_once('loader.inc');
$medicinename = $_POST['medicinename'];
$qty = $_POST['qty'];
$price = $_POST['price'];
$mrp = $_POST['mrp'];
$discountpercent = $_POST['discountpercent'];
$artist = find("first", MEDICINELIST, '*', "WHERE name='".$medicinename."'", array());
if($artist['id'])
{
    $medid = $artist['id'];
}
else
{
    $medid = '';

}
$uniid=uniqid();
  $pname=$artist['name'];
  $tprice=$qty*$price;
 
  $grandtotal=$tprice;
 $_SESSION['medicine'][$uniid] = array('uniid'=> $uniid,'medid'=> $medid,'medname'=> $medicinename,'mrp'=> $mrp,'qty'=> $qty,'discount'=>$discountpercent,'price'=> $price,'tprice'=> $grandtotal);

print_r($_SESSION);
?>