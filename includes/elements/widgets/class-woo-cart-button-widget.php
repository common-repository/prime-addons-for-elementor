<?php
/**
 * Widget: Woo Cart Button
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
 * Woo Cart Button widget class.
 *
 * @since 1.0.0
 */
class Woo_Cart_Button_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-woo-cart-button';
	}

	public function get_title() {
		return esc_html__( 'Woo Cart Button', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-cart-medium';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_woo_cart_button_main',
			[
				'label' => esc_html__( 'WooCommerce Button', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'product_id',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Select Product', 'prime-addons-for-elementor' ),
				'default' => 0,
				'options' => PAE_Utils::get_posts_options( 'product' ),
			]
		);

		$this->add_control(
			'action',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Click Action', 'prime-addons-for-elementor' ),
				'default' => 'ajax',
				'options' => [
					'ajax'     => esc_html__( 'Ajax', 'prime-addons-for-elementor' ),
					'redirect' => esc_html__( 'Redirect', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Button Text', 'prime-addons-for-elementor' ),
				'default' => 'Buy Now',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => PAE_Utils::get_alignment_options(),
				'selectors' => [
					'{{WRAPPER}} .pae-button-container' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => esc_html__( 'Button Style', 'prime-addons-for-elementor' ),
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
					'{{WRAPPER}} .pae-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .pae-button',
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
					'{{WRAPPER}} .pae-button:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .pae-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
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
					'{{WRAPPER}} .pae-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pae-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-button',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$button_action          = $settings['action'];
		$button_product_id      = $settings['product_id'];
		$button_text            = $settings['button_text'];
		$button_hover_animation = $settings['button_hover_animation'];

		$button_link = 'javascript:void(0);';

		if ( '' !== $button_product_id ) {
			$button_link = wc_get_cart_url() . '?add-to-cart=' . esc_attr( $button_product_id );
		}

		$this->add_render_attribute( 'pae-woo-cart-button', 'class', 'pae-button-container' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-woo-cart-button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<?php if ( 'ajax' === $button_action || '' === $button_action ) : ?>
				<a href="javascript:void(0);" data-quantity="1" data-product_id="<?php echo absint( $button_product_id ); ?>" class="hvr-grow add_to_cart_button pae-button product_type_simple ajax_add_to_cart elementor-animation-<?php echo esc_attr( $button_hover_animation ); ?>"><?php echo esc_html( $button_text ); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url( $button_link ); ?>" class="pae-button elementor-animation-<?php echo esc_attr( $button_hover_animation ); ?>"><?php echo esc_html( $button_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php
	}
}
