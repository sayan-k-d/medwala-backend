	<?php
session_start();
    require_once('loader.inc');
    //print_r($_SESSION['medicine']);
    if(isset($_SESSION['medicine'])){
    	$tot = 0;

    foreach( $_SESSION['medicine'] as $medicine){

    $tot = $tot + $medicine['tprice'];
    ?>
<tr>
	
  	<td><?php echo $medicine['medname']?></td>
  	<td><?php echo $medicine['mrp']?></td>
  	<td><?php echo $medicine['qty']?></td>
  	<td><?php echo $medicine['price']?></td>
  	<td><?php echo $medicine['discount']?></td>
    <td><?php echo $medicine['tprice']?></td>
  	<td><a href="javascript:void(0)" onclick="productdel('<?php echo $medicine['uniid'];?>')" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
  </tr>
 <?php }?>

 <tr >
	<td colspan="5">Grand Total</td>
	<td colspan="5">  
        <div class="form-group">
     <input id="grandtotal" value="<?php echo $tot; ?>" name="grandtotal12" type="text" placeholder="Grand Total" class="form-control" required  disabled>
</div>
 </td>
  </tr>
  <?php } ?>