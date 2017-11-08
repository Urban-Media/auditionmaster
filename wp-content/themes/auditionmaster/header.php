<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<!-- Typekit -->
	<script src="https://use.typekit.net/spu7gip.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>

<body <?php body_class('nimbus_sans body_text'); ?>>

<div class="hfeed site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<!--<div class="wrapper-fluid wrapper-navbar fixed_menu" id="wrapper-navbar">-->

		<!--<nav class="navbar navbar-expand-md navbar-dark">-->

			<div class="container-fluid nopadding fixed_menu">

				<div class="container">

				<div class="row">

					<div class="col-2">

						<div class="navbar-brand">
							<img class="logo" src="<?php echo get_template_directory_uri(); ?>/img/logo.png">
						</div>

					</div>

					<div class="col-3"></div>

					<div class="col-7">

						<!-- The WordPress Menu goes here -->
						<!--<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
					   <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
					     <span class="navbar-toggler-icon"></span>
					   </button>-->
							<?php /*wp_nav_menu(
								array(
									'theme_location'  => 'header-menu',
									'container_class' => 'collapse navbar-collapse',
									'container'				=> 'div',
									'container_id'    => 'bs4navbar',
									'menu_class'      => 'header_menu source_sans_pro text-right navbar-nav mr-auto',
									'fallback_cb'     => 'bs4navwalker::fallback',
									'menu_id'         => 'header-menu',
									'walker'          => new bs4Navwalker(),
								)
							);*/ ?>
							<?php wp_nav_menu(
								array(
									'theme_location'  => 'header-menu',
									//'container_class' => 'collapse navbar-collapse',
									'container_id'    => 'bs4navbar',
									'menu_class'      => 'header_menu source_sans text-right',
									'fallback_cb'     => '',
									'menu_id'         => 'header-menu',
									//'walker'          => new WP_Bootstrap_Navwalker(),
								)
							); ?>
						<!--</nav>-->
						<!-- End Wordpress Menu -->

						</div>

				</div>

			</div><!-- .container -->
		</div>

		<!--</nav>--><!-- .site-navigation -->

	<!--</div>--><!-- .wrapper-navbar end -->
