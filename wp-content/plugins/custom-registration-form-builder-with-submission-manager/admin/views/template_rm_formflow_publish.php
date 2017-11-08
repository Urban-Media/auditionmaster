<?php
$settings = new RM_Options;

?>

<link rel="stylesheet" type="text/css" href="<?php echo RM_BASE_URL . 'admin/css/'; ?>style_rm_formflow.css">
<script type="text/javascript" src="<?php echo RM_BASE_URL . 'admin/js/'; ?>script_rm_formflow.js"></script>

    <div  class="rm-grid rm-dbfl">

        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_shortcode"> 
            <div class="rm-section-publish-note"> Publish inside a page or a post </div>
            <div class="rm-publish-text">The most common method. Copy this shortcode and paste it inside a page or post where you want to display the form.</div>
                        
            <div class="rm-section-shortcode">
                <span id="rmformshortcode" data-publish_code="[RM_Form id='%fid%']"><?php echo "[RM_Form id='{$form_id_to_publish}']"; ?></span>            
                <div class="rm-click-to-copy-button" onclick="rm_copy_content(document.getElementById('rmformshortcode'), this)">Copy</div>
            </div>
        </div>
        
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_widget">
            <div class="rm-section-publish-note">
                <span id="rmformshortcode">Publish inside a Page Builder or Widget area</span>
                
            </div>
            <div class="rm-publish-text">Find RegistrationMagic Form widget in your <b>Appearance/Widgets</b> section. Drag it to the widget area where you wish to display the form. Select the form to display in Widget settings and save.</div>
            <div class="rm-section-youtube-video"><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . "images/rm-widget.gif"; ?>"></div>
        
        </div> 
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_embed">  

            <div class="rm-section-publish-note"> Publish using embed code </div>
                  
        
                    <span id="rmformembedcode" class="rm-premium-feature"><?php echo RM_UI_Strings::get("MSG_BUY_PRO_INLINE"); ?></span>
               
        

        </div> 
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_userdir">

            <div class="rm-section-publish-note"> Publish a Directory of users who submitted this form</div>
            <div class="rm-publish-text">Displays a directory of all the users who have submitted this form. Only users with WordPress account will be displayed.</div>

            <div class="rm-directory-container rm-dbfl">
                <div class="rm-publish-directory-col rm-difl"><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . "images/rm-user-directory.png"; ?>"></div>
                <div class="rm-publish-directory-col rm-difl">  
                    <div class="rm-section-shortcode"> 
                        <span id="rmformuserdircode" data-publish_code="[RM_Users form_id='%fid%']"><?php echo "[RM_Users form_id='{$form_id_to_publish}']"; ?></span>
                        <div class="rm-premium-feature"><?php echo RM_UI_Strings::get("MSG_BUY_PRO_INLINE"); ?></div>                       
                    </div>                    
                </div>
            </div>
        </div>  
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_subs">
            <div class="rm-directory-container rm-dbfl">

                <div class="rm-publish-directory-col rm-difl">  
                    <div class="rm-section-publish-note">Create a user area on your site</div>
                    <div class="rm-publish-text">This shortcode renders a comprehensive user specific area on your site.</div>
                    <div class="rm-section-shortcode"> 
                        <span id="rmsubmissionscode"><?php echo "[RM_Front_Submissions]"; ?></span>
                        <div class="rm-click-to-copy-button" onclick="rm_copy_content(document.getElementById('rmsubmissionscode'), this)">Copy</div>
                    </div>
                </div>
                <div class="rm-publish-directory-col rm-difl"><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . "images/rm-submissions.gif"; ?>"></div>
                


            </div>
        </div>
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_magicpopup">
            <div class="rm-directory-container rm-dbfl">
                <div class="rm-publish-directory-col rm-difl"><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . "images/rm-popup.gif"; ?>"></div>
                <div class="rm-publish-directory-col rm-difl">  
                    <div class="rm-section-publish-note">Display the form in a sliding popup</div>
                    <div class="rm-publish-text">Click the star to activate the form in Magic Popup. To remove the form, select another form.</div>
                    <div class="rm-section-shortcode rm-formflow-embedcode"> 
                        <span id="rmdefformstar">
                            <i class="material-icons rm_not_def_form_star rm_form_star" onclick="rm_formflow_set_def_form(this)" id="rm-star_<?php echo $form_id_to_publish; ?>" data-def_form_id="<?php echo $data->def_form_id;?>">&#xe838</i>
                                <span>
                                    Click above star to set this form as default registration form. The default registration form appears in the Magic Popup on front-end.
                                </span> 
                        </span>                        
                    </div>

                </div>
                <?php if($settings->get_value_of('display_floating_action_btn') !== 'yes'): ?>
                <div class="rm-magic-popup-notice rm-dbfl"> Magic pop-up is currently disabled. Please go to <a href="?page=rm_options_fab" target="_blank">Global Settings >> Magic Popup Button</a> to enable it. </div>
                      <?php endif; ?>
            </div>
        </div>
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_landingpage">
            <?php do_action("rm_formflow_publish_page", $form_id_to_publish); ?>
        </div>
        
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_otp">
            <div class="rm-directory-container dbfl">OTP (One-time password) system is built into RegistrationMagic. It allows issuing temporary one-time usable passwords to users who do not have user accounts on your site. OTP system works seamlessly with RegistrationMagic Login Widget in <a href="<?php echo admin_url("widgets.php");?>" target="_blank">Appearance --> Widgets</a> and Login link in Magic PopUp Menu, which can be turned on by going to <a href="?page=rm_options_fab" target="_blank"> Global Settings --> Magic Popup Button</a>.<br/><br/>

<b>Here's how it works -</b> When user enters email in the login box, RegistrationMagic checks if the users has an account on the site. If an account is found, user is asked to enter password in the next step. If an account is not found, RegistrationMagic generates a temporary one-time password and emails it to the user. User is prompted to check his/ her email. By using that password, the user can log into a restricted area of the site and check form submissions from the email ID used to login.
        </div>
        </div>
        
        <div class="rm-grid-section rm-dbfl rm_publish_section" id="rm_publish_login">
            <div class="rm-section-publish-note"> Publish a login form </div>
            <div class="rm-publish-text">Login system is built into RegistrationMagic. To display a login box on any page, post or widget use this code.</div>
                        
            <div class="rm-section-shortcode">
                <span id="rmloginformshortcode"><?php echo "[RM_Login]"; ?></span>            
                <div class="rm-click-to-copy-button" onclick="rm_copy_content(document.getElementById('rmloginformshortcode'), this)">Copy</div>
            </div>
        </div>

    </div>
