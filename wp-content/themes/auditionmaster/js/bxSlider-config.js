jQuery(document).ready(function($) {
  var templateUrl = local_vars.template_directory_uri;

  $('#header_slider').bxSlider({
    pager: false,
    nextText: '<img id="arrow_right" src="' + templateUrl + '/img/arrow_right.png">',
    prevText: '<img id="arrow_left" src="' + templateUrl + '/img/arrow_left.png">',
    touchEnabled: false
    //nextSelector: '#arrow_right',
    //prevSelector: '#arrow_left'
  });
});
