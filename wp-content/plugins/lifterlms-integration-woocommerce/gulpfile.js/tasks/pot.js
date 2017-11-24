/**
 * -----------------------------------------------------------
 * pot
 * -----------------------------------------------------------
 *
 * Generate a new .pot file
 *
 */

var   gulp  = require( 'gulp' )
	, sort  = require( 'gulp-sort' )
	, wpPot = require( 'gulp-wp-pot' )
;

gulp.task( 'pot', function() {

	gulp.src( [ '*.php', './includes/**/*.php' ] )

		.pipe( sort() )

		.pipe( wpPot( {
			domain: 'lifterlms-woocommerce',
			package: 'lifterlms-integration-woocommerce',
			bugReport: 'https://lifterlms.com/my-account/my-tickets',
			lastTranslator: 'Thomas Patrick Levy <thomas@lifterlms.com>',
			team: 'LifterLMS <help@lifterlms.com>',
		} ) )

		.pipe( gulp.dest( 'i18n/lifterlms-woocommerce.pot' ) )

} );
