/*Functions for displaying helptext tooltip*/
function rmHelpTextIn2(a) {
    var helpTextNode = jQuery(a).siblings(".rmnote");
    var fieldWidth = jQuery(a).children().innerWidth();
    var fieldHeight = jQuery(a).parent().outerHeight();
    var topPos = fieldHeight;
    //var id = setInterval(frame, 1);
    jQuery(helpTextNode).css("width", fieldWidth + "px");
    jQuery(helpTextNode).css('top', topPos + "px");
    helpTextNode.fadeIn(500);
    /*function frame() {
        if (topPos === fieldHeight) {
            clearInterval(id);
        } else {
            topPos++;
            helpTextNode.css('top', topPos + "px");
            }
        }*/
    } 

function rmHelpTextOut2(a) {
    jQuery(a).siblings(".rmnote").fadeOut('fast');
}

function rmFontColor(rmColor) {
        jQuery(".rmnote").css("background-color", rmColor);
        jQuery(".rmprenote").css("border-bottom-color", rmColor);
        var rmRgb = rmColor.substr(3);
        rmRgb = rmRgb.split(',');
        rmRgb[0] = parseFloat((rmRgb[0].substr(1)) / 255);
        rmRgb[1] = parseFloat(rmRgb[1] / 255);
        rmRgb[2] = parseFloat((rmRgb[2].substring(0, rmRgb[2].length-1)) / 255);
        rmRgb.sort(function(a, b){return a-b});
        rmLum = Math.ceil(((rmRgb[2] + rmRgb[1]) * 100) / 2);
        if (rmLum > 80) {jQuery(".rmnote").css("color", "black");}
}

/* Functions for automatically styling certain uncommon fields*/
function rmAddStyle(rmElement) {
    var rmInputHeight = jQuery(".rm-input-control").outerHeight();
    var rmInputBorder = jQuery(".rm-input-control").css("border");
    if (rmInputBorder.search("inset") != 1) {rmInputBorder = "1px solid rgba(150,150,150,0.4)";}
    var rmInputRadius = jQuery(".rm-input-control").css("border-radius");
    /* var rmInputBg = jQuery(".rm-input-control").css("background"); */
    if (rmInputHeight < 36) {rmInputHeight = 36}; 
    jQuery(".rminput").children(rmElement).css({"height": rmInputHeight + "px", "border": rmInputBorder, "border-radius": rmInputRadius /*, "background": rmInputBg */});
}


function load_js_data(){
    var data = {
        'action': 'rm_js_data'
    };

    jQuery.post(rm_ajax_url, data, function (response) {
       rm_js_data= JSON.parse(response);
       initialize_validation_strings();
    });

}

function initialize_validation_strings(){
    if(typeof jQuery.validator != 'undefined'){
        rm_js_data.validations.maxlength = jQuery.validator.format(rm_js_data.validations.maxlength);
        rm_js_data.validations.minlength = jQuery.validator.format(rm_js_data.validations.minlength);
        rm_js_data.validations.max = jQuery.validator.format(rm_js_data.validations.max);
        rm_js_data.validations.min = jQuery.validator.format(rm_js_data.validations.min);
        jQuery.extend(jQuery.validator.messages,rm_js_data.validations); 
    }
}

function rm_init_total_pricing() {
    
    var ele_rm_forms = jQuery("form[name='rm_form']");
    if(ele_rm_forms.length > 0) {
        ele_rm_forms.each(function(i) {
            var el_form = jQuery(this);
            var form_id = el_form.attr('id');     
            var price_elems = el_form.find('[data-rmfieldtype="price"]');
            if(price_elems.length > 0) {
                
                rm_calc_total_pricing(form_id);
                
                price_elems.change(function(e){       
                    rm_calc_total_pricing(form_id);
                });            
                                
                /*Get userdef price fields*/
                var ud_price_elems = price_elems.find('input[type="number"]');
                if(ud_price_elems.length > 0) {
                    ud_price_elems.keyup(function(e){       
                        rm_calc_total_pricing(form_id);
                    });
                }
                
                /*Get quantity fields*/
                var qty_elems = el_form.find('.rm_price_field_quantity');
                if(qty_elems.length > 0) {
                    qty_elems.keyup(function(e){       
                        rm_calc_total_pricing(form_id);
                    });
                    qty_elems.change(function(e){       
                        rm_calc_total_pricing(form_id);
                    });
                }
                
                /*Get role selector field if any*/
                var roles_elems = el_form.find('input[name="role_as"]');
                if(roles_elems.length > 0) {
                    roles_elems.change(function(e){       
                        rm_calc_total_pricing(form_id);
                    });
                }
            }
        });
    }    
}

