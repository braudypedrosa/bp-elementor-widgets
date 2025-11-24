/**
 * Info Box Widget Handler
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Info Box Widget Handler
	 *
	 * @since 1.0.0
	 */
	window.BpWidgets = window.BpWidgets || {};
	
	window.BpWidgets.InfoBox = {

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
			if (window.BpWidgets.Utils) {
				window.BpWidgets.Utils.animateOnScroll($infoBox);
			}

			// Example: Track clicks on box links for analytics
			$infoBox.on('click', function () {
				// You can add Google Analytics tracking or other analytics here
				// Example: gtag('event', 'click', { 'event_category': 'Info Box' });
			});
		}
	};

})(jQuery);

