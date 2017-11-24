<div class="bbp-template-notice">
    <p><?php echo __("Maximum file size allowed is", "gd-bbpress-attachments")." ".$file_size." KB."; ?></p>
</div>
<p class="bbp-attachments-form">
    <div class="source_sans_pro upload_media">
      <?php _e("Upload Media", "gd-bbpress-attachments"); ?>
    </div>
    <br/>
    <label for="add_file" class="file_attach_button source_sans_pro">
      Choose Files...
    </label>
    <input type="file" size="40" id="add_file" name="d4p_attachment[]" class="file_attach_button"><br/>
    <a class="d4p-attachment-addfile" href="#"><?php _e("Add another file", "gd-bbpress-attachments"); ?></a>
</p>
