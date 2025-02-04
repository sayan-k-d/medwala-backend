
<div id="sidebar" class="sidebar py-3">
        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">MAIN</div>
			<ul class="sidebar-menu list-unstyled">
				  <li class="sidebar-list-item"><a href="admin-panel.php" class="sidebar-link text-muted"><i class="o-home-1 mr-3 text-gray"></i><span>Dashboard</span></a></li>
				  <li class="sidebar-list-item"><a href="about.php" class="sidebar-link text-muted"><i class="fas fa-chalkboard-teacher mr-3 text-gray"></i><span>About</span></a></li>
				  <li class="sidebar-list-item"><a href="quotationrequest.php" class="sidebar-link text-muted"><i class="fa fa-circle mr-3 text-gray" aria-hidden="true"></i><span>Quotation Request</span></a></li>
				   <li class="sidebar-list-item"><a href="vendororder.php" class="sidebar-link text-muted"><i class="fa fa-first-order mr-3 text-gray" aria-hidden="true"></i><span>Order</span></a></li>
				   <li class="sidebar-list-item"><a href="vendorwallet.php" class="sidebar-link text-muted"><i class="fa fa-money mr-3 text-gray" aria-hidden="true"></i><span>Wallet</span></a></li>
				  <li class="sidebar-list-item"> <a href="javascript:void(0)" class="sidebar-link text-muted"  data-toggle="modal" data-target="#supportmodal"><i class="fa fa-shopping-cart mr-3 text-gray"></i><span>Support</span></a></li>
				 <li class="sidebar-list-item"><a href="all-subaccount.php" class="sidebar-link text-muted"><i class="fa fa-first-order mr-3 text-gray" aria-hidden="true"></i><span>Sub Account</span></a></li>

                  <li class="sidebar-list-item"><a href="logout.php" class="sidebar-link text-muted"><i class="fa fa-sign-out mr-3 text-gray" aria-hidden="true"></i><span>Logout</span></a></li>
                  
			</ul>
        </div>
		
		<script>
		var pathname = window.location.pathname;
		var lastslashindex = pathname.lastIndexOf('/');
		var result= pathname.substring(lastslashindex  + 1);
		$("a[href$='"+result+"']").addClass("active");
		//alert(result);
		</script>