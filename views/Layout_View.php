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
	
	private $kindPage;
	
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
		
		switch ($_GET['kind'])
		{
			case 1:// Causas
				$this->kindPage = "causas";
			break;
			
			case 2:// Links
				$this->kindPage = "links";
			break;
			
			case 3:// Espacios
				$this->kindPage = "espacios";
			break;
			
			case 4:// Noticias
				$this->kindPage = "noticias";
			break;
			
			default:
				;
			break;
		}
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
				
				case 'main-sliders':
					echo self :: getMainSliderHead();
	 			break;
	 			
	 			case 'banner':
	 				echo self :: getBannerHead();
 				break;
 				
 				case 'aliados':
 					echo self :: getAliadosHead();
 				break;
 				
 				case 'directorio':
 					echo self :: getDirectorioHead();
 				break;
 				
 				case 'noticias':
 					echo self::getNoticiasHeader();
 				break;
 				
 				case 'editar-seccion':
 					echo self::getEditSectionHeader();
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
					<div class="col-sm-10 col-sm-offset-2 main">
						<h1 class="page-header"><?php echo $this->title; ?></h1>
						<?php 
						switch ($section) {

							case 'dashboard':
								echo self :: getIndexSections();
							break;
							
							case 'main-sliders':
								echo self :: getMainSlider();
							break;
							
							case 'banner':
								echo self :: getBanner();
							break;
							
							case 'aliados':
								echo self :: getAliados();
							break;
							
							case 'directorio':
								echo self :: getDirectorio();
							break;
							
							case 'links':
								echo self :: getLinksSections();
							break;
							
							case 'espacios':
								echo self :: getEspaciosSections();
							break;
							
							case 'noticias':
								echo self :: getNoticiasSections();
							break;
							
							case 'editar-seccion':
								echo self :: getEditSection();
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
					<li><a <?php if ($_GET['section'] == 5) echo $active; ?> href="/aliados/">Aliados y donantes</a></li>
					<li><a <?php if ($_GET['section'] == 5) echo $active; ?> href="/directorio/">Directorio</a></li>		
					<li><a <?php if ($_GET['section'] == 10) echo $active; ?> href="/sign-out/" class="sign-out">Salir</a></li>
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
   		<div class="col-sm-2 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li <?php if ($_GET['section'] == 1) echo $active; ?>><a href="/dashboard/">Causas</a></li>
				<li <?php if ($_GET['section'] == 2) echo $active; ?>><a href="/espacios/">Espacios</a></li>
				<li <?php if ($_GET['section'] == 3) echo $active; ?>><a href="/dashboard/">Proyectos</a></li>
				<li <?php if ($_GET['section'] == 4) echo $active; ?>><a href="/dashboard/">Actividades</a></li>
				<li <?php if ($_GET['section'] == 5) echo $active; ?>><a href="/dashboard/">Logros</a></li>
				<li <?php if ($_GET['section'] == 6) echo $active; ?>><a href="/noticias/">Noticias</a></li>
				<li <?php if ($_GET['section'] == 7) echo $active; ?>><a href="/links/">Links</a></li>
			</ul>
		</div>
   		<?php
   		$sideBar = ob_get_contents();
   		ob_end_clean();
   		return $sideBar;
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
	 * extra files for the main-slider
	 * @return string
	 */
	public function getBannerHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/banner.js"></script>
   		<?php		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
   	
   	/**
	 * Main slider
	 * 
	 * @return string
	 */
	public function getBanner()
	{
		ob_start();
		?>
		<div class="row">
			<div class="col-sm-12">
				<h5>(2050 * 1072 px)</h5>
			</div>
			<div class="col-sm-12 upload-slider">
				Upload
			</div>
		</div>
		
		<div class="row" id="slidersBox">
			<?php 
			if ($this->data['banner'])
			{
				echo self::getBannerItem($this->data['banner']);
			}
			?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getBannerItem($banner)
	{
		ob_start();
		?>
		<div class="col-sm-12 slider-item" id="sId-<?php echo $banner['banner_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-4">
					<img alt="" src="/images-system/medium/<?php echo $banner['banner']; ?>" />
				</div>
				<div class="col-sm-offset-7 col-sm-1">
					<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteSlider" sId="<?php echo $banner['banner_id']; ?>">Delete</a>
				</div>
			</div>
		</div>
		<?php
		$sliders = ob_get_contents();
		ob_end_clean();
		return $sliders;
	}
	
	/**
	 * extra files for the main-slider
	 * @return string
	 */
	public function getAliadosHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/aliados.js"></script>
   		<?php		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
   	
   	/**
	 * Main slider
	 * 
	 * @return string
	 */
	public function getAliados()
	{
		ob_start();
		?>
		<div class="row">
			<div class="col-sm-12">
				<h5>(170 * 170 px)</h5>
			</div>
			<div class="col-sm-12 upload-slider">
				Upload
			</div>
		</div>
		
		<div class="row" id="slidersBox">
			<?php 
			foreach ($this->data['aliados'] as $aliado)
			{
				echo self::getAliadosItem($aliado);
			}
			?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getAliadosItem($aliado)
	{
		ob_start();
		?>
		<div class="col-sm-12 slider-item" id="sId-<?php echo $aliado['aliado_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-4">
					<img alt="" src="/images-system/medium/<?php echo $aliado['aliado']; ?>" />
				</div>
				<div class="col-sm-offset-6 col-sm-2">
					<a href="javascript:void(0);" class="btn btn-info btn-xs saveSlider" sId="<?php echo $aliado['aliado_id']; ?>">Save</a>
					<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteSlider" sId="<?php echo $aliado['aliado_id']; ?>">Delete</a>
				</div>
			</div>
			
			<div class="col-sm-12 slider-section">
				<div class="col-sm-4">
					<input type="text" placeholder="Twitter" class="form-control" id="titleSlider-<?php echo $aliado['aliado_id']; ?>" value="<?php echo $aliado['twitter']; ?>">
				</div>
				<div class="col-sm-4">
					<input type="text" placeholder="Facebook" class="form-control" id="linkSlider-<?php echo $aliado['aliado_id']; ?>" value="<?php echo $aliado['facebook']; ?>">
				</div>
				<div class="col-sm-4">
					<input type="text" placeholder="Google Plus" class="form-control" id="gSlider-<?php echo $aliado['aliado_id']; ?>" value="<?php echo $aliado['gplus']; ?>">
				</div>
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
   	
   	public function getIndexSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   		<?php 
   		foreach ($this->data['causas'] as $section)
   		{
   			echo self::getSectionCausasItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getSectionCausasItem($section)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['causas_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="/images-system/medium/<?php echo $section['icon']; ?>" />
				</div>
				<div class="col-sm-9">
					<p class="section-title"><?php echo $section['title']; ?></p>
				</div>
				<div class="col-sm-1">
					<a href="/editar-causas/<?php echo $section['causas_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getLinksSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   		<?php 
   		foreach ($this->data['links'] as $section)
   		{
   			echo self::getLinksItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getLinksItem($section)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['causas_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="/images-system/medium/<?php echo $section['icon']; ?>" />
				</div>
				<div class="col-sm-9">
					<p class="section-title"><?php echo $section['title']; ?></p>
				</div>
				<div class="col-sm-1">
					<a href="/editar-links/<?php echo $section['link_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getEspaciosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   		<?php 
   		foreach ($this->data['espacios'] as $section)
   		{
   			echo self::getEspaciosItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getEspaciosItem($section)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['causas_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="/images-system/medium/<?php echo $section['icon']; ?>" />
				</div>
				<div class="col-sm-9">
					<p class="section-title"><?php echo $section['title']; ?></p>
				</div>
				<div class="col-sm-1">
					<a href="/editar-espacios/<?php echo $section['espacios_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getNoticiasHeader()
	{
		ob_start();
		?>
		<script src="/js/jquery.uploadfile.min.js"></script>
		<link rel="stylesheet" href="/css/jquery-ui.css">
		<script src="/js/jquery-ui.js"></script>
		<script src="/js/noticias.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	public function getNoticiasSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>Fecha</b></label>
						<div class="col-sm-2">
							<input type="text" placeholder="" class="form-control has-date" id="newNoticiaDate" value="">
						</div>
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-5">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newNoticiaTitle" value="">
						</div>
						<div class="col-sm-2 col-sm-offset-1">
							<button type="submit" class="btn btn-primary" id="addNoticia">A&ntilde;adir noticia</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="noticiasBox">
   		<?php 
   		foreach ($this->data['noticias'] as $section)
   		{
   			echo self::getNoticiasItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getNoticiasItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['noticias_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
					<p class="section-title"><?php echo Tools::formatMYSQLToFront($section['date']); ?></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-noticias/<?php echo $section['noticias_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteNew" sId="<?php echo $section['noticias_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	/**
	 * extra files for the main-slider
	 * @return string
	 */
	public function getDirectorioHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.dir.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/directorio.js"></script>
		
		<<script type="text/javascript">
		$(document).ready(function()
		{
		<?php
		if ($this->data['directorio'])
		{
			foreach ($this->data['directorio'] as $directorio)
			{
				?>
				$("#uploadDir-<?php echo $directorio['directorio_id']; ?>").uploadFile({
					url:		"/ajax/media.php",
					fileName:	"myfile",
					multiple: 	true,
					doneStr:	"uploaded!",
					dragDrop:	true,
					formData: {
							directorioId: <?php echo $directorio['directorio_id']; ?>,
							opt: 16 
						},
					onSuccess:function(files, data, xhr)
					{
						obj 			= JSON.parse(data);
						imageGallery 	= obj.fileName;
						lastIdGallery 	= obj.lastId;

						$('#iconDir<?php echo $directorio['directorio_id']; ?>').attr('src',"/images-system/medium/"+imageGallery);
					}
				});
				<?php
			}
		}
		?>
		});
		</script>
   		<?php		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
   	
   	/**
	 * Main slider
	 * 
	 * @return string
	 */
	public function getDirectorio()
	{
		ob_start();
		?>
		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>Nombre</b></label>
						<div class="col-sm-2">
							<input type="text" placeholder="Nombre" class="form-control has-date" id="dirName" value="">
						</div>
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-2">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="dirCharge" value="">
						</div>
						<label class="col-sm-1 control-label" for="textinput"><b>E-Mail</b></label>
						<div class="col-sm-2">
							<input type="text" placeholder="E-Mail" class="form-control" id="dirEmail" value="">
						</div>
						<div class="col-sm-2 col-sm-offset-1">
							<button type="submit" class="btn btn-primary" id="addDir">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
		
		<div class="row" id="dirBox">
			<?php 
			foreach ($this->data['directorio'] as $directorio)
			{
				echo self::getDirectorioItem($directorio);
			}
			?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getDirectorioItem($directorio)
	{
		ob_start();
		$img = '';
		if ($directorio['icon'])
			$img = '/images-system/medium/'.$directorio['icon'];
		else
			$img = '/images/100x100-default.jpg'; 
		?>
		<div class="col-sm-12 slider-item" id="sId-<?php echo $directorio['directorio_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" src="<?php echo $img; ?>" id="iconDir<?php echo $directorio['directorio_id']; ?>" />
				</div>
				<div class="col-sm-3">
					<div class="col-sm-12" id="uploadDir-<?php echo $directorio['directorio_id']; ?>">
						Cambiar foto. (155 * 138 px)
					</div>
				</div>
				<div class="col-sm-offset-5 col-sm-2">
					<a href="javascript:void(0);" class="btn btn-info btn-xs saveDir" sId="<?php echo $directorio['directorio_id']; ?>">Guardar</a>
					<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteDir" sId="<?php echo $directorio['directorio_id']; ?>">Eliminar</a>
				</div>
			</div>
			
			<div class="col-sm-12 slider-section">
				<div class="col-sm-4">
					<input type="text" placeholder="Nombre" class="form-control" id="dirName-<?php echo $directorio['directorio_id']; ?>" value="<?php echo $directorio['name']; ?>">
				</div>
				<div class="col-sm-4">
					<input type="text" placeholder="Titulo" class="form-control" id="dirCharge-<?php echo $directorio['directorio_id']; ?>" value="<?php echo $directorio['charge']; ?>">
				</div>
				<div class="col-sm-4">
					<input type="text" placeholder="E-Mail" class="form-control" id="dirEmail-<?php echo $directorio['directorio_id']; ?>" value="<?php echo $directorio['e_mail']; ?>">
				</div>
			</div>
		</div>
		<?php
		$sliders = ob_get_contents();
		ob_end_clean();
		return $sliders;
	}
   	
   	
   	
   	
   	public function getEditSectionHeader()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/trumbowyg/trumbowyg.min.js"></script>
		<link rel="stylesheet" href="/js/trumbowyg/ui/trumbowyg.min.css">
		<script type="text/javascript">
		$(document).ready(function()
				{
					$('.has-editor').trumbowyg({
					    fullscreenable: false,
					    semantic: true,
					    resetCss: true,
					    removeformatPasted: true,
					    autogrow: true,
					    mobile: true,
					    tablet: true,
					    btns: ['viewHTML',
					           '|', 'btnGrp-design',
					           '|', 'btnGrp-justify',
					           '|', 'btnGrp-lists']
					});
				});
		</script>
		<?php 
		switch ($this->kindPage)
		{
			case 'causas':
			?>
			<script src="/js/causas.js"></script>
			<?php
			break;
			
			case 'links':
			?>
			<script src="/js/links.js"></script>
			<?php
			break;
			
			case 'espacios':
			?>
			<script src="/js/espacios.js"></script>
			<?php
			break;
			
			case 'noticias':
			?>
			<script src="/js/noticias.js"></script>
			<?php
			break;
		}
		?>
		
   		<?php		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
   	
   	
   	
   	public function getEditSection()
   	{
   		$section = $this->data['section'];
   		ob_start();

		switch ($this->kindPage)
		{
			case 'causas':
			?>
			<input type="hidden" value="<?php echo $section['causas_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'links':
			?>
			<input type="hidden" value="<?php echo $section['link_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'espacios':
			?>
			<input type="hidden" value="<?php echo $section['espacios_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'noticias':
			?>
			<input type="hidden" value="<?php echo $section['noticias_id']; ?>" id="sectionId" />
			<?php
			break;
			
		}
		?>
   		
   		<div class="row edit-box">
	   		<?php 
	   		if ($section['has_icon'] == 1)
	   		{
	   				$img = '';
	   			if (!$section['icon'])
	   				$img = '/images/100x100-default.jpg';
	   			else
	   				$img = "/images-system/medium/".$section['icon'];
	   			?>
	   		<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-2">
						<img alt="" height="100" id="iconImg" src="<?php echo $img; ?>" />
					</div>
					<div class="col-sm-2">
						<h5><b>Icono</b> (170 * 170 px)</h5>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-6 upload-icon">
						Cambiar icono
					</div>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
	   			<?php
	   		}
	   		?>
   			
   			<?php 
	   		if ($section['has_bg'] == 1)
	   		{
	   			?>
	   		<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-2">
						<img alt="" width="170" id="iconbg" src="/images-system/medium/<?php echo $section['background']; ?>" />
					</div>
					<div class="col-sm-2">
						<h5><b>Fondo</b> (2050 * 1072 px)</h5>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-6 upload-bg">
						Cambiar fondo
					</div>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
	   			<?php
	   		}
	   		?>
	   		
	   		<?php 
	   		if ($section['has_portrait'] == 1)
	   		{
	   			$img = '';
	   			if (!$section['portrait'])
	   				$img = '/images/300x108-default.jpg';
	   			else
	   				$img = "/images-system/medium/".$section['portrait'];
	   			?>
	   		<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-2">
						<img alt="" width="170" id="portraitImg" src="<?php echo $img; ?>" />
					</div>
					<div class="col-sm-3">
						<h5><b>Imagen principal</b> (800 * 290 px)</h5>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-6 upload-portrait">
						Cambiar imagen principal
					</div>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
	   			<?php
	   		}
	   		?>
   		
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="sectionTitle" value="<?php echo $section['title']; ?>">
						</div>
					</div>
						
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Descripci&oacute;n</b></label>
						<div class="col-sm-10">
							<textarea rows="4" cols="" class="form-control" placeholder="Descripci&oacute;n" id="sectionDescription"><?php echo $section['description']; ?></textarea>
						</div>
					</div>
					
					<?php 
					if ($this->kindPage == 'causas' || $this->kindPage == 'espacios' || $this->kindPage == 'noticias')
					{
						?>
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Contenido</b></label>
						<div class="col-sm-10">
							<textarea rows="10" cols="" class="form-control has-editor" placeholder="Contenido" id="sectionContent"><?php echo $section['content']; ?></textarea>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>T&iacute;tulo segunda columna</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo segunda columna" class="form-control" id="secondColumnTitle" value="<?php echo $section['second_column_title']; ?>">
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>T&iacute;tulo tercera columna</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo tercera columna" class="form-control" id="thirdColumnTitle" value="<?php echo $section['third_column_title']; ?>">
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Bloques de la segunda columna</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo del bloque" class="form-control" id="bloqueTitle" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<textarea rows="3" cols="" class="form-control" placeholder="Contenido del bloque" id="bloqueContent"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<p  class="text-right"><a href="javascript:void(0)" class="addBloque">A&ntilde;adir bloque</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<h4 class="sub-header">Bloques a&ntilde;adidos</h4>	
						</div>
						<div class="col-sm-10 col-sm-offset-2" id="bloquesBox">
							<?php 
							if ($this->data['bloques'])
							{
								foreach ($this->data['bloques'] as $bloque)
								{
									?>
							<div class="itemBlock" id="itemBlock-<?php echo $bloque['espacios_bloques_id']; ?>">
								<div class="text-right">
									<a href="#" bloqueId="<?php echo $bloque['espacios_bloques_id']; ?>" class="glyphicon glyphicon-remove text-danger delete-bloque"></a>
								</div>
								<div>
									<h5><?php echo $bloque['title']; ?></h5>
									<p><?php echo $bloque['description']; ?></p>
								</div>
							</div>
									<?php
								}
							}
								
							?>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios')
					{
						?>
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Contenido tercera columna</b></label>
						<div class="col-sm-10">
							<textarea rows="12" cols="" class="form-control has-editor" placeholder="Contenido tercera columna" id="thirdColumnContent"><?php echo $section['third_column_content']; ?></textarea>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>URL del Video</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL del Video" class="form-control" id="singleVideo" value="<?php echo $section['video']; ?>">
						</div>
					</div>
						<?php
					}
					?>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary" id="updateSection">Guardar</button>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<?php 
		if ($this->kindPage == 'noticias')
		{
			?>
   		<div class="row gallery-box">
   			<h4 class="subheader">Galer&iacute;a de videos</h4>
   			<div class="row">
				<div class="col-sm-12">
					<form class="form-horizontal" role="form">
						<fieldset>
							<label class="col-sm-2 control-label" for="textinput"><b>URL del Video</b></label>
							<div class="col-sm-8">
								<input type="text" placeholder="URL del Video" class="form-control" id="videoURL" value="">
							</div>
							<div class="col-sm-2">
								<div class="pull-left">
									<button type="submit" class="btn btn-primary" id="addVideo">Agregar Video</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="col-sm-12" id="galleryVideoItems">
					<?php 
					if ($this->data['videos'])
					{
						foreach ($this->data['videos'] as $video)
						{
							?>
					<div class="col-sm-2 gallery-item" id="itemVideo-<?php echo $video['video_id']; ?>">
						<div class="delete-picture">
							<div class="text-right">
								<a href="#" videoId="<?php echo $video['video_id']; ?>" class="glyphicon glyphicon-remove text-danger delete-video"></a>
							</div>	
						</div>
						<div class="image">
							<img alt="" width="180" src="http://img.youtube.com/vi/<?php echo $video['video']; ?>/0.jpg">
						</div>
					</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
   		</div>
   			<?php
		}
		?>
   		
   		<?php 
		if ($this->kindPage == 'noticias')
		{
			?>
   		<div class="row gallery-box">
   			<h4 class="subheader">Galer&iacute;a de im&aacute;genes</h4>
   			<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-6 upload-gallery">
						A&ntilde;adir im&aacute;gen
					</div>
				</div>
				<div class="col-sm-12" id="galleryBoxItems">
					<?php 
					if ($this->data['gallery'])
					{
						foreach ($this->data['gallery'] as $picture)
						{
							?>
					<div class="col-sm-3 gallery-item" id="itemPicture-<?php echo $picture['picture_id']; ?>">
						<div class="delete-picture">
							<div class="text-right">
								<a href="#" pictureId="<?php echo $picture['picture_id']; ?>" class="glyphicon glyphicon-remove text-danger delete-picture"></a>
							</div>	
						</div>
						<div class="image">
							<img alt="" src="/images-system/medium/<?php echo $picture['picture']; ?>">
						</div>
					</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
   		</div>
   			<?php
		}
		?>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
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
}