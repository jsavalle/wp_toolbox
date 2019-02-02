<?php

/*
Plugin Name: Extra Toolbox 
Plugin URI: 
Description: Toolbox of custom calls
Author:JS
Version: 0.0.1
Author URI:
*/


add_action('admin_menu', 'toolbox_menu');

function toolbox_menu(){
  add_menu_page('Toolbox Page', 'Extra Toolbox', 'manage_options', 'toolbox-slug', 'toolbox_admin_page');

}

function toolbox_admin_page() {

  // This function creates the output for the admin page.
  // It also checks the value of the $_POST variable to see whether
  // there has been a form submission. 

  // The check_admin_referer is a WordPress function that does some security
  // checking and is recommended good practice.

  // General check for user permissions.
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient gold to access this page.')    );
  }

  // Start building the page

  echo '<div class="wrap">';

  echo '<h2>Toolbox</h2>';

  // Check whether the button has been pressed AND also check the nonce
  if (isset($_POST['test_button']) && check_admin_referer('test_button_clicked')) {
    // the button has been pressed AND we've passed the security check
    test_button_action();
  }

  echo '<form action="options-general.php?page=toolbox-slug" method="post">';

  // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('test_button_clicked');
  echo '<input type="hidden" value="true" name="test_button" />';
  submit_button('Call Function');
  echo '</form>';

  echo '</div>';

}

function test_button_action()
{
  echo '<div id="message" class="updated fade"><p>'
    .'The "Call Function" button was clicked.' . '</p></div>';

  $path = WP_TEMP_DIR . '/test-button-log.txt';

  $handle = fopen($path,"w");

  if ($handle == false) {
    echo '<p>Could not write the log file to the temporary directory: ' . $path . '</p>';
  }
  else {
    echo '<p>Log of button click written to: ' . $path . '</p>';

    fwrite ($handle , "Call Function button clicked on: " . date("D j M Y H:i:s", time())); 
    fclose ($handle);
  }
}  
?>
