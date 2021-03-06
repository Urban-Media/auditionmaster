<?php
/**
 * The template for displaying all woocommerce pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

?>

<?php get_template_part( 'global-templates/header' ); ?>
<div id="whiteMenuTrigger"></div>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php //get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>
			<div class="col-md-9">

				<?php
					$template_name = '/archive-product.php';
					$args = array();
					$template_path = '';
					$default_path = untrailingslashit( plugin_dir_path(__FILE__) ) . '/woocommerce';

						if ( is_singular( 'product' ) ) {

							woocommerce_content();

				//For ANY product archive, Product taxonomy, product search or /shop landing page etc Fetch the template override;
					} 	elseif ( file_exists( $default_path . $template_name ) )
						{
						wc_get_template( $template_name, $args, $template_path, $default_path );

				//If no archive-product.php template exists, default to catchall;
					}	else  {
						woocommerce_content( );
					}

				;?>

			</div><!-- #col-md-8 -->

	<?php get_sidebar( 'shop' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

<?php get_footer(); ?>
