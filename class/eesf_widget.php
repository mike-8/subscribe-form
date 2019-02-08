<?php

class EESW_Widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array(
            'classname' => 'EESW_Widget',
            'description' => 'Official Elastic Email Subscribe widget!',
        );
        parent::__construct('EESW_Widget', 'Subscribe Form by Elastic Email', $widget_ops);
    }

    function register_style_widget()
    {
        add_action('wp_enqueue_scripts', array($this, 'register_style_widget'));
        add_action('admin_enqueue_scripts', array($this, 'register_widget_scripts'));
    }

    function register_widget_scripts($hook)
    {
         if ($hook != 'widgets.php')
            return;
    }

    /*  Widget Settings */
    // display widget
    function widget($args, $instance)
    {
        extract($args);

        echo $before_widget;
        require(dirname(__FILE__) . '/../template/eesf_templatewidget.php');
        echo $after_widget;
    }

    //default settings
    function form($instance)
    {
        // Builds a label with check boxes based on json with settingswidget.php
        if (get_option('ee-listdata_json') != '0') {
            $listdata_array = json_decode(get_option('ee-listdata_json'));

            $fulllistslist = '';
            $fulllistslist_id = '';

            foreach ($listdata_array as $key) {
                $fulllistslist .= '
                    <label class="checkbox-inline" style="padding-right:10px;">
                        <span class="eesw_selected_list" publiclistid="' . $key[1] . '" eesfselected="no" style="text-decoration: line-through; font-weight: normal;">' . $key[0] . '</span>
                    </label>';

                $fulllistslist_id .= $key[1] . ',';
            }
        } else {
            $fulllistslist = 'Not selected list. Your contacts will be added to AllContacts.';
        }

        $fulllistslist_id_trim = substr($fulllistslist_id, 0, -1);

        $defaults = array(
            'text_header' => 'Subscribe me!',
            'text_description' => 'Subscribe to our mailing list',
            'text_action' => 'Thank you for subscribing to our newsletter!',
            'text_subscribe' => 'Subscribe!',
            'color_body' => '#282842',
            'color_header-txt' => '#fff',
            'color_description-txt' => '#fff',
            'color_input-bg' => '#fff',
            'color_input-txt' => '#1a1a1a',
            'color_input-label' => '#fff',
            'color_button-bg' => '#f9c053',
            'color_button-txt' => '#32325c',
            'button-position' => 'center',
            'text_align' => 'center',
            'border_radius' => '4px',
            'widget_padding' => '40px 30px',
            'selectedlists' => '00000000-0000-0000-0000-000000000000'
        );

        //widget forms
        $instance = wp_parse_args((array)$instance, $defaults);

        ?>
        <p style="margin-top:10px;margin-bottom:6px"><strong>WIDGET TEXT:</strong></p>
        <p style="margin:2px">Header: <input class="widefat" name="<?php echo $this->get_field_name('text_header'); ?>" type="text" value="<?php echo $instance['text_header']; ?>"/></p>
        <p style="margin:2px">Description: <input class="widefat" name="<?php echo $this->get_field_name('text_description'); ?>" type="text" value="<?php echo esc_attr($instance['text_description']); ?>"/></p>
        <p style="margin:2px">Button text: <input class="widefat" name="<?php echo $this->get_field_name('text_subscribe'); ?>" type="text" value="<?php echo esc_attr($instance['text_subscribe']); ?>"/></p>

        <p style="margin-top:10px;margin-bottom:6px"><strong>WIDGET COLORS:</strong></p>
        <p style="margin:2px">Body color: <input class="widefat" name="<?php echo $this->get_field_name('color_body'); ?>" type="text" value="<?php echo esc_attr($instance['color_body']); ?>"/></p>
        <p style="margin:2px">Header text color: <input class="widefat" name="<?php echo $this->get_field_name('color_header-txt'); ?>" type="text" value="<?php echo esc_attr($instance['color_header-txt']); ?>"/></p>
        <p style="margin:2px">Description text color: <input class="widefat" name="<?php echo $this->get_field_name('color_description-txt'); ?>" type="text" value="<?php echo esc_attr($instance['color_description-txt']); ?>"/></p>
        <p style="margin:2px">Button color: <input class="widefat" name="<?php echo $this->get_field_name('color_button-bg'); ?>" type="text" value="<?php echo esc_attr($instance['color_button-bg']); ?>"/></p>
        <p style="margin:2px">Button text color: <input class="widefat" name="<?php echo $this->get_field_name('color_button-txt'); ?>" type="text"  value="<?php echo esc_attr($instance['color_button-txt']); ?>"/></p>
        <p style="margin:2px">Button position: [left/center/right] <input class="widefat" name="<?php echo $this->get_field_name('button-position'); ?>" type="text"  value="<?php echo esc_attr($instance['button-position']); ?>"/></p>
        <p style="margin:2px">Input color: <input class="widefat" name="<?php echo $this->get_field_name('color_input-bg'); ?>" type="text" value="<?php echo esc_attr($instance['color_input-bg']); ?>"/></p>
        <p style="margin:2px">Input text color: <input class="widefat" name="<?php echo $this->get_field_name('color_input-txt'); ?>" type="text" value="<?php echo esc_attr($instance['color_input-txt']); ?>"/></p>
        <p style="margin:2px">Input label color: <input class="widefat" name="<?php echo $this->get_field_name('color_input-label'); ?>" type="text" value="<?php echo esc_attr($instance['color_input-label']); ?>"/></p>
        <p style="margin:2px">Text align: [left/center/right] <input class="widefat" name="<?php echo $this->get_field_name('text_align'); ?>" type="text" value="<?php echo esc_attr($instance['text_align']); ?>"/></p>
        <p style="margin:2px">Border radius: <input class="widefat" name="<?php echo $this->get_field_name('border_radius'); ?>" type="text" value="<?php echo esc_attr($instance['border_radius']); ?>"/></p>
        <p style="margin:2px">Widget padding: <input class="widefat" name="<?php echo $this->get_field_name('widget_padding'); ?>" type="text" value="<?php echo esc_attr($instance['widget_padding']); ?>"/></p>
        <p style="margin:2px">Information after adding to the list: <input class="widefat" name="<?php echo $this->get_field_name('text_action'); ?>" type="text" value="<?php echo esc_attr($instance['text_action']); ?>"/></p>
        <p style="margin-top:10px;margin-bottom:6px"><strong>LIST/LISTS:</strong></p>
        <p style="margin:2px;padding-bottom:30px"><?php echo $fulllistslist; ?></p>

        <p style="display: none;"><input style="width: 100%" name="<?php echo $this->get_field_name('selectedlists') ?>" type="eeswselectedlist" value="<?php echo $instance['selectedlists'] ?>"/></p>
        <?php

        if (isset($_POST['actualselectedlist'])) {
            $string_selectedlist = '';
            $post_array_selectedlist = $_POST['actualselectedlist'];

            foreach ($post_array_selectedlist as $new_post_val) {
                if (strlen($new_post_val) >= 2) {
                    $string_selectedlist .= $new_post_val . ',';
                }
            }
            $instance['selectedlists'] = $string_selectedlist;
        }

        wp_register_script('eesubscribe-widget-list', get_option('plugin_path') . '/elastic-email-shared/assets/js/eesf_lists.min.js', '', 1.0, false);
        wp_enqueue_script('eesubscribe-widget-list');

        if(strlen($instance['selectedlists']) >= 2) {
            wp_localize_script('eesubscribe-widget-list', 'eesw_data',
                array(
                    'oldselectedlists' => $instance['selectedlists'],
                    'actualidlists' => $fulllistslist_id_trim
                )
            );
       }
    }

    //save widget settings
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['text_header'] = strip_tags($new_instance['text_header']);
        $instance['text_description'] = strip_tags($new_instance['text_description']);
        $instance['text_subscribe'] = strip_tags($new_instance['text_subscribe']);
        $instance['color_body'] = strip_tags($new_instance['color_body']);
        $instance['color_header-txt'] = strip_tags($new_instance['color_header-txt']);
        $instance['color_description-txt'] = strip_tags($new_instance['color_description-txt']);
        $instance['color_button-bg'] = strip_tags($new_instance['color_button-bg']);
        $instance['color_button-txt'] = strip_tags($new_instance['color_button-txt']);
        $instance['button-position'] = strip_tags($new_instance['button-position']);
        $instance['color_input-bg'] = strip_tags($new_instance['color_input-bg']);
        $instance['color_input-txt'] = strip_tags($new_instance['color_input-txt']);
        $instance['color_input-label'] = strip_tags($new_instance['color_input-label']);
        $instance['text_align'] = strip_tags($new_instance['text_align']);
        $instance['border_radius'] = strip_tags($new_instance['border_radius']);
        $instance['widget_padding'] = strip_tags($new_instance['widget_padding']);
        $instance['text_action'] = strip_tags($new_instance['text_action']);
        $instance['selectedlists'] = $new_instance['selectedlists'];
        return $instance;
    }
}