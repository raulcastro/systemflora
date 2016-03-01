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
	
	case 8:
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
	
	default:
	break;
}