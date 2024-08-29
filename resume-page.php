<?php

/**
 * Plugin Name:             WP Resume Builder
 * Plugin URI:              https://github.com/Open-WP-Club/resume-builder
 * Description:             A plugin to create and display a resume using a shortcode
 * Version:                 0.0.1
 * Author:                  Gabriel Kanev
 * Author URI:              https://gkanev.com
 * License:                 GPL-2.0 License
 * Requires at least:       6.0
 * Requires PHP:            7.4
 * Tested up to:            6.6.2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// Define plugin constants
define('WP_RESUME_BUILDER_VERSION', '0.0.1');
define('WP_RESUME_BUILDER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_RESUME_BUILDER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once(WP_RESUME_BUILDER_PLUGIN_DIR . 'inc/settings.php');
require_once(WP_RESUME_BUILDER_PLUGIN_DIR . 'inc/shortcode.php');

// Initialize the plugin
function wp_resume_builder_init()
{
	// Initialize settings
	$settings = new WP_Resume_Builder_Settings();
	$settings->init();

	// Initialize shortcode
	$shortcode = new WP_Resume_Builder_Shortcode();
	$shortcode->init();
}
add_action('plugins_loaded', 'wp_resume_builder_init');

// Activation hook
function wp_resume_builder_activate()
{
	// Activation tasks (if any)
}
register_activation_hook(__FILE__, 'wp_resume_builder_activate');

// Deactivation hook
function wp_resume_builder_deactivate()
{
	// Deactivation tasks (if any)
}
register_deactivation_hook(__FILE__, 'wp_resume_builder_deactivate');
