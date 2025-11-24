/**
 * Admin JavaScript
 *
 * JavaScript functionality for the BP Elementor Widgets settings page.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Settings Page Handler
	 *
	 * Handles all interactions on the settings page.
	 *
	 * @since 1.0.0
	 */
	const BpWidgetsSettings = {

		/**
		 * Initialize
		 *
		 * Initialize all event handlers.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		init: function () {
			this.bindEvents();
		},

		/**
		 * Bind Events
		 *
		 * Bind all event handlers.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		bindEvents: function () {
			// Toggle individual widget
			$('.bp-widget-checkbox').on('change', this.toggleWidget);

			// Toggle all widgets
			$('.bp-toggle-all').on('click', this.toggleAllWidgets);

			// Save settings
			$('.bp-save-settings').on('click', this.saveSettings);

			// Click on card to toggle
			$('.bp-widget-card').on('click', function (e) {
				// Don't trigger if clicking on the checkbox itself
				if (!$(e.target).hasClass('bub-widget-checkbox') && 
				    !$(e.target).closest('.bp-widget-toggle').length &&
				    !$(e.target).is('a')) {
					const $checkbox = $(this).find('.bp-widget-checkbox');
					$checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');
				}
			});
		},

		/**
		 * Toggle Widget
		 *
		 * Handle individual widget toggle.
		 *
		 * @since 1.0.0
		 * @param {Event} e The event object.
		 * @return {void}
		 */
		toggleWidget: function (e) {
			const $checkbox = $(this);
			const $card = $checkbox.closest('.bp-widget-card');
			const isChecked = $checkbox.is(':checked');

			// Update card appearance
			if (isChecked) {
				$card.addClass('active');
			} else {
				$card.removeClass('active');
			}

			// Update toggle all button text
			BpWidgetsSettings.updateToggleAllButton();
		},

		/**
		 * Toggle All Widgets
		 *
		 * Enable or disable all widgets at once.
		 *
		 * @since 1.0.0
		 * @param {Event} e The event object.
		 * @return {void}
		 */
		toggleAllWidgets: function (e) {
			e.preventDefault();

			const $button = $(this);
			const action = $button.data('action');
			const shouldEnable = action === 'enable';

			// Toggle all checkboxes
			$('.bp-widget-checkbox').each(function () {
				const $checkbox = $(this);
				const $card = $checkbox.closest('.bp-widget-card');

				$checkbox.prop('checked', shouldEnable);

				if (shouldEnable) {
					$card.addClass('active');
				} else {
					$card.removeClass('active');
				}
			});

			// Update button text
			BpWidgetsSettings.updateToggleAllButton();

			// Show feedback
			BpWidgetsSettings.showNotice(
				shouldEnable
					? bpElementorWidgets.strings.enableAll + ' widgets enabled'
					: bpElementorWidgets.strings.disableAll + ' widgets disabled',
				'success'
			);
		},

		/**
		 * Update Toggle All Button
		 *
		 * Update the state of the toggle all button based on current selection.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		updateToggleAllButton: function () {
			const totalWidgets = $('.bp-widget-checkbox').length;
			const enabledWidgets = $('.bp-widget-checkbox:checked').length;

			// Update button states (optional visual feedback)
			if (enabledWidgets === totalWidgets) {
				// All enabled - could add a visual indicator here
			} else if (enabledWidgets === 0) {
				// All disabled - could add a visual indicator here
			}
		},

		/**
		 * Save Settings
		 *
		 * Save widget settings via AJAX.
		 *
		 * @since 1.0.0
		 * @param {Event} e The event object.
		 * @return {void}
		 */
		saveSettings: function (e) {
			e.preventDefault();

			const $button = $(this);
			const $status = $('.bp-save-status');

			// Get all enabled widgets
			const enabledWidgets = [];
			$('.bp-widget-checkbox:checked').each(function () {
				enabledWidgets.push($(this).val());
			});

			// Add loading state
			$button.addClass('loading').prop('disabled', true);
			$status.removeClass('show success error');

			// Send AJAX request
			$.ajax({
				url: bpElementorWidgets.ajaxUrl,
				type: 'POST',
				data: {
					action: 'bub_save_widget_settings',
					nonce: bpElementorWidgets.nonce,
					enabled_widgets: enabledWidgets
				},
				success: function (response) {
					if (response.success) {
						BpWidgetsSettings.showNotice(
							response.data.message || bpElementorWidgets.strings.saved,
							'success'
						);
					} else {
						BpWidgetsSettings.showNotice(
							response.data.message || bpElementorWidgets.strings.error,
							'error'
						);
					}
				},
				error: function (xhr, status, error) {
					BpWidgetsSettings.showNotice(
						bpElementorWidgets.strings.error,
						'error'
					);
					console.error('AJAX Error:', error);
				},
				complete: function () {
					// Remove loading state
					$button.removeClass('loading').prop('disabled', false);
				}
			});
		},

		/**
		 * Show Notice
		 *
		 * Display a status message to the user.
		 *
		 * @since 1.0.0
		 * @param {string} message The message to display.
		 * @param {string} type The message type (success or error).
		 * @return {void}
		 */
		showNotice: function (message, type) {
			const $status = $('.bp-save-status');

			// Update message and show
			$status.text(message)
				.removeClass('success error')
				.addClass(type + ' show');

			// Hide after 3 seconds
			setTimeout(function () {
				$status.removeClass('show');
			}, 3000);
		}
	};

	// Initialize when DOM is ready
	$(document).ready(function () {
		BpWidgetsSettings.init();
	});

})(jQuery);

