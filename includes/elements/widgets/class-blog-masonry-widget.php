<?php
/**
 * Widget: Blog Masonry
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
 * Blog Masonry widget class.
 *
 * @since 1.0.0
 */
class Blog_Masonry_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-isotope', PAE_PLUGIN_URL . '/third-party/isotope/isotope.js', [], '2.0.12', false );
		wp_register_script( 'prime-addons-elementor-infinite-scroll', PAE_PLUGIN_URL . '/third-party/infinite-scroll/infinite-scroll.js', [], '2.0.12', false );
		wp_register_script( 'prime-addons-elementor-grid', PAE_PLUGIN_URL . '/assets/js/widgets/grid.js', [ 'elementor-frontend', 'prime-addons-elementor-isotope', 'imagesloaded', 'prime-addons-elementor-infinite-scroll' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-blog-masonry';
	}

	public function get_title() {
		return esc_html__( 'Blog Masonry', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-masonry';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'blog', 'post', 'masonry', 'grid' ];
	}

	public function get_script_depends() {
		return [ 'prime-addons-elementor-grid' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_blog_masonry_post',
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
				'default'     => 20,
				'condition'   => [
					'show_excerpt' => 'yes',
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

		do_action( 'pae_action_blog_masonry_controls', $this );

		$this->start_controls_section(
			'section_blog_masonry_layout',
			[
				'label' => esc_html__( 'Layout', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			]
		);

		$this->add_responsive_control(
			'row_gap',
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

		$this->start_controls_section(
			'section_blog_masonry_title_style',
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
			'section_blog_masonry_category_style',
			[
				'label'     => esc_html__( 'Category', 'prime-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .category-link, {{WRAPPER}} .category-link a' => 'color: {{VALUE}};',
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
			'standard_cats_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .category-link:hover, {{WRAPPER}} .category-link:hover a' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .category-link, {{WRAPPER}} .category-link a',
				'condition' => [
					'post_meta_category' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'cats_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .category-link' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition' => [
					'post_meta_category' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_masonry_meta_style',
			[
				'label'      => esc_html__( 'Meta Text', 'prime-addons-for-elementor' ),
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
				'selector'   => '{{WRAPPER}} .pae-post .meta, {{WRAPPER}} .pae-post .meta a',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'post_meta_date',
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
			'section_blog_masonry_excerpt_style',
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
				'default'   => '#666',
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
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_blog_masonry_pagination_style',
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

		$columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$this->add_render_attribute( 'pae-masonry-blog', 'class', 'pae-grids pae-masonry pae-masonry-container pae-masonry-blog' );
		$this->add_render_attribute( 'pae-masonry-blog', 'class', 'columns-sm-' . $columns_mobile . ' columns-md-' . $columns_tablet . ' columns-lg-' . $columns );
		?>

		<div <?php echo $this->get_render_attribute_string( 'pae-masonry-blog' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
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
					<div class="pae-grid-item pae-post <?php echo esc_attr( $settings['shape'] ); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="pae-post-thumbnail"><a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>" alt="" />
							</a>
							</div><!-- .pae-post-thumbnail -->
						<?php endif; ?>

						<div class="pae-post-entry">
							<?php if ( 'yes' === $settings['post_meta_category'] ) : ?>
								<span class="category-link" itemprop="category"><?php echo get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<?php endif; ?>

							<h4 class="pae-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

							<div class="meta">

								<?php if ( 'yes' === $settings['post_meta_date'] ) : ?>
									<a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="datePublished" content="<?php echo esc_attr( get_the_date( get_option( 'date_format' ) ) ); ?>" class="meta-item"><?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?></a>
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
