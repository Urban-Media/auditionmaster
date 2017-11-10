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
	new ScrollMagic.Scene({triggerElement: "#whiteMenuTrigger"})
					.setClassToggle("#globalMenu", "white_menu") // add class toggle
					.addIndicators() // add indicators (requires plugin)
					.addTo(controller);
});
