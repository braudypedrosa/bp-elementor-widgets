<?php
/**
 * Gallery Widget
 *
 * Displays an image gallery with Slick Carousel.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

namespace BP_Elementor_Widgets\Widgets;

use BP_Elementor_Widgets\Abstracts\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gallery Widget Class
 *
 * Creates a responsive image gallery with Slick Carousel.
 *
 * @since 1.0.0
 */
class Gallery extends Base_Widget {

	/**
	 * Get Widget Name
	 *
	 * Returns the widget name (slug).
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'bp-gallery';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the widget title that appears in the Elementor panel.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Gallery Carousel', 'bp-elementor-widgets' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Returns the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get Widget Keywords
	 *
	 * Returns keywords for the widget (for search).
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'gallery', 'image', 'carousel', 'slider', 'slick', 'lightbox', 'bp' );
	}

	/**
	 * Register Widget Controls
	 *
	 * Register all the controls for this widget.
	 * Controls define what settings appear in the Elementor panel.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_carousel_controls();
		$this->register_style_controls();
	}

	/**
	 * Register Content Controls
	 *
	 * Controls for the gallery images.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_gallery',
			array(
				'label' => esc_html__( 'Gallery', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'gallery',
			array(
				'label'   => esc_html__( 'Add Images', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::GALLERY,
				'default' => array(),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'default'   => 'large',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'image_ratio',
			array(
				'label'   => esc_html__( 'Image Ratio', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '16-9',
				'options' => array(
					'1-1'   => esc_html__( '1:1', 'bp-elementor-widgets' ),
					'3-2'   => esc_html__( '3:2', 'bp-elementor-widgets' ),
					'4-3'   => esc_html__( '4:3', 'bp-elementor-widgets' ),
					'16-9'  => esc_html__( '16:9', 'bp-elementor-widgets' ),
					'21-9'  => esc_html__( '21:9', 'bp-elementor-widgets' ),
					'custom' => esc_html__( 'Custom', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'image_ratio_custom',
			array(
				'label'      => esc_html__( 'Custom Ratio', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 56.25, // 16:9 ratio
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-gallery-item::before' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'image_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'gallery_layout',
			array(
				'label'   => esc_html__( 'Layout', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'   => esc_html__( 'Default', 'bp-elementor-widgets' ),
					'thumbnail' => esc_html__( 'Thumbnail Navigation', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->add_control(
			'thumbnails_per_slide',
			array(
				'label'     => esc_html__( 'Thumbnails Per Slide', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '7',
				'options'   => array(
					'8' => esc_html__( '8 (Small)', 'bp-elementor-widgets' ),
					'7' => esc_html__( '7 (Medium)', 'bp-elementor-widgets' ),
					'6' => esc_html__( '6 (Large)', 'bp-elementor-widgets' ),
				),
				'separator' => 'before',
				'condition' => array(
					'gallery_layout' => 'thumbnail',
				),
			)
		);

		$this->add_control(
			'open_lightbox',
			array(
				'label'   => esc_html__( 'Lightbox', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => array(
					'yes' => esc_html__( 'Yes', 'bp-elementor-widgets' ),
					'no'  => esc_html__( 'No', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Carousel Controls
	 *
	 * Controls for Slick Carousel settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_carousel_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			array(
				'label' => esc_html__( 'Carousel Settings', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'slides_to_show',
			array(
				'label'   => esc_html__( 'Slides to Show', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 10,
			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'   => esc_html__( 'Slides to Scroll', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 10,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3000,
				'min'       => 100,
				'max'       => 10000,
				'step'      => 100,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'transition_speed',
			array(
				'label'   => esc_html__( 'Transition Speed (ms)', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 100,
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'        => esc_html__( 'Navigation Arrows', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'pagination',
			array(
				'label'        => esc_html__( 'Pagination Dots', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'adaptive_height',
			array(
				'label'        => esc_html__( 'Adaptive Height', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'center_mode',
			array(
				'label'        => esc_html__( 'Center Mode', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'center_padding',
			array(
				'label'     => esc_html__( 'Center Padding', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '50px',
				'condition' => array(
					'center_mode' => 'yes',
				),
			)
		);

		$this->add_control(
			'fade_effect',
			array(
				'label'        => esc_html__( 'Fade Effect', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'slides_to_show' => '1',
				),
			)
		);

		$this->add_control(
			'rtl',
			array(
				'label'        => esc_html__( 'RTL Mode', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Controls
	 *
	 * Controls for styling the gallery.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_style_controls() {
		// Image Styles.
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Image', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-gallery-item' => 'padding: 0 {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .bp-gallery-item img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .bp-gallery-item img',
			)
		);

		$this->end_controls_section();

		// Arrow Styles.
		$this->start_controls_section(
			'section_style_arrows',
			array(
				'label'     => esc_html__( 'Navigation Arrows', 'bp-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_size',
			array(
				'label'      => esc_html__( 'Size', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-gallery-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} / 2);',
				),
			)
		);

		$this->start_controls_tabs( 'arrow_style_tabs' );

		$this->start_controls_tab(
			'arrow_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-gallery-arrow' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_background',
			array(
				'label'     => esc_html__( 'Background', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.5)',
				'selectors' => array(
					'{{WRAPPER}} .bp-gallery-arrow' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrow_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'arrow_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-gallery-arrow:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_background',
			array(
				'label'     => esc_html__( 'Background', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.8)',
				'selectors' => array(
					'{{WRAPPER}} .bp-gallery-arrow:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrow_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-gallery-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Dots Styles.
		$this->start_controls_section(
			'section_style_dots',
			array(
				'label'     => esc_html__( 'Pagination Dots', 'bp-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'pagination' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'      => esc_html__( 'Size', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 30,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots li button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_active_color',
			array(
				'label'     => esc_html__( 'Active Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget Output on the Frontend
	 *
	 * Outputs the widget content on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$gallery  = $settings['gallery'];

		if ( empty( $gallery ) ) {
			return;
		}

		// Build Slick settings for JavaScript.
		$slick_settings = array(
			'slidesToShow'   => absint( $settings['slides_to_show'] ),
			'slidesToScroll' => absint( $settings['slides_to_scroll'] ),
			'autoplay'       => 'yes' === $settings['autoplay'],
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'pauseOnHover'   => 'yes' === $settings['pause_on_hover'],
			'infinite'       => 'yes' === $settings['infinite'],
			'speed'          => absint( $settings['transition_speed'] ),
			'arrows'         => 'yes' === $settings['navigation'],
			'dots'           => 'yes' === $settings['pagination'],
			'adaptiveHeight' => 'yes' === $settings['adaptive_height'],
			'centerMode'     => 'yes' === $settings['center_mode'],
			'centerPadding'  => $settings['center_padding'],
			'fade'           => 'yes' === $settings['fade_effect'] && 1 === absint( $settings['slides_to_show'] ),
			'rtl'            => 'yes' === $settings['rtl'],
		);

		$this->add_render_attribute( 'wrapper', 'class', 'bp-gallery' );
		$this->add_render_attribute( 'wrapper', 'class', 'bp-gallery-layout-' . $settings['gallery_layout'] );
		$this->add_render_attribute( 'wrapper', 'class', 'bp-gallery-ratio-' . $settings['image_ratio'] );
		$this->add_render_attribute( 'wrapper', 'data-slick', wp_json_encode( $slick_settings ) );

		if ( 'yes' === $settings['open_lightbox'] ) {
			$this->add_render_attribute( 'wrapper', 'data-lightbox', 'yes' );
		}

		// Add thumbnails per slide data attribute for JavaScript.
		if ( 'thumbnail' === $settings['gallery_layout'] ) {
			$thumbs_per_slide = isset( $settings['thumbnails_per_slide'] ) ? $settings['thumbnails_per_slide'] : '7';
			// Convert to size for CSS styling
			$size_map = array(
				'8' => 'small',
				'7' => 'medium',
				'6' => 'large',
			);
			$thumb_size = isset( $size_map[ $thumbs_per_slide ] ) ? $size_map[ $thumbs_per_slide ] : 'medium';
			$this->add_render_attribute( 'wrapper', 'data-thumbnail-size', $thumb_size );
		}
		?>

		<div class="bp-gallery-container">
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
				<?php
				foreach ( $gallery as $image ) {
					$image_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumbnail', $settings );
					$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );
					$full_image_url = wp_get_attachment_image_url( $image['id'], 'full' );

					if ( ! $image_url ) {
						$image_url = $image['url'];
					}

					if ( ! $full_image_url ) {
						$full_image_url = $image['url'];
					}
					?>
					<div class="bp-gallery-item">
						<?php if ( 'yes' === $settings['open_lightbox'] ) : ?>
							<a href="<?php echo esc_url( $full_image_url ); ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="bp-gallery-<?php echo esc_attr( $this->get_id() ); ?>">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
							</a>
						<?php else : ?>
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
						<?php endif; ?>
					</div>
					<?php
				}
				?>
			</div>

			<?php if ( 'thumbnail' === $settings['gallery_layout'] ) : 
				$thumbs_per_slide = isset( $settings['thumbnails_per_slide'] ) ? $settings['thumbnails_per_slide'] : '7';
				$slides_to_show = absint( $thumbs_per_slide );
				
				// Convert to size for CSS class
				$size_map = array(
					'8' => 'small',
					'7' => 'medium',
					'6' => 'large',
				);
				$thumb_size = isset( $size_map[ $thumbs_per_slide ] ) ? $size_map[ $thumbs_per_slide ] : 'medium';
				?>
				<div class="bp-gallery-thumbnails bp-gallery-thumbnails-<?php echo esc_attr( $thumb_size ); ?>" data-slick='{"slidesToShow": <?php echo $slides_to_show; ?>, "slidesToScroll": 1, "asNavFor": ".bp-gallery", "focusOnSelect": true, "arrows": false, "dots": false, "centerMode": true, "centerPadding": "0"}'>
					<?php
					foreach ( $gallery as $image ) {
						$thumb_url = wp_get_attachment_image_url( $image['id'], 'thumbnail' );
						$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );

						if ( ! $thumb_url ) {
							$thumb_url = $image['url'];
						}
						?>
						<div class="bp-gallery-thumb-item">
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
						</div>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Render Widget Output in the Editor
	 *
	 * Written as HTML using JavaScript to work in the editor.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if ( settings.gallery.length ) { #>
			<div class="bp-gallery-container">
				<div class="bp-gallery bp-gallery-layout-{{{ settings.gallery_layout }}}">
					<# _.each( settings.gallery, function( image ) { #>
						<div class="bp-gallery-item">
							<img src="{{{ image.url }}}" alt="">
						</div>
					<# }); #>
				</div>
				<# if ( 'thumbnail' === settings.gallery_layout ) { #>
					<div class="bp-gallery-thumbnails">
						<# _.each( settings.gallery, function( image ) { #>
							<div class="bp-gallery-thumb-item">
								<img src="{{{ image.url }}}" alt="">
							</div>
						<# }); #>
					</div>
				<# } #>
			</div>
		<# } else { #>
			<div style="text-align: center; padding: 40px;">
				<p><?php esc_html_e( 'Click the "Add Images" button to add images to your gallery.', 'bp-elementor-widgets' ); ?></p>
			</div>
		<# } #>
		<?php
	}
}

