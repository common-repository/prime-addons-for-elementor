<?php
/**
 * Widget: EDD Search
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * EDD Search widget class.
 *
 * @since 1.0.0
 */
class EDD_Search_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-edd-search';
	}

	public function get_title() {
		return esc_html__( 'EDD Search', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-search-bold';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_edd_search_text',
			[
				'label' => esc_html__( 'EDD Search', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'placeholder_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Placeholder Text', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Search &hellip;', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Button Text', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Search', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_edd_search_style',
			[
				'label' => esc_html__( 'Input', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_input_style' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'input_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="text"], {{WRAPPER}} .pae-edd-search input[type="text"]::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .pae-edd-search input[type="text"]',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'input_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]:hover, {{WRAPPER}} .pae-edd-search input[type="text"]:focus::placeholder, {{WRAPPER}} .pae-edd-search input[type="text"]:hover, {{WRAPPER}} .pae-edd-search input[type="text"]:focus::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]:hover, {{WRAPPER}} .pae-edd-search input[type="text"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'input_border_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]:hover,  {{WRAPPER}} .pae-edd-search input[type="text"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-edd-search input[type="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-edd-search input[type="text"]',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => esc_html__( 'Button', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .pae-edd-search input[type="submit"]',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]:hover,{{WRAPPER}} .pae-edd-search input[type="submit"]:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]:hover,{{WRAPPER}} .pae-edd-search input[type="submit"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]:hover,{{WRAPPER}} .pae-edd-search input[type="submit"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pae-edd-search input[type="submit"]',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => esc_html__( 'Margin', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-edd-search input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-edd-search input[type="submit"]',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-edd-search', 'class', 'pae-edd-search' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-edd-search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" value="<?php the_search_query(); ?>" name="s" />
				<input type="submit" value="<?php echo esc_attr( $settings['button_text'] ); ?>" />
				<input type="hidden" name="post_type" value="download" />
			</form>
		</div>
		<?php
	}
}
