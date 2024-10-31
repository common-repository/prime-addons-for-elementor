<?php
/**
 * Widget: Contact Form 7
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
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contact Form 7 widget class.
 *
 * @since 1.0.0
 */
class Contact_Form_7_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-contact-form-7';
	}

	public function get_title() {
		return esc_html__( 'Contact Form 7', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_contact_form_7',
			[
				'label' => esc_html__( 'Contact Form 7', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'contact_form_id',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Select a Form', 'prime-addons-for-elementor' ),
				'default' => 0,
				'options' => PAE_Utils::get_posts_options( 'wpcf7_contact_form' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cf7_label_style',
			[
				'label' => esc_html__( 'Label', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p > label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} p > label',
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} p > label' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 8,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cf7_input_style',
			[
				'label' => esc_html__( 'Input Field', 'prime-addons-for-elementor' ),
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
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]),{{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select,{{WRAPPER}} .wpcf7-form-control-wrap label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]),{{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]), {{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select',
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
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):hover,{{WRAPPER}} .wpcf7-form-control-wrap textarea:hover,{{WRAPPER}} .wpcf7-form-control-wrap select:hover,{{WRAPPER}} .wpcf7-form-control-wrap:hover label,{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):focus,{{WRAPPER}} .wpcf7-form-control-wrap textarea:focus,{{WRAPPER}} .wpcf7-form-control-wrap select:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):hover,{{WRAPPER}} .wpcf7-form-control-wrap textarea:hover,{{WRAPPER}} .wpcf7-form-control-wrap select:hover,{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):focus,{{WRAPPER}} .wpcf7-form-control-wrap textarea:focus,{{WRAPPER}} .wpcf7-form-control-wrap select:focus' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):hover,{{WRAPPER}} .wpcf7-form-control-wrap textarea:hover,{{WRAPPER}} .wpcf7-form-control-wrap select:hover,{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]):focus,{{WRAPPER}} .wpcf7-form-control-wrap textarea:focus,{{WRAPPER}} .wpcf7-form-control-wrap select:focus' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]),{{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]),{{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control-wrap,{{WRAPPER}} input[type="submit"].wpcf7-form-control' => 'display:block;margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form-control-wrap .wpcf7-quiz-label' => 'display:block;margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 8,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wpcf7-form-control-wrap input:not([type="submit"]):not([type="file"]), {{WRAPPER}} .wpcf7-form-control-wrap textarea,{{WRAPPER}} .wpcf7-form-control-wrap select, {{WRAPPER}} .wpcf7-form-control-wrap label',
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
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} input[type="submit"].wpcf7-form-control',
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
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} input[type="submit"].wpcf7-form-control',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} input[type="submit"].wpcf7-form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} input[type="submit"].wpcf7-form-control',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$contact_form_id = absint( $settings['contact_form_id'] );

		$this->add_render_attribute( 'pae-contact-form-7', 'class', 'pae-contact-form-7' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-contact-form-7' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( $contact_form_id > 0 ) : ?>
				<?php echo do_shortcode( '[contact-form-7 id="' . $contact_form_id . '"]' ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
