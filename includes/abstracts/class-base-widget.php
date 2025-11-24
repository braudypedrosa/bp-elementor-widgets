<?php
/**
 * Base Widget Abstract Class
 *
 * All custom widgets should extend this class to inherit common functionality.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

namespace BP_Elementor_Widgets\Abstracts;

use Elementor\Widget_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Widget Abstract Class
 *
 * Provides common functionality for all widgets.
 * Extend this class when creating new widgets.
 *
 * @since 1.0.0
 */
abstract class Base_Widget extends Widget_Base {

	/**
	 * Get Widget Categories
	 *
	 * Returns an array of widget categories.
	 * Override this method if you want to use a different category.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'bp-widgets' );
	}

	/**
	 * Get Widget Keywords
	 *
	 * Returns an array of keywords for the widget.
	 * Override this method to add custom keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'bp' );
	}

	/**
	 * Get Script Dependencies
	 *
	 * Returns an array of script handles to be enqueued.
	 * Override this method if your widget needs custom scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Script handles.
	 */
	public function get_script_depends() {
		return array( 'bp-elementor-widgets-widgets' );
	}

	/**
	 * Get Style Dependencies
	 *
	 * Returns an array of style handles to be enqueued.
	 * Override this method if your widget needs custom styles.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Style handles.
	 */
	public function get_style_depends() {
		return array( 'bp-elementor-widgets' );
	}

	/**
	 * Render Plain Content
	 *
	 * Override the default plain content rendering.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function render_plain_content() {
		// Override if needed.
	}

	/**
	 * Get Custom Help URL
	 *
	 * Returns the help URL for the widget.
	 * Override this method to provide documentation link.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Help URL.
	 */
	public function get_custom_help_url() {
		return 'https://yourwebsite.com/docs/';
	}

	/**
	 * Render Icon
	 *
	 * Helper method to render icons consistently across widgets.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @param array $icon Icon data from control.
	 * @return void
	 */
	protected function render_icon( $icon ) {
		if ( empty( $icon['library'] ) ) {
			return;
		}

		\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
	}

	/**
	 * Add Inline Editing Attributes
	 *
	 * Helper method to add inline editing attributes.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @param string $key Control key.
	 * @param string $toolbar Toolbar type (basic, advanced, etc.).
	 * @return void
	 */
	protected function add_inline_editing( $key, $toolbar = 'basic' ) {
		$this->add_render_attribute( $key, array(
			'class' => 'elementor-inline-editing',
			'data-elementor-setting-key' => $key,
			'data-elementor-inline-editing-toolbar' => $toolbar,
		) );
	}

	/**
	 * Render Link Attributes
	 *
	 * Helper method to render link attributes safely.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @param array  $link_settings Link control settings.
	 * @param string $key Attribute key.
	 * @return void
	 */
	protected function render_link_attributes( $link_settings, $key = 'link' ) {
		if ( empty( $link_settings['url'] ) ) {
			return;
		}

		$this->add_link_attributes( $key, $link_settings );
	}
}

