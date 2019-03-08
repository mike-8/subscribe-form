<?php

define('EE_ADMIN_SUBSCRIBE', true);

/**
 * Description of eeadmin
 *
 * @author ElasticEmail
 */
class eeadmin_subscribe
{

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $defaultOptions = array('ee_enable' => 'no', 'ee_apikey' => ''),
        $options,
        $config,
        $initAPI = false;
    public $theme_path, $publicid;

    /**
     * Start up
     */
    public function __construct($pluginpath)
    {
        $this->theme_path = $pluginpath;
        if (get_option('elastic-email-sender-status') == false) {
            add_action('admin_menu', array($this, 'add_menu'));
        }

        add_action('admin_init', array($this, 'init_options'));
        $this->options = get_option('ee_options', $this->defaultOptions);
        add_action('delLists', array($this, 'delLists'), get_option('ee_delListName'));

        $configuration = new \ElasticEmailClient\ApiConfiguration([
            'apiUrl' => 'https://api.elasticemail.com/v2/',
            'apiKey' => $this->options['ee_apikey']
        ]);
        update_option('api_conf',$configuration);
    }

    //Added admin menu
    public function add_menu()
    {
        add_action('admin_enqueue_scripts', array($this, 'custom_admin_scripts'));
        add_menu_page('Elastic Email Subscribe', 'Elastic Email Subscribe', 'manage_options', 'elasticemail-settings', array($this, 'show_settings'), plugins_url('elastic-email-shared/assets/images/icon.png', dirname(__DIR__)));
        add_submenu_page('elasticemail-settings', 'Settings', 'Settings', 'manage_options', 'elasticemail-widget-settings', array($this, 'show_widgetsettings'));
    }

    //Added custom admin scripts
    public function custom_admin_scripts()
    {
        if (is_admin()) {
            $plugin_path = plugins_url();
            update_option('plugin_path', $plugin_path);

            wp_register_script('eesubscribe-jquery', $plugin_path . '/elastic-email-shared/assets/js/jquery.min.js', '', 3.3, true);
            wp_register_script('eesubscribe-scripts', $plugin_path . '/elastic-email-shared/assets/js/eesf_scripts.min.js', '', 1.0, true);

            wp_register_style('eesubscribe-bootstrap-grid', $plugin_path . '/elastic-email-shared/assets/css/bootstrap-grid.min.css', '', 4.1, false);
            wp_register_style('eesubscribe-css', $plugin_path . '/elastic-email-shared/assets/css/eesf_admin.css', '', 1.0, false);

            wp_localize_script('eesubscribe-scripts', 'eesf_php_data',
                array(
                    'apikey' => get_option('ee-apikey'),
                    'publicAccountID' => get_option('ee_publicaccountid'),
                    'createEmptyList' => true,
                    'allContacts' => true
                )
            );
        }
    }

//Load Elastic Email settings
    public function show_settings()
    {
        $this->initAPI();
        
        $configuration = get_option('api_conf');
        
        try {

            
            $accountAPI = new \ElasticEmailApi\Account($configuration);

            $error = null;
            $account = $accountAPI->Load();
            $this->statusToSendEmail();
        } catch (ElasticEmailApi\ApiException $e) {
            $error = $e->getMessage();
            $account = array();
            $statusToSendEmail = array();

        }
      

        $accountstatus = '';
        if (isset($account->statusnumber)) {
            if ($account->statusnumber > 0) {
                $accountstatus = $account->statusnumber;
            } else {
                $accountstatus = 'Please conect to Elastic Email API';
            }
        }

        if (isset($account->email)) {
            update_option('ee_accountemail', $account->email);
        }

        $accountdailysendlimit = '';
        if (isset($account->actualdailysendlimit)) {
            $accountdailysendlimit = $account->actualdailysendlimit;
        }

        if (isset($account->publicaccountid)) {
            $this->publicid = $account->publicaccountid;
            update_option('ee_publicaccountid', $this->publicid);
        }

        if (isset($account->enablecontactfeatures)) {
            update_option('ee_enablecontactfeatures', $account->enablecontactfeatures);
        }

        if (isset($account->requiresemailcredits)) {
            $requiresemailcredits = $account->requiresemailcredits;
        }

        if (isset($account->emailcredits)) {
            $emailcredits = $account->emailcredits;
        }

        if (isset($account->requiresemailcredits)) {
            $requiresemailcredits = $account->requiresemailcredits;
        }
        
        if (isset($account->apikey)) {
            update_option('ee-apikey', $account->apikey);
        }

        if (isset($account->issub)) {
            $issub = $account->issub;
        }

        if (get_option('ee_accountemail') !== null) {
            if (get_option('ee_accountemail') !== get_option('ee_accountemail_2')) {
                $this->addToUserList();
            }
        }
        
        require_once($this->theme_path . '/template/eesf_settingsadmin.php');
        return;
    }

