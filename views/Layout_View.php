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
			
			case 5:// Logros
				$this->kindPage = "logros";
			break;
			
			case 6:// Proyectos
				$this->kindPage = 'proyectos';
			break;
			
			case 7:
				$this->kindPage = 'actividades';
			break;
			
			case 8:
				$this->kindPage = 'campanas';
			break;
			
			case 9:
				$this->kindPage = 'materiales';
			break;
			
			case 10:
				$this->kindPage = 'voluntariado';
			break;
			
			case 11:
				$this->kindPage = 'embajadores';
			break;
			
			case 12:
				$this->kindPage = 'contenidos';
			break;
			
			case 13:
				$this->kindPage = 'productos';
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
 				
 				case 'footer':
 					echo self :: getFooterHead();
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
 				
 				case 'logros':
 					echo self::getLogrosHeader();
				break;
				
				case 'proyectos':
					echo self::getProyectosHeader();
				break;
 				
				case 'actividades':
					echo self::getActividadesHeader();
				break;
				
				case 'campanas':
					echo self::getCampanasHeader();
				break;
				
				case 'materiales':
					echo self::getMaterialesHeader();
				break;
				
				case 'voluntariado':
					echo self::getVoluntariadoHeader();
				break;
				
				case 'embajadores':
					echo self::getEmbajadoresHeader();
				break;
				
				case 'contenidos':
					echo self::getContenidosHeader();
				break;
				
				case 'productos':
					echo self::getProductosHeader();
				break;
				
 				case 'editar-seccion':
 					echo self::getEditSectionHeader();
 				break;
 				
 				case 'testimonios':
 					echo self :: getTestimoniosHead();
 				break;
 				
 				case 'documentos':
 					echo self::getDocumentosHeader();
 				break;
 				
 				case 'redes':
 					echo self::getRedesHeader();
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
							
							case 'footer':
								echo self :: getFooterUploader();
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
							
							case 'logros':
								echo self :: getLogrosSections();
							break;
							
							case 'proyectos':
								echo self :: getProyectosSections();
							break;
							
							case 'actividades':
								echo self :: getActividadesSections();
							break;
							
							case 'campanas':
								echo self :: getCampanasSections();
							break;
							
							case 'materiales':
								echo self :: getMaterialesSections();
							break;
							
							case 'editar-seccion':
								echo self :: getEditSection();
							break;
							
							case 'voluntariado':
								echo self::getVoluntariadoSection();
							break;
							
							case 'embajadores':
								echo self :: getEmbajadoresSections();
							break;
							
							case 'contenidos':
								echo self :: getContenidosSections();
							break;
							
							case 'testimonios':
								echo self :: getTestimonios();
							break;
							
							case 'productos':
								echo self :: getProductosSections();
							break;
							
							case 'documentos':
								echo self::getDocumentosSections();
							break;
							
							case 'redes':
								echo self::getRedesSections();
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
					<li><a <?php if ($_GET['section'] == 17) echo $active; ?> href="/footer/">Footer</a></li>
					<li><a <?php if ($_GET['section'] == 17) echo $active; ?> href="/redes-sociales/">Redes sociales</a></li>
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
				<li <?php if ($_GET['section'] == 8) echo $active; ?>><a href="/logros/">Logros</a></li>
				<li <?php if ($_GET['section'] == 3) echo $active; ?>><a href="/proyectos/">Proyectos</a></li>
				<li <?php if ($_GET['section'] == 4) echo $active; ?>><a href="/actividades/">Actividades</a></li>
				<li <?php if ($_GET['section'] == 9) echo $active; ?>><a href="/campanas/">Campa&ntilde;as</a></li>
				<li <?php if ($_GET['section'] == 10) echo $active; ?>><a href="/materiales/">Materiales</a></li>
				<li <?php if ($_GET['section'] == 6) echo $active; ?>><a href="/noticias/">Noticias</a></li>
				<li <?php if ($_GET['section'] == 2) echo $active; ?>><a href="/espacios/">Espacios</a></li>
				<li <?php if ($_GET['section'] == 15) echo $active; ?>><a href="/contenidos/">Contenidos</a></li>
				<li <?php if ($_GET['section'] == 11) echo $active; ?>><a href="/servicio-social/">Servicio Social</a></li>
				<li <?php if ($_GET['section'] == 12) echo $active; ?>><a href="/practicas/">Practicas profesionales</a></li>
				<li <?php if ($_GET['section'] == 13) echo $active; ?>><a href="/embajadores/">Embajadores</a></li>
				<li <?php if ($_GET['section'] == 14) echo $active; ?>><a href="/testimonios/">Testimonios</a></li>
				<li <?php if ($_GET['section'] == 16) echo $active; ?>><a href="/donativos/">Donativos</a></li>
				<li <?php if ($_GET['section'] == 17) echo $active; ?>><a href="/aportaciones/">Aportaciones</a></li>
				<li <?php if ($_GET['section'] == 20) echo $active; ?>><a href="/productos/">Productos</a></li>
				<li <?php if ($_GET['section'] == 21) echo $active; ?>><a href="/documentos/">Documentos</a></li>
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
				<h5>JPG(2050 * 1072 px)</h5>
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
	public function getFooterHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/footer.js"></script>
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
	public function getFooterUploader()
	{
		ob_start();
		?>
		<div class="row">
			<div class="col-sm-12">
				<h5>JPG(2050 * 1404 px)</h5>
			</div>
			<div class="col-sm-12 upload-slider">
				Upload
			</div>
		</div>
		
		<div class="row" id="slidersBox">
		<?php 
		if ($this->data['banner'])
		{
			echo self::getFooterItem($this->data['banner']);
		}
		?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getFooterItem($banner)
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
			<!-- 
			<div class="col-sm-12 slider-section " id="causasSelector-<?php echo $aliado['aliado_id']; ?>">
				<div class="col-sm-3">
					<input type="checkbox" class="causas-selector-item" <?php if($aliado['conservacion'] == 1){echo "checked";} ?> causaName="conservacion" > 
					<label>Conservaci&oacute;n</label>
				</div>
				<div class="col-sm-3">
					<input type="checkbox" class="causas-selector-item" <?php if($aliado['bienestar'] == 1){echo "checked";} ?> causaName="bienestar" > 
					<label>Bienestar comunitario</label>
				</div>
				<div class="col-sm-3">
					<input type="checkbox" class="causas-selector-item" <?php if($aliado['educacion'] == 1){echo "checked";} ?> causaName="educacion" > 
					<label>Educaci&oacute;n ambiental</label>
				</div>
			</div>
			 -->
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
   		if ($section['icon'])
			$img = '/images-system/medium/'.$section['icon'];
		else
			$img = '/images/default-122-100.jpg'; 
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['causas_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
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
	
	public function getLogrosHeader()
	{
		ob_start();
		?>
		<script src="/js/logros.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	public function getLogrosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-5">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newLogroTitle" value="">
						</div>
						<div class="col-sm-2 col-sm-offset-4">
							<button type="submit" class="btn btn-primary" id="addLogro">A&ntilde;adir logro</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="logrosBox">
   		<?php 
   		foreach ($this->data['logros'] as $section)
   		{
   			echo self::getLogrosItem($section);
   		}
   		?>
   		</div>
   		
   		<h3 class="page-header" style="margin-top: 30px;">Fechas destacadas</h3>
   		
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<div class="col-sm-5">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newFechaDestacadaTitle" value="">
						</div>
						<div class="col-sm-5">
							<input type="text" placeholder="URL" class="form-control" id="newFechaDestacadaURL" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addFechaDestacada">A&ntilde;adir fecha</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		<div class="row" id="fechasDestacadasBox">
   		<?php 
   		foreach ($this->data['fechasDestacadas'] as $section)
   		{
   			echo self::getFechaDestacadaItem($section);
   		}
   		?>
   		</div>
   		
   		<h3 class="page-header" style="margin-top: 30px;">Otros logros</h3>
   		
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newOtrosLogrosTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addOtrosLogros">A&ntilde;adir logro</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		<div class="row" id="otrosLogrosBox">
   		<?php 
   		foreach ($this->data['otrosLogros'] as $section)
   		{
   			echo self::getOtrosLogrosItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getLogrosItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['logros_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-logros/<?php echo $section['logros_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteLogro" sId="<?php echo $section['logros_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getFechaDestacadaItem($section)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['logros_fechas_id']; ?>">
			<div class="col-sm-12">
				<div class=" col-sm-9">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
					<p class="section-title"><?php echo $section['url']; ?></p>
				</div>
				<div class="col-sm-1 col-sm-offset-2">
					<a href="" class="btn btn-danger btn-xs deleteLogrosFechas" sId="<?php echo $section['logros_fechas_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getOtrosLogrosItem($section)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['logros_otros_id']; ?>">
			<div class="col-sm-12">
				<div class=" col-sm-9">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-1 col-sm-offset-2">
					<a href="" class="btn btn-danger btn-xs deleteOtrosLogros" sId="<?php echo $section['logros_otros_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getProyectosHeader()
	{
		ob_start();
		?>
		<script src="/js/proyectos.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	public function getProyectosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newProyectoTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addProyecto">A&ntilde;adir proyecto</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="proyectosBox">
   		<?php 
   		foreach ($this->data['proyectos'] as $section)
   		{
   			echo self::getProyectosItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getProyectosItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['proyectos_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-proyectos/<?php echo $section['proyectos_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteProyectos" sId="<?php echo $section['proyectos_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getActividadesHeader()
	{
		ob_start();
		?>
		<script src="/js/jquery.uploadfile.min.js"></script>
		<link rel="stylesheet" href="/css/jquery-ui.css">
		<script src="/js/jquery-ui.js"></script>
		<script src="/js/actividades.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	public function getActividadesSections()
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
							<button type="submit" class="btn btn-primary" id="addNoticia">A&ntilde;adir actividad</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="noticiasBox">
   		<?php 
   		foreach ($this->data['actividades'] as $section)
   		{
   			echo self::getActividadesItem($section);
   		}
   		?>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getActividadesItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['actividades_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
					<p class="section-title"><?php echo Tools::formatMYSQLToFront($section['date']); ?></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-actividades/<?php echo $section['actividades_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs deleteSlider" sId="<?php echo $section['section_id']; ?>">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteActividad" sId="<?php echo $section['actividades_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getCampanasHeader()
	{
		ob_start();
		?>
		<script src="/js/campanas.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getCampanasSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newCampanaTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addCampana">A&ntilde;adir campa&ntilde;a</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="campanasBox">
   		<?php 
   		foreach ($this->data['campanas'] as $section)
   		{
   			echo self::getCampanasItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getCampanasItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['campanas_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-campanas/<?php echo $section['campanas_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteCampanas" sId="<?php echo $section['campanas_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getMaterialesHeader()
	{
		ob_start();
		?>
		<script src="/js/materiales.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getMaterialesSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newMaterialTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addMaterial">A&ntilde;adir material</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="materialesBox">
   		<?php 
   		foreach ($this->data['materiales'] as $section)
   		{
   			echo self::getMaterialesItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getMaterialesItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['materiales_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-materiales/<?php echo $section['materiales_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteMaterial" sId="<?php echo $section['materiales_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getVoluntariadoHeader()
	{
		ob_start();
		?>
		<script src="/js/voluntariado.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getVoluntariadoSection()
   	{
   		$pageSection = 0;
   		 
   		switch ($_GET['type'])
   		{
   			case '1';
   			$pageSection = 11;
   			break;
   		
   			case '2':
   				$pageSection = 12;
   				break;
   					
   			case '3':
   				$pageSection = 16;
   			break;
   			
   			case '4':
   				$pageSection = 17;
			break;
   		}
   		
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newTitle" value="">
							<input type="hidden" id="voluntariadoType" value="<?php echo $_GET['type']; ?>">
							<input type="hidden" id="pageSection" value="<?php echo $pageSection; ?>">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addVoluntariado">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="voluntariadoBox">
   		<?php
   		foreach ($this->data['voluntariados'] as $section)
   		{
   			echo self::getVoluntariadoItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getVoluntariadoItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		$pageSection = 0;
   		
   		switch ($_GET['type'])
   		{
   			case '1';
   				$pageSection = 11;
   			break;
   			
   			case '2':
				$pageSection = 12;
			break;
			
			case '3':
				$pageSection = 16;
			break;
			
			case '4':
				$pageSection = 17;
			break;
   		}
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['voluntariado_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-voluntariado/<?php echo $section['voluntariado_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/".$pageSection; ?>/" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs delete" sId="<?php echo $section['voluntariado_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getEmbajadoresHeader()
	{
		ob_start();
		?>
		<script src="/js/embajadores.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getEmbajadoresSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newMaterialTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addMaterial">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="materialesBox">
   		<?php 
   		foreach ($this->data['materiales'] as $section)
   		{
   			echo self::getEmbajadoresItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getEmbajadoresItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['materiales_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-embajadores/<?php echo $section['materiales_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteMaterial" sId="<?php echo $section['materiales_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getContenidosHeader()
	{
		ob_start();
		?>
		<script src="/js/contenidos.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getContenidosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newMaterialTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addMaterial">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="materialesBox">
   		<?php 
   		foreach ($this->data['materiales'] as $section)
   		{
   			echo self::getContenidosItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getContenidosItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['materiales_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-contenidos/<?php echo $section['materiales_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteMaterial" sId="<?php echo $section['materiales_id']; ?>">Eliminar</a>
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
	public function getTestimoniosHead()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.dir.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/testimonios.js"></script>
		
		<<script type="text/javascript">
		$(document).ready(function()
		{
		<?php
		if ($this->data['testimonios'])
		{
			foreach ($this->data['testimonios'] as $testimonio)
			{
				?>
				$("#uploadDir-<?php echo $testimonio['testimonios_id']; ?>").uploadFile({
					url:		"/ajax/media.php",
					fileName:	"myfile",
					multiple: 	true,
					doneStr:	"uploaded!",
					dragDrop:	true,
					formData: {
							directorioId: <?php echo $testimonio['testimonios_id']; ?>,
							opt: 32 
						},
					onSuccess:function(files, data, xhr)
					{
						obj 			= JSON.parse(data);
						imageGallery 	= obj.fileName;
						lastIdGallery 	= obj.lastId;

						$('#iconDir<?php echo $testimonio['testimonios_id']; ?>').attr('src',"/images-system/medium/"+imageGallery);
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
	public function getTestimonios()
	{
		ob_start();
		?>
		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>Testimonio</b></label>
						<div class="col-sm-8">
							<textarea placeholder="testimonio" class="form-control" id="newTestimonio"></textarea>
						</div>
						<div class="col-sm-2 col-sm-offset-1">
							<button type="submit" class="btn btn-primary" id="addTestimonio">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
		
		<div class="row" id="dirBox">
			<?php 
			foreach ($this->data['testimonios'] as $testimonio)
			{
				echo self::getTestimoniosItem($testimonio);
			}
			?>
		</div>
		<?php
		$agencies = ob_get_contents();
		ob_end_clean();
		return $agencies; 
	}
	
	public function getTestimoniosItem($testimonio)
	{
		ob_start();
		$img = '';
		if ($testimonio['icon'])
			$img = '/images-system/medium/'.$testimonio['icon'];
		else
			$img = '/images/100x100-default.jpg'; 
		?>
		<div class="col-sm-12 slider-item" id="sId-<?php echo $testimonio['testimonios_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" src="<?php echo $img; ?>" id="iconDir<?php echo $testimonio['testimonios_id']; ?>" />
				</div>
				<div class="col-sm-4">
					<div class="col-sm-12" id="uploadDir-<?php echo $testimonio['testimonios_id']; ?>">
						Cambiar foto. JPG (270 * 241 px)
					</div>
				</div>
				<div class="col-sm-offset-3 col-sm-2">
					<a href="javascript:void(0);" class="btn btn-info btn-xs saveDir" sId="<?php echo $testimonio['testimonios_id']; ?>">Guardar</a>
					<a href="javascript:void(0);" class="btn btn-danger btn-xs deleteDir" sId="<?php echo $testimonio['testimonios_id']; ?>">Eliminar</a>
				</div>
			</div>
			
			<div class="col-sm-12 slider-section">
				<p><?php echo $testimonio['description']; ?></p>
			</div>
			
			<div class="col-sm-12 slider-section " id="causasSelector-<?php echo $testimonio['testimonios_id']; ?>">
				<div class="col-sm-1">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['general'] == 1){echo "checked";} ?> causaName="general" > 
					<label>General</label>
				</div>
				
				<div class="col-sm-1">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['servicios'] == 1){echo "checked";} ?> causaName="servicios" > 
					<label>Servicios</label>
				</div>
				<div class="col-sm-1">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['practicas'] == 1){echo "checked";} ?> causaName="practicas" > 
					<label>Practicas</label>
				</div>
				<div class="col-sm-2">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['voluntariado'] == 1){echo "checked";} ?> causaName="voluntariado" > 
					<label>Voluntariado</label>
				</div>
				
				<div class="col-sm-2">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['experiencia'] == 1){echo "checked";} ?> causaName="experiencia" > 
					<label>Experiencia</label>
				</div>
				
				<div class="col-sm-2">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['embajadores'] == 1){echo "checked";} ?> causaName="embajadores" > 
					<label>Embajadores</label>
				</div>
				
				<div class="col-sm-2">
					<input type="checkbox" class="causas-selector-item" <?php if($testimonio['aliados'] == 1){echo "checked";} ?> causaName="aliados" > 
					<label>Aliados y donantes</label>
				</div>
			</div>
			 
		</div>
		<?php
		$sliders = ob_get_contents();
		ob_end_clean();
		return $sliders;
	}
	
	public function getProductosHeader()
	{
		ob_start();
		?>
		<script src="/js/productos.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getProductosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
   			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="textinput"><b>T&iacute;tulo</b></label>
						<div class="col-sm-9">
							<input type="text" placeholder="T&iacute;tulo" class="form-control" id="newMaterialTitle" value="">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" id="addMaterial">A&ntilde;adir</button>
						</div>
					</div>
				</fieldset>
			</form>
   		</div>
   		
   		<div class="row" id="materialesBox">
   		<?php 
   		foreach ($this->data['productos'] as $section)
   		{
   			echo self::getProductosItem($section);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getProductosItem($section)
   	{
   		$img = '';
   		if (!$section['icon'])
   			$img = '/images/100x100-default.jpg';
   		else
   			$img = "/images-system/medium/".$section['icon'];
   		
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $section['materiales_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<img alt="" height="100" src="<?php echo $img; ?>" />
				</div>
				<div class="col-sm-8">
					<p class="section-title"><strong><?php echo $section['title']; ?></strong></p>
				</div>
				<div class="col-sm-2">
					<a href="/editar-contenidos/<?php echo $section['materiales_id']; ?>/<?php echo Tools::slugify($section['title']); ?>/<?php echo $section['kind']."/"; ?>" class="btn btn-info btn-xs">Editar</a>
					<a href="" class="btn btn-danger btn-xs deleteMaterial" sId="<?php echo $section['materiales_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getDocumentosHeader()
	{
		ob_start();
		?>
		<link href="/css/uploadfile.css" rel="stylesheet">
		<script src="/js/jquery.uploadfile.min.js"></script>
		<script src="/js/documentos.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getDocumentosSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-6 upload-icon">
					Cargar documento
				</div>
			</div>
			<br>
			<div class="clearfix"></div>
   		
   		</div>
   		
   		<div class="row" id="documentsBox">
   		<?php 
   		foreach ($this->data['documentos'] as $documento)
   		{
   			$url = $this->data['appInfo']['url'].'/pdf/'.$documento['documento'];
   			echo self::getDocumentosItem($documento, $url);
   		}
   		?>
   		</div>
   		
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
   	}
	
   	public function getDocumentosItem($documento, $url)
   	{
   		ob_start();
   		?>
   		<div class="col-sm-12 slider-item" id="sId-<?php echo $documento['documento_id']; ?>">
			<div class="col-sm-12">
				<div class="col-sm-8">
					<p class="section-title"><i><?php echo $url; ?></i></p>
				</div>
				<div class="col-sm-2">
					<a href="" class="btn btn-danger btn-xs deleteDocumento" sId="<?php echo $documento['documento_id']; ?>">Eliminar</a>
				</div>
			</div>
		</div>
   		<?php
   		$item = ob_get_contents();
   		ob_end_clean();
   		return $item;
   	}
   	
   	public function getRedesHeader()
	{
		ob_start();
		?>
		<script src="/js/redes.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		});
		</script>
		
   		<?php		
		$sectionHead = ob_get_contents();
		ob_end_clean();
		return $sectionHead;
	}
   	
   	
   	public function getRedesSections()
   	{
   		ob_start();
   		?>
   		<div class="row">
			<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Twitter</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rTwitter" value="<?php echo $this->data['appInfo']['twitter']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Facebook</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rFacebook" value="<?php echo $this->data['appInfo']['facebook']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Google Plus</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rGoogle" value="<?php echo $this->data['appInfo']['googleplus']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Pinterest</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rPinterest" value="<?php echo $this->data['appInfo']['pinterest']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Linkedin</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rLinkedin" value="<?php echo $this->data['appInfo']['linkedin']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Youtube</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rYoutube" value="<?php echo $this->data['appInfo']['youtube']; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Instagram</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="rInstagram" value="<?php echo $this->data['appInfo']['instagram']; ?>">
						</div>
					</div>
				</fieldset>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="pull-right">
							<button type="submit" class="btn btn-primary" id="updateRedes">Guardar</button>
						</div>
					</div>
				</div>
			</form>
			<div class="clearfix"></div>
   		</div>
   		<?php
   		$inicio = ob_get_contents();
   		ob_end_clean();
   		return $inicio;
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
					    semantic: 		true,
					    resetCss: true,
					    removeformatPasted: true,
					    autogrow: true,
					    mobile: true,
					    tablet: true,
					    btns: ['viewHTML',
					           '|', 'btnGrp-design',
					           '|', 'btnGrp-justify',
					           '|', 'btnGrp-lists',
					           '|', 'link'],
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
			
			case 'logros':
			?>
			<script src="/js/logros.js"></script>
			<?php
			break;
			
			case 'proyectos':
				?>
			<script src="/js/proyectos.js"></script>
			<?php
			break;
			
			case 'actividades':
				?>
			<script src="/js/actividades.js"></script>
			<?php
			break;
			
			case 'campanas':
				?>
			<script src="/js/campanas.js"></script>
			<?php
			break;
			
			case 'materiales':
				?>
			<script src="/js/materiales.js"></script>
			<?php
			break;
			
			case 'voluntariado':
				?>
			<script src="/js/voluntariado.js"></script>
			<?php
			break;
			
			case 'embajadores':
				?>
			<script src="/js/embajadores.js"></script>
			<?php
			break;
			
			case 'contenidos':
				?>
			<script src="/js/contenidos.js"></script>
			<?php
			break;
			
			case 'productos':
				?>
			<script src="/js/productos.js"></script>
			<?php
			break;
			
			
		}
		
		$agenciesHead = ob_get_contents();
		ob_end_clean();
		return $agenciesHead;
	}
   	
   	public function getEditSection()
   	{
   		$section = $this->data['section'];
   		ob_start();

   		$iconSize 		= '';
   		$portraitSize 	= '';
   		
		switch ($this->kindPage)
		{
			
			case 'causas':
				$iconSize 		= 'JPG (370 * 300 px)';
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
				$iconSize 		= 'JPG (270 * 241 px)';
				$portraitSize = 'JPG (2050 * 1072 px)';
			?>
			<input type="hidden" value="<?php echo $section['espacios_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'noticias':
				$iconSize 		= 'JPG (270 * 241 px)';
				$portraitSize 	= 'JPG (800 * 290 px)';
			?>
			<input type="hidden" value="<?php echo $section['noticias_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'logros':
				$iconSize 		= 'JPG (270 * 241 px)';
				$portraitSize 	= 'JPG (900 * 560 px)';
			?>
			<input type="hidden" value="<?php echo $section['logros_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'proyectos':
				$iconSize 		= 'JPG (270 * 241 px)';
			?>
			<input type="hidden" value="<?php echo $section['proyectos_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'actividades':
				$iconSize 		= 'JPG (270 * 241 px o 569 * 290 px)';
				$portraitSize 	= 'JPG (800 * 290 px)';
			?>
			<input type="hidden" value="<?php echo $section['actividades_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'campanas':
				$iconSize 		= 'JPG (270 * 241 px)';
				$portraitSize 	= 'JPG (570 * 290 px)';
			?>
			<input type="hidden" value="<?php echo $section['campanas_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'materiales':
				$iconSize 		= 'JPG (370 * 300 px)';
				$portraitSize 	= 'JPG (800 * 290 px)';
			?>
			<input type="hidden" value="<?php echo $section['materiales_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'voluntariado':
				$iconSize 		= 'JPG (270 * 241 px)';
			?>
			<input type="hidden" value="<?php echo $section['voluntariado_id']; ?>" id="sectionId" />
			<?php
			break;
			
			case 'embajadores':
			case 'contenidos':
			case 'productos':
				$iconSize 		= 'JPG (270 * 241 px)';
				$portraitSize 	= 'JPG (800 * 290 px)';
			?>
			<input type="hidden" value="<?php echo $section['materiales_id']; ?>" id="sectionId" />
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
					<div class="col-sm-3">
						<h5><b>Icono</b> <?php echo $iconSize; ?></h5>
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
					<div class="col-sm-3">
						<img alt="" width="170" id="iconbg" src="/images-system/medium/<?php echo $section['background']; ?>" />
					</div>
					<div class="col-sm-3">
						<h5><b>Fondo</b> <?php echo $portraitSize; ?></h5>
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
					<div class="col-sm-3">
						<img alt="" width="170" id="portraitImg" src="<?php echo $img; ?>" />
					</div>
					<div class="col-sm-4">
						<h5><b>Imagen principal</b> <?php echo $portraitSize; ?></h5>
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
					if ($this->kindPage == 'links' || $this->kindPage == 'causas' || $this->kindPage == 'espacios' || $this->kindPage == 'noticias' || $this->kindPage == 'proyectos' || $this->kindPage == 'actividades' || $this->kindPage == 'campanas' || $this->kindPage == 'materiales' || $this->kindPage == 'voluntariado' || $this->kindPage == 'embajadores' || $this->kindPage == 'contenidos' || $this->kindPage == 'productos')
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
					if ($this->kindPage == 'proyectos' || $this->kindPage == 'voluntariado')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>T&iacute;tulo primera columna</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo primera columna" class="form-control" id="firstColumnTitle" value="<?php echo $section['first_column_title']; ?>">
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios' || $this->kindPage == 'proyectos' || $this->kindPage == 'campanas' || $this->kindPage == 'voluntariado')
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
					if ($this->kindPage == 'espacios' || $this->kindPage == 'proyectos' || $this->kindPage == 'campanas' || $this->kindPage == 'voluntariado')
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
					if ($this->kindPage == 'proyectos')
					{
						?>
						<h4>Links de la primera columna</h4>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Titulo del link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo del link" class="form-control" id="linkTitle-1" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL" class="form-control" id="linkUrl-1" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<p  class="text-right"><a href="javascript:void(0)" class="addLink" linkType="1">A&ntilde;adir Link</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<h4 class="sub-header">Links a&ntilde;adidos</h4>	
						</div>
						<div class="col-sm-10 col-sm-offset-2" id="linksBox-1">
							<?php 
							if ($this->data['links-1'])
							{
								foreach ($this->data['links-1'] as $link)
								{
									?>
							<div class="itemBlock" id="linkBlock-<?php echo $link['proyectos_links_id']; ?>">
								<div class="text-right">
									<a href="#" linkId="<?php echo $link['proyectos_links_id']; ?>" class="glyphicon glyphicon-remove text-danger deleteProyectosLink"></a>
								</div>
								<div>
									<a href="<?php echo $link['url']; ?>" target="_blank" linkId="<?php echo $link['proyectos_links_id']; ?>" class="text-success"><?php echo $link['title']; ?></a>
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
					if ($this->kindPage == 'proyectos')
					{
						?>
						<h4>Links de la segunda columna</h4>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Titulo del link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo del link" class="form-control" id="linkTitle-2" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL" class="form-control" id="linkUrl-2" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<p  class="text-right"><a href="javascript:void(0)" class="addLink" linkType="2">A&ntilde;adir Link</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<h4 class="sub-header">Links a&ntilde;adidos</h4>	
						</div>
						<div class="col-sm-10 col-sm-offset-2" id="linksBox-2">
							<?php 
							if ($this->data['links-2'])
							{
								foreach ($this->data['links-2'] as $link)
								{
									?>
							<div class="itemBlock" id="linkBlock-<?php echo $link['proyectos_links_id']; ?>">
								<div class="text-right">
									<a href="#" linkId="<?php echo $link['proyectos_links_id']; ?>" class="glyphicon glyphicon-remove text-danger deleteProyectosLink"></a>
								</div>
								<div>
									<a href="<?php echo $link['url']; ?>" target="_blank" linkId="<?php echo $link['proyectos_links_id']; ?>" class="text-success"><?php echo $link['title']; ?></a>
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
					if ($this->kindPage == 'proyectos' || $this->kindPage == 'campanas')
					{
						?>
						<h4>Links de la tercera columna</h4>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Titulo del link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo del link" class="form-control" id="linkTitle-3" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL" class="form-control" id="linkUrl-3" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<p  class="text-right"><a href="javascript:void(0)" class="addLink" linkType="3">A&ntilde;adir Link</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<h4 class="sub-header">Links a&ntilde;adidos</h4>	
						</div>
						<div class="col-sm-10 col-sm-offset-2" id="linksBox-3">
							<?php 
							if ($this->data['links-3'])
							{
								foreach ($this->data['links-3'] as $link)
								{
									?>
							<div class="itemBlock" id="linkBlock-<?php echo $link['proyectos_links_id']; ?>">
								<div class="text-right">
									<a href="#" linkId="<?php echo $link['proyectos_links_id']; ?>" class="glyphicon glyphicon-remove text-danger deleteProyectosLink"></a>
								</div>
								<div>
									<a href="<?php echo $link['url']; ?>" target="_blank" linkId="<?php echo $link['proyectos_links_id']; ?>" class="text-success"><?php echo $link['title']; ?></a>
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
					if ($this->kindPage == 'campanas!')
					{
						?>
						<h4>Links spots de radio</h4>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Titulo del link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="T&iacute;tulo del link" class="form-control" id="linkTitle-4" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Link</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL" class="form-control" id="linkUrl-4" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<p  class="text-right"><a href="javascript:void(0)" class="addLink" linkType="4">A&ntilde;adir Link</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<h4 class="sub-header">Links a&ntilde;adidos</h4>	
						</div>
						<div class="col-sm-10 col-sm-offset-2" id="linksBox-4">
							<?php 
							if ($this->data['links-3'])
							{
								foreach ($this->data['links-4'] as $link)
								{
									?>
							<div class="itemBlock" id="linkBlock-<?php echo $link['proyectos_links_id']; ?>">
								<div class="text-right">
									<a href="#" linkId="<?php echo $link['proyectos_links_id']; ?>" class="glyphicon glyphicon-remove text-danger deleteProyectosLink"></a>
								</div>
								<div>
									<a href="<?php echo $link['url']; ?>" target="_blank" linkId="<?php echo $link['proyectos_links_id']; ?>" class="text-success"><?php echo $link['title']; ?></a>
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
					if ($this->kindPage == 'voluntariado')
					{
						?>
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Contenido primera columna</b></label>
						<div class="col-sm-10">
							<textarea rows="12" cols="" class="form-control has-editor" placeholder="Contenido primera columna" id="firstColumnContent"><?php echo $section['second_column_content']; ?></textarea>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'campanas' || $this->kindPage == 'voluntariado')
					{
						?>
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Contenido segunda columna</b></label>
						<div class="col-sm-10">
							<textarea rows="12" cols="" class="form-control has-editor" placeholder="Contenido segunda columna" id="secondColumnContent"><?php echo $section['second_column_content']; ?></textarea>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios' || $this->kindPage == 'campanas' || $this->kindPage == 'voluntariado')
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
					if ($this->kindPage == 'campanas!')
					{
						?>
					<!-- Textarea input-->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Contenido Otros</b></label>
						<div class="col-sm-10">
							<textarea rows="4" cols="" class="form-control has-editor" placeholder="Contenido de Otros" id="otrosContent"><?php echo $section['otros_content']; ?></textarea>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'espacios' || $this->kindPage == 'campanas')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>URL del Video</b></label>
						<div class="col-sm-10">
							<input type="text" placeholder="URL del Video" class="form-control" id="singleVideo" value="<?php echo 'https://www.youtube.com/watch?v='.$section['video']; ?>">
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'noticias')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>Causas</b></label>
						<div class="col-sm-10" id="causasSelector">
							<div class="col-sm-3">
								<input type="checkbox" class="causas-selector-item" <?php if($section['conservacion'] == 1){echo "checked";} ?> causaname="conservacion"> 
								<label>Conservación</label>
							</div>
							<div class="col-sm-3">
								<input type="checkbox" class="causas-selector-item" <?php if($section['bienestar'] == 1){echo "checked";} ?> causaname="bienestar"> 
								<label>Bienestar comunitario</label>
							</div>
							<div class="col-sm-3">
								<input type="checkbox" class="causas-selector-item" <?php if($section['educacion'] == 1){echo "checked";} ?> causaname="educacion"> 
								<label>Educación ambiental</label>
							</div>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'actividades')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>¿Admiten voluntarios?</b></label>
						<div class="col-sm-10" id="voluntariadoSelector">
							<div class="col-sm-2">
								<input type="radio" name="actRadios" class="voluntariado-selector-item" <?php if($section['voluntariado'] == 1){echo "checked";} ?> selectorOption="si"> 
								<label>SI</label>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="actRadios" class="voluntariado-selector-item" <?php if($section['voluntariado'] == 0){echo "checked";} ?> selectorOption="no"> 
								<label>NO</label>
							</div>
						</div>
					</div>
						<?php
					}
					?>
					
					<?php 
					if ($this->kindPage == 'campanas')
					{
						?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><b>¿Promocionar?</b></label>
						<div class="col-sm-10" id="voluntariadoSelector">
							<div class="col-sm-2">
								<input type="radio" name="actRadios" class="voluntariado-selector-item" <?php if($section['promoted'] == 1){echo "checked";} ?> selectorOption="si"> 
								<label>SI</label>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="actRadios" class="voluntariado-selector-item" <?php if($section['promoted'] == 0){echo "checked";} ?> selectorOption="no"> 
								<label>NO</label>
							</div>
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
		if ($this->kindPage == 'contenidos')
		{
			?>
   			<div class="row">
				<div class="col-sm-12">
					<form class="form-horizontal" role="form">
						<fieldset>
							<label class="col-sm-2 control-label" for="textinput"><b>URL del Contenido</b></label>
							<div class="col-sm-8">
								<label class="control-label" for="textinput"><i><?php echo $this->data['appInfo']['front'];?>contenidos/<?php echo $_GET['sectionId'];?>/<?php echo Tools::slugify($section['title']);?>/</i></label>
							</div>
						</fieldset>
					</form>
				</div>
		</div>
		<?php 
		}
		?>
   		
   		<?php 
		if ($this->kindPage == 'noticias' || $this->kindPage == 'proyectos' || $this->kindPage == 'actividades' || $this->kindPage == 'campanas' || $this->kindPage == 'materiales' || $this->kindPage == 'embajadores' || $this->kindPage == 'contenidos' || $this->kindPage == 'productos')
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
		if ($this->kindPage == 'noticias' || $this->kindPage == 'proyectos' || $this->kindPage == 'actividades' || $this->kindPage == 'campanas' || $this->kindPage == 'materiales' || $this->kindPage == 'embajadores' || $this->kindPage == 'contenidos' || $this->kindPage == 'productos')
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
		if ($this->kindPage == 'proyectos' || $this->kindPage == 'campanas' || $this->kindPage == 'espacios')
		{
			?>
   		<div class="row gallery-box">
   			<h4 class="subheader">Aliados</h4>
   			<div class="row">
				<div class="col-sm-12" id="aliadosBoxItems">
					<?php 
					if ($this->data['aliados'])
					{
						foreach ($this->data['aliados'] as $aliado)
						{
							?>
					<div class="col-xs-2 aliados-choose" id="itemPicture-<?php echo $aliado['picture_id']; ?>">
						<div class="image">
							<img alt="" width="100" src="/images-system/medium/<?php echo $aliado['aliado']; ?>">
						</div>
						<div class="col-sm-12">
							<input type="checkbox" aliadoId="<?php echo $aliado['aliado_id']; ?>"  class="aliado-item" <?php if($aliado['checked'] == 1){echo "checked";} ?>> 
							<label>Patrocinador</label>
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
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="pull-right">
						<button type="submit" class="btn btn-primary" id="updateAliados">Guardar</button>
					</div>
				</div>
			</div>
   		</div>
   			<?php
		}
		?>
		
		<?php 
		if ($this->kindPage == 'causas')
		{
			?>
   		<div class="row gallery-box">
   			<h4 class="subheader">Proyectos</h4>
   			<div class="row">
				<div class="col-sm-12" id="contenidosBoxItems">
					<?php 
					if ($this->data['proyectos'])
					{
						foreach ($this->data['proyectos'] as $proyecto)
						{
							?>
					<div class="col-xs-3 aliados-choose">
						<div class="col-sm-12">
							<input type="checkbox" aliadoId="<?php echo $proyecto['proyectos_id']; ?>"  class="aliado-item" <?php if($proyecto['checked'] == 1){echo "checked";} ?>> 
							<label><?php echo $proyecto['title']; ?></label>
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
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="pull-right">
						<button type="submit" class="btn btn-primary" id="updateProyectos">Guardar</button>
					</div>
				</div>
			</div>
   		</div>
   			<?php
		}
		?>
		
		<?php 
		if ($this->kindPage == 'espacios')
		{
			?>
   		<div class="row gallery-box">
   			<h4 class="subheader">Contenidos destacados</h4>
   			<div class="row">
				<div class="col-sm-12" id="contenidosBoxItems">
					<?php 
					if ($this->data['contenidos'])
					{
						foreach ($this->data['contenidos'] as $contenido)
						{
							?>
					<div class="col-xs-3 aliados-choose">
						<div class="col-sm-12">
							<input type="checkbox" aliadoId="<?php echo $contenido['materiales_id']; ?>"  class="aliado-item" <?php if($contenido['checked'] == 1){echo "checked";} ?>> 
							<label><?php echo $contenido['title']; ?></label>
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
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="pull-right">
						<button type="submit" class="btn btn-primary" id="updateProyectos">Guardar</button>
					</div>
				</div>
			</div>
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