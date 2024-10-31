<?php
/**
 * Widget: Post Carousel
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
 * Post Carousel widget class.
 *
 * @since 1.0.0
 */
class Post_Carousel_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-carousel', PAE_PLUGIN_URL . '/assets/js/widgets/carousel.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-post-carousel';
	}

	public function get_title() {
		return esc_html__( 'Post Carousel', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'post', 'carousel' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-carousel' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_post_carousel_post',
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
			'show_cats',
			[
				'label'     => esc_html__( 'Show Categories', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Show Excerpt', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'       => esc_html__( 'Excerpt Length', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'in words.', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_carousel_after_post_settings_controls', $this );

		$this->start_controls_section(
			'section_post_carousel_layout',
			[
				'label' => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'grid_style',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Grid Layout', 'prime-addons-for-elementor' ),
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Standard', 'prime-addons-for-elementor' ),
					'overlay' => esc_html__( 'Overlay', 'prime-addons-for-elementor' ),
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

		$this->add_control(
			'boxed',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Boxed Style', 'prime-addons-for-elementor' ),
				'default'   => '',
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'condition' => [
					'grid_style' => 'default',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Image Size', 'prime-addons-for-elementor' ),
				'default' => 'medium',
				'options' => PAE_Utils::get_image_sizes_options(),
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'     => esc_html__( 'Hover Effect', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_carousel_after_layout_settings_controls', $this );

		$this->start_controls_section(
			'section_post_carousel_column_style',
			[
				'label'      => esc_html__( 'Boxed', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'grid_style',
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'boxed',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'type'       => Controls_Manager::COLOR,
				'label'      => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'    => '#f9f9f9',
				'selectors'  => [
					'{{WRAPPER}} .pae-carousel .swiper-slide.boxed' => 'background: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'grid_style',
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'boxed',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'       => 'item_border',
				'selector'   => '{{WRAPPER}} .pae-carousel .swiper-slide.boxed',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'grid_style',
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'boxed',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
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
					'{{WRAPPER}} .pae-carousel .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'grid_style',
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'boxed',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'grid_style',
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'boxed',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_carousel_after_thumbnail_style_controls', $this );

		$this->start_controls_section(
			'section_post_carousel_title_style',
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
					'{{WRAPPER}} .pae-carousel-title a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pae-carousel-title:hover a' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pae-carousel-title a',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 8,
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
			'section_post_carousel_cats_style',
			[
				'label'     => esc_html__( 'Categories', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cats' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_cats_style' );

		$this->start_controls_tab(
			'tab_cats_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'cats_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-cats li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cats_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'standard_cats_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-cats li:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'cats_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cats_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-carousel-cats li a',
			]
		);

		$this->add_responsive_control(
			'cats_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-cats' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_carousel_after_title_style_controls', $this );

		$this->start_controls_section(
			'section_post_carousel_excerpt_style',
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
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-excerpt' => 'color: {{VALUE}}',
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
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-carousel-excerpt p',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_margin_top',
			[
				'label'      => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 10,
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-carousel-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_carousel_after_excerpt_style_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$gap        = isset( $settings['gap']['size'] ) ? $settings['gap']['size'] : 30;
		$gap_tablet = isset( $settings['gap_tablet']['size'] ) ? $settings['gap_tablet']['size'] : 20;
		$gap_mobile = isset( $settings['gap_mobile']['size'] ) ? $settings['gap_mobile']['size'] : 0;

		$autoplay        = $settings['carousel_autoplay'];
		$show_pagination = $settings['show_pagination'];
		$show_navigation = $settings['show_navigation'];

		$carousel_id = 'pae-carousel-' . $this->get_id();

		$show_cats    = $settings['show_cats'];
		$show_excerpt = $settings['show_excerpt'];
		$image_size   = $settings['image_size'];

		$extra_class  = '';
		$extra_class .= esc_attr( $settings['shape'] );
		$extra_class .= esc_attr( $settings['boxed'] );

		if ( 'yes' === $show_pagination ) {
			$extra_class .= ' has-pagination';
		}

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$extra_class .= ' navigation-onhover';
		}

		$hover_effect_class = ( 'yes' === $settings['hover_effect'] ) ? 'scale' : '';

		$content_class  = '';
		$content_class .= esc_attr( $settings['grid_style'] );

		$boxed_class = ( 'yes' === $settings['boxed'] ) ? ' boxed' : '';

		$render_html = '<div id="' . esc_attr( $carousel_id ) . '" data-columns-sm="' . esc_attr( $columns_mobile ) . '" data-columns-md="' . esc_attr( $columns_tablet ) . '" data-columns="' . esc_attr( $columns ) . '" data-gap-sm="' . esc_html( $gap_mobile ) . '" data-gap-md="' . esc_html( $gap_tablet ) . '" data-gap="' . esc_html( $gap ) . '" data-autoplay="' . esc_attr( $autoplay ) . '" class="pae-carousel pae-post-carousel swiper-container ' . esc_attr( $extra_class ) . '">
		<div class="swiper-wrapper">';

			$qargs = PAE_Utils::get_blog_query_args( $settings );

			$pae_carousel_query = new \WP_Query( $qargs );

		if ( $pae_carousel_query->have_posts() ) {
			while ( $pae_carousel_query->have_posts() ) :
				$pae_carousel_query->the_post();

				$render_html .= '<div class="swiper-slide pae-carousel-item pae-carousel-item-' . esc_attr( get_the_ID() ) . esc_attr( $boxed_class ) . '">';

				$image_url = '';

				if ( has_post_thumbnail() ) {
					$image_url = get_the_post_thumbnail_url( get_the_ID(), $image_size );
				}

				$render_html .= '<div class="pae-carousel-thumbnail ' . esc_attr( $hover_effect_class ) . '">';
				if ( $image_url ) {
					$render_html .= '<a href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image_url ) . '" alt=" ' . esc_attr( get_the_title() ) . ' " /></a>';
				}
				$render_html .= '</div>';

				$render_html .= '<div class="pae-carousel-content ' . esc_attr( $content_class ) . '">';

				if ( 'yes' === $show_cats ) {
					$cats_content = PAE_Utils::get_terms( get_the_ID(), 'category', 1, '</li><li>' );
					if ( $cats_content ) {
						$render_html .= '<div class="pae-carousel-cats"><ul><li>';
						$render_html .= wp_kses_post( $cats_content );
						$render_html .= '</li></ul></div>';
					}
				}

				$render_html .= '<h4 class="pae-carousel-title"><a class="title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h4>';

				if ( 'yes' === $show_excerpt ) {
					$excerpt = PAE_Utils::get_post_excerpt( absint( $settings['excerpt_length'] ) );

					$render_html .= '<div class="pae-carousel-excerpt">' . wp_kses_post( wpautop( $excerpt ) ) . '</div>';
				}

				$render_html .= '</div>';
				$render_html .= '</div>';

				endwhile;

			wp_reset_postdata();
		} else {
			$render_html .= '<div class="swiper-slide pae-carousel-item"><p>' . esc_html__( 'Not found', 'prime-addons-for-elementor' ) . '</p></div>';
		}

			$render_html .= '</div>';

		if ( 'yes' === $show_pagination ) {
			$render_html .= '<div class="swiper-pagination"></div>';
		}

		if ( 'yes' === $show_navigation ) {
			$render_html .= '<div class="swiper-button-next"><span>' . PAE_Utils::get_svg( 'icon-chevron-right' ) . '</span></div><div class="swiper-button-prev"><span>' . PAE_Utils::get_svg( 'icon-chevron-left' ) . '</span></div>';
		}

		$render_html .= '</div>';

		echo $render_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
