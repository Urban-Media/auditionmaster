<h2><?php _e('Settings &raquo; Advanced', 'wishlist-member'); ?></h2>
<?php
/*
 * Advanced Settings
 */
$mergecode = '<b>' . __('Merge Codes', 'wishlist-member') . '</b><small><br /><br />';
$mergecode.='[level] : ' . __('Membership Level', 'wishlist-member') . '<br /><br />' . __('Registration Links', 'wishlist-member') . '<br />';
$mergecode.='[newlink] : ' . __('New Member', 'wishlist-member') . '<br />';
$mergecode.='[existinglink] : ' . __('Existing Member', 'wishlist-member') . '</small><br />';

$reset = false;

if (wlm_arrval($_POST, 'sidebar_widget_css_reset')) {
	$this->DeleteOption('sidebar_widget_css');
	$reset = true;
}
if (wlm_arrval($_POST, 'login_mergecode_css_reset')) {
	$this->DeleteOption('login_mergecode_css');
	$reset = true;
}
if (wlm_arrval($_POST, 'reg_form_css_reset')) {
	$this->DeleteOption('reg_form_css');
	$reset = true;
}
if (wlm_arrval($_POST, 'reg_instructions_new_reset')) {
	$this->DeleteOption('reg_instructions_new');
	$reset = true;
}
if (wlm_arrval($_POST, 'reg_instructions_new_noexisting_reset')) {
	$this->DeleteOption('reg_instructions_new_noexisting');
	$reset = true;
}
if (wlm_arrval($_POST, 'reg_instructions_existing_reset')) {
	$this->DeleteOption('reg_instructions_existing');
	$reset = true;
}
if ($reset) {
	$this->Activate();
}
?>
<form method="post">
	<h2><?php _e('CSS Code', 'wishlist-member'); ?></h2>
	<h3><?php _e('Sidebar Widget CSS', 'wishlist-member'); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"></th>
			<td>
				<textarea name="<?php $this->Option('sidebar_widget_css', true); ?>" cols="70" rows="20"><?php $this->OptionValue(); ?></textarea>
				<br />
				<label><input type="checkbox" name="sidebar_widget_css_reset" value="1" /> Reset to Default <?php echo $this->Tooltip("settings-advanced-tooltips-Reset-to-Default"); ?></label>
			</td>
		</tr>
	</table>
	<h3><?php _e('Login Form Merge Code CSS', 'wishlist-member'); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"></th>
			<td>
				<textarea name="<?php $this->Option('login_mergecode_css', true); ?>" cols="70" rows="20"><?php $this->OptionValue(); ?></textarea>
				<br />
				<label><input type="checkbox" name="login_mergecode_css_reset" value="1" /> Reset to Default <?php echo $this->Tooltip("settings-advanced-tooltips-Reset-to-Default"); ?></label>
			</td>
		</tr>
	</table>


	<p class="submit">
		<?php
		$this->Options();
		$this->RequiredOptions();
		?>
		<input type="hidden" name="WishListMemberAction" value="Save" />
		<input type="submit" class="button-primary" value="<?php _e('Save', 'wishlist-member'); ?>" />
	</p>
</form>

<h2><?php _e('WishList Member Cache folder', 'wishlist-member'); ?></h2>

<blockquote>
    <p>The path to the cache folder <?php echo $this->Tooltip("settings-advanced-tooltips-cache-folder"); ?></p> 

	<?php 
		$sys_tmp = sys_get_temp_dir();

		// Check if open_basedir has value. Some servers have open_basedir restrictions so 
		// instead of using the default server tmp folder, we use the path open_basedir allows PHP to have access to.
		$open_basedir= ini_get('open_basedir');
		if(!empty($open_basedir)) {
			$basedirs = explode(":", $open_basedir);
			$sys_tmp = $basedirs[0].'tmp';
		}
		$custom_cache_folder = $this->GetOption('custom_cache_folder') ? $this->GetOption('custom_cache_folder') : $sys_tmp;
	?>
	<span class="cache_folder_display">
		<code><span class="parent_folder_noedit"><strong><?php echo $custom_cache_folder; ?></strong></span></code>
	            &nbsp;
		<span class="parent_folder_noedit">(<a href="#" id="cache_folder_change_text" >change</a>)</span>
	</span>
    <span style="display:none;" class="cache_folder_edit">
    <form method="post" onsubmit="return wlm_confirm_change_cache_folder(this)">
        <input type="hidden" name="WishListMemberAction" value="CacheFolderUpdate">
        <div>
            <input class="cache_folder_edit" type="text" name="cacheFolder" value="<?php echo $custom_cache_folder; ?>" data-original="<?php echo $sys_tmp; ?>" size="90"> 
            <br>
            <i><small><?php _e('To use System Temp folder, just leave this as blank.', 'wishlist-member'); ?></small></i>
            <br><br>
            <span class="cache_folder_edit">
            	<input type="submit" class="button button-primary" value="Save">
                <input type="button" class="button" id="cache_folder_edit_cancel" value="Cancel">
            </span>
        </div>
    </form>
	</span>
</blockquote>
<br>
<hr>
<br><br>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#cache_folder_change_text").on( "click", function() {
			jQuery(".cache_folder_edit").show();
			jQuery(".cache_folder_display").hide();
			return false;
		});

		jQuery("#cache_folder_edit_cancel").on( "click", function() {
			jQuery(".cache_folder_edit").hide();
			jQuery(".cache_folder_display").show();
			return false;
		});
	});
</script>