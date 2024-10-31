<?php
/**
 * Widget: weDocs Archive
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
 * WeDocs Archive widget class.
 *
 * @since 1.0.0
 */
class WeDocs_Archive_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-wedocs-archive';
	}

	public function get_title() {
		return esc_html__( 'weDocs Archive', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_wedocs_archive_settings',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of Questions Per Section', 'prime-addons-for-elementor' ),
				'default' => '6',
			]
		);

		$this->add_control(
			'more_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Read More Text', 'prime-addons-for-elementor' ),
				'default' => 'More Questions',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wedocs_archive_layout',
			[
				'label' => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'type'            => Controls_Manager::SELECT,
				'label'           => esc_html__( 'Columns', 'prime-addons-for-elementor' ),
				'desktop_default' => 3,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'options'         => PAE_Utils::get_columns_options(),
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Column Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 30,
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

		$this->add_responsive_control(
			'row_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Row Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 30,
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
			'shape',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Grid Shape', 'prime-addons-for-elementor' ),
				'default' => 'square',
				'options' => [
					'square' => esc_html__( 'Square', 'prime-addons-for-elementor' ),
					'round'  => esc_html__( 'Round', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		// Style Tab.
		$this->start_controls_section(
			'section_wedocs_archive_title_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-docs-list .wedocs-docs-single > h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wedocs-docs-list .wedocs-docs-single > h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wedocs_archive_section_list_style',
			[
				'label' => esc_html__( 'List', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_marker_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Bullet Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-sections li::marker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Item Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-sections' => 'display: flex;flex-direction: column;row-gap: {{SIZE}}{{UNIT}};',
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
			'section_wedocs_archive_section_title_style',
			[
				'label' => esc_html__( 'Section Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_section_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'section_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-sections li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'section_title_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-sections li:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'section_title_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_title_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wedocs-doc-sections li',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wedocs_archive_button_style',
			[
				'label' => esc_html__( 'Read More Button', 'prime-addons-for-elementor' ),
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
					'{{WRAPPER}} .wedocs-doc-link a' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-link a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .wedocs-doc-link a',
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
					'{{WRAPPER}} .wedocs-doc-link:hover a' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-link:hover a' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .wedocs-doc-link a:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wedocs-doc-link a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .wedocs-doc-link a',
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wedocs-doc-link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-link' => 'margin-top: {{SIZE}}{{UNIT}};',
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

		$this->add_responsive_control(
			'button_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => PAE_Utils::get_alignment_options(),
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .wedocs-doc-link' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wedocs-doc-link a',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$wedocs_shape           = $settings['shape'];
		$button_hover_animation = $settings['button_hover_animation'];

		$wedocs_columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$wedocs_columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$wedocs_columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$this->add_render_attribute( 'pae-wedocs-archive', 'class', 'pae-wedocs-archive' );

		$docs = [];

		$parent_args = [
			'post_type'   => 'docs',
			'parent'      => 0,
			'sort_column' => 'menu_order',
		];

		$parent_docs = get_pages( $parent_args );

		// Prepare docs.
		if ( $parent_docs ) {
			foreach ( $parent_docs as $root ) {
				$sections = get_children(
					[
						'post_parent' => $root->ID,
						'post_type'   => 'docs',
						'post_status' => 'publish',
						'orderby'     => 'menu_order',
						'order'       => 'ASC',
						'numberposts' => absint( $settings['number'] ),
					]
				);

				$docs[] = [
					'doc'      => $root,
					'sections' => $sections,
				];
			}
		}
		?>

		<?php if ( ! empty( $docs ) ) : ?>

			<div <?php echo $this->get_render_attribute_string( 'pae-wedocs-archive' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="wedocs-archive-wrap">
					<ul class="wedocs-docs-list pae-grid columns-<?php echo esc_attr( $wedocs_columns_mobile ); ?> columns-md-<?php echo esc_attr( $wedocs_columns_tablet ); ?> columns-lg-<?php echo esc_attr( $wedocs_columns ); ?>">

						<?php foreach ( $docs as $main_doc ) : ?>
							<li class="wedocs-docs-single <?php echo esc_attr( $wedocs_shape ); ?>">
								<h3><?php echo esc_html( get_the_title( $main_doc['doc']->ID ) ); ?></h3>

								<?php if ( $main_doc['sections'] ) : ?>

									<div class="inside">
										<ul class="wedocs-doc-sections">
											<?php foreach ( $main_doc['sections'] as $section ) : ?>
												<li><a href="<?php echo esc_url( get_permalink( $section->ID ) ); ?>"><?php echo esc_html( get_the_title( $section->ID ) ); ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

								<?php endif; ?>

								<?php if ( ! empty( $settings['more_text'] ) ) : ?>
									<div class="wedocs-doc-link">
										<a href="<?php echo esc_url( get_permalink( $main_doc['doc']->ID ) ); ?>" class="elementor-animation-<?php echo esc_attr( $button_hover_animation ); ?>"><?php echo esc_html( $settings['more_text'] ); ?></a>
									</div>
								<?php endif; ?>

							</li>
						<?php endforeach; ?>
					</ul>
				</div><!-- .wedocs-archive-wrap -->
			</div><!-- .pae-wedocs-archive -->

		<?php endif; ?>
		<?php
	}
}
