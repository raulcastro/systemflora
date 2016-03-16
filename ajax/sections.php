<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root.'/models/back/Layout_Model.php');
require_once($root.'/views/Layout_View.php');
require_once $root.'/backends/admin-backend.php';
require_once $root.'/Framework/Tools.php';
$model	= new Layout_Model();


$memberId = (int) $_POST['memberId'];

switch ($_POST['opt'])
{
	
	case 1://Update Causas
		if ($model->updateCausas($_POST))
		{
			echo 1;
		}
	break;
	
	case 2://Update links
		if($model->updateLinks($_POST))
		{
			echo 1;
		}
	break;
	
	case 3://Update espacios
		if($model->updateEspacios($_POST))
		{
			echo 1;
		}
	break;
	
	case 4:// delete espacios bloques
		if ($model->deleteEspaciosBloques($_POST['bloqueId']))
		{
			echo 1;
		}
	break;
	
	case 5:// Añade un bloque a espacios
		if ($bloqueId = $model->addBloque($_POST))
		{
			echo $bloqueId;
		}
	break;
	
	case 6:// Añade una noticia
		if ($noticiaId = $model->addNews($_POST))
		{
			echo $noticiaId;
		}
	break;
	
	case 7:// Delete news
		if ($model->deleteNew($_POST['noticias_id']))
		{
			echo 1;
		}
	break;
	
	case 8://update noticias
		if ($model->updateNews($_POST))
		{
			echo 1;
		}
	break;
	
	case 9:
		if ($model->deleteNewsPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 10:
		if($model->addNewsVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 11:
		if($model->deleteNewsVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 12:
		if ($model->updateDirectorio($_POST))
		{
			echo 1;
		}
	break;
	
	case 13:
		if ($model->deleteDirectorio($_POST['directorioId']))
		{
			echo 1;
		}
	break;
	
	case 14:
		if ($lastDir = $model->addDirectorio($_POST))
		{
			echo $lastDir;
		}
	break;
	
	case 15:// Add Logro
		if ($lastLogro = $model->addLogros($_POST))
		{
			echo $lastLogro;
		}
	break;
	
	case 16:// Delete Logro
		if ($model->deleteLogro($_POST['logros_id']))
		{
			echo 1;
		}
	break;
	
	case 18://Update Logros
		if ($model->updateLogros($_POST))
		{
			echo 1;
		}
	break;
	
	case 19:
		if ($lastFecha = $model->addLogrosFechasDestacadas($_POST))
		{
			echo $lastFecha;
		}
	break;
	
	case 20:
		if ($model->deleteLogrosFechas($_POST['logros_id']))
		{
			echo 1;
		}
	break;
	
	case 21:
		if ($lastOtroLogro = $model->addLogrosOtros($_POST))
		{
			echo $lastOtroLogro;
		}
	break;
	
	case 22:
		if ($model->deleteLogrosOtros($_POST['logros_id']))
		{
			echo 1;
		}
	break;
	
	case 23:
		if ($lastProyecto = $model->addProyectos($_POST))
		{
			echo $lastProyecto;
		}
	break;
	
	case 24:
		if ($model->deleteProyectos($_POST['logros_id']))
		{
			echo 1;
		}
	break;
	
	case 25:
		if ($model->updateProyectos($_POST))
		{
			echo 1;
		}
	break;
	
	case 26:
		if ($lastLink = $model->addProyectosLinks($_POST))
		{
			echo $lastLink;
		}
	break;
	
	case 27:
		if ($model->deleteProyectosLinksById($_POST['linkId']))
		{
			echo 1;
		}
	break;
	
	case 28:
		if($model->addProyectosVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 29:
		if($model->deleteProyectosVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 30:
		if ($model->deleteProyectosPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	default:
	break;
}