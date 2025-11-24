/**
 * Widgets JavaScript
 *
 * Combined JavaScript for all BP Elementor Widgets.
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
			// Wait for Elementor frontend to be ready
			$(window).on('elementor/frontend/init', function () {
				BpWidgets.registerWidgets();
			});
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
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/bp-info-box.default',
				BpWidgets.InfoBox.init
			);

			// Countdown Timer Widget
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/bp-countdown-timer.default',
				BpWidgets.CountdownTimer.init
			);

			// Add more widget handlers here as you create them
		}
	};

	/**
	 * Info Box Widget Handler
	 *
	 * @since 1.0.0
	 */
	BpWidgets.InfoBox = {

		/**
		 * Initialize Info Box
		 *
		 * @since 1.0.0
		 * @param {jQuery} $scope The widget wrapper element.
		 * @return {void}
		 */
		init: function ($scope) {
			const $infoBox = $scope.find('.bp-info-box');

			if (!$infoBox.length) {
				return;
			}

			// Add any custom JavaScript functionality for the Info Box here
			// For example, animation on scroll, click handlers, etc.

			// Example: Add smooth reveal animation when scrolled into view
			BpWidgets.Utils.animateOnScroll($infoBox);

			// Example: Track clicks on box links for analytics
			$infoBox.on('click', function () {
				// You can add Google Analytics tracking or other analytics here
				// Example: gtag('event', 'click', { 'event_category': 'Info Box' });
			});
		}
	};

	/**
	 * Countdown Timer Widget Handler
	 *
	 * @since 1.0.0
	 */
	BpWidgets.CountdownTimer = {

		/**
		 * Initialize Countdown Timer
		 *
		 * @since 1.0.0
		 * @param {jQuery} $scope The widget wrapper element.
		 * @return {void}
		 */
		init: function ($scope) {
			const $timer = $scope.find('.bp-countdown-timer');

			if (!$timer.length) {
				return;
			}

			// Get settings from data attributes
			const settings = {
				targetDate: $timer.data('target-date'),
				countdownType: $timer.data('countdown-type'),
				recurringType: $timer.data('recurring-type'),
				recurringDays: parseInt($timer.data('recurring-days')) || 7,
				recurringHours: parseInt($timer.data('recurring-hours')) || 24,
				showDays: $timer.data('show-days') === 'yes',
				showHours: $timer.data('show-hours') === 'yes',
				showMinutes: $timer.data('show-minutes') === 'yes',
				showSeconds: $timer.data('show-seconds') === 'yes',
			};

			// Start the countdown
			BpWidgets.CountdownTimer.startCountdown($timer, settings);
		},

		/**
		 * Start Countdown
		 *
		 * @since 1.0.0
		 * @param {jQuery} $timer The timer element.
		 * @param {Object} settings The timer settings.
		 * @return {void}
		 */
		startCountdown: function ($timer, settings) {
			// Calculate the target date
			let targetDate = BpWidgets.CountdownTimer.calculateTargetDate(settings);

			// Update the countdown every second
			const updateInterval = setInterval(function () {
				const now = new Date().getTime();
				const distance = targetDate - now;

				// If countdown finished
				if (distance < 0) {
					if (settings.countdownType === 'recurring') {
						// Recalculate target date for recurring countdown
						targetDate = BpWidgets.CountdownTimer.calculateTargetDate(settings);
					} else {
						// One-time countdown finished
						clearInterval(updateInterval);
						BpWidgets.CountdownTimer.displayZeros($timer);
						return;
					}
				}

				// Calculate time units
				const days = Math.floor(distance / (1000 * 60 * 60 * 24));
				const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				const seconds = Math.floor((distance % (1000 * 60)) / 1000);

				// Update the display
				BpWidgets.CountdownTimer.updateDisplay($timer, days, hours, minutes, seconds);

			}, 1000);

			// Store the interval ID so we can clear it later if needed
			$timer.data('countdown-interval', updateInterval);
		},

		/**
		 * Calculate Target Date
		 *
		 * @since 1.0.0
		 * @param {Object} settings The timer settings.
		 * @return {number} Target date timestamp.
		 */
		calculateTargetDate: function (settings) {
			const now = new Date().getTime();
			let targetDate = new Date(settings.targetDate).getTime();

			// If recurring, calculate next occurrence
			if (settings.countdownType === 'recurring') {
				// If target date is in the past, find the next occurrence
				if (targetDate < now) {
					let increment;

					if (settings.recurringType === 'days') {
						increment = settings.recurringDays * 24 * 60 * 60 * 1000;
					} else {
						increment = settings.recurringHours * 60 * 60 * 1000;
					}

					// Calculate how many increments have passed
					const timePassed = now - targetDate;
					const incrementsPassed = Math.floor(timePassed / increment);

					// Add enough increments to get to the next future occurrence
					targetDate = targetDate + ((incrementsPassed + 1) * increment);
				}
			}

			return targetDate;
		},

		/**
		 * Update Display
		 *
		 * @since 1.0.0
		 * @param {jQuery} $timer The timer element.
		 * @param {number} days Days remaining.
		 * @param {number} hours Hours remaining.
		 * @param {number} minutes Minutes remaining.
		 * @param {number} seconds Seconds remaining.
		 * @return {void}
		 */
		updateDisplay: function ($timer, days, hours, minutes, seconds) {
			// Format numbers with leading zeros
			const formattedDays = BpWidgets.Utils.padNumber(days);
			const formattedHours = BpWidgets.Utils.padNumber(hours);
			const formattedMinutes = BpWidgets.Utils.padNumber(minutes);
			const formattedSeconds = BpWidgets.Utils.padNumber(seconds);

			// Update each element
			$timer.find('.bp-countdown-days').text(formattedDays);
			$timer.find('.bp-countdown-hours').text(formattedHours);
			$timer.find('.bp-countdown-minutes').text(formattedMinutes);
			$timer.find('.bp-countdown-seconds').text(formattedSeconds);

			// Add animation class for visual feedback
			$timer.find('.bp-countdown-digit').addClass('bp-countdown-tick');
			setTimeout(function () {
				$timer.find('.bp-countdown-digit').removeClass('bp-countdown-tick');
			}, 300);
		},

		/**
		 * Display Zeros
		 *
		 * @since 1.0.0
		 * @param {jQuery} $timer The timer element.
		 * @return {void}
		 */
		displayZeros: function ($timer) {
			$timer.find('.bp-countdown-days').text('00');
			$timer.find('.bp-countdown-hours').text('00');
			$timer.find('.bp-countdown-minutes').text('00');
			$timer.find('.bp-countdown-seconds').text('00');

			// Add finished class
			$timer.addClass('bp-countdown-finished');

			// Trigger custom event
			$timer.trigger('bpCountdownFinished');
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
	window.BpWidgets = BpWidgets;

})(jQuery);

