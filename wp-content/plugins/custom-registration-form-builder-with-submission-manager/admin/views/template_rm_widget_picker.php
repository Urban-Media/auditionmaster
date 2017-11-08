<ul class="rm-widget-selector-view">
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_HTMLH"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('HTMLH')">

        <div class="rm-difl rm-widget-icon rm-widget-heading"><i class="fa fa-header" aria-hidden="true"></i></div>
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_HEADING"); ?></a>
            
        </div>
    </li>
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_HTMLP"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('HTMLP')">
        <div class="rm-difl rm-widget-icon rm-widget-paragraph"><i class="fa fa-paragraph" aria-hidden="true"></i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_PARAGRAPH"); ?></a>
        </div>
    </li>
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_Divider"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('Divider')">
        <div class="rm-difl rm-widget-icon rm-widget-divider"><i class="fa fa-arrows-h" aria-hidden="true"></i></div> 
        <div class="rm-difl rm-widget-head"> <a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_DIVIDER"); ?></a>
   
        </div>
    </li>
            
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_Spacing"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('Spacing')">
        <div class="rm-difl rm-widget-icon rm-widget-spacing"><i class="material-icons">&#xE256;</i></div> 
        <div class="rm-difl rm-widget-head"> <a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_SPACING"); ?></a>
 
        </div>
    </li>  
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_RICHTEXT"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('RichText')">
        <div class="rm-difl rm-widget-icon rm-widget-richtext"><i class="material-icons">&#xE165;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_RICHTEXT"); ?></a>
  

        </div>
    </li>  
    
    <li title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_TIMER"); ?>" class="rm_button_like_links" onclick="add_new_widget_to_page('Timer')">
        <div class="rm-difl rm-widget-icon rm-widget-richtext"><i class="material-icons">&#xE425;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_TIMER"); ?></a>
        </div>
    </li> 
    
    <li class="rm_button_like_links" onclick="add_new_widget_to_page('Link')" title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_LINK"); ?>">

        <div class="rm-difl rm-widget-icon rm-widget-add-link">
            <i class="material-icons">&#xE157;</i>
        </div>
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("WIDGET_TYPE_LINK"); ?></a>
            
        </div>
    </li>
    
    <li class="rm_button_like_links" onclick="add_new_widget_to_page('YouTubeV')" title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_YOUTUBE"); ?>">
        <div class="rm-difl rm-widget-icon rm-widget-youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)">YouTube Video</a>
        </div>
    </li> 
    
    <li class="rm_button_like_links" onclick="add_new_widget_to_page('Iframe')" title="<?php echo RM_UI_Strings::get("FIELD_HELP_TEXT_IFRAME"); ?>">
        <div class="rm-difl rm-widget-icon rm-widget-iframe-embed"><i class="material-icons">&#xE86F;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)">iFrame Embed</a>
  

        </div>
    </li> 
  
</ul>

<!-- Upcoming Widget -->

<div class="dbfl rm-upcoming-widget-head">Upcoming MagicWidgets</div>


<ul class="rm-widget-selector-view rm-upcoming-widget">
    
    <li title="" class="rm_button_like_links">
        <div class="rm-difl rm-widget-icon rm-widget-add-image"><i class="material-icons">&#xE439;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)"> Image</a>
        </div>
    </li>
    <li class="rm_button_like_links">
        <div class="rm-difl rm-widget-icon rm-widget-form-data"><i class="material-icons">&#xE85D;</i></div> 
        <div class="rm-difl rm-widget-head"> <a href="javascript:void(0)">Form Meta-Data</a>
   
        </div>
    </li>
            
    <li class="rm_button_like_links">
        <div class="rm-difl rm-widget-icon rm-widget-form-date-chart"><i class="material-icons">&#xE6C4;</i></div> 
        <div class="rm-difl rm-widget-head"> <a href="javascript:void(0)">Form Data Chart</a>
 
        </div>
    </li>  
    <li class="rm_button_like_links">
        <div class="rm-difl rm-widget-icon rm-widget-map"><i class="material-icons">&#xE0C8;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)">Map</a>
  

        </div>
    </li>  
     
    
  
    
    <li class="rm_button_like_links">
        <div class="rm-difl rm-widget-icon rm-widget-registration-feed"><i class="material-icons">&#xE0E5;</i></div> 
        <div class="rm-difl rm-widget-head"><a href="javascript:void(0)">Registration Feed</a>
  

        </div>
    </li>
    

  
</ul>



<script>
    function add_new_widget_to_page(widget_type) {
                
                var curr_form_page = get_current_form_page();//(jQuery("#rm_form_page_tabs").tabs("option", "active")) + 1;
                var loc = "?page=rm_field_add_widget&rm_form_id=<?php echo $data->form_id; ?>&rm_form_page_no=" + curr_form_page + "&rm_field_type";
                if (widget_type !== undefined)
                    loc += ('=' + widget_type);
                window.location = loc;
    }
</script>
