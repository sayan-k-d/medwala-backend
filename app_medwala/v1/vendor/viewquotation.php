<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['vendorid'])) {
	header('Location: index.php');
	exit;
}
//unset($_SESSION['medicine']);
if(isset($_POST['submit']))
	{
	   
	  $quotetimes = find("first", QUOTEITEMS, '*', "WHERE quoteid!='".$_POST['quoteid']."' ", array());
	  
	 
	  if($quotetimes)
	  {
	            date_default_timezone_set("Asia/Calcutta");
    			$date = date('Y-m-d');
    			$time=date('h:i:s');
    			$medicineprice=0;
				if(isset($_SESSION['medicine'])){
                foreach( $_SESSION['medicine'] as $medicine){
                    $medicineprice=$medicineprice+$medicine['tprice'];
        				$table=QUOTEITEMS;
        				$fields="medid,medname,quoteid,qty,mrp,price,total,discount,date,time";
        				$values=":medid,:medname,:quoteid,:qty,:mrp,:price,:total,:discount,:date,:time";
        				$execute=array(
        					':medid'=>$medicine['medid'],
        					':medname'=>$medicine['medname'],
        					':quoteid'=>$_POST['quoteid'],
        					':qty'=>$medicine['qty'],
        					':mrp'=>$medicine['mrp'],
        					':price'=>$medicine['price'],
        					':discount'=>$medicine['discount'],
        					':total'=>$medicine['tprice'],
        					':date'=>$date,
        					':time'=>$time,
        					);
        				$save_data = save($table, $fields, $values, $execute);
				    }
				    
                    	    
        				$quoterequest = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid='".$_POST['quoteid']."' ORDER BY id DESC", array());
        				
                        //echo json_encode($b);exit;
                        //json_encode($b);	
                		$table=QUOTATIONREQUEST;
                		$set_value="shopamount=:shopamount,delivery_hour_by_shop=:delivery_hour_by_shop,status=:status,quoteimages=:quoteimages,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
                		$where_clause="WHERE id=".$quoterequest['id'];
                		$execute=array(
                		':shopamount'=>$medicineprice,
                		':delivery_hour_by_shop'=>$_POST['delivery_hour_by_shop'],
                		':status'=>'submitted',
                	    ':quoteimages'=>json_encode($b),
                	    ':orderprocess'=>36,
                		':status_background_color_for_app'=>'#FFF',
                		':status_text_color_for_app'=>'#008000'
                		);
                		$update=update($table, $set_value, $where_clause, $execute);
                		date_default_timezone_set("Asia/Calcutta");
                        $date = date("Y-m-d");
                        $time = date("h:i:s");
                		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$_POST['quoteid']."' AND command='submitted' ", array());
                		 $quoid= $find_track['quoteid']; 
                    	 $table=TRACKING;
                    	 $set_value="status=:status,date=:date,time=:time";
                    	 $where_clause="WHERE quoteid='$quoid' AND command='submitted' " ;
                    	 $execute=array(  
                        
                    	    ':status'=>'ok',
                    	    ':date'=>$date,
                    	    ':time'=>$time,
                    	    );
                    	    $update=update($table, $set_value, $where_clause, $execute);
                		
		
						header('location:quotationrequest.php');
				}
			else{
				
			echo("<script>window.alert('Please Add Medicene');</script>");
			unset($_SESSION['medicine']);
			echo("<script>window.location.href = '".DOMAIN_NAME_PATH."vendor/viewquotation.php?quoteid=".$_POST['quoteid']."';</script>");
			}
	        
	  }
	  else
	  {
	            
		    echo("<script>window.alert('Please Add Medicene');</script>");
		    unset($_SESSION['medicine']);
			echo("<script>window.location.href = '".DOMAIN_NAME_PATH."vendor/viewquotation.php?quoteid=".$_POST['quoteid']."';</script>");
	  }
	    
	}
    else
	{
		unset($_SESSION['medicine']);
	}
	

?>
<!DOCTYPE html>
<html>
  <head>

	<?php require_once('includes/header.php');?>
