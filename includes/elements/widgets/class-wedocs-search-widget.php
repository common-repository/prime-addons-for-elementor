<?php
/**
 * Widget: weDocs Search
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
 * WeDocs Search widget class.
 *
 * @since 1.0.0
 */
class WeDocs_Search_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-wedocs-search';
	}

	public function get_title() {
		return esc_html__( 'weDocs Search', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_wedocs_search',
			[
				'label' => esc_html__( 'weDocs Search', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'search_field_placeholder',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Field Placeholder', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Documentation Search &hellip;', 'prime-addons-for-elementor' ),
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

		$this->add_control(
			'docs_dropdown',
			[
				'label'     => esc_html__( 'Docs Dropdown', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'input_style',
			[
				'label' => esc_html__( 'Search', 'prime-addons-for-elementor' ),
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
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-input input,{{WRAPPER}} .wedocs-search-input input::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-input input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .wedocs-search-input input',
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
					'{{WRAPPER}} .wedocs-search-input input:hover,{{WRAPPER}} .wedocs-search-input input:focus,{{WRAPPER}} .wedocs-search-input input:hover::placeholder,{{WRAPPER}} .wedocs-search-input input:focus::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-input input:hover,{{WRAPPER}} .wedocs-search-input input:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'input_border_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-input input:hover,{{WRAPPER}} .wedocs-search-input input:focus' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wedocs-search-input input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .wedocs-search-input input',
			]
		);

		$this->add_responsive_control(
			'input_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-search-input input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-search-input input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wedocs-search-input input',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_style',
			[
				'label'     => esc_html__( 'Dropdown', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_style' );

		$this->start_controls_tab(
			'tab_dropdown_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'dropdown_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-in select' => 'color: {{VALUE}};',
				],
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_control(
			'dropdown_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-in select' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'dropdown_border',
				'selector'  => '{{WRAPPER}} .wedocs-search-in select',
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'dropdown_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-in select:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_control(
			'dropdown_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-in select:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_control(
			'dropdown_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-search-in select:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'dropdown_border_color!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dropdown_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-search-in select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'dropdown_box_shadow',
				'selector'  => '{{WRAPPER}} .wedocs-search-in select',
				'condition' => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-search-in select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-search-in' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'docs_dropdown' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'dropdown_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .wedocs-search-in select',
				'condition' => [
					'docs_dropdown' => 'yes',
				],
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
					'{{WRAPPER}} .search-submit-button input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .search-submit-button input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .search-submit-button input',
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
					'{{WRAPPER}} .search-submit-button input:hover,{{WRAPPER}} .search-submit-button input:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .search-submit-button input:hover,{{WRAPPER}} .search-submit-button input:focus' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .search-submit-button input:hover,{{WRAPPER}} .search-submit-button input:focus' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .search-submit-button input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .search-submit-button input',
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .search-submit-button input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .search-submit-button input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .search-submit-button input',
			]
		);

		$this->end_controls_section();
	}

	protected function render_document_dropdown() {
		$dropdown_args = [
			'post_type'         => 'docs',
			'echo'              => 1,
			'depth'             => 1,
			'show_option_none'  => esc_html__( 'All Docs', 'prime-addons-for-elementor' ),
			'option_none_value' => 'all',
			'name'              => 'search_in_doc',
		];

		if ( isset( $_GET['search_in_doc'] ) && 'all' !== $_GET['search_in_doc'] ) {
			$dropdown_args['selected'] = (int) $_GET['search_in_doc'];
		}
		?>
		<div class="wedocs-search-in">
			<?php wp_dropdown_pages( $dropdown_args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div><!-- .wedocs-search-in -->
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-wedocs-search', 'class', 'pae-wedocs-search' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-wedocs-search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

				<div class="wedocs-search-input">
					<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'prime-addons-for-elementor' ); ?></span>
					<input type="search" class="search-field" placeholder="<?php echo esc_attr( $settings['search_field_placeholder'] ); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'prime-addons-for-elementor' ); ?>">
					<input type="hidden" name="post_type" value="docs" />
				</div><!-- .wedocs-search-input -->

				<?php if ( 'yes' === $settings['docs_dropdown'] ) : ?>
					<?php $this->render_document_dropdown(); ?>
				<?php endif; ?>

				<div class="search-submit-button">
					<input type="submit" class="search-submit" value="<?php echo esc_attr( $settings['button_text'] ); ?>" />
				</div><!-- .search-submit-button -->

			</form>
		</div><!-- .pae-wedocs-search -->
		<?php
	}
}
