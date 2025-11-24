<?php
/**
 * Main Plugin Class
 *
 * The main class that initiates and runs the plugin.
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
 * Main Plugin Class
 *
 * This class handles the initialization of all plugin components.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Instance
	 *
	 * Holds the single instance of this class.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Plugin
	 */
	private static $_instance = null;

	/**
	 * Widgets Manager
	 *
	 * Holds the widgets manager instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var Widgets_Manager
	 */
	public $widgets_manager;

	/**
	 * Settings
	 *
	 * Holds the settings instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var Settings
	 */
	public $settings;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * Initialize the plugin by hooking into Elementor.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->init_components();
		$this->register_hooks();
	}

	/**
	 * Load Dependencies
	 *
	 * Load required plugin files.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function load_dependencies() {
		// Load the widgets manager.
		require_once BP_ELEMENTOR_WIDGETS_PATH . 'includes/class-widgets-manager.php';

		// Load the settings class.
		require_once BP_ELEMENTOR_WIDGETS_PATH . 'includes/class-settings.php';

		// Note: The abstract widget class is loaded in the Widgets_Manager
		// when needed, after Elementor's classes are available.
	}

	/**
	 * Initialize Components
	 *
	 * Initialize plugin components.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function init_components() {
		// Initialize settings.
		$this->settings = new Settings();

		// Initialize widgets manager.
		$this->widgets_manager = new Widgets_Manager();
	}

	/**
	 * Register Hooks
	 *
	 * Register all WordPress hooks.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function register_hooks() {
		// Register widget styles.
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_frontend_styles' ) );

		// Register widget scripts.
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'enqueue_frontend_scripts' ) );

		// Register editor scripts.
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );

		// Register custom widget categories.
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_categories' ) );
	}

	/**
	 * Enqueue Frontend Styles
	 *
	 * Load CSS files for the frontend.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_frontend_styles() {
		// Enqueue Font Awesome - load early with high priority.
		wp_enqueue_style(
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
			array(),
			'6.5.1'
		);
		
		wp_style_add_data( 'font-awesome', 'crossorigin', 'anonymous' );
		wp_style_add_data( 'font-awesome', 'integrity', 'sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==' );

		// Enqueue Slick Carousel CSS (base only, no theme).
		wp_enqueue_style(
			'slick-carousel',
			'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
			array(),
			'1.8.1'
		);

		// Note: NOT loading slick-theme.css - we use custom arrows with Font Awesome.

		wp_enqueue_style(
			'bp-elementor-widgets',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/css/frontend.min.css',
			array( 'font-awesome', 'slick-carousel' ),
			BP_ELEMENTOR_WIDGETS_VERSION
		);
	}

	/**
	 * Enqueue Frontend Scripts
	 *
	 * Load JavaScript files for the frontend.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		// Register Slick Carousel JS.
		wp_register_script(
			'slick-carousel',
			'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
			array( 'jquery' ),
			'1.8.1',
			true
		);

		wp_register_script(
			'bp-elementor-widgets',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/js/frontend.min.js',
			array( 'jquery' ),
			BP_ELEMENTOR_WIDGETS_VERSION,
			true
		);

		// Register combined widgets script.
		wp_register_script(
			'bp-elementor-widgets-widgets',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/js/widgets.min.js',
			array( 'jquery', 'slick-carousel', 'elementor-frontend' ),
			BP_ELEMENTOR_WIDGETS_VERSION,
			true
		);
	}

	/**
	 * Enqueue Editor Scripts
	 *
	 * Load JavaScript files for the Elementor editor.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script(
			'bp-elementor-widgets-editor',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/js/editor.min.js',
			array( 'jquery' ),
			BP_ELEMENTOR_WIDGETS_VERSION,
			true
		);
	}

	/**
	 * Register Widget Categories
	 *
	 * Register custom widget categories for organizing widgets in Elementor.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 * @return void
	 */
	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'bp-widgets',
			array(
				'title' => esc_html__( 'BP Widgets', 'bp-elementor-widgets' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}
}

