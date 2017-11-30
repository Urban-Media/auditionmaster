<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

 $course = llms_get_post( $post->ID );
 $instructors = $course->get_course()->get_instructors( true );
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

    <div class="entry-meta">

  		<span class="lms_lesson_author nimbus_sans">
        <?php
        if (!$instructors) {
          echo "Anonymous";
        } else {
          $instructorArray = array();
          foreach($instructors as $instructor) {
             $instructorArray[] = get_the_author_meta('display_name', $instructor['id']);
          }
        }

        echo _n('Author: ', 'Authors: ', count($instructorArray));
        echo implode(', ', $instructorArray);
        ?>
      </span>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

    <!-- Lesson Tabs -->

    <div id="tab-container" class="tab-container">
      <ul class='etabs'>
        <li class='tab nimbus_sans'>
    			<a href="#tabs1-overview">
    				Overview
    			</a>
    		</li>
        <li class='tab nimbus_sans'>
    			<a href="#tabs1-resources">
    				Resources
    			</a>
    		</li>
        <li class='tab nimbus_sans'>
    			<a href="#tabs1-usefullinks">
    				Useful Links
    			</a>
    		</li>
      </ul>

      <div id="tabs1-overview">
    		<!-- Overview tab content -->

        <h2>HTML Markup for these tabs</h2>
        CONTENT

    		<!-- End overview tab content -->
      </div>

      <div id="tabs1-resources">
    		<!-- Resources tab content -->

    		<?php
        if (have_rows('resources')) {
          echo "<ul class='lesson_resource_list'>";
          while (have_rows('resources')) { the_row();
            $resource = get_sub_field('resource');
            //var_dump($resource);

            // Get icon by mime type
            $mimetype = explode('/', $resource['mime_type']);
            switch ($mimetype[0]) {
              case "video":
                $iconType = "video";
              break;

              case "image":
                $iconType = "image";
              break;

              case "text":
              case "application":
                // e.g .txt, .pdf, .docx
                $iconType = "document";
              break;

              default:
                $iconType = "document";
              break;
            }

            $fileIcon = get_template_directory_uri().'/img/file_icons/' . $iconType .'.png';

            $fileName = (get_sub_field('display_name')) ? get_sub_field('display_name') : $resource['title'];
            ?>
            <a href="<?php echo $resource['url']; ?>">
              <li class="lesson_resource box_hover">
              <?php
              echo "<img src='" . $fileIcon ."' class='lesson_resource_icon'>";
              echo $fileName;
              ?>
              </li>
            </a>
            <?php
          }
          echo "</ul>";
        }
        ?>

    		<!-- End resources tab content -->
      </div>

      <div id="tabs1-usefullinks">
    		<!-- Useful links tab content -->


    		<!-- End useful links tab content -->
      </div>
    </div>

    <!-- Lesson Tabs -->

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
