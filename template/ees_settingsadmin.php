<?php
defined('EE_ADMIN') OR die('No direct access allowed.');

wp_enqueue_script('eesender-jquery');
wp_enqueue_script('eesender-scripts');
wp_enqueue_style('eesender-bootstrap-grid');
wp_enqueue_style('eesender-css');
if (isset($_GET['settings-updated'])):
    ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.', 'elastic-email-sender') ?></strong></p>
    </div>
<?php endif; ?>
<div id="eewp_plugin" class="row eewp_container" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-12 col-md-12 col-lg-7 ee_line">
        <div class="ee_header">
            <div class="ee_logo">
                <?php echo '<img src="' . esc_url(plugins_url('elastic-email-shared/assets/images/icon.png', dirname(__DIR__))) . '" > ' ?>
            </div>
            <div class="ee_pagetitle">
                <h1><?php _e('General Settings', 'elastic-email-sender') ?></h1>
            </div>
        </div>
        <h4 class="ee_h4">
            <?php _e('Welcome to Elastic Email WordPress Plugin!', 'elastic-email-sender') ?><br/> <?php _e('From now on, you can send your emails in the fastest and most reliable way!', 'elastic-email-sender') ?><br/>
            <?php _e('Just one quick step and you will be ready to rock your subscribers\' inbox.', 'elastic-email-sender') ?><br/><br/>
            <?php _e('Fill in the details about the main configuration of Elastic Email connections.', 'elastic-email-sender') ?>
        </h4>

        <form method="post" action="options.php">
            <?php
            settings_fields('ee_option_group');

            do_settings_sections('ee-settings');
            ?>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('Connection Test:', 'elastic-email-sender') ?></th>
                        <td> <span class="<?= (empty($error) === true) ? 'ee_success' : 'ee_error' ?>">
                                <?= (empty($error) === true) ? __('Connected', 'elastic-email-sender') : __('Connection error, check your API key. ', 'elastic-email-sender') . '<a href="https://elasticemail.com/support/user-interface/settings/smtp-api/" target="_blank">' . __('Read more', 'elastic-email-sender') . '</a>' ?>
                            </span></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Account status:', 'elastic-email-sender') ?></th>
                        <td>
                            <?php
                            if (isset($accountstatus)) {
                                if ($accountstatus == 1) {
                                    $accountstatusname = '<span class="ee_account-status-active">' . __('Active', 'elastic-email-sender') . '</span>';
                                } else {
                                    $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-sender') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile', 'elastic-email-sender') . '</a>' . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-sender') . '</span>';
                                }
                            } else {
                                $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-sender') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile','elastic-email-sender') . '</a>' . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-sender') . '</span>';
                            }
                            echo $accountstatusname;
                            ?>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e('Account daily limit:', 'elastic-email-sender') ?></th>
                        <td>
                            <?php
                            if (isset($accountdailysendlimit)) {
                                echo $accountdailysendlimit;
                            } else {
                                echo ' -------';
                            }
                            ?>
                        </td>
                    </tr>

                    <?php
                    if (isset($issub) || isset($requiresemailcredits) || isset($emailcredits)) {
                        if ($emailcredits != 0) {
                            if ($issub == false || $requiresemailcredits == false) {
                                echo '<tr valign="top"><th scope="row">' . __('Email Credits:', 'elastic-email-sender') . '</th><td>' . $emailcredits . '</td></tr>';
                            }
                        }
                    }
                   
                    if ($statusToSendEmail !== NULL) {
                        if ($statusToSendEmail == 1) {
                            $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Account doesn\'t have enough credits', 'elastic-email-sender') . '</span>';
                        } elseif ($statusToSendEmail == 2) {
                            $getaccountabilitytosendemail_single = '<span style="color: orange;">' . __('Account can send e-mails but only without the attachments', 'elastic-email-sender') . '</span>';
                        } elseif ($statusToSendEmail == 3) {
                            $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Daily Send Limit Exceeded', 'elastic-email-sender') . '</span>';
                        } elseif ($statusToSendEmail == 4) {
                            $getaccountabilitytosendemail_single = '<span style="color: green;">' . __('Account is ready to send e-mails', 'elastic-email-sender') . '</span>';
                        } else {
                            $getaccountabilitytosendemail_single = '<span style="color: red;">' . __('Check the account configuration', 'elastic-email-sender') . '</span>';
                        }
                    } else {
                        $getaccountabilitytosendemail_single = '---';
                    }
                    ?>
                    <tr valign="top">
                        <th scope="row"><?php _e('Credit status:', 'elastic-email-sender') ?></th>
                        <td>
                            <?php echo '<span>' . $getaccountabilitytosendemail_single . '</span>'; ?>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="button_section">
            <?php submit_button(); ?></div><div class="button_section"> <?php $this->update_button(); ?></div>
        </form>


        <?php if (empty($error) === false) { ?><?php _e('Do not have an account yet?', 'elastic-email-sender') ?> <a href="https://elasticemail.com/account#/create-account" target="_blank" title="First 1000 emails for free."><?php _e('Create your account now', 'elastic-email-sender') ?></a>!<br/>
            <a href="http://elasticemail.com/transactional-email" target="_blank"><?php _e('Tell me more about it', 'elastic-email-sender') ?></a>
        <?php } ?>
        <!-- add link -->
        <h4>
            <?php _e('Want to use this plugin in a different language version?', 'elastic-email-sender') ?> <a href="http://support.elasticemail.com/"><?php _e('Let us know or help us translate it!', 'elastic-email-sender') ?></a>
        </h4>
        <div class="">
            <h4 class="ee_h4footer">
                <?php _e('Share your experience of using Elastic Email WordPress Plugin by', 'elastic-email-sender') ?> <a href="https://wordpress.org/support/plugin/elastic-email-sender/reviews/#new-post"><?php _e('rating us here.', 'elastic-email-sender') ?></a> <?php _e('Thanks!', 'elastic-email-sender') ?>
            </h4>
        </div>
    </div>

    <?php
    include 'ees_marketing.php';
    ?>

</div>