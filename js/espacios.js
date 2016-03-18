$(document).ready(function()
{
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('.delete-bloque').click(function(){
		deleteBloque(this);
		return false;
	});
	
	$('.addBloque').click(function(){
		addBloque();
		return false;
	});
	
	$('#updateProyectos').click(function(){
		updateProyectos();
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
				opt: 11
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#iconImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
	
	$(".upload-bg").uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
				sectionId: sectionId,
				opt: 12
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#iconbg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
});

function updateSection()
{
	var sectionId 			= $('#sectionId').val();
	var sectionTitle		= $('#sectionTitle').val();
	var sectionDescription	= $('#sectionDescription').val();
	var sectionContent		= $('#sectionContent').val();
	var secondColumnTitle = $('#secondColumnTitle').val();
	var thirdColumnTitle = $('#thirdColumnTitle').val();
	var thirdColumnContent = $('#thirdColumnContent').val();
	var singleVideo = $('#singleVideo').val();
	
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
	        	thirdColumnTitle: 		thirdColumnTitle,
	        	thirdColumnContent: 	thirdColumnContent,
	        	singleVideo: 			singleVideo,
	            opt: 					3
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

function deleteBloque(node)
{
	var bloqueId = $(node).attr('bloqueId');
	
	if (bloqueId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  bloqueId: 	bloqueId,
	            opt: 			4
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	$('#itemBlock-'+bloqueId).remove();
	            }
	        }
	    });
	}
	
	return false;
}


function addBloque()
{
	var sectionId 			= $('#sectionId').val();
	var bloqueTitle = $('#bloqueTitle').val();
	var bloqueContent = $('#bloqueContent').val();
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 			sectionId,
	        	bloqueTitle:			bloqueTitle,
	        	bloqueContent: 	bloqueContent,
	            opt: 					5
	             },
	        success:
	        function(bloqueId)
	        {
	            if (0 != bloqueId)
	            {
	            	item = '<div class="itemBlock" id="itemBlock-'+bloqueId+'"> ' +
						'		<div class="text-right">' +
						'		<a href="#" bloqueId="'+bloqueId+'" class="glyphicon glyphicon-remove text-danger delete-bloque"></a>' +
						'	</div>' +
						'	<div>' +
						'		<h5>'+bloqueTitle+'</h5>' +
						'		<p>'+bloqueContent+'</p>' +
						'	</div>' +
						'</div>';
	            	
	            	$('#bloquesBox').prepend(item);
	            	
	            	$('#bloqueTitle').val('');
	            	$('#bloqueContent').val('');
	            	
	            	$('.delete-bloque').click(function(){
	            		deleteBloque(this);
	            		return false;
	            	});
	            }
	        }
	    });
	}
}

function updateProyectos()
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
	            	opt: 			73
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
	            	opt: 			74
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






