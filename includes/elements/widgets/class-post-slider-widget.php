<?php
/**
 * Widget: Post Slider
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
 * Post Slider widget class.
 *
 * @since 1.0.0
 */
class Post_Slider_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-slider', PAE_PLUGIN_URL . '/assets/js/widgets/slider.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-post-slider';
	}

	public function get_title() {
		return esc_html__( 'Post Slider', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'post', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-slider' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_global_block',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'number',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Number of Posts', 'prime-addons-for-elementor' ),
				'default' => '3',
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
				'default'     => 20,
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_slider_controls', $this );

		$this->start_controls_section(
			'section_post_slider_content_style',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_content_style' );

		$this->start_controls_tab(
			'tab_content_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'   => '#00000080',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-content' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_content_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'content_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-content:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'content_overlay_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Overlay Background Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider .pae-slider-overlay' => 'background-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'text_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'prime-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 600,
				],
				'size_units' => [ 'px', '%', 'em', 'vw' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1600,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
					'vw' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pae-post-slider-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Content Position', 'prime-addons-for-elementor' ),
				'default' => 'center-center',
				'options' => [
					'top-left'      => esc_html__( 'Top Left', 'prime-addons-for-elementor' ),
					'top-center'    => esc_html__( 'Top Center', 'prime-addons-for-elementor' ),
					'top-right'     => esc_html__( 'Top Right', 'prime-addons-for-elementor' ),
					'center-left'   => esc_html__( 'Center Left', 'prime-addons-for-elementor' ),
					'center-center' => esc_html__( 'Center', 'prime-addons-for-elementor' ),
					'center-right'  => esc_html__( 'Center Right', 'prime-addons-for-elementor' ),
					'bottom-left'   => esc_html__( 'Bottom Left', 'prime-addons-for-elementor' ),
					'bottom-center' => esc_html__( 'Bottom Center', 'prime-addons-for-elementor' ),
					'bottom-right'  => esc_html__( 'Bottom Right', 'prime-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => 'true',
				],
				'selectors'  => [
					'{{WRAPPER}} .pae-post-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_slider_cats_style',
			[
				'label'     => esc_html__( 'Categories', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_meta_category' => 'yes',
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
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-categories, {{WRAPPER}} .pae-post-slider-categories a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'post_meta_category' => 'yes',
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
			'cats_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-categories a:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'post_meta_category' => 'yes',
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
				'name'      => 'cats_typography',
				'label'     => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .pae-post-slider-categories',
				'condition' => [
					'post_meta_category' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_slider_title_style',
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
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-title a' => 'color: {{VALUE}}',
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
			'title_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-title a:hover' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .pae-post-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 8,
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pae-post-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_slider_excerpt_style',
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
				'label'     => esc_html__( 'Color', 'prime-addons-for-elementor' ),
				'default'   => '#FFFFFFED',
				'selectors' => [
					'{{WRAPPER}} .pae-post-slider-excerpt p' => 'color: {{VALUE}}',
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
				'selector'  => '{{WRAPPER}} .pae-post-slider-excerpt p',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'label'      => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 8,
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pae-post-slider-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_post_slider_style_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-post-slider', 'class', 'pae-post-slider' );
		$this->add_render_attribute( 'pae-post-slider', 'class', 'pae-swiper-slider' );
		$this->add_render_attribute( 'pae-post-slider', 'class', 'swiper-container' );
		$this->add_render_attribute( 'pae-post-slider', 'class', 'swiper-container-horizontal' );
		$this->add_render_attribute( 'pae-post-slider', 'data-autoplay', esc_attr( $settings['slider_autoplay'] ) );

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$this->add_render_attribute( 'pae-post-slider', 'class', 'navigation-onhover' );
		}

		$show_pagination = $settings['show_pagination'];
		$show_navigation = $settings['show_navigation'];

		$qargs = PAE_Utils::get_blog_query_args( $settings );

		$the_query = new \WP_Query( $qargs );
		?>

		<div <?php echo $this->get_render_attribute_string( 'pae-post-slider' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="swiper-wrapper">

				<?php if ( $the_query->have_posts() ) : ?>

					<?php
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						?>

						<?php
						$slide_attrs = [];

						if ( has_post_thumbnail() ) {
							$image_url = get_the_post_thumbnail_url( get_the_ID(), $settings['image_size'] );

							$slide_attrs['style'] = 'background-image:url(' . esc_url( $image_url ) . ');';
						}
						?>

						<div class="swiper-slide swiper-lazy <?php echo esc_attr( $settings['layout'] ); ?>" <?php PAE_Utils::render_attr( $slide_attrs ); ?>>
							<div class="swiper-lazy-preloader"></div>

							<div class="pae-slider-overlay"></div>

							<div class="pae-slider-content pae-post-slider-content text-align-<?php echo esc_attr( $settings['text_alignment'] ); ?>">
							<?php if ( 'yes' === $settings['post_meta_category'] ) : ?>
								<span class="pae-post-slider-categories"><?php echo get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<?php endif; ?>

							<h3 class="pae-post-slider-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<?php
							if ( 'yes' === $settings['show_excerpt'] ) {
								?>
								<div class="pae-post-slider-excerpt">
									<?php
									$excerpt = PAE_Utils::get_post_excerpt( absint( $settings['excerpt_length'] ) );
									echo wp_kses_post( wpautop( $excerpt ) );
									?>
								</div>
							<?php } ?>
							</div><!-- .pae-post-slider-content -->
						</div><!-- .swiper-slide -->

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				<?php endif; ?>

			</div><!-- .swiper-wrapper -->

			<?php if ( 'yes' === $show_pagination ) : ?>
				<div class="swiper-pagination"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $show_navigation ) : ?>
				<div class="swiper-button-next"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
				<div class="swiper-button-prev"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
			<?php endif; ?>
		</div><!-- .pae-post-slider .swiper-container -->

		<?php
	}
}
