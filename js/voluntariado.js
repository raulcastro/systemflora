$(document).ready(function()
{
	$('#addVoluntariado').click(function(){
		addVoluntariado();
		return false;
	});
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('.delete').click(function(){
		deleteVoluntariado(this);
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
	
	var sectionId = $('#sectionId').val();
	
	$(".upload-icon").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 29
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#iconImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
});

function addVoluntariado()
{
	var newTitle = $('#newTitle').val();
	var type = $('#voluntariadoType').val();
	var pageSection = $('#pageSection').val();
	
	if (newTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	newTitle,
	        	type:	type,
	            opt: 		51
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
	            		+ '		<p class="section-title"><strong>'+newTitle+'</strong></p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-2">'
	            		+ '		<a href="/editar-voluntariado/'+newId+'/nuevo-node/10/'+pageSection+'/" class="btn btn-info btn-xs">Editar</a>'
	            		+ ' <a href="" class="btn btn-danger btn-xs delete" sId="'+newId+'">Eliminar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#voluntariadoBox').prepend(item);
	            	$('#newTitle').val('');
	            	
	            	$('.delete').click(function(){
	            		deleteVoluntariado(this);
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
	var firstColumnTitle 	= $('#firstColumnTitle').val();
	var firstColumnContent = $('#firstColumnContent').val();
	var secondColumnTitle 	= $('#secondColumnTitle').val();
	var secondColumnContent = $('#secondColumnContent').val();
	var thirdColumnTitle 	= $('#thirdColumnTitle').val();
	var thirdColumnContent 	= $('#thirdColumnContent').val();
	var singleVideo 		= $('#singleVideo').val();
	
	
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
	        	firstColumnContent:		firstColumnContent,
	        	secondColumnTitle: 		secondColumnTitle,
	        	secondColumnContent:	secondColumnContent,
	        	thirdColumnTitle: 		thirdColumnTitle,
	        	thirdColumnContent: 	thirdColumnContent,
	            opt: 					53
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

function deleteVoluntariado(node)
{
	var sId = $(node).attr('sId');

	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  voluntariado_id: sId,
	            	opt: 		52
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






