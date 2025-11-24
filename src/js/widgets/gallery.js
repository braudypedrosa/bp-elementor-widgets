/**
 * Gallery Widget Handler
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

// Ensure BpWidgets namespace exists
window.BpWidgets = window.BpWidgets || {};

window.BpWidgets.Gallery = {

	/**
	 * Initialize Gallery
	 *
	 * @since 1.0.0
	 * @param {jQuery} $scope The widget wrapper element.
	 * @return {void}
	 */
	init: function ($scope) {
		const $gallery = $scope.find('.bp-gallery');
		const $thumbnails = $scope.find('.bp-gallery-thumbnails');

		if (!$gallery.length) {
			return;
		}

		// Check if already initialized (avoid double-init)
		if ($gallery.hasClass('slick-initialized')) {
			return;
		}

		// Get Slick settings from data attribute
		const slickSettings = $gallery.data('slick');
		const hasLightbox = $gallery.data('lightbox') === 'yes';

		if (!slickSettings) {
			return;
		}

		// Default settings
		const defaultSettings = {
			prevArrow: '<button type="button" class="slick-prev bp-gallery-arrow"><i class="fa-solid fa-chevron-left"></i></button>',
			nextArrow: '<button type="button" class="slick-next bp-gallery-arrow"><i class="fa-solid fa-chevron-right"></i></button>',
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: Math.min(slickSettings.slidesToShow, 2),
						slidesToScroll: 1,
						arrows: true,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: true,
						dots: false,
					}
				}
			]
		};

		// Merge settings
		const finalSettings = jQuery.extend({}, defaultSettings, slickSettings);

		// Initialize main gallery
		if ($thumbnails.length) {
			// Gallery with thumbnail navigation
			finalSettings.asNavFor = '.bp-gallery-thumbnails';
			$gallery.slick(finalSettings);

			// Initialize thumbnails
			$thumbnails.slick();
		} else {
			// Gallery without thumbnails
			$gallery.slick(finalSettings);
		}

		// Handle lightbox (Elementor handles it automatically)
		if (hasLightbox) {
			// Elementor's lightbox will be automatically triggered
			// No additional code needed
		}
	}
};
