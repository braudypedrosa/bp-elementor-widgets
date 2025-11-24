<?php
/**
 * Settings Class
 *
 * Handles the plugin settings page in WordPress admin.
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
 * Settings Class
 *
 * Creates and manages the settings page where users can enable/disable widgets.
 *
 * @since 1.0.0
 */
class Settings {

	/**
	 * Constructor
	 *
	 * Initialize the settings page.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_ajax_bp_save_widget_settings', array( $this, 'ajax_save_settings' ) );
	}

	/**
	 * Add Admin Menu
	 *
	 * Add the settings page to WordPress admin menu.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function add_admin_menu() {
		add_menu_page(
			esc_html__( 'BP Elementor Widgets', 'bp-elementor-widgets' ),
			esc_html__( 'BP Widgets', 'bp-elementor-widgets' ),
			'manage_options',
			'bp-elementor-widgets',
			array( $this, 'render_settings_page' ),
			'dashicons-layout',
			59
		);
	}

	/**
	 * Register Settings
	 *
	 * Register plugin settings with WordPress.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'bp_elementor_widgets_settings',
			'bp_elementor_enabled_widgets',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_enabled_widgets' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Sanitize Enabled Widgets
	 *
	 * Sanitize the array of enabled widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $input Array of widget keys.
	 * @return array Sanitized array of widget keys.
	 */
	public function sanitize_enabled_widgets( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		// Get available widgets to validate against.
		$widgets_manager   = Plugin::instance()->widgets_manager;
		$available_widgets = $widgets_manager->get_available_widgets();

		// Only keep valid widget keys.
		$sanitized = array();
		foreach ( $input as $widget_key ) {
			if ( isset( $available_widgets[ $widget_key ] ) ) {
				$sanitized[] = sanitize_key( $widget_key );
			}
		}

		return $sanitized;
	}

