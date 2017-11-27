<?php
/**
 * LifterLMS Loop Author Info
 *
 * @since   3.0.0
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } // End if().

?>
<div class="col-6">
<?php
echo llms_get_author( array(
	'avatar_size' => 28,
) );
?>
</div>
