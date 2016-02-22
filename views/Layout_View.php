<?php
/**
 * This file has the main view of the project
 *
 * @package    Reservation System
 * @subpackage Tropical Casa Blanca Hotel
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <rd.castro.silva@gmail.com>
 */

$root = $_SERVER['DOCUMENT_ROOT'];
/**
 * Includes the file /Framework/Tools.php which contains a 
 * serie of useful snippets used along the code
 */
require_once $root.'/Framework/Tools.php';

/**
 * 
 * Is the main class, almost everything is printed from here
 * 
 * @package 	Reservation System
 * @subpackage 	Tropical Casa Blanca Hotel
 * @author 		Raul Castro <rd.castro.silva@gmail.com>
 * 
 */
class Layout_View
{
	/**
	 * @property string $data a big array cotaining info for especified sections
	 */
	private $data;
	
	/**
	 * @property string $title title that will be printed in <title></title>
	 */
	private $title;
	
	/**
	 * @property string $section the section of the application, 
	 * it can be 'dashboard', 'members, ... 
	 * 
	 */
	private $section;
	
	/**
	 * get's the data *ARRAY* and the title of the document
	 * 
	 * @param array $data Is a big array with the whole info of the document 
	 * @param string $title The title that will be printed in <title></title>
	 */
	public function __construct($data, $title)
	{
		$this->data = $data;
		$this->title = $title;
	}    
	
	/**
	 * function printHTMLPage
	 * 
	 * Prints the content of the whole website
	 * 
	 * @param int $section the section that define what will be printed
	 * 
	 */
	
	public function printHTMLPage($section)
    {
    	$this->section = $section;
    ?>
	<!DOCTYPE html>
	<html class='no-js' lang='<?php echo $this->data['appInfo']['lang']; ?>'>
		<head>
			<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->
			<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
    		<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="favicon.ico" />
			<link rel="icon" type="image/gif" href="favicon.ico" />
			<title><?php echo $this->title; ?> - <?php echo $this->data['appInfo']['title']; ?></title>
			<meta name="keywords" content="<?php echo $this->data['appInfo']['keywords']; ?>" />
			<meta name="description" content="<?php echo $this->data['appInfo']['description']; ?>" />
			<meta property="og:type" content="website" /> 
			<meta property="og:url" content="<?php echo $this->data['appInfo']['url']; ?>" />
			<meta property="og:site_name" content="<?php echo $this->data['appInfo']['siteName']; ?> />
			<link rel='canonical' href="<?php echo $this->data['appInfo']['url']; ?>" />
			<?php echo self::getCommonDocuments(); ?>			
			<?php 
			switch ($section) 
			{
				case 'sign-in':
 					echo self :: getSignInHead();
				break;

				case 'dashboard':
					# code...
				break;
			
				case 'members':
					# code...
				break;

				case 'add-member':
					echo self :: getMembersHead();
				break;
				
				case 'reservations':
					echo self :: getReservationsHead();
				break;

				case 'rooms':
					echo self :: getRoomsHead();
				break;
				
				case 'rooms-month':
					echo self :: getRoomsMonthHead();
				break;

				case 'calendar':
					echo self :: getCalendarHead();
				break;
				
				case 'agencies':
					echo self :: getAgenciesHead();
				break;

				case 'tasks':
					echo self :: getTasksHead();
				break;
				
				case 'reports':
					echo self :: getReportsHead();
				break;
				
				case 'main-sliders':
					echo self :: getMainSliderHead();
	 			break;
			}
			?>
		</head>
		<body id="<?php echo $section; ?>">
			<?php 
 			echo self :: getHeader();
 
			if ($section != 'sign-in' && $section != 'sign-out')
			{
			?>
			<div class="container-fluid">
				<div class="row">
					<?php echo self::getSidebar(); ?>
					<div class="col-sm-11 col-sm-offset-1 main">
						<h1 class="page-header"><?php echo $this->title; ?></h1>
						<?php 
						echo self :: getDashboardIcons();
						switch ($section) {

							case 'dashboard':
								echo self :: getRecentMembers();
							break;

							case 'members':
								echo self :: getAllMembers();
							break;

							case 'add-member':
								echo self :: getAddMember();
							break;
							
							case 'reservations':
								echo self :: getReservations();
							break;
							
							case 'rooms':
								echo self :: getRooms();
							break;
							
							case 'rooms-month':
								echo self :: getRoomsMonth();
							break;

							case 'calendar':
								echo self :: getCalendar();
							break;
							
							case 'agencies':
								echo self :: getAgencies();
							break;

							case 'tasks':
								echo self :: getAllTasks();
							break;
							
							case 'reports':
								echo self :: getReports();
							break;
							
							case 'main-sliders':
								echo self :: getMainSlider();
							break;
							
							default :
								# code...
							break;
						}
						?>
					</div>
				</div>
			</div>
			<?php
			}
			else
			{
				switch ($section) 
				{
					case 'sign-in':
						echo self :: getSignInContent();
					break;
				
					case 'sign-out':
						echo self :: getSignOutContent();
					break;
					
					default:
					break;
				}
			}
			
// 			echo self::getFooter();
			?>
		</body>
	</html>
    <?php
    }
    
