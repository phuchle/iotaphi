<?php
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>
<!DOCTYPE html>
<head>
<!-- <meta charset="<?php bloginfo( 'charset' ); ?>" /> -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Alpha Phi Omega | Iota Phi</title>
<link rel="stylesheet" type="text/css" media="all" href="/style/bootstrap2.2.2.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script src="/script/bootstrap.min.js"></script>
<script src="/js/mobile_menu.js"></script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<!-- <script type="text/javascript">
	if (screen.width <= 699) {
		document.location = "/mobile";
	}
</script> -->

<?php if ( !is_user_logged_in() ){ ?>
	    <style>
            #wpadminbar{ display:none; }
	    html { margin-top: 28px !important}
            </style>
		<?php } ?>
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body>
	<header>
	<!-- Modified 02/15/2014
		Added this to give the sectionals page special viewing privileges
	-->
	<?php if(is_page('sectionals')){
			echo '<div id="header" class="container navbar-fixed-top">'
	    .'<div id="crest">'  						
			.'<a class="home-button" href="http://www.iotaphi.org/sectionals"><img src="/images/crest.png" alt="Alpha Phi Omega Crest" />'
			.'<h2>UC Davis Chapter</h2></a>'
			.'</div>'
	    	.'<div id="access" role="navigation" >';
	      }
	      else{
	      	echo '<div id="header" class="container navbar-fixed-top">'	
	    .'<div id="crest">'  				
			.'<a class="home-button" href="http://www.iotaphi.org">'
				.'<h1>ΑΦΩ - ΙΦ</h1>'
			// . '<img src="/images/crest.png" alt="Alpha Phi Omega Crest" />'
			.'</a>'
			// .'<p class="small">UC Davis Chapter</p>'
			.'</div>'
			// .'<div class="nav-links">'
			.'<div id="access" role="navigation">';
	      }
	?>
						
	<?php
	/* adding the menu swap here */
	if($_SESSION['class'] == 'admin') { 
		 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Excomm' , 'theme_location' => 'primary', 'container_id' => 'cssmenu', 'walker' => new CSS_Menu_Walker() ) );
	}
	elseif(isset($_SESSION['id'])) {
	 // if they are logged in
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Logged_In' , 'theme_location' => 'primary', 'container_id' => 'cssmenu', 'walker' => new CSS_Menu_Walker() ) );
	} 
	///// Added 02/15/2014
	elseif(is_page('sectionals')){ //check the current page you are viewing and see if it is the one specified
	 //if they are viewing the sectionals page
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Sectionals' , 'theme_location' => 'primary', 'container_id' => 'cssmenu', 'walker' => new CSS_Menu_Walker() ) );
	}
	/////
	else {
	 // they are not logged in
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'container_id' => 'cssmenu', 'walker' => new CSS_Menu_Walker() ) );
	}
	
	?>
	</div>
	<div class="login-button">

		<?php 						
				if(isset($_SESSION['id'])):
				include_once 'user.inc.php'; 
		?>
				 <a class="btn btn-small btn-danger" href="/input.php?action=logout&amp;redirect=index.php">Logout</a>
			    <?php elseif(is_page('sectionals')): ?>
			    <?php else: ?>		
		<a href="#myModal" role="button" class="btn btn-small" data-toggle="modal">Login</a>
			<?php endif; ?>
	</div> <!-- login_button -->
	</div>	<!-- container -->

<?php if ( !isset($_SESSION['id']) ) { ?>
	<?php if (is_front_page()) { ?>
		<div class="cover-image">
			<div class="homepage-overlay">
				<div class="content lead">

					<p class="lead"><strong>ALPHA PHI OMEGA @ UC DAVIS</strong></p>
					<hr class="home-page-hr">
					<p class="lead"><strong>LEADERSHIP, FRIENDSHIP, SERVICE</strong></p>
				</div> <!-- content lead -->
			</div> <!-- homepage-overlay -->
				<div class="learn-more">				
					<a id="about-us-links" class="lead ps2id" href="/#about-us">
						<strong>
							Learn More
							<p>&#8675</p>
						</strong>
					</a>
				</div>
		</div> <!-- cover-image -->
	<?php } ?>
<!-- adds nav bg-color when scrolling past cover -->
<script src="/js/nav-coloring.js"></script>
	
<link rel="stylesheet" type="text/css" href="/style/public_homepage.css">
<?php	
} 
else {
?>

<link rel="stylesheet" type="text/css" href="/style/logged_in.css">

<?php } ?>
</header>

		</header>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <h3 id="myModalLabel">Alpha Phi Omega | Iota Phi - Log In</h3>
  </div>
  <div class="modal-body">
    <p>	    	
    	<form class="form-inline" method="post" action="/input.php">
    		<input name="action" type="hidden" value="login" />
    		<input name="redirect" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
    		<input type="text" name="username"  class="input-small" placeholder="Your Name"  onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" />
    		<input type="password" name="password" class="input-small" placeholder="Password" onclick="this.select();" />
    		<button type="submit" name="submit" value="Log In"  class="btn"/>Sign In</button>
    	</form>
    	</p>
  </div>
</div>
<div id="container" class="container" >