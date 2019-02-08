<?php
wp_register_script('eesubscribe-jquery', get_option('plugin_path') . '/elastic-email-shared/assets/js/jquery.min.js', '', 3.3, true);
wp_register_script('eesubscribe-widget-scripts', get_option('plugin_path') . '/elastic-email-shared/assets/js/eesf_widget.min.js', '', 1.0, true);
wp_enqueue_style('eesw-widget-style', plugins_url('/elastic-email-shared/assets/css/eesf_widget.min.css', dirname(__FILE__)), array(), null, 'all');

wp_enqueue_script('eesubscribe-jquery');
wp_enqueue_script('eesubscribe-widget-scripts');
wp_enqueue_style('eesw-widget-style');

wp_localize_script('eesubscribe-widget-scripts', 'eesf_php_data',
    array(
        'publicAccountID' => get_option('ee_publicaccountid')
    )
);

?>
<!-- Powered by Elastic Email | Elastic Email Subscribe Form - https://wordpress.org/plugins/elastic-email-subscribe-form/-->
<div id="eewp_widget"
     style="background:<?php echo $instance['color_body'] ?>; border-radius: <?php echo $instance['border_radius'] ?>; padding: <?php echo $instance['widget_padding'] ?>">
    <h4 class="title"
        style="color:<?php echo $instance['color_header-txt'] ?>;text-align:<?php echo $instance['text_align'] ?>"><?php echo $instance['text_header'] ?></h4>
    <p style="color:<?php echo $instance['color_description-txt'] ?>;text-align:<?php echo $instance['text_align'] ?>"><?php echo $instance['text_description'] ?></p>


    <form action="" method="post" id="eesf_subscribewidget">
        <div id="eeswlistsinputs">
            <?php

            $eesw_actual_lists = explode(",", $instance['selectedlists']);

            if (sizeof($eesw_actual_lists) == 1) {
                $eesw_list .= '<input type="checkbox" class="eeswpubliclist" name="publiclistid" value="' . $eesw_selectedlist . '" checked="checked" style="display: none">';
            }

            foreach ($eesw_actual_lists as $eesw_selectedlist) {
                if ($eesw_selectedlist != '00000000-0000-0000-0000-000000000000') {
                    $eesw_list .= '<input type="checkbox" class="eeswpubliclist" name="publiclistid" value="' . $eesw_selectedlist . '" checked="checked" style="display: none">';
                }
            }
            echo $eesw_list;

            ?>
        </div>

        <div class="row">

            <div class="eesf-form-group">
                <label for="eesw-name" style="color:<?php echo $instance['color_input-label'] ?>">Name</label>
                <input maxlength="60" name="eesw-name" id="eesw-name" type="text" size="20"
                       placeholder="Please enter your name" class="form-control contact-input"
                       style="text-align:left;padding-left:6px;padding-right:6px;background:<?php echo $instance['color_input-bg'] ?>;color:<?php echo $instance['color_input-txt'] ?>;">
                <span class="form_error hide" style="color:<?php echo $instance['color_input-label'] ?>">Please enter your name.</span>
            </div>

            <div class="eesf-form-group">
                <label for="email" style="color:<?php echo $instance['color_input-label'] ?>">Email</label>
                <input maxlength="60" name="eesw-email" id="eesw-email" type="email" size="20"
                       placeholder="Please enter your email" class="form-control contact-input"
                       style="text-align:left;padding-left:6px;padding-right:6px;background:<?php echo $instance['color_input-bg'] ?>;color:<?php echo $instance['color_input-txt'] ?>;">
                <span class="form_error hide" style="color:<?php echo $instance['color_input-label'] ?>">Please enter your email.</span>
                <span class="form_error hide" id="invalid_email"
                      style="color:<?php echo $instance['color_input-label'] ?>">This email is not valid.</span>
            </div>

            <div class="eesf-form-group" style="text-align:<?php echo $instance['button-position'] ?>">
                <input type="submit" id="submit_from_widget" value="<?php echo $instance['text_subscribe'] ?>"
                       style="background:<?php echo $instance['color_button-bg'] ?>;color:<?php echo $instance['color_button-txt'] ?>;text-align:<?php echo $instance['text_align'] ?>">
            </div>

        </div>
    </form>
    <div id="ee-success" class="col-12 hide ee-form_success text-center" style="padding-top: 15px;">
        <div class="col-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 13.229 13.229">
                <path d="M6.615 0A6.606 6.606 0 0 0 0 6.615a6.606 6.606 0 0 0 6.615 6.614 6.606 6.606 0 0 0 6.614-6.614A6.606 6.606 0 0 0 6.615 0zm-.993 10.12L2.25 6.725l1.102-1.08 2.271 2.292 4.256-4.255 1.102 1.103z"
                      fill="#fff"/>
            </svg>
        </div>
        <p style="font-size:0.85rem;margin-top:10px;margin-bottom:5px;color:<?php echo $instance['color_input-label'] ?>"><?php echo $instance['text_action'] ?></p>
    </div>
</div>


