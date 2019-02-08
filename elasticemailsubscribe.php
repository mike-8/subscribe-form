<?php

/*
 * Plugin Name: Elastic Email Subscribe Form
 * Text Domain: elastic-email-subscribe-form
 * Domain Path: /languages
 * Plugin URI: https://wordpress.org/plugins/elastic-email-subscribe-form/
 * Description: This plugin add subscribe widget to your page and integration with Elastic Email account.
 * Author: Elastic Email
 * Author URI: https://elasticemail.com
 * Version: 1.0.2
 * License: GPLv2 or later
 * Elastic Email Inc. for WordPress
 * Copyright (C) 2018
 */

/* Version check */
global $wp_version;
$exit_msg = 'ElasticEmail Sender requires WordPress 4.1 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress"> Please update!</a>';

if (version_compare($wp_version, "4.1", "<")) {
    exit($exit_msg);
}

require_once( dirname(__DIR__) . '/elastic-email-shared/vendor/autoload.php');
include 'script-copy.php';
/* ----------- ADMIN ----------- */
if (is_admin()) {

    /* deactivate */
    function elasticemailsubscribe_deactivate() {
        update_option('elastic-email-subscribe-status', false);
        update_option('elastic-email-credit-status', '<span style="color:green;font-weight:bold;">OK</span>');
    }

    register_deactivation_hook(__FILE__, 'elasticemailsubscribe_deactivate');


    /* uninstall */
    function elasticemailsubscribe_activate() {
        
        update_option('eesf_plugin_dir_name', plugin_basename(__DIR__));
        update_option('elastic-email-subscribe-status', true);
        update_option('ee-', 0);
        register_uninstall_hook(__FILE__, 'elasticemailsubscribe_uninstall');
    }

    register_activation_hook(__FILE__, 'elasticemailsubscribe_activate');

    function elasticemailsubscribe_uninstall() {
        
        /* delating shared files */
        $dir=plugin_dir_path(__DIR__).'/elastic-email-sender';
        if(get_option('elastic-email-sender-status')==false && !is_dir($dir))
       {         
    $dir =plugin_dir_path(__DIR__).'/elastic-email-shared/form'; /* Dummy folder - change for .'/elastic-email-shared/  */
$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
foreach ( $ri as $file ) {
    $file->isDir() ?  rmdir($file) : unlink($file);
}
    rmdir($dir);          
       }
        
        delete_option('elastic-email-subscribe-status');
        delete_option('elastic-email-credit-status');
        delete_option('ee_options');
        delete_option('ee_selectedlists_html');
        delete_option('ee_publicaccountid');
        delete_option('ee_enablecontactfeatures');
        delete_option('ee-listdata_json');
        delete_option('ee-apikey');
        unregister_widget('eeswidgetadmin');
    }

    require_once 'class/eesf_admin.php';
    $ee_admin = new eeadmin_subscribe(__DIR__);
}

//widget init
add_action('widgets_init', 'ees_register_widget');

function ees_register_widget() {
    require_once(dirname(__FILE__) . '/class/eesf_widget.php');
    register_widget('EESW_Widget');
}