    /**
     * returns the common css and js that are in all the web documents
     * 
     * @return string $documents css & js files used in all the files
     */
    public function getCommonDocuments()
    {
    	ob_start();
    	?>
    	<script src="/js/jquery-2.1.3.min.js"></script>
    	<!-- Bootstrap -->
	    <link href="/css/bootstrap.min.css" rel="stylesheet">
	    <script src="/js/bootstrap.min.js"></script>
	
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
       	<link href="/css/style.css" media="screen" rel="stylesheet" type="text/css" />
    	<script src="/js/scripts.js"></script>
       	<?php 
       	$documents = ob_get_contents();
       	ob_end_clean();
       	return $documents; 
    }
    
    /**
     * The main menu
     *
     * it's the top and main navigation menu
     * if is logged shows a sign-in | sign-up links
     * but if is logged it shows other menus included the sign-out
     *
     * @return string HTML Code of the main menu 
     */
    public function getHeader()
    {
    	ob_start();
    	$active='class="active"';
    	?>  		
    	<header class="navigation navbar navbar-fixed-top main-menu-holder">
			<?php 
			if ($this->section == 'sign-in')
			{
				?>
			<nav class="nav navbar-nav navbar-fixed-top">
				<ul class="nav navbar-nav main-menu">
					<li class="active"><a href="/">Sign In</a></li>
					<li><a href="/">Sign Up</a></li>
				</ul>
			</nav>
				<?php 
			}
			else
			{
				?>
			<nav id='nav navbar-nav navbar-fixed-top'>
				<ul class="nav navbar-nav main-menu">
					<li><a <?php if ($_GET['section'] == 1) echo $active; ?> href="/dashboard/"><b><?php echo $this->data['userInfo']['name']; ?></b></a></li>
					<li><a <?php if ($_GET['section'] == 17) echo $active; ?> href="/banner/">Banner Principal</a></li>
					<li><a <?php if ($_GET['section'] == 5) echo $active; ?> href="#">Manage Rooms</a></li>		
					<li><a <?php if ($_GET['section'] == 10) echo $active; ?> href="/sign-out/" class="sign-out">Log Out</a></li>
				</ul>
			</nav>
				<?php 
			}
			?>
		</header>
    	<?php
    	$header = ob_get_contents();
    	ob_end_clean();
    	return $header;
    }
    
    /**
     * it is the head that works for the sign in section, aparently isn't getting 
     * any parameter, I just left it here for future cases
     *
     * @package 	Reservation System
     * @subpackage 	Sign-in
     * @todo 		Delete it?
     * 
     * @return string
     */
    public function getSignInHead()
    {
    	ob_start();
    	?>
    	<script type="text/javascript">
		</script>
    	<?php
    	$signIn = ob_get_contents();
    	ob_end_clean();
    	return $signIn;
    }
    
    /**
     * getSignInContent
     * 
     * the sign-in box
     * 
     * @package Reservation System
     * @subpackage Sign-in
     * 
     * @return string
     */
    public function getSignInContent()
    {
    	ob_start();
    	?>
    	<div class="login-box" id="sign-in">
			<div class="col-md-4 col-md-offset-4">
	    		<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">Log In</h3>
				 	</div>
				  	<div class="panel-body">
				    	<form accept-charset="UTF-8" role="form" method='post' 
								action="<?php echo $_SERVER['REQUEST_URI']; ?>" 
								id="slick-login">
		                    <fieldset>
					    	  	<div class="form-group">
					    		    <input class="form-control" 
					    		    		placeholder="Usuario" 
					    		    		type="text" 
					    		    		name='loginUser'>
					    		</div>
					    		<div class="form-group">
					    			<input class="form-control" 
					    					placeholder="Contrase&ntilde;a" 
					    					type="password" 
					    					value="" 
					    					name='loginPassword'>
					    		</div>
					    	    <input type="hidden" name="submitButton" value="1">
					    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Entrar" id="login">
					    	</fieldset>
				      	</form>
				    </div>
				</div>
			</div>
		</div>
        <?php
        $wideBody = ob_get_contents();
        ob_end_clean();
        return $wideBody;
    }
    
