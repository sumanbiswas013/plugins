<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/sumanbiswas013/
 * @since      1.0.0
 *
 * @package    Custom_Login_Sso
 * @subpackage Custom_Login_Sso/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
$log_content = file_get_contents(plugins_url('/').'custom-login-sso/log/login.log')
?>
<div class="wrap">
    <h2>Login Log</h2>
    <?php echo esc_html($log_content); ?>
</div>