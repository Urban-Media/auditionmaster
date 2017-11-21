<!-- This may or may not be a slider depending on the page. All pages should however have at least one header -->
<?php
global $post;
?>
<div id="header_slider" class="slider">
   <?php
   if(have_rows('slides')) {
      while (have_rows('slides')) { the_row();
        $slideBackgroundImage = get_sub_field('background_image');
   ?>
         <div class="header_slide header_slider_background" style="display: flex; background-image: url('<?php echo $slideBackgroundImage['url']; ?>');">
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
     This is another slide <?php if (is_home()) { echo "This is the home page"; } else { echo "This is NOT the home page"; } ?>
   </div>
 </div>
