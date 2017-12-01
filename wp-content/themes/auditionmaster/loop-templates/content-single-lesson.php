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

        <ul class="lesson_resource_list">
          <li class="lesson_resource">
            <div class="row">
              <div class="col-1">
                Lesson:
              </div>
              <div class="col-11">
                <?php the_title(); ?>
              </div>
            </div>
          </li>
          <li class="lesson_resource">
            <div class="row">
              <div class="col-1">
                <?php echo _n('Author: ', 'Authors: ', count($instructorArray)); ?>
              </div>
              <div class="col-11">
                <?php echo implode(', ', $instructorArray); ?>
              </div>
            </div>
          </li>
          <li class="lesson_resource">
            <div class="row">
              <div class="col-1">
                Course:
              </div>
              <div class="col-11">
                <?php

                ?>
              </div>
            </div>
          </li>
        </ul>

    		<!-- End overview tab content -->
      </div>

      <div id="tabs1-resources">
    		<!-- Resources tab content -->
        <ul class='lesson_resource_list'>
      		<?php
          if (have_rows('resources')) {
            while (have_rows('resources')) { the_row();
              $resource = get_sub_field('resource');

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
                  <div class="row">
                    <div class="col-1">
                      <?php
                      echo "<img src='" . $fileIcon ."' class='lesson_resource_icon'>";
                      ?>
                    </div>
                    <div class="col-11">
                      <?php
                      echo $fileName;

                      if (strlen(get_sub_field('description')) > 0) {
                        ?>
                        <div class="lesson_resource_description">
                          <?php the_sub_field('description') ?>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </li>
              </a>
              <?php
            }
          } else {
            ?>
            <li class="lesson_resource">
              <div class="row">
                <div class="col-12">
                  There are no resources associated with this lesson.
                </div>
              </div>
            </li>
            <?php
          }
          ?>
        </ul>

    		<!-- End resources tab content -->
      </div>

      <div id="tabs1-usefullinks">
    		<!-- Useful links tab content -->
        <ul class='lesson_resource_list'>
          <?php
          if (have_rows('useful_links')) {

            while (have_rows('useful_links')) { the_row();
              $link = array(
                  'location'      => get_sub_field('link_location'),
                  'link_internal' => get_sub_field('link_internal'),
                  'link_external' => get_sub_field('link_external'),
                  'display_name'  => get_sub_field('display_name'),
                  'description'   => get_sub_field('description')
              );

              $link['url'] = (!empty($link['link_internal']) && !!$link['link_internal']) ? $link['link_internal'] : $link['link_external'];
              ?>
              <a href="<?php echo prepend_hypertext($link['url']); ?>">
                <li class="lesson_resource box_hover lesson_links">
                  <div class="row">
                    <div class="col-12">
                      <?php
                      echo (strlen($link['display_name']) > 0) ? $link['display_name'] : $link['url'];
                      ?>

                      <?php
                      if (strlen($link['description']) > 0) {
                        ?>
                        <span class="lesson_resource_description">
                          <?php echo $link['description']; ?>
                        </span>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </li>
              </a>
              <?php
            }
          } else {
            ?>
            <li class="lesson_resource">
              <div class="row">
                <div class="col-12">
                  There are no links associated with this lesson.
                </div>
              </div>
            </li>
            <?php
          }
          ?>
        </ul>
    		<!-- End useful links tab content -->
      </div>
    </div>

    <!-- Lesson Tabs -->

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
