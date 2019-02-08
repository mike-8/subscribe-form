<?php
defined('EE_ADMIN_SUBSCRIBE') OR die('No direct access allowed.');

wp_enqueue_script('eesubscribe-jquery');
wp_enqueue_script('eesubscribe-scripts');
wp_enqueue_style('eesubscribe-bootstrap-grid');
wp_enqueue_style('eesubscribe-css');


if (isset($_GET['settings-updated'])):
    ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.', 'elastic-email-subscribe-form') ?></strong></p>
    </div>
<?php endif; ?>
<div id="eewp_plugin" class="row eewp_container" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-12 col-md-12 col-lg-7 ee_line">        
        <div class="ee_header">
            <div class="ee_logo">
                <?php echo '<img src="' . esc_url(plugins_url('/assets/images/icon.png', dirname(__FILE__))) . '" > ' ?>
            </div>
            <div class="ee_pagetitle">
                <h1 class="ee_h1"><?php _e('General Settings', 'elastic-email-subscribe-form') ?></h1>
            </div>
        </div>
        <h4 class="ee_h4">
            <?php _e('Welcome to Elastic Email WordPress Plugin!', 'elastic-email-subscribe-form') ?><br/> <?php _e('From now on, you can send your emails in the fastest and most reliable way!', 'elastic-email-subscribe-form') ?><br/>
            <?php _e('Just one quick step and you will be ready to rock your subscribers\' inbox.', 'elastic-email-subscribe-form') ?><br/><br/>
            <?php _e('Fill in the details about the main configuration of Elastic Email connections.', 'elastic-email-subscribe-form') ?>
        </h4>

        <form method="post" action="options.php">
            <?php
            settings_fields('ee_option_group');
            do_settings_sections('ee-settings');
            ?>
            <table class="form-table">
                <tbody>
                    <?php
                    ?>
                    <tr valign="top">
                        <th scope="row"><?php _e('Connection Test:', 'elastic-email-subscribe-form') ?></th>
                        <td> <span class="<?= (empty($error) === true) ? 'ee_success' : 'ee_error' ?>">
                                <?= (empty($error) === true) ? __('Connected', 'elastic-email-subscribe-form') : __('Connection error, check your API key. ', 'elastic-email-subscribe-form') . '<a href="https://elasticemail.com/support/user-interface/settings/smtp-api/" target="_blank">' . __('Read more', 'elastic-email-subscribe-form') . '</a>' ?>
                            </span></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Account status:', 'elastic-email-subscribe-form') ?></th>
                        <td>
                            <?php
                            if (isset($accountstatus)) {
                                if ($accountstatus === 1) {
                                    $accountstatusname = '<span class="ee_account-status-active">' . __('Active', 'elastic-email-subscribe-form') . '</span>';
                                } else {
                                    $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-subscribe-form') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile', 'elastic-email-subscribe-form') . '</a>' . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-subscribe-form') . '</span>';
                                }
                            } else {
                                $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-subscribe-form') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile', 'elastic-email-subscribe-form') . '</a>'  . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-subscribe-form') . '</span>';
                            }
                            echo $accountstatusname;
                            ?>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e('Account daily limit:', 'elastic-email-subscribe-form') ?></th>
                        <td>
                            <?php
    
                            if (isset($accountdailysendlimit)) {
                                if ($accountdailysendlimit === 0) {
                                    $accountlimitspan = '<span class="ee_standard-account">' . __('No limits', 'elastic-email-subscribe-form') . '</span>';
                                    $tooltip = __('Lucky you! Your account has no daily limits! Check out our other', 'elastic-email-subscribe-form') . ' <a href="http://elasticemail.com/pricing"> ' . __('pricing plans', 'elastic-email-subscribe-form') . ' </a> ' . __('and discover unlimited possibilities of your account.', 'elastic-email-subscribe-form') . '</a>';
                                }
                                if ($accountdailysendlimit === 5 || $accountdailysendlimit === -5) {
                                    $accountlimitspan = '<span class="ee_standard-account">5</span>';
                                    $tooltip = __('Oops! It seems your limit is 5. Fill out your profile to get unlimited possibilities.', 'elastic-email-subscribe-form');
                                }
                                if ($accountdailysendlimit == 50 || $accountdailysendlimit === 50) {
                                    $accountlimitspan = '<span class="ee_standard-account">50</span>';
                                    $tooltip = __('Ups! It seems your your limit is 50. Fill out your profile to get unlimited possibilities.', 'elastic-email-subscribe-form');
                                }
                                if ($accountdailysendlimit === 5000) {
                                    $accountlimitspan = '<span class="ee_standard-account">5000</span>';
                                    $tooltip = __('Your account is limited to 5,000 free emails per day. Check out our', 'elastic-email-subscribe-form') . ' <a href="http://elasticemail.com/pricing">' . __(' pricing plans', 'elastic-email-subscribe-form') . '</a>' . __('and take your campaigns to the next level!', 'elastic-email-subscribe-form') . '</a>';
                                }
                                if ($accountdailysendlimit != 0 && $accountdailysendlimit != 5 && $accountdailysendlimit != -5 && $accountdailysendlimit != 50 && $accountdailysendlimit != -50 && $accountdailysendlimit != 5000) {
                                    $accountlimitspan = '<span class="ee_standard-account">' . __('Custom: ') . $accountdailysendlimit . '</span>';
                                    $tooltip = __('Your account has a custom limit: ', 'elastic-email-subscribe-form') . $accountdailysendlimit;
                                }
                                if ($accountdailysendlimit === '') {
                                    $accountlimitspan = ' -------';
                                    $tooltip = __('Seems that you might have some limits on your account. Please check out your account settings to unlock more options.', 'elastic-email-subscribe-form');
                                }
                             
                            else {
                                    $accountlimit = '';
                                    $accountlimitspan = "-------";

                                    $tooltip = __('Seems that you might have some limits on your account. Please check out your account settings to unlock more options.', 'elastic-email-subscribe-form');
                            }};
                            echo  $accountlimitspan;
                            ?>

                            <div class="ee_tooltip"><?php echo '<img class = "ee_tootlip-icon" style = "max-width:15px;" src = "' . esc_url(plugins_url('/assets/images/info.svg', dirname(__FILE__))) . '" > ' ?>
                                <span class="ee_tooltiptext">
                                    <?php echo $tooltip; ?>
                                </span>
                            </div>
                        </td>
                        <?php
                        if (isset($issub) || isset($requiresemailcredits) || isset($emailcredits)) {
                            if ($emailcredits != 0) {
                                if ($issub == false || $requiresemailcredits == false) {
                                    echo '<tr valign="top"><th scope="row">' . __('Email Credits:', 'elastic-email-subscribe-form') . '</th><td>' . $emailcredits . '</td></tr>';
                                }
                            }
                        }

                        if (get_option('elastic-email-to-send-status') !== NULL) {
                            if (get_option('elastic-email-to-send-status') == 1) {
                                $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Account doesn\'t have enough credits', 'elastic-email-subscribe-form') . '</span>';
                            } elseif (get_option('elastic-email-to-send-status') == 2) {
                                $getaccountabilitytosendemail_single = '<span style="color: orange;">' . __('Account can send e-mails but only without the attachments', 'elastic-email-subscribe-form') . '</span>';
                            } elseif (get_option('elastic-email-to-send-status') == 3) {
                                $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Daily Send Limit Exceeded', 'elastic-email-subscribe-form') . '</span>';
                            } elseif (get_option('elastic-email-to-send-status') == 4) {
                                $getaccountabilitytosendemail_single = '<span style="color: green;">' . __('Account is ready to send e-mails', 'elastic-email-subscribe-form') . '</span>';
                            } else {
                                $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Check the account configuration', 'elastic-email-subscribe-form') . '</span>';
                            }
                        } else {
                            $getaccountabilitytosendemail_single = '---';
                        }
                        ?>
                    <tr valign="top">
                        <th scope="row"><?php _e('Credit status:', 'elastic-email-subscribe-form') ?></th>
                        <td>
                            <?php echo '<span>' . $getaccountabilitytosendemail_single . '</span>'; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>

        <?php if (empty($error) === false) { ?><?php _e('Do not have an account yet?', 'elastic-email-subscribe-form') ?><a href="https://elasticemail.com/account#/create-account" target="_blank" title="First 1000 emails for free."><?php _e('Create your account now', 'elastic-email-subscribe-form') ?></a>!<br/>
            <a href="http://elasticemail.com/transactional-email" target="_blank"> <?php _e('Tell me more about it', 'elastic-email-subscribe-form') ?></a>
        <?php } ?>
        <!-- add link -->
        <h4 class="ee_h4">
            <?php _e('Want to use this plugin in a different language version?', 'elastic-email-subscribe-form') ?><a href="http://support.elasticemail.com/"> <?php _e('Let us know or help us translate it!', 'elastic-email-subscribe-form') ?></a>
        </h4>
    </div>

    <?php
    include 'eesf_marketing.php';
    ?>

</div>