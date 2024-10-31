<?php
/**
 * Widget: Price Table
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typing widget class.
 *
 * @since 1.0.0
 */
class Price_Table_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-price-table';
	}

	public function get_title() {
		return esc_html__( 'Price Table', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'price', 'table', 'pricing' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_price_table_content',
			[
				'label' => esc_html__( 'Price Table Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Table Name', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Table Name', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'price',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Price', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'Do not miss the currency symbol such as $10 or $10/month.', 'prime-addons-for-elementor' ),
				'default'     => '$99',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'   => esc_html__( 'Item Text', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sample Feature', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'table_content',
			[
				'label'         => esc_html__( 'Table Content', 'prime-addons-for-elementor' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ item_text }}}',
				'prevent_empty' => false,
				'default'       => [
					[
						'item_text' => 'Feature #1',
					],
					[
						'item_text' => 'Feature #2',
					],
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Button Text', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Buy Now', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_url',
			[
				'type'        => Controls_Manager::URL,
				'label'       => esc_html__( 'Button URL', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'If you leave it empty, the button will not be shown.', 'prime-addons-for-elementor' ),
				'default'     => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'featured',
			[
				'label'     => esc_html__( 'Mark it As Featured Plan?', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		// Style Tab: Table.
		$this->start_controls_section(
			'section_pricetable_style',
			[
				'label' => esc_html__( 'Table', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_table_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'price_table_border',
				'selector' => '{{WRAPPER}} .pae-price-table',
			]
		);
		$this->add_control(
			'table_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-price-table'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pae-price-table header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} .pae-price-table',
			]
		);
		$this->end_controls_section();

		// Style Tab: Table Head.
		$this->start_controls_section(
			'section_pricetable_head_style',
			[
				'label' => esc_html__( 'Table Head', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_head_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'table_head_border_color',
			[
				'label'     => esc_html__( 'Separator Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header .price, {{WRAPPER}} .pae-price-table header h3' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_table_title_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header h3' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-price-table header h3',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-price-table header h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_table_price_style',
			[
				'label' => esc_html__( 'Price', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table header .price' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-price-table header .price',
			]
		);

		$this->add_responsive_control(
			'price_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-price-table header .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab: Table Content.
		$this->start_controls_section(
			'section_pricing_table_content_style',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => esc_html__( 'Separator Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-content li' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-price-content',
			]
		);

		$this->add_responsive_control(
			'content_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Item Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-price-content li' => 'padding-block: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 12,
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

		// Style Tab: Table Button.
		$this->start_controls_section(
			'section_pricetable_button_style',
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
					'{{WRAPPER}} .pae-price-table-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .pae-price-table-button',
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
					'{{WRAPPER}} .pae-price-table-button:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-price-table-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .pae-price-table-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'    => esc_html__( 'Hover Animation', 'prime-addons-for-elementor' ),
				'type'     => Controls_Manager::HOVER_ANIMATION,
				'selector' => '{{WRAPPER}} .pae-price-table-button',

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
					'{{WRAPPER}} .pae-price-table-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pae-price-table-button',
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-price-table-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-price-table-button' => 'margin-block: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 20,
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
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-price-table-button',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings               = $this->get_settings_for_display();
		$button_hover_animation = $settings['button_hover_animation'];

		$this->add_render_attribute( 'pae-price-table', 'class', 'pae-price-table' );

		if ( 'yes' === $settings['featured'] ) {
			$this->add_render_attribute( 'pae-price-table', 'class', 'featured' );
		}

		// URL.
		if ( ! empty( $settings['button_url']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_url'] );
			$this->add_render_attribute( 'button', 'class', 'pae-price-table-button elementor-animation-' . $button_hover_animation );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-price-table' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<header>
					<?php if ( ! empty( $settings['title'] ) ) : ?>
					<h3><?php echo esc_html( $settings['title'] ); ?></h3>

					<?php endif; ?>

					<?php if ( ! empty( $settings['price'] ) ) : ?>
						<div class="price"><?php echo esc_html( $settings['price'] ); ?></div>
					<?php endif; ?>
				</header>

			<?php if ( ! empty( $settings['table_content'] ) ) : ?>
				<div class="pae-price-content">
					<ul>
						<?php foreach ( $settings['table_content'] as $item ) : ?>
							<?php if ( ! empty( $item['item_text'] ) ) : ?>
								<li><?php echo esc_html( $item['item_text'] ); ?></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div><!-- .pae-price-content -->
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_url']['url'] ) ) : ?>
				<div class="pae-table-footer">
					<a <?php echo $this->get_render_attribute_string( 'button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
