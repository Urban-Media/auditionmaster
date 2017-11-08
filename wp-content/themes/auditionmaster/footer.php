<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_sidebar( 'footerfull' ); ?>

<div class="container-fluid nopadding footer">

	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="footer_title nimbus_sans_bold">
					Company
				</div>
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'company-menu',
						'container_class' => 'footer_menu',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav nimbus_sans',
						'fallback_cb'     => '',
						'menu_id'         => 'company-menu',
						//'walker'          => new WP_Bootstrap_Navwalker(,
					)
				); ?>
			</div>
			<div class="col-md-3">
				<div class="footer_title nimbus_sans_bold">
					Membership
				</div>
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'membership-menu',
						'container_class' => 'footer_menu',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav nimbus_sans',
						'fallback_cb'     => '',
						'menu_id'         => 'membership-menu',
						//'walker'          => new WP_Bootstrap_Navwalker(,
					)
				); ?>
			</div>
			<div class="col-md-3">
				<div class="footer_title nimbus_sans_bold">
					Useful Links
				</div>
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'useful-links-menu',
						'container_class' => 'footer_menu',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav nimbus_sans',
						'fallback_cb'     => '',
						'menu_id'         => 'useful-links-menu',
						//'walker'          => new WP_Bootstrap_Navwalker(,
					)
				); ?>
			</div>
			<div class="col-md-3">
				<!-- Social Media Stuff -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'social-links-menu',
						'container_class' => 'footer_menu',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'social_links',
						'fallback_cb'     => '',
						'menu_id'         => 'useful-links-menu',
						'walker'          => new Social_Links_Navwalker()
					)
				); ?>
			</div>
		</div>

		<div class="row footer_bottom">
			<div class="col-md-3 footer_bottom_text nimbus_sans">
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'legal-links-menu',
						'container_class' => 'footer_menu',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'footer_bottom_text',
						'fallback_cb'     => '',
						'menu_id'         => 'legal-links-menu',
						//'walker'          => new Social_Links_Navwalker()
					)
				); ?>
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-3 footer_bottom_text nimbus_sans">
				Website Design: Urban Media
			</div>
		</div>

	</div>

</div>

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>
