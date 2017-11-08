<?php

//var_dump($data->init_field_config);
$rule_data = $data->init_field_config->rule_data;
$action_data = $data->init_field_config->action_data;
?>

    
<div class="rmagic">
    
    <div class="rm-task-setting-wrap">
        

        <div class="rmheader">Task Settings</div>
   
        <form name="rmc_task_settings_form" id="rmc_task_settings_form" action="" method="post" style="display:none">
            <input type="hidden" name="rmc-task-edit-form-subbed" value="yes">
 
            <input type="radio" name="rm-task-slide" class="rm-slide-radio1 rm-task-slide-radio" checked id="rm-task-slide-1"> 
            <input type="radio" name="rm-task-slide" class="rm-slide-radio2 rm-task-slide-radio" id="rm-task-slide-2">
            <input type="radio" name="rm-task-slide" class="rm-slide-radio3 rm-task-slide-radio" id="rm-task-slide-3">
    
            <div class="rm-task-slide rm-task-slide1">     

                <div class="rmrow">
                    <div class="rmfield" for="rmc_task_name">
                        <label><sup class="required">* </sup><b>Name</b></label>
                    </div>
                    <div class="rminput">
                        <input type="text" name="rmc_task_name" id="rmc_task_name" required value="<?php echo $data->init_field_config->name; ?>">
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Name of the task. Should be unique.</div>
                    </div>
                </div>

                <div class="rmrow">
                    <div class="rmfield" for="rmc_task_description">
                        <label><b>Description</b></label>
                    </div>
                    <div class="rminput">
                        <textarea rows="5" name="rmc_task_description" id="rmc_task_description"><?php echo $data->init_field_config->desc; ?></textarea>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">A brief description of the task.</div>
                    </div>
                </div>   

            </div>

            <div class="rm-task-slide rm-task-slide2">
                
                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>User Account Rule</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio" >
                            <li>
                                <input id="rmc_enable_user_account_rule" class="rmc_control_toggle" type="checkbox" name="rmc_enable_user_account_rule" value="1" <?php echo $rule_data['g_user_account_rule']['state']; ?>>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Select users depending upon the account state.</div>
                    </div>              
                </div>

                <div class="childfieldsrow" id="rmc_enable_user_account_rule_ctrl_subpanel">
                    <div class="rmrow">
                        <div class="rmfield" for=""><label><b>User Account State</b></label></div>
                        <div class="rminput">
                            <ul class="rmradio">
                                <li> 
                                    <input id="rm_-0" type="radio" name="rmc_rule_user_account" class="rm_"  required="" value="active" <?php echo $rule_data['g_user_account_rule']['active_option_state']; ?>> Activated User Accounts </li>
                                <li> 
                                    <input id="rm_-1" type="radio" name="rmc_rule_user_account" class="rm_"  required="" value="inactive" <?php echo $rule_data['g_user_account_rule']['inactive_option_state']; ?>> Deactivated User Accounts </li> 
                            </ul>
                            <div id="rm_user_state_rule_error"  class="rm-rule-error" style="display:none">
                                &#9888; Select a user state.
                            </div>
                        </div>
                        <div class="rmnote"><div class="rmprenote"></div>
                            <div class="rmnotecontent">Select the type of the users account.</div>
                        </div>
                    </div>
                </div>
                
                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>Submission age Rule</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio" >
                            <li>
                                <input id="rmc_enable_sub_time_rule" class="rmc_control_toggle" type="checkbox" name="rmc_enable_sub_time_rule" value="1" <?php echo $rule_data['g_sub_time_rule']['state']; ?>>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Select submissions depending upon the time elapsed after submission.</div>
                    </div>              
                </div>

                <div class="childfieldsrow" id="rmc_enable_sub_time_rule_ctrl_subpanel">
                    <div class="rmrow">
                        <div class="rmfield" for=""><label><b>Submission age Rule</b></label></div>
                        <div class="rminput">
                            <ul class="rmradio">
                                <li> 
                                    <input id="rmc_enable_sub_time_rule_older_than" type="checkbox" name="rmc_enable_sub_time_rule_older_than" class="rm_" value="1" <?php echo $rule_data['g_sub_time_rule']['older_than_state']; ?>> Submissions older than 
                                    <input id="rmc_rule_sub_time_older_than_age" type="number" name="rmc_rule_sub_time_older_than_age" class="rm_" step="1" min="0" value="<?php echo $rule_data['g_sub_time_rule']['older_than_age']; ?>"> days
                                </li>
                                <li> 
                                    <input id="rmc_enable_sub_time_rule_younger_than" type="checkbox" name="rmc_enable_sub_time_rule_younger_than" class="rm_" value="1" <?php echo $rule_data['g_sub_time_rule']['younger_than_state']; ?>> Submissions younger than 
                                    <input id="rmc_rule_sub_time_younger_than_age" type="number" name="rmc_rule_sub_time_younger_than_age" class="rm_" step="1" min="0" value="<?php echo $rule_data['g_sub_time_rule']['younger_than_age']; ?>"> days
                                </li> 
                            </ul>
                            <div id="rm_sub_time_rule_error" class="rm-rule-error" style="display:none">
                                    Error Message!
                            </div>
                        </div>
                        <div class="rmnote"><div class="rmprenote"></div>
                            <div class="rmnotecontent">Configure the desired criteria.</div>
                        </div>
                    </div>
                </div>
                

                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>Field Value Rule</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio">
                            <li>
                                <input id="rmc_enable_field_value_rule" class="rmc_control_toggle" type="checkbox" name="rmc_enable_field_value_rule" value="1" <?php echo $rule_data['g_field_val_rule']['state']; ?>>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Apply rule on the value of the form fields</div>
                    </div>
                </div>

                <div class="childfieldsrow" id="rmc_enable_field_value_rule_ctrl_subpanel">
                    <div class="rmrow">
                        <div class="rminput rm-field-value-rule">
                            <ul class="rm-field-value-rule-wrap" id="rm_field_value_rule_wrap">
                                <?php if(count($rule_data['g_field_val_rule']['rmc_rule_fv_fids']) > 0): ?>
                                <?php foreach($rule_data['g_field_val_rule']['rmc_rule_fv_fids'] as $index => $fid): ?>
                                <li class="appendable_options rm-deletable-options">
                                    <select name="rmc_rule_fv_fids[]">
                                        <option value="">Select a Field</option>
                                        <?php foreach($data->fields as $field): 
                                                echo '<option value="',$field->field_id,'"';
                                                if($field->field_id == $fid)
                                                    echo " selected";
                                                echo '>',$field->field_label,'</option>';
                                              endforeach; ?>
                                    </select>
                                    <input type="text" placeholder="Values" name="rmc_rule_fv_fvals[]" id="id_placeholder_no" class="" required value="<?php echo $rule_data['g_field_val_rule']['rmc_rule_fv_fvals'][$index]; ?>">
                                    <div class="rm_actions" onclick="rm_delete_appended_field(this,'rm_field_value_rule_wrap')">
                                        <a href="javascript:void(0)">Delete</a>
                                    </div>
                                </li>   
                                <?php endforeach; ?>
                                <?php else: ?>
                                <li class="appendable_options rm-deletable-options">
                                    <select name="rmc_rule_fv_fids[]">
                                        <option value="">Select a Field</option>
                                        <?php foreach($data->fields as $field): 
                                                echo '<option value="',$field->field_id,'"';
                                                echo '>',$field->field_label,'</option>';
                                              endforeach; ?>
                                    </select>
                                    <input type="text" placeholder="Values" name="rmc_rule_fv_fvals[]" id="id_placeholder_no" class="" required value="">
                                    <div class="rm_actions" onclick="rm_delete_appended_field(this,'rm_field_value_rule_wrap')">
                                        <a href="javascript:void(0)">Delete</a>
                                    </div>
                                </li>
                                <?php endif; ?>
                            </ul>
                            <div class="rm_action_container" id="rm_action_container_id">
                                <div id="rm_field_value_rule_error"  class="rm-rule-error" style="display: none">
                                    Error Message!
                                </div>
                              <div class="rm_action" id="rm_action_field_container" onclick="rm_append_field('li',this)">
                                  <a href="javascript:void(0)">+ Add more field value rules</a>
                              </div>
                            </div>                              
                        </div>
                        <div class="rmnote">
                            <div class="rmprenote"></div>
                            <div class="rmnotecontent">Create rules for submitted field values. Separate multiple values with pipe '|'.</div>
                        </div>
                    </div>  
                </div>  
                
                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>Payment processor Rule</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio" >
                            <li>
                                <input id="rmc_enable_pay_proc_rule" class="rmc_control_toggle" type="checkbox" name="rmc_enable_pay_proc_rule" value="1" <?php echo $rule_data['g_pay_proc_rule']['state']; ?>>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Select submissions depending upon the payment processor used for submission.</div>
                    </div>              
                </div>
                
                <div class="childfieldsrow" id="rmc_enable_pay_proc_rule_ctrl_subpanel">
                    <div class="rmrow rm_pricefield_checkbox">
                        <div class="rmfield" for="">
                            <label>Payment Processor</label>
                        </div>
                        <div class="rminput">
                            <ul class="rmradio">
                                <?php $sppcount = count($rule_data['g_pay_proc_rule']['pprocs']); ?>
                                <?php foreach($data->pay_procs_options as $pproc => $pproc_label): ?>
                                <li>
                                    <input id="options_payment-element-1-0" type="checkbox" name="rmc_rule_pay_procs[]" value="<?php echo $pproc;?>"
                                           <?php if(in_array($pproc, $rule_data['g_pay_proc_rule']['pprocs']))
                                                   echo "checked";
                                           ?>
                                    >
                                    <span><?php echo $pproc_label;?></span>
                                </li>
                                <?php endforeach; ?>                            
                            </ul>
                        </div>
                        <div class="rmnote">
                            <div class="rmprenote"></div>
                            <div class="rmnotecontent">Only submission's having payment through these gateways will be considered.</div>    
                        </div>
                    </div>
                </div>
                
                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>Payment status Rule</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio" >
                            <li>
                                <input id="rmc_enable_pay_status_rule" class="rmc_control_toggle" type="checkbox" name="rmc_enable_pay_status_rule" value="1" <?php echo $rule_data['g_pay_status_rule']['state']; ?>>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Select submissions depending upon the status of payment.</div>
                    </div>              
                </div>
                
                <div class="childfieldsrow" id="rmc_enable_pay_status_rule_ctrl_subpanel">
                    <div class="rmrow rm_pricefield_checkbox">
                        <div class="rmfield" for="">
                            <label>Payment Status</label>
                        </div>
                        <div class="rminput">
                            <ul class="rmradio">
                                <?php $spscount = count($rule_data['g_pay_status_rule']['pay_statuses']); ?>                            
                                <li>
                                    <?php if(in_array('completed',$rule_data['g_pay_status_rule']['pay_statuses']))
                                            $temp_state = "checked";
                                    else $temp_state = ""
                                    ?>            
                                    <input id="options_payment-element-1-0" type="checkbox" name="rmc_rule_pay_status[]" value="completed" <?php echo $temp_state; ?>>
                                    <span> Completed </span>
                                </li>
                                <li>
                                    <?php if(in_array('pending',$rule_data['g_pay_status_rule']['pay_statuses']) || $spscount == 0)
                                            $temp_state = "checked";
                                    else $temp_state = ""
                                    ?>
                                    <input id="options_payment-element-1-1" type="checkbox" name="rmc_rule_pay_status[]" value="pending" <?php echo $temp_state; ?>>
                                    <span> Pending </span>
                                </li>
                                <li>
                                    <?php if(in_array('canceled',$rule_data['g_pay_status_rule']['pay_statuses']) || $spscount == 0)
                                            $temp_state = "checked";
                                    else $temp_state = ""
                                    ?>
                                    <input id="options_payment-element-1-2" type="checkbox" name="rmc_rule_pay_status[]" value="canceled" <?php echo $temp_state; ?>>
                                    <span> Canceled </span>
                                </li>
                            </ul>
                        </div>
                        <div class="rmnote">
                            <div class="rmprenote"></div>
                            <div class="rmnotecontent">Submissions having these payment status associated will be considered.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rm-task-slide rm-task-slide3">

                <div class="rmrow rm-account-action">
                    <div class="rmfield" for="">
                        <label>User account action</label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio">
                            <li>
                                <input id="options_payment-element-1-0" type="radio" name="rmc_action_user_acc" value="do_nothing" <?php if("do_nothing" == $action_data['g_user_acc_action']['type']) echo "checked";?>>
                                <span> Do Nothing </span>
                            </li>
                            <li>
                                <input id="options_payment-element-1-1" type="radio" name="rmc_action_user_acc" value="activate" <?php if("activate" == $action_data['g_user_acc_action']['type']) echo "checked";?>>
                                <span> Activate Account </span>
                            </li>
                            <li>
                                <input id="options_payment-element-1-2" type="radio" name="rmc_action_user_acc" value="deactivate" <?php if("deactivate" == $action_data['g_user_acc_action']['type']) echo "checked";?>>
                                <span> Deactivate Account </span>
                            </li>
                            <li>
                                <input id="options_payment-element-1-2" type="radio" name="rmc_action_user_acc" value="delete" <?php if("delete" == $action_data['g_user_acc_action']['type']) echo "checked";?>>
                                <span> Delete Account!! </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Select the action to be taken on the filtered accounts.</div>
                    </div>
                </div> 

                <div class="rmrow">
                    <div class="rmfield" for="">
                        <label><b>Send Email</b></label>
                    </div>
                    <div class="rminput">
                        <ul class="rmradio">
                            <li>
                                <input id="rmc_enable_send_mail_action" class="rmc_control_toggle" type="checkbox" name="buy_pro" value="1" disabled>
                                <span>  </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rmnote">
                        <div class="rmprenote"></div>
                        <div class="rmnotecontent">Send email to selected users.<br/><br/><?php echo RM_UI_Strings::get('MSG_BUY_PRO_INLINE');?></div>
                    </div>
                </div>

                <div class="childfieldsrow" id="rmc_enable_send_mail_action_ctrl_subpanel">                
                    
                </div>

            </div>

            <div class="buttonarea rm-task-setting-footer">              
                <div class="rm-previous rm-control">
                    <label for="rm-task-slide-1" class="rm-numb0" onclick="window.history.back()">&larr; &nbsp; Back</label>
                    <label for="rm-task-slide-1" class="rm-numb1">&larr; &nbsp; Previous</label>
                    <label for="rm-task-slide-2" class="rm-numb2">&larr; &nbsp; Previous</label>
                    <label for="rm-task-slide-3" class="rm-numb3">&larr; &nbsp; Previous</label>
                </div>           
                <div class="rm-next rm-control">

                    <label for="rm-task-slide-2" class="rm-numb2" onclick="rmc_validate_task_form('basic_details')">Next</label>
                    <label for="rm-task-slide-3" class="rm-numb3" onclick="rmc_validate_task_form('rule_config')">Next</label>
                    <label for="rm-task-slide-3" class="rm-numb4" onclick="rmc_validate_task_form('action_config')">Save</label>
                </div>            
            </div> 
        </form>
    </div> 
</div> 

