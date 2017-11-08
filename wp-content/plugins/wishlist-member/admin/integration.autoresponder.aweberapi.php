<?php
/*
 * AWeber Autoresponder Interface
 * Original Author : Mike Lopez
 * Version: $Id: integration.autoresponder.aweberapi.php 3179 2017-01-31 13:42:11Z mike $
 */

$__index__ = 'aweberapi';
$__ar_options__[$__index__] = 'AWeber API';
$__ar_affiliates__[$__index__] = 'http://wlplink.com/go/aweber';
$__ar_videotutorial__[$__index__] = wlm_video_tutorial ( 'integration', 'ar', $__index__ );

if ($data['ARProvider'] == $__index__):
	if ($__INTERFACE__):
		$connected = false;
		$lists = array();

		//make sure WLM_AUTORESPONDER_AWEBERAPI_INIT class is loaded
		//integration inits does not load when you just switch from one integration to another
		if ( !class_exists('WLM_AUTORESPONDER_AWEBERAPI_INIT') ) {
			require_once($this->pluginDir . '/lib/integration.autoresponder.aweberapi.init.php');
		}

		if(!empty($_GET['authorization_code'])) {
			$x = $_GET['authorization_code'];
			if($x != $data['aweberapi']['auth_key']) {
				$data['aweberapi']['auth_key'] = $x;
				$x = add_query_arg('auth_key_saved', '1', remove_query_arg( 'authorization_code' ));
				$this->SaveOption('Autoresponders', $data);
				echo <<<SCRIPT
<script>
	document.location = '{$x}';
</script>
SCRIPT;
				exit;
			}
		}

		/** Load the integration */
	    if ( class_exists('WLM_AUTORESPONDER_AWEBERAPI_INIT') ) {

			$integration = new WLM_AUTORESPONDER_AWEBERAPI_INIT;
			$integration->set_wlm( $this );
			$integration->set_auth_key( $data['aweberapi']['auth_key'] );
			$curl_exists = function_exists('curl_init');
			$access_tokens = array("","");

			// If curl is disabled, don't run Aweber API connection and return error msg
			if ( $curl_exists ) {
				// Try Connecting and if there's an error, catch it so that the page doesn't go blank
				try {

					$access_tokens = $integration->get_access_tokens();
					if ( !empty( $access_tokens ) ) $connected = true;

					// !connected but we have an auth key
					// let's try to connect one last time
					if ( !$connected && !empty( $data['aweberapi']['auth_key'] ) ) {
						$access_tokens = $integration->renew_access_tokens();
						if ( !empty( $access_tokens ) ) {
							//save the new access tokens
							$data['aweberapi']['access_tokens'] = $access_tokens;
							$this->SaveOption('Autoresponders', $data);
							$connected = true;
						} else {
							$access_tokens = array("","");
							$_POST['err_msg'] = '<strong>Unable to connect to your Aweber account.</strong> <br> Please check and make sure that the Authorization Key is correct.';
						}
					}

					if ( $connected ) {
						$lists = $integration->get_lists();
						// reformat
						$list_tmp = array();
						foreach ($lists as $item) {
							$list_tmp[$item['id']] = $item;
						}
						$lists = $list_tmp;
					}
				} catch (Exception $e) {
					$err_msg = $e->getMessage();
					$_POST['err_msg'] = $err_msg;
				}
			} else {
				$_POST['err_msg'] = '<strong>Aweber API integration needs the CURL enabled for it to work</strong>. <br> Please contact your host and have them enable it on your server  to continue integrating with AWeber API.';
			}
	    }

		if (wlm_arrval($_POST, 'err_msg')) echo '<div class="error fade below-h2"><p>'.$_POST['err_msg'].'</p></div>';
		if ($connected && wlm_arrval($_GET, 'auth_key_saved')) echo '<div class="updated fade below-h2"><p>'.__('WishList Member successfully connected to AWeber.','wishlist-member').'</p><p>'.__('If you need to connect any other WishList Member sites to your AWeber account you must use the existing AWeber API Authorization Key that is listed below.','wishlist-member').'</p></div>';
		?>
		<style>
			td input.disabled {
				background-color: #eee;
			}
		</style>
		<form method="post" action="<?php echo remove_query_arg('auth_key_saved'); ?>">
			<input type="hidden" name="saveAR" value="saveAR" />
			<input type="hidden" name="ar[auth_key]" value="<?php echo $data['aweberapi']['auth_key'] ?>" />
			<input class="access_tokens" type="hidden" name="ar[access_tokens][0]" value="<?php echo $data['aweberapi']['access_tokens'][0] ?>"/>
			<input class="access_tokens" type="hidden" name="ar[access_tokens][1]" value="<?php echo $data['aweberapi']['access_tokens'][1] ?>"/>

			<?php if ( !$connected ): ?>
				<h2 class="wlm-integration-steps"><?php _e('Connect WishList Member to AWeber:','wishlist-member'); ?></h2>
				<?php _e('Do you have any other WishList Member sites currently connected to your AWeber account?','wishlist-member'); ?>
				<?php echo $this->Tooltip("integration-autoresponder-aweberapi-tooltips-connect"); ?>

				<div id="existing_key_toggle">
					<blockquote>
						<label><input type="radio" name="existing_key" value="yes"> <?php _e('Yes','wishlist-member'); ?></label><br>
						<label><input type="radio" name="existing_key" value="no"> <?php _e('No','wishlist-member'); ?></label><br>
					</blockquote>
					<div style="display: none;" id="existing_key_no" class="existing_key_choice">
							<p class="description"><?php _e("Use the link below to access a page that will prompt you to enter your AWeber login information and then click Allow Access.",'wishlist-member') ?></p>
							<p><a class="button button-primary" href="<?php echo $integration->get_authkey_url() ?>?oauth_callback=<?php echo urlencode(admin_url('admin.php?' . remove_query_arg( array('authorization_code','auth_key_saved'), $_SERVER['QUERY_STRING'] ))); ?>"><?php _e("Connect WishList Member to AWeber") ?></a></p>
							<p style="font-style:italic"><?php _e('* Please note this will create a new connection between WishList Member and the AWeber API. If you have any other WishList Member sites connected to AWeber, they will be disconnected. The same API key must be used across any connections.','wishlist-member'); ?></p>
					</div>
					<div style="display: none;" id="existing_key_yes" class="existing_key_choice">
							<p class="description"><?php _e("Paste your existing AWeber API Authorization Key below and click 'Connect to AWeber'.",'wishlist-member') ?></p>
							<p class="description"><?php _e('The existing AWeber API Authorization Key can be obtained from any WishList Member site that is already connected to AWeber. You must be running WishList Member 2.91.3174 or higher in order to copy the key from that site. Please note all WishList Member sites that connect to the AWeber API must use the same AWeber API Authorization Key.','wishlist-member'); ?> <a href="<?php echo $wlm_ar_vidlink; ?>" target="_blank" style="text-decoration:none"><span class="dashicons dashicons-video-alt3"></span></a></p>
 							<p>
								<textarea style="width: 530px; height: 100px;" name="ar[auth_key]" _data="<?php echo $integration->get_auth_key(); ?>" onkeyup="clear_access_tokens(this)"><?php echo $integration->get_auth_key(); ?></textarea>
							</p>
							<p class="submit">
								<input type="submit" class="button-primary" value="<?php _e('Connect to AWeber', 'wishlist-member'); ?>" />
							</p>
					</div>
				</div>

				<p>&nbsp;</p>
			<?php endif; ?>

			<?php if ( $connected ): ?>
				<h2 class="wlm-integration-steps">Map your Membership Levels to your Lists</h2>
				<p>Map your membership levels to your email lists by selecting a list from the dropdowns provided under the "List" column.</p>
				<table class="widefat">
					<thead>
						<tr>
							<th width="20%">Membership Level</th>
							<th width="20%">List</th>
							<th width="20%">Ad Tracking</th>
							<th width="20%">Actions if Removed/Cancelled from Level</th>
							<th width="20%">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ((array) $wpm_levels AS $levelid => $level): ?>
							<?php
								$show_edit_tag = false;
								$tag_settings = array(
									"added" => "Added",
									"cancelled" => "Cancelled",
									"removed" => "Removed",
								);
							?>
							<tr class="<?php echo ++$autoresponder_row % 2 ? 'alternate' : ''; ?>">
								<th scope="row"><?php echo $level['name']; ?></th>
								<td>
									<select class="aweber_lists" name="ar[connections][<?php echo $levelid ?>]">
										<option value="">Select a list</option>
										<?php foreach ($lists as $l): ?>
											<?php
												if ( $data['aweberapi']['connections'][$levelid] == $l['id'] ) {
													$selected = 'selected="selected"';
													$show_edit_tag = !$show_edit_tag ? true : false;
												} else {
													$selected = null;
												}
											?>
											<option <?php echo $selected ?> value="<?php echo $l['id'] ?>"><?php echo $l['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<input maxlength="20" type="text" name="ar[ad_tracking][<?php echo $levelid ?>]" value="<?php echo substr( $data['aweberapi']["ad_tracking"][$levelid], 0, 20); ?>" />
								</td>
								<td>
									<?php
										$autounsub = $data['aweberapi']['autounsub'][$levelid];
										$autounsub = $autounsub ? $autounsub : '';
									?>
									<select class="aweber_unsub" name="ar[autounsub][<?php echo $levelid ?>]">
										<option value="">- Select an Action -</option>
										<option value="nothing" <?php echo $autounsub == "nothing" ? 'selected="selected"' : '';  ?> >Do Nothing (Contact will remain on Selected List)</option>
										<option value="unsubscribe" <?php echo $autounsub == "unsubscribe" || $autounsub == "yes" ? 'selected="selected"' : '';  ?>>Unsubscribe Contact from Selected List</option>
										<option value="delete" <?php echo $autounsub == "delete" ? 'selected="selected"' : '';  ?> >Delete Contact from Selected List</option>s
									</select>
								</td>
								<td>
									<?php
										$bold = "";
										if ( isset( $data['aweberapi']['level_tag'][$levelid] ) ) {
											foreach ( $tag_settings as $key => $title) {
												if ( isset( $data['aweberapi']['level_tag'][$levelid][$key]['apply'] ) ) {
													$bold = !empty($data['aweberapi']['level_tag'][$levelid][$key]['apply']) ? 'font-weight:bold;' : '';
												}
												if ( isset( $data['aweberapi']['level_tag'][$levelid][$key]['apply'] ) ) {
													$bold = !empty($data['aweberapi']['level_tag'][$levelid][$key]['apply']) ? 'font-weight:bold;' : '';
												}
												if ( !empty( $bold ) ) break;
											}
										}
									?>
									<a style="float: right;<?php echo $bold ?>" class="aweber_edit_tag awshow <?php echo $show_edit_tag ? '' : 'hidden'; ?>" href="javascript:void(0);">[+] Edit Tag Settings</a>
								</td>
							</tr>
							<tr class="<?php echo $autoresponder_row % 2 ? 'alternate' : ''; ?> hidden" id="wpm_level_row_<?php echo $levelid ?>">
								<td colspan="5">
									<table style="width: 100%">
										<tbody>
											<tr>
											<?php foreach ($tag_settings as $key => $title) : ?>
												<?php
													$cls = ""; $disabled = "";
													if ( $key != "added" && $data['aweberapi']['autounsub'][$levelid] == 'delete' ) {
														$cls = "disabled";
														$disabled = "disabled='disabled'";
													}
												?>
												<td class="<?php echo $key; ?>_tags">
													<p><b>When <?php echo $title; ?>:</b></p>
													<p>
														Apply Tags:<br />
														<input class="<?php echo $cls; ?>" style="width: 95%;" type="text" name="ar[level_tag][<?php echo $levelid ?>][<?php echo $key; ?>][apply]" value="<?php echo strtolower( $data['aweberapi']["level_tag"][$levelid][$key]['apply'] ); ?>"  <?php echo $disabled; ?> placeholder="tag name 1, tag name 2, tag name 3 ..."/>
													</p>
													<p>
														Remove Tags:<br />
														<input class="<?php echo $cls; ?>" style="width: 95%;" type="text" name="ar[level_tag][<?php echo $levelid ?>][<?php echo $key; ?>][remove]" value="<?php echo strtolower( $data['aweberapi']["level_tag"][$levelid][$key]['remove'] ); ?>" <?php echo $disabled; ?> placeholder="tag name 1, tag name 2, tag name 3 ..."/>
													</p>
												</td>
											<?php endforeach; ?>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'wishlist-member'); ?>" />
				</p>
			<?php else: ?>
				<div class="error fade" id="message">
					<p><?php _e('WishList Member has not yet been connected to an AWeber account. Follow the instructions below to connect WishList Member with an AWeber account.', 'wishlist-member') ?></p>
				</div>
			<?php endif; ?>
		</form>
		<hr>
		<?php if ( $connected ): ?>
			<strong><?php _e('Your AWeber API Authorization Key:', 'wishlist-member'); ?></strong>
			<p><span class="description"><?php _e('Use this same key if you wish to connect your other WishList Member sites to AWeber.', 'wishlist-member'); ?></span></p>

			<textarea onclick="this.focus();this.select()" onfocus="this.select()" style="width: 530px; height: 100px;" readonly="readonly"><?php printf('%s|%s', preg_replace('/\|$/', '', $integration->get_auth_key()), implode('|', $access_tokens)); ?></textarea>

			<form method="post" action="<?php echo remove_query_arg('auth_key_saved'); ?>">
				<input type="hidden" name="saveAR" value="saveAR" />
				<input type="hidden" name="ar[auth_key]" value="" />
				<p>
					<span class="description"><?php _e("Disconnect WishList Member from your AWeber account by clicking the button below. All your AWeber API settings will be reset.") ?></span>
				</p>
				<input onclick="return confirm('All your AWeber API settings will be reset.\nClick OK to continue.')" type="submit" class="button-secondary" value="<?php _e('Disconnect from my AWeber Account', 'wishlist-member'); ?>" />
				<p>&nbsp;</p>
			</form>
		<?php endif; ?>
		<script>
			function clear_access_tokens(fld) {
				fld = jQuery(fld);
				if(fld.val() != fld.attr('_data')) {
					jQuery('.access_tokens').val('');
				}
			}

			jQuery(document).ready(function() {
				jQuery('#existing_key_toggle input[name=existing_key]').click(function() {
					if(jQuery(this).prop('checked')) {
						jQuery('#existing_key_toggle .existing_key_choice').hide();
						jQuery('#existing_key_toggle #existing_key_'+jQuery(this).val()).show();
					}
				});
				jQuery('.aweber_edit_tag').click(function() {
					var next_tr = jQuery(this).parent().parent().next();
					if (jQuery(this).hasClass("awshow")) {
						next_tr.show();
						jQuery(this).removeClass("awshow");
						jQuery(this).addClass("awhide");
						jQuery(this).html("[-] Hide Tag Settings");
					} else {
						next_tr.hide();
						jQuery(this).removeClass("awhide");
						jQuery(this).addClass("awshow");
						jQuery(this).html("[+] Edit Tag Settings");
					}
				});

				jQuery('.aweber_lists').change(function() {
					var next_tr = jQuery(this).parent().parent().next();
					var next_td = jQuery(this).parent().next().next().next();
					if ( jQuery(this).val() != "" ) {
						next_td.find(".aweber_edit_tag").show();
						if ( next_td.find(".aweber_edit_tag").hasClass("awhide") ) {
							next_td.find(".aweber_edit_tag").addClass("awhide");
							next_td.find(".aweber_edit_tag").removeClass("awshow");
							next_td.find(".aweber_edit_tag").html("[-] Hide Tag Settings");
						} else {
							next_td.find(".aweber_edit_tag").trigger('click');
						}
					} else {
						next_tr.hide();
						next_td.find(".aweber_edit_tag").hide();
						next_td.find(".aweber_edit_tag").removeClass("awhide");
						next_td.find(".aweber_edit_tag").addClass("awshow");
						next_td.find(".aweber_edit_tag").html("[+] Edit Tag Settings");
					}
				});

				jQuery('.aweber_unsub').change(function() {
					var next_tr = jQuery(this).parent().parent().next();
					if ( jQuery(this).val() == 'delete' ) {
						next_tr.find(".cancelled_tags").find("input").prop("disabled",true);
						next_tr.find(".cancelled_tags").find("input").addClass("disabled");
						next_tr.find(".removed_tags").find("input").prop("disabled",true);
						next_tr.find(".removed_tags").find("input").addClass("disabled");
					} else {
						next_tr.find(".cancelled_tags").find("input").prop("disabled",false);
						next_tr.find(".cancelled_tags").find("input").removeClass("disabled");
						next_tr.find(".removed_tags").find("input").prop("disabled",false);
						next_tr.find(".removed_tags").find("input").removeClass("disabled");
					}
				});
			});
		</script>
		<?php
	endif;
endif;

include_once($this->pluginDir . '/admin/tooltips/integration.autoresponder.aweberapi.tooltips.php');
?>