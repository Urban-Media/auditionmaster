<?php
/*
 * ConvertKit Autoresponder API
 * Original Author : Fel Jun Palawan
 * Version: $Id: integration.autoresponder.convertkit.php 3141 2016-10-27 16:34:22Z feljun $
 */

	$__index__ = 'convertkit';
	$__ar_options__[$__index__] = 'ConvertKit';
	$__ar_videotutorial__[$__index__] = wlm_video_tutorial ( 'integration', 'ar', $__index__ );
?>
<?php if ($data['ARProvider'] == $__index__): ?>
<?php if ($__INTERFACE__): ?>
<?php
	//make sure WLM_AUTORESPONDER_CONVERTKIT_INIT class is loaded
	// integration inits does not load when you just switch from one integration to another
	if ( !class_exists('WLM_AUTORESPONDER_CONVERTKIT_INIT') ) {
		require_once($this->pluginDir . '/lib/integration.autoresponder.convertkit.init.php');
	}
?>
<?php include_once( $this->pluginDir . '/extlib/convertkit/convertkit-admin.php' ); ?>
<?php include_once( $this->pluginDir . '/admin/tooltips/integration.autoresponder.convertkit.tooltips.php' ); ?>
<?php endif; ?>
<?php endif; ?>