    /**
     * getSignOutContent
     *
     * It finish the session
     *
     * @package 	Reservation System
     * @subpackage 	Sign-in
     *
     * @return string
     */
    public function getSignOutContent()
    {
    	ob_start();
    	?>
       	<div class="row login-box" id="sign-in">
    		<div class="col-md-4 col-md-offset-4">
    			<h3 class="text-center">You've been logged out successfully</h3>
    			<br />
    	    	<div class="panel panel-default">
					<div class="panel-body">
						<a href="/" class="btn btn-lg btn-success btn-block">Login</a>
					</div>
    			</div>
    		</div>
    	</div>
		<?php
		$wideBody = ob_get_contents();
		ob_end_clean();
		return $wideBody;
    }
   	
    /**
     * The side bar of the apliccation
     * 
     * Is the side-bar of the application where the main sections are as links
     * 
     * @return string
     */
   	public function getSidebar()
   	{
   		ob_start();
   		$active = 'class="active"';
   		?>
   		<div class="col-sm-1 col-md-1 sidebar">
			<ul class="nav nav-sidebar">
				<li <?php if ($_GET['section'] == 1) echo $active; ?>><a href="/dashboard/">Dashboard</a></li>
				<li <?php if ($_GET['section'] == 12) echo $active; ?>><a href="/reservations/">New Reservation</a></li>
			</ul>
			
			<ul class="nav nav-sidebar">
				<?php 
   				if ($this->data['userInfo']['type'] == 1)
   				{
   					?>
				<li <?php if ($_GET['section'] == 16) echo $active; ?>><a href="/reports/">Reports</a></li>
				<?php 
				}
				?>
				<li <?php if ($_GET['section'] == 13) echo $active; ?>><a href="/rooms/">Rooms</a></li>
				<li <?php if ($_GET['section'] == 5) echo $active; ?>><a href="/agencies/">Agencies</a></li>
			</ul>
		</div>
   		<?php
   		$sideBar = ob_get_contents();
   		ob_end_clean();
   		return $sideBar;
   	}
   	
   	/**
   	 * the big icons that appear on the top of every section
   	 * 
   	 * @return string
   	 */
   	public function getDashboardIcons() 
   	{
   		ob_start();
   		?>
   		<div class="row placeholders dashboard-icons">
			<div class="col-xs-6 col-sm-3 placeholder">
				<a href="/guests/">
					<i class="glyphicon glyphicon-th"></i>
					<h4>Guests</h4>
					<span class="text-muted">
					<?php 
					if ($this->data['recentMembers'] > 0)
						echo $this->data['recentMembers'];
					else 
						echo 'No';
					?>
					 recent guests
					</span>
				</a>
			</div>
			<div class="col-xs-6 col-sm-3 placeholder">
				<a href="/tasks/">
					<i class="glyphicon glyphicon-th-list"></i>
					<h4>Tasks</h4>
					<span class="text-muted">
						<strong><?php echo $this->data['taskInfo']['today']; ?></strong> tasks for today, 
						<strong><?php echo $this->data['taskInfo']['pending']; ?></strong> pending
					</span>
				</a>
			</div>
		</div>
   		<?php
   		$dashboardIcons = ob_get_contents();
   		ob_end_clean();
   		return $dashboardIcons;
   	}
   	
