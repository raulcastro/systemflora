$(document).ready(function()
{
	$('#addLogro').click(function(){
		addLogro();
		return false;
	});
	
	$('#updateSection').click(function(){
		updateSection();
		return false;
	});
	
	$('#addFechaDestacada').click(function(){
		addFechaDestacada();
		return false;
	});
	
	$('#addOtrosLogros').click(function(){
		addOtrosLogros();
		return false;
	});
	
	$('.deleteLogro').click(function(){
		deleteLogro(this);
		return false;
	});
	
	$('.deleteLogrosFechas').click(function(){
		deleteLogrosFechas(this);
		return false;
	});
	
	$('.deleteOtrosLogros').click(function(){
		deleteOtrosLogros(this);
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
				opt: 17
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
				opt: 18
			},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			$('#portraitImg').attr('src', '/images-system/medium/'+imageGallery);
		}
	});
});

function addLogro()
{
	
	var logroTitle = $('#newLogroTitle').val();
	
	if (logroTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	logroTitle,
	            opt: 		15
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
	            		+ '		<p class="section-title"><strong>'+logroTitle+'</strong></p>'
	            		+ '	</div>'
	            		+ '	<div class="col-sm-1">'
	            		+ '		<a href="/editar-logros/'+newId+'/nuevo-logro/5/" class="btn btn-info btn-xs deleteSlider" sId="'+newId+'">Editar</a>'
	            		+ '	</div>'
	            		+ '</div>'
	            		+ '</div>';
	            	
	            	$('#logrosBox').prepend(item);
	            	$('#newLogroTitle').val('');
	            		
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
	
	if (sectionId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  sectionId: 			sectionId,
	        	sectionTitle:			sectionTitle,
	        	sectionDescription: 	sectionDescription,
	            opt: 					18
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

function deleteLogro(node)
{
	var sId = $(node).attr('sId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  logros_id: 	sId,
	            	opt: 			16
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

function addFechaDestacada()
{
	
	var newTitle 	= $('#newFechaDestacadaTitle').val();
	var newURL 		= $('#newFechaDestacadaURL').val();
	
	if (newTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	newTitle,
	        	newURL: newURL,
	            opt: 		19
	             },
	        success:
	        function(newId)
	        {
	            if (0 != newId)
	            {
	            	var item = '<div class="col-sm-12 slider-item" id="sId-'+newId+'">'+
			    		'	<div class="col-sm-12">'+
						'		<div class=" col-sm-9">'+
						'			<p class="section-title"><strong>'+newTitle+'</strong></p>'+
						'			<p class="section-title">'+newURL+'</p>'+
						'		</div>'+
						'		<div class="col-sm-1 col-sm-offset-2">'+
						'			<a href="" class="btn btn-danger btn-xs deleteLogrosFechas" sId="'+newId+'">Eliminar</a>'+
						'		</div>'+
						'	</div>'+
						'</div>';
	            	
	            	$('#fechasDestacadasBox').prepend(item);
	            	
	            	$('.deleteLogrosFechas').click(function(){
	            		deleteLogrosFechas(this);
	            		return false;
	            	});
	            	
	            	$('#newFechaDestacadaTitle').val('');
	            	$('#newFechaDestacadaURL').val('');	
	            }
	        }
	    });
	}
}

function deleteLogrosFechas(node)
{
	var sId = $(node).attr('sId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  logros_id: 	sId,
	            	opt: 		20
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


function addOtrosLogros()
{
	
	var newTitle = $('#newOtrosLogrosTitle').val();

	if (newTitle)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  
	        	newTitle: 	newTitle,
	            opt: 		21
	             },
	        success:
	        function(newId)
	        {
	            if (0 != newId)
	            {
	            	var item = '<div class="col-sm-12 slider-item" id="sId-'+newId+'">'+
			    		'	<div class="col-sm-12">'+
						'		<div class=" col-sm-9">'+
						'			<p class="section-title"><strong>'+newTitle+'</strong></p>'+
						'		</div>'+
						'		<div class="col-sm-1 col-sm-offset-2">'+
						'			<a href="" class="btn btn-danger btn-xs deleteOtrosLogros" sId="'+newId+'">Eliminar</a>'+
						'		</div>'+
						'	</div>'+
						'</div>';
	            	
	            	$('#otrosLogrosBox').prepend(item);
	            	
	            	$('.deleteOtrosLogros').click(function(){
	            		deleteOtrosLogros(this);
	            		return false;
	            	});
	            	
	            	$('#newOtrosLogrosTitle').val('');
	            }
	        }
	    });
	}
}

function deleteOtrosLogros(node)
{
	var sId = $(node).attr('sId');
	
	if (sId)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/sections.php',
	        data:{  logros_id: 	sId,
	            	opt: 		22
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
