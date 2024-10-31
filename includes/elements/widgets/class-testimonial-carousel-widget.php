<?php
/**
 * Widget: Testimonial Carousel
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
 * Testimonial Carousel widget class.
 *
 * @since 1.0.0
 */
class Testimonial_Carousel_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-carousel', PAE_PLUGIN_URL . '/assets/js/widgets/carousel.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-testimonial-carousel';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'slider', 'slide', 'carousel' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-carousel' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_testimonials',
			[
				'label' => esc_html__( 'Testimonials', 'prime-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'job',
			[
				'label' => esc_html__( 'Position', 'prime-addons-for-elementor' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'avatar',
			[
				'label'   => esc_html__( 'Avatar', 'prime-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'said',
			[
				'label'      => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::TEXTAREA,
				'show_label' => false,
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__( 'Testimonials', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => [
					[
						'name' => 'John Doe',
						'job'  => 'Manager',
						'said' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					],
					[
						'name' => 'Jane Doe',
						'job'  => 'Designer',
						'said' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					],
					[
						'name' => 'Ben Smith',
						'job'  => 'Accountant',
						'said' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					],
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_testimonial_carousel_after_testimonial_settings_controls', $this );

		$this->start_controls_section(
			'section_testimonial_settings',
			[
				'label' => esc_html__( 'Settings', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'              => esc_html__( 'Text Alignment', 'prime-addons-for-elementor' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => PAE_Utils::get_alignment_options(),
				'default'            => 'center',
				'frontend_available' => true,
				'selectors'          => [
					'{{WRAPPER}} .testimonial-text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_quotation_marks',
			[
				'label'     => esc_html__( 'Show Quotation Marks', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_opening_quotation_mark',
			[
				'label'     => esc_html__( 'Show Opening Quotation Mark', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => [
					'show_quotation_marks' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_closing_quotation_mark',
			[
				'label'     => esc_html__( 'Show Closing Quotation Mark', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'prime-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => [
					'show_quotation_marks' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_testimonial_carousel_after_layout_settings_controls', $this );

		// Style Tab.
		do_action( 'pae_action_testimonial_carousel_after_quotation_style_controls', $this );

		$this->start_controls_section(
			'section_testimonial_slide_style',
			[
				'label' => esc_html__( 'Boxed', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_background_color',
			[
				'label'     => __( 'Background Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-testimonial-carousel .swiper-slide' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slide_border',
				'selector' => '{{WRAPPER}} .pae-testimonial-carousel .swiper-slide',
			]
		);

		$this->add_control(
			'slide_border_radius',
			[
				'label'      => __( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-testimonial-carousel .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slide_padding',
			[
				'label'      => __( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-testimonial-carousel .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_name_style',
			[
				'label' => esc_html__( 'Name', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pae-testimonial-carousel .author-detail' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_name',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-testimonial-carousel .author-detail',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_title_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pae-testimonial-carousel .author-detail em' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_title',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-testimonial-carousel .author-detail em',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_style',
			[
				'label' => esc_html__( 'Content', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-text, {{WRAPPER}} .testimonial-text p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_content',
				'label'    => esc_html__( 'Content Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .testimonial-text p',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_testimonial_carousel_after_content_style_controls', $this );

		$this->start_controls_section(
			'section_testimonials_quotation_marks_style',
			[
				'label'     => esc_html__( 'Quotation Marks', 'prime-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_quotation_marks' => 'yes',
				],
			]
		);

		$this->add_control(
			'quotation_color',
			[
				'label'     => esc_html__( 'Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#dddddd',
				'selectors' => [
					'{{WRAPPER}} .testimonial-text::before,{{WRAPPER}} .testimonial-text::after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_quotation_marks' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quotation_marks_content',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .testimonial-text::before,{{WRAPPER}} .testimonial-text::after',
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_testimonial_carousel_after_column_style_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['testimonials'] ) ) {
			return;
		}

		$columns        = isset( $settings['columns'] ) ? $settings['columns'] : 3;
		$columns_tablet = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$columns_mobile = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$gap        = isset( $settings['gap']['size'] ) ? $settings['gap']['size'] : 30;
		$gap_tablet = isset( $settings['gap_tablet']['size'] ) ? $settings['gap_tablet']['size'] : 20;
		$gap_mobile = isset( $settings['gap_mobile']['size'] ) ? $settings['gap_mobile']['size'] : 0;

		$show_pagination = $settings['show_pagination'];

		$has_pagination = '';

		if ( 'yes' === $show_pagination ) {
			$has_pagination = ' has-pagination';
		}

		$show_navigation = $settings['show_navigation'];

		$this->add_render_attribute( 'pae-testimonial-carousel', 'class', [ 'pae-testimonial-carousel', 'pae-carousel', 'swiper-container', 'pae-slide-' . esc_attr( $settings['alignment'] ), $has_pagination ] );

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$this->add_render_attribute( 'pae-testimonial-carousel', 'class', 'navigation-onhover' );
		}

		$this->add_render_attribute(
			'pae-testimonial-carousel',
			[
				'data-columns-sm' => esc_attr( $columns_mobile ),
				'data-columns-md' => esc_attr( $columns_tablet ),
				'data-columns'    => esc_attr( $columns ),
				'data-gap-sm'     => esc_attr( $gap_mobile ),
				'data-gap-md'     => esc_attr( $gap_tablet ),
				'data-gap'        => esc_attr( $gap ),
				'data-autoplay'   => esc_attr( $settings['carousel_autoplay'] ),
				'data-direction'  => 'horizontal',
			]
		); ?>

		<div <?php echo $this->get_render_attribute_string( 'pae-testimonial-carousel' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<div class="swiper-wrapper">

				<?php foreach ( $settings['testimonials'] as $item ) : ?>

					<div class="swiper-slide">
						<?php if ( ! empty( $item['said'] ) ) : ?>

							<?php
							$text_class = '';

							if ( 'yes' === $settings['show_quotation_marks'] ) {
								if ( 'yes' === $settings['show_opening_quotation_mark'] ) {
									$text_class .= ' quotation-marks-opening';
								}
								if ( 'yes' === $settings['show_closing_quotation_mark'] ) {
									$text_class .= ' quotation-marks-closing';
								}

								if ( 'yes' === $settings['show_opening_quotation_mark'] || 'yes' === $settings['show_closing_quotation_mark'] ) {
									$text_class .= ' quotation-marks';
								}
							}
							?>

							<div class="testimonial-text <?php echo esc_attr( trim( $text_class ) ); ?>"><?php echo wp_kses_post( wpautop( $item['said'] ) ); ?></div>
						<?php endif; ?>

						<footer class="testimonial-author">
							<?php if ( ! empty( $item['avatar']['url'] ) ) : ?>
								<img src="<?php echo esc_url( $item['avatar']['url'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" class="avatar" />
							<?php endif; ?>

							<?php if ( ! empty( $item['name'] ) ) : ?>
								<span class="author-detail">
									<?php echo esc_html( $item['name'] ); ?>
									<?php if ( ! empty( $item['job'] ) ) : ?>
										<em><?php echo esc_html( $item['job'] ); ?></em>
									<?php endif; ?>
								</span>
							<?php endif; ?>

						</footer><!-- .testimonial-author -->
					</div><!-- .swiper-slide -->

				<?php endforeach; ?>

			</div><!-- .swiper-wrapper -->

			<?php if ( 'yes' === $show_pagination ) : ?>
				<div class="swiper-pagination"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $show_navigation ) : ?>
				<div class="swiper-button-next"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
				<div class="swiper-button-prev"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
			<?php endif; ?>

		</div><!-- .pae-testimonial-carousel -->
		<?php
	}
}