	/**
	 * Enqueue Admin Assets
	 *
	 * Load CSS and JavaScript for the settings page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $hook Current admin page hook.
	 * @return void
	 */
	public function enqueue_admin_assets( $hook ) {
		// Only load on our settings page.
		if ( 'toplevel_page_bp-elementor-widgets' !== $hook ) {
			return;
		}

		// Enqueue admin styles.
		wp_enqueue_style(
			'bp-elementor-widgets-admin',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/css/admin.min.css',
			array(),
			BP_ELEMENTOR_WIDGETS_VERSION
		);

		// Enqueue admin scripts.
		wp_enqueue_script(
			'bp-elementor-widgets-admin',
			BP_ELEMENTOR_WIDGETS_URL . 'dist/js/admin.min.js',
			array( 'jquery' ),
			BP_ELEMENTOR_WIDGETS_VERSION,
			true
		);

		// Localize script with data.
		wp_localize_script(
			'bp-elementor-widgets-admin',
			'bpElementorWidgets',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'bp_widgets_nonce' ),
				'strings' => array(
					'saved'       => esc_html__( 'Settings saved successfully!', 'bp-elementor-widgets' ),
					'error'       => esc_html__( 'Error saving settings. Please try again.', 'bp-elementor-widgets' ),
					'enableAll'   => esc_html__( 'Enable All', 'bp-elementor-widgets' ),
					'disableAll'  => esc_html__( 'Disable All', 'bp-elementor-widgets' ),
				),
			)
		);
	}

	/**
	 * AJAX Save Settings
	 *
	 * Handle AJAX request to save widget settings.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function ajax_save_settings() {
		// Verify nonce.
		check_ajax_referer( 'bp_widgets_nonce', 'nonce' );

		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'bp-elementor-widgets' ) ) );
		}

		// Get enabled widgets from POST data.
		$enabled_widgets = isset( $_POST['enabled_widgets'] ) ? $_POST['enabled_widgets'] : array();

		// Sanitize and update option.
		$sanitized = $this->sanitize_enabled_widgets( $enabled_widgets );
		update_option( 'bp_elementor_enabled_widgets', $sanitized );

		// Send success response.
		wp_send_json_success(
			array(
				'message' => esc_html__( 'Settings saved successfully!', 'bp-elementor-widgets' ),
			)
		);
	}

	/**
	 * Render Settings Page
	 *
	 * Output the HTML for the settings page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function render_settings_page() {
		// Get widgets manager instance.
		$widgets_manager = Plugin::instance()->widgets_manager;
		$available_widgets = $widgets_manager->get_available_widgets();
		$enabled_widgets = get_option( 'bp_elementor_enabled_widgets', array_keys( $available_widgets ) );
		?>
		<div class="wrap bp-widgets-settings">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<div class="bp-settings-container">
				<!-- Header Section -->
				<div class="bp-settings-header">
					<div class="bp-header-content">
						<h2><?php esc_html_e( 'Widget Manager', 'bp-elementor-widgets' ); ?></h2>
						<p class="description">
							<?php esc_html_e( 'Enable or disable widgets to optimize your site performance. Only enabled widgets will be loaded.', 'bp-elementor-widgets' ); ?>
						</p>
					</div>
					<div class="bp-header-actions">
						<button type="button" class="button bp-toggle-all" data-action="enable">
							<?php esc_html_e( 'Enable All', 'bp-elementor-widgets' ); ?>
						</button>
						<button type="button" class="button bp-toggle-all" data-action="disable">
							<?php esc_html_e( 'Disable All', 'bp-elementor-widgets' ); ?>
						</button>
					</div>
				</div>

				<!-- Widgets Grid -->
				<div class="bp-widgets-grid">
					<?php
					if ( empty( $available_widgets ) ) {
						?>
						<div class="bp-no-widgets">
							<p><?php esc_html_e( 'No widgets available yet.', 'bp-elementor-widgets' ); ?></p>
						</div>
						<?php
					} else {
						foreach ( $available_widgets as $widget_key => $widget_data ) {
							$is_enabled = in_array( $widget_key, $enabled_widgets, true );
							
							// Map Elementor icons to WordPress Dashicons.
							$icon_map = array(
								'eicon-info-box'     => 'dashicons-info',
								'eicon-countdown'    => 'dashicons-clock',
								'eicon-gallery-grid' => 'dashicons-images-alt2',
								'eicon-testimonial'  => 'dashicons-format-quote',
								'eicon-price-table'  => 'dashicons-table-col-after',
								'eicon-plug'         => 'dashicons-admin-plugins',
							);
							
							$eicon = isset( $widget_data['icon'] ) ? $widget_data['icon'] : 'eicon-plug';
							$icon = isset( $icon_map[ $eicon ] ) ? $icon_map[ $eicon ] : 'dashicons-screenoptions';
							?>
							<div class="bp-widget-card <?php echo $is_enabled ? 'active' : ''; ?>" data-widget="<?php echo esc_attr( $widget_key ); ?>">
								<div class="bp-widget-header">
									<div class="bp-widget-icon">
										<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
									</div>
									<div class="bp-widget-toggle">
										<label class="bp-switch">
											<input 
												type="checkbox" 
												class="bp-widget-checkbox" 
												name="enabled_widgets[]" 
												value="<?php echo esc_attr( $widget_key ); ?>"
												<?php checked( $is_enabled ); ?>
											>
											<span class="bp-slider"></span>
										</label>
									</div>
								</div>
								<div class="bp-widget-body">
									<h3 class="bp-widget-title"><?php echo esc_html( $widget_data['title'] ); ?></h3>
									<p class="bp-widget-description"><?php echo esc_html( $widget_data['description'] ); ?></p>
								</div>
								<?php if ( isset( $widget_data['demo_url'] ) && ! empty( $widget_data['demo_url'] ) ) : ?>
									<div class="bp-widget-footer">
										<a href="<?php echo esc_url( $widget_data['demo_url'] ); ?>" target="_blank" class="bp-demo-link">
											<?php esc_html_e( 'View Demo', 'bp-elementor-widgets' ); ?>
										</a>
									</div>
								<?php endif; ?>
							</div>
							<?php
						}
					}
					?>
				</div>

				<!-- Save Button -->
				<div class="bp-settings-footer">
					<button type="button" class="button button-primary button-large bp-save-settings">
						<?php esc_html_e( 'Save Changes', 'bp-elementor-widgets' ); ?>
					</button>
					<span class="bp-save-status"></span>
				</div>
			</div>
		</div>
		<?php
	}
}

