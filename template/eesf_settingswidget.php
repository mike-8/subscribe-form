<?php
defined('EE_ADMIN_SUBSCRIBE') OR die('No direct access allowed.');

if (isset($_GET['settings-updated'])):
    ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.', 'elastic-email-subscribe-form') ?></strong></p>
    </div>
<?php endif; ?>
<div id="eewp_plugin" class="row eewp_container" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-12 col-md-12 col-lg-7 <?php if (empty($error) === TRUE) echo 'ee_line'; ?>"
         style="padding-right: 50px;">

        <section class="ee_containerfull">
            <div class="row ">
                <div class="col-8">
                    <div class="ee_logo">
                        <?php echo '<img src="' . esc_url(plugins_url('/assets/images/icon.png', dirname(__FILE__))) . '" > ' ?>
                    </div>
                    <div class="ee_pagetitle">
                        <h1 class="ee_h1"><?php _e('Widget', 'elastic-email-subscribe-form') ?></h1>
                    </div>
                </div>
                <div class="col-4 text-right" style="padding-left: 0px; padding-right: 0px;">
                    <?php if (empty($error) === TRUE) { ?>
                        <form action="<?php echo admin_url('/admin.php?page=elasticemail-widget-settings'); ?>"
                              method="post">
                            <input type="submit" class="ee_button" value="Sync"/>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section class="ee_containerfull">

            <!-- List header -->
            <div class="row listist_header">
                <div class="col-12 col-md-8"><strong><?php _e('Name', 'elastic-email-subscribe-form') ?></strong></div>
                <div class="col-12 col-md-2 text-center"><strong><?php _e('Count', 'elastic-email-subscribe-form') ?></strong></div>
                <div class="col-12 col-md-2 text-right"><strong><?php _e('Action', 'elastic-email-subscribe-form') ?></strong></div>
            </div>

            <?php
            if (isset($list)) {
                if (!isset($list->data)) {
                    $listdata_array = array();
                    foreach ($list as $value => $key) {
                        array_push($listdata_array, array($key->listname, $key->publiclistid));
                        ?>
                        <!-- List template -->
                        <div class="row listist">
                            <div class="col-12 col-md-8"><?php echo $key->listname; ?></div>
                            <div class="col-12 col-md-2 text-center"><?php echo $key->count; ?></div>
                            <div class="col-12 col-md-2 text-right">
                                <input listname="<?php echo $key->listname; ?>" type="submit" class="ee_linkbutton-del"
                                       value="Delete"/>
                            </div>
                        </div>

                    <?php }
                    update_option('ee-listdata_json', json_encode($listdata_array));
                } else {
                    // if is empty
                    echo '<div class="row listist"><div class="col-12">' . __('All contacts go to AllContacts list. Create your first list.', 'elastic-email-subscribe-form') . '</div></div>';
                    update_option('ee-listdata_json', '["",""]');
                }
            } else {
                // if lists is not exist
                echo '<div class="row listist"><div class="col-12 col-md-10">' . __('None', 'elastic-email-subscribe-form') . '</div><div class="col-12 col-md-1 text-center">----</div><div class="col-12 col-md-1 text-center">----</div></div>';
            } ?>

            <!-- New list input -->
            <form action="" method="post" id="eesf_addnewlist">
                <div class="row listist_add">
                    <div class="col-12 col-md-10">
                        <input class="ee-plugin-input" maxlength="60" name="eesw-name" id="eesf-listname"
                               placeholder="New list name">
                        <span id="eesf-error-add" class="form_error hide"
                              style="color:#EE9946"><?php _e('Please enter list name.', 'elastic-email-subscribe-form') ?></span>
                        <span id="eesf-success-add" class="form_success hide" style="color:#449D44"><?php _e('Your list has been added.', 'elastic-email-subscribe-form') ?></span>
                    </div>
                    <div class="col-12 col-md-2 text-right">
                        <input type="submit" id="submit_addnewlist" class="ee_linkbutton-add" value="Add"/>
                    </div>
                </div>
            </form>

        </section>


    </div>

    <?php include 'eesf_marketing.php'; ?>

</div>