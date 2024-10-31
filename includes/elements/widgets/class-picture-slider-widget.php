<?php
/**
 * Widget: Picture Slider
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
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
 * Global Block Slider widget class.
 *
 * @since 1.0.0
 */
class Picture_Slider_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-slider', PAE_PLUGIN_URL . '/assets/js/widgets/slider.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-picture-slider';
	}

	public function get_title() {
		return esc_html__( 'Picture Slider', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'picture', 'slider', 'slide', 'image' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-slider' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_picture_slider',
			[
				'label' => esc_html__( 'Picture Slider', 'prime-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'featured_image',
			[
				'label' => esc_html__( 'Content Image', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'image_position',
			[
				'label'   => esc_html__( 'Image Position', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row'         => esc_html__( 'Left', 'prime-addons-for-elementor' ),
					'row-reverse' => esc_html__( 'Right', 'prime-addons-for-elementor' ),
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
			'title_wrapper',
			[
				'label'   => esc_html__( 'Title Wrapper', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => 'H1',
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'div' => 'DIV',
				],
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
			'text_color',
			[
				'label'   => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#000000',
			]
		);

		$repeater->add_control(
			'content_position',
			[
				'label'   => esc_html__( 'Content Position', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
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

		$repeater->add_control(
			'text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'align-left',
				'options' => [
					'align-left'   => esc_html__( 'Left', 'prime-addons-for-elementor' ),
					'align-center' => esc_html__( 'Center', 'prime-addons-for-elementor' ),
					'align-right'  => esc_html__( 'Right', 'prime-addons-for-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'prime-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'button_url',
			[
				'label' => esc_html__( 'Button URL', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::URL,
			]
		);

		$repeater->add_control(
			'bg_image',
			[
				'label'   => esc_html__( 'Background Image', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'slides',
			[
				'label'       => esc_html__( 'Slides', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => [
					[
						'title'    => 'Slide #1',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
					[
						'title'    => 'Slide #2',
						'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_picture_slider_title_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-picture-slider-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_picture_slider_content_style',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-picture-slider-text p',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'section_picture_slider_button_style',
			[
				'label' => esc_html__( 'Button', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .pae-picture-slider-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'    => esc_html__( 'Hover Animation', 'prime-addons-for-elementor' ),
				'type'     => Controls_Manager::HOVER_ANIMATION,
				'selector' => '{{WRAPPER}} .pae-picture-slider-button',

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-picture-slider-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pae-picture-slider-button',
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-picture-slider-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Margin Top', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-picture-slider-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 20,
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

		do_action( 'pae_action_picture_slider_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$slides                 = $settings['slides'];
		$button_hover_animation = $settings['button_hover_animation'];

		if ( empty( $slides ) ) {
			return;
		}

		$this->add_render_attribute( 'pae-picture-slider', 'class', 'pae-picture-slider' );
		$this->add_render_attribute( 'pae-picture-slider', 'class', 'pae-swiper-slider' );
		$this->add_render_attribute( 'pae-picture-slider', 'class', 'swiper-container' );
		$this->add_render_attribute( 'pae-picture-slider', 'class', 'swiper-container-horizontal' );
		$this->add_render_attribute( 'pae-picture-slider', 'data-autoplay', esc_attr( $settings['slider_autoplay'] ) );

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$this->add_render_attribute( 'pae-picture-slider', 'class', 'navigation-onhover' );
		}

		$show_pagination = $settings['show_pagination'];
		$show_navigation = $settings['show_navigation'];
		?>

		<div <?php echo $this->get_render_attribute_string( 'pae-picture-slider' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="swiper-wrapper">

			<?php foreach ( $slides as $item ) : ?>

				<?php
				if ( ! empty( $item['button_url']['url'] ) ) {
					$this->add_link_attributes( 'button_url' . $item['_id'], $item['button_url'] );
				}

				$text_color = $item['text_color'] ? 'style="color: ' . esc_attr( $item['text_color'] ) . ';"' : '';

				$title_tag = esc_attr( $item['title_wrapper'] );

				// Rendering picture background.
				if ( ! empty( $item['bg_image']['url'] ) ) {
					$background_style        = '';
					$background_style       .= 'background-image:url(' . esc_url( $item['bg_image']['url'] ) . ');';
					$background_img['style'] = $background_style;
				}
				?>

					<div class="swiper-slide swiper-lazy pae-picture-slider-item <?php echo esc_attr( $item['content_position'] ); ?>" <?php PAE_Utils::render_attr( $background_img ); ?>>
						<div class="swiper-lazy-preloader"></div>

					<?php
					if ( ! empty( $item['bg_color'] ) ) :
						$bg_color_style = $item['bg_color'] ? ' style="background-color: ' . esc_attr( $item['bg_color'] ) . ';"' : '';
						?>
							<div class="pae-picture-slider-overlay"<?php echo $bg_color_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
						<?php endif; ?>

					<?php
					if ( ! empty( $item['title'] ) || ! empty( $item['subtitle'] ) ) :

						$content_width = '';
						?>

						<div class="pae-picture-slider-content <?php echo esc_attr( $item['image_position'] ); ?>">
							<?php if ( ! empty( $item['featured_image']['url'] ) ) { ?>
							<div class="pae-picture-slider-image">
								<img src="<?php echo esc_url( $item['featured_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" />
							</div>
								<?php
							} else {
								$content_width = 'full-width';
							}
							?>

							<div class="pae-picture-slider-content-wrap <?php echo esc_attr( $content_width ) . ' ' . esc_attr( $item['text_align'] ); ?>">
								<?php
								if ( ! empty( $item['title'] ) ) :

									$title_attrs = [ 'class' => 'pae-picture-slider-title' ];

									if ( ! empty( $item['text_color'] ) ) {
										$title_attrs['style'] = 'color:' . esc_attr( $item['text_color'] );
									}

									echo PAE_Utils::content_tag( $item['title_wrapper'], $item['title'], $title_attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								endif;
								?>

								<?php
								if ( ! empty( $item['subtitle'] ) ) :

									$subtitle_attrs = [];
									if ( ! empty( $item['text_color'] ) ) {
										$subtitle_attrs['style'] = 'color:' . esc_attr( $item['text_color'] );
									}
									?>
									<div class="pae-picture-slider-text"><p <?php PAE_Utils::render_attr( $subtitle_attrs ); ?>><?php echo wp_kses_post( $item['subtitle'] ); ?></p></div>
								<?php endif; ?>

								<?php if ( ! empty( $item['button_text'] ) && ! empty( $item['button_url']['url'] ) ) : ?>
									<?php $this->add_render_attribute( 'button_url' . $item['_id'], 'class', 'pae-picture-slider-button elementor-animation-' . $button_hover_animation ); ?>

									<a <?php echo $this->get_render_attribute_string( 'button_url' . $item['_id'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_attr( $item['button_text'] ); ?></a>
								<?php endif; ?>

							</div><!-- .pae-picture-slider-content -->
						</div>
					<?php endif; ?>

					</div><!-- .swiper-slide -->

			<?php endforeach; ?>
				</div>

			<?php if ( 'yes' === $show_pagination ) : ?>
					<div class="swiper-pagination"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $show_navigation ) : ?>
					<div class="swiper-button-next"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
					<div class="swiper-button-prev"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
			<?php endif; ?>

		</div><!-- .pae-picture-slider -->

		<?php
	}
}
