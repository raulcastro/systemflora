$(document).ready(function()
{
	$('#updateRedes').click(function(){
		updateSection();
		return false;
	});
});

function updateSection()
{
	var rTwitter = $('#rTwitter').val();
	var rFacebook = $('#rFacebook').val();
	var rGoogle = $('#rGoogle').val();
	var rPinterest = $('#rPinterest').val();
	var rLinkedin = $('#rLinkedin').val();
	var rYoutube = $('#rYoutube').val();
	var rInstagram = $('#rInstagram').val();
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/sections.php',
        data:{  rTwitter: rTwitter,
        	rFacebook : rFacebook, 
        	rGoogle : rGoogle,
        	rPinterest: rPinterest,
        	rLinkedin: rLinkedin,
        	rYoutube: rYoutube,
        	rInstagram: rInstagram,
            opt: 		87
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