function rm_calc_total_pricing(form_id){
    var ele_form = jQuery('#'+form_id);
    var price_elems = ele_form.find('[data-rmfieldtype="price"]');
    if(price_elems.length > 0) {
        var tot_price = 0;
        price_elems.each(function(i){
           var el = jQuery(this);
           var qty = 1;
           if(el.prop("tagName") == "INPUT") {
                var el_type = el.attr('type');
                var el_name = el.attr('name');
                switch(el_type){
                    case 'text':     
                        var ele_qty = ele_form.find(':input[name="'+el_name+'_qty"]');
                         
                         if(ele_qty.length > 0) {
                             qty = ele_qty.val();
                         }
                         /* Let it fall through for price calc */
                    case 'hidden':
                        ele_price = el.data("rmfieldprice");
                        if(!ele_price)
                            ele_price = 0;
                        break;

                    case 'number':
                         ele_price = el.val();
                         if(!ele_price)
                             ele_price = 0;
                         var ele_qty = ele_form.find(':input[name="'+el_name+'_qty"]');
                         
                         if(ele_qty.length > 0) {
                             qty = ele_qty.val();
                         }
                        break;

                    case 'checkbox':
                        if(el.prop("checked")){
                         ele_val = el.val();
                         price_val = el.data("rmfieldprice");
                         ele_price = price_val[ele_val];
                         if(!ele_price)
                             ele_price = 0;
                         el_name = el_name.slice(0,-2); /* remove [] */
                         var ele_qty = ele_form.find(':input[name="'+el_name+'_qty['+ele_val+']"]');                         
                            if(ele_qty.length > 0) {
                                qty = ele_qty.val();
                            }
                         }
                         else
                             ele_price = 0;  
                         
                         
                         
                        break;
                        
                    default:
                        ele_price = 0;
                        break;
                }
            } else if(el.prop("tagName") == "SELECT") {
                ele_val = el.val();
                var el_name = el.attr('name');
                if(!ele_val){
                    ele_price = 0;                      
                } else {
                    price_val = el.data("rmfieldprice");
                    ele_price = price_val[ele_val];
                    if(!ele_price)
                        ele_price = 0;  
                    
                    var ele_qty = ele_form.find(':input[name="'+el_name+'_qty"]');
                         
                    if(ele_qty.length > 0) {
                        qty = ele_qty.val();
                    }
                }
            } else {
                ele_price = 0;
            }   
            qty = parseInt(qty);
            if(isNaN(qty))
                qty = 1;
           tot_price += parseFloat(ele_price)*qty;
        });     
        
        /*Add cost of paid role*/
        var role_cost = 0;
        var ele_paidrole = jQuery("#paid_role"+form_id.substr(4));
        if(ele_paidrole.length > 0) {
            var role_data = ele_paidrole.data("rmcustomroles");
            var user_role = ele_paidrole.data("rmdefrole");
            if(!user_role) {
                var roles_elems = ele_form.find('input[name="role_as"]');
                if(roles_elems.length > 0) {
                    user_role = jQuery('input[name="role_as"]:checked', '#'+form_id).val();
                    if(typeof user_role == 'undefined')
                        user_role = '';
                }
            }
            
            if(user_role) {
                if(typeof role_data[user_role] != 'undefined' && role_data[user_role].is_paid)
                    role_cost = parseInt(role_data[user_role].amount);
                if(isNaN(role_cost))
                    role_cost = 0;
            }
        }
        tot_price += role_cost;
        var tot_price_ele = jQuery('#'+form_id).find(".rm_total_price");
        if(tot_price_ele.length > 0) {
            var price_formatting = tot_price_ele.data("rmpriceformat");
            var f_tot_price = '';
            if(price_formatting.pos == 'after')
                f_tot_price = tot_price.toFixed(2) + price_formatting.symbol;
            else
                f_tot_price = price_formatting.symbol + tot_price.toFixed(2);

            tot_price_ele.html(price_formatting.loc_total_text.replace("%s",f_tot_price));
        }
    }
}

