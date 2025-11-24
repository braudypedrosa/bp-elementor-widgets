<?php
/**
 * Countdown Timer Widget
 *
 * Displays a countdown timer with customizable styles and recurring options.
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
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Countdown Timer Widget Class
 *
 * Creates a customizable countdown timer with recurring options.
 *
 * @since 1.0.0
 */
class Countdown_Timer extends Base_Widget {

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
		return 'bp-countdown-timer';
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
		return esc_html__( 'Countdown Timer', 'bp-elementor-widgets' );
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
		return 'eicon-countdown';
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
		return array( 'countdown', 'timer', 'clock', 'time', 'counter', 'date', 'bp' );
	}

	/**
	 * Get Script Dependencies
	 *
	 * Returns script dependencies for this widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Script handles.
	 */
	public function get_script_depends() {
		return array( 'bp-elementor-widgets', 'bp-countdown-timer' );
	}

	/**
	 * Register Widget Controls
	 *
	 * Register all the controls for this widget.
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
	 * Register all content-related controls (Content tab).
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function register_content_controls() {
		// Content Section: Timer Settings.
		$this->start_controls_section(
			'section_timer',
			array(
				'label' => esc_html__( 'Timer Settings', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'target_date',
			array(
				'label'       => esc_html__( 'Target Date & Time', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => gmdate( 'Y-m-d H:i', strtotime( '+7 days' ) ),
				'description' => esc_html__( 'Set the target date and time for the countdown.', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'countdown_type',
			array(
				'label'   => esc_html__( 'Countdown Type', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'one-time',
				'options' => array(
					'one-time'  => esc_html__( 'One Time', 'bp-elementor-widgets' ),
					'recurring' => esc_html__( 'Recurring', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->add_control(
			'recurring_type',
			array(
				'label'     => esc_html__( 'Recurring Type', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'days',
				'options'   => array(
					'days'  => esc_html__( 'Days', 'bp-elementor-widgets' ),
					'hours' => esc_html__( 'Hours', 'bp-elementor-widgets' ),
				),
				'condition' => array(
					'countdown_type' => 'recurring',
				),
			)
		);

		$this->add_control(
			'recurring_days',
			array(
				'label'       => esc_html__( 'Recurring Days', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 7,
				'min'         => 1,
				'max'         => 365,
				'description' => esc_html__( 'Timer will restart every X days.', 'bp-elementor-widgets' ),
				'condition'   => array(
					'countdown_type' => 'recurring',
					'recurring_type' => 'days',
				),
			)
		);

		$this->add_control(
			'recurring_hours',
			array(
				'label'       => esc_html__( 'Recurring Hours', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 24,
				'min'         => 1,
				'max'         => 8760,
				'description' => esc_html__( 'Timer will restart every X hours.', 'bp-elementor-widgets' ),
				'condition'   => array(
					'countdown_type' => 'recurring',
					'recurring_type' => 'hours',
				),
			)
		);

		$this->end_controls_section();

		// Content Section: Display Settings.
		$this->start_controls_section(
			'section_display',
			array(
				'label' => esc_html__( 'Display Settings', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_days',
			array(
				'label'        => esc_html__( 'Show Days', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_days',
			array(
				'label'       => esc_html__( 'Days Label', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Days', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Days', 'bp-elementor-widgets' ),
				'condition'   => array(
					'show_days' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_hours',
			array(
				'label'        => esc_html__( 'Show Hours', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_hours',
			array(
				'label'       => esc_html__( 'Hours Label', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hours', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Hours', 'bp-elementor-widgets' ),
				'condition'   => array(
					'show_hours' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_minutes',
			array(
				'label'        => esc_html__( 'Show Minutes', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_minutes',
			array(
				'label'       => esc_html__( 'Minutes Label', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Minutes', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Minutes', 'bp-elementor-widgets' ),
				'condition'   => array(
					'show_minutes' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_seconds',
			array(
				'label'        => esc_html__( 'Show Seconds', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'label_seconds',
			array(
				'label'       => esc_html__( 'Seconds Label', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seconds', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Seconds', 'bp-elementor-widgets' ),
				'condition'   => array(
					'show_seconds' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		// Content Section: Separator.
		$this->start_controls_section(
			'section_separator',
			array(
				'label' => esc_html__( 'Separator', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_separator',
			array(
				'label'        => esc_html__( 'Show Separator', 'bp-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bp-elementor-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'bp-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'separator_text',
			array(
				'label'       => esc_html__( 'Separator Text', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ':',
				'placeholder' => ':',
				'condition'   => array(
					'show_separator' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Controls
	 *
	 * Register all style-related controls (Style tab).
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function register_style_controls() {
		// Style Section: Container.
		$this->start_controls_section(
			'section_style_container',
			array(
				'label' => esc_html__( 'Container', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'container_style',
			array(
				'label'   => esc_html__( 'Style', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'boxed',
				'options' => array(
					'boxed'      => esc_html__( 'Boxed', 'bp-elementor-widgets' ),
					'rounded'    => esc_html__( 'Rounded', 'bp-elementor-widgets' ),
					'no-borders' => esc_html__( 'No Borders', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'container_alignment',
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
					'{{WRAPPER}} .bp-countdown-timer' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_gap',
			array(
				'label'      => esc_html__( 'Gap Between Items', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-countdown-timer' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Box.
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'Box', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'box_background',
				'label'    => esc_html__( 'Background', 'bp-elementor-widgets' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .bp-countdown-item',
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => '20',
					'right'  => '25',
					'bottom' => '20',
					'left'   => '25',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'box_border',
				'label'     => esc_html__( 'Border', 'bp-elementor-widgets' ),
				'selector'  => '{{WRAPPER}} .bp-countdown-item',
				'condition' => array(
					'container_style!' => 'no-borders',
				),
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-countdown-item',
			)
		);

		$this->add_responsive_control(
			'box_min_width',
			array(
				'label'      => esc_html__( 'Min Width', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 300,
					),
				),
				'default'    => array(
					'size' => 100,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-countdown-item' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Digits.
		$this->start_controls_section(
			'section_style_digits',
			array(
				'label' => esc_html__( 'Digits', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'digits_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .bp-countdown-digit' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'digits_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-countdown-digit',
			)
		);

		$this->add_responsive_control(
			'digits_spacing',
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
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-countdown-digit' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Labels.
		$this->start_controls_section(
			'section_style_labels',
			array(
				'label' => esc_html__( 'Labels', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'labels_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .bp-countdown-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'labels_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-countdown-label',
			)
		);

		$this->add_control(
			'labels_text_transform',
			array(
				'label'     => esc_html__( 'Text Transform', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'uppercase',
				'options'   => array(
					'none'       => esc_html__( 'None', 'bp-elementor-widgets' ),
					'uppercase'  => esc_html__( 'Uppercase', 'bp-elementor-widgets' ),
					'lowercase'  => esc_html__( 'Lowercase', 'bp-elementor-widgets' ),
					'capitalize' => esc_html__( 'Capitalize', 'bp-elementor-widgets' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .bp-countdown-label' => 'text-transform: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Separator.
		$this->start_controls_section(
			'section_style_separator',
			array(
				'label'     => esc_html__( 'Separator', 'bp-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_separator' => 'yes',
				),
			)
		);

		$this->add_control(
			'separator_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .bp-countdown-separator' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'separator_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-countdown-separator',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget Output
	 *
	 * Outputs the widget content on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Build data attributes for JavaScript.
		$countdown_data = array(
			'target-date'      => $settings['target_date'],
			'countdown-type'   => $settings['countdown_type'],
			'recurring-type'   => isset( $settings['recurring_type'] ) ? $settings['recurring_type'] : 'days',
			'recurring-days'   => isset( $settings['recurring_days'] ) ? $settings['recurring_days'] : 7,
			'recurring-hours'  => isset( $settings['recurring_hours'] ) ? $settings['recurring_hours'] : 24,
			'show-days'        => $settings['show_days'],
			'show-hours'       => $settings['show_hours'],
			'show-minutes'     => $settings['show_minutes'],
			'show-seconds'     => $settings['show_seconds'],
		);

		$this->add_render_attribute( 'wrapper', 'class', 'bp-countdown-timer' );
		$this->add_render_attribute( 'wrapper', 'class', 'bp-countdown-style-' . $settings['container_style'] );
		
		// Add all data attributes.
		foreach ( $countdown_data as $key => $value ) {
			$this->add_render_attribute( 'wrapper', 'data-' . $key, $value );
		}
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
			<?php if ( 'yes' === $settings['show_days'] ) : ?>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-days">00</span>
					<span class="bp-countdown-label"><?php echo esc_html( $settings['label_days'] ); ?></span>
				</div>

				<?php if ( 'yes' === $settings['show_separator'] ) : ?>
					<span class="bp-countdown-separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_hours'] ) : ?>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-hours">00</span>
					<span class="bp-countdown-label"><?php echo esc_html( $settings['label_hours'] ); ?></span>
				</div>

				<?php if ( 'yes' === $settings['show_separator'] ) : ?>
					<span class="bp-countdown-separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_minutes'] ) : ?>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-minutes">00</span>
					<span class="bp-countdown-label"><?php echo esc_html( $settings['label_minutes'] ); ?></span>
				</div>

				<?php if ( 'yes' === $settings['show_separator'] ) : ?>
					<span class="bp-countdown-separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( 'yes' === $settings['show_seconds'] ) : ?>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-seconds">00</span>
					<span class="bp-countdown-label"><?php echo esc_html( $settings['label_seconds'] ); ?></span>
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
		<#
		view.addRenderAttribute( 'wrapper', 'class', 'bp-countdown-timer' );
		view.addRenderAttribute( 'wrapper', 'class', 'bp-countdown-style-' + settings.container_style );
		view.addRenderAttribute( 'wrapper', 'data-target-date', settings.target_date );
		view.addRenderAttribute( 'wrapper', 'data-countdown-type', settings.countdown_type );
		#>

		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<# if ( 'yes' === settings.show_days ) { #>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-days">07</span>
					<span class="bp-countdown-label">{{{ settings.label_days }}}</span>
				</div>

				<# if ( 'yes' === settings.show_separator ) { #>
					<span class="bp-countdown-separator">{{{ settings.separator_text }}}</span>
				<# } #>
			<# } #>

			<# if ( 'yes' === settings.show_hours ) { #>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-hours">12</span>
					<span class="bp-countdown-label">{{{ settings.label_hours }}}</span>
				</div>

				<# if ( 'yes' === settings.show_separator ) { #>
					<span class="bp-countdown-separator">{{{ settings.separator_text }}}</span>
				<# } #>
			<# } #>

			<# if ( 'yes' === settings.show_minutes ) { #>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-minutes">21</span>
					<span class="bp-countdown-label">{{{ settings.label_minutes }}}</span>
				</div>

				<# if ( 'yes' === settings.show_separator ) { #>
					<span class="bp-countdown-separator">{{{ settings.separator_text }}}</span>
				<# } #>
			<# } #>

			<# if ( 'yes' === settings.show_seconds ) { #>
				<div class="bp-countdown-item">
					<span class="bp-countdown-digit bp-countdown-seconds">24</span>
					<span class="bp-countdown-label">{{{ settings.label_seconds }}}</span>
				</div>
			<# } #>
		</div>
		<?php
	}
}

