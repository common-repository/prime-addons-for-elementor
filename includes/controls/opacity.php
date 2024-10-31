<?php
/**
 * Opacity controls
 *
 * @package Prime_Addons_Elementor
 */

use Elementor\Controls_Manager;

/**
 * Add custom controls.
 *
 * @since 1.0.0
 *
 * @param \Elementor\Controls_Stack $element The element type.
 * @param string                    $section_id Section ID.
 * @param array                     $args Section arguments.
 */
function pae_add_opacity_control_to_widget( $element, $section_id, $args ) {

	if ( 'common' === $element->get_name() && '_section_style' === $section_id ) {

		$element->start_controls_section(
			'_section_opacity',
			[
				'label' => esc_html__( 'Opacity', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'element_opacity',
			[
				'label'       => esc_html__( 'Opacity', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Value should be between 0 and 1', 'prime-addons-for-elementor' ),
				'default'     => [
					'size' => 1,
				],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors'   => [
					'{{WRAPPER}}' => 'opacity: {{SIZE}};',
				],
			]
		);

		$element->end_controls_section();

	}
}
add_action( 'elementor/element/after_section_end', 'pae_add_opacity_control_to_widget', 10, 3 );
