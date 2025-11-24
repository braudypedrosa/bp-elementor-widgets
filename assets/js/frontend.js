/**
 * Frontend JavaScript
 *
 * JavaScript functionality for BUB Elementor Widgets on the frontend.
 *
 * @package BUB_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * BUB Elementor Widgets Frontend Handler
	 *
	 * Main object that handles all frontend functionality for the widgets.
	 *
	 * @since 1.0.0
	 */
	const BubElementorWidgets = {

		/**
		 * Initialize
		 *
		 * Initialize all frontend handlers when Elementor is ready.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		init: function () {
			// Wait for Elementor frontend to be ready
			$(window).on('elementor/frontend/init', function () {
				BubElementorWidgets.initWidgets();
			});
		},

		/**
		 * Initialize Widgets
		 *
		 * Initialize handlers for all widgets.
		 *
		 * @since 1.0.0
		 * @return {void}
		 */
		initWidgets: function () {
			// Info Box Widget Handler
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/bub-info-box.default',
				BubElementorWidgets.initInfoBox
			);

			// Add more widget handlers here as you create them
			// Example:
			// elementorFrontend.hooks.addAction(
			//     'frontend/element_ready/bub-pricing-table.default',
			//     BubElementorWidgets.initPricingTable
			// );
		},

		/**
		 * Initialize Info Box Widget
		 *
		 * Handler for the Info Box widget on the frontend.
		 *
		 * @since 1.0.0
		 * @param {jQuery} $scope The widget wrapper element.
		 * @return {void}
		 */
		initInfoBox: function ($scope) {
			const $infoBox = $scope.find('.bub-info-box');

			if (!$infoBox.length) {
				return;
			}

			// Add any custom JavaScript functionality for the Info Box here
			// For example, animation on scroll, click handlers, etc.

			// Example: Add smooth reveal animation when scrolled into view
			BubElementorWidgets.animateOnScroll($infoBox);

			// Example: Track clicks on box links for analytics
			$infoBox.on('click', function () {
				// You can add Google Analytics tracking or other analytics here
				// Example: gtag('event', 'click', { 'event_category': 'Info Box' });
			});
		},

		/**
		 * Animate On Scroll
		 *
		 * Add animation when element comes into viewport.
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
				if (isInViewport($element) && !$element.hasClass('bub-animated')) {
					$element.addClass('bub-animated');
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
		 * Limits the rate at which a function can fire.
		 * Useful for scroll and resize events.
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
		BubElementorWidgets.init();
	});

	// Make it globally accessible if needed
	window.BubElementorWidgets = BubElementorWidgets;

})(jQuery);

