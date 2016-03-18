$(document).ready(function()
{
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('#addMaterial').click(function(){
		addMaterial();
		return false;
	});
	
	$('.deleteMaterial').click(function(){
		deleteMaterial(this);
		return false;
	});
	
	$('.delete-picture').click(function(){
		deletePicture(this);
		return false;
	});
	
	$('#addVideo').click(function(){
		addVideo();
		return false;
	});
	
	$('.delete-video').click(function(){
		deleteVideo(this);
		return false;
	});
	
	var sectionId = $('#sectionId').val();
	
	$(".upload-icon").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 30
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#iconImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
	
	$(".upload-gallery").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 31
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			
			item = '<div class="col-sm-3 gallery-item" id="itemPicture-'+lastIdGallery+'">' +
				'		<div class="delete-picture">' +
				'		<div class="text-right">' +
				'			<a href="#" pictureId="'+lastIdGallery+'" class="glyphicon glyphicon-remove text-danger delete-picture"></a>' +
				'		</div>	' +
				'	</div>' +
				'	<div class="image">' +
				'		<img alt="" src="/images-system/medium/'+imageGallery+'">' +
				'	</div>' +
				'</div>';
			
			$('#galleryBoxItems').prepend(item);
			
			$('.delete-picture').click(function(){
				deletePicture(this);
				return false;
			});
		}
	});
});

function addMaterial()
{
	
	var newTitle = $('#newMaterialTitle').val();
	
	if (newTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	newTitle,
	            opt: 		54
	             },
	        success:
	        function(newId)
	        {
	            if (0 != newId)
	            {
	            	var item = '<div class="col-sm-12 slider-item" id="sId-'+newId+'">'
	            		+ '<div class="col-sm-12">'
	            		+ '		<div class="col-sm-2">'
	            		+ '		<img alt="" height="100" src="/images/100x100-default.jpg" />'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-9">'
	            		+ '		<p class="section-title"><strong>'+newTitle+'</strong></p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-1">'
	            		+ '		<a href="/editar-materiales/'+newId+'/nuevo-material/10/" class="btn btn-info btn-xs deleteSlider" sId="'+newId+'">Editar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#materialesBox').prepend(item);
	            	$('#newMaterialTitle').val('');
	            }
	        }
	    });
	}
}

function updateSection()
{
	var sectionId 			= $('#sectionId').val();
	var sectionTitle		= $('#sectionTitle').val();
	var sectionDescription	= $('#sectionDescription').val();
	var sectionContent		= $('#sectionContent').val();
	
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 			sectionId,
	        	sectionTitle:			sectionTitle,
	        	sectionDescription: 	sectionDescription,
	        	sectionContent: 		sectionContent,
	            opt: 					56
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

function deleteMaterial(node)
{
	var sId = $(node).attr('sId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  materiales_id: 	sId,
	            	opt: 			55
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	$('#sId-'+sId).remove();
	            }
	        }
	    });
	}
	
	return false;
}

function deletePicture(node)
{
	var sId = $(node).attr('pictureId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  pictureId: 	sId,
	            	opt: 		57
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	$('#itemPicture-'+sId).remove();
	            }
	        }
	    });
	}
	
	return false;
}

function addVideo()
{
	var sectionId 	= $('#sectionId').val();
	var singleVideo	= $('#videoURL').val();
	
	if (singleVideo)
	{
		singleVideo = extractVideoID(singleVideo);
	}
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 	sectionId,
	        	video:			singleVideo,
	            opt: 			58
	             },
	        success:
	        function(video_id)
	        {
	            if (0 != video_id)
	            {
	            	$('#videoURL').val('');
	            	item = '<div class="col-sm-2 gallery-item" id="itemVideo-'+video_id+'"> '+
						'	<div class="delete-picture"> '+
						'		<div class="text-right"> '+
						'			<a href="#" videoId="'+video_id+'" class="glyphicon glyphicon-remove text-danger delete-video"></a> '+
						'		</div>	 '+
						'	</div> '+
						'	<div class="image"> '+
						'		<img alt="" width="180" src="http://img.youtube.com/vi/'+singleVideo+'/0.jpg"> '+
						'	</div> '+
						'</div>';
	            	
	            	$('#galleryVideoItems').prepend(item);
//	            	alert('Informacion actualizada!');
	            }
	        }
	    });
	}
}

function deleteVideo(node)
{
	var sId = $(node).attr('videoId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  videoId: 	sId,
	            	opt: 		59
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	$('#itemVideo-'+sId).remove();
	            }
	        }
	    });
	}
	
	return false;
}



function extractVideoID(url)
{
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if ( match && match[7].length == 11 ){
        return match[7];
    }else{
//        alert("Could not extract video ID.");
    }
}

