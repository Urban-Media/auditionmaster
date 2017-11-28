<?php
/**
 * The Lifter Course Catalogue sidebar intended for use on the course catalogue
 *
 * @package understrap
 */

if ( ! is_active_sidebar( 'lifter_course_catalogue' ) ) {
	return;
}

?>

<div class="col-md-4 widget-area" id="course-catalogue-sidebar" >
	<?php dynamic_sidebar( 'lifter_course_catalogue' ); ?>
</div><!-- #secondary -->