function rm_register_stat_ids() {
    var form_ids = [];
    
    jQuery("form[name='rm_form']").each(function(){
        $this = jQuery(this);
        if($this.find("input[name='stat_id']").length > 0)
            form_ids.push($this.attr('id'));
    })
    
    var data = {
                    'action': 'rm_register_stat_ids',
                    'form_ids': form_ids
               };
    
    jQuery.post(rm_ajax_url,
                data,
                function(resp){
                    resp = JSON.parse(resp);
                    if(typeof resp === 'object') {
                        var stat_id = null, stat_field;
                        for(var key in resp) {
                            if(resp.hasOwnProperty(key)) {
                                stat_id = resp[key];                                
                                stat_field = jQuery("form#"+key+" input[name='stat_id']");
                                if(stat_field.length > 0) {
                                    stat_field.val(stat_id);
                                }
                            }
                        }
                    }                    
                });
}

var rmColor;
jQuery(document).ready(function(){
    jQuery(".rminput").on ({
        click: function () {rmHelpTextIn2(this);},
        focusin: function () {rmHelpTextIn2(this);},
        mouseleave: function () {rmHelpTextOut2(this);},
        focusout: function () {rmHelpTextOut2(this);}
    });
    
    jQuery("input, select, textarea").blur(function (){
        jQuery(this).parents(".rminput").siblings(".rmnote").fadeOut('fast');
    });
    
    rm_register_stat_ids();
    
    load_js_data();
    
    /*Initialize "Total" price display functionality*/
    rm_init_total_pricing();
    jQuery('.rmagic.rm_layout_two_columns .rmfieldset').each(function(){
        var a = jQuery(this).children(".rmrow").not(".rm_captcha_fieldrow");

        for( var i = 0; i < a.length; i+=2 ) {
             a.slice(i, i+2).wrapAll('<div class="rm-two-columns-wrap"></div>');
         }

    });     
    
    var $rmagic = jQuery(".rmagic");
    if($rmagic.length > 0) {
        /* Commands for automatically styling certain uncommon fields*/
        $rmagic.append("<input type='text' class='rm-input-control'><a class='rm-anchor-control'>.</a>");

        var rmHasSelect = jQuery(".rminput").children("select[multiple != multiple]").length;
        if (jQuery.isNumeric(rmHasSelect) && rmHasSelect > 0) {
            rmAddStyle("select[multiple != multiple]");
            jQuery(".rminput").children("select[multiple != multiple]").css("background", "initial");
        }

        var rmHasNumber = jQuery(".rminput").children("input[type = 'number']").length;
        if (jQuery.isNumeric(rmHasNumber) && rmHasNumber > 0) {
            rmAddStyle("input[type = 'number']");}
        var rmHasUrl = jQuery(".rminput").children("input[type = 'url']").length;
        if (jQuery.isNumeric(rmHasUrl) && rmHasUrl > 0) {
            rmAddStyle("input[type = 'url']");}

        /* For automatically styling helptext tooltip*/
        var rmHasPass = jQuery(".rminput").children("input[type = 'password']").length;
        if (jQuery.isNumeric(rmHasPass) && rmHasPass > 0) {
            rmAddStyle("input[type = 'password']");}

        var rmColor = jQuery(".rm-anchor-control").css("color");
        rmFontColor(rmColor);

        jQuery(".rm-input-control").remove();
        jQuery(".rm-anchor-control").remove();
    }
});

