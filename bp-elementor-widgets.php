<?php
/**
 * Plugin Name: BP Elementor Widgets
 * Plugin URI: https://yourwebsite.com/
 * Description: A collection of custom Elementor widgets to enhance your website building experience.
 * Version: 1.0.0
 * Author: BP
 * Author URI: https://yourwebsite.com/
 * Text Domain: bp-elementor-widgets
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'BP_ELEMENTOR_WIDGETS_VERSION', '1.0.0' );

/**
 * Plugin directory path.
 */
define( 'BP_ELEMENTOR_WIDGETS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin directory URL.
 */
define( 'BP_ELEMENTOR_WIDGETS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin basename.
 */
define( 'BP_ELEMENTOR_WIDGETS_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Minimum Elementor Version required.
 */
define( 'BP_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION', '3.0.0' );

/**
 * Minimum PHP Version required.
 */
define( 'BP_ELEMENTOR_MINIMUM_PHP_VERSION', '7.4' );

/**
 * Load the plugin text domain for translation.
 *
 * @since 1.0.0
 * @return void
 */
function bp_elementor_widgets_load_textdomain() {
	load_plugin_textdomain( 'bp-elementor-widgets', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'bp_elementor_widgets_load_textdomain' );

/**
 * Initialize the plugin.
 *
 * Check for required PHP and Elementor versions.
 * Load plugin core class.
 *
 * @since 1.0.0
 * @return void
 */
function bp_elementor_widgets_init() {
	
	// Check if Elementor is installed and activated.
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'bp_elementor_widgets_fail_load_elementor' );
		return;
	}

	// Check for required Elementor version.
	if ( ! version_compare( ELEMENTOR_VERSION, BP_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
		add_action( 'admin_notices', 'bp_elementor_widgets_fail_load_version' );
		return;
	}

	// Check for required PHP version.
	if ( version_compare( PHP_VERSION, BP_ELEMENTOR_MINIMUM_PHP_VERSION, '<' ) ) {
		add_action( 'admin_notices', 'bp_elementor_widgets_fail_php_version' );
		return;
	}

	// Require the main plugin class.
	require_once BP_ELEMENTOR_WIDGETS_PATH . 'includes/class-plugin.php';

	// Instantiate the main plugin class.
	\BP_Elementor_Widgets\Plugin::instance();
}
add_action( 'plugins_loaded', 'bp_elementor_widgets_init', 20 );

/**
 * Admin notice for missing Elementor.
 *
 * Warning when the site doesn't have Elementor installed or activated.
 *
 * @since 1.0.0
 * @return void
 */
function bp_elementor_widgets_fail_load_elementor() {
	$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
		esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'bp-elementor-widgets' ),
		'<strong>' . esc_html__( 'BP Elementor Widgets', 'bp-elementor-widgets' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor', 'bp-elementor-widgets' ) . '</strong>'
	);

	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}

/**
 * Admin notice for minimum Elementor version.
 *
 * Warning when the site doesn't have the minimum required Elementor version.
 *
 * @since 1.0.0
 * @return void
 */
function bp_elementor_widgets_fail_load_version() {
	$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
		esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bp-elementor-widgets' ),
		'<strong>' . esc_html__( 'BP Elementor Widgets', 'bp-elementor-widgets' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor', 'bp-elementor-widgets' ) . '</strong>',
		BP_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION
	);

	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}

/**
 * Admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 * @return void
 */
function bp_elementor_widgets_fail_php_version() {
	$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
		esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bp-elementor-widgets' ),
		'<strong>' . esc_html__( 'BP Elementor Widgets', 'bp-elementor-widgets' ) . '</strong>',
		'<strong>' . esc_html__( 'PHP', 'bp-elementor-widgets' ) . '</strong>',
		BP_ELEMENTOR_MINIMUM_PHP_VERSION
	);

	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}

