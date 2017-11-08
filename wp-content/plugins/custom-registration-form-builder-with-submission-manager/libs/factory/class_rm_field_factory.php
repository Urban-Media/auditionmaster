<?php

/**
 * Description of RM_Field_Factory
 *
 */
class RM_Field_Factory {
    
    protected $db_field;
    protected $field_name;
    protected $field_options;
    protected $gopts;
    protected $opts;
    protected $x_opts;
    protected $prevent_value_update;
            
    public function __construct($db_field,$opts, $prevent_value_update = false){
        $this->prevent_value_update = $prevent_value_update;
        $this->db_field= $db_field;
        $this->gopts= new RM_Options;
        $this->opts= $opts;
        $this->field_options = maybe_unserialize($db_field->field_options);
        $temp_field = new RM_Fields;
        $valid_field_options = $temp_field->get_valid_options();
        
        if($this->field_options) {
            foreach($valid_field_options as $option_name) {
                if(!isset($this->field_options->$option_name)) {
                    $this->field_options->$option_name = null;
                }
            }
        }
        
        $this->field_name= $db_field->field_type."_".$db_field->field_id;
        $this->db_field->field_value = maybe_unserialize($db_field->field_value);
        if(isset($this->field_options->icon))
            $this->x_opts = (object)array('icon' => $this->field_options->icon);
        else
            $this->x_opts = null;
        
        if(!isset($this->opts['value']))
            $this->opts['value'] = null;
    }
    
