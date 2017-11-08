<?php
?>
<div class="rm-directory-container dbfl">
    <div class="rm-publish-directory-col difl">
        <div class="rm-section-publish-note">   Display this form in a landing/squeeze page </div>
        <div class="rm-publish-text">RegistrationMagic has a dedicated extension for this purpose. It will allow you to display any form inside a landing or squeeze page, with full control over other visual elements of the page. The extension is free, and you can get started within few minutes. You can create as many pages as you like with individual slugs.</div>
        <?php if(!$data->is_lm_installed): ?>
            <a href="<?php echo $data->lm_install_url; ?>">Install Now</a>
        <?php elseif(!$data->is_lm_activated): ?>
            <a href="<?php echo $data->lm_activate_url; ?>">Activate Now</a>
        <?php else: ?>
            <a href="<?php echo $data->lm_page_url; ?>">Create/Manage Landing Pages</a>
        <?php endif; ?>
    </div>
    <div class="rm-publish-directory-col difl"><img src="<?php echo RM_EX_LMS()->base_url; ?>images/rm-splash.gif"></div>
</div>
