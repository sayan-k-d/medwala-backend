<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">Copyright © Medwala</p>
              </div>
              <div class="col-md-6 text-center text-md-right text-gray-400">
                <p class="mb-0">Designed by <a href="https://servequewebservices.in/" class="external text-gray-400">Serveque</a></p>
              </div>
            </div>
          </div>
        </footer>
		

<script>
	$(function () {
	  $('select').each(function () {
		$(this).select2({
		  theme: 'bootstrap4',
		  width: 'style',
		  placeholder: $(this).attr('placeholder'),
		  allowClear: Boolean($(this).data('allow-clear')),
		});
	  });
	});
	</script>
	
		<script>
        var input = $( "input:file" ).addClass( "fileInput" );
          
          $(".fileInput").change(function(){
            var ext = $('.fileInput').val().split('.').pop().toLowerCase();
              if(ext != '')
              {
            	 if($.inArray(ext, ['ico','gif','png','jpg','jpeg','pdf']) == -1)
            	 {
            		alert('invalid extension! Image Or Document files only!');
            		$('.fileInput').val('');
            	 } 
              }
          });
          
          
    function getsubcategories(){
        var categories = $('#categories').val();
        //alert(categories);
        
        $.ajax({  
				url:"<?php echo DOMAIN_NAME_PATH_ADMIN; ?>subcategoryvalues.php", 
				method:"POST",  
				data:{categories:categories},
				dataType:"text",
				cache: false,
				success:function(data)  
				{
				    //alert(data);
				    $("#subcategories").html(data);
				}  
			})
    }
    
    
     function getsubcategoriesedit(){
        var categories = $('#categoriesedit').val();
        //alert(categories);
        
        $.ajax({  
				url:"<?php echo DOMAIN_NAME_PATH_ADMIN; ?>subcategoryvalues.php", 
				method:"POST",  
				data:{categories:categories},
				dataType:"text",
				cache: false,
				success:function(data)  
				{
				    //alert(data);
				    $("#subcategoriesedit").html(data);
				}  
			})
    }
    
    
    
    function findfiltersedit(){
        var categories = $('#subcategoriesedit').val();
        //alert(categories);
        
        $.ajax({  
				url:"<?php echo DOMAIN_NAME_PATH_ADMIN; ?>data.php", 
				method:"POST",  
				data:{categories:categories},
				dataType:"text",
				cache: false,
				success:function(data)  
				{
				    //alert(data);
				    $("#subfiltersedit").html(data);
				}  
			})
    }
    
    
    function findfilters(){
        var categories = $('#subcategories').val();
        //alert(categories);
        
        $.ajax({  
				url:"<?php echo DOMAIN_NAME_PATH_ADMIN; ?>data.php", 
				method:"POST",  
				data:{categories:categories},
				dataType:"text",
				cache: false,
				success:function(data)  
				{
				    //alert(data);
				    $("#subfilters").html(data);
				}  
			})
    }
    
    
   function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
		 
</script>