   	/**
	 * Main slider
	 * 
	 * @return string
	 */
	public function getMainSlider()
	{
		ob_start();
		?>
		<div class="row">
			<div class="col-sm-12">
				<h5>(2050 * 640 px)</h5>
			</div>
			<div class="col-sm-12 upload-slider">
				Upload
			</div>
		</div>
		
		<div class="row" id="slidersBox">
			<?php 
			foreach ($this->data['sliders'] as $slider)
			{
				echo self::getSliderItem($slider);
			}
			?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getSliderItem($slider)
	{
		ob_start();
		?>
		<div class="col-sm-12 slider-item" id="sId-<?php echo $slider['slider_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-4">
					<img alt="" src="/images-system/sliders/<?php echo $slider['slider']; ?>" />
				</div>
				<div class="col-sm-offset-7 col-sm-1">
					<a href="javascript:void(0);" class="btn btn-info btn-xs saveSlider" sId="<?php echo $slider['slider_id']; ?>">Save</a>
					<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteSlider" sId="<?php echo $slider['slider_id']; ?>">Delete</a>
				</div>
			</div>
			
			<div class="col-sm-12 slider-section">
				<div class="col-sm-6">
					<input type="text" placeholder="Title" class="form-control" id="titleSlider-<?php echo $slider['slider_id']; ?>" value="<?php echo $slider['title']; ?>">
				</div>
				<div class="col-sm-6">
					<input type="text" placeholder="Link" class="form-control" id="linkSlider-<?php echo $slider['slider_id']; ?>" value="<?php echo $slider['link']; ?>">
				</div>
			</div>
			
			<div class="col-sm-12 slider-section">
				<textarea rows="2" cols="" class="form-control" placeholder="Info" id="infoSlider-<?php echo $slider['slider_id']; ?>"><?php echo $slider['info']; ?></textarea>
			</div>
		</div>
		<?php
		$sliders = ob_get_contents();
		ob_end_clean();
		return $sliders;
	}
   	
   	
   	
   	/**
   	 * Last n members
   	 * 
   	 * Is like a preview, it is printed on the dashboard
   	 * 
   	 * @return string
   	 */
   	
   	public function getRecentMembers()
   	{
   		ob_start();
   		?>
   		<h2 class="sub-header">Recent Guests</h2>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Member ID</th>
						<th>Name</th>
						<?php 
						if ($_SESSION['loginType'] == 1)
						{
						?>
							<th>Added by</th>
						<?php 
						} 
						else 
						{
						?>
							<th>Address</th>
						<?php 
						}
						?>
						<th>City</th>
						<th>State</th>
						<th>Country</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($this->data['lastMembers'] as $member)
					{
						?>
					<tr>
						<td>
							<a href="/<?php echo $member['member_id']; ?>/<?php echo Tools::slugify($member['name'].' '.$member['last_name']); ?>/">
								<?php echo $member['member_id']; ?>
							</a>
						</td>
						<td>
							<a href="/<?php echo $member['member_id']; ?>/<?php echo Tools::slugify($member['name'].' '.$member['last_name']); ?>/" class="member-link">
								<?php echo $member['name'].' '.$member['last_name']; ?>
							</a>
						</td>
						<?php 
						if ($_SESSION['loginType'] == 1)
						{
							?>
							<td><?php echo $member['user_name']; ?></td>
							<?php 
						} 
						else 
						{
							?>
							<td><?php echo $member['address']; ?></td>
							 <?php 
						}
						?>
						<td><?php echo $member['city']; ?></td>
						<td><?php echo $member['state']; ?></td>
						<td><?php echo $member['country']; ?></td>
					</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
   		<?php
   		$membersRecent = ob_get_contents();
   		ob_end_clean();
   		return $membersRecent;
   	}
	
   	/**
   	 * The whole list of members
   	 * 
   	 * @return string
   	 */
   	public function getAllMembers()
   	{
   		ob_start();
   		?>
   		
   	   	<?php
   	   	$membersRecent = ob_get_contents();
   	   	ob_end_clean();
   	   	return $membersRecent;
   	}
   	
   	/**
   	 * The very awesome footer!
   	 * 
   	 * <s>useless</s>
   	 * 
   	 * @return string
   	 */
    public function getFooter()
    {
    	ob_start();
    	?>
		<footer>
			<nav class="row navbar col-lg-8">
				<ul class='nav navbar-nav main-menu'>
					<li><a href="../contact-us/">Contact</a></li>
					<li><a href="#">API &amp; Hacks</a></li>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Privacy Policy</a></li>
					<li><a href="#">Terms of Service</a></li>
				</ul>
			</nav>
			<div class="row col-lg-4">
				<p>Copyright &copy; <?php echo date('Y'); ?> <?php echo $this->data['appInfo']['siteName']; ?>. All rights reserved.</p>
			<div>
		</footer>
    	<?php
    	$footer = ob_get_contents();
    	ob_end_clean();
    	return $footer;
	}
	
	/**
	 * extra files for the main-slider
	 * @return string
	 */
	public function getMainSliderHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/sliders.js"></script>
   		<?php		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
}