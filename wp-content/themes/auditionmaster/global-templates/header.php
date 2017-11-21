<!-- This may or may not be a slider depending on the page. All pages should however have at least one header -->
<?php
global $post;
/*
 * The header slide is slightly larger (660px vs 400px) on the homepage
 * only, which has a post ID of 9
 */
$isOnHomepageClass = ($post->ID == 9) ? 'homepage_slide' : 'header_slide';

/*
 * Archive pages like the Woocommerce shop don't work like regular pages
 * so we have to use an alternate method to get the right data for them
 */
if ( is_post_type_archive( 'product' ) ) {
  $post = get_post(119);
  setup_postdata($post);
}
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
                   <a href="<?php the_sub_field('right_button_link'); ?>">
                     <button class="header_slider_button header_slider_button_transparent locationAware locationAwareHover">
                       <?php the_sub_field('right_button_text'); ?>
                       <span></span>
                     </button>
                   </a>
                 </div>
               </div>
             </div>
           </div>
         </div>
   <?php
      }
   }
   ?>
   <div class="header_slide header_slider_background">
     This is another slide <?php if (is_home()) { echo "This is the home page"; } else { echo "This is NOT the home page but it is page ID: ".$post->ID; } ?>
   </div>
 </div>
