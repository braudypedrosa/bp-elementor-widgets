/**
 * Widgets JavaScript - Main Entry Point
 *
 * Combined JavaScript for all BP Elementor Widgets.
 * This file imports individual widget handlers and initializes them.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Main Widgets Handler
	 *
	 * Handles initialization of all widget-specific functionality.
	 *
	 * @since 1.0.0
	 */
	const BpWidgets = {

		/**
		 * Initialize
		 *
		 * Initialize all widget handlers when Elementor is ready.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		init: function () {
			// Check if Elementor frontend is already initialized
			if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
				BpWidgets.registerWidgets();
			} else {
				// Wait for Elementor frontend to be ready
				$(window).on('elementor/frontend/init', function () {
					BpWidgets.registerWidgets();
				});
			}
		},

		/**
		 * Register Widgets
		 *
		 * Register handlers for all widgets.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		registerWidgets: function () {
			// Info Box Widget
			if (BpWidgets.InfoBox) {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/bp-info-box.default',
					BpWidgets.InfoBox.init
				);
			}

			// Countdown Timer Widget
			if (BpWidgets.CountdownTimer) {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/bp-countdown-timer.default',
					BpWidgets.CountdownTimer.init
				);
			}

			// Gallery Widget
			if (BpWidgets.Gallery) {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/bp-gallery.default',
					BpWidgets.Gallery.init
				);
			}

			// Add more widget handlers here as you create them
		}
	};

	/**
	 * Utility Functions
	 *
	 * @since 1.0.0
	 */
	BpWidgets.Utils = {

		/**
		 * Pad Number
		 *
		 * @since 1.0.0
		 * @param {number} num The number to pad.
		 * @return {string} Padded number string.
		 */
		padNumber: function (num) {
			return num < 10 ? '0' + num : num.toString();
		},

		/**
		 * Animate On Scroll
		 *
		 * @since 1.0.0
		 * @param {jQuery} $element The element to animate.
		 * @return {void}
		 */
		animateOnScroll: function ($element) {
			// Check if element is in viewport
			const isInViewport = function (elem) {
				const elementTop = elem.offset().top;
				const elementBottom = elementTop + elem.outerHeight();
				const viewportTop = $(window).scrollTop();
				const viewportBottom = viewportTop + $(window).height();
				return elementBottom > viewportTop && elementTop < viewportBottom;
			};

			// Check on scroll
			const checkAndAnimate = function () {
				if (isInViewport($element) && !$element.hasClass('bp-animated')) {
					$element.addClass('bp-animated');
				}
			};

			// Check initially
			checkAndAnimate();

			// Check on scroll
			$(window).on('scroll', checkAndAnimate);
		},

		/**
		 * Debounce Function
		 *
		 * @since 1.0.0
		 * @param {Function} func The function to debounce.
		 * @param {number} wait The wait time in milliseconds.
		 * @return {Function} The debounced function.
		 */
		debounce: function (func, wait) {
			let timeout;
			return function executedFunction(...args) {
				const later = function () {
					clearTimeout(timeout);
					func(...args);
				};
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
			};
		}
	};

	// Initialize when DOM is ready
	$(document).ready(function () {
		BpWidgets.init();
	});

	// Make it globally accessible
	window.BpWidgets = window.BpWidgets || {};
	$.extend(window.BpWidgets, BpWidgets);

})(jQuery);
