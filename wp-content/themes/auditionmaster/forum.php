<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

 global $post;
 get_header();
?>

<?php get_template_part( 'global-templates/header' ); ?>
<div id="whiteMenuTrigger"></div>

<div class="container block">
  <div class="row">
    <div class="col-md-12 col-12">

  		<?php while ( have_posts() ) : the_post(); ?>

  			<?php get_template_part( 'loop-templates/content', 'page' ); ?>

  		<?php endwhile; // end of the loop. ?>

  		<!-- Do the right sidebar check -->
  		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

  			<?php get_sidebar( 'right' ); ?>

  		<?php endif; ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>
