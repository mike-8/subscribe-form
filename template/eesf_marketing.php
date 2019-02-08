<?php

wp_enqueue_script('eesubscribe-jquery');
wp_enqueue_script('eesubscribe-scripts');

wp_enqueue_style('eesubscribe-bootstrap-grid');
wp_enqueue_style('eesubscribe-css');


?>
<div class="col-12 col-md-12 col-lg-5 ee_marketing">
    <h2 class="ee_h2"><?php _e('Let us help you send better emails!', 'elastic-email-subscribe-form') ?></h2>
    <h4 class="ee_h4">
        <?php _e('If you are new to Elastic Email, feel free to visit our', 'elastic-email-subscribe-form') ?> <a href="https://elasticemail.com"><?php _e('website', 'elastic-email-subscribe-form') ?></a> <?php _e('and find out how our comprehensive set of tools will help you reach your goals or get premium email marketing tools at a fraction of what you\'re paying now!', 'elastic-email-subscribe-formr') ?>
    </h4>
    <hr>
    <h4 class="ee_h4"><?php _e('If you already use Elastic Email to send your emails, you can subscribe to our monthly updates to start receiving the latest email news, tips, best practices and more.', 'elastic-email-subscribe-form') ?></h4>

    <form action="" method="post" id="subscribe-inputs">
        <div class="row">
            <div class="form-group col-12">
                <input maxlength="60" name="name" id="name" type="text" size="20" placeholder="<?php _e('Please enter your name', 'elastic-email-subscribe-form') ?>"
                       class="form-control">
                <span class="form_error"><?php _e('Please enter your name.', 'elastic-email-subscribe-form') ?></span>
            </div>
            <div class="form-group col-12">
                <input maxlength="60" name="email" id="email" type="email" size="20"
                       placeholder="<?php _e('Please enter your email', 'elastic-email-subscribe-form') ?>" class="form-control">
                <span class="form_error"><?php _e('Please enter your email.', 'elastic-email-subscribe-form') ?></span>
                <span class="form_error" id="invalid_email"><?php _e('This email is not valid.', 'elastic-email-subscribe-form') ?></span>
            </div>
            <div class="form-group ee_button-subscribe col-12">
                <input type="submit" class="ee_button" id="submit_newsletter" value="Subscribe"/>
            </div>
        </div>
    </form>
    <div id="ee-success" class="col-12 hide ee-form_success">
        <div class="col-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 13.229 13.229">
                <path d="M6.615 0A6.606 6.606 0 0 0 0 6.615a6.606 6.606 0 0 0 6.615 6.614 6.606 6.606 0 0 0 6.614-6.614A6.606 6.606 0 0 0 6.615 0zm-.993 10.12L2.25 6.725l1.102-1.08 2.271 2.292 4.256-4.255 1.102 1.103z"
                      fill="#1b4"/>
            </svg>
        </div>
        <p style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;"><?php _e('Thank you for subscribing to our newsletter!', 'elastic-email-subscribe-form') ?></p>
        <p style="margin-top: 5px; margin-bottom: 0px;"><?php _e('You will start receiving our email marketing newsletter, as soon as you confirm your subscription.', 'elastic-email-subscribe-form') ?></p>
    </div>

    <br/>
    <hr>
    <br/>
    <h2 class="ee_h2"><?php _e('How we can help you?', 'elastic-email-subscribe-form') ?></h2>
    <h4 class="ee_h4"><?php _e('If you would like to boost your email marketing campaigns or improve your email delivery, check out our helpful guides to get you started!', 'elastic-email-subscribe-form') ?></h4>
    <ul style="padding-left: 40px;">
        <li type="circle"><a
                    href="https://elasticemail.com/resources/"><?php _e('Guides and resources', 'elastic-email-subscribe-form') ?></a>
        </li>
        <li type="circle"><a
                    href="https://elasticemail.com/resources/api/"><?php _e('Looking for code? Check our API', 'elastic-email-subscribe-form') ?></a>
        </li>
        <li type="circle"><a
                    href="https://elasticemail.com/contact/"><?php _e('Want to talk with a live person? Contact us', 'elastic-email-subscribe-form') ?></a>
        </li>
    </ul>
    <br/>
    <h4 class="ee_h4"><?php _e('Remember that in case of any other questions or feedback, you can always contact our friendly', 'elastic-email-subscribe-form') ?><a href="http://elasticemail.com/help"><?php _e('Support Team.', 'elastic-email-subscribe-form') ?></a></h4>

</div>