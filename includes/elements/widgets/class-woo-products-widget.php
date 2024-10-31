<?php
/**
 * Widget: Woo Products
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
 * Woo Products widget class.
 *
 * @since 1.0.0
 */
class Woo_Products_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-isotope', PAE_PLUGIN_URL . '/third-party/isotope/isotope.js', [], '2.0.12', false );
		wp_register_script( 'prime-addons-elementor-infinite-scroll', PAE_PLUGIN_URL . '/third-party/infinite-scroll/infinite-scroll.js', [], '2.0.12', false );
		wp_register_script( 'prime-addons-elementor-grid', PAE_PLUGIN_URL . '/assets/js/widgets/grid.js', [ 'elementor-frontend', 'prime-addons-elementor-isotope', 'imagesloaded', 'prime-addons-elementor-infinite-scroll' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-woo-products';
	}

	public function get_title() {
		return esc_html__( 'Woo Products', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'product', 'woo', 'woocommerce', 'grid' ];
	}

	public function get_script_depends() {
		return [ 'prime-addons-elementor-grid' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_wc_products_settings',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of Products Per Page', 'prime-addons-for-elementor' ),
				'default' => '6',
			]
		);

		$this->add_control(
			'product_filter',
			[
				'label'   => esc_html__( 'Product Data Filter', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '_all',
				'options' => [
					'_all'        => esc_html__( 'All Products', 'prime-addons-for-elementor' ),
					'_featured'   => esc_html__( 'Featured Products', 'prime-addons-for-elementor' ),
					'_sale_price' => esc_html__( 'On Sale Products', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'     => esc_html__( 'Show Price', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
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
			'featured_label',
			[
				'label'       => esc_html__( 'Show Featured Label?', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'Once a product is set as featured product, the featured label will display on the product thumbnail.', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'label_on'    => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off'   => esc_html__( 'No', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'onsale_label',
			[
				'label'       => esc_html__( 'Show Sale Label?', 'prime-addons-for-elementor' ),
				'description' => esc_html__( 'Once a product has on sale price, the sale label will display on the product thumbnail.', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'label_on'    => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off'   => esc_html__( 'No', 'prime-addons-for-elementor' ),
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
			'section_wc_products_query',
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
				'options'     => PAE_Utils::get_terms_options( 'product_cat' ),
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
			'section_wc_products_layout',
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
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Thumbnail Height', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-grid-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 220,
				],
				'range'     => [
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
				'label'     => esc_html__( 'Content Alignment Center', 'prime-addons-for-elementor' ),
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
				'condition' => [
					'grid_style' => 'default',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wc_products_title_style',
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
			'section_wc_products_price_style',
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
					'{{WRAPPER}} .pae-wc-product-item .price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pae-wc-product-item .overlay .sale-price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pae-wc-product-item .overlay .regular-price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pae-wc-product-item .sale-price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pae-wc-product-item .regular-price' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .pae-wc-product-item .price, {{WRAPPER}} .pae-wc-product-item .sale-price,{{WRAPPER}} .pae-wc-product-item .regular-price,{{WRAPPER}} .overlay .woocommerce-Price-amount amount',
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
					'{{WRAPPER}} .pae-grid .price, {{WRAPPER}} .pae-grid .sale-price' => 'margin-top: {{SIZE}}{{UNIT}};',
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
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wc_products_overlay_style',
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
		$settings = $this->get_settings_for_display();

		$product_item_number  = $settings['number'];
		$products_show_price  = $settings['show_price'];
		$products_show_button = $settings['show_button'];

		$product_grid_columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$product_grid_columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$product_grid_columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;
		$product_pagination          = $settings['pagination'];
		$products_categories         = $settings['categories'];
		$product_filter              = $settings['product_filter'];
		$product_grid_style          = $settings['grid_style'];
		$product_layout              = $settings['layout'];
		$product_infinite            = $settings['infinite'];

		$product_grid_shape     = $settings['shape'];
		$product_thumbnail_size = $settings['thumbnail'];
		$product_orderby        = $settings['orderby'];
		$product_order          = $settings['order'];
		$product_featured_label = $settings['featured_label'];
		$product_onsale_label   = $settings['onsale_label'];
		$center_text            = $settings['center_text'];

		$product_extra_class = '';

		if ( $center_text ) {
			$product_extra_class = ' text-center';
		}

		// Pagination.
		global $pae_loop;
		global $post;

		if ( ! isset( $pae_loop ) ) {
			$pae_loop = 1;
		} else {
			++$pae_loop;
		}

		$paging          = 'paged' . $pae_loop;
		$paged           = isset( $_GET[ $paging ] ) ? absint( $_GET[ $paging ] ) : 1;
		$pagination_base = add_query_arg( $paging, '%#%' );

		// Grid ID.
		$grid_object_id = $this->get_id();

		$render_html = '<div id="pae-wc-products-' . esc_attr( $grid_object_id ) . '" class="woocommerce pae-grids pae-' . esc_attr( $product_layout ) . ' columns-' . esc_attr( $product_grid_columns_mobile ) . ' columns-sm-' . esc_attr( $product_grid_columns_tablet ) . ' columns-lg-' . esc_attr( $product_grid_columns ) . ' ' . esc_attr( $product_extra_class ) . ' pae-grid-style-' . esc_attr( $product_grid_style ) . ' pae-' . esc_attr( $product_layout ) . '-container" data-id="' . esc_attr( $grid_object_id ) . '" data-infinite="' . esc_attr( $product_infinite ) . '">';

			// Data Query.
			$params = [
				'posts_per_page' => absint( $product_item_number ),
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'paged'          => $paged,
				'order'          => esc_attr( $product_order ),
				'orderby'        => esc_attr( $product_orderby ),
			];

			$tq_items = [];

			if ( ! empty( $products_categories ) ) {
				$tq_items[] = [
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => (array) $products_categories,
				];
			}

			if ( '_featured' === $product_filter ) {
				$tq_items[] = [
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
				];
			}

			if ( ! empty( $tq_items ) ) {
				$params['tax_query'] = $tq_items;
			}

			if ( '_sale_price' === $product_filter ) {
				$params['post__in'] = array_merge( [ 0 ], wc_get_product_ids_on_sale() );
			}

			$wc_query = new \WP_Query( $params );

			if ( $wc_query->have_posts() ) {

				while ( $wc_query->have_posts() ) :
					$wc_query->the_post();
					global $product;

					$offset = wp_rand( -1, 1 ) / 25;

					// Get Product Informations.
					$sale_price    = $product->get_sale_price();
					$regular_price = $product->get_regular_price();
					$price         = $product->get_price();
					$rating        = wc_get_rating_html( $product->get_average_rating() );
					$review_count  = $product->get_review_count();
					$product_title = esc_html( get_the_title() );
					$product_type  = $product->get_type();
					$product_link  = get_permalink();

					// Out of stock label.
					$nostock = '';

					// Cart Button Type.
					$ajax_class  = '';
					$icon_text   = '';
					$target      = '';
					$button_link = 'javascript:void(0);';

					// Button Icon.
					switch ( $product_type ) {
						case 'external':
							$icon_text   = PAE_Utils::get_icon( 'external' );
							$target      = 'target="_blank"';
							$button_link = $product_link;
							break;

						case 'grouped':
							$icon_text = PAE_Utils::get_icon( 'link' );
							break;

						case 'simple':
							$icon_text   = PAE_Utils::get_icon( 'cart' ) . PAE_Utils::get_icon( 'spinner' ) . PAE_Utils::get_icon( 'check' );
							$button_link = esc_url( get_permalink() ) . '?add-to-cart=' . esc_attr( get_the_ID() );
							$ajax_class .= 'product_type_simple add_to_cart_button ajax_add_to_cart';
							break;

						case 'variable':
							$icon_text = PAE_Utils::get_icon( 'cog' );
							break;
					}

					$featured_class = $product->is_featured() ? ' pae-featured-product' : '';

					// HTML Makeup below.
					$render_html .= '<div class="pae-grid-item' . $featured_class . ' pae-wc-product-item pae-wc-product-item-' . get_the_ID() . ' ' . esc_attr( $product_grid_shape ) . '">';

						// Highlight Label.
					if ( $product->is_on_sale() && 'yes' === $product_onsale_label ) {
						$render_html .= '<span class="on-sale">' . esc_html__( 'Sale!', 'prime-addons-for-elementor' ) . '</span>';
					}

						// Thumbnail & Title & Cart Button.
						$render_html .= '<div class="pae-grid-thumbnail product-showcase">';
					if ( $product->is_featured() && 'yes' === $product_featured_label ) {
						$render_html .= '<span class="featured">' . esc_html__( 'Featured!', 'prime-addons-for-elementor' ) . '</span>';
					}

						// Thumbnail.
						$attachment_ids = $product->get_gallery_image_ids();
						$hover_image    = '';
						$attachment_id  = '';

					if ( count( $attachment_ids ) > 0 && isset( $attachment_ids[0] ) ) {
						$attachment_id = $attachment_ids[0];
						$hover_image   = '<span class="product-hover-image" style="background-image:url(' . esc_url( wp_get_attachment_url( $attachment_id ) ) . ');background-size:cover;background-position:center;"></span>';
					}

						$render_html .= $hover_image;

					if ( has_post_thumbnail() ) {
							$render_html .= get_the_post_thumbnail( get_the_ID(), $product_thumbnail_size );
					}

					if ( 'default' === $product_grid_style || '' === $product_grid_style ) {

						$render_html .= '<div class="overlay">';

						// Add to cart button.
						$render_html .= '<div class="button-area pae-cart-button">';

						$render_html .= '<a href="' . esc_url( $product_link ) . '" class="view grid-button">' . PAE_Utils::get_icon( 'plus' ) . '</a>';

						if ( 'yes' === $products_show_button && $product->is_in_stock() ) {

							$render_html .= '
							<a href="' . esc_url( $button_link ) . '"
							data-quantity="1" data-product_id="' . $product->get_id() . '"
							class="buy grid-button pae-carousel-button alt add_to_cart_button product_type_simple ' . esc_attr( $ajax_class ) . '">' . $icon_text . '</a>';

						}
						$render_html .= '</div></div>';

						// Overlay Grid Style.
					} elseif ( 'overlay' === $product_grid_style ) {
						$render_html .= '<div class="overlay">

						<h3 class="pae-grid-title"><a href="' . esc_url( $product_link ) . '" ' . $target . '>' . esc_html( get_the_title() ) . '</a></h3>';

						// Star Rating.
						$average = $product->get_average_rating();
						if ( $average ) {
							/* translators: %s: rating */
							$render_html .= '<div class="star-rating" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'prime-addons-for-elementor' ), $average ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'prime-addons-for-elementor' ) . '</span></div>';
						}

						// Price.
						if ( 'yes' === $products_show_price ) {
							if ( '' !== $sale_price && '0' !== $sale_price ) {
								$render_html .= '<span class="sale-price">' . wc_price( $sale_price ) . '</span>';
								$render_html .= '<del class="regular-price">' . wc_price( $regular_price ) . '</del>';
							} else {
								$render_html .= '<span class="price">' . wc_price( $price ) . '</span>';
							}
						}

						// Button.
						if ( 'yes' === $products_show_button && $product->is_in_stock() ) {
							$render_html .= '<div class="button-area pae-cart-button">
									<a href="' . esc_url( $button_link ) . '" data-quantity="1" data-product_id="' . $product->get_id() . '" class="buy grid-button pae-carousel-button ' . esc_attr( $ajax_class ) . '">' . $icon_text . '</a>
								</div>';
						}

						$render_html .= '</div>';
					}

					$render_html .= '</div>';

					// Grid Default Style.
					if ( 'default' === $product_grid_style || '' === $product_grid_style ) {

						// Product Title.
						$render_html .= '<h3 class="pae-grid-title"><a href="' . esc_url( $product_link ) . '" ' . $target . '>' . esc_html( get_the_title() ) . '</a>' . $nostock . '</h3>';

						// Star Rating.
						$average = $product->get_average_rating();
						if ( $average ) {
							/* translators: %s: rating */
							$render_html .= '<div class="star-rating" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'prime-addons-for-elementor' ), $average ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'prime-addons-for-elementor' ) . '</span></div>';
						}

						// Price.
						if ( 'yes' === $products_show_price ) {
							if ( '' !== $sale_price && '0' !== $sale_price ) {
								$render_html .= '<span class="sale-price">' . wc_price( $sale_price ) . '</span>';
								$render_html .= '<del class="regular-price">' . wc_price( $regular_price ) . '</del>';
							} else {
								$render_html .= '<span class="price">' . wc_price( $price ) . '</span>';
							}
						}
					}

					$render_html .= '</div>';
			endwhile;
				wp_reset_postdata();
			} else {
				$render_html .= '<p>' . esc_html__( 'No Products Found', 'prime-addons-for-elementor' ) . '</p>';
			}

			$render_html .= '</div>';

			if ( 'yes' === $product_pagination ) :
				$render_html .= '<div class="pae-pagenavi">';
				$render_html .= paginate_links(
					[
						'type'    => '',
						'base'    => $pagination_base,
						'format'  => '?' . $paging . '=%#%',
						'current' => max( 1, $wc_query->get( 'paged' ) ),
						'total'   => $wc_query->max_num_pages,
					]
				);
				$render_html .= '</div>';
		endif;

			echo $render_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
