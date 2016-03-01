$(document).ready(function()
{
	$('#addDir').click(function(){
		addDirectorio();
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
	
	$(".upload-disr").uploadFile({
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
			
//			$('#slidersBox').prepend(itemGallery);
//			
//			$('.saveSlider').click(function(){
//				saveSlider(this);
//				return false;
//			});
//			
//			$('.deleteSlider').click(function(){
//				deleteSlider(this);
//				return false;
//			});
		}
	});
});

function addDirectorio()
{
	var dirName	= $('#dirName').val();
	var dirCharge 	= $('#dirCharge').val();
	var dirEmail 	= $('#dirEmail').val();
	
	if (dirName)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	dirName:	dirName,
	        	dirCharge: 	dirCharge,
	        	dirEmail: 	dirEmail,
	            opt: 			14
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
					'		<div class="col-sm-4"> ' +
					'			<input type="text" placeholder="Nombre" class="form-control" id="dirName-'+lastId+'" value=""> ' +
					'		</div> ' +
					'		<div class="col-sm-4"> ' +
					'			<input type="text" placeholder="Titulo" class="form-control" id="dirCharge-'+lastId+'" value=""> ' +
					'		</div> ' +
					'		<div class="col-sm-4"> ' +
					'			<input type="text" placeholder="E-Mail" class="form-control" id="dirEmail-'+lastId+'" value=""> ' +
					'		</div> ' +
					'	</div> ' +
					'</div>';
	            	
	            	$('#dirBox').append(item);
	            	
	            	$('.saveDir').click(function(){
	            		saveDirectorio(this);
	            		return false;
	            	});
	            	
	            	$('.deleteDir').click(function(){
	            		deleteDirectorio(this);
	            		return false;
	            	});
	            	
	            	uploader(lastId);
//	            	alert('Informacion actualizada!');
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
					opt: 16 
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
	var dirName	= $('#dirName-'+sid).val();
	var dirCharge 	= $('#dirCharge-'+sid).val();
	var dirEmail 	= $('#dirEmail-'+sid).val();
	
	if (sid)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  directorioId: 		sid,
	        	dirName:	dirName,
	        	dirCharge: 	dirCharge,
	        	dirEmail: 	dirEmail,
	            opt: 			12
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
	        data:{  directorioId: 		sid,
	            opt: 			13
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