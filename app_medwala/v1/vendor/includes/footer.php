<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">Copyright © MEDWALA</p>
              </div>
              <div class="col-md-6 text-center text-md-right text-gray-400">
                <p class="mb-0">Designed by <a href="https://servequewebservices.in/" class="external text-gray-400">Serveque</a></p>
              </div>
            </div>
          </div>
        </footer>
		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            	 if($.inArray(ext, ['ico','gif','png','jpg','jpeg','pdf','xlsx']) == -1)
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
		
        $(document).ready(function(){
            
          $("#vendorsupport").submit(function(e){
              
             $('#supprtfrmsubmitprocess').show();
             $('#supprtfrmsubmitbtn').hide();
            e.preventDefault();
		    $.ajax({  
		        
    				url:"<?php echo DOMAIN_NAME_PATH ?>vendor/vendorsupport.php", 
    				method:"POST",  
    				data:$('#vendorsupport').serialize(),
    				dataType:"text",
    				cache: false,
    				success:function(data)  
    				{
    				   
    					if(data == 'done'){
    					    
    					    $('#vendorsupport')[0].reset();
    					    $('#supprtfrmsubmitprocess').hide();
    					    $('#supportmodalsuccessmsg').show();
    					}
    					else{
    					    alert('error occured! Try Again Later');
    					}
    				}  
    			})
          });
        });
  	 
</script>

	<script>
	
	var allEditors = document.querySelectorAll('.editor');
    for (var i = 0; i < allEditors.length; ++i) {
      //ClassicEditor.create(allEditors[i]);
      
      ClassicEditor
			.create( allEditors[i], {
				plugins: [ 'MathType', 'Bold', 'Italic', 'Underline', 'Strikethrough', 'Subscript', 'Superscript',  'Heading', 'Base64UploadAdapter', 'Image', 'ImageUpload', 'ImageResize', 'ImageToolbar',
				'BlockQuote', 'Table', 'MediaEmbed', 'Alignment', 'FontBackgroundColor', 'FontColor', 'FontFamily', 'FontSize', 'Highlight', 'HorizontalLine', 'Underline', 'Link', 'List', 'SpecialCharacters',
				'ImageStyle'],
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo',
						'alignment',
						'fontBackgroundColor',
						'fontColor',
						'fontFamily',
						'fontSize',
						'highlight',
						'subscript',
						'horizontalLine',
						'superscript',
						'strikethrough',
						'underline',
						'imageUpload',
						'MathType',
						'ChemType',
                        '|',
						'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
					]
				},
				language: 'en',
				licenseKey: '',
				
				// MathType parameters.
				mathTypeParameters : {
					serviceProviderProperties : {
						URI : '<?php echo DOMAIN_NAME_PATH; ?>teacher/ckeditor/integration',
						server : 'php'
					}
				}
				
			} )
			.then( editor => {
				window.editor = editor;
		
				
				
				
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: oede1numya3s-v0kdrx76mxwg' );
				console.error( error );
			} );
    }


    function loadckeditor(id){
        ClassicEditor
			.create( document.querySelector( '.editor'+id ), {
				plugins: [ 'MathType', 'Bold', 'Italic', 'Underline', 'Strikethrough', 'Subscript', 'Superscript',  'Heading', 'Base64UploadAdapter', 'Image', 'ImageUpload', 'ImageResize', 'ImageToolbar',
				'BlockQuote', 'Table', 'MediaEmbed', 'Alignment', 'FontBackgroundColor', 'FontColor', 'FontFamily', 'FontSize', 'Highlight', 'HorizontalLine', 'Underline', 'Link', 'List', 'SpecialCharacters',
				'ImageStyle'],
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo',
						'alignment',
						'fontBackgroundColor',
						'fontColor',
						'fontFamily',
						'fontSize',
						'highlight',
						'subscript',
						'horizontalLine',
						'superscript',
						'strikethrough',
						'underline',
						'imageUpload',
						'MathType',
						'ChemType',
                        '|',
						'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
					]
				},
				language: 'en',
				licenseKey: '',
				
				// MathType parameters.
				mathTypeParameters : {
					serviceProviderProperties : {
						URI : 'https://machinist.co.in/teacher/ckeditor/integration',
						server : 'php'
					}
				}
				
			} )
			.then( editor => {
				window.editor = editor;
		
				
				
				
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: oede1numya3s-v0kdrx76mxwg' );
				console.error( error );
			} );
    }
	</script>