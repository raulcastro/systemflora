<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root.'/models/back/Layout_Model.php');
require_once($root.'/models/back/Media_Model.php');
require_once($root.'/views/Layout_View.php');
require_once $root.'/backends/admin-backend.php';
require_once $root.'/Framework/Tools.php';
$model	= new Layout_Model();

$memberId = (int) $_POST['memberId'];

switch ($_POST['opt'])
{
// 	Add Slider
	case 1: 
		$model	= new Layout_Model();
		$data 	= $backend->loadBackend();
		
		$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
		$sizeLimit 	= 20 * 1024 * 1024;
		
		$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
		$savePath 		= $root.'/images-system/original/';
		$medium 		= $root.'/images-system/sliders/';
		$pre	  		= 'slider';
		$mediumWidth 	= 250;
		
		if ($result = $uploader->handleUpload($savePath, $pre))
		{
			$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
					'width', '');
		
			$newData = getimagesize($medium.$result['fileName']);
		
			$wp     = $newData[0];
			$hp     = $newData[1];
			
			$lastId = 0;
			
			if ($newData)
			{
				$lastId = $model->addSlider($result['fileName']);
			}
		
			$data  = array('success'=>true, 'fileName'=>$result['fileName'],
					'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
			echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
		}
	break;
	
// 	Update Slider
	case 2:	 
		if ($model->updateSlider($_POST));
		{
			echo 1;
		}
	break;
	
// 	Delete Slider
	case 3:
		if ($model->deleteSlider($_POST))
		{
			echo 1;
		}
	break;
	
	case 4: // add principal banner
		$model	= new Layout_Model();
		$data 	= $backend->loadBackend();
	
		$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
		$sizeLimit 	= 20 * 1024 * 1024;
	
		$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
	
		$savePath 		= $root.'/images-system/original/';
		$medium 		= $root.'/images-system/medium/';
		$pre	  		= 'banner';
		$mediumWidth 	= 300;
	
		if ($result = $uploader->handleUpload($savePath, $pre))
		{
			$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
					'width', '');
	
			$newData = getimagesize($medium.$result['fileName']);
	
			$wp     = $newData[0];
			$hp     = $newData[1];
				
			$lastId = 0;
				
			if ($newData)
			{
				$lastId = $model->addBanner($result['fileName']);
			}
	
			$data  = array('success'=>true, 'fileName'=>$result['fileName'],
					'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
	
			echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
		}
		break;
		
		// 	Delete Banner
		case 5:
			if ($model->deleteBanner($_POST))
			{
				echo 1;
			}
		break;
	
		case 6: // add principal banner
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'aliado';
			$mediumWidth 	= 170;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				if ($newData)
				{
					$lastId = $model->addAliados($result['fileName']);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		// 	Update Aliados
		case 7:
			if ($model->updateAliados($_POST));
			{
				echo 1;
			}
		break;
		
		// 	Update Aliados
		case 8:
			if ($model->deleteAliado($_POST));
			{
				echo 1;
			}
		break;
		
		case 9: // update causas icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'causas';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$info = array('icon'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
				
				if ($newData)
				{
					$lastId = $model->updateCausasIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 10: // update links icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'link';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$info = array('icon'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateLinksIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 11: // update links icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'link';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$info = array('icon'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateEspaciosIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 12: // change spaces background
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'espacios';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
				
				if ($newData)
				{
					$lastId = $model->updateEspaciosBackground($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 13: // change news icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'noticias-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
				
				if ($newData)
				{
					$lastId = $model->updateNewsIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 14: // change news portrait
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'noticias-portrait';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateNewsPortrait($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 15: // Add news gallery
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'noticias-portrait';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->addNewsGallery($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 16: // Update directorio-icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'directorio';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('icon'=>$result['fileName'], 'directorioId'=>$_POST['directorioId']);
		
				if ($newData)
				{
					$lastId = $model->updateDirectorioIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 17: // change logros icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'logros-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
				
				if ($newData)
				{
					$lastId = $model->updateLogrosIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 18: // change news portrait
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'logros-portrait';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateLogrosPortrait($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 19: // change proyectos icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'proyectos-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateProyectosIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
	
		case 20: // Add proyectos gallery
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'proyectos-gallery';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->addProyectosGallery($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 21: // change actividades icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'actividades-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateActividadesIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 22: // change actividades portrait
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'actividades-portrait';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateActividadesPortrait($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 23: // Add actividades gallery
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'actividades-gallery';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->addActividadesGallery($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 24: // change campanas icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'campanas-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateCampanasIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 25: // change actividades portrait
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'campanas-portrait';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateCampanasPortrait($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 26: // Add actividades gallery
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'campanas-gallery';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->addCampanasGallery($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 27: // change materiales icon
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'materiales-icon';
			$mediumWidth 	= 100;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('background'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->updateMaterialesIcon($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
		case 28: // Add actividades gallery
			$model	= new Layout_Model();
			$data 	= $backend->loadBackend();
		
			$allowedExtensions = array("jpg", "JPG", "jpeg", "png");
			$sizeLimit 	= 20 * 1024 * 1024;
		
			$uploader 	= new Media_Model($allowedExtensions, $sizeLimit);
		
			$savePath 		= $root.'/images-system/original/';
			$medium 		= $root.'/images-system/medium/';
			$pre	  		= 'materiales-gallery';
			$mediumWidth 	= 300;
		
			if ($result = $uploader->handleUpload($savePath, $pre))
			{
				$uploader->getThumb($result['fileName']	, $savePath, $medium, $mediumWidth,
						'width', '');
		
				$newData = getimagesize($medium.$result['fileName']);
		
				$wp     = $newData[0];
				$hp     = $newData[1];
		
				$lastId = 0;
		
				$info = array('image'=>$result['fileName'], 'sectionId'=>$_POST['sectionId']);
		
				if ($newData)
				{
					$lastId = $model->addMaterialesGallery($info);
				}
		
				$data  = array('success'=>true, 'fileName'=>$result['fileName'],
						'wp'=>$wp, 'hp'=>$hp, 'lastId'=>$lastId);
		
				echo htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			}
		break;
		
	default:
	break;
}