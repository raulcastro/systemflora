$(document).ready(function()
{
	$('#addCampana').click(function(){
		addCampana();
		return false;
	});
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('.deleteCampanas').click(function(){
		deleteCampana(this);
		return false;
	});
	
	$('.addLink').click(function(){
		addLink(this);
		return false;
	});
	
	$('.deleteProyectosLink').click(function(){
		deleteCampanasLinks(this);
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
	
	$('#updateAliados').click(function(){
		updateAliados();
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
				opt: 24
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
				opt: 25
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
				opt: 26
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

function addCampana()
{
	var newCampanaTitle = $('#newCampanaTitle').val();
	
	if (newCampanaTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	newCampanaTitle,
	            opt: 		37
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
	            		+ '	<div class="col-sm-8">'
	            		+ '		<p class="section-title"><strong>'+newCampanaTitle+'</strong></p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-2">'
	            		+ '		<a href="/editar-campanas/'+newId+'/nuevo-proyecto/8/" class="btn btn-info btn-xs">Editar</a>'
	            		+ ' <a href="" class="btn btn-danger btn-xs deleteCampanas" sId="'+newId+'">Eliminar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#campanasBox').prepend(item);
	            	$('#newCampanaTitle').val('');
	            	
	            	$('.deleteCampanas').click(function(){
	            		deleteCampana(this);
	            		return false;
	            	});
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
	var secondColumnTitle 	= $('#secondColumnTitle').val();
	var secondColumnContent = $('#secondColumnContent').val();
	var otrosContent		= $('#otrosContent').val();
	var thirdColumnTitle 	= $('#thirdColumnTitle').val();
	var thirdColumnContent 	= $('#thirdColumnContent').val();
	var singleVideo 		= $('#singleVideo').val();
	
	var promoted = 0;
	
	$('#voluntariadoSelector .voluntariado-selector-item').each(function(){
		var causaName = $(this).attr('selectorOption');
		switch (causaName)
		{
			case 'si':
				if ($(this).is(':checked'))
				{
					promoted = 1;
				}
			break;
			
			case 'no':
				if ($(this).is(':checked'))
				{
					promoted = 0;
				}
			break;
		}
	});
	
	
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
	        	sectionTitle:			sectionTitle,
	        	sectionDescription: 	sectionDescription,
	        	sectionContent: 		sectionContent,
	        	secondColumnTitle: 		secondColumnTitle,
	        	secondColumnContent:	secondColumnContent,
	        	otrosContent:			otrosContent,
	        	thirdColumnTitle: 		thirdColumnTitle,
	        	thirdColumnContent: 	thirdColumnContent,
	        	singleVideo: 			singleVideo,
	        	promoted:				promoted,
	            opt: 					39
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

function deleteCampana(node)
{
	var sId = $(node).attr('sId');
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  campanas_id: sId,
	            	opt: 		38
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


function addLink(node)
{
	var sectionId 	= $('#sectionId').val();
	var linkType 	= $(node).attr('linkType');
	
	var linkTitle 	= $('#linkTitle-'+linkType).val();
	var linkUrl 	= $('#linkUrl-'+linkType).val();
	
	if (sectionId && linkUrl)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 	sectionId,
	        	linkType:		linkType,
	        	linkTitle: 		linkTitle,
	        	linkUrl: 		linkUrl,
	            opt: 			40
	             },
	        success:
	        function(linkId)
	        {
	            if (0 != linkId)
	            {
	            	item = '<div class="itemBlock" id="linkBlock-'+linkId+'"> ' +
						'		<div class="text-right">' +
						'		<a href="#" linkId="'+linkId+'" class="glyphicon glyphicon-remove text-danger deleteProyectosLink"></a>' +
						'	</div>' +
						'	<div>' +
						'<a href="'+linkUrl+'" target="_blank" linkId="'+linkId+'" class="text-success">'+linkTitle+'</a>' +
						'	</div>' +
						'</div>';
	            	
	            	$('#linksBox-'+linkType).prepend(item);
	            	
	            	$('#linkTitle-'+linkType).val('');
	            	$('#linkUrl-'+linkType).val('');
	            	
	            	$('.deleteProyectosLink').click(function(){
	            		deleteCampanasLinks(this);
	            		return false;
	            	});
	            }
	        }
	    });
	}
}

function deleteCampanasLinks(node)
{
	var linkId 	= $(node).attr('linkId');
	
	if (linkId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  linkId: 	linkId,
	            opt: 			41
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	$('#linkBlock-'+linkId).remove();
	            	
	            }
	        }
	    });
	}
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
	            	opt: 		42
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
	            opt: 			43
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
	            	opt: 		44
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

function updateAliados()
{
	var sectionId 	= $('#sectionId').val();
	deleteRealacion(sectionId);
	$('#aliadosBoxItems .aliado-item').each(function(){
		if ($(this).is(':checked'))
		{
			aliadoId = $(this).attr('aliadoId');
			addRelacion(sectionId, aliadoId);
		}
	});
	alert('Actualizado');
}

function addRelacion(sectionId, aliadoId)
{
	if (aliadoId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: sectionId,
	        		aliadoId: 	aliadoId,
	            	opt: 			81
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	
	            }
	        }
	    });
	}
	
	return false
}

function deleteRealacion(sectionId)
{
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: sectionId,
	            	opt: 			82
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	
	            }
	        }
	    });
	}
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






