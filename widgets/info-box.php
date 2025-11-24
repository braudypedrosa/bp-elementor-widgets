<?php
/**
 * Info Box Widget
 *
 * Displays information in a stylish box with icon, title, and description.
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
 * Info Box Widget Class
 *
 * Creates a customizable info box with icon, title, description, and link.
 *
 * @since 1.0.0
 */
class Info_Box extends Base_Widget {

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
		return 'bp-info-box';
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
		return esc_html__( 'Info Box', 'bp-elementor-widgets' );
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
		return 'eicon-info-box';
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
		return array( 'info', 'box', 'feature', 'service', 'icon box', 'bp' );
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
	 * Register all content-related controls (Content tab).
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function register_content_controls() {
		// Content Section: Icon.
		$this->start_controls_section(
			'section_icon',
			array(
				'label' => esc_html__( 'Icon', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'   => esc_html__( 'Top', 'bp-elementor-widgets' ),
					'left'  => esc_html__( 'Left', 'bp-elementor-widgets' ),
					'right' => esc_html__( 'Right', 'bp-elementor-widgets' ),
				),
			)
		);

		$this->end_controls_section();

		// Content Section: Content.
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Info Box Title', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter your title', 'bp-elementor-widgets' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is a description for the info box. You can add any text here.', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter your description', 'bp-elementor-widgets' ),
				'rows'        => 5,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		// Content Section: Link.
		$this->start_controls_section(
			'section_link',
			array(
				'label' => esc_html__( 'Link', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'bp-elementor-widgets' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'link_type',
			array(
				'label'     => esc_html__( 'Link Type', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'box',
				'options'   => array(
					'none'   => esc_html__( 'None', 'bp-elementor-widgets' ),
					'box'    => esc_html__( 'Whole Box', 'bp-elementor-widgets' ),
					'button' => esc_html__( 'Button', 'bp-elementor-widgets' ),
				),
				'condition' => array(
					'link[url]!' => '',
				),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'bp-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn More', 'bp-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter button text', 'bp-elementor-widgets' ),
				'condition'   => array(
					'link[url]!' => '',
					'link_type'  => 'button',
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
		// Style Section: Box.
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'Box', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'bp-elementor-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
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
				'default' => 'center',
				'toggle'  => true,
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'box_background',
				'label'    => esc_html__( 'Background', 'bp-elementor-widgets' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .bp-info-box',
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'box_border',
				'label'    => esc_html__( 'Border', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-info-box',
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-info-box',
			)
		);

		$this->end_controls_section();

		// Style Section: Icon.
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => esc_html__( 'Icon', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Size', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bp-info-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6EC1E4',
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bp-info-box-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Title.
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-info-box-title',
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Description.
		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__( 'Description', 'bp-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-info-box-description',
			)
		);

		$this->end_controls_section();

		// Style Section: Button.
		$this->start_controls_section(
			'section_style_button',
			array(
				'label'     => esc_html__( 'Button', 'bp-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'link_type' => 'button',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'bp-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .bp-info-box-button',
			)
		);

		$this->start_controls_tabs( 'button_tabs' );

		// Normal State.
		$this->start_controls_tab(
			'button_normal',
			array(
				'label' => esc_html__( 'Normal', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => esc_html__( 'Background Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6EC1E4',
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		// Hover State.
		$this->start_controls_tab(
			'button_hover',
			array(
				'label' => esc_html__( 'Hover', 'bp-elementor-widgets' ),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background',
			array(
				'label'     => esc_html__( 'Background Color', 'bp-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bp-info-box-button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'    => '20',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bp-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bp-info-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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

		$this->add_render_attribute( 'wrapper', 'class', 'bp-info-box' );
		$this->add_render_attribute( 'wrapper', 'class', 'bp-icon-position-' . $settings['icon_position'] );

		// If link type is 'box', wrap the entire box in a link.
		$is_box_link = ! empty( $settings['link']['url'] ) && 'box' === $settings['link_type'];

		if ( $is_box_link ) {
			$this->add_link_attributes( 'box_link', $settings['link'] );
			?>
			<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'box_link' ) ); ?>>
			<?php
		}
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
				<div class="bp-info-box-icon">
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="bp-info-box-content">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<<?php echo esc_attr( $settings['title_tag'] ); ?> class="bp-info-box-title">
						<?php echo esc_html( $settings['title'] ); ?>
					</<?php echo esc_attr( $settings['title_tag'] ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ) : ?>
					<div class="bp-info-box-description">
						<?php echo wp_kses_post( $settings['description'] ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['link']['url'] ) && 'button' === $settings['link_type'] ) : ?>
					<?php
					$this->add_link_attributes( 'button_link', $settings['link'] );
					$this->add_render_attribute( 'button_link', 'class', 'bp-info-box-button' );
					?>
					<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button_link' ) ); ?>>
						<?php echo esc_html( $settings['button_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<?php
		if ( $is_box_link ) {
			?>
			</a>
			<?php
		}
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
		view.addRenderAttribute( 'wrapper', 'class', 'bp-info-box' );
		view.addRenderAttribute( 'wrapper', 'class', 'bp-icon-position-' + settings.icon_position );

		const isBoxLink = settings.link.url && 'box' === settings.link_type;
		#>

		<# if ( isBoxLink ) { #>
			<a href="{{ settings.link.url }}">
		<# } #>

		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<# if ( settings.icon.value ) { #>
				<div class="bp-info-box-icon">
					<# 
					const iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i', 'object' );
					if ( iconHTML.rendered ) { #>
						{{{ iconHTML.value }}}
					<# } #>
				</div>
			<# } #>

			<div class="bp-info-box-content">
				<# if ( settings.title ) { #>
					<{{{ settings.title_tag }}} class="bp-info-box-title">
						{{{ settings.title }}}
					</{{{ settings.title_tag }}}>
				<# } #>

				<# if ( settings.description ) { #>
					<div class="bp-info-box-description">
						{{{ settings.description }}}
					</div>
				<# } #>

				<# if ( settings.link.url && 'button' === settings.link_type ) { #>
					<a href="{{ settings.link.url }}" class="bp-info-box-button">
						{{{ settings.button_text }}}
					</a>
				<# } #>
			</div>
		</div>

		<# if ( isBoxLink ) { #>
			</a>
		<# } #>
		<?php
	}
}

