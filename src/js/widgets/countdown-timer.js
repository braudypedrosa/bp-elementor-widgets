/**
 * Countdown Timer Widget Handler
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

// Ensure BpWidgets namespace exists
window.BpWidgets = window.BpWidgets || {};

window.BpWidgets.CountdownTimer = {

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
		window.BpWidgets.CountdownTimer.startCountdown($timer, settings);
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
		let targetDate = window.BpWidgets.CountdownTimer.calculateTargetDate(settings);

		// Function to update countdown
		const updateCountdown = function () {
			const now = new Date().getTime();
			const distance = targetDate - now;

			// If countdown finished
			if (distance < 0) {
				if (settings.countdownType === 'recurring') {
					// Recalculate target date for recurring countdown
					targetDate = window.BpWidgets.CountdownTimer.calculateTargetDate(settings);
				} else {
					// One-time countdown finished
					clearInterval(updateInterval);
					window.BpWidgets.CountdownTimer.displayZeros($timer);
					return;
				}
			}

			// Calculate time units
			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Update the display
			window.BpWidgets.CountdownTimer.updateDisplay($timer, days, hours, minutes, seconds);
		};

		// Run immediately on load
		updateCountdown();

		// Update the countdown every second
		const updateInterval = setInterval(updateCountdown, 1000);

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
		const Utils = window.BpWidgets.Utils;
		const formattedDays = Utils ? Utils.padNumber(days) : days;
		const formattedHours = Utils ? Utils.padNumber(hours) : hours;
		const formattedMinutes = Utils ? Utils.padNumber(minutes) : minutes;
		const formattedSeconds = Utils ? Utils.padNumber(seconds) : seconds;

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
