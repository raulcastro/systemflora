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
	
	/**
	 * Get the last 10 members added
	 * 
	 * If the user is an admin then all the members will show
	 * If not, only the user that belongs to the user will be show
	 * 
	 * @return mixed|bool An array of info or false
	 */
	public function getLastMembers()
	{
		try {
			$filter = '';
			
			if ($_SESSION['loginType'] != 1)
			{
				$filter = 'WHERE m.user_id = '.$_SESSION['userId'];
			}
			
			$query = 'SELECT 
					lpad(m.member_id, 4, 0) AS member_id, 
					m.user_id, 
					m.name, 
					m.last_name, 
					m.address, 
					m.city, 
					m.state, 
					m.country, 
					m.active,
					d.name AS user_name
					FROM members m
					LEFT JOIN user_detail d ON m.user_id = d.user_id
					'.$filter.'
					 ORDER BY m.member_id DESC
					LIMIT 0, 10
					';

			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Get all the members 
	 * 
	 * With all the details
	 * 
	 * @return mixed|bool An array of info or false
	 */
	public function getAllMembers()
	{
		try {
			$filter = '';
				
			if ($_SESSION['loginType'] != 1)
			{
				$filter = 'WHERE m.user_id = '.$_SESSION['userId'];
			}
				
			$query = 'SELECT lpad(m.member_id, 4, 0) AS member_id, 
					m.user_id, 
					m.name, 
					m.last_name, 
					m.address, 
					m.city, 
					m.state, 
					m.country, 
					m.active,
					d.name AS user_name
					FROM members m
					LEFT JOIN user_detail d ON m.user_id = d.user_id
					'.$filter.'
					 ORDER BY m.member_id DESC
					';
				
			return $this->db->getArray($query);
				
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllCountries()
	{
		try {
			$query = 'SELECT Name, Code FROM Country;';
	
			return $this->db->getArray($query);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function getAllStatesByCountry($country)
	{
		try
		{
			$query = 'SELECT District, CountryCode 
					FROM City 
					WHERE CountryCode = "'.$country.'" 
					GROUP BY District;';
	
			return $this->db->getArray($query);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function getCitiesByEstate($code)
	{
		try
		{
			$query = 'SELECT Name, CountryCode 
					FROM City 
					WHERE District = "'.$code.'" 
					ORDER BY Name;';
	
			return $this->db->getArray($query);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function updateMember($data)
	{
		try {
			$query = 'UPDATE members 
					SET name 	= ?, 
					last_name 	= ?, 
					address 	= ?, 
					city 		= ?, 
					state 		= ?, 
					country 	= ?, 
					notes 		= ?
					WHERE member_id = ?';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('sssssssi',
					$data['memberName'],
					$data['memberLastName'],
					$data['memberAddress'],
					$data['city'],
					$data['mState'],
					$data['country'],
					$data['notes'],
					$data['memberId']
					);
			
			if ($prep->execute())
			{
				return $data['memberId'];
			}
			else {
				printf("Errormessage: %s\n", $prep->error);
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addMemberEmail($data)
	{
		try
		{	
			$query = 'INSERT INTO member_emails (member_id, email, active) 
					VALUES(?, ?, 1)';
	
			$prep = $this->db->prepare($query);
			 
			$prep->bind_param('is',
					$data['memberId'],
					$data['emailVal']);
			 
			return $prep->execute();
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function updateMemberEmail($data)
	{
		try {
			$query = 'UPDATE member_emails 
					SET email = ? 
					WHERE email_id = ?';
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('si', $data['emailVal'], $data['emailId']);
			
			return $prep->execute();
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addMemberPhone($data)
	{
		try
		{
			$query = 'INSERT INTO member_phones(member_id, phone, active) 
					VALUES(?, ?, 1)';
	
			$prep = $this->db->prepare($query);
			 
			$prep->bind_param('is',
					$data['memberId'],
					$data['phoneVal']);
			 
			return $prep->execute();
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function updateMemberPhone($data)
	{
		try {
			$query = 'UPDATE member_phones 
					SET phone = ? 
					WHERE phone_id = ?';
			
			$prep = $this->db->prepare($query);
			$prep->bind_param('si', 
					$data['phoneVal'], 
					$data['phoneId']);
			
			return $prep->execute();
			
		} catch (Exception $e) {
			printf("Errormessage: %s\n", $prep->error);
		}
	}
	
	public function getMemberByMemberId($memberId)
	{
		try {
			$query = 'SELECT m.*, c.Name as country, c.Code as country_code
					FROM members m
					LEFT JOIN Country c ON m.country = c.Code
					WHERE m.member_id = 
					'.$memberId;
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMemberEmailsById($memberId)
	{
		try {
			$query = 'SELECT * 
					FROM member_emails 
					WHERE member_id = '.$memberId;
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMemberPhonesById($memberId)
	{
		try {
			$query = 'SELECT * FROM member_phones WHERE member_id = '.$memberId;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getMemberHistoryById($memberId)
	{
		try {
			$query = 'SELECT mh.* , ud.name
					FROM member_history mh 
					LEFT JOIN user_detail ud ON mh.user_id = ud.user_id
					WHERE mh.member_id = '.$memberId.'
					ORDER BY mh.history_id DESC		
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function addHistory($data)
	{
	    try
	    {
	    	$query = 'INSERT INTO member_history(user_id, member_id, date, time, history) 
	    			VALUES('.$_SESSION["userId"].', ?, CURDATE(), CURTIME(), ?)';
			
	        $prep = $this->db->prepare($query);

	        $prep->bind_param('is', 
	        		$data['memberId'],
	        		$data['historyEntry']);
			
             return $prep->execute();
	    }
	    catch (Exception $e)
	    {
	    	echo $e->getMessage();
	    }
	}
	
	public function getHistoryEntries($member_id)
	{
		try 
		{
			$member_id = (int) $member_id;
			$query = 'SELECT h.*, ud.name
					FROM member_history h
					LEFT JOIN user_detail ud ON ud.user_id = h.user_id
					WHERE h.member_id = '.$member_id.'
					ORDER BY h.history_id DESC';
			
			return $this->db->getArray($query);
		}
		catch (Exception $e)
		{
			return false;			
		}
	}
	
	public function addMemberTask($data)
	{
		$date = Tools::formatToMYSQL($data['task_date']);
	
		$time = $data['task_hour'].':00';
		$member_id = (int) $data['memberId'];
		try {
			$query = 'INSERT INTO member_tasks(task_to, task_from, date, created_on, time, content, member_id)
					VALUES(?, ?, ?, CURDATE(), ?, ?, ?)';
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('iisssi',
					$data['task_to'],
					$_SESSION['userId'],
					$date,
					$time,
					$data['task_content'],
					$member_id);
			// 			Pretty good piece of code!
			// 			if(!$prep->execute())
				// 			{
				// 				printf("Errormessage: %s\n", $prep->error);
				// 			}
				return $prep->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
	public function getMemberTaskByMemberId($member_id)
	{
		try {
			$member_id = (int) $member_id;
			
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					WHERE t.member_id = '.$member_id.'
					ORDER BY t.date ASC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllMemberTasks()
	{
		try {
			$member_id = (int) $member_id;
			
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.status = 0
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getAllTasksByUser()
	{
		try {
			$member_id = (int) $member_id;
	
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.assigned_to = '.$_SESSION['userId'].'
					AND t.status = 0
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getTotalTodayTasksByMemberId()
	{
		try {
			$query = 'SELECT COUNT(*) 
					FROM member_tasks 
					WHERE date = CURDATE() 
					AND task_to = '.$_SESSION['userId'].'
					AND status = 0';
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getTodayTasksByUser()
	{
		try {
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.date = CURDATE() 
					AND t.task_to = '.$_SESSION['userId'].'
					AND t.status = 0
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getTotalPendingTasksByMemberId()
	{
		try {
			$query = 'SELECT COUNT(*) 
					FROM member_tasks 
					WHERE date < CURDATE()
					AND task_to = '.$_SESSION['userId'].'
					AND status = 0';
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getPendingTasksByUser()
	{
		try {
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.date < CURDATE()
					AND t.task_to = '.$_SESSION['userId'].'
					AND t.status = 0
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getTotalFutureTasksByMemberId()
	{
		try {
			$query = 'SELECT COUNT(*)
					FROM member_tasks
					WHERE date > CURDATE()
					AND task_to = '.$_SESSION['userId'].'
					AND status = 0';
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getFutureTasksByUser()
	{
		try {
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.date > CURDATE()
					AND t.task_to = '.$_SESSION['userId'].'
					AND t.status = 0
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getCompletedTasksByUser()
	{
		try {
			$query = 'SELECT t.*,
					ud.name AS assigned_by,
					uds.name AS assigned_to,
					m.name, m.last_name
					FROM member_tasks t
					LEFT JOIN user_detail ud ON ud.user_id = t.task_from
					LEFT JOIN user_detail uds ON uds.user_id = t.task_to
					LEFT JOIN members m ON m.member_id = t.member_id
					WHERE t.task_to = '.$_SESSION['userId'].'
					AND t.status = 1
					ORDER BY t.date DESC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getRecentMembers()
	{
		try {
			$query = 'SELECT COUNT(*) FROM members WHERE date = CURDATE() AND user_id = '.$_SESSION['userId'];
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function completeTask($task_id)
	{
		try {
			$task_id = (int) $task_id;
			$query = 'UPDATE member_tasks SET status = 1, completed_by = '.$_SESSION['userId'].', completed_date = CURDATE()
					WHERE task_id = '.$task_id;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * addAgency
	 *
	 * add an agency on the agency table
	 *
	 * @param ustring $agency
	 * @return true on success | false on fail
	 */
	public function addAgency($agency)
	{
		try {
			$query = 'INSERT INTO agencies(agency)
						VALUES(?);';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('s', $agency);
				
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getAgencies
	 *
	 * returns an array of agencies
	 *
	 * @return multitype:array of agencies on success false on fail
	 */
	public function getAgencies()
	{
		try {
			$query = 'SELECT * FROM agencies ORDER BY agency_id DESC';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
		
	public function getAllReservations()
	{
		try {
			$query = 'SELECT s.reservation_id, 
					s.check_in,
					DATE_ADD(s.check_out, INTERVAL 1 DAY) AS check_out,
					rt.room_type,
					rt.abbr,
					r.room,
					m.name,
					m.last_name
					FROM reservations s
					LEFT JOIN rooms r ON s.room_id = r.room_id
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id
					LEFT JOIN members m ON m.member_id = s.member_id
					';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * searchRooms
	 * 
	 * Execute a search for available rooms depending on check-in & check-out
	 * 
	 * @param array $data
	 * @return multitype:a list of available rooms | false on fail
	 */
	public function searchRooms($data)
	{
		$checkIn 	= Tools::formatToMYSQL($data['checkIn']);
		$checkIn	= date($checkIn);
		
		$checkOut 	= Tools::formatToMYSQL($data['checkOut']);
		$checkOut 	= date($checkOut);
		
		try {
			$query = 'SELECT r.*, rt.room_type_id, rt.room_type
			FROM rooms r
			LEFT JOIN room_types rt ON r.room_type_id = rt.room_type_id
			WHERE r.room_id NOT IN (SELECT room_id
			FROM reservations 
			WHERE (check_in < "'.$checkOut.'" AND check_out >="'.$checkOut.'")
			OR (check_in <= "'.$checkIn.'" AND check_out >"'.$checkIn.'")
			OR (check_in >= "'.$checkIn.'" AND check_out <= "'.$checkOut.'"))
			ORDER BY r.room_order ASC		
			;';
// 			echo $query;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
	/**
	 * searchSingleRoom
	 *
	 * Execute a search for the availability of a singles specific room, according to check in and check out date
	 *
	 * @param array $data
	 * @return multitype:a list of available rooms | false on fail
	 */
	public function searchSingleRoom($data)
	{
		$checkIn 	= Tools::formatToMYSQL($data['checkIn']);
		$checkOut 	= Tools::formatToMYSQL($data['checkOut']);
	
		$room_id = (int) $data['roomId'];
		try {
			$query = 'SELECT r.*, rt.room_type_id, rt.room_type
			FROM rooms r
			LEFT JOIN room_types rt ON r.room_type_id = rt.room_type_id
			WHERE r.room_id NOT IN (SELECT room_id
			FROM reservations
			WHERE (check_in < "'.$checkOut.'" AND check_out >="'.$checkOut.'")
			OR (check_in <= "'.$checkIn.'" AND check_out >"'.$checkIn.'")
			OR (check_in >= "'.$checkIn.'" AND check_out <= "'.$checkOut.'"))
			AND r.room_id = '.$data['roomId'].'
			ORDER BY r.room_order ASC
			;';
			return $this->db->getRow($query);
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
	public function addMemberFromReservation($data)
	{
		try {
			$query = 'INSERT INTO members(name, user_id, last_name, active, date)
						VALUES(?, '.$_SESSION["userId"].', ?, 1, CURDATE());';
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('ss',
					$data['memberName'],
					$data['memberLastName']);
			
			if ($prep->execute())
			{
				return $prep->insert_id;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * addReservation
	 * 
	 * add a new reservation with a room id, check-in and checkout and other parameters
	 * 
	 * @param array $data
	 * @return true on success | false on fail
	 */
	public function addReservation($data)
	{
		$checkIn 		= Tools::formatToMYSQL($data['checkIn']);
		$checkInDate	= date($checkIn);
		$checkInDate	= date('Y-m-d', strtotime('+1 day', strtotime($checkInDate)));
		
		$checkOut 		= Tools::formatToMYSQL($data['checkOut']);
		$checkOutDate 	= date($checkOut);
		$checkOutDate 	= date('Y-m-d', strtotime('-1 day', strtotime($checkOutDate)));
		
		try {
			$query = 'INSERT INTO
					reservations(
						member_id,
						room_id,
						check_in,
						check_out,
						date,
						price,
						status,
						adults,
						children,
						agency,
						price_per_night,
						external_id)
					VALUES(?, ?, ?, ?, CURDATE(), ?, 1, ?, ?, ?, ?, ?)';

			$prep = $this->db->prepare($query);
			
			$prep->bind_param('iissiiiiis',
					$data['memberId'],
					$data['roomId'],
					$checkIn,
					$checkOut,
					$data['price'],
					$data['reservationAdults'],
					$data['reservationChildren'],
					$data['agency'],
					$data['pricePerNight'],
					$data['externalId']
					);
			
			if ($prep->execute())
			{
// 				$info = array('reservationId' => $prep->insert_id, 'description' => "Staying cost", 'cost' => $data['price']);
// 				$this->addPayment($info);
				return $prep->insert_id;
				
			}
			
// 			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getMemberReservationByMemberId
	 * 
	 * it gets all the reservation related to a member
	 * 
	 * @param int $memberId
	 * @return array on success | false on fail
	 */
	public function getMemberReservationsByMemberId($memberId)
	{
		$memberId = (int) $memberId;
		try {
			$query = 'SELECT s.reservation_id,
					s.check_in,
					DATE_ADD(s.check_in, INTERVAL -1 DAY) AS check_in_mask,
					s.check_out,
					DATE_ADD(s.check_out, INTERVAL 1 DAY) AS check_out_mask,
					s.date,
					s.price,
					s.adults,
					s.children,
					s.status,
					s.external_id,
					s.room_id,
					rt.room_type,
					rt.abbr,
					r.room,
					m.name,
					m.last_name,
					a.agency,
					a.agency_id
					FROM reservations s
					LEFT JOIN rooms r ON s.room_id = r.room_id
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id
					LEFT JOIN members m ON m.member_id = s.member_id
					LEFT JOIN agencies a ON s.agency = a.agency_id
					WHERE s.member_id = '.$memberId.' ORDER BY s.check_in ASC';
				
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getMemberCancelationsByMemberId
	 *
	 * it gets all the reservation canceled related to a member
	 *
	 * @param int $memberId
	 * @return array on success | false on fail
	 */
	public function getMemberCancelationsByMemberId($memberId)
	{
		$memberId = (int) $memberId;
		try {
			$query = 'SELECT s.reservation_id,
					s.check_in,
					DATE_ADD(s.check_in, INTERVAL -1 DAY) AS check_in_mask,
					s.check_out,
					DATE_ADD(s.check_out, INTERVAL 1 DAY) AS check_out_mask,
					s.date,
					s.price,
					s.adults,
					s.children,
					s.status,
					s.external_id,
					s.room_id,
					rt.room_type,
					rt.abbr,
					r.room,
					m.name,
					m.last_name,
					a.agency
					FROM cancelations s
					LEFT JOIN rooms r ON s.room_id = r.room_id
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id
					LEFT JOIN members m ON m.member_id = s.member_id
					LEFT JOIN agencies a ON s.agency = a.agency_id
					WHERE s.member_id = '.$memberId.' ORDER BY s.reservation_id DESC';
	
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getAllRooms
	 * 
	 * Returns the collection of rooms on table rooms
	 * it works for the section 'Rooms'
	 * 
	 * @return multitype:unknown |boolean
	 */
	
	public function getAllRooms()
	{
		try {
			$query = 'SELECT r.*, rt.room_type, rt.abbr
					FROM rooms r
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id 
					ORDER BY r.room_order ASC
					';
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getSingleRoomById
	 *
	 * Return the info a single room by a given room id
	 *
	 * @return multitype:unknown |boolean
	 */
	
	public function getSingleRoomById($roomId)
	{
		try {
			$roomId = (int) $roomId;
			$query = 'SELECT r.*, rt.room_type, rt.abbr
					FROM rooms r
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id
					WHERE r.room_id = '.$roomId.'
					';
			return $this->db->getRow($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getReservationsByRoomId
	 * 
	 * returns all the reservations related to an specific room
	 * 
	 * @param int $room_id
	 * @return multitype:array of reservations on success | false on fail
	 */
	public function getReservationsByRoomId($room_id)
	{
		try {
			$room_id = (int) $room_id;
			$query = 'SELECT s.reservation_id, 
					s.check_in,
					DATE_ADD(s.check_in, INTERVAL -1 DAY) AS check_in_mask,
					s.check_out,
					DATE_ADD(s.check_out, INTERVAL 1 DAY) AS check_out_mask,
					s.status,
					s.reservation_id,
					rt.room_type,
					rt.abbr,
					r.room,
					m.member_id, 
					m.name,
					m.last_name,
					a.agency
					FROM reservations s
					LEFT JOIN rooms r ON s.room_id = r.room_id
					LEFT JOIN room_types rt ON rt.room_type_id = r.room_type_id
					LEFT JOIN members m ON m.member_id = s.member_id
					LEFT JOIN agencies a ON s.agency = a.agency_id
					WHERE r.room_id = '.$room_id.' ORDER BY s.check_in';
			
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * addPayment
	 * 
	 * add a payment item to an reservation
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function addPayment($data)
	{
		try {
			$query = 'INSERT INTO payments(reservation_id, description, cost, staying)
						VALUES(?, ?, ?, ?);';
	
			$prep = $this->db->prepare($query);
	
			$prep->bind_param('isii',
					$data['reservationId'],
					$data['description'],
					$data['cost'],
					$data['staying']);
			
			return $prep->execute();
// 			if ($prep->execute())
// 			{
// 				return $prep->insert_id;
// 			}
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getPaymentsByReservationId
	 * 
	 * get all the payments related to a reservation
	 * 
	 * @param int $reservation_id
	 * @return multitype:unknown |boolean
	 */
	public function getPaymentsByReservationId($reservation_id)
	{
		try {
			$reservation_id = (int) $reservation_id;
			
			$query = "SELECT * FROM payments WHERE reservation_id = ".$reservation_id;
			return $this->db->getArray($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getReservationGrandTotalByReservationId
	 * 
	 * returns the sum of the active payments by reservation id
	 * 
	 * @param int $reservation_id
	 * @return int | false on failed
	 */
	public function getReservationGrandTotalByReservationId($reservation_id)
	{
		try {
			$reservation_id = (int) $reservation_id;
			
			$stayingTotal = $this->getReservationStayingCostTotal($reservation_id);
			
			$query = 'SELECT SUM(cost) as grand_total FROM payments WHERE reservation_id = '.$reservation_id." AND active = 1 AND staying = 0";
			
			return ($this->db->getValue($query) + $stayingTotal);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getReservationPaidByReservationId
	 *
	 * returns the sum of the paid payments by reservation id
	 *
	 * @param int $reservation_id
	 * @return int | false on failed
	 */
	public function getReservationPaidByReservationId($reservation_id)
	{
		try {
			$reservation_id = (int) $reservation_id;
			$query = 'SELECT IFNULL(SUM(cost), 0) as grand_total FROM payments WHERE reservation_id = '.$reservation_id." AND active = 1 AND status = 1";
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * getReservationUnpaidByReservationId
	 *
	 * returns the sum of the pending payments by reservation id
	 *
	 * @param int $reservation_id
	 * @return int | false on failed
	 */
	public function getReservationUnpaidByReservationId($reservation_id)
	{
		try {
			
			$total = $this->getReservationGrandTotalByReservationId($reservation_id);
			$paid = $this->getReservationPaidByReservationId($reservation_id);
			
			return ($total - $paid);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getReservationStayingCostTotal($reservation_id)
	{
		try {
			$reservation_id = (int) $reservation_id;
			$query = 'SELECT price FROM reservations WHERE reservation_id = '.$reservation_id;
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getReservationStayingCostPaid($reservation_id)
	{
		try {
			$query = 'SELECT IFNULL(SUM(cost), 0) as staying_paid FROM payments WHERE reservation_id = '.$reservation_id." AND active = 1 AND status = 1 AND staying = 1";
			return $this->db->getValue($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getReservationStayingPending($reservation_id)
	{
		try {
			$total = $this->getReservationStayingCostTotal($reservation_id);
			$paid = $this->getReservationStayingCostPaid($reservation_id);
			
			return $total - $paid;
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function setPaymentStatus($paymentId)
	{
		try {
			$query = 'UPDATE payments SET status = 1 WHERE payment_id = '.$paymentId;
			
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function setPaymentType($data)
	{
		try {
			$query = 'UPDATE payments SET payment_type = '.$data['payType'].' WHERE payment_id = '.$data['paymentId'];
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function unActivePayment($paymentId)
	{
		try {
			$query = 'UPDATE payments SET active = 0 WHERE payment_id = '.$paymentId;
			return $this->db->run($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * uptadeSingleReservation
	 * 
	 * change the status of the reservation to pending, confirmed, checked-in, checked-out. BUT NOT TO CANCELED
	 * 
	 * @param array of data
	 * @return true on success, false on failed
	 */
	public function uptadeSingleReservation($data)
	{
		try {
			$query = 'UPDATE reservations 
					SET status = ?, 
					agency = ?
					WHERE reservation_id = '.$data['reservationId'];
				
			$prep = $this->db->prepare($query);
				
			$prep->bind_param('ii',
					$data['optRes'],
					$data['agencyId']);
			return $prep->execute();
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * addCancelation
	 * 
	 * Place a cancelation, creates a copy of the interested row on the cancelation table, 
	 * then the reservation is deleted
	 * 
	 * @param array $data array of data
	 * @return Ambigous <boolean, mixed>|boolean
	 */
	public function addCancelation($data)
	{
		try {
			$reservation_id = (int) $data['reservationId'];
				
			$query = 'INSERT INTO cancelations
					SELECT * FROM reservations
					WHERE reservation_id = '.$reservation_id;
				
			if ($this->db->run($query))
			{
				return $this->deleteReservation($reservation_id);
			}
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * deleteReservation
	 * 
	 * 
	 * 
	 * @param unknown $reservationId
	 * @return Ambigous <boolean, mixed>|boolean
	 */
	public function deleteReservation($reservationId)
	{
		try {
			$reservationId = (int) $reservationId;
			
			$query = 'DELETE 
					FROM reservations 
					WHERE reservation_id = '.$reservationId;
			
			return $this->db->run($query);
			
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function getReservationsByRange($start, $end)
	{
		try {
			$query = '
					SELECT r.*,
					m.name,
					m.last_name,
					a.agency,
					ro.room,
					m.country,
					m.notes,
					DATEDIFF(r.check_out, check_in) AS n_days,
					((SELECT IFNULL(SUM(p.cost), 0) as grand_total FROM payments p WHERE p.reservation_id = r.reservation_id AND p.active = 1 AND p.staying = 0) + r.price) as total,
					(SELECT IFNULL(SUM(cost), 0) as grand_total FROM payments WHERE reservation_id = r.reservation_id AND active = 1 AND status = 1) AS paid,
					FORMAT((r.price/DATEDIFF(r.check_out, check_in)), 0) AS ppn,
					CASE
						WHEN r.status = 1 THEN "Pending"
						WHEN r.status = 2 THEN "Confirmed"
						WHEN r.status = 3 THEN "In"
						WHEN r.status = 4 THEN "Out"
						WHEN r.status = 5 THEN "Canceled"
					END as r_status
					FROM reservations r
					LEFT JOIN members m ON r.member_id = m.member_id
					LEFT JOIN agencies a ON r.agency = a.agency_id
					LEFT JOIN rooms ro ON r.room_id = ro.room_id 
					WHERE r.check_in
					BETWEEN "'.$start.'" AND "'.$end.'"
					';
// 			echo $query;
			return $this->db->getArray($query);
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function updateReservation($data)
	{
		try {
			$checkIn 	= Tools::formatToMYSQL($data['checkIn']);
			$checkIn	= date($checkIn);
		
			$checkOut 	= Tools::formatToMYSQL($data['checkOut']);
			$checkOut 	= date($checkOut);
		
			$query = 'UPDATE reservations
					SET check_in = ?,
					check_out = ?,
					room_id = ?,
					price = ?
					WHERE reservation_id = '.$data['reservationId'];
			
			$prep = $this->db->prepare($query);
			
			$prep->bind_param('ssii',
					$checkIn,
					$checkOut,
					$data['roomId'],
					$data['total']);
			
			return $prep->execute();
			
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
			$query = 'UPDATE links SET title = ?, description = ? WHERE link_id = ?';
				
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
}

























