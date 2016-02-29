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
			
			case 'main-sliders':
				$slidersArray 		= $this->model->getSliders();
				$data['sliders'] 	= $slidersArray;
			break;
			
			case 'aliados':
				$slidersArray 		= $this->model->getAliados();
				$data['aliados'] 	= $slidersArray;
			break;
			
			case 'inicio':
				$causasArray		= $this->model->getCausas();
				$data['causas']		= $causasArray;
			break;
			
			case 'links':
				$linksArray		= $this->model->getLinks();
				$data['links']		= $linksArray;
			break;
			
			case 'espacios':
				$espaciosArray = $this->model->getEspacios();
				$data['espacios'] = $espaciosArray;
			break;
			
			case 'noticias':
				$newsArray = $this->model->getNews();
				$data['noticias'] = $newsArray;
			break;
			
			case 'editar-seccion':
				switch ($_GET['kind']) 
				{
					case 1:// Causas
						$sectionRow = $this->model->getSeccionInfo($_GET['sectionId']);
						$data['section'] = $sectionRow;
					break;
					
					case 2:// Links
						$sectionRow = $this->model->getLinkByLinkId($_GET['sectionId']);
						$data['section'] = $sectionRow;
					break;
					
					case 3:// Espacios
						$sectionRow = $this->model->getEspaciosByEspacioId($_GET['sectionId']);
						$data['section'] = $sectionRow;
						
						$bloquesArray = $this->model->getEspaciosBloques($_GET['sectionId']);
						$data['bloques'] = $bloquesArray;
					break;
					
					case 4:// Noticias
						$sectionRow = $this->model->getNewsById($_GET['sectionId']);
						$data['section'] = $sectionRow;
					
						$galleryArray  = $this->model->getNewsGallery($_GET['sectionId']);
						$data['gallery'] = $galleryArray;
						
						$videosArray	= $this->model->getNewsVideo($_GET['sectionId']);
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