<?php
/**
 * Widget: EDD Products
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * EDD Products widget class.
 *
 * @since 1.0.0
 */
class EDD_Products_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-isotope', PAE_PLUGIN_URL . '/third-party/isotope/isotope.js', [], '3.0.6', false );
		wp_register_script( 'prime-addons-elementor-infinite-scroll', PAE_PLUGIN_URL . '/third-party/infinite-scroll/infinite-scroll.js', [], '3.0.6', false );
		wp_register_script( 'prime-addons-elementor-grid', PAE_PLUGIN_URL . '/assets/js/widgets/grid.js', [ 'elementor-frontend', 'prime-addons-elementor-isotope', 'imagesloaded', 'prime-addons-elementor-infinite-scroll' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-edd-products';
	}

	public function get_title() {
		return esc_html__( 'EDD Products', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'edd', 'grid', 'download', 'easy', 'digital' ];
	}

	public function get_script_depends() {
		return [ 'prime-addons-elementor-grid' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_edd_products_settings',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of downloads per page', 'prime-addons-for-elementor' ),
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
			'show_button',
			[
				'label'     => esc_html__( 'Show Cart Button', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__( 'Enable Pagination?', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => esc_html__( 'Infinite Scroll', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
				'condition' => [
					'pagination' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_edd_products_query',
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
				'options'     => PAE_Utils::get_terms_options( 'download_category' ),
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

		$this->start_controls_section(
			'section_edd_products_layout',
			[
				'label' => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'default' => 'grid',
				'options' => [
					'grid'    => esc_html__( 'Grid', 'prime-addons-for-elementor' ),
					'masonry' => esc_html__( 'Masonry', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
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
				'condition' => [
					'layout' => 'grid',
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
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_responsive_control(
			'masonry_column_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Column Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-masonry-container' => 'margin-inline: calc(-{{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .pae-grid-item'         => 'padding-inline: calc({{SIZE}}{{UNIT}} / 2);',
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
				'condition' => [
					'layout' => 'masonry',
				],
			]
		);

		$this->add_responsive_control(
			'masonry_row_gap',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Row Gap', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid-item' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
				'condition' => [
					'layout' => 'masonry',
				],
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label'   => esc_html__( 'Grid Style', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'prime-addons-for-elementor' ),
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
			'thumbnail',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Thumbnail Size', 'prime-addons-for-elementor' ),
				'default' => 'medium_large',
				'options' => PAE_Utils::get_image_sizes_options(),
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'type'               => Controls_Manager::SLIDER,
				'label'              => esc_html__( 'Thumbnail Height', 'prime-addons-for-elementor' ),
				'selectors'          => [
					'{{WRAPPER}} .pae-grid-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
				],
				'default'            => [
					'size' => 220,
				],
				'frontend_available' => true,
				'range'              => [
					'px' => [
						'min'  => 150,
						'max'  => 1000,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'center_text',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Center Alignment', 'prime-addons-for-elementor' ),
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_edd_products_title_style',
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
					'{{WRAPPER}} .pae-grid-title a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pae-grid-title:hover a' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pae-grid-title a',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid-title' => 'margin-top: {{SIZE}}{{UNIT}};',
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

		$this->start_controls_section(
			'section_edd_products_price_style',
			[
				'label'     => esc_html__( 'Price', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid .edd_price' => 'color: {{VALUE}};',
				],
				'default'   => '',
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-grid .edd_price',
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'price_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid .pae-grid-price	' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_edd_products_overlay_style',
			[
				'label' => esc_html__( 'Overlay', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid-thumbnail .overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wc_products_pagination_style',
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
		global $post;

		$settings = $this->get_settings();

		$products_number         = $settings['number'];
		$products_layout         = $settings['layout'];
		$products_columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$products_columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$products_columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;
		$products_shape          = $settings['shape'];
		$products_pagination     = $settings['pagination'];
		$products_categories     = $settings['categories'];
		$products_thumbnail_size = $settings['thumbnail'];
		$products_orderby        = $settings['orderby'];
		$products_order          = $settings['order'];
		$products_show_price     = $settings['show_price'];
		$products_show_button    = $settings['show_button'];
		$products_grid_style     = $settings['grid_style'];
		$products_infinite       = $settings['infinite'];
		$products_min_height     = $settings['min_height'];
		$center_text             = $settings['center_text'];

		$product_extra_class = '';

		if ( $center_text ) {
			$product_extra_class = ' text-center';
		}

		/* Pagination */
		global $pae_loop;

		if ( ! isset( $pae_loop ) ) {
			$pae_loop = 1;
		} else {
			++$pae_loop;
		}

		$paging = 'paged' . $pae_loop;

		if ( isset( $_GET[ $paging ] ) ) {
			$paged = absint( $_GET[ $paging ] );
		} else {
			$paged = 1;
		}

		$pagination_base = add_query_arg( $paging, '%#%' );

		/* Grid ID */
		$grid_object_id = $this->get_id();

		$render_html = '';

		$render_html .= '<div id="pae-edd-products-' . esc_attr( $grid_object_id ) . '" class="pae-grids pae-' . esc_attr( $products_layout ) . ' columns-' . esc_attr( $products_columns_mobile ) . ' columns-md-' . esc_attr( $products_columns_tablet ) . ' columns-lg-' . esc_attr( $products_columns ) . ' pae-grid-style-' . esc_attr( $products_grid_style ) . esc_attr( $product_extra_class ) . ' pae-' . esc_attr( $products_layout ) . '-container" data-id="' . esc_attr( $grid_object_id ) . '" data-thumbnail-height="' . esc_attr( $products_min_height['size'] ) . esc_attr( $products_min_height['unit'] ) . '" data-infinite="' . esc_attr( $products_infinite ) . '">';

					/* Data Query */
					$params = [
						'posts_per_page' => absint( $products_number ),
						'post_type'      => 'download',
						'post_status'    => 'publish',
						'orderby'        => $products_orderby,
						'order'          => $products_order,
						'paged'          => $paged,
					];

					if ( ! empty( $products_categories ) ) {
						$params['tax_query'] = [
							[
								'taxonomy' => 'download_category',
								'field'    => 'term_id',
								'terms'    => (array) $products_categories,
							],
						];
					}

					$edd_query = new \WP_Query( $params );

					if ( $edd_query->have_posts() ) {
						while ( $edd_query->have_posts() ) :
							$edd_query->the_post();

							/* EDD Buy Link */
							$buy_link = home_url( '/' ) . '?edd_action=add_to_cart&download_id=' . $post->ID;

							$render_html .= '<div class="pae-grid-item pae-edd-grid-' . esc_attr( get_the_ID() ) . ' ' . esc_attr( $products_shape ) . '">';
							$render_html .= '<div class="pae-grid-thumbnail">' . get_the_post_thumbnail( get_the_ID(), $products_thumbnail_size, [ 'alt' => esc_attr( get_the_title() ) ] ) .
							'<div class="overlay">';
								/* Overlay Grid Style: Overlay */
							if ( 'overlay' === $products_grid_style ) {
								$render_html .= '<h3 class="pae-grid-title"><a href="' . esc_url( get_the_permalink() ) . '">' . esc_attr( get_the_title() ) . '</a></h3>';
								if ( 'yes' === $products_show_price ) {
									$render_html .= '<div class="pae-grid-price">' . edd_price( get_the_ID(), false ) . '</div>';
								}
									$render_html .= '<div class="button-area">';
								if ( 'yes' === $products_show_button ) {
									$render_html .= '<a href="' . esc_url( $buy_link ) . '" class="buy grid-button">' . PAE_Utils::get_icon( 'cart' ) . '</a>';
								}
									$render_html .= '<a href="' . esc_url( get_permalink() ) . '" class="view grid-button">' . PAE_Utils::get_icon( 'plus' ) . '</a>';
									$render_html .= '</div>';

									/* Default Grid Style: Button Area */
							} else {
								$render_html .= '<div class="button-area">';
								$render_html .= '<a href="' . esc_url( get_permalink() ) . '" class="details grid-button">' . PAE_Utils::get_icon( 'plus' ) . '</a>';
								if ( 'yes' === $products_show_button ) {
									$render_html .= '<a href="' . esc_url( $buy_link ) . '" class="buy grid-button">' . PAE_Utils::get_icon( 'cart' ) . '</a>';
								}
								$render_html .= '</div>';
							}

							$render_html .= '</div>
		                    </div>';

							/* Default Grid Style: Text Area */
							if ( 'default' === $products_grid_style ) {
								$render_html .= '<h3 class="pae-grid-title"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
								if ( 'yes' === $products_show_price ) {
									$render_html .= '<div class="pae-grid-price">' . edd_price( get_the_ID(), false ) . '</div>';
								}
							}
							$render_html .= '</div>';
						endwhile;
						wp_reset_postdata();
					} else {
						$render_html .= '<p>' . esc_html__( 'No Item Found', 'prime-addons-for-elementor' ) . '</p>';
					}

					$render_html .= '</div>';

					/* Pagination */
					if ( 'yes' === $products_pagination ) {
						$render_html .= '<div class="pae-pagenavi">';
						$render_html .= paginate_links(
							[
								'type'    => '',
								'base'    => $pagination_base,
								'format'  => '?' . $paging . '=%#%',
								'current' => max( 1, $edd_query->get( 'paged' ) ),
								'total'   => $edd_query->max_num_pages,
							]
						);
						$render_html .= '</div>';
					}

					echo $render_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
