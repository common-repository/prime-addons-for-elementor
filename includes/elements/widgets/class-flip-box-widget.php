<?php
/**
 * Widget: Flip Box
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flip Box widget class.
 *
 * @since 1.0.0
 */
class Flip_Box_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-flip-box';
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_flip_box',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'type'               => Controls_Manager::SLIDER,
				'label'              => esc_html__( 'Flip Box Height', 'prime-addons-for-elementor' ),
				'default'            => [
					'size' => 400,
				],
				'frontend_available' => true,
				'range'              => [
					'px' => [
						'min'  => 200,
						'max'  => 800,
						'step' => 1,
					],
				],
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .pae-flip-box .front,{{WRAPPER}} .pae-flip-box .back' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Flipping Direction', 'prime-addons-for-elementor' ),
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Flip X', 'prime-addons-for-elementor' ),
					'vertical'   => esc_html__( 'Flip Y', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		// Content Tab: Front Content.
		$this->start_controls_section(
			'section_flipbox_front_content',
			[
				'label' => esc_html__( 'Front Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'front_icon',
			[
				'type'        => Controls_Manager::ICONS,
				'label'       => esc_html__( 'Select Icon', 'prime-addons-for-elementor' ),
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$this->add_control(
			'front_title',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Sample Title', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'front_content',
			[
				'type'    => Controls_Manager::TEXTAREA,
				'label'   => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			]
		);

		$this->add_control(
			'front_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front,{{WRAPPER}} .pae-flip-box .front:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'front_single_image',
			[
				'type'      => Controls_Manager::MEDIA,
				'label'     => esc_html__( 'Background Image', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front' => 'background-image: url({{URL}});',
				],
			]
		);

		$this->end_controls_section();

		// Content Tab: Back Content.
		$this->start_controls_section(
			'section_flipbox_back_content',
			[
				'label' => esc_html__( 'Back Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'back_icon',
			[
				'type'        => Controls_Manager::ICONS,
				'label'       => esc_html__( 'Select Icon', 'prime-addons-for-elementor' ),
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$this->add_control(
			'back_title',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Sample Title', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'back_content',
			[
				'type'    => Controls_Manager::TEXTAREA,
				'label'   => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			]
		);

		$this->add_control(
			'back_show_button',
			[
				'label'     => esc_html__( 'Show Button?', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'back_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click here', 'prime-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Click here', 'prime-addons-for-elementor' ),
				'condition'   => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_button_url',
			[
				'label'       => esc_html__( 'Button URL', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => '',
				'default'     => [
					'url' => '#',
				],
				'condition'   => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'back_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#D4B840',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back,{{WRAPPER}} .pae-flip-box .back:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'back_single_image',
			[
				'type'      => Controls_Manager::MEDIA,
				'label'     => esc_html__( 'Background Image', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back' => 'background-image: url({{URL}});',
				],
			]
		);
		$this->end_controls_section();

		// Style Tab: Front.
		$this->start_controls_section(
			'section_flipbox_front_style',
			[
				'label' => esc_html__( 'Front Style', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'front_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front .icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'front_icon_size',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Icon Size', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-flip-box .front .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pae-flip-box .front .icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'default'    => [
					'size' => '48',
				],
				'size_units' => [ 'em', 'px' ],
				'range'      => [
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
					'px' => [
						'min'  => 12,
						'max'  => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'front_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front .title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_front_title',
				'label'    => esc_html__( 'Title Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-flip-box .front .title',
			]
		);

		$this->add_responsive_control(
			'front_title_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front .title' => 'margin-top: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'front_content_color',
			[
				'label'     => esc_html__( 'Content Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .front .content' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_content',
				'label'    => esc_html__( 'Content Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-flip-box .front .content',
			]
		);

		$this->end_controls_section();

		// Style Tab: Back.
		$this->start_controls_section(
			'section_flipbox_back_style',
			[
				'label' => esc_html__( 'Back Style', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'back_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'back_icon_size',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Icon Size', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-flip-box .back .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pae-flip-box .back .icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'default'    => [
					'size' => '48',
				],
				'size_units' => [ 'em', 'px' ],
				'range'      => [
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
					'px' => [
						'min'  => 12,
						'max'  => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'back_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_back_title',
				'label'    => esc_html__( 'Title Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-flip-box .back .title',
			]
		);

		$this->add_responsive_control(
			'back_title_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .title' => 'margin-top: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'back_content_color',
			[
				'label'     => esc_html__( 'Content Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .content' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_back_content',
				'label'    => esc_html__( 'Content Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-flip-box .back .content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_flipbox_button_style',
			[
				'label'     => esc_html__( 'Button', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'back_show_button' => 'yes',
				],
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
					'{{WRAPPER}} .pae-flip-box .back .pae-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .pae-button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .pae-flip-box .back .pae-button',
				'condition' => [
					'back_show_button' => 'yes',
				],
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
					'{{WRAPPER}} .pae-flip-box .back .pae-button:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .pae-button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .pae-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'     => esc_html__( 'Hover Animation', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [
					'back_show_button' => 'yes',
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
					'{{WRAPPER}} .pae-flip-box .back .pae-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .pae-flip-box .back .pae-button',
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-flip-box .back .pae-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-flip-box .back .pae-button',
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-flip-box .back .pae-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'back_show_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$height                 = $settings['height'];
		$button_hover_animation = $settings['button_hover_animation'];

		$this->add_render_attribute( 'pae-flip-box', 'class', 'pae-flip-box' );
		$this->add_render_attribute( 'pae-flip-box', 'class', esc_attr( $settings['direction'] ) );

		// URL.
		if ( ! empty( $settings['back_button_url']['url'] ) ) {
			$this->add_link_attributes( 'back_button', $settings['back_button_url'] );
			$this->add_render_attribute( 'back_button', 'class', 'pae-button elementor-animation-' . $button_hover_animation );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-flip-box' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> ontouchstart="this.classList.toggle('hover');">
			<?php
			$flipper_attrs = [
				'class' => 'flipper',
			];

			$flipper_styles = '';

			if ( 'vertical' === $settings['direction'] ) {
				$flipper_styles = 'transform-origin: 100% ' . ( $height['size'] / 2 ) . 'px;'; // Half height.
			}

			if ( ! empty( $flipper_styles ) ) {
				$flipper_attrs['style'] = $flipper_styles;
			}
			?>
			<div <?php PAE_Utils::render_attr( $flipper_attrs ); ?>>
				<div class="front">
					<div class="inner">
						<?php if ( ! empty( $settings['front_icon']['value'] ) ) : ?>
							<div class="icon"><?php Icons_Manager::render_icon( $settings['front_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['front_title'] ) ) : ?>
							<h2 class="title"><?php echo esc_html( $settings['front_title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $settings['front_content'] ) ) : ?>
							<div class="content"><?php echo wp_kses_post( $settings['front_content'] ); ?></div>
						<?php endif; ?>
					</div><!-- .inner -->
				</div>
				<div class="back">
					<div class="inner">
						<?php if ( ! empty( $settings['back_icon']['value'] ) ) : ?>
							<div class="icon"><?php Icons_Manager::render_icon( $settings['back_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['back_title'] ) ) : ?>
							<h2 class="title"><?php echo esc_html( $settings['back_title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $settings['back_content'] ) ) : ?>
							<div class="content"><?php echo wp_kses_post( $settings['back_content'] ); ?></div>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['back_show_button'] ) : ?>
							<div><a <?php echo $this->get_render_attribute_string( 'back_button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['back_button_text'] ); ?></a></div>
						<?php endif; ?>
					</div><!-- .inner -->
				</div>
			</div><!-- .flipper -->
		</div><!-- .pae-flip-box -->
		<?php
	}
}
