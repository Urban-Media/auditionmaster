<?php
$rdrto = "rm_form_manage";
?>


<div class="rm-formcard-menu" id="fcm_<?php echo $entry->form_id; ?>" data-formid="<?php echo $entry->form_id; ?>" style="visibility:hidden;">
    <span class="rm-formcard-menu-nub"></span>
    <div class="rm-formcard-menu-header"> 
        <span class="rm-formcard-menu-form-name rm_formname_display_span" title="Click to edit form name">
            <?php echo htmlentities(stripslashes($entry->form_name)); ?>
        </span>
        <span class="rm-formcard-menu-form-name-save-loader" style="display:none">
            <i class="material-icons">&#xE86A;</i>
        </span>
        <span class="rm-formcard-menu-form-name-save-icon" style="display:none">
            <i class="material-icons">&#xE86C;</i>
        </span>
        <input class="rm_formname_edit_input" 
            value="<?php echo htmlentities(stripslashes($entry->form_name)); ?>"
            style="display:none;"
        />
        <span class="rm-formcard-menu-close"><i class="material-icons">&#xE5CD;</i></span>
    </div>   


    <div class="rm-formcard-tabmenu-wrap rm-dbfl">
        <div class="rm-formcard-tabhead-container rm-difl">
            <div class="rm_formcard_tabhead-title">Form</div>
            <ul>
                <li class="rm_formcard_tabhead rm_active_tabhead" data-tabpanel="#rm_fcm_panel_build"><a href="javascript:void(0)"><i class="material-icons">&#xE869;</i>Build </a></li>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_config"><a href="javascript:void(0)"><i class="material-icons">&#xE429;</i>Configure</a></li>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_integrate"><a href="javascript:void(0)"><i class="material-icons">&#xE8C0;</i>Integrate</a></li>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_publish"><a href="javascript:void(0)"><i class="material-icons">&#xE255;</i>Publish</a></li>
            </ul>
            <div class="rm_formcard_tabhead-title">Submissions</div>
            <ul>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_manage"><a href="javascript:void(0)"><i class="material-icons">&#xE8F9;</i>Manage</a></li>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_analyze"><a href="javascript:void(0)"><i class="material-icons">&#xE6C4;</i>Analyze</a></li>
                <li class="rm_formcard_tabhead" data-tabpanel="#rm_fcm_panel_automate"><a href="javascript:void(0)"><i class="material-icons">&#xE923;</i>Automate</a></li>
            </ul>

        </div>

        <div class="rm-formcard-tabpanel-container rm-difl"> 
            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_build">
                
                <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                <div class="rm-formcard-tab-item">  
                    <a href="?page=rm_field_manage&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-custom-fields.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('FD_LABEL_FORM_FIELDS'); ?></div>
                    </a>
                </div>

                <div class="rm-formcard-tab-item">  
                    <a href="?page=rm_form_sett_view&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-view.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('FD_LABEL_DESIGN'); ?></div>
                    </a>
                </div>


                    <div class="rm-formcard-tabpanel-info">Build your form just as you would like it to appear to your site visitors. Add and set up custom fields, labels, buttons, form pages, colors, backgrounds and more. </div>
                </div>
            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_config">
                 <div class="rm-formcard-tabpanel-wrap rm-dbfl">

                <div class="rm-formcard-tab-item">
                    <a href="?page=rm_form_sett_general&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-settings.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_GEN_SETT'); ?></div>
                    </a>
                </div>

                <div class="rm-formcard-tab-item" id="rm-accounts-icon">
                    <a href="?page=rm_form_sett_accounts&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-accounts.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_ACC_SETT'); ?></div>

                    </a>
                </div> 

                <div class="rm-formcard-tab-item" id="rm-postsubmit-icon">
                    <a href="?page=rm_form_sett_post_sub&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>post-submission.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_PST_SUB_SETT'); ?></div>
                    </a>
                </div>

                <div class="rm-formcard-tab-item" id="rm-autoresponder-icon">
                    <a href="?page=rm_form_sett_autoresponder&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>auto-responder.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_AUTO_RESP_SETT'); ?></div>
                    </a>
                </div>       

                <div class="rm-formcard-tab-item" id="rm-limits-icon">
                    <a href="?page=rm_form_sett_limits&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-limits.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_LIM_SETT'); ?></div>
                    </a>
                </div>
                     
                <!--
                <div class="rm-formcard-tab-item" id="rm-access-icon"> 
                    <a href="?page=rm_form_sett_access_control&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-access.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_ACTRL_SETT'); ?></div>
                    </a>
                </div>
                -->
                <div class="rm-formcard-tab-item" id="rm-emtemplates-icon">
                    <a href="?page=rm_form_sett_email_templates&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>email_templates.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_EMAIL_TEMPLATES_SETT'); ?></div>
                    </a>
                </div>
                
                  <div class="rm-formcard-tabpanel-info">Every form configuration option under the sky! Tweak behavior of your forms to match your registration process.  
                    </div> 
                
                <!--
                <div class="rm-formcard-tab-item" id="rm-overrides-icon">
                    <a href="?page=rm_form_sett_override&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link"> 
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-overrides.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_OVERRIDES_SETT'); ?></div>
                    </a>
                </div> 
                -->
                 </div>

            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_integrate">
                
                 <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                <div class="rm-formcard-tab-item">  
                    <a href="?page=rm_form_sett_mailchimp&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">  
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>mailchimp.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_F_MC_SETT'); ?></div>
                    </a>
                </div> 
                
                <!--
                <div class="rm-formcard-tab-item"> 
                    <a href="?page=rm_form_sett_aweber&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>logo-aweber.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_AWEBER_OPTION'); ?></div>
                    </a>
                </div> 

                <div class="rm-formcard-tab-item">  
                    <a href="?page=rm_form_sett_ccontact&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>" class="rm_fd_link">  
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>constant-contact.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('NAME_CONSTANT_CONTACT'); ?></div>
                    </a>
                </div>  
                -->

                <?php do_action('rm_extended_apps_formcard_menu', $entry->form_id, $rdrto); ?>
                
                <div class="rm-formcard-tabpanel-info">Give your form extra chops by connecting it to powerful third party apps, greatly expanding scope of what you can do with your forms.
 
                 </div>                     
        
                 </div>
            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_publish">
                 <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                     <div class="rm-formcard-tab-items" >

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="shortcode" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_shortcode.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_SHORTCODE'); ?></div>
                             </a>

                         </div> 


                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="embed" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_embed.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_HTML_CODE'); ?></div>
                             </a>

                         </div> 

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="widget" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_widget.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_FORM_WIDGET'); ?></div>
                             </a>

                         </div>

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="userdir" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_userdir.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_USER_DIRECTORY'); ?></div>
                             </a>

                         </div>

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="subs" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_subs.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_USER_AREA'); ?></div>
                             </a>

                         </div>

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="magicpopup" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_magicpopup.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_MAGIC_POPUP'); ?></div>
                             </a>

                         </div>
                         
                         <div class="rm-formcard-tab-item">
                             <a href="?page=rm_form_sett_manage&rm_form_id=<?php echo $entry->form_id; ?>&rdrto=<?php echo $rdrto; ?>#rm-publish-section" class="rm_fdlink_more">   
                                 More
                             </a>

                         </div>
                             <div class="rm-formcard-tabpanel-info">RegistrationMagic offers you multiple ways to publish your forms and associated data. Choose what suits you best.
                             </div>
                         <!--
                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="landingpage" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_landingpage.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_LANDING_PAGE'); ?></div>
                             </a>

                         </div>

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="login" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_login.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_LOGIN_BOX'); ?></div>
                             </a>

                         </div>

                         <div class="rm-formcard-tab-item">
                             <a href="javascript:void(0)" class="rm_fd_link rm_publish_popup_link" data-publish_type="otp" data-form_id="<?php echo $entry->form_id; ?>">   
                                 <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>publish_otp.png">
                                 <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_PUBLISH_OTP_WIDGET'); ?></div>
                             </a>

                         </div>
                         -->




                     </div>
                     
                 </div>
            
            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_manage">
                <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                <div class="rm-formcard-tab-item">
                    <a href="?page=rm_submission_manage&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-inbox.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_REGISTRATIONS'); ?></div>
                    </a>
                </div> 
                    
                <div class="rm-formcard-tab-item">
                    <a href="?page=rm_sent_emails_manage&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link"> 
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>outbox.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('LABEL_OUTBOX'); ?></div>

                    </a>
                </div>
                    
                <!--
                <div class="rm-formcard-tab-item">
                    <a href="?page=rm_attachment_manage&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link"> 
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-attachments.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('TITLE_ATTACHMENT_PAGE'); ?></div>

                    </a>
                </div>
                -->  
                     <div class="rm-formcard-tabpanel-info">Manage form data collected from users. Advance filters and searches make it both easy and fun to manage large number of submissions.</div>  
                 </div>
            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_analyze">
                <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                <div class="rm-formcard-tab-item" id="rm-analytics-icon">
                    <a href="?page=rm_analytics_show_form&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>form-analytics.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('TITLE_FORM_STAT_PAGE'); ?></div>
                    </a>
                </div> 
                <!--
                <div class="rm-formcard-tab-item" id="rm-field-analytics-icon">
                    <a href="?page=rm_analytics_show_field&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link">   
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>field-analytics.png">
                        <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('TITLE_FIELD_STAT_PAGE'); ?></div>

                    </a>
                </div>
                -->  
                    <div class="rm-formcard-tabpanel-info">Analyze the form data using automatically generated metrics and charts. Find meaningful insights essential to fine tuning your form's conversion rate.
</div>
                                   
                </div>
            </div>

            <div class="rm-formcard-tabpanel" id="rm_fcm_panel_automate">
                 <div class="rm-formcard-tabpanel-wrap rm-dbfl">
                <div class="rm-formcard-tab-item" id="rm-emailusers-icon">
                    <a href="?page=rm_invitations_manage&rm_form_id=<?php echo $entry->form_id; ?>" class="rm_fd_link">    
                        <img class="rm-formcard-icon" src="<?php echo RM_IMG_URL; ?>email-users.png">
                       <div class="rm-formcard-label"><?php echo RM_UI_Strings::get('TITLE_INVITES'); ?></div>
                    </a>
                </div> 
                <?php do_action("rm_formcard_menu_action_icon", $entry->form_id, $rdrto); ?>
                     <div class="rm-formcard-tabpanel-info">It works for you, even when you are not working! Create automated tasks and emails which run in the background executing predefined actions.​
</div>
                     
                 </div>
            </div>
        </div>
    </div>



</div>
