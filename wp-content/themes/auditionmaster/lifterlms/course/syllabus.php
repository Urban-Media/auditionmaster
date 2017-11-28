<?php
/**
 * Template for the Course Syllabus Displayed on individual course pages
 *
 * @author 		LifterLMS
 * @package 	LifterLMS/Templates
 * @since       1.0.0
 * @version     3.0.0 - refactored for sanity's sake
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;

$course = new LLMS_Course( $post );

// retrieve sections to use in the template
$sections = $course->get_sections( 'posts' );
?>

<div class="clear"></div>

<!-- TEST TABS -->

<div id="tab-container" class="tab-container">
  <ul class='etabs'>
    <li class='tab nimbus_sans'>
			<a href="#tabs1-overview">
				Overview
			</a>
		</li>
    <li class='tab'>
			<a href="#tabs1-modules">
				Modules
			</a>
		</li>
    <li class='tab'>
			<a href="#tabs1-css">
				Example CSS
			</a>
		</li>
  </ul>
  <div id="tabs1-overview">
    <h2>HTML Markup for these tabs</h2>
    CONTENT
  </div>
  <div id="tabs1-modules">
    <h2>JS for these tabs</h2>
    MO CONTENT
  </div>
  <div id="tabs1-css">
    <h2>CSS Styles for these tabs</h2>
    EVEN MO CONTENT
  </div>
</div>

<!-- END TEST TABS -->

<div class="llms-syllabus-wrapper">

	<?php if ( ! $sections ) : ?>

		<?php _e( 'This course does not have any sections.', 'lifterlms' ); ?>

	<?php else : ?>

		<?php foreach ( $sections as $s ) :
			$section = new LLMS_Section( $s->ID ); ?>

			<?php if ( apply_filters( 'llms_display_outline_section_titles', true ) ) : ?>
				<h3 class="llms-h3 llms-section-title"><?php echo get_the_title( $s->ID ); ?></h3>
			<?php endif; ?>

			<?php $lessons = $section->get_children_lessons();
			if ( $lessons ) : ?>

				<?php foreach ( $lessons as $l ) : ?>

					<?php llms_get_template( 'course/lesson-preview.php', array(
						'lesson' => new LLMS_Lesson( $l->ID ),
						'total_lessons' => count( $lessons ),
					) ); ?>

				<?php endforeach; ?>

			<?php else : ?>

				<?php _e( 'This section does not have any lessons.', 'lifterlms' ); ?>

			<?php endif; ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<div class="clear"></div>
</div>
