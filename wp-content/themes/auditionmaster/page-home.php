<?php
/**
 * Template Name: Home Page
 *
 */
 global $post;
 get_header();
?>

<?php get_template_part( 'global-templates/header' ); ?>

<!-- Block 1 -->
<div class="container block">
  <div class="row">
    <div class="col-md-6 col-12">
      <h2 class="block_1_title nimbus_sans_bold">
        <?php the_field('block_1_title'); ?>
      </h2>
      <ul class="features_list">
        <?php
        if(have_rows('feature_list')) {
          while(have_rows('feature_list')) { the_row();
            $listIcon = get_sub_field('feature_icon');
        ?>
          <li class="feature feature_list_icon" style="background-image: url('<?php echo $listIcon['url']; ?>');">
            <div class="feature_list_content">
              <h3 class="feature_list_title nimbus_sans_bold">
                <?php the_sub_field('feature_title'); ?> <?php if(get_sub_field('premium_feature') == true) echo "<span class='premium'>*</span>"; ?>
              </h3>
              <?php the_sub_field('feature_content'); ?>
            </div>
          </li>
        <?php
          }
        }
        ?>
      </ul>
      <div class="feature_list_footer">
        And much more...
        <br />
        <span class="premium">
          * These are premium features. <a href="#">View our premium plans.</a>
        </span>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <?php echo do_shortcode('[RM_Form id="3"]'); ?>
    </div>
  </div>
</div>
<!-- End Block 1 -->

<!-- Block 2 -->
<?php
$block2BackgroundImage = get_field('block_2_background');
?>
<div class="container-fluid nopadding ">
  <div class="row">
    <div class="col-12 block_2" style="background-image: url('<?php echo $block2BackgroundImage['url']; ?>');">

      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3 class="frontpage_title white_text text-center nimbus_sans_bold">
              <?php the_field('block_2_title'); ?>
            </h3>
            <div class="text-center white_text block_2_content">
              <?php the_field('block_2_content'); ?>
            </div>
            <div class="block_2_video text-center">
              <video controls plays-inline class="frontpage_video">
                <source src="<?php the_field('block_2_video'); ?>" type="video/mp4">
              </video>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- End Block 2 -->

<!-- Block 3 -->
<?php
$leftImage = get_field('block_3_image');
?>
<div class="container-fluid nopadding block block_3">
  <div class="row">
    <div class="col-12">

      <div class="container">
        <div class="row">
          <div class="col-md-6 col-12">
            <img src="<?php echo $leftImage['url']; ?>">
          </div>
          <div class="col-md-6 col-12">
            <h3 class="frontpage_title block_3_title nimbus_sans_bold">
              <?php the_field('block_3_title'); ?>
            </h3>
            <?php the_field('block_3_content'); ?>

            <div class="block_slider_buttons">
              <a href="<?php the_field('block_3_left_button_link'); ?>">
                <button class="block_slider_button header_slider_button_colour block_slider_button_hover locationAware locationAwareHoverPurple">
                  <?php the_field('block_3_left_button_text'); ?>
                  <span></span>
                </button>
              </a>
              <a href="<?php the_field('block_3_right_button_link'); ?>">
                <button class="block_slider_button block_slider_button_transparent locationAware locationAwareHover">
                  <?php the_field('block_3_right_button_text'); ?>
                  <span></span>
                </button>
              </a>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- End Block 3 -->

<!-- Block 4 -->
<?php
$rightImage = get_field('block_4_image');
?>
<div class="container block">
  <div class="row">
    <div class="col-md-6 col-12">
      <h3 class="frontpage_title block_3_title nimbus_sans_bold">
        <?php the_field('block_4_title'); ?>
      </h3>
      <?php the_field('block_4_content'); ?>

      <?php
      if (have_rows('block_4_features')) { ?>
        <ul class="block_4_points">
          <?php while(have_rows('block_4_features')) { the_row(); ?>
            <li>
              <?php the_sub_field('block_4_feature'); ?>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>

      <div class="block_4_button_container">
        <a href="<?php the_field('block_4_button_link'); ?>">
          <button class="block_slider_button header_slider_button_colour" style="margin-left: 0px;">
            <?php the_field('block_4_button_text'); ?>
          </button>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <img class="binoculars" src="<?php echo $rightImage['url']; ?>">
    </div>
  </div>
</div>

<!-- End Block 4 -->

<?php get_footer(); ?>
