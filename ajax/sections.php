<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root.'/models/back/Layout_Model.php');
require_once($root.'/views/Layout_View.php');
require_once $root.'/backends/admin-backend.php';
require_once $root.'/Framework/Tools.php';
$model	= new Layout_Model();
$data 	= $backend->loadBackend();

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
	
	case 31:// Añade una actividad
		if ($noticiaId = $model->addActividad($_POST))
		{
			echo $noticiaId;
		}
	break;
	
	case 32:// Delete actividad
		if ($model->deleteActividades($_POST['actividades_id']))
		{
			echo 1;
		}
	break;
	
	case 33://update actividades
		if ($model->updateActividades($_POST))
		{
			echo 1;
		}
	break;
	
	case 34:
		if ($model->deleteActividadesPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 35:
		if($model->addActividadesVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 36:
		if($model->deleteActividadesVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 37:
		if ($lastCampana = $model->addCampana($_POST))
		{
			echo $lastCampana;
		}
	break;
	
	case 38:
		if ($model->deleteCampanas($_POST['campanas_id']))
		{
			echo 1;
		}
	break;
	
	case 39:
		if ($model->updateCampanas($_POST))
		{
			echo 1;
		}
	break;
	
	case 40:
		if ($lastLink = $model->addCampanasLinks($_POST))
		{
			echo $lastLink;
		}
	break;
	
	case 41:
		if ($model->deleteCampanasLinksById($_POST['linkId']))
		{
			echo 1;
		}
	break;
	
	case 42:
		if ($model->deleteCampanasPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 43:
		if($model->addCampanasVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 44:
		if($model->deleteCampanasVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 45:
		if ($lastMaterial = $model->addMaterial($_POST))
		{
			echo $lastMaterial;
		}
	break;
	
	case 46:// Delete material
		if ($model->deleteMateriales($_POST['materiales_id']))
		{
			echo 1;
		}
	break;
	
	case 47:
		if ($model->updateMateriales($_POST))
		{
			echo 1;
		}
	break;
	
	case 48:
		if ($model->deleteMaterialesPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 49:
		if($model->addMaterialesVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 50:
		if($model->deleteMaterialesVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 51:
		if ($last = $model->addVoluntariado($_POST))
		{
			echo $last;
		}
	break;
	
	case 52:
		if ($model->deleteVoluntariado($_POST['voluntariado_id']))
		{
			echo 1;
		}
	break;
	
	case 53:
		if ($model->updateVoluntariado($_POST))
		{
			echo 1;
		}
	break;
	
	case 54:
		if ($lastMaterial = $model->addEmbajadores($_POST))
		{
			echo $lastMaterial;
		}
	break;
	
	case 55:// Delete material
		if ($model->deleteEmbajadores($_POST['materiales_id']))
		{
			echo 1;
		}
	break;
	
	case 56:
		if ($model->updateEmbajadores($_POST))
		{
			echo 1;
		}
	break;
	
	case 57:
		if ($model->deleteEmbajadoresPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 58:
		if($model->addEmbajadoresVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 59:
		if($model->deleteEmbajadoresVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 60:
		if ($last = $model->addTestimonios($_POST))
		{
			echo $last;
		}
	break;
	
	case 61:// Delete material
		if ($model->deleteTestimonios($_POST['testimonioId']))
		{
			echo 1;
		}
	break;
	
	case 62:
		if ($model->updateTestimonios($_POST))
		{
			echo 1;
		}
	break;
	
	case 63:
		if ($model->addRelacionAliadosProyectos($_POST['sectionId'], $_POST['aliadoId']))
		{
			echo 1;
		}
	break;
	
	case 64:
		if ($model->deleteRelacionAliadosProyectos($_POST['sectionId']))
		{
			echo 1;
		}
	break;
	
	case 65:
		if ($model->addRelacionCausasProyectos($_POST['sectionId'], $_POST['aliadoId']))
		{
			echo 1;
		}
	break;
	
	case 66:
		if ($model->deleteRelacionCausasProyectos($_POST['sectionId']))
		{
			echo 1;
		}
	break;
	
	case 67:
		if ($lastMaterial = $model->addContenidos($_POST))
		{
			echo $lastMaterial;
		}
	break;
	
	case 68:// Delete material
		if ($model->deleteContenidos($_POST['materiales_id']))
		{
			echo 1;
		}
	break;
	
	case 69:
		if ($model->updateContenidos($_POST))
		{
			echo 1;
		}
	break;
	
	case 70:
		if ($model->deleteContenidosPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 71:
		if($model->addContenidosVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 72:
		if($model->deleteContenidosVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 73:
		if ($model->addRelacionEspaciosContenidos($_POST['sectionId'], $_POST['aliadoId']))
		{
			echo 1;
		}
	break;
	
	case 74:
		if ($model->deleteRelacionEspaciosContenidos($_POST['sectionId']))
		{
			echo 1;
		}
	break;
	
	case 75:
		if ($lastMaterial = $model->addProductos($_POST))
		{
			echo $lastMaterial;
		}
	break;
	
	case 76:// Delete material
		if ($model->deleteProductos($_POST['materiales_id']))
		{
			echo 1;
		}
	break;
	
	case 77:
		if ($model->updateProductos($_POST))
		{
			echo 1;
		}
	break;
	
	case 78:
		if ($model->deleteProductosPicture($_POST['pictureId']))
		{
			echo 1;
		}
	break;
	
	case 79:
		if($model->addProductosVideo($_POST))
		{
			echo 1;
		}
	break;
	
	case 80:
		if($model->deleteProductosVideo($_POST['videoId']))
		{
			echo 1;
		}
	break;
	
	case 81:
		if ($model->addRelacionAliadosCampanas($_POST['sectionId'], $_POST['aliadoId']))
		{
			echo 1;
		}
	break;
	
	case 82:
		if ($model->deleteRelacionAliadosCampanas($_POST['sectionId']))
		{
			echo 1;
		}
	break;
	
	case 83:
		if ($documents = $model->getDocuments())
		{
			foreach ($documents as $documento)
			{
				$url = $data['appInfo']['url'].'/pdf/'.$documento['documento'];
				echo Layout_View::getDocumentosItem($documento, $url);
			}
		}
	break;
	
	case 84:
		if ($model->deleteDocument($_POST['id']))
		{
			echo 1;
		}
	break;
	
	case 85:
		if ($model->addRelacionAliadosEspacios($_POST['sectionId'], $_POST['aliadoId']))
		{
			echo 1;
		}
	break;
	
	case 86:
		if ($model->deleteRelacionAliadosEspacios($_POST['sectionId']))
		{
			echo 1;
		}
	break;
	
	case 87:
		if ($model->updateSocial($_POST))
		{
			echo 1;
		}
	break;
	
	default:
	break;
}