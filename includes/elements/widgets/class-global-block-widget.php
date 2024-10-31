<?php
/**
 * Widget: Global Block
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Global Block widget class.
 *
 * @since 1.0.0
 */
class Global_Block_Widget extends Widget_Base {
	public function get_name() {
		return 'pae-global-block';
	}

	public function get_title() {
		return esc_html__( 'Global Block', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-inner-section';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'global', 'block' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_global_block',
			[
				'label' => esc_html__( 'Global Block', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'global_block_id',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Select Block:', 'prime-addons-for-elementor' ),
				'default' => 0,
				'options' => PAE_Utils::get_posts_options( 'pae_global_block' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		echo Plugin::instance()->frontend->get_builder_content_for_display( $settings['global_block_id'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
