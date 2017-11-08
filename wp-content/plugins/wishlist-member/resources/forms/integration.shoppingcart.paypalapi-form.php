<!-- PayPal -->
<style type="text/css">
	.col-edit { 
		display: none;
	}
	.config-modify, .config-box, .config-complete {
		display: none;
	}

	.config-modify {
		float: right;
		font-size: 14px;
	}

	.config-complete {
		color: #008800;
		padding-left:.5em;
	}
</style>
<script>
	jQuery(function($) {
		var config_good = true;
		jQuery('.config-required').each(function(i, o){
			if(!jQuery(o).val().trim()) {
				config_good = false;
			}
		});

		if(config_good) {
			jQuery('.config-box').hide();
			jQuery('.config-complete').show();
			jQuery('.config-modify').show();
			jQuery('#setup-products').show();
		} else {
			jQuery('.config-box').show();
			jQuery('.config-complete').hide();
			jQuery('.config-modify').hide();
			jQuery('#setup-products').hide();
		}

		jQuery('.config-modify a').click(function() {
			if(jQuery('.config-box').is(':visible')) {
				jQuery('#settings-chevron').addClass('icon-chevron-right').removeClass('icon-chevron-down');
				jQuery('.config-box').hide('slow');
				jQuery('.config-complete').show();
				jQuery('.config-box form')[0].reset();
			} else {
				jQuery('#settings-chevron').addClass('icon-chevron-down').removeClass('icon-chevron-right');
				jQuery('.config-box').show('slow');
				jQuery('.config-complete').hide();
			}
		});

		jQuery('select.new-product-level').change(function() {
			jQuery('button.new-product').prop('disabled', this.selectedIndex == 0);
		});

	});
</script>

<h2 class="wlm-integration-steps config-title">
	<div class="config-modify">
		<i class="icon-gear"></i>
		<a href="#">
			<?php _e('Modify Settings','wishlist-member'); ?>
			<i id="settings-chevron" class="icon-chevron-right"></i>
		</a>
	</div>
	<?php _e('PayPal Settings:', 'wishlist-member'); ?>
	<span class="config-complete">
		<i class="icon-ok"></i>
		<?php _e('OK','wishlist-member'); ?>
	</span>
</h2>
<div class="config-box">
	<form method="post" id="stripe_form">
		<!-- <p><?php _e('Locate your API Credentials in the Profile > My Selling Tools > API Access > View API Signature section of PayPal','wishlist-member'); ?></p> -->
		<h2 class="wlm-integration-steps" style="border:none"><?php _e('Live API Credentials:','wishlist-member'); ?></h2>
		<p><a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_get-api-signature&generic-flow=true" target="paypal-api-get-signature" onclick="window.open(this.href, 'paypal-api-get-signature', 'height=500,width=360')"><?php _e('Click here to get your live PayPal API credentials','wishlist-member'); ?></a></p>
		<table class="form-table">
			<tr>
				<th><?php _e('API Username','wishlist-member'); ?></th>
				<td><input class="config-required" type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[live][api_username]" value="<?php echo ${$paypal_api_settings_variable_name}['live']['api_username'] ?>"><br/></td>
			</tr>
			<tr>
				<th><?php _e('API Password','wishlist-member'); ?></th>
				<td><input class="config-required" type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[live][api_password]" value="<?php echo ${$paypal_api_settings_variable_name}['live']['api_password']  ?>"><br/></td>
			</tr>
			<tr>
				<th><?php _e('API Signature','wishlist-member'); ?></th>
				<td><input class="config-required" type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[live][api_signature]" value="<?php echo ${$paypal_api_settings_variable_name}['live']['api_signature']  ?>"><br/></td>
			</tr>
		</table>
		<h2></h2>
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e('PayPal Sandbox Testing', 'wishlist-member'); ?></th>
				<td>
					<label>
						<input type="checkbox" name="<?php echo $paypal_api_settings_variable_name; ?>[sandbox_mode]" value="1" <?php $this->Checked(${$paypal_api_settings_variable_name}['sandbox_mode'], 1); ?> class="sandbox_mode">
						<?php _e('Enable PayPal Sandbox','wishlist-member'); ?>
					</label>
					<p><em><?php printf(__('The optional <a href="%1$s" target="_blank">PayPal Sandbox</a> can be enabled in order to test the PayPal integration. ', 'wishlist-member'), 'http://www.sandbox.paypal.com/'); ?></em></p>
				</td>
			</tr>
			<tr class="sandbox-mode">
				<th><?php _e('Sandbox API Username', 'wishlist-member'); ?></th>
				<td><input type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[sandbox][api_username]" value="<?php echo ${$paypal_api_settings_variable_name}['sandbox']['api_username'] ?>"><br/></td>
			</tr>
			<tr class="sandbox-mode">
				<th><?php _e('Sandbox API Password', 'wishlist-member'); ?></th>
				<td><input type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[sandbox][api_password]" value="<?php echo ${$paypal_api_settings_variable_name}['sandbox']['api_password']  ?>"><br/></td>
			</tr>
			<tr class="sandbox-mode">
				<th><?php _e('Sandbox API Signature', 'wishlist-member'); ?></th>
				<td><input type="text" style="width:100%; max-width: 450px" name="<?php echo $paypal_api_settings_variable_name; ?>[sandbox][api_signature]" value="<?php echo ${$paypal_api_settings_variable_name}['sandbox']['api_signature']  ?>"><br/></td>
			</tr>
		</table>
		<p><input type="submit" class="button-primary" value="<?php _e('Save Settings', 'wishlist-member'); ?>" /></p>
	</form>
</div>
