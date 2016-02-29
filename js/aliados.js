$(document).ready(function()
{
	$('.saveSlider').click(function(){
		saveSlider(this);
		return false;
	});
	
	$('.deleteSlider').click(function(){
		deleteSlider(this);
		return false;
	});
	
	$(".upload-slider").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				opt: 6 
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			
			itemGallery = '<div class="col-sm-12 slider-item" id="sId-'+lastIdGallery+'">'+
			'	<div class="col-sm-12">'+
			'		<div class="col-sm-4">'+
			'			<img alt="" src="/images-system/medium/'+imageGallery+'" />'+
			'		</div>'+
			'		<div class="col-sm-offset-6 col-sm-2">'+
			'			<a href="javascript:void(0);" class="btn btn-info btn-xs saveSlider" sId="'+lastIdGallery+'">Save</a>'+
			'			<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteSlider" sId="'+lastIdGallery+'">Delete</a>'+
			'		</div>'+
			'	</div>'+
			'	<div class="col-sm-12 slider-section">'+
			'		<div class="col-sm-4">'+
			'			<input type="text" placeholder="Twitter" class="form-control" id="titleSlider-'+lastIdGallery+'" value="">'+
			'		</div>'+
			'		<div class="col-sm-4">'+
			'			<input type="text" placeholder="Facebook" class="form-control" id="linkSlider-'+lastIdGallery+'" value="">'+
			'		</div>'+
			'		<div class="col-sm-4">'+
			'			<input type="text" placeholder="Google Plus" class="form-control" id="gSlider-'+lastIdGallery+'" value="">'+
			'		</div>'+
			'	</div>'+
			'</div>';
			
			$('#slidersBox').prepend(itemGallery);
			
			$('.saveSlider').click(function(){
				saveSlider(this);
				return false;
			});
			
			$('.deleteSlider').click(function(){
				deleteSlider(this);
				return false;
			});
		}
	});
});

function saveSlider(node)
{
	var sid	= $(node).attr('sId');
	var titleSlider	= $('#titleSlider-'+sid).val();
	var linkSlider 	= $('#linkSlider-'+sid).val();
	var gSlider 	= $('#gSlider-'+sid).val();
	
	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/media.php',
	        data:{  sId: 		sid,
	        	titleSlider:	titleSlider,
	        	linkSlider: 	linkSlider,
	        	infoSlider: 	gSlider,
	            opt: 			7
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	alert('Informacion actualizada!');
	            }
	        }
	    });
	}
}

function deleteSlider(node)
{
	var sid	= $(node).attr('sId');
	
	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/media.php',
	        data:{  sId: 		sid,
	            opt: 			8
	             },
	        success:
	        function(xml)
	        {
	            if (1 == xml)
	            {
	            	$('#sId-'+sid).hide();
	            }
	        }
	    });
	}
}