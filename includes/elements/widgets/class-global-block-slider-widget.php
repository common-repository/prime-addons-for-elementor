<?php
/**
 * Widget: Global Block Slider
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
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
class Global_Block_Slider_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-slider', PAE_PLUGIN_URL . '/assets/js/widgets/slider.js', [ 'elementor-frontend', 'imagesloaded' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-global-block-slider';
	}

	public function get_title() {
		return esc_html__( 'Global Block Slider', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'global', 'slider', 'slide' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'prime-addons-elementor-slider' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_global_block',
			[
				'label' => esc_html__( 'Global Block', 'prime-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'block',
			[
				'label'       => esc_html__( 'Block', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 0,
				'show_label'  => false,
				'label_block' => true,
				'options'     => PAE_Utils::get_posts_options( 'pae_global_block' ),
			]
		);

		$this->add_control(
			'global_blocks',
			[
				'label'  => esc_html__( 'Blocks', 'prime-addons-for-elementor' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();

		do_action( 'pae_action_global_block_slider_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$global_blocks = $settings['global_blocks'];

		if ( empty( $global_blocks ) ) {
			return;
		}

		$this->add_render_attribute( 'pae-global-block-slider', 'class', 'pae-global-block-slider' );
		$this->add_render_attribute( 'pae-global-block-slider', 'class', 'pae-swiper-slider' );
		$this->add_render_attribute( 'pae-global-block-slider', 'class', 'swiper-container' );
		$this->add_render_attribute( 'pae-global-block-slider', 'class', 'swiper-container-horizontal' );
		$this->add_render_attribute( 'pae-global-block-slider', 'data-autoplay', esc_attr( $settings['slider_autoplay'] ) );

		if ( 'yes' === $settings['navigation_visible_on_hover'] ) {
			$this->add_render_attribute( 'pae-global-block-slider', 'class', 'navigation-onhover' );
		}

		$show_pagination = $settings['show_pagination'];
		$show_navigation = $settings['show_navigation'];
		?>

		<div <?php echo $this->get_render_attribute_string( 'pae-global-block-slider' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="swiper-wrapper">

				<?php foreach ( $global_blocks as $item ) : ?>
					<div class="swiper-slide">
						<?php echo Plugin::instance()->frontend->get_builder_content_for_display( $item['block'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endforeach; ?>

			</div><!-- .swiper-wrapper -->

			<?php if ( 'yes' === $show_pagination ) : ?>
				<div class="swiper-pagination"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $show_navigation ) : ?>
				<div class="swiper-button-next"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
				<div class="swiper-button-prev"><span><?php echo PAE_Utils::get_svg( 'icon-chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
			<?php endif; ?>
		</div><!-- .pae-global-block-slider .swiper-container -->
		<?php
	}
}
