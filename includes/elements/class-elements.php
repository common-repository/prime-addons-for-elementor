<?php
/**
 * Elementor module
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements;

use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;
use PrimeAddonsElementor\Elements\Traits\Controls;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elements class.
 *
 * @since 1.0.0
 */
class Elements {
	use Controls;

	/**
	 * The single instance of the class.
	 *
	 * @since 1.0.0
	 * @var Elements
	 */
	private static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Elements Class instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'frontend_styles' ], 10 );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_categories' ] );
		add_action( 'init', [ $this, 'load_files' ] );

		// Add post query settings.
		add_action( 'pae_action_blog_grid_controls', [ $this, 'query_settings' ] );
		add_action( 'pae_action_blog_masonry_controls', [ $this, 'query_settings' ] );
		add_action( 'pae_action_blog_standard_controls', [ $this, 'query_settings' ] );

		// Global block slider.
		add_action( 'pae_action_global_block_slider_controls', [ $this, 'slider_settings' ] );
		add_action( 'pae_action_global_block_slider_controls', [ $this, 'slider_style_settings' ] );

		// Picture slider.
		add_action( 'pae_action_picture_slider_controls', [ $this, 'slider_settings' ] );
		add_action( 'pae_action_picture_slider_controls', [ $this, 'slider_style_settings' ] );

		// Post slider.
		add_action( 'pae_action_post_slider_controls', [ $this, 'query_settings' ] );
		add_action( 'pae_action_post_slider_controls', [ $this, 'slider_settings' ] );
		add_action( 'pae_action_post_slider_style_controls', [ $this, 'slider_style_settings' ] );

		// Post carousel.
		add_action( 'pae_action_post_carousel_after_post_settings_controls', [ $this, 'query_settings' ] );
		add_action( 'pae_action_post_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_post_carousel_after_excerpt_style_controls', [ $this, 'carousel_style_settings' ] );

		// Woo carousel.
		add_action( 'pae_action_woo_product_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_woo_product_carousel_after_icon_style_controls', [ $this, 'carousel_style_settings' ] );

		// EDD carousel.
		add_action( 'pae_action_edd_product_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_edd_product_carousel_after_icon_style_controls', [ $this, 'carousel_style_settings' ] );

		// LP carousel.
		add_action( 'pae_action_lp_course_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_lp_course_carousel_after_icon_style_controls', [ $this, 'carousel_style_settings' ] );

		// Picture carousel.
		add_action( 'pae_action_picture_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_picture_carousel_after_overlay_style_controls', [ $this, 'carousel_style_settings' ] );

		// Testimonial carousel.
		add_action( 'pae_action_testimonial_carousel_after_layout_settings_controls', [ $this, 'carousel_settings' ] );
		add_action( 'pae_action_testimonial_carousel_after_column_style_controls', [ $this, 'carousel_style_settings' ] );
	}

	/**
	 * Load frontend styles.
	 *
	 * @since 1.0.0
	 */
	public function frontend_styles() {
		wp_register_style( 'font-awesome-5-all', ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css', false, PAE_PLUGIN_VERSION );
		wp_register_style( 'prime-addons-elementor', PAE_PLUGIN_URL . '/assets/css/prime-addons-elementor.css', [ 'font-awesome-5-all' ], PAE_PLUGIN_VERSION );
		wp_enqueue_style( 'prime-addons-elementor' );
	}

	/**
	 * Load frontend scripts.
	 *
	 * @since 1.0.0
	 */
	public function frontend_scripts() {
		wp_register_script( 'prime-addons-elementor-velocity', PAE_PLUGIN_URL . '/third-party/velocity/velocity.js', [ 'jquery' ], '1.5.2', false );
		wp_register_script( 'prime-addons-elementor', PAE_PLUGIN_URL . '/assets/js/prime-addons-elementor.js', [ 'jquery', 'prime-addons-elementor-velocity' ], PAE_PLUGIN_VERSION, true );
		wp_enqueue_script( 'prime-addons-elementor' );
	}

	public function load_files() {
	}

	/**
	 * Register widget categories.
	 *
	 * @since 1.0.0
	 *
	 * @param Elements_Manager $elements_manager The elements manager instance.
	 */
	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'prime-addons-elementor',
			[
				'title' => esc_html__( 'Prime Addons', 'prime-addons-for-elementor' ),
				'icon'  => 'eicon-font',
			],
			2
		);
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @since 1.0.0
	 *
	 * @param Widgets_Manager $widgets_manager The widgets manager instance.
	 */
	public function widgets_registered( $widgets_manager ) {
		$list = [
			'blog-grid'            => 'Blog_Grid_Widget',
			'blog-masonry'         => 'Blog_Masonry_Widget',
			'blog-standard'        => 'Blog_Standard_Widget',
			'countdown'            => 'Countdown_Widget',
			'flip-box'             => 'Flip_Box_Widget',
			'interactive-banner'   => 'Interactive_Banner_Widget',
			'global-block'         => 'Global_Block_Widget',
			'global-block-slider'  => 'Global_Block_Slider_Widget',
			'picture-carousel'     => 'Picture_Carousel_Widget',
			'picture-slider'       => 'Picture_Slider_Widget',
			'post-carousel'        => 'Post_Carousel_Widget',
			'post-slider'          => 'Post_Slider_Widget',
			'price-table'          => 'Price_Table_Widget',
			'separate-text'        => 'Separate_Text_Widget',
			'typing'               => 'Typing_Widget',
			'testimonial-carousel' => 'Testimonial_Carousel_Widget',
		];

		if ( PAE_Utils::is_cf7_active() ) {
			$list = array_merge(
				$list,
				[
					'contact-form-7' => 'Contact_Form_7_Widget',
				]
			);
		}

		if ( PAE_Utils::is_edd_active() ) {
			$list = array_merge(
				$list,
				[
					'edd-cart-button'      => 'EDD_Cart_Button_Widget',
					'edd-products'         => 'EDD_Products_Widget',
					'edd-search'           => 'EDD_Search_Widget',
					'edd-product-carousel' => 'EDD_Product_Carousel_Widget',
				]
			);
		}

		if ( PAE_Utils::is_woocommerce_active() ) {
			$list = array_merge(
				$list,
				[
					'woo-cart-button'      => 'Woo_Cart_Button_Widget',
					'woo-product-carousel' => 'Woo_Product_Carousel_Widget',
					'woo-products'         => 'Woo_Products_Widget',
				]
			);
		}

		if ( PAE_Utils::is_wedocs_active() ) {
			$list = array_merge(
				$list,
				[
					'wedocs-archive' => 'WeDocs_Archive_Widget',
					'wedocs-search'  => 'WeDocs_Search_Widget',
				]
			);
		}

		if ( PAE_Utils::is_learnpress_active() ) {
			$list = array_merge(
				$list,
				[
					'lp-course-carousel' => 'LP_Course_Carousel_Widget',
					'lp-courses'         => 'LP_Courses_Widget',
				]
			);
		}

		ksort( $list );

		foreach ( $list as $key => $class ) {
			require PAE_PLUGIN_URI . "/includes/elements/widgets/class-{$key}-widget.php";
			$class_full_name = '\PrimeAddonsElementor\Elements\Widgets\\' . $class;
			$widgets_manager->register_widget_type( new $class_full_name() );
		}
	}
}

Elements::get_instance()->init();
