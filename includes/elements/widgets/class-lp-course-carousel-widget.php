<?php
/**
 * Widget: LP Course Carousel
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
 * LP Course Carousel widget class.
 *
 * @since 1.0.0
 */
class LP_Course_Carousel_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-carousel', PAE_PLUGIN_URL . '/assets/js/widgets/carousel.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-lp-course-carousel';
	}

	public function get_title() {
		return esc_html__( 'LP Course Carousel', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'learnpress', 'carousel', 'course' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-carousel' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_lp_course_carousel_post',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of Courses', 'prime-addons-for-elementor' ),
				'default' => '6',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'     => esc_html__( 'Show Price', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_students_count',
			[
				'label'     => esc_html__( 'Show Enrolled Students Count', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_course_settings_controls', $this );

		$this->start_controls_section(
			'section_lp_courses_query',
			[
				'label' => esc_html__( 'Query', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories', 'prime-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => PAE_Utils::get_terms_options( 'course_category' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => PAE_Utils::get_post_orderby_options(),
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => PAE_Utils::get_post_order_options(),
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_query_settings_controls', $this );

		$this->start_controls_section(
			'section_lp_course_carousel_layout',
			[
				'label' => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label'   => esc_html__( 'Grid Style', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
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
				'default' => 'large',
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

		do_action( 'pae_action_lp_course_carousel_after_layout_settings_controls', $this );

		$this->start_controls_section(
			'section_lp_course_carousel_column_style',
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

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_column_style_controls', $this );

		$this->start_controls_section(
			'section_lp_course_carousel_title_style',
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

		do_action( 'pae_action_lp_course_carousel_after_title_style_controls', $this );

		$this->start_controls_section(
			'section_lp_course_product_carousel_price_style',
			[
				'label'      => esc_html__( 'Price', 'prime-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_price',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'type'       => Controls_Manager::COLOR,
				'label'      => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-carousel-price' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_price',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'       => 'price_typography',
				'label'      => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'     => Typography::TYPOGRAPHY_2,
				'selector'   => '{{WRAPPER}} .pae-carousel-price',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_price',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_margin',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors'  => [
					'{{WRAPPER}} .pae-carousel-price' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'    => [
					'size' => 8,
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_price',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_price_style_controls', $this );

		$this->start_controls_section(
			'section_lp_course_carousel_students_style',
			[
				'label'     => esc_html__( 'Students Count', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_students_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'students_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-student-count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_students_count' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'students_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-student-count',
				'condition' => [
					'show_students_count' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'students_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-student-count' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 4,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'show_students_count' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_students_style_controls', $this );

		do_action( 'pae_action_lp_course_carousel_after_category_style_controls', $this );

		$this->start_controls_section(
			'section_lp_course_carousel_overlay_style',
			[
				'label' => esc_html__( 'Overlay', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Overlay Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_lp_course_carousel_after_overlay_style_controls', $this );

		do_action( 'pae_action_lp_course_carousel_after_icon_style_controls', $this );
	}

	protected function render() {
		global $post;

		$settings = $this->get_settings_for_display();

		$number = $settings['number'];

		$columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$gap        = isset( $settings['gap']['size'] ) ? $settings['gap']['size'] : 30;
		$gap_tablet = isset( $settings['gap_tablet']['size'] ) ? $settings['gap_tablet']['size'] : 20;
		$gap_mobile = isset( $settings['gap_mobile']['size'] ) ? $settings['gap_mobile']['size'] : 0;

		$grid_style = $settings['grid_style'];
		$boxed      = $settings['boxed'];
		$shape      = $settings['shape'];

		$courses_categories = $settings['categories'];
		$order              = $settings['order'];
		$orderby            = $settings['orderby'];

		$autoplay        = $settings['carousel_autoplay'];
		$show_pagination = $settings['show_pagination'];
		$show_navigation = $settings['show_navigation'];

		$hover_effect        = $settings['hover_effect'];
		$show_price          = $settings['show_price'];
		$show_students_count = $settings['show_students_count'];

		$has_pagination = '';

		if ( 'yes' === $show_pagination ) {
			$has_pagination = ' has-pagination'; }

		$boxed_class        = ( 'yes' === $settings['boxed'] ) ? 'boxed' : '';
		$hover_effect_class = ( 'yes' === $settings['hover_effect'] ) ? 'scale' : '';

		$nav_hover_class = '';

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$nav_hover_class = ' navigation-onhover';
		}

		$carousel_id = 'pae-carousel-' . $this->get_id();

		$render_html = '<div id="' . esc_attr( $carousel_id ) . '" data-columns-sm="' . esc_attr( $columns_mobile ) . '" data-columns-md="' . esc_attr( $columns_tablet ) . '" data-columns="' . esc_attr( $columns ) . '" data-gap-sm="' . esc_attr( $gap_mobile ) . '" data-gap-md="' . esc_attr( $gap_tablet ) . '" data-gap="' . esc_attr( $gap ) . '" data-autoplay="' . esc_attr( $autoplay ) . '" class="pae-learnpress-courses-carousel pae-carousel swiper-container ' . esc_attr( $shape ) . $has_pagination . $nav_hover_class . '">
		<div class="swiper-wrapper">';
			$params  = [
				'posts_per_page' => absint( $number ),
				'post_type'      => 'lp_course',
				'orderby'        => $orderby,
				'order'          => $order,
			];

			if ( ! empty( $courses_categories ) ) {
				$params['tax_query'] = [
					[
						'taxonomy' => 'course_category',
						'field'    => 'term_id',
						'terms'    => (array) $courses_categories,
					],
				];
			}

			$the_query = new \WP_Query( $params );

			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) :
					$the_query->the_post();

					$course = learn_press_get_course( get_the_ID() );

					$count_students = $course->count_students();

					// HTML markup below.
					$render_html .= '<div class="pae-learnpress-courses-carousel swiper-slide pae-carousel-item pae-carousel-item-' . esc_attr( get_the_ID() ) . ' ' . esc_attr( $boxed_class ) . '">';

					$render_html .= '<div class="pae-carousel-thumbnail ' . esc_attr( $hover_effect_class ) . '">
										<img src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), $settings['image_size'] ) ) . '" alt=" ' . esc_attr( get_the_title() ) . ' " />

										<div class="overlay">';
					if ( 'overlay' === $grid_style ) {
						$render_html .= '<h4 class="pae-carousel-title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h4>';

						$render_html .= '<div class="pae-carousel-meta">';

						if ( 'yes' === $show_price ) {
												$render_html .= '<div class="pae-carousel-price">' . $course->get_course_price_html() . '</div>';
						}

						if ( 'yes' === $show_students_count ) {
													$render_html .= '<div class="pae-student-count"><span>' . intval( $count_students ) . '</span> ' . esc_html__( 'Students', 'prime-addons-for-elementor' ) . '</div>';
						}

																		$render_html .= '</div>';

					}

											$render_html .= '<div class="button-area">';
											$render_html .= '<a href="' . esc_url( get_permalink() ) . '" class="details pae-carousel-button">' . PAE_Utils::get_icon( 'plus' ) . '</a>';
											$render_html .= '</div>';
						$render_html                     .= '</div>
									</div>';

					if ( 'default' === $grid_style ) {

						$render_html .= '<h4 class="pae-carousel-title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h4>';

						$render_html .= '<div class="pae-carousel-meta">';

						if ( 'yes' === $show_price ) {
										$render_html .= '<div class="pae-carousel-price">' . $course->get_course_price_html() . '</div>';
						}

						if ( 'yes' === $show_students_count ) {
											$render_html .= '<div class="pae-student-count"><span>' . intval( $count_students ) . '</span> ' . esc_html__( 'Students', 'prime-addons-for-elementor' ) . '</div>';
						}

														$render_html .= '</div>';
					}

					$render_html .= '</div>';

				endwhile;
				wp_reset_postdata();
			} else {
				$render_html .= '<div class="swiper-slide pae-carousel-item"><p>' . esc_html__( 'No Courses Found', 'prime-addons-for-elementor' ) . '</p></div>';
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
