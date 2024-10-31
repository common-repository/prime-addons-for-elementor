<?php
/**
 * Widget: Picture Carousel
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\utils;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Picture Carousel widget class.
 *
 * @since 1.0.0
 */
class Picture_Carousel_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-carousel', PAE_PLUGIN_URL . '/assets/js/widgets/carousel.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-picture-carousel';
	}

	public function get_title() {
		return esc_html__( 'Picture Carousel', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'image', 'picture', 'carousel' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-carousel' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_picture_carousel_images',
			[
				'label' => esc_html__( 'Picture Carousel', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::URL,
			]
		);

		$this->add_control(
			'carousel_items',
			[
				'label'       => esc_html__( 'Carousel Items', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => [
					[
						'title'    => 'Item #1',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
					[
						'title'    => 'Item #2',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
					[
						'title'    => 'Item #3',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
					[
						'title'    => 'Item #4',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_picture_carousel_after_main_controls', $this );

		$this->start_controls_section(
			'section_picture_carousel_layout_settings',
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
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
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

		do_action( 'pae_action_picture_carousel_after_layout_settings_controls', $this );

		$this->start_controls_section(
			'section_picture_carousel_grid_style',
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

		do_action( 'pae_action_picture_carousel_after_box_style_controls', $this );

		$this->start_controls_section(
			'section_edd_product_carousel_title_style',
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
					'{{WRAPPER}} .pae-carousel-title'   => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pae-carousel-title a, {{WRAPPER}} .pae-carousel-title',
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

		do_action( 'pae_action_picture_carousel_after_title_style_controls', $this );

		$this->start_controls_section(
			'section_edd_product_carousel_content_style',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-carousel-excerpt',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-carousel-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 5,
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

		do_action( 'pae_action_picture_carousel_after_content_style_controls', $this );

		$this->start_controls_section(
			'section_picture_carousel_overlay_style',
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

		do_action( 'pae_action_picture_carousel_after_overlay_style_controls', $this );
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

		$carousel_items = $settings['carousel_items'];

		$grid_style = $settings['grid_style'];

		$carousel_id = 'pae-carousel-' . $this->get_id();

		$extra_class = '';

		$extra_class .= esc_attr( $settings['shape'] );

		if ( 'overlay' === $grid_style ) {
			$extra_class .= ' overlay-content';
		}

		if ( 'yes' === $show_pagination ) {
			$extra_class .= ' has-pagination';
		}

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$extra_class .= ' navigation-onhover';
		}

		$boxed_class = ( 'yes' === $settings['boxed'] ) ? 'boxed' : '';

		$hover_effect_class = ( 'yes' === $settings['hover_effect'] ) ? 'scale' : '';

		$wrapper_attrs = [
			'id'              => $carousel_id,
			'data-columns-sm' => $columns_mobile,
			'data-columns-md' => $columns_tablet,
			'data-columns'    => $columns,
			'data-gap-sm'     => $gap_mobile,
			'data-gap-md'     => $gap_tablet,
			'data-gap'        => $gap,
			'data-autoplay'   => $autoplay,
		];

		$wrapper_attrs['class'] = [ 'pae-carousel', 'swiper-container' ];

		if ( ! empty( $extra_class ) ) {
			$wrapper_attrs['class'][] = $extra_class;
		}
		?>

		<div <?php PAE_Utils::render_attr( $wrapper_attrs ); ?>>

			<div class="swiper-wrapper">

				<?php if ( ! empty( $carousel_items ) ) : ?>

					<?php $cnt = 0; ?>

					<?php foreach ( $carousel_items as $item ) : ?>
						<?php
						if ( ! empty( $item['link']['url'] ) ) {
							$this->add_link_attributes( "item_link_{$cnt}", $item['link'] );
							$this->add_render_attribute( "item_link_{$cnt}", 'class', 'title' );
						}
						?>

						<div class="swiper-slide pae-carousel-item <?php echo esc_attr( $boxed_class ); ?>">

							<?php if ( ! empty( $item['link']['url'] ) ) : ?>
								<a <?php echo $this->get_render_attribute_string( "item_link_{$cnt}" ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php endif; ?>
								<div class="pae-carousel-thumbnail <?php echo esc_attr( $hover_effect_class ); ?>">
									<?php if ( ! empty( $item['image']['id'] ) ) : ?>
										<?php $img_detail = wp_get_attachment_image_src( $item['image']['id'], esc_attr( $settings['image_size'] ) ); ?>
										<?php if ( $img_detail ) : ?>
											<img src="<?php echo esc_url( $img_detail[0] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" />
										<?php endif; ?>
									<?php endif; ?>

									<div class="overlay">
										<?php if ( 'overlay' === $grid_style ) : ?>
											<?php if ( ! empty( $item['title'] ) ) : ?>
												<h4 class="pae-carousel-title">
													<?php if ( ! empty( $item['link']['url'] ) ) : ?>
														<a <?php echo $this->get_render_attribute_string( "item_link_{$cnt}" ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $item['title'] ); ?></a>
														<?php else : ?>
															<?php echo esc_html( $item['title'] ); ?>
													<?php endif; ?>
												</h4>
											<?php endif; ?>
											<?php if ( ! empty( $item['subtitle'] ) ) : ?>
												<div class="pae-carousel-excerpt"><?php echo wp_kses_post( wpautop( $item['subtitle'] ) ); ?></div>
											<?php endif; ?>
										<?php endif; ?>
									</div><!-- .overlay -->
								</div><!-- .pae-carousel-thumbnail -->
							<?php if ( ! empty( $item['link']['url'] ) ) : ?>
								</a>
							<?php endif; ?>

							<?php if ( 'default' === $grid_style ) : ?>
								<?php if ( ! empty( $item['title'] ) ) : ?>
									<h4 class="pae-carousel-title">
										<?php if ( ! empty( $item['link']['url'] ) ) : ?>
											<a <?php echo $this->get_render_attribute_string( "item_link_{$cnt}" ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $item['title'] ); ?></a>
											<?php else : ?>
												<?php echo esc_html( $item['title'] ); ?>
										<?php endif; ?>
									</h4>
								<?php endif; ?>

								<?php if ( ! empty( $item['subtitle'] ) ) : ?>
									<div class="pae-carousel-excerpt"><?php echo wp_kses_post( wpautop( $item['subtitle'] ) ); ?></div>
								<?php endif; ?>
							<?php endif; ?>

						</div><!-- .swiper-slide -->

						<?php ++$cnt; ?>

					<?php endforeach; ?>

					<?php else : ?>

						<div class="swiper-slide pae-carousel-item"><p><?php esc_html_e( 'No item found', 'prime-addons-for-elementor' ); ?></p></div>

				<?php endif; ?>

				</div><!-- .swiper-wrapper -->

				<?php if ( 'yes' === $show_pagination ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
				<?php if ( 'yes' === $show_navigation ) : ?>
					<div class="swiper-button-next"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
					<div class="swiper-button-prev"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
				<?php endif; ?>

		</div><!-- .pae-carousel -->
		<?php
	}
}