<style type="text/css">
	#searchResult{
 list-style: none;
 padding: 0px;
 width: 250px;
 position: absolute;
 margin: 0;
  z-index: 11111111 !important;
}

#searchResult li{
 background: lavender;
 padding: 4px;
 margin-bottom: 1px;


}

#searchResult li:nth-child(even){
 background: cadetblue;
 color: white;
}

#searchResult li:hover{
 cursor: pointer;
}
                     </style>

	<div class="d-flex align-items-stretch">
			<?php require_once('includes/sidebar.php');?> 
			<div class="page-holder w-100 d-flex flex-wrap">
				<div class="container-fluid px-xl-5">
					<section class="py-5">
						<div class="row">
							<div class="col-lg-12 mb-12">
							    <div class="wrapper_box">
							        <form method="post" enctype="multipart/form-data">
    							    <input type="hidden" id="quoteid" name="quoteid"  value="<?php echo $_GET['quoteid'];?>">
    							      <div class="line"></div>

									<div class="row">
								    <div class="form-group col-md-2">
								    	<label> Medicine Name</label>
											 <input type="text" id="medicinename" name="medicinename" class="form-control" placeholder="Medicine Name">
											 <ul id="searchResult"></ul>
									  </div>
									   <div class="form-group col-md-2">
									  		<label>MRP</label>
									  <input name="mrp" id="mrp" type="number"  class="form-control" placeholder="MRP">
									  </div>
									  <div class="form-group col-md-2">
									  		<label>Price</label>
									  <input name="price" id="price" type="number"  class="form-control" placeholder="PRICE"   onkeyup="pricechange()" onchange="pricechange()">
									  </div>
									  <div class="form-group col-md-2">
									  		<label> Discount</label>
									  <input onkeyup="discountput()" id="discountpercent" onchange="discountput()" name="discount" type="text"  class="form-control" placeholder="Discount"  >
									  </div>
									  <div class="form-group col-md-2">
									  		<label> Qty</label>
									  <input name="qty" type="number" id="qty"  class="form-control" placeholder="Quantity" min="1" >
									  </div>
									  
									  <div class="form-group col-md-2">
									  	<label></label>
										<a style="width:100%;color:#fff;" class="btn btn-success" onclick="addproduct()">Add</a>
									  </div>
    							    
									  <div class="col-lg-12 mb-12">
									  	<table id="" class="table" style="
                                                background-color: white;" border="1">
											  <thead class="thead-dark">
												<tr>
												 
												  <th>Product Name</th>
												  <th>MRP</th>
												  <th>QTY</th>
												  <th>Price</th>
												  <th>Dis</th>
												  <th>Total</th>
												  <th>Actions</th>
												</tr>
											  </thead>
											  <tbody id="div1">
											  <tr>
                                        	<td colspan="6">No Medicine Added</td>
                                        	
                                          </tr>
                                        </tbody>   
									  	</table>
									  </div>
    							   <div class="line"></div>
									  <div class="form-group row">
										<div class="col-md-9 ml-auto">
										    
										    <a  href="javascript:void(0)" data-toggle="modal" data-target="#shopmodal" class="btn btn-primary">Submit</a>
										     
										   
										</div>
									  </div>
                                    </form>
                                </div>
							</div>
						</div>
					</section>
				</div>
				<!-- The Modal -->
                <div class="modal" id="shopmodal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Delivery Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                
                      <!-- Modal body -->
                      <div class="modal-body">
						<form method="post" enctype="multipart/form-data" class="form-horizontal">
							<div class="form-group">
							    <label>Delivery Hours By Shop</label>
								<select name="delivery_hour_by_shop" id="delivery_hour_by_shop" class="form-control" required>
								    <option value="">Select Hours</option>
								    <option value="1">1</option>
								    <option value="2">2</option>
								    <option value="3">3</option>
								    <option value="4">4</option>
								    <option value="5">5</option>
								</select>
								  <input type="hidden" id="quoteid" name="quoteid" value="<?php echo $_GET['quoteid'];?>">  
							</div>

							<button type="submit" name="submit" class="btn btn-success">Submit</button>
							
						</form>
                      </div>
                
                      <!-- Modal footer -->
                      
                
                    </div>
                  </div>
                </div>
		<?php require_once('includes/footer.php');?>
		<script type="text/javascript">
		function discountput()
		{
            var discount = $('#discountpercent').val();
            var mrp = $('#mrp').val();
            var discountedamt = mrp - ( mrp * discount ) / 100;
            $('#price').val(discountedamt);
        }
        function pricechange(){
            var grandtotal = $('#price').val();
            var mrp = $('#mrp').val();
            var discountedamt = Math.round((mrp - grandtotal ) * 100) / mrp;
            $('#discountpercent').val(discountedamt);
        }
        $(document).ready(function () {
          $("#medicinename").keyup(function () {
                var query = $(this).val();
                if (query != "") {
                	
                    $.ajax({
                        url: "<?php echo DOMAIN_NAME_PATH ?>vendor/statuschange.php",
                        method: "POST",
                        data: {
                            query: query
                        },
                         dataType: 'text',
                        cache: false,
                        success: function (data) {
                      //console.log(data);
                      $("#searchResult").html(data);
                      $("#searchResult li").bind("click",function(){
                        setText(this);
                    });
                        }

                    });

                } else {
                    $('#searchResult').html('');
                }
            });
        });

              // Set Text to search box and get details
        function setText(element){
        
            var value = $(element).text();
            var mrpval = $(element).val();
            $("#medicinename").val(value);
            $("#searchResult").empty();
            $.ajax({  
                        url:"<?php echo DOMAIN_NAME_PATH ?>vendor/get_details.php", 
                        method:"POST",  
                        data:{ value:value},
                        dataType: 'json',
                        cache: false,
                        success:function(data)  
                        {
                        	  var len = data.length;
                                // data = JSON.parse(data);
                                 if(len > 0)
                                 {
                                    var mrp = data[0]['mrp'];
                                     $("#mrp").val(data[0]['mrp']);                                
                                }    
                        }  
                    }) 
  
        }
        function addproduct(){
        	var medicinename = $('#medicinename').val();
        	
        	if(medicinename =='')
        	{
        		alert("Please select product");
        		return false;
        	}
        	var qty = $('#qty').val();
        	if(qty =='')
        	{
        		alert("Please enter quantity");
        		return false;
        	}
        	var price = $('#price').val();
        	if(price =='')
        	{
        		alert("Please enter price");
        		return false;
        	}
        	var mrp = $('#mrp').val();
        	if(mrp =='')
        	{
        		alert("Please Enter MRP");
        		return false;
        	}
        	var discountpercent = $('#discountpercent').val();
        	if(discountpercent =='')
        	{
        		alert("Please Enter Discount");
        		return false;
        	}
             $.ajax({
                type: "POST",
                url: "<?php echo DOMAIN_NAME_PATH ?>vendor/session.php",
                data:{ medicinename: medicinename ,qty:qty,price:price,mrp:mrp,discountpercent:discountpercent}, 
                success: function(data){
                    //alert(data);
                        if(data =='no'){
                        alert("out of stock");
                     }
                     else 
                     {
                     	 $("#div1").load("<?php echo DOMAIN_NAME_PATH ?>vendor/addproduct.php");
                     	 
                     	$('#medicinename').val('');
                     	 $('#qty').val('');
                     	 $('#mrp').val('');
                     	 $('#price').val('');
                     	 $('#discountpercent').val('');
                     }
                    }
                
             });
        }
        function productdel(pid)
			{	
			$.ajax({  
	                    url:"<?php echo DOMAIN_NAME_PATH ?>vendor/productdel.php", 
	                    method:"POST",  
	                    data:{pid:pid},
	                    dataType: 'text',
	                    cache: false,
	                    success:function(data)  
	                    {
	                    	//alert(data);
	                       $("#div1").load("<?php echo DOMAIN_NAME_PATH ?>vendor/addproduct.php");
	                           
	                    }  
		             }) 
			}
				
        </script>
	</div>
	</div>
  </body>
</html>