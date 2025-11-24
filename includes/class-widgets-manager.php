<?php
/**
 * Widgets Manager
 *
 * Manages the registration and loading of all widgets.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

namespace BP_Elementor_Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widgets Manager Class
 *
 * Handles the registration of widgets and checks settings to enable/disable them.
 *
 * @since 1.0.0
 */
class Widgets_Manager {

	/**
	 * Available Widgets
	 *
	 * Array of all available widgets in the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array
	 */
	private $available_widgets = array();

	/**
	 * Constructor
	 *
	 * Initialize the widgets manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->define_available_widgets();
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Define Available Widgets
	 *
	 * Define the list of all available widgets with their metadata.
	 * This makes it easy to add new widgets in the future.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function define_available_widgets() {
		/**
		 * Array structure for each widget:
		 * 'key' => array(
		 *     'title'       => 'Widget Display Name',
		 *     'description' => 'Widget description',
		 *     'class'       => 'Widget_Class_Name',
		 *     'file'        => 'widget-file-name.php',
		 *     'demo_url'    => 'https://demo-url.com', // Optional
		 *     'is_pro'      => false, // For future pro features
		 * )
		 */
		$this->available_widgets = array(
			'info-box' => array(
				'title'       => esc_html__( 'Info Box', 'bp-elementor-widgets' ),
				'description' => esc_html__( 'Display information in a stylish box with icon, title, and description.', 'bp-elementor-widgets' ),
				'class'       => 'Info_Box',
				'file'        => 'info-box.php',
				'icon'        => 'eicon-info-box',
				'is_pro'      => false,
			),
			'countdown-timer' => array(
				'title'       => esc_html__( 'Countdown Timer', 'bp-elementor-widgets' ),
				'description' => esc_html__( 'Create urgency with a customizable countdown timer featuring recurring options.', 'bp-elementor-widgets' ),
				'class'       => 'Countdown_Timer',
				'file'        => 'countdown-timer.php',
				'icon'        => 'eicon-countdown',
				'is_pro'      => false,
			),
			'gallery' => array(
				'title'       => esc_html__( 'Gallery Carousel', 'bp-elementor-widgets' ),
				'description' => esc_html__( 'Create beautiful image galleries with Slick Carousel and lightbox.', 'bp-elementor-widgets' ),
				'class'       => 'Gallery',
				'file'        => 'gallery.php',
				'icon'        => 'eicon-gallery-grid',
				'is_pro'      => false,
			),
			// Add more widgets here as you build them:
			// 'pricing-table' => array(
			//     'title'       => esc_html__( 'Pricing Table', 'bp-elementor-widgets' ),
			//     'description' => esc_html__( 'Create beautiful pricing tables.', 'bp-elementor-widgets' ),
			//     'class'       => 'Pricing_Table',
			//     'file'        => 'pricing-table.php',
			//     'icon'        => 'eicon-price-table',
			//     'is_pro'      => false,
			// ),
		);

		/**
		 * Filter available widgets.
		 *
		 * Allows developers to add or modify available widgets.
		 *
		 * @since 1.0.0
		 * @param array $available_widgets Array of available widgets.
		 */
		$this->available_widgets = apply_filters( 'bp_elementor_widgets_available', $this->available_widgets );
	}

	/**
	 * Get Available Widgets
	 *
	 * Returns the array of all available widgets, sorted alphabetically by title.
	 * Used by the settings page to display the widget list.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Array of available widgets.
	 */
	public function get_available_widgets() {
		$widgets = $this->available_widgets;
		
		// Sort widgets alphabetically by title
		uasort( $widgets, function( $a, $b ) {
			return strcmp( $a['title'], $b['title'] );
		} );
		
		return $widgets;
	}

	/**
	 * Register Widgets
	 *
	 * Register all enabled widgets with Elementor.
	 * Only registers widgets that are enabled in settings.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		// Load the abstract widget class (after Elementor is loaded).
		require_once BP_ELEMENTOR_WIDGETS_PATH . 'includes/abstracts/class-base-widget.php';

		// Get enabled widgets from settings.
		$enabled_widgets = get_option( 'bp_elementor_enabled_widgets', array_keys( $this->available_widgets ) );

		// If it's a fresh install, enable all widgets by default.
		if ( false === get_option( 'bp_elementor_enabled_widgets' ) ) {
			$enabled_widgets = array_keys( $this->available_widgets );
			update_option( 'bp_elementor_enabled_widgets', $enabled_widgets );
		}

		// Loop through available widgets and register enabled ones.
		foreach ( $this->available_widgets as $widget_key => $widget_data ) {
			// Check if widget is enabled.
			if ( ! in_array( $widget_key, $enabled_widgets, true ) ) {
				continue;
			}

			// Build the widget file path.
			$widget_file = BP_ELEMENTOR_WIDGETS_PATH . 'widgets/' . $widget_data['file'];

			// Check if widget file exists.
			if ( ! file_exists( $widget_file ) ) {
				continue;
			}

			// Include the widget file.
			require_once $widget_file;

			// Build the full widget class name with namespace.
			$widget_class = 'BP_Elementor_Widgets\\Widgets\\' . $widget_data['class'];

			// Check if class exists.
			if ( ! class_exists( $widget_class ) ) {
				continue;
			}

			// Register the widget.
			$widgets_manager->register( new $widget_class() );
		}
	}

	/**
	 * Is Widget Enabled
	 *
	 * Check if a specific widget is enabled.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $widget_key The widget key to check.
	 * @return bool True if enabled, false otherwise.
	 */
	public function is_widget_enabled( $widget_key ) {
		$enabled_widgets = get_option( 'bp_elementor_enabled_widgets', array_keys( $this->available_widgets ) );
		return in_array( $widget_key, $enabled_widgets, true );
	}
}

