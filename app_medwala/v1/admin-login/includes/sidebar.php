
<div id="sidebar" class="sidebar py-3">
        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">MAIN</div>
			<ul class="sidebar-menu list-unstyled">
				  <li class="sidebar-list-item"><a href="admin-panel.php" class="sidebar-link text-muted"><i class="fas fa-home mr-3 text-gray"></i><span>Dashboard</span></a></li>
				  <li class="sidebar-list-item"><a href="about.php" class="sidebar-link text-muted"><i class="fas fa-chalkboard-teacher mr-3 text-gray"></i><span>About</span></a></li>
				  <li class="sidebar-list-item"><a href="slider.php" class="sidebar-link text-muted"><i class="fa fa-picture-o mr-3 text-gray"></i><span>Slider</span></a></li>
				  <li class="sidebar-list-item"><a href="all-categories.php" class="sidebar-link text-muted"><i class="fa fa-picture-o mr-3 text-gray"></i><span>Categories</span></a></li>
				  <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#medicinelist" aria-expanded="false" aria-controls="medicinelist" class="sidebar-link text-muted"><i class="fa fa-truck mr-3 text-gray"></i><span>Medicine List</span></a>
    					<div id="medicinelist" class="collapse">
    					  <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
    						<li class="sidebar-list-item"><a href="add-medicine.php" class="sidebar-link text-muted "><span>Add Medicine List</span></a></li>
    						<li class="sidebar-list-item"><a href="all-medicine.php" class="sidebar-link text-muted "><span>View Medicine List</span></a></li>
    					  </ul>
    					</div>
    			  </li>
				  <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages2334" aria-expanded="false" aria-controls="pages2334" class="sidebar-link text-muted"><i class="fa fa-truck mr-3 text-gray"></i><span>Shop</span></a>
    					<div id="pages2334" class="collapse">
    					  <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
    						<li class="sidebar-list-item"><a href="add-shop.php" class="sidebar-link text-muted "><span>Add Shop</span></a></li>
    						<li class="sidebar-list-item"><a href="all-shop.php" class="sidebar-link text-muted "><span>View Shop</span></a></li>
    					  </ul>
    					</div>
    				</li>
    			<li class="sidebar-list-item"><a href="appliedshop.php" class="sidebar-link text-muted "><i class="fa fa-truck mr-3 text-gray"></i><span>Applied Vendor </span></a></li>
    			<li class="sidebar-list-item"><a href="users.php" class="sidebar-link text-muted "><i class="fa fa-truck mr-3 text-gray"></i><span>Users </span></a></li>
			</ul>
        </div>
		
		
		<script>
		var pathname = window.location.pathname;
		var lastslashindex = pathname.lastIndexOf('/');
		var result= pathname.substring(lastslashindex  + 1);
		$("a[href$='"+result+"']").addClass("active");
		//alert(result);
		</script>