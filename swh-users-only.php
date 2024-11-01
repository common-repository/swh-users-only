<?php

/*
  Plugin Name: SWH Users Only
  Plugin URI: http://SinaWebHost.ir/plugins/swh-users-only/
  Description: SWH Users Only allows you to hide some parts of your content from not logged in users using shortcode.<br>[swh-users-only]Text, Content, Image, Video, Shortcode, HTML & etc.[/swh-users-only]
  Version: 1.0
  Author: Sina Saeedi
  Author URI: http://SinaSaeedi.ir/
 */

// Definitions
defined('ABSPATH') or die('You are cheating, don\'t you?!');

// Includes
require_once('settings.php');

// Languages
add_action('plugins_loaded', 'swh_uo_language');

function swh_uo_language() {
    load_plugin_textdomain('swh_uo', false, dirname(plugin_basename(__FILE__)) . '/content/languages/');
}

// Shortcode
add_shortcode('swh-users-only', 'swh_users_only_shortcode');

function swh_users_only_shortcode($attr, $content = null) {
    if (is_user_logged_in()) {
        return do_shortcode($content);
    } else {
        global $swhUsersOnlyCount;
        $options = get_option('swh_uo_options');
        if ($options['default'] == 'wp_login_form' && $swhUsersOnlyCount < 1) {

            if (isset($options['show_only_one_login_form'])) {
                $swhUsersOnlyCount++;
            } else {
                $swhUsersOnlyCount = 0;
            }

            if (isset($options['show_replacement_text_before_login_form'])) {
                $output = $options['replacement_text'];
            } else {
                $output = '';
            }

            if (isset($_GET['login'])) {
                $get = $_GET['login'];
            } else {
                $get = '';
            }

            if ($get == 'failed') {
                $output .= "<p style='color: red;'>" . __('Login failed! Please try again.', 'swh_uo') . "</p>";
            }

            return $output . wp_login_form(array('echo' => false));
        } else {
            return $options['replacement_text'];
        }
    }
}

// Prevent redirect user to wp-login.php on login failiure
add_action('wp_login_failed', 'swh_uo_login_fail');

function swh_uo_login_fail($username) {
    $referrer = $_SERVER['HTTP_REFERER'];

    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        if (strstr($referrer, 'login=failed')) {
            wp_redirect($referrer);
        } else {
            if (strpos($referrer, '?') !== false) {
                wp_redirect($referrer . '&login=failed');
            } else {
                wp_redirect($referrer . '?login=failed');
            }
        }
        exit;
    }
}

// Enqueue scripts
add_action('admin_enqueue_scripts', 'swh_uo_admin_scripts');

function swh_uo_admin_scripts() {
    if (is_admin()) {
        wp_enqueue_style('swh-admin-style', plugin_dir_url(__FILE__) . 'content/css/swh-admin-style.css');
    }
}


// Activation
register_activation_hook(__FILE__, 'swh_shop_activation');

function swh_shop_activation() {

	// Default Values
	$options = get_option('swh_uo_options');
	$site_url = get_bloginfo('wpurl') . "/wp-login.php";
	if (!$options) {
		add_option('swh_uo_options', array(
			'default' => 'wp_login_form',
			'replacement_text' => "<a href=\"" . $site_url . "\">" . __('Login to see the content.', 'swh_uo') . "</a>",
			'show_replacement_text_before_login_form' => '1',
			'show_only_one_login_form' => '1'
		));
	}
}