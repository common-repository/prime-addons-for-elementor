<?php
/**
 * Widget: Blog Standard
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Standard widget class.
 *
 * @since 1.0.0
 */
class Blog_Standard_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-blog-standard';
	}

	public function get_title() {
		return esc_html__( 'Blog Standard', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'blog', 'post', 'standard' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_blog_standard_post',
			[
				'label' => esc_html__( 'Post Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of Posts', 'prime-addons-for-elementor' ),
				'default' => '6',
			]
		);

		$this->add_control(
			'post_meta_date',
			[
				'label'     => esc_html__( 'Show Post Date', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'post_meta_category',
			[
				'label'     => esc_html__( 'Show Post Category', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'post_meta_author',
			[
				'label'     => esc_html__( 'Show Post Author', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Show Post Excerpt', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'       => esc_html__( 'Excerpt Length', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'in words.', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 40,
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'     => esc_html__( 'Show Read More', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'     => esc_html__( 'Read More Text', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'prime-addons-for-elementor' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__( 'Enable Pagination', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_blog_standard_controls', $this );

		$this->start_controls_section(
			'section_standard_blog_listing_style',
			[
				'label' => esc_html__( 'Boxed', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'boxed',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Boxed', 'prime-addons-for-elementor' ),
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'   => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .pae-standard-blog.boxed .pae-post' => 'background: {{VALUE}}',
				],
				'condition' => [
					'boxed' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border',
				'selector'  => '{{WRAPPER}} .pae-standard-blog.boxed .pae-post',
				'separator' => 'before',
				'condition' => [
					'boxed' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-standard-blog.boxed .pae-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'boxed' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_standard_thubmnail_style',
			[
				'label' => esc_html__( 'Thumbnail', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label'     => esc_html__( 'Show Featured Image', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'thumbnail_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'none'  => [
						'title' => esc_html__( 'None', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'none',
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_width',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Thumbnail Width', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-post-thumbnail' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',
				],
				'default'    => [
					'size' => 400,
				],
				'range'      => [
					'px' => [
						'min'  => 50,
						'max'  => 1200,
						'step' => 1,
					],
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'thumbnail_alignment',
							'operator' => '==',
							'value'    => 'left',
						],
						[
							'name'     => 'thumbnail_alignment',
							'operator' => '==',
							'value'    => 'right',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_height',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Thumbnail Height', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 400,
				],
				'range'     => [
					'px' => [
						'min'  => 180,
						'max'  => 1200,
						'step' => 1,
					],
				],
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_standard_title_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-title a' => 'color: {{VALUE}};',
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
			'standard_title_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-title:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'title_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-post-title a',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-title' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'section_blog_standard_meta_style',
			[
				'label'      => esc_html__( 'Meta', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_category',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_author',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_meta_style' );

		$this->start_controls_tab(
			'tab_meta_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'type'       => Controls_Manager::COLOR,
				'label'      => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-post .meta .meta-item, {{WRAPPER}} .pae-post .meta a' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_category',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_author',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_meta_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'standard_meta_hover_color',
			[
				'type'       => Controls_Manager::COLOR,
				'label'      => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-post .meta a:hover' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_category',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_author',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'meta_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'       => 'meta_typography',
				'label'      => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'     => Typography::TYPOGRAPHY_2,
				'selector'   => '{{WRAPPER}} .pae-post .meta .meta-item, {{WRAPPER}} .pae-post .meta a',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_category',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_author',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'meta_margin',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-post .meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_category',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'post_meta_author',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_standard_excerpt_style',
			[
				'label'     => esc_html__( 'Excerpt', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Excerpt Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-excerpt' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'excerpt_typography',
				'label'     => esc_html__( 'Excerpt Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-post-excerpt p',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_standard_read_more_style',
			[
				'label'     => esc_html__( 'Read More', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_read_more_style' );

		$this->start_controls_tab(
			'tab_read_more_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .read-more' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read_more_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'standard_read_more_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .read-more:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'read_more_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'read_more_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .read-more',
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'read_more_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-footer' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_standard_pagination_style',
			[
				'label'     => esc_html__( 'Pagination', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_pagination_style' );

		$this->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-pagenavi .page-numbers' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-pagenavi .page-numbers' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-pagenavi .page-numbers:hover, {{WRAPPER}} .pae-pagenavi .page-numbers.current' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-pagenavi .page-numbers:hover, {{WRAPPER}} .pae-pagenavi .page-numbers.current' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-pagenavi' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'pagination' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-standard-blog', 'class', 'pae-standard-blog' );
		$this->add_render_attribute( 'pae-standard-blog', 'class', 'thumbnail-' . $settings['thumbnail_alignment'] );
		if ( 'yes' === $settings['boxed'] ) {
			$this->add_render_attribute( 'pae-standard-blog', 'class', 'boxed' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-standard-blog' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php

			global $pae_loop;

			if ( ! isset( $pae_loop ) ) {
				$pae_loop = 1;
			} else {
				++$pae_loop;
			}

			$paging          = 'paged' . $pae_loop;
			$paged           = isset( $_GET[ $paging ] ) ? absint( $_GET[ $paging ] ) : 1;
			$pagination_base = add_query_arg( $paging, '%#%' );

			$qargs = PAE_Utils::get_blog_query_args( $settings );

			$qargs['paged'] = $paged;

			$pae_blog_query = new \WP_Query( $qargs );
			?>

			<?php if ( $pae_blog_query->have_posts() ) : ?>

				<?php
				while ( $pae_blog_query->have_posts() ) :
					$pae_blog_query->the_post();
					?>
					<?php
					$no_thumbnail = ! has_post_thumbnail() ? 'pae-no-thumbnail' : '';
					?>
					<div class="pae-post">
						<?php if ( 'yes' === $settings['show_thumbnail'] && has_post_thumbnail() ) : ?>
							<div class="pae-post-thumbnail" style="background-image:url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>);"><a href="<?php the_permalink(); ?>"></a>
							</div><!-- .pae-post-thumbnail -->
						<?php endif; ?>

						<div class="pae-post-entry <?php echo esc_attr( $no_thumbnail ); ?>">

							<h4 class="pae-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

							<div class="meta">

								<?php if ( 'yes' === $settings['post_meta_date'] ) : ?>
									<a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="datePublished" content="<?php echo esc_attr( get_the_date( get_option( 'date_format' ) ) ); ?>" class="meta-item"><?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?></a>
								<?php endif; ?>

								<?php if ( 'yes' === $settings['post_meta_category'] ) : ?>
									<span class="category meta-item" itemprop="category"><?php echo esc_html__( 'In', 'prime-addons-for-elementor' ) . ' ' . get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<?php endif; ?>

								<?php if ( 'yes' === $settings['post_meta_author'] ) : ?>
									<span class="author meta-item" itemprop="author" itemscope itemtype="http://schema.org/Person"><?php echo esc_html__( 'By', 'prime-addons-for-elementor' ); ?> <?php the_author_posts_link(); ?></span>
								<?php endif; ?>

							</div><!-- .meta -->

							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
								<div class="pae-post-excerpt">
									<?php
									$excerpt = PAE_Utils::get_post_excerpt( absint( $settings['excerpt_length'] ) );
									echo wp_kses_post( wpautop( $excerpt ) );
									?>
								</div>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_read_more'] ) : ?>
								<footer class="pae-post-footer">
									<a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $settings['read_more_text'] ); ?></a>
								</footer>
							<?php endif; ?>

						</div><!-- .pae-post-entry -->

					</div><!-- .pae-post -->

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>

				<?php else : ?>

					<div class="pae-standard-post"><p><?php esc_html_e( 'No Posts Found', 'prime-addons-for-elementor' ); ?></p></div>

			<?php endif; ?>
		</div>

		<?php if ( 'yes' === $settings['pagination'] ) : ?>
			<div class="pae-pagenavi">
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo paginate_links(
					[
						'type'    => '',
						'base'    => $pagination_base,
						'format'  => '?' . $paging . '=%#%',
						'current' => max( 1, $pae_blog_query->get( 'paged' ) ),
						'total'   => $pae_blog_query->max_num_pages,
					]
				);
				?>
			</div>

		<?php endif; ?>

		<?php
	}
}
