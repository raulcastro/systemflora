$(document).ready(function()
{
	$('.deleteSlider').click(function(){
		deleteBanner(this);
		return false;
	});
	
	$(".upload-slider").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				opt: 4 
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
			'		<div class="col-sm-offset-7 col-sm-1">'+
			'			<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteSlider" sId="'+lastIdGallery+'">Delete</a>'+
			'		</div>'+
			'	</div>'+
			'</div>';
			
			$('#slidersBox').prepend(itemGallery);
			
			$('.deleteSlider').click(function(){
				deleteBanner(this);
				return false;
			});
		}
	});
});


function deleteBanner(node)
{
	var sid	= $(node).attr('sId');
	
	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/media.php',
	        data:{  sId: 		sid,
	            opt: 			5
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