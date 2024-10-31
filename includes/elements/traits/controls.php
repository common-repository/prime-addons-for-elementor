<?php
/**
 * Controls trait
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Traits;

use Elementor\Controls_Manager;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

trait Controls {
	/**
	 * Register query settings.
	 *
	 * @since 1.0.0
	 *
	 * @param Widget_Base $wb Widget base object instance.
	 */
	public static function query_settings( $wb ) {
		$wb->start_controls_section(
			'pae_common_query_settings_section',
			[
				'label' => esc_html__( 'Query', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'prime-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => PAE_Utils::get_terms_options( 'category' ),
			]
		);

		$wb->add_control(
			'post_tags',
			[
				'label'       => esc_html__( 'Tags', 'prime-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => PAE_Utils::get_terms_options( 'post_tag' ),
			]
		);

		$wb->add_control(
			'post_exclude',
			[
				'label'       => esc_html__( 'Exclude', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => PAE_Utils::get_posts_options( 'post', [ 'add_default' => false ] ),
				'label_block' => true,
				'multiple'    => true,
				'separator'   => 'after',
			]
		);

		$wb->add_control(
			'post_orderby',
			[
				'label'   => esc_html__( 'Order By', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => esc_html__( 'Date', 'prime-addons-for-elementor' ),
					'rand'  => esc_html__( 'Random', 'prime-addons-for-elementor' ),
					'title' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				],
			]
		);

		$wb->add_control(
			'post_order',
			[
				'label'   => esc_html__( 'Order', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'prime-addons-for-elementor' ),
					'desc' => esc_html__( 'Descending', 'prime-addons-for-elementor' ),
				],
			]
		);

		$wb->end_controls_section();
	}

	/**
	 * Register basic carousel settings.
	 *
	 * @since 1.0.0
	 *
	 * @param Widget_Base $wb Widget base object instance.
	 */
	public static function carousel_settings( $wb ) {
		// Current widget type.
		$widget_type = $wb->get_name();

		$wb->start_controls_section(
			'pae_carousel_common_settings_section',
			[
				'label' => esc_html__( 'Carousel Settings', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_responsive_control(
			'columns',
			[
				'type'           => Controls_Manager::SELECT,
				'label'          => esc_html__( 'Columns', 'prime-addons-for-elementor' ),
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'options'        => PAE_Utils::get_columns_options(),
			]
		);

		$wb->add_responsive_control(
			'gap',
			[
				'type'            => Controls_Manager::SLIDER,
				'label'           => esc_html__( 'Column Gap', 'prime-addons-for-elementor' ),
				'default'         => [
					'size' => 30,
				],
				'desktop_default' => [
					'size' => 30,
				],
				'tablet_default'  => [
					'size' => 20,
				],
				'mobile_default'  => [
					'size' => 0,
				],
				'range'           => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'size_units'      => [ 'px' ],
				'condition'       => [
					'columns!' => '1',
				],
			]
		);

		if ( ! in_array( $widget_type, [ 'pae-testimonial-carousel' ], true ) ) {
			$wb->add_responsive_control(
				'thumbnail_height',
				[
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Thumbnail Height', 'prime-addons-for-elementor' ),
					'selectors'   => [
						'{{WRAPPER}} .pae-carousel-thumbnail' => 'height: {{SIZE}}{{UNIT}}!important;',
						'{{WRAPPER}} .pae-carousel' => 'height:auto;',
					],
					'description' => esc_html__( 'You can adjust the thumbnail height for different devices. ', 'prime-addons-for-elementor' ),
					'default'     => [
						'size' => 250,
					],
					'range'       => [
						'px' => [
							'min'  => 180,
							'max'  => 600,
							'step' => 1,
						],
					],
				]
			);
		}

		$wb->add_control(
			'carousel_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$wb->add_control(
			'show_navigation',
			[
				'label'     => esc_html__( 'Show Navigation', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',

			]
		);

		$wb->add_control(
			'navigation_visible_on_hover',
			[
				'label'     => esc_html__( 'Navigation Visible onHover', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'show_pagination',
			[
				'label'     => esc_html__( 'Show Pagination', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$wb->end_controls_section();
	}

	/**
	 * Register basic slider settings.
	 *
	 * @since 1.0.0
	 *
	 * @param Widget_Base $wb Widget base object instance.
	 */
	public static function slider_settings( $wb ) {
		$wb->start_controls_section(
			'pae_slider_common_settings_section',
			[
				'label' => esc_html__( 'Slider Settings', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'slider_autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
			]
		);

		$wb->add_control(
			'slider_height',
			[
				'label'      => esc_html__( 'Slider Height', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 500,
				],
				'size_units' => [ 'px', 'em', 'vh' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 25,
						'max'  => 62.5,
						'step' => 0.1,
					],
					'vh' => [
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pae-swiper-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$wb->add_control(
			'show_navigation',
			[
				'label'     => esc_html__( 'Show Navigation', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'separator' => 'before',
				'default'   => 'yes',
			]
		);

		$wb->add_control(
			'navigation_visible_on_hover',
			[
				'label'     => esc_html__( 'Navigation Visible onHover', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'after',
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'show_pagination',
			[
				'label'     => esc_html__( 'Show Pagination', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
			]
		);

		$wb->end_controls_section();
	}

	/**
	 * Register slider style settings.
	 *
	 * @since 1.0.0
	 *
	 * @param Widget_Base $wb Widget base object instance.
	 */
	public static function slider_style_settings( $wb ) {
		$wb->start_controls_section(
			'pae_slider_common_style_section',
			[
				'label'      => esc_html__( 'Slider Navigation', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_navigation',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$wb->start_controls_tabs( 'tabs_navigation_style' );

		$wb->start_controls_tab(
			'tab_navigation_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'navigation_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'navigation_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled)' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();

		$wb->start_controls_tab(
			'tab_navigation_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'navigation_hover_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:hover svg, {{WRAPPER}} .swiper-button-prev:hover svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'navigation_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();
		$wb->end_controls_tabs();

		$wb->add_control(
			'navigation_size',
			[
				'label'      => esc_html__( 'Arrow Size', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'separator'  => 'before',
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 32,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}}{{UNIT}} * 1.6);margin-top: calc(-{{SIZE}}{{UNIT}} * 1.6 / 2)',
				],
				'condition'  => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_section();

		$wb->start_controls_section(
			'pae_slider_common_pagination_style_section',
			[
				'label'      => esc_html__( 'Slider Pagination', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_pagination',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$wb->start_controls_tabs( 'tabs_pagination_style' );

		$wb->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();

		$wb->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'pagination_hover_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet:hover, {{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();
		$wb->end_controls_tabs();

		$wb->add_control(
			'pagination_size',
			[
				'label'      => esc_html__( 'Bullets Size', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination' => 'height: calc({{SIZE}}{{UNIT}} + 4px);',
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};margin-inline: calc({{SIZE}}{{UNIT}} / 3)',
				],
				'condition'  => [
					'show_pagination' => 'yes',
				],
				'separator'  => 'before',
			]
		);

		$wb->add_control(
			'pagination_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination' => 'bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_section();
	}

	/**
	 * Register carousel style settings.
	 *
	 * @since 1.0.0
	 *
	 * @param Widget_Base $wb Widget base object instance.
	 */
	public static function carousel_style_settings( $wb ) {
		$wb->start_controls_section(
			'pae_carousel_common_style_section',
			[
				'label'      => esc_html__( 'Carousel Navigation', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_navigation',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$wb->start_controls_tabs( 'tabs_navigation_style' );

		$wb->start_controls_tab(
			'tab_navigation_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'navigation_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next svg, {{WRAPPER}} .swiper-button-prev svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'navigation_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled)' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();

		$wb->start_controls_tab(
			'tab_navigation_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'navigation_hover_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:hover svg, {{WRAPPER}} .swiper-button-prev:hover svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->add_control(
			'navigation_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();
		$wb->end_controls_tabs();

		$wb->add_control(
			'navigation_size',
			[
				'label'      => esc_html__( 'Arrow Size', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'separator'  => 'before',
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}}{{UNIT}} * 1.6);margin-top: calc(-{{SIZE}}{{UNIT}} * 1.6 / 2)',
				],
				'condition'  => [
					'show_navigation' => 'yes',
				],
			]
		);

		$wb->end_controls_section();

		$wb->start_controls_section(
			'pae_carousel_common_pagination_style_section',
			[
				'label'      => esc_html__( 'Carousel Pagination', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_pagination',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$wb->start_controls_tabs( 'tabs_pagination_style' );

		$wb->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();

		$wb->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$wb->add_control(
			'pagination_hover_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet:hover, {{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_tab();
		$wb->end_controls_tabs();

		$wb->add_control(
			'pagination_size',
			[
				'label'      => esc_html__( 'Bullets Size', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination' => 'height: calc({{SIZE}}{{UNIT}} + 4px);',
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};margin-inline: calc({{SIZE}}{{UNIT}} / 3)',
				],
				'condition'  => [
					'show_pagination' => 'yes',
				],
				'separator'  => 'before',
			]
		);

		$wb->add_control(
			'pagination_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination' => 'bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_pagination' => 'yes',
				],
			]
		);

		$wb->end_controls_section();
	}
}
