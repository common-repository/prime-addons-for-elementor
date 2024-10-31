<?php
/**
 * Widget: Separate Text
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Separate Text widget class.
 *
 * @since 1.0.0
 */
class Separate_Text_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-separate-text';
	}

	public function get_title() {
		return esc_html__( 'Separate Text', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-divider';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_separate_text',
			[
				'label' => esc_html__( 'Text Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text',
			[
				'label'   => esc_html__( 'Separate Text', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subheading', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => PAE_Utils::get_alignment_options(),
				'default' => 'center',
			]
		);

		$this->add_control(
			'text_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'none'   => esc_html__( 'None', 'prime-addons-for-elementor' ),
					'solid'  => esc_html__( 'Solid', 'prime-addons-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'prime-addons-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'prime-addons-for-elementor' ),
					'double' => esc_html__( 'Double', 'prime-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text .title' => 'border-style:{{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text .title' => 'border-width:{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'text_border_style!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'text_width',
			[
				'label'          => esc_html__( 'Text Width', 'prime-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'default'        => [
					'size' => 33,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .pae-separate-text .title' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_separate_text_line',
			[
				'label' => esc_html__( 'Line Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'line_border_style',
			[
				'label'     => esc_html__( 'Line Style', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'none'   => esc_html__( 'None', 'prime-addons-for-elementor' ),
					'solid'  => esc_html__( 'Solid', 'prime-addons-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'prime-addons-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'prime-addons-for-elementor' ),
					'double' => esc_html__( 'Double', 'prime-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text:before' => 'border-style:{{VALUE}};',
					'{{WRAPPER}} .pae-separate-text:after' => 'border-style:{{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text:before' => 'border-top-width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pae-separate-text:after' => 'border-top-width:{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'line_border_style!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'line_width',
			[
				'label'          => esc_html__( 'Width', 'prime-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'default'        => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .pae-separate-text:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pae-separate-text:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [
					'line_border_style!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style_settings',
			[
				'label' => esc_html__( 'Text', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'prime-addons-for-elementor' ),
				'global'    => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .pae-separate-text .title',
			]
		);

		$this->add_control(
			'text_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text .title' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'text_border_style!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_line_style_settings',
			[
				'label'     => esc_html__( 'Line', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'line_border_style!' => 'none',
				],
			]
		);

		$this->add_control(
			'line_color',
			[
				'label'     => esc_html__( 'Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .pae-separate-text:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pae-separate-text:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-separate-text', 'class', 'pae-separate-text' );
		$this->add_render_attribute( 'pae-separate-text', 'class', $settings['alignment'] );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-separate-text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<h4 class="title">
				<?php echo esc_html( $settings['text'] ); ?>
			</h4>
		</div>
		<?php
	}
}
