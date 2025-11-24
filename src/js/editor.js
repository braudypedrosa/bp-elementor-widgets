/**
 * Elementor Editor JavaScript
 *
 * JavaScript functionality for the Elementor editor.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Elementor Editor Handler
	 *
	 * Handles editor-specific functionality for BP widgets.
	 *
	 * @since 1.0.0
	 */
	const BpElementorEditor = {

		/**
		 * Initialize
		 *
		 * Initialize all editor handlers when Elementor is ready.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		init: function () {
			// Wait for Elementor editor to be ready
			$(window).on('elementor:init', function () {
				BpElementorEditor.initHandlers();
			});
		},

		/**
		 * Initialize Handlers
		 *
		 * Initialize all editor handlers.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		initHandlers: function () {
			// Add custom editor functionality here
			// For example, custom panel tabs, preview handlers, etc.

			// Example: Add a custom icon to the widgets panel
			BpElementorEditor.customizeWidgetPanel();

			// Example: Add tooltips or help text
			BpElementorEditor.addHelpTooltips();
		},

		/**
		 * Customize Widget Panel
		 *
		 * Customize how BP widgets appear in the Elementor panel.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		customizeWidgetPanel: function () {
		// Add custom class to BP widget category
		elementor.on('panel:init', function () {
			const $bpCategory = $('.elementor-element-wrapper')
				.find('[data-category="bp-widgets"]')
				.closest('.elementor-panel-category');

			if ($bpCategory.length) {
				$bpCategory.addClass('bp-widgets-category');
			}
		});
		},

		/**
		 * Add Help Tooltips
		 *
		 * Add helpful tooltips to widget controls in the editor.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		addHelpTooltips: function () {
			// This is a placeholder for future tooltip functionality
			// You can add custom help tooltips for complex controls here
		},

		/**
		 * Log Debug Info
		 *
		 * Helper function to log debug information in the editor.
		 *
		 * @since 1.0.0
		 * @param {string} message The message to log.
		 * @param {*} data Additional data to log.
		 * @return {void}
		 */
		log: function (message, data) {
			if (typeof console !== 'undefined' && console.log) {
				console.log('[BP Elementor Widgets]', message, data || '');
			}
		}
	};

	// Initialize when DOM is ready
	$(document).ready(function () {
		BpElementorEditor.init();
	});

	// Make it globally accessible
	window.BpElementorEditor = BpElementorEditor;

})(jQuery);

