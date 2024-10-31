<?php
/**
 * Parallax controls
 *
 * @package Prime_Addons_Elementor
 */

use Elementor\Controls_Manager;
use Elementor\Element_Base;

function pae_add_parallax_control_to_widget( $element, $section_id, $args ) {

	if ( 'common' === $element->get_name() && '_section_style' === $section_id ) {

		$element->start_controls_section(
			'_section_parallax',
			[
				'label' => esc_html__( 'Parallax', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'parallax_item',
			[
				'label'     => esc_html__( 'Parallax Item', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
			]
		);

		$element->add_control(
			'parallax_axis',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Parallax Axis', 'prime-addons-for-elementor' ),
				'default'   => 'y',
				'options'   => [
					'y' => esc_html__( 'Y axis', 'prime-addons-for-elementor' ),
					'x' => esc_html__( 'X axis', 'prime-addons-for-elementor' ),
				],
				'condition' => [
					'parallax_item' => 'yes',
				],
			]
		);

		$element->add_control(
			'parallax_momentum',
			[
				'label'       => esc_html__( 'Momentum', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Value should be between -1 and +1', 'prime-addons-for-elementor' ),
				'default'     => [
					'size' => -0.15,
				],
				'range'       => [
					'px' => [
						'min'  => -1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'condition'   => [
					'parallax_item' => 'yes',
				],
			]
		);

		$element->end_controls_section();

	}
}
add_action( 'elementor/element/after_section_end', 'pae_add_parallax_control_to_widget', 10, 3 );

function pae_add_parallax_control_attributes_to_elements( Element_Base $element ) {
	if ( empty( $element->get_settings( 'parallax_item' ) ) || ! $element->get_settings( 'parallax_item' ) === 'yes' ) {
		return;
	}

	$element->add_render_attribute(
		'_wrapper',
		[
			'class'                  => 'parallax-layer',
			'data-parallax-momentum' => $element->get_settings( 'parallax_momentum' )['size'],
			'data-parallax-axis'     => $element->get_settings( 'parallax_axis' ),
		]
	);
}
add_action( 'elementor/frontend/element/before_render', 'pae_add_parallax_control_attributes_to_elements' );
add_action( 'elementor/frontend/widget/before_render', 'pae_add_parallax_control_attributes_to_elements' );
