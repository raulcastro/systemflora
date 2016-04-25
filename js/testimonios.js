$(document).ready(function()
{
	$('#addTestimonio').click(function(){
		addTestimonio();
		return false;
	});
	
	$('.saveDir').click(function(){
		saveDirectorio(this);
		return false;
	});
	
	$('.deleteDir').click(function(){
		deleteDirectorio(this);
		return false;
	});
	
});

function addTestimonio()
{
	var description	= $('#newTestimonio').val();
	
	if (description)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	description:	description,
	            opt: 			60
	             },
	        success:
	        function(lastId)
	        {
	            if (0 != lastId)
	            {
	            	var item = '<div class="col-sm-12 slider-item" id="sId-'+lastId+'"> ' +
			    	'	<div class="col-sm-12"> ' +
					'		<div class="col-sm-2"> ' +
					'			<img alt="" src="/images/100x100-default.jpg" id="iconDir'+lastId+'" /> ' +
					'		</div> ' +
					'		<div class="col-sm-3"> ' +
					'			<div class="col-sm-12" id="uploadDir-'+lastId+'"> ' +
					'				Cambiar foto. (155 * 138 px) ' +
					'			</div> ' +
					'		</div> ' +
					'		<div class="col-sm-offset-5 col-sm-2"> ' +
					'			<a href="javascript:void(0);" class="btn btn-info btn-xs saveDir" sId="'+lastId+'">Guardar</a> ' +
					'			<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteDir" sId="'+lastId+'">Eliminar</a> ' +
					'		</div> ' +
					'	</div> ' +
					'	<div class="col-sm-12 slider-section"> ' +
					'		<p>'+description+'</p> ' +
					'	</div> ' +
					'</div>';
	            	
	            	$('#dirBox').prepend(item);
	            	
	            	$('.saveDir').click(function(){
	            		saveDirectorio(this);
	            		return false;
	            	});
	            	
	            	$('.deleteDir').click(function(){
	            		deleteDirectorio(this);
	            		return false;
	            	});
	            	
	            	uploader(lastId);
	            	
	            	$('#newTestimonio').val('');
	            }
	        }
	    });
	}
}

function uploader(dirId)
{
	$('#uploadDir-'+dirId).uploadFile({
		url:		"/ajax/media.php",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
					directorioId: dirId,
					opt: 32
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			
			$('#iconDir'+dirId).attr('src',"/images-system/medium/"+imageGallery);
		}
	});	
}

function saveDirectorio(node)
{
	var sid	= $(node).attr('sId');

	var general 		= 0;
	var servicios 		= 0;
	var practicas 		= 0;
	var voluntariado 	= 0;
	var experiencia 	= 0;
	var embajadores 	= 0;
	var aliados		 	= 0;
	
	$('#causasSelector-'+sid+' .causas-selector-item').each(function(){
		var causaName = $(this).attr('causaName');
		switch (causaName)
		{
			case 'general':
				if ($(this).is(':checked'))
				{
					general = 1;
				}
			break;
			
			case 'servicios':
				if ($(this).is(':checked'))
				{
					servicios = 1;
				}
			break;
			
			case 'practicas':
				if ($(this).is(':checked'))
				{
					practicas = 1;
				}
			break;
			
			case 'voluntariado':
				if ($(this).is(':checked'))
				{
					voluntariado = 1;
				}
			break;
			
			case 'experiencia':
				if ($(this).is(':checked'))
				{
					experiencia = 1;
				}
			break;
			
			case 'embajadores':
				if ($(this).is(':checked'))
				{
					embajadores = 1;
				}
			break;
			
			case 'aliados':
				if ($(this).is(':checked'))
				{
					aliados = 1;
				}
			break;
			
		}
	});
	
	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  testimoniosId: 		sid,
	        	general:		general,
	        	servicios:		servicios,
	        	practicas:		practicas,
	        	voluntariado:	voluntariado,
	        	experiencia:	experiencia,
	        	embajadores:	embajadores,
	        	aliados:		aliados,
	            opt: 			62
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

function deleteDirectorio(node)
{
	var sid	= $(node).attr('sId');

	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  testimonioId: 		sid,
	            opt: 			61
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