<!-- This may or may not be a slider depending on the page. All pages should however have at least one header -->
<?php
global $post;

/*
 * Make a save of the current page data to reload it if we get
 * header data from a different page
 */
$samePost = true;
$currentPostCopy = $post;

/*
 * The header slide is slightly larger (660px vs 400px) on the homepage
 * only, which has a post ID of 9
 */
$isOnHomepageClass = ($post->ID == 9) ? 'homepage_slide' : 'header_slide';

/*
 * Archive pages like the Woocommerce shop don't work like regular pages
 * so we have to use an alternate method to get the right data for them
 */
if ( is_post_type_archive( 'product' ) || is_product() ) {
  $post = get_post(119);
  setup_postdata($post);
  $samePost = false;
}

// bbPress forum
if ( is_bbpress() ) {
  $post = get_post(160);
  setup_postdata($post);
  $samePost = false;
}

// LifterLMS course
if ( is_course() || is_lesson() ) {
  $post = get_post(226);
  setup_postdata($post);
  $samePost = false;
}

if (is_courses() || is_quiz() || is_membership() || is_memberships() || is_llms_account_page() || is_llms_checkout()) {
  $post = get_post(175);
  setup_postdata($post);
  $samePost = false;
}

//var_dump($currentPostCopy);
?>
<div id="header_slider" class="slider">
   <?php
   if(have_rows('slides')) {
      while (have_rows('slides')) { the_row();
        $slideBackgroundImage = get_sub_field('background_image');
   ?>
         <div class="<?php echo $isOnHomepageClass; ?> header_slider_background" style="display: flex; background-image: url('<?php echo $slideBackgroundImage['url']; ?>');">
           <div class="container-fluid">
             <div class="row">
               <div class="col-12 header_slider_slide">
                 <h1 class="header_slider_title nimbus_sans_bold white_text text-center">
                   <?php the_sub_field('title'); ?>
                 </h1>
                 <div class="header_slider_buttons">
                   <a href="<?php the_sub_field('left_button_link'); ?>">
                     <button class="header_slider_button header_slider_button_colour locationAware locationAwareHoverPurple">
                       <?php the_sub_field('left_button_text'); ?>
                       <span></span>
                     </button>
                   </a>
                   <?php
                   /*
                    * There may not always be a second button
                    */
                   if (get_sub_field('right_button_text') != '') {
                   ?>
                   <a href="<?php the_sub_field('right_button_link'); ?>">
                     <button class="header_slider_button header_slider_button_transparent locationAware locationAwareHover">
                       <?php the_sub_field('right_button_text'); ?>
                       <span></span>
                     </button>
                   </a>
                   <?php
                   }
                   ?>
                 </div>
               </div>
             </div>
           </div>
         </div>
   <?php
      }
   }
   ?>
 </div>

<?php
/*
* Reset page data to its original value if needed
*/
if (!$samePost) {
  setup_postdata($currentPostCopy);
}
?>
