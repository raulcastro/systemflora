<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/Framework/Back_Default_Header.php';

/**
 * Contains the methods for interact with the databases
 *
 * @package    Reservation System
 * @subpackage Tropical Casa Blanca Hotel
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <rd.castro.silva@gmail.com>
 */
class Layout_Model
{
    private $db; 
	
    /**
     * Initialize the MySQL Link
     */
	public function __construct()
	{
		$this->db = new Mysqli_Tool(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	
	/**
	 * getGeneralAppInfo
	 *
	 * get all the info that from the table app_info, this is about the application
	 * the name, url, creator and so
	 *
	 * @return array row containing the info
	 */
	
	public function getGeneralAppInfo()
	{
		try {
			$query = 'SELECT * FROM app_info';
	
			return $this->db->getRow($query);
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Get the user info
	 * 
	 * Get's the user detail {user_id, name, ...}
	 * 
	 * @return mixed|bool An array of info or false
	 */
	public function getUserInfo()
	{
		try {
			$query = "SELECT 
					u.user_id,
					u.type,
					d.name, 
					u.type, 
					ue.email as user_email, 
					ue.inbox
					FROM users u 
					LEFT JOIN user_detail d ON u.user_id = d.user_id 
					LEFT JOIN user_emails ue ON u.user_id = ue.user_id
					WHERE u.user_id = ".$_SESSION['userId'];
			return $this->db->getRow($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Get only the active users
	 * 
	 * @return mixed|bool An array of info or false
	 */
	public function getActiveUsers()
	{
		try {
			$query = 'SELECT 
					ud.user_id, 
					ud.name 
					FROM users u 
					LEFT JOIN user_detail ud ON ud.user_id = u.user_id
					WHERE u.active = 1  
					';
			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	
	
	public function addSlider($name)
	{
		try
		{
			$query = 'INSERT INTO sliders(slider)
	                VALUES(?)';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param(
					's',
					$name
					);
				
			if ($prep->execute())
				return $prep->insert_id;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function getSliders()
	{
		try {
			$query = 'SELECT * FROM sliders ORDER BY slider_id DESC';
			
			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateSlider($data)
	{
		try {
			$query = 'UPDATE sliders 
					SET 
					title = ?,
					link = ?,
					info = ?
					WHERE slider_id = ?
					';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param(
					'sssi', 
					$data['titleSlider'],
					$data['linkSlider'],
					$data['infoSlider'],
					$data['sId']
					);
			
			return $prep->execute();
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteSlider($data)
	{
		try {
			$query = 'DELETE FROM sliders WHERE slider_id = ?';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('i', $data['sId']);
			
			if($prep->execute())
			{
				return true;
			}
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addBanner($name)
	{
		try
		{
			$query = 'DELETE FROM banner';
			
			if ($this->db->run($query))
			{
				$query = 'INSERT INTO banner(banner)
	                VALUES(?)';
				
				$prep = $this->db->prepare($query);
				
				$prep->bind_param(
						's',
						$name
				);
				
				if ($prep->execute())
					return $prep->insert_id;
			}
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function getBanner()
	{
		try {
			$query = 'SELECT * FROM banner';
				
			return $this->db->getRow($query);
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteBanner($data)
	{
		try {
			$query = 'DELETE FROM banner WHERE banner_id = ?';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('i', $data['sId']);
				
			if($prep->execute())
			{
				return true;
			}
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addFooter($name)
	{
		try
		{
			$query = 'DELETE FROM footer';
				
			if ($this->db->run($query))
			{
				$query = 'INSERT INTO footer(banner)
	                VALUES(?)';
	
				$prep = $this->db->prepare($query);
	
				$prep->bind_param(
						's',
						$name
				);
	
				if ($prep->execute())
					return $prep->insert_id;
			}
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function getFooter()
	{
		try {
			$query = 'SELECT * FROM footer';
	
			return $this->db->getRow($query);
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteFooter($data)
	{
		try {
			$query = 'DELETE FROM footer WHERE banner_id = ?';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('i', $data['sId']);
	
			if($prep->execute())
			{
				return true;
			}
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAliados()
	{
		try {
			$query = 'SELECT * FROM aliados ORDER BY aliado_id DESC';
	
			return $this->db->getArray($query);
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addAliados($name)
	{
		try
		{
			$query = 'INSERT INTO aliados(aliado)
	                VALUES(?)';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param(
					's',
					$name
			);
	
			if ($prep->execute())
				return $prep->insert_id;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function updateAliados($data)
	{
		try {
			$query = 'UPDATE aliados
					SET
					twitter = ?,
					facebook = ?,
					gplus = ?,
					conservacion = ?,
					bienestar = ?,
					educacion = ?
					WHERE aliado_id = ?
					';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param(
					'sssiiii',
					$data['titleSlider'],
					$data['linkSlider'],
					$data['infoSlider'],
					$data['conservacion'],
					$data['bienestar'],
					$data['educacion'],
					$data['sId']
			);
				
			return $prep->execute();
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteAliado($data)
	{
		try {
			$query = 'DELETE FROM aliados WHERE aliado_id = ?';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('i', $data['sId']);
	
			if($prep->execute())
			{
				return true;
			}
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCausas()
	{
		try {
			$query = 'SELECT * FROM causas';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMediumIndexSections()
	{
		try {
			$query = 'SELECT * FROM sections WHERE on_index = 1 AND segment = "medium"';
				
			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getBottomIndexSection() {
		try {
			
			$query = 'SELECT * FROM sections WHERE on_index = 1 AND segment = "bottom"';
			
			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getSeccionInfo($section_id)
	{
		try {
			$section_id = (int) $section_id;
			
			$query = 'SELECT * FROM causas WHERE causas_id = '.$section_id;

			return $this->db->getRow($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateCausasIcon($data)
	{
		try {
			$query = 'UPDATE causas SET icon = ? WHERE causas_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['icon'], $data['sectionId']);
			
			return $prep->execute();
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateCausas($data)
	{
		try {
			$query = 'UPDATE causas SET title = ?, description = ?, content = ? WHERE causas_id = ?';
			
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi', 
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
			
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getLinks()
	{
		try {
			$query = 'SELECT * FROM links';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getLinkByLinkId($link_id)
	{
		try {
			$link_id = (int) $link_id;
			$query = 'SELECT * FROM links WHERE link_id = '.$link_id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateLinksIcon($data)
	{
		try {
			$query = 'UPDATE links SET icon = ? WHERE link_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['icon'], $data['sectionId']);
				
			return $prep->execute();
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateLinks($data)
	{
		try {
			$query = 'UPDATE links SET title = ?, description = ?, content = ? WHERE link_id = ?';
				
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
				
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEspacios()
	{
		try {
			$query = 'SELECT * FROM espacios';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEspaciosByEspacioId($espacio_id)
	{
		try {
			$espacio_id = (int) $espacio_id;
			$query = 'SELECT * FROM espacios WHERE espacios_id = '.$espacio_id;

			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateEspaciosIcon($data)
	{
		try {
			$query = 'UPDATE espacios SET icon = ? WHERE espacios_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['icon'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateEspaciosBackground($data)
	{
		try {
			$query = 'UPDATE espacios SET background = ? WHERE espacios_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateEspacios($data)
	{
		try {
			$query = 'UPDATE espacios SET
					title = ?,
					description = ?,
					content = ?,
					second_column_title = ?,
					third_column_title = ?,
					third_column_content = ?,
					video = ?
					WHERE espacios_id = ?
					';
			
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssssssi', 
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['secondColumnTitle'],
					$data['thirdColumnTitle'],
					$data['thirdColumnContent'],
					$data['singleVideo'],
					$data['sectionId']
					);
			
			return $prep->execute();
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addBloque($data)
	{
		try {
			$query = 'INSERT INTO espacios_bloques(espacios_id, title, description) VALUES(?, ?, ?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('iss', $data['sectionId'], $data['bloqueTitle'], $data['bloqueContent']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEspaciosBloques($espacioId)
	{
		try {
			$espacioId = (int) $espacioId;
			
			$query = 'SELECT * FROM espacios_bloques WHERE espacios_id = '.$espacioId.' ORDER BY espacios_bloques_id DESC';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteEspaciosBloques($bloqueId)
	{
		try {
			$query = 'DELETE FROM espacios_bloques WHERE espacios_bloques_id = '.$bloqueId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addNews($data)
	{
		try {
			$query = 'INSERT INTO noticias(title, date) VALUES(?, ?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('ss', $data['newTitle'], Tools::formatToMYSQL($data['newDate']));
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getNewsById($noticiasId)
	{
		try {
			$noticiasId = (int) $noticiasId;
			$query = 'SELECT * FROM noticias WHERE noticias_id = '.$noticiasId;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getNews()
	{
		try {
			$query = 'SELECT * FROM noticias ORDER BY date DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteNew($noticias_id)
	{
		try {
			$noticias_id = (int) $noticias_id;
			$query = 'DELETE FROM noticias WHERE noticias_id = '.$noticias_id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateNewsIcon($data)
	{
		try {
			$query = 'UPDATE noticias SET icon = ? WHERE noticias_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateNewsPortrait($data)
	{
		try {
			$query = 'UPDATE noticias SET portrait = ? WHERE noticias_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateNews($data)
	{
		try {
			$query = 'UPDATE noticias SET 
					title = ?, 
					description = ?, 
					content = ? ,
					conservacion = ?,
					bienestar = ?,
					educacion = ?
					WHERE noticias_id = ?';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('sssiiii', 
					$data['sectionTitle'], 
					$data['sectionDescription'], 
					$data['sectionContent'], 
					$data['conservacion'],
					$data['bienestar'],
					$data['educacion'],
					$data['sectionId']);
			
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addNewsGallery($data)
	{
		try {
			$query = 'INSERT INTO noticias_gallery(noticias_id, picture) VALUES(?, ?)';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('is', $data['sectionId'], $data['image']);
			
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getNewsGallery($noticias_id)
	{
		try {
			$query = 'SELECT * FROM noticias_gallery WHERE noticias_id = '.$noticias_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteNewsPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM noticias_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addNewsVideo($data)
	{
		try {
			$query = 'INSERT INTO noticias_videos(noticias_id, video) VALUES(?, ?)';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('is', $data['sectionId'], $data['video']);
				
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getNewsVideo($noticias_id)
	{
		try {
			$query = 'SELECT * FROM noticias_videos WHERE noticias_id = '.$noticias_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteNewsVideo($videoId)
	{
		try {
			$query = 'DELETE FROM noticias_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addDirectorio($data)
	{
		try {
			$query = 'INSERT INTO directorio(name, charge, e_mail) VALUES(?, ?, ?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('sss', $data['dirName'], $data['dirCharge'], $data['dirEmail']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getDirectorio()
	{
		try {
			$query = 'SELECT * FROM directorio ORDER BY directorio_id ASC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateDirectorioIcon($data)
	{
		try {
			$query = 'UPDATE directorio SET icon = ? WHERE directorio_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['icon'], $data['directorioId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateDirectorio($data)
	{
		try {
			$query = 'UPDATE directorio SET name = ?, charge = ?, e_mail = ? WHERE directorio_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi', 
					$data['dirName'],
					$data['dirCharge'],
					$data['dirEmail'],
					$data['directorioId']);
			return $prep->execute();
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteDirectorio($directorioId)
	{
		try {
			$directorioId = (int) $directorioId;
			$query = 'DELETE FROM directorio WHERE directorio_id = '.$directorioId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllLogros()
	{
		try {
			$query = 'SELECT * FROM logros ORDER BY logros_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateLogros($data)
	{
		try {
			$query = 'UPDATE logros SET title = ?, description = ? WHERE logros_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('ssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionId']);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addLogros($data)
	{
		try {
			$query = 'INSERT INTO logros(title) VALUES(?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteLogro($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM logros WHERE logros_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getSingleLogro($logroId)
	{
		try {
			$logroId = (int) $logroId;
			$query = 'SELECT * FROM logros WHERE logros_id= '.$logroId;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateLogrosIcon($data)
	{
		try {
			$query = 'UPDATE logros SET icon = ? WHERE logros_id = ?';
			
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateLogrosPortrait($data)
	{
		try {
			$query = 'UPDATE logros SET portrait = ? WHERE logros_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllLogrosFechasDestacadas()
	{
		try {
			$query = 'SELECT * FROM logros_fechas ORDER BY logros_fechas_id DESC';
				
			return $this->db->getArray($query);
				
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addLogrosFechasDestacadas($data)
	{
		try {
			$query = 'INSERT INTO logros_fechas(title, url) VALUES(?, ?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('ss', $data['newTitle'], $data['newURL']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteLogrosFechas($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM logros_fechas WHERE logros_fechas_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllLogrosOtros()
	{
		try {
			$query = 'SELECT * FROM logros_otros ORDER BY logros_otros_id DESC';
	
			return $this->db->getArray($query);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addLogrosOtros($data)
	{
		try {
			$query = 'INSERT INTO logros_otros(title) VALUES(?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteLogrosOtros($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM logros_otros WHERE logros_otros_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProyectos()
	{
		try {
			$query = 'SELECT * FROM proyectos ORDER BY proyectos_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProyectos($data)
	{
		try {
			$query 	= 'INSERT INTO proyectos(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProyectos($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM proyectos WHERE proyectos_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getSingleProyecto($proyectoId)
	{
		try {
			$proyectoId = (int) $proyectoId;
			$query = 'SELECT * FROM proyectos WHERE proyectos_id = '.$proyectoId;
			
			return $this->db->getRow($query); 
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateProyectosIcon($data)
	{
		try {
			$query = 'UPDATE proyectos SET icon = ? WHERE proyectos_id = ?';
				
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['image'], $data['sectionId']);
	
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
				
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateProyectos($data)
	{
		try {
// 			$query = 'UPDATE proyectos 
// 					SET 
// 					title = ?, 
// 					description = ?, 
// 					content = ?,
// 					first_column_title = ?,
// 					second_column_title = ?,
// 					third_column_title = ?,
// 					conservacion = ?,
// 					bienestar = ?,
// 					educacion = ?
// 					WHERE proyectos_id = ?';
	
// 			$prep = $this->db->prepare($query);
// 			$prep->bind_param('ssssssiiii',
// 					$data['sectionTitle'],
// 					$data['sectionDescription'],
// 					$data['sectionContent'],
// 					$data['firstColumnTitle'],
// 					$data['secondColumnTitle'],
// 					$data['thirdColumnTitle'],
// 					$data['conservacion'],
// 					$data['bienestar'],
// 					$data['educacion'],
// 					$data['sectionId']);
			
			$query = 'UPDATE proyectos
					SET
					title = ?,
					description = ?,
					content = ?,
					first_column_title = ?,
					second_column_title = ?,
					third_column_title = ?
					WHERE proyectos_id = ?';
			
			$prep = $this->db->prepare($query);
			$prep->bind_param('ssssssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['firstColumnTitle'],
					$data['secondColumnTitle'],
					$data['thirdColumnTitle'],
					$data['sectionId']);
	
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			else
			{
				return true;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProyectosLinks($data)
	{
		try {
			$query = 'INSERT INTO proyectos_links(proyectos_id, title, url, kind) VALUES(?, ?, ?, ?)';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('issi', 
					$data['sectionId'],
					$data['linkTitle'],
					$data['linkUrl'],
					$data['linkType']);
			
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			else
			{
				return $prep->insert_id;
			}
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProyectosLinksByIdAndType($sectionId, $type)
	{
		try {
			$query = 'SELECT * FROM proyectos_links WHERE proyectos_id = '.$sectionId.' AND kind = '.$type.' ORDER BY proyectos_links_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProyectosLinksById($id)
	{
		try {
			$query = 'DELETE FROM proyectos_links WHERE proyectos_links_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProyectosVideo($data)
	{
		try {
			$query = 'INSERT INTO proyectos_videos(proyectos_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProyectosVideo($noticias_id)
	{
		try {
			$query = 'SELECT * FROM proyectos_videos WHERE proyectos_id= '.$noticias_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProyectosVideo($videoId)
	{
		try {
			$query = 'DELETE FROM proyectos_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProyectosGallery($data)
	{
		try {
			$query = 'INSERT INTO proyectos_gallery(proyectos_id, picture) VALUES(?, ?)';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('is', $data['sectionId'], $data['image']);
				
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProyectosGallery($proyectos_id)
	{
		try {
			$query = 'SELECT * FROM proyectos_gallery WHERE proyectos_id = '.$proyectos_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProyectosPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM proyectos_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addActividad($data)
	{
		try {
			$query = 'INSERT INTO actividades(title, date) VALUES(?, ?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('ss', $data['newTitle'], Tools::formatToMYSQL($data['newDate']));
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getActividades()
	{
		try {
			$query = 'SELECT * FROM actividades ORDER BY date DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteActividades($actividades_id)
	{
		try {
			$actividades_id = (int) $actividades_id;
			$query = 'DELETE FROM actividades WHERE actividades_id = '.$actividades_id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getActividadesById($actividades_id)
	{
		try {
			$actividades_id = (int) $actividades_id;
			$query = 'SELECT * FROM actividades WHERE actividades_id = '.$actividades_id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateActividadesIcon($data)
	{
		try {
			$query = 'UPDATE actividades SET icon = ? WHERE actividades_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateActividadesPortrait($data)
	{
		try {
			$query = 'UPDATE actividades SET portrait = ? WHERE actividades_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateActividades($data)
	{
		try {
			$query = 'UPDATE actividades SET
					title = ?,
					description = ?,
					content = ? ,
					voluntariado = ?,
					conservacion = ?,
					bienestar = ?,
					educacion = ?
					WHERE actividades_id = ?';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('sssiiiii',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['voluntariado'],
					$data['conservacion'],
					$data['bienestar'],
					$data['educacion'],
					$data['sectionId']);
				
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addActividadesGallery($data)
	{
		try {
			$query = 'INSERT INTO actividades_gallery(actividades_id, picture) VALUES(?, ?)';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('is', $data['sectionId'], $data['image']);
				
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getActividadesGallery($actividades_id)
	{
		try {
			$query = 'SELECT * FROM actividades_gallery WHERE actividades_id = '.$actividades_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteActividadesPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM actividades_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addActividadesVideo($data)
	{
		try {
			$query = 'INSERT INTO actividades_videos(actividades_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getActividadesVideo($actividades_id)
	{
		try {
			$query = 'SELECT * FROM actividades_videos WHERE actividades_id = '.$actividades_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteActividadesVideo($videoId)
	{
		try {
			$query = 'DELETE FROM actividades_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addCampana($data)
	{
		try {
			$query 	= 'INSERT INTO campanas(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCampanas()
	{
		try {
			$query = 'SELECT * FROM campanas ORDER BY campanas_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteCampanas($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM campanas WHERE campanas_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCampanasById($campanas_id)
	{
		try {
			$campanas_id = (int) $campanas_id;
			$query = 'SELECT * FROM campanas WHERE campanas_id = '.$campanas_id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateCampanasIcon($data)
	{
		try {
			$query = 'UPDATE campanas SET icon = ? WHERE campanas_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateCampanasPortrait($data)
	{
		try {
			$query = 'UPDATE campanas SET portrait = ? WHERE campanas_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateCampanas($data)
	{
		try {
			$query = 'UPDATE campanas
					SET
					title = ?,
					description = ?,
					content = ?,
					second_column_title = ?,
					second_column_content = ?,
					otros_content = ?,
					third_column_title = ?,
					third_column_content = ?,
					video = ?,
					promoted = ?
					WHERE campanas_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssssssssii',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['secondColumnTitle'],
					$data['secondColumnContent'],
					$data['otrosContent'],
					$data['thirdColumnTitle'],
					$data['thirdColumnContent'],
					$data['singleVideo'],
					$data['promoted'],
					$data['sectionId']);
	
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			else
			{
				return true;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addCampanasLinks($data)
	{
		try {
			$query = 'INSERT INTO campanas_links(campanas_id, title, url, kind) VALUES(?, ?, ?, ?)';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('issi',
					$data['sectionId'],
					$data['linkTitle'],
					$data['linkUrl'],
					$data['linkType']);
				
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			else
			{
				return $prep->insert_id;
			}
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCampanasLinksByIdAndType($sectionId, $type)
	{
		try {
			$query = 'SELECT * FROM campanas_links WHERE campanas_id = '.$sectionId.' AND kind = '.$type.' ORDER BY proyectos_links_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteCampanasLinksById($id)
	{
		try {
			$query = 'DELETE FROM campanas_links WHERE proyectos_links_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addCampanasGallery($data)
	{
		try {
			$query = 'INSERT INTO campanas_gallery(campanas_id, picture) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['image']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCampanasGallery($campanas_id)
	{
		try {
			$query = 'SELECT * FROM campanas_gallery WHERE campanas_id = '.$campanas_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteCampanasPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM campanas_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addCampanasVideo($data)
	{
		try {
			$query = 'INSERT INTO campanas_videos(campanas_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCampanasVideo($campanas_id)
	{
		try {
			$query = 'SELECT * FROM campanas_videos WHERE campanas_id = '.$campanas_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteCampanasVideo($videoId)
	{
		try {
			$query = 'DELETE FROM campanas_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addMaterial($data)
	{
		try {
			$query 	= 'INSERT INTO materiales(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMateriales()
	{
		try {
			$query = 'SELECT * FROM materiales ORDER BY materiales_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteMateriales($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM materiales WHERE materiales_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMaterialesById($id)
	{
		try {
			$id = (int) $id;
			$query = 'SELECT * FROM materiales WHERE materiales_id = '.$id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateMaterialesIcon($data)
	{
		try {
			$query = 'UPDATE materiales SET icon = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateMateriales($data)
	{
		try {
			$query = 'UPDATE materiales SET title = ?, description = ?, content = ? WHERE materiales_id = ?';
				
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
				
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addMaterialesGallery($data)
	{
		try {
			$query = 'INSERT INTO materiales_gallery(materiales_id, picture) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['image']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMaterialesGallery($materiales_id)
	{
		try {
			$query = 'SELECT * FROM materiales_gallery WHERE materiales_id = '.$materiales_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteMaterialesPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM materiales_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addMaterialesVideo($data)
	{
		try {
			$query = 'INSERT INTO materiales_videos(materiales_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMaterialesVideo($materiales_id)
	{
		try {
			$query = 'SELECT * FROM materiales_videos WHERE materiales_id = '.$materiales_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteMaterialesVideo($videoId)
	{
		try {
			$query = 'DELETE FROM materiales_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addVoluntariado($data)
	{
		try {
			$query 	= 'INSERT INTO voluntariado(title, type) VALUES(?, ?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('si', $data['newTitle'], $data['type']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getVoluntariado($type)
	{
		try {
			$query = 'SELECT * FROM voluntariado WHERE type = '.$type.' ORDER BY voluntariado_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteVoluntariado($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM voluntariado WHERE voluntariado_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getVoluntariadoById($id)
	{
		try {
			$id = (int) $id;
			$query = 'SELECT * FROM voluntariado WHERE voluntariado_id = '.$id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateVoluntariadoIcon($data)
	{
		try {
			$query = 'UPDATE voluntariado SET icon = ? WHERE voluntariado_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateVoluntariado($data)
	{
		try {
			$query = 'UPDATE voluntariado
					SET
					title = ?,
					description = ?,
					content = ?,
					first_column_title = ?,
					first_column_content = ?,
					second_column_title = ?,
					second_column_content = ?,
					third_column_title = ?,
					third_column_content = ?
					WHERE voluntariado_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssssssssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['firstColumnTitle'],
					$data['firstColumnContent'],
					$data['secondColumnTitle'],
					$data['secondColumnContent'],
					$data['thirdColumnTitle'],
					$data['thirdColumnContent'],
					$data['sectionId']);
	
			if (!$prep->execute())
			{
				printf("Errormessage: %s\n", $prep->error);
			}
			else
			{
				return true;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addEmbajadores($data)
	{
		try {
			$query 	= 'INSERT INTO embajadores(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEmbajadores()
	{
		try {
			$query = 'SELECT * FROM embajadores ORDER BY materiales_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteEmbajadores($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM embajadores WHERE materiales_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEmbajadoresById($id)
	{
		try {
			$id = (int) $id;
			$query = 'SELECT * FROM embajadores WHERE materiales_id = '.$id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateEmbajadoresIcon($data)
	{
		try {
			$query = 'UPDATE embajadores SET icon = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateEmbajadores($data)
	{
		try {
			$query = 'UPDATE embajadores SET title = ?, description = ?, content = ? WHERE materiales_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addEmbajadoresGallery($data)
	{
		try {
			$query = 'INSERT INTO embajadores_gallery(materiales_id, picture) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['image']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEmbajadoresGallery($materiales_id)
	{
		try {
			$query = 'SELECT * FROM embajadores_gallery WHERE materiales_id = '.$materiales_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteEmbajadoresPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM embajadores_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addEmbajadoresVideo($data)
	{
		try {
			$query = 'INSERT INTO embajadores_videos(materiales_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getEmbajadoresVideo($materiales_id)
	{
		try {
			$query = 'SELECT * FROM embajadores_videos WHERE materiales_id = '.$materiales_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteEmbajadoresVideo($videoId)
	{
		try {
			$query = 'DELETE FROM embajadores_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addTestimonios($data)
	{
		try {
			$query 	= 'INSERT INTO testimonios(description) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['description']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getTestimonios()
	{
		try {
			$query = 'SELECT * FROM testimonios ORDER BY testimonios_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateTestimoniosIcon($data)
	{
		try {
			$query = 'UPDATE testimonios SET icon = ? WHERE testimonios_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['icon'], $data['directorioId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteTestimonios($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM testimonios WHERE testimonios_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateTestimonios($data)
	{
		try {
			$query = 'UPDATE testimonios SET general = ?, servicios = ?, practicas = ?, voluntariado = ?, experiencia = ?, embajadores = ?, aliados = ? 
					WHERE testimonios_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('iiiiiiii',
					$data['general'],
					$data['servicios'],
					$data['practicas'],
					$data['voluntariado'],
					$data['experiencia'],
					$data['embajadores'],
					$data['aliados'],
					$data['testimoniosId']);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addRelacionAliadosProyectos($sectionId, $aliadoId)
	{
		try {
			$query = 'INSERT INTO proyectos_aliados(proyectos_id, aliado_id) VALUES('.$sectionId.', '.$aliadoId.')';
			
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteRelacionAliadosProyectos($sectionId)
	{
		try {
			$query = 'DELETE FROM proyectos_aliados WHERE proyectos_id = '.$sectionId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function checkRelacionAliadosProyectos($sectionId, $aliadoId)
	{
		try {
			$query = 'SELECT * FROM proyectos_aliados WHERE proyectos_id = '.$sectionId.' AND aliado_id = '.$aliadoId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addRelacionCausasProyectos($sectionId, $causaId)
	{
		try {
			$query = 'INSERT INTO causas_proyectos(causa_id, proyectos_id) VALUES('.$sectionId.', '.$causaId.')';
				
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteRelacionCausasProyectos($sectionId)
	{
		try {
			$query = 'DELETE FROM causas_proyectos WHERE causa_id = '.$sectionId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function checkRelacionCausasProyectos($sectionId, $aliadoId)
	{
		try {
			$query = 'SELECT * FROM causas_proyectos WHERE causa_id = '.$sectionId.' AND proyectos_id = '.$aliadoId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addContenidos($data)
	{
		try {
			$query 	= 'INSERT INTO contenidos(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getContenidos()
	{
		try {
			$query = 'SELECT * FROM contenidos ORDER BY materiales_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteContenidos($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM contenidos WHERE materiales_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getContenidosById($id)
	{
		try {
			$id = (int) $id;
			$query = 'SELECT * FROM contenidos WHERE materiales_id = '.$id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateContenidosIcon($data)
	{
		try {
			$query = 'UPDATE contenidos SET icon = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateContenidosPortrait($data)
	{
		try {
			$query = 'UPDATE contenidos SET portrait = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateContenidos($data)
	{
		try {
			$query = 'UPDATE contenidos SET title = ?, description = ?, content = ? WHERE materiales_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addContenidosGallery($data)
	{
		try {
			$query = 'INSERT INTO contenidos_gallery(materiales_id, picture) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['image']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getContenidosGallery($materiales_id)
	{
		try {
			$query = 'SELECT * FROM contenidos_gallery WHERE materiales_id = '.$materiales_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteContenidosPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM contenidos_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addContenidosVideo($data)
	{
		try {
			$query = 'INSERT INTO contenidos_videos(materiales_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getContenidosVideo($materiales_id)
	{
		try {
			$query = 'SELECT * FROM contenidos_videos WHERE materiales_id = '.$materiales_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteContenidosVideo($videoId)
	{
		try {
			$query = 'DELETE FROM contenidos_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addRelacionEspaciosContenidos($sectionId, $causaId)
	{
		try {
			$query = 'INSERT INTO espacios_contenidos(espacios_id, materiales_id) VALUES('.$sectionId.', '.$causaId.')';
	
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteRelacionEspaciosContenidos($sectionId)
	{
		try {
			$query = 'DELETE FROM espacios_contenidos WHERE espacios_id = '.$sectionId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function checkRelacionEspaciosContenidos($sectionId, $aliadoId)
	{
		try {
			$query = 'SELECT * FROM espacios_contenidos WHERE espacios_id = '.$sectionId.' AND materiales_id = '.$aliadoId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProductos($data)
	{
		try {
			$query 	= 'INSERT INTO productos(title) VALUES(?)';
			$prep 	= $this->db->prepare($query);
			$prep->bind_param('s', $data['newTitle']);
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProductos()
	{
		try {
			$query = 'SELECT * FROM productos ORDER BY materiales_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProductos($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM productos WHERE materiales_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProductosById($id)
	{
		try {
			$id = (int) $id;
			$query = 'SELECT * FROM productos WHERE materiales_id = '.$id;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateProductosIcon($data)
	{
		try {
			$query = 'UPDATE productos SET icon = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateProductosPortrait($data)
	{
		try {
			$query = 'UPDATE productos SET portrait = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateProductos($data)
	{
		try {
			$query = 'UPDATE productos SET title = ?, description = ?, content = ? WHERE materiales_id = ?';
	
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssi',
					$data['sectionTitle'],
					$data['sectionDescription'],
					$data['sectionContent'],
					$data['sectionId']);
	
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProductosGallery($data)
	{
		try {
			$query = 'INSERT INTO productos_gallery(materiales_id, picture) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['image']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProductosGallery($materiales_id)
	{
		try {
			$query = 'SELECT * FROM productos_gallery WHERE materiales_id = '.$materiales_id.' ORDER BY picture_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProductosPicture($pictureId)
	{
		try {
			$query = 'DELETE FROM productos_gallery WHERE picture_id = '.$pictureId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addProductosVideo($data)
	{
		try {
			$query = 'INSERT INTO productos_videos(materiales_id, video) VALUES(?, ?)';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('is', $data['sectionId'], $data['video']);
	
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getProductosVideo($materiales_id)
	{
		try {
			$query = 'SELECT * FROM productos_videos WHERE materiales_id = '.$materiales_id.' ORDER BY video_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteProductosVideo($videoId)
	{
		try {
			$query = 'DELETE FROM productos_videos WHERE video_id = '.$videoId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addRelacionAliadosCampanas($sectionId, $aliadoId)
	{
		try {
			$query = 'INSERT INTO campanas_aliados(proyectos_id, aliado_id) VALUES('.$sectionId.', '.$aliadoId.')';
				
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteRelacionAliadosCampanas($sectionId)
	{
		try {
			$query = 'DELETE FROM campanas_aliados WHERE proyectos_id = '.$sectionId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function checkRelacionAliadosCampanas($sectionId, $aliadoId)
	{
		try {
			$query = 'SELECT * FROM campanas_aliados WHERE proyectos_id = '.$sectionId.' AND aliado_id = '.$aliadoId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateMaterialesPortrait($data)
	{
		try {
			$query = 'UPDATE materiales SET portrait = ? WHERE materiales_id = ?';
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', $data['background'], $data['sectionId']);
	
			return $prep->execute();
	
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addDocument($name)
	{
		try {
			$query = 'INSERT INTO documentos(documento) VALUES(?)';
			$prep = $this->db->prepare($query);
			$prep->bind_param('s', $name);
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getDocuments()
	{
		try {
			$query = 'SELECT * FROM documentos ORDER BY documento_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteDocument($id)
	{
		try {
			$id = (int) $id;
			$query = 'DELETE FROM documentos WHERE documento_id = '.$id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addRelacionAliadosEspacios($sectionId, $aliadoId)
	{
		try {
			$query = 'INSERT INTO espacios_aliados(espacio_id, aliado_id) VALUES('.$sectionId.', '.$aliadoId.')';
				
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function deleteRelacionAliadosEspacios($sectionId)
	{
		try {
			$query = 'DELETE FROM espacios_aliados WHERE espacio_id = '.$sectionId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function checkRelacionAliadosEspacios($sectionId, $aliadoId)
	{
		try {
			$query = 'SELECT * FROM espacios_aliados WHERE espacio_id = '.$sectionId.' AND aliado_id = '.$aliadoId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateSocial($data)
	{
		try {
			$query = 'UPDATE app_info SET
					twitter 	= ?,
					facebook 	= ?,
					googleplus 	= ?,
					pinterest 	= ?,
					linkedin 	= ?,
					youtube 	= ?,
					instagram 	= ?
					';
			$prep = $this->db->prepare($query);
			$prep->bind_param('sssssss', 
					$data['rTwitter'],
					$data['rFacebook'],
					$data['rGoogle'],
					$data['rPinterest'],
					$data['rLinkedin'],
					$data['rYoutube'],
					$data['rInstagram']
					);
			
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
}

























