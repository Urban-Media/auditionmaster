<div class="rmlms-promo-wrap rmagic">
    <div  class="rmcontent">
        <div class="rmheader">LeadMagic</div>  
<?php if(!$data->is_lm_activated): ?>
    <div class="rmrow rmlms-banner"><img src="<?php echo RM_EX_LMS()->base_url; ?>images/lm_sshot.jpg"/></div>

<div class="rmrow rmlms-prag"><strong>LeadMagic</strong> solves two problems that 
    many of our users face - Firstly,
    an ability to quickly create a working 
    splash page/ landing page on their site
    with a permalink and embedded form without 
    worrying about the technicalities. Secondly, 
    displaying registration form in a consistent design environment 
    where it fits in overall scheme of the page presenting a pleasant experience to the visitor.</div>

<div class="rmrow rmlms-action-call">Ready to <strong>extend</strong> power of your forms?</div>
    <?php if(!$data->is_lm_installed): ?>
    <div class="rmlms-button-wrap rmrow"><a class="button" href="<?php echo $data->lm_install_url; ?>" target="_self">Install Now</a></div>
    <?php else:?>
    <div class="rmlms-button-wrap rmrow"><a class="button" href="<?php echo $data->lm_activate_url; ?>" target="_self">Activate Now</a></div>
    <?php endif; ?>
<?php else: ?>
    <div class="rmrow">
    LeadMagic is already installed. <a href="<?php echo $data->lm_page_url; ?>">Click here</a> to create/manage landing pages.
</div>

<?php endif; ?>

    </div>
    </div>
