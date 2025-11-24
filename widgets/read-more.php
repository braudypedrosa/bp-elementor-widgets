<?php
/**
 * Read More Widget
 *
 * Displays collapsible content with a toggle button.
 *
 * @package BP_Elementor_Widgets
 * @since 1.0.0
 */

namespace BP_Elementor_Widgets\Widgets;

use BP_Elementor_Widgets\Abstracts\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read More Widget Class
 *
 * Creates a read more/less toggle for long content.
 *
 * @since 1.0.0
 */
class Read_More extends Base_Widget {

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
		return 'bp-read-more';
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
		return esc_html__( 'Read More', 'bp-elementor-widgets' );
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
		return 'eicon-accordion';
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
		return array( 'read more', 'read less', 'toggle', 'expand', 'collapse', 'accordion', 'content', 'bp' );
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
	 * Controls for the read more content.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_content_controls() {
		// Content Section.
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'content',
			array(
				'label'       => esc_html__( 'Content', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'bp-elementor-widgets' ),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'collapsed_height',
			array(
				'label'      => esc_html__( 'Collapsed Height', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 500,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
			)
		);

		$this->add_control(
			'show_fade',
			array(
				'label'        => esc_html__( 'Show Fade Effect', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		// Button Section.
		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'read_more_text',
			array(
				'label'       => esc_html__( 'Read More Text', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'bp-elementor-widgets' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'read_less_text',
			array(
				'label'       => esc_html__( 'Read Less Text', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read Less', 'bp-elementor-widgets' ),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'bp-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bp-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'bp-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-button-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Controls
	 *
	 * Controls for styling the read more widget.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_style_controls() {
		// Content Style.
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-content' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-read-more-content',
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-read-more-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Button Style.
		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Button', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-read-more-button',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-read-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-read-more-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#667eea',
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'button_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#5568d3',
				'selectors' => array(
					'{{WRAPPER}} .bp-read-more-button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .bp-read-more-button',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-read-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bp-read-more-button',
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

		if ( empty( $settings['content'] ) ) {
			return;
		}

		$collapsed_height = ! empty( $settings['collapsed_height']['size'] ) ? absint( $settings['collapsed_height']['size'] ) : 150;
		$show_fade        = 'yes' === $settings['show_fade'];

		$this->add_render_attribute(
			'wrapper',
			array(
				'class'                => 'bp-read-more-wrapper',
				'data-collapsed-height' => $collapsed_height,
				'data-show-fade'       => $show_fade ? 'yes' : 'no',
			)
		);
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
			<div class="bp-read-more-content-wrapper">
				<div class="bp-read-more-content">
					<?php echo wp_kses_post( $settings['content'] ); ?>
				</div>
				<?php if ( $show_fade ) : ?>
					<div class="bp-read-more-fade"></div>
				<?php endif; ?>
			</div>

			<div class="bp-read-more-button-wrapper">
				<button class="bp-read-more-button" type="button">
					<span class="bp-read-more-text"><?php echo esc_html( $settings['read_more_text'] ); ?></span>
					<span class="bp-read-less-text" style="display: none;"><?php echo esc_html( $settings['read_less_text'] ); ?></span>
				</button>
			</div>
		</div>

		<?php
	}
}

