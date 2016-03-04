$(document).ready(function()
{
	if ( $('.has-date').length ) {
		$( ".has-date" ).datepicker({
			altFormat: "d M, y",
			changeMonth: true,
		    changeYear: true
		});
	}
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('#addNoticia').click(function(){
		addNoticia();
		return false;
	});
	
	$('.deleteNew').click(function(){
		deleteNews(this);
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
				opt: 13
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#iconImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
	
	$(".upload-portrait").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 14
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#portraitImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
	
	$(".upload-gallery").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 15
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

function addNoticia()
{
	
	var newNoticiaDate = $('#newNoticiaDate').val();
	var newNoticiaTitle = $('#newNoticiaTitle').val();
	
	if (newNoticiaDate && newNoticiaTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newDate:	newNoticiaDate,
	        	newTitle: 	newNoticiaTitle,
	            opt: 					6
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
	            		+ '		<p class="section-title"><strong>'+newNoticiaTitle+'</strong></p>'
	            		+ '		<p class="section-title">'+newNoticiaDate+'</p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-1">'
	            		+ '		<a href="/editar-espacios/'+newId+'/nueva-noticia/4/" class="btn btn-info btn-xs deleteSlider" sId="'+newId+'">Editar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#noticiasBox').prepend(item);
	            	$('#newNoticiaTitle').val('');
	            	$('#newNoticiaDate').val('');
	            		
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
	
	var conservacion 	= 0;
	var bienestar 		= 0;
	var educacion 		= 0;
	
	$('#causasSelector .causas-selector-item').each(function(){
		var causaName = $(this).attr('causaName');
		switch (causaName)
		{
			case 'conservacion':
				if ($(this).is(':checked'))
				{
					conservacion = 1;
				}
			break;
			
			case 'bienestar':
				if ($(this).is(':checked'))
				{
					bienestar = 1;
				}
			break;
			
			case 'educacion':
				if ($(this).is(':checked'))
				{
					educacion = 1;
				}
			break;
		}
	});
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 			sectionId,
	        	sectionTitle:			sectionTitle,
	        	sectionDescription: 	sectionDescription,
	        	sectionContent: 		sectionContent,
	        	conservacion:			conservacion,
	        	bienestar:				bienestar,
	        	educacion:				educacion,
	            opt: 					8
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

function deleteNews(node)
{
	var sId = $(node).attr('sId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  noticias_id: 	sId,
	            	opt: 			7
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
	            	opt: 			9
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
	var sectionId 			= $('#sectionId').val();
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
	        data:{  sectionId: 			sectionId,
	        	video:			singleVideo,
	            opt: 					10
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
	            	opt: 			11
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