    public function addToUserList()
    {
        try {
            $addToUserListAPI = new \ElasticEmailApi\Contact($this->config);
            $error = null;
            $sourceUrl = get_site_url();
            $addToUserList = $addToUserListAPI->Add('d0bcb758-a55c-44bc-927c-34f48d5db864', get_option('ee_accountemail'), array('55c8fa37-4c77-45d0-8675-0937d034c605'), array(), 'A', $sourceUrl, null, null, null, null, null, null, false, null, array(), null);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $addToUserList = array();
        }
        update_option('ee_accountemail_2', get_option('ee_accountemail'));
    }

    public function statusToSendEmail()
    {
        $this->initAPI();
        try {

            $statusToSendEmailAPI = new \ElasticEmailApi\Account($this->config);
            $error = null;
            $statusToSendEmail = $statusToSendEmailAPI->GetAccountAbilityToSendEmail();
            update_option('elastic-email-to-send-status', $statusToSendEmail);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $statusToSendEmail = array();
        }
        return;
    }

    public function show_widgetsettings()
    {
        $this->initAPI();
        try {
            $listAPI = new \ElasticEmailApi\EEList($this->config);
            $error = null;
            $list = $listAPI->EElist();
        } catch (ElasticEmailClient\ApiException $e) {
            $error = $e->getMessage();
            $list = array();
        }
        

        require($this->theme_path . '/template/eesf_settingswidget.php');
        return;
    }

    //Initialization Elastic Email API
    public function initAPI()
    {
        if ($this->initAPI === true) {
            return;
        }

        //Loads Elastic Email Client
        require_once( dirname(__DIR__) . '/../elastic-email-shared/vendor/autoload.php');

       $config = new \ElasticEmailClient\ApiConfiguration([
            'apiUrl' => 'https://api.elasticemail.com/v2/',
            'apiKey' => $this->options['ee_apikey']
        ]);

        $client = new \ElasticEmailClient\ElasticClient($config);
        $this->config = $config;
        update_option('config',$config);
        if (empty($this->options['ee_apikey']) === false) {
            $config -> SetApiKey($this->options['ee_apikey']);
        }

        $this->initAPI = true;
    }

    //Initialization custom options
    public function init_options()
    {
        register_setting(
            'ee_option_group', // Option group
            'ee_options', // Option name
            array($this, 'valid_options')   // Santize Callback
        );
        //INIT SECTION
        add_settings_section('setting_section_id', null, null, 'ee-settings');
        //INIT FIELD
        add_settings_field('ee_enable', 'Select mailer:', array($this, 'enable_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_enable'));
        add_settings_field('ee_apikey', 'Elastic Email API Key:', array($this, 'input_apikey'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_apikey', 'width' => 280));
        add_settings_field('ee_emailtype', 'Email type:', array($this, 'emailtype_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_emailtype'));

        //saving the option whether the plugin is active
        add_option('elastic-email-subscribe-status', is_plugin_active('ElasticEmailSubscribe/elasticemailsubscribe.php'));
    }

    /**
     * Validation plugin options during their update data
     * @param type $input
     * @return type
     */
    public function valid_options($input)
    {
        //If api key have * then use old api key
        if (strpos($input['ee_apikey'], '*') !== false) {
            $input['ee_apikey'] = $this->options['ee_apikey'];
        } else {
            $input['ee_apikey'] = sanitize_key($input['ee_apikey']);
        }

        if ($input['ee_enable'] !== 'yes') {
            $input['ee_enable'] = 'no';
        }
        return $input;
    }

    /**
     * Get the apikey option and print one of its values
     */
    public function input_apikey($arg)
    {
        $apikey = $this->options[$arg['input_name']];
        if (empty($apikey) === false) {
            $apikey = substr($apikey, 0, 15) . '***************';
        }
        printf('<input type="text" id="title" name="ee_options[' . $arg['input_name'] . ']" value="' . $apikey . '" style="%s"/>', (isset($arg['width']) && $arg['width'] > 0) ? 'width:' . $arg['width'] . 'px' : '');
    }

    //Displays the settings items
    public function enable_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $valuel = 'no';
        } else {
            $valuel = $this->options[$arg['input_name']];
        }

        echo '<div style="margin-bottom:15px;"><label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="yes" ' . (($valuel === 'yes') ? 'checked' : '') . '/><span>Send all WordPress emails via Elastic Email API.</span><label></div>';
        echo '<label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="no"  ' . (($valuel === 'no') ? 'checked' : '') . '/><span>Use the defaults Wordpress function to send emails.</span><label>';
    }

    /**
     * Displays the settings email type
     */
    public function emailtype_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $type = 'marketing';
            update_option('ee_send-email-type', false);
        } else {
            $type = $this->options[$arg['input_name']];
            if ($type === 'marketing') {
                update_option('ee_send-email-type', false);
            } else {
                update_option('ee_send-email-type', true);
            }
        }
        echo '<div style="margin-bottom:15px;"><label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="marketing" ' . (($type === 'marketing') ? 'checked' : '') . '/><span>' . __('Marketing') . '</span><label></div>';
        echo '<label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="transactional"  ' . (($type === 'transactional') ? 'checked' : '') . '/><span>' . __('Transactional', 'elastic-email-sender') . '</span><label>';
    }

}
