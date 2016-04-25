$(document).ready(function()
{
	$('#updateSection').click(function(){
		updateSection();
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
				opt: 9 
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
	            opt: 					1
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

function updateProyectos()
{
	var sectionId 	= $('#sectionId').val();
	deleteRealacion(sectionId);
	$('#contenidosBoxItems .aliado-item').each(function(){
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
	            	opt: 			65
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
	            	opt: 			66
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