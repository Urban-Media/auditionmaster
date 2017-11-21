jQuery(document).ready(function($) {
  /*
   * Social media footer icons hover
   */
  $('.social_button_footer').on('mouseover', function() {
    var platform = $(this).data('platform');
    var originalSrc = $(this).attr('src');
    // Get rid of file extension
    var extensionLessSrc = originalSrc.replace(/\.[^/.]+$/, "");
    var newSrc = extensionLessSrc + '_hover.png';
    $(this).attr('src', newSrc);
  }).on('mouseout', function() {
    var originalSrc = $(this).data('original');
    $(this).attr('src', originalSrc);
  });

  /*
   * Sticky header code
   */
   // init controller
	var controller = new ScrollMagic.Controller();

	// build scenes
	new ScrollMagic.Scene({triggerElement: "#whiteMenuTrigger", offset: 375})
					.setClassToggle("#globalMenu", "white_menu") // add class toggle
					.addIndicators() // add indicators (requires plugin)
					.addTo(controller);


  /*
   * Mobile menu
   */
 /***
  * Run this code when the #toggle-menu link has been tapped
  * or clicked
  */
 $( '#spinner-form2' ).on( 'touchstart click', function(e) {
    e.stopPropagation();

    var $body = $( 'body' ),
        $page = $( '#page' ),
        $menu = $( '#menu' ),

    /* Cross browser support for CSS "transition end" event */
    transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

    /* When the toggle menu link is clicked, animation starts */
    $body.addClass( 'animating' );

    /***
     * Determine the direction of the animation and
     * add the correct direction class depending
     * on whether the menu was already visible.
     */
    if ( $body.hasClass( 'menu-visible' ) ) {
     $body.addClass( 'right' );
    } else {
     $body.addClass( 'left' );
    }

    /***
     * When the animation (technically a CSS transition)
     * has finished, remove all animating classes and
     * either add or remove the "menu-visible" class
     * depending whether it was visible or not previously.
     */
    $page.on( transitionEnd, function() {
     $body
      .removeClass( 'animating left right' )
      .toggleClass( 'menu-visible' );

     $page.off( transitionEnd );
    });
   });
   /*
    * End mobile menu
    */
});
