<?php
$root = $_SERVER['DOCUMENT_ROOT'].'/';

/**
 * Includes the file /models/front/Layout_Model.php
 * in order to interact with the database
 */
require_once $root.'models/back/Layout_Model.php';

/**
 * Contains the classes for access to the basic app after log-in
 *
 * @package    Reservation System
 * @subpackage Tropical Casa Blanca Hotel
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <rd.castro.silva@gmail.com>
 */
class generalBackend
{
	protected  $model;
	
	/**
	 * Initialize a class, the model one
	 */
	
	public function __construct()
	{
		$this->model = new Layout_Model();
	}
	
	/**
	 * Based on the section it returns the right info that could be propagated along the application
	 *
	 * @param string $section
	 * @return array Array with the asked info of the application
	 */
	public function loadBackend($section = '')
	{
		$data 		= array();
		
// 		Info of the Application
		
		$appInfoRow = $this->model->getGeneralAppInfo();
		
		$appInfo = array( 
				'title' 		=> $appInfoRow['title'],
				'siteName' 		=> $appInfoRow['site_name'],
				'url' 			=> $appInfoRow['url'],
				'front'			=> $appInfoRow['front'],
				'content' 		=> $appInfoRow['content'],
				'description'	=> $appInfoRow['description'],
				'keywords' 		=> $appInfoRow['keywords'],
				'location'		=> $appInfoRow['location'],	
				'creator' 		=> $appInfoRow['creator'],
				'creatorUrl' 	=> $appInfoRow['creator_url'],
				'twitter' 		=> $appInfoRow['twitter'],
				'facebook' 		=> $appInfoRow['facebook'],
				'googleplus' 	=> $appInfoRow['googleplus'],
				'pinterest' 	=> $appInfoRow['pinterest'],
				'linkedin' 		=> $appInfoRow['linkedin'],
				'youtube' 		=> $appInfoRow['youtube'],
				'instagram'		=> $appInfoRow['instagram'],
				'email'			=> $appInfoRow['email'],
				'lang'			=> $appInfoRow['lang']
		);
		
		$data['appInfo'] = $appInfo;

		// Active Users
		$usersActiveArray 			= $this->model->getActiveUsers();
		$data['usersActive'] 		= $usersActiveArray;
		
		// User Info
		$userInfoRow 				= $this->model->getUserInfo();
		$data['userInfo'] 			= $userInfoRow;
		
		switch ($section) 
		{
			case 'companies':
				// 		get All companies
				$companiesArray 	= $this->model->getCompanies();
				$data['companies'] 	= $companiesArray;
			break;
			
			case 'banner':
				$slidersArray 		= $this->model->getBanner();
				$data['banner'] 	= $slidersArray;
			break;
			
			case 'footer':
				$slidersArray 		= $this->model->getFooter();
				$data['banner'] 	= $slidersArray;
			break;
			
			case 'main-sliders':
				$slidersArray 		= $this->model->getSliders();
				$data['sliders'] 	= $slidersArray;
			break;
			
			case 'aliados':
				$slidersArray 		= $this->model->getAliados();
				$data['aliados'] 	= $slidersArray;
				
				$causasArray		= $this->model->getCausas();
				$data['causas']		= $causasArray;
			break;
			
			case 'directorio':
				$directorioArray	= $this->model->getDirectorio();
				$data['directorio'] = $directorioArray; 
			break;
			
			case 'inicio':
				$causasArray		= $this->model->getCausas();
				$data['causas']		= $causasArray;
			break;
			
			case 'links':
				$linksArray		= $this->model->getLinks();
				$data['links']	= $linksArray;
			break;
			
			case 'espacios':
				$espaciosArray 		= $this->model->getEspacios();
				$data['espacios'] 	= $espaciosArray;
			break;
			
			case 'noticias':
				$newsArray 			= $this->model->getNews();
				$data['noticias'] 	= $newsArray;
			break;
			
			case 'logros':
				$logrosArray 	= $this->model->getAllLogros();
				$data['logros'] = $logrosArray;
				
				$fechasLogros 				= $this->model->getAllLogrosFechasDestacadas();
				$data['fechasDestacadas'] 	= $fechasLogros;
				
				$otrosLogros 			= $this->model->getAllLogrosOtros();
				$data['otrosLogros'] 	= $otrosLogros;
			break;
			
			case 'proyectos':
				$proyectosArray 	= $this->model->getProyectos();
				$data['proyectos'] 	= $proyectosArray;
			break;
			
			case 'actividades':
				$newsArray 				= $this->model->getActividades();
				$data['actividades'] 	= $newsArray;
			break;
			
			case 'campanas':
				$newsArray 			= $this->model->getCampanas();
				$data['campanas'] 	= $newsArray;
			break;
			
			case 'materiales':
				$newsArray 			= $this->model->getMateriales();
				$data['materiales'] 	= $newsArray;
			break;
			
			case 'voluntariado':
				$newsArray 			= $this->model->getVoluntariado($_GET['type']);
				$data['voluntariados'] 	= $newsArray;
			break;
			
			case 'embajadores':
				$newsArray 			= $this->model->getEmbajadores();
				$data['materiales'] 	= $newsArray;
			break;
			
			case 'contenidos':
				$newsArray 			= $this->model->getContenidos();
				$data['materiales'] 	= $newsArray;
			break;
			
			case 'testimonios':
				$newsArray 			= $this->model->getTestimonios();
				$data['testimonios'] 	= $newsArray;
			break;
			
			case 'productos':
				$newsArray 			= $this->model->getProductos();
				$data['productos'] 	= $newsArray;
			break;
			
			case 'documentos':
				$documentosArray = $this->model->getDocuments();
				$data['documentos'] = $documentosArray;
			break;
			
			case 'editar-seccion':
				switch ($_GET['kind']) 
				{
					case 1:// Causas
						$sectionRow 		= $this->model->getSeccionInfo($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
						
						$proyectosArray 	= $this->model->getProyectos();
						
						$i = 0;
						foreach ($proyectosArray as $proyecto)
						{
							if ($this->model->checkRelacionCausasProyectos($_GET['sectionId'], $proyecto['proyectos_id']))
							{
								$proyectosArray[$i]['checked'] = '1';
							}
						
							$i++;
						}
						
						$data['proyectos'] 	= $proyectosArray;
					break;
					
					case 2:// Links
						$sectionRow 		= $this->model->getLinkByLinkId($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
					break;
					
					case 3:// Espacios
						$sectionRow 		= $this->model->getEspaciosByEspacioId($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
						
						$bloquesArray 		= $this->model->getEspaciosBloques($_GET['sectionId']);
						$data['bloques'] 	= $bloquesArray;
						
						$newsArray 			= $this->model->getContenidos();
						$i = 0;
						foreach ($newsArray as $contenido)
						{
							if ($this->model->checkRelacionEspaciosContenidos($_GET['sectionId'], $contenido['materiales_id']))
							{
								$newsArray[$i]['checked'] = '1';
							}
						
							$i++;
						}
						$data['contenidos'] 	= $newsArray;
						
						$aliadosArray 		= $this->model->getAliados();
						$i = 0;
						foreach ($aliadosArray as $aliado)
						{
							if ($this->model->checkRelacionAliadosEspacios($_GET['sectionId'], $aliado['aliado_id']))
							{
								$aliadosArray[$i]['checked'] = '1';
							}
								
							$i++;
						}
						// 						var_dump($aliadosArray);
						$data['aliados'] 	= $aliadosArray;
					break;
					
					case 4:// Noticias
						$sectionRow 		= $this->model->getNewsById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
					
						$galleryArray  		= $this->model->getNewsGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
						
						$videosArray	= $this->model->getNewsVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					case 5://Logros
						$sectionRow 		= $this->model->getSingleLogro($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
					break;
					
					case 6://Proyectos
						$sectionRow = $this->model->getSingleProyecto($_GET['sectionId']);
						$data['section'] = $sectionRow;
						
						$linksArray = $this->model->getProyectosLinksByIdAndType($_GET['sectionId'], 1);
						$data['links-1'] = $linksArray;
						
						$linksArray = $this->model->getProyectosLinksByIdAndType($_GET['sectionId'], 2);
						$data['links-2'] = $linksArray;
						
						$linksArray = $this->model->getProyectosLinksByIdAndType($_GET['sectionId'], 3);
						$data['links-3'] = $linksArray;
						
						$galleryArray  		= $this->model->getProyectosGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
						
						$videosArray	= $this->model->getProyectosVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
						
						$aliadosArray 		= $this->model->getAliados();
						$i = 0;
						foreach ($aliadosArray as $aliado)
						{
							if ($this->model->checkRelacionAliadosProyectos($_GET['sectionId'], $aliado['aliado_id']))
							{
								$aliadosArray[$i]['checked'] = '1';
							}
							
							$i++;
						}
// 						var_dump($aliadosArray);
						$data['aliados'] 	= $aliadosArray;
					break;
					
					case 7:// actividades
						$sectionRow 		= $this->model->getActividadesById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
							
						$galleryArray  		= $this->model->getActividadesGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
					
						$videosArray	= $this->model->getActividadesVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					case 8:// Campañas
						$sectionRow 		= $this->model->getCampanasById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
					
						$linksArray = $this->model->getCampanasLinksByIdAndType($_GET['sectionId'], 3);
						$data['links-3'] = $linksArray;
						
						$linksArray = $this->model->getCampanasLinksByIdAndType($_GET['sectionId'], 4);
						$data['links-4'] = $linksArray;
						
						$galleryArray  		= $this->model->getCampanasGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
							
						$videosArray	= $this->model->getCampanasVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
						
						$aliadosArray 		= $this->model->getAliados();
						$i = 0;
						foreach ($aliadosArray as $aliado)
						{
							if ($this->model->checkRelacionAliadosCampanas($_GET['sectionId'], $aliado['aliado_id']))
							{
								$aliadosArray[$i]['checked'] = '1';
							}
								
							$i++;
						}

						$data['aliados'] 	= $aliadosArray;
					break;
					
					case 9:// materiales
						$sectionRow 		= $this->model->getMaterialesById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
							
						$galleryArray  		= $this->model->getMaterialesGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
							
						$videosArray	= $this->model->getMaterialesVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					case 10: // voluntariado
						$sectionRow 		= $this->model->getVoluntariadoById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
					break;
					
					case 11:// embajadores
						$sectionRow 		= $this->model->getEmbajadoresById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
							
						$galleryArray  		= $this->model->getEmbajadoresGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
							
						$videosArray	= $this->model->getEmbajadoresVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					case 12:// contenidos
						$sectionRow 		= $this->model->getContenidosById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
							
						$galleryArray  		= $this->model->getContenidosGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
							
						$videosArray	= $this->model->getContenidosVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					case 13:// productos
						$sectionRow 		= $this->model->getProductosById($_GET['sectionId']);
						$data['section'] 	= $sectionRow;
							
						$galleryArray  		= $this->model->getProductosGallery($_GET['sectionId']);
						$data['gallery'] 	= $galleryArray;
							
						$videosArray	= $this->model->getProductosVideo($_GET['sectionId']);
						$data['videos'] = $videosArray;
					break;
					
					default:
						;
					break;
				}
				 
			break;
			
			default:
			break;
		}
		
		return $data;
	}
}

$backend = new generalBackend();

// $info = $backend->loadBackend();
// var_dump($info['categoryInfo']);