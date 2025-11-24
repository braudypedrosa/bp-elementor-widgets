/**
 * Read More Widget Handler
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	// Ensure BpWidgets namespace exists
	window.BpWidgets = window.BpWidgets || {};

	window.BpWidgets.ReadMore = {

		/**
		 * Initialize Read More
		 *
		 * @since 1.0.0
		 * @param {jQuery} $scope The widget wrapper element.
		 * @return {void}
		 */
		init: function ($scope) {
			const $wrapper = $scope.find('.bp-read-more-wrapper');

			if (!$wrapper.length) {
				return;
			}

			const $contentWrapper = $wrapper.find('.bp-read-more-content-wrapper');
			const $content = $wrapper.find('.bp-read-more-content');
			const $fade = $wrapper.find('.bp-read-more-fade');
			const $button = $wrapper.find('.bp-read-more-button');
			const $readMoreText = $button.find('.bp-read-more-text');
			const $readLessText = $button.find('.bp-read-less-text');

			// Get settings
			const collapsedHeight = parseInt($wrapper.data('collapsed-height')) || 150;
			const showFade = $wrapper.data('show-fade') === 'yes';

			// Set initial collapsed state
			$contentWrapper.css({
				'max-height': collapsedHeight + 'px',
				'overflow': 'hidden',
				'position': 'relative',
				'transition': 'max-height 0.4s ease'
			});

			// Show fade if enabled
			if (showFade) {
				$fade.css({
					'position': 'absolute',
					'bottom': '0',
					'left': '0',
					'right': '0',
					'height': '60px',
					'background': 'linear-gradient(to bottom, transparent 0%, rgba(255,255,255,1) 100%)',
					'pointer-events': 'none',
					'transition': 'opacity 0.4s ease'
				});
			}

			// Toggle functionality
			let isExpanded = false;

			$button.on('click', function (e) {
				e.preventDefault();

				if (!isExpanded) {
					// Expand
					const fullHeight = $content.outerHeight();
					$contentWrapper.css('max-height', fullHeight + 'px');
					
					if (showFade) {
						$fade.css('opacity', '0');
					}

					$readMoreText.hide();
					$readLessText.show();
					$wrapper.addClass('bp-read-more-expanded');
					isExpanded = true;
				} else {
					// Collapse
					$contentWrapper.css('max-height', collapsedHeight + 'px');
					
					if (showFade) {
						$fade.css('opacity', '1');
					}

					$readMoreText.show();
					$readLessText.hide();
					$wrapper.removeClass('bp-read-more-expanded');
					isExpanded = false;

					// Scroll to top of content
					$('html, body').animate({
						scrollTop: $wrapper.offset().top - 100
					}, 300);
				}
			});

			// Check if content needs the button
			setTimeout(function() {
				const contentHeight = $content.outerHeight();
				if (contentHeight <= collapsedHeight) {
					$button.parent().hide();
					$contentWrapper.css('max-height', 'none');
					if (showFade) {
						$fade.hide();
					}
				}
			}, 100);
		}
	};

})(jQuery);

