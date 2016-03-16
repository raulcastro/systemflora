$(document).ready(function()
{
	$('#addProyecto').click(function(){
		addProyecto();
		return false;
	});
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('.deleteProyectos').click(function(){
		deleteProyecto(this);
		return false;
	});
	
	$('.addLink').click(function(){
		addLink(this);
		return false;
	});
	
	$('.deleteProyectosLink').click(function(){
		deleteProyectosLinks(this);
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
				opt: 19
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
				opt: 20
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

function addProyecto()
{
	var proyectoTitle = $('#newProyectoTitle').val();
	
	if (proyectoTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	proyectoTitle,
	            opt: 		23
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
	            		+ '		<p class="section-title"><strong>'+proyectoTitle+'</strong></p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-2">'
	            		+ '		<a href="/editar-proyectos/'+newId+'/nuevo-proyecto/6/" class="btn btn-info btn-xs">Editar</a>'
	            		+ ' <a href="" class="btn btn-danger btn-xs deleteProyectos" sId="'+newId+'">Eliminar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#proyectosBox').prepend(item);
	            	$('#newProyectoTitle').val('');
	            	
	            	$('.deleteProyectos').click(function(){
	            		deleteProyecto(this);
	            		return false;
	            	});
	            }
	        }
	    });
	}
}

function updateSection()
{
	
//	alert('here');
	var sectionId 			= $('#sectionId').val();
	var sectionTitle		= $('#sectionTitle').val();
	var sectionDescription	= $('#sectionDescription').val();
	var sectionContent		= $('#sectionContent').val();
	var firstColumnTitle = $('#firstColumnTitle').val();
	var secondColumnTitle = $('#secondColumnTitle').val();
	var thirdColumnTitle = $('#thirdColumnTitle').val();
//	var thirdColumnContent = $('#thirdColumnContent').val();
//	var singleVideo = $('#singleVideo').val();
	
//	if (singleVideo)
//	{
//		singleVideo = extractVideoID(singleVideo);
//	}
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 			sectionId,
	        	sectionTitle:			sectionTitle,
	        	sectionDescription: 	sectionDescription,
	        	sectionContent: 		sectionContent,
	        	firstColumnTitle:		firstColumnTitle,
	        	secondColumnTitle: 		secondColumnTitle,
	        	thirdColumnTitle: 		thirdColumnTitle,
//	        	thirdColumnContent: 	thirdColumnContent,
//	        	singleVideo: 			singleVideo,
	            opt: 					25
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

function deleteProyecto(node)
{
	var sId = $(node).attr('sId');
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  logros_id: 	sId,
	            	opt: 		24
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
	            opt: 			26
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
	            		deleteProyectosLinks(this);
	            		return false;
	            	});
	            }
	        }
	    });
	}
}

function deleteProyectosLinks(node)
{
	var linkId 	= $(node).attr('linkId');
	
	if (linkId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  linkId: 	linkId,
	            opt: 			27
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
	            	opt: 		30
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
	        data:{  sectionId: 			sectionId,
	        	video:			singleVideo,
	            opt: 					28
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
	            	opt: 			29
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






