<?php
/**
 * Widget: Interactive Banner
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\utils;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Interactive Banner widget class.
 *
 * @since 1.0.0
 */
class Interactive_Banner_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-interactive-banner';
	}

	public function get_title() {
		return esc_html__( 'Interactive Banner', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'banner', 'interactive' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_interactive_banner',
			[
				'label' => esc_html__( 'Banner Settings', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'picture',
			[
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Upload Picture', 'prime-addons-for-elementor' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'picture_url',
			[
				'type'  => Controls_Manager::URL,
				'label' => esc_html__( 'Picture Link', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Sample Title', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'hide_title',
			[
				'label'     => esc_html__( 'Hide Title By Default', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'prime-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'prime-addons-for-elementor' ),
				'default'   => '',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Height', 'prime-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .pae-interactive-banner > a' => 'height: {{SIZE}}{{UNIT}};',
				],
				'default'   => [
					'size' => 500,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1200,
						'step' => 5,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_interactive_banner_style',
			[
				'label' => esc_html__( 'Text Style', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'text_style' );

		$this->start_controls_tab(
			'normal',
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
					'{{WRAPPER}} .pae-interactive-banner .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-interactive-banner .title' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'title_border',
				'selector' => '{{WRAPPER}} .pae-interactive-banner .title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__( 'Hover', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pae-interactive-banner .title:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'prime-addons-for-elementor' ),
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .pae-interactive-banner .title:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'title_border_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .pae-interactive-banner .title:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'typo_divider',
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
				'selector' => '{{WRAPPER}} .pae-interactive-banner .title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-interactive-banner .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'prime-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pae-interactive-banner .title'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_box_shadow',
				'selector' => '{{WRAPPER}} .pae-interactive-banner .title',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-interactive-banner', 'class', 'pae-interactive-banner' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-interactive-banner' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			if ( ! empty( $settings['picture_url']['url'] ) ) {
				$this->add_link_attributes( 'picture_url', $settings['picture_url'] );
			}

			if ( ! empty( $settings['picture']['url'] ) ) {
				$this->add_render_attribute( 'picture', 'src', $settings['picture']['url'] );
				if ( ! empty( $settings['title'] ) ) {
					$this->add_render_attribute( 'picture', 'alt', $settings['title'] );
				} else {
					$this->add_render_attribute( 'picture', 'alt', Control_Media::get_image_alt( $settings['picture'] ) );
				}

				$this->add_render_attribute( 'picture', 'class', 'banner-picture' );
			}
			?>

			<a <?php echo $this->get_render_attribute_string( 'picture_url' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php if ( ! empty( $settings['picture'] ) ) : ?>
					<img <?php echo $this->get_render_attribute_string( 'picture' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> />
				<?php endif; ?>

				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<?php
					$title_attrs = [
						'class' => [ 'title' ],
					];
					if ( 'yes' === $settings['hide_title'] ) {
						$title_attrs['class'][] = 'pae-hidden-title';
					}
					?>
					<div class="pae-content">
					<span <?php PAE_Utils::render_attr( $title_attrs ); ?>><?php echo esc_html( $settings['title'] ); ?></span>
					</div>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}
}
