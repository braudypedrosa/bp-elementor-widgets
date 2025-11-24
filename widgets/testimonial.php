<?php
/**
 * Testimonial Widget
 *
 * Displays customer testimonials with image/icon, rating, and multiple layouts.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

namespace BP_Elementor_Widgets\Widgets;

use BP_Elementor_Widgets\Abstracts\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Testimonial Widget Class
 *
 * Creates a testimonial display with slider and grid layouts.
 *
 * @since 1.0.0
 */
class Testimonial extends Base_Widget {

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
		return 'bp-testimonial';
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
		return esc_html__( 'Testimonial', 'bp-elementor-widgets' );
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
		return 'eicon-testimonial';
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
		return array( 'testimonial', 'review', 'rating', 'feedback', 'customer', 'slider', 'carousel', 'bp' );
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
		$this->register_style_controls();
	}

	/**
	 * Register Content Controls
	 *
	 * Controls for the testimonial content.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_content_controls() {
		// Testimonials Section.
		$this->start_controls_section(
			'section_testimonials',
			array(
				'label' => esc_html__( 'Testimonials', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'       => esc_html__( 'Name', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'John Doe', 'bp-elementor-widgets' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle / Location', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CEO at Company', 'bp-elementor-widgets' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'review',
			array(
				'label'       => esc_html__( 'Review', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is an amazing product! Highly recommended for anyone looking for quality and reliability.', 'bp-elementor-widgets' ),
				'rows'        => 5,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5,
				'step'    => 0.5,
				'default' => 5,
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonials', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'     => esc_html__( 'Sarah Johnson', 'bp-elementor-widgets' ),
						'subtitle' => esc_html__( 'Marketing Director', 'bp-elementor-widgets' ),
						'review'   => esc_html__( 'Outstanding service! The team went above and beyond to ensure our satisfaction. Highly recommend!', 'bp-elementor-widgets' ),
						'rating'   => 5,
					),
					array(
						'name'     => esc_html__( 'Michael Chen', 'bp-elementor-widgets' ),
						'subtitle' => esc_html__( 'Business Owner', 'bp-elementor-widgets' ),
						'review'   => esc_html__( 'Excellent quality and great customer support. Will definitely use their services again.', 'bp-elementor-widgets' ),
						'rating'   => 5,
					),
					array(
						'name'     => esc_html__( 'Emily Rodriguez', 'bp-elementor-widgets' ),
						'subtitle' => esc_html__( 'Project Manager', 'bp-elementor-widgets' ),
						'review'   => esc_html__( 'Professional, reliable, and efficient. Everything was delivered on time and exceeded expectations.', 'bp-elementor-widgets' ),
						'rating'   => 5,
					),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->end_controls_section();

		// Layout Section.
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slider',
				'options' => array(
					'slider' => esc_html__( 'Slider', 'bp-elementor-widgets' ),
					'grid'   => esc_html__( 'Grid', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'condition' => array(
					'layout' => 'grid',
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'     => esc_html__( 'Slides to Show', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'condition' => array(
					'layout' => 'slider',
				),
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
				'condition'    => array(
					'layout' => 'slider',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 10000,
				'step'      => 100,
				'condition' => array(
					'layout'   => 'slider',
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_arrows',
			array(
				'label'        => esc_html__( 'Show Arrows', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'layout' => 'slider',
				),
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'        => esc_html__( 'Show Dots', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'layout' => 'slider',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Controls
	 *
	 * Controls for styling the testimonial.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_style_controls() {
		// Card Style.
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_background',
			array(
				'label'     => esc_html__( 'Background Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-testimonial-item' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .bp-testimonial-item',
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .bp-testimonial-item',
			)
		);

		$this->end_controls_section();

		// Image Style.
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Image', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_size',
			array(
				'label'      => esc_html__( 'Size', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 150,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 80,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-testimonial-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array(
						'min' => 0,
						'max' => 50,
					),
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-testimonial-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Content Style.
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Name Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-testimonial-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-testimonial-name',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-testimonial-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-testimonial-subtitle',
			)
		);

		$this->add_control(
			'review_color',
			array(
				'label'     => esc_html__( 'Review Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-testimonial-review' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_typography',
				'label'    => esc_html__( 'Review Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-testimonial-review',
			)
		);

		$this->add_control(
			'rating_color',
			array(
				'label'     => esc_html__( 'Rating Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5a623',
				'selectors' => array(
					'{{WRAPPER}} .bp-testimonial-rating i' => 'color: {{VALUE}};',
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
		$settings     = $this->get_settings_for_display();
		$testimonials = $settings['testimonials'];

		if ( empty( $testimonials ) ) {
			return;
		}

		$layout = $settings['layout'];

		$this->add_render_attribute( 'wrapper', 'class', 'bp-testimonial-wrapper' );
		$this->add_render_attribute( 'wrapper', 'class', 'bp-testimonial-layout-' . $layout );

		if ( 'slider' === $layout ) {
			$this->add_render_attribute( 'wrapper', 'class', 'bp-testimonial-slider' );
			$slides_to_show = ! empty( $settings['slides_to_show'] ) ? absint( $settings['slides_to_show'] ) : 1;
			$this->add_render_attribute(
				'wrapper',
				'data-slick',
				wp_json_encode(
					array(
						'slidesToShow'   => $slides_to_show,
						'slidesToScroll' => 1,
						'autoplay'       => 'yes' === $settings['autoplay'],
						'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
						'arrows'         => 'yes' === $settings['show_arrows'],
						'dots'           => 'yes' === $settings['show_dots'],
						'infinite'       => true,
						'speed'          => 500,
					)
				)
			);
		} else {
			$this->add_render_attribute( 'wrapper', 'class', 'bp-testimonial-grid' );
			$columns = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
			$this->add_render_attribute( 'wrapper', 'data-columns', $columns );
		}
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<div class="bp-testimonial-item">
					<?php if ( ! empty( $testimonial['image']['url'] ) ) : ?>
						<div class="bp-testimonial-image">
							<img src="<?php echo esc_url( $testimonial['image']['url'] ); ?>" alt="<?php echo esc_attr( $testimonial['name'] ); ?>">
						</div>
					<?php endif; ?>

					<div class="bp-testimonial-content">
						<?php if ( ! empty( $testimonial['rating'] ) ) : ?>
							<div class="bp-testimonial-rating">
								<?php
								$rating = floatval( $testimonial['rating'] );
								for ( $i = 1; $i <= 5; $i++ ) {
									if ( $i <= $rating ) {
										echo '<i class="fa-solid fa-star"></i>';
									} elseif ( $i - 0.5 <= $rating ) {
										echo '<i class="fa-solid fa-star-half-stroke"></i>';
									} else {
										echo '<i class="fa-regular fa-star"></i>';
									}
								}
								?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $testimonial['review'] ) ) : ?>
							<div class="bp-testimonial-review">
								<?php echo wp_kses_post( $testimonial['review'] ); ?>
							</div>
						<?php endif; ?>

						<div class="bp-testimonial-author">
							<?php if ( ! empty( $testimonial['name'] ) ) : ?>
								<h4 class="bp-testimonial-name"><?php echo esc_html( $testimonial['name'] ); ?></h4>
							<?php endif; ?>

							<?php if ( ! empty( $testimonial['subtitle'] ) ) : ?>
								<p class="bp-testimonial-subtitle"><?php echo esc_html( $testimonial['subtitle'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}
}

