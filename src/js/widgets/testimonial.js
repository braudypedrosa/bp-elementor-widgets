/**
 * Testimonial Widget Handler
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	// Ensure BpWidgets namespace exists
	window.BpWidgets = window.BpWidgets || {};

	window.BpWidgets.Testimonial = {

		/**
		 * Initialize Testimonial
		 *
		 * @since 1.0.0
		 * @param {jQuery} $scope The widget wrapper element.
		 * @return {void}
		 */
		init: function ($scope) {
			const $slider = $scope.find('.bp-testimonial-slider');

			if (!$slider.length) {
				return;
			}

			// Check if already initialized (avoid double-init)
			if ($slider.hasClass('slick-initialized')) {
				return;
			}

			// Get Slick settings from data attribute
			const slickSettings = $slider.data('slick');

			if (!slickSettings) {
				return;
			}

		// Default settings
		const defaultSettings = {
			prevArrow: '<button type="button" class="slick-prev bp-testimonial-arrow"><i class="fa-solid fa-chevron-left"></i></button>',
			nextArrow: '<button type="button" class="slick-next bp-testimonial-arrow"><i class="fa-solid fa-chevron-right"></i></button>',
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: Math.min(slickSettings.slidesToShow, 2),
						slidesToScroll: 1,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
					}
				}
			]
		};

		// Merge settings
		const finalSettings = $.extend({}, defaultSettings, slickSettings);

		// Initialize slider
		$slider.slick(finalSettings);
		}
	};

})(jQuery);