     public function create_binfo_field(){
        if(is_user_logged_in() && !isset($_GET['form_prev']))
        {
            $current_user = wp_get_current_user();  
            $user_binfo= get_user_meta($current_user->ID, 'description', true);
            $this->opts['value'] = ($user_binfo == '')? $this->opts['value'] : $user_binfo;
        }
       return new RM_Frontend_Field_Base($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
   
     }     
    
    public function create_price_field(){
        $currency_pos = $this->gopts->get_value_of('currency_symbol_position');
        $currency_symbol = $this->gopts->get_currency_symbol();
        return new RM_Frontend_Field_Price($this->db_field->field_id, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $currency_pos, $currency_symbol, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts); 
    }
    
    public function create_file_field(){
        return null;
    }
    
    public function create_select_field(){
        if(is_user_logged_in() && !$this->prevent_value_update && !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
            $current_user = wp_get_current_user();  
            $select_field= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
            $this->opts['value'] = ($select_field == '')? $this->opts['value'] : $select_field;
        }
        return new RM_Frontend_Field_Select($this->db_field->field_id, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_multidropdown_field(){
      
        $this->opts['multiple']='multiple';
        return null;
    }
    
    public function create_repeatable_field(){
        return null;
    }
    
    public function create_base_field(){
        if(is_user_logged_in() && !$this->prevent_value_update && !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
            $current_user = wp_get_current_user();  
            $user_base_info= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
            $this->opts['value'] = ($user_base_info == '')? $this->opts['value'] : $user_base_info;
        }
        return new RM_Frontend_Field_Base($this->db_field->field_id,'Textbox', $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_phone_field(){
       return null;
    }
    
    public function create_mobile_field(){
        return null;
    }
    
    public function create_nickname_field(){
        if(is_user_logged_in() && !isset($_GET['form_prev']))
        {
            $current_user = wp_get_current_user();  
            $user_nickname= get_user_meta($current_user->ID, 'nickname', true);
            $this->opts['value'] = ($user_nickname == '')? $this->opts['value'] : $user_nickname;
        }
       return new RM_Frontend_Field_Base($this->db_field->field_id,'Nickname', $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_image_field(){
        return null;
    }
    
    public function create_facebook_field(){
        return null;
    }
    
    public function create_website_field(){
        $this->opts['Pattern'] = "((?:https?\:\/\/|[wW][wW][wW]\.)(?:[-a-zA-Z0-9]+\.)*[-a-zA-Z0-9]+.*)";
        if(is_user_logged_in() && !isset($_GET['form_prev']))
        {
            $current_user = wp_get_current_user(); 
            $this->opts['value'] = isset($current_user->user_url)? $current_user->user_url : null;
        }
        return new RM_Frontend_Field_Base($this->db_field->field_id,'Website', $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_twitter_field(){
        return null;
    }
    
    public function create_google_field(){
        return null;
    }
    
    public function create_instagram_field(){
       return null;
    }
    
    public function create_linked_field(){
        return null;
    }
    
    public function create_soundcloud_field(){
        return null;
    }
    
    public function create_youtube_field(){
        return null;
        
    }
    
    public function create_vkontacte_field(){
        return null;
        
    }
    
    public function create_skype_field(){
        return null;
    }
    
    public function create_bdate_field(){
        return null;
    }
    
    public function create_secemail_field(){
        return null;
    }
    
    public function create_gender_field(){
        return null;
    }
    
    public function create_terms_field(){
        $this->opts['cb_label'] = isset($this->field_options->tnc_cb_label)?$this->field_options->tnc_cb_label:null;
        return new RM_Frontend_Field_Terms($this->db_field->field_id, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_language_field(){
       return null;
    }
    
    public function create_radio_field(){
        if(is_user_logged_in() && !$this->prevent_value_update && !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
            $current_user = wp_get_current_user();  
            $radio_info= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
            $this->opts['value'] = ($radio_info == '')? $this->opts['value'] : $radio_info;
        }
        return new RM_Frontend_Field_Radio($this->db_field->field_id, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_checkbox_field(){
        
         if(is_user_logged_in() && !$this->prevent_value_update &&  !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
                $current_user = wp_get_current_user();  
                $checkbox_info= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
                $this->opts['value'] = ($checkbox_info == '')? $this->opts['value'] : $checkbox_info;  
        }
      
       
        return new RM_Frontend_Field_Checkbox($this->db_field->field_id, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
      
        }
 
    public function create_shortcode_field(){
        return null;
    }
    
    public function create_divider_field(){
       return new RM_Frontend_Field_Visible_Only($this->db_field->field_id,'HTMLCustomized', $this->db_field->field_label, $this->opts, ' <div class="rmrow rm-full-width"><hr class="rm_divider" width="100%" size="8" align="center"></div>', $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_spacing_field(){
       return new RM_Frontend_Field_Visible_Only($this->db_field->field_id,'HTMLCustomized', $this->db_field->field_label, $this->opts, '<div class="rmrow rm-full-width"><div class="rm_spacing"></div></div>', $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_htmlh_field(){
        return new RM_Frontend_Field_Visible_Only($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_htmlp_field(){
        return new RM_Frontend_Field_Visible_Only($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_time_field(){
        return null;
    }
    
    public function create_rating_field(){
        return null;
    }
    
    public function create_custom_field(){
               return null;
    }
    
    public function create_email_field(){
        // in this case pre-populate the primary email field with logged-in user's email.
        if($this->db_field->is_field_primary)
        {
            if(is_user_logged_in() && !isset($_GET['form_prev']))
            {
                $current_user = wp_get_current_user();                            
                $this->opts['value'] = $current_user->user_email;
            }
        }
        else
        {
            if(is_user_logged_in()  && !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
                $current_user = wp_get_current_user();  
                $user_emailinfo= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
                $this->opts['value'] = ($user_emailinfo == '')? $this->opts['value'] : $user_emailinfo;
            }
        }
         return new RM_Frontend_Field_Base($this->db_field->field_id,$this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_address_field(){
        return null;
    }
    
    public function create_map_field(){
        return null;
    }
    
    public function create_geo_field(){
        return null;
    }
    
    public function create_textbox_field(){
        $field= $this->create_base_field();
        return $field;
    }
    
    
    public function create_fname_field(){
       if(is_user_logged_in() && !isset($_GET['form_prev']))
        {
            $current_user = wp_get_current_user();  
            $user_fname= get_user_meta($current_user->ID, 'first_name', true);
            $this->opts['value'] = ($user_fname == '')? $this->opts['value'] : $user_fname;
        }
      return new RM_Frontend_Field_Base($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
  
    }
    
    public function create_lname_field(){
        if(is_user_logged_in() && !isset($_GET['form_prev']))
        {
            $current_user = wp_get_current_user();  
            $user_lname= get_user_meta($current_user->ID, 'last_name', true);
            $this->opts['value'] = ($user_lname == '')? $this->opts['value'] : $user_lname;
        }
      return new RM_Frontend_Field_Base($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
  
    }
    
    public function create_hidden_field(){
        return new RM_Frontend_Field_Hidden($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_richtext_field(){ 
        return new RM_Frontend_Field_Visible_Only($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->field_value, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_default_field(){
        if(is_user_logged_in() && !$this->prevent_value_update && !isset($_GET['form_prev']) && $this->db_field->field_show_on_user_page && !empty($this->field_options->field_meta_add)){
         $current_user = wp_get_current_user();  
         $user_defaultinfo= get_user_meta($current_user->ID, $this->field_options->field_meta_add, true);
        
         $this->opts['value'] = ($user_defaultinfo == '')? $this->opts['value'] : $user_defaultinfo;
        }
        return new RM_Frontend_Field_Base($this->db_field->field_id, $this->db_field->field_type, $this->db_field->field_label, $this->opts, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_link_field(){
       $href=''; $target='';
      // print_r($this->field_options);
       if($this->field_options->link_type=="url"){
           $href= $this->field_options->link_href;
       } else if($this->field_options->link_type=="page"){
           $href= get_permalink($this->field_options->link_page);
       }
       
       if($this->field_options->link_same_window!=1){
           $target='target="_blank"';
       }
       
       $link_html= '<a '.$target.' href="' ;
       $link_html .= $href.'">';
       $link_html.= $this->db_field->field_label.'</a>';
       return new RM_Frontend_Field_Visible_Only($this->db_field->field_id,'HTMLCustomized',$this->db_field->field_label, $this->opts,$link_html, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    // Special function for YouTube Widgets
    public function create_youtubev_widget(){
        $class=  isset($options['class'])?$options['class'].' rm-full-width':'rm-full-width';
        $width= !empty($this->field_options->yt_player_width)?$this->field_options->yt_player_width:'560';
        $height= !empty($this->field_options->yt_player_height)?$this->field_options->yt_player_height:'315';
        $video_id= RM_Utilities::extract_youtube_embed_src($this->db_field->field_value);
        $src= "http://www.youtube.com/embed/".$video_id."?autoplay=".$this->field_options->yt_auto_play; 
        $src .= $this->field_options->yt_repeat ? "&playlist=".$video_id."&loop=1"  : '';
        $src .= empty($this->field_options->yt_related_videos) ? '&rel=0' : '';
        
        $iframe= "<div class='rmrow'><iframe width='".$width."' height='".$height."' src='".$src."' frameborder='0' allowfullscreen></iframe></div>";
        return new RM_Frontend_Field_Visible_Only($this->db_field->field_id,'HTMLCustomized',$this->db_field->field_label, $this->opts,$iframe, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
    
    public function create_youtubev_field(){
         return $this->create_youtubev_widget();
     }
    
    public function create_iframe_field(){  
        $class=  isset($options['class'])?$options['class'].' rm-full-width':'rm-full-width';
        $width= !empty($this->field_options->if_width)?$this->field_options->if_width:'auto';
        $height= !empty($this->field_options->if_height)?$this->field_options->if_height:'auto';
        $src= $this->db_field->field_value; 
        $link_type= RM_Utilities::check_src_type($this->db_field->field_value);
        
        if($link_type === 'youtube'){
            $video_id= RM_Utilities::extract_youtube_embed_src($this->db_field->field_value);
            $src= "http://www.youtube.com/embed/".$video_id;        
        }
        elseif($link_type === 'vimeo') {
            $video_id= RM_Utilities::extract_vimeo_embed_src($this->db_field->field_value);
            $src= "http://player.vimeo.com/video/".$video_id; 
        }
        $iframe= "<div class='rmrow'><iframe width='".$width."' height='".$height."' src='".$src."' frameborder='0' allowfullscreen></iframe></div>";
        return new RM_Frontend_Field_Visible_Only($this->db_field->field_id,'HTMLCustomized',$this->db_field->field_label, $this->opts,$iframe, $this->db_field->page_no, $this->db_field->is_field_primary, $this->x_opts);
    }
   
}
