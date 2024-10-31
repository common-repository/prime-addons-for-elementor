<?php
/**
 * Widget: Typing
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use PrimeAddonsElementor\Elements\Helpers\Utils as PAE_Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typing widget class.
 *
 * @since 1.0.0
 */
class Typing_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-typed', PAE_PLUGIN_URL . '/third-party/typed/typed.js', [], '2.0.12', false );
		wp_register_script( 'prime-addons-elementor-typing', PAE_PLUGIN_URL . '/assets/js/widgets/typing.js', [ 'elementor-frontend', 'prime-addons-elementor-typed' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-typing';
	}

	public function get_title() {
		return esc_html__( 'Typing', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-pencil';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_keywords() {
		return [ 'typing', 'text', 'type', 'typewriter' ];
	}

	public function get_script_depends() {
		return [ 'prime-addons-elementor-typing' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_typing_text',
			[
				'label' => esc_html__( 'Typing', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'static_text',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Static Text', 'prime-addons-for-elementor' ),
				'default' => esc_html__( 'Static Text', 'prime-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'       => false,
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Sample Text', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'typing_text',
			[
				'label'         => esc_html__( 'Typing Text', 'prime-addons-for-elementor' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ item_text }}}',
				'prevent_empty' => true,
				'default'       => [
					[
						'item_text' => 'Sample Text',
					],
					[
						'item_text' => 'Hello World',
					],
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => PAE_Utils::get_alignment_options(),
				'selectors' => [
					'{{WRAPPER}} .pae-typing' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_static_style',
			[
				'label' => esc_html__( 'Static Text', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'static_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-typing-static' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'static_typography',
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-typing-static',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_typing_style',
			[
				'label' => esc_html__( 'Typing Text', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'typing_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pae-typing-text, {{WRAPPER}} .typed-cursor' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typing_typography',
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-typing-text, {{WRAPPER}} .typed-cursor',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-typing', 'class', 'pae-typing' );

		$dynamic_texts = [];

		if ( ! empty( $settings['typing_text'] ) ) {
			$dynamic_texts = wp_list_pluck( $settings['typing_text'], 'item_text' );
			$dynamic_texts = array_filter( $dynamic_texts );
		}

		$this->add_render_attribute( 'pae-typing', 'data-texts', implode( '||', $dynamic_texts ) );

		$this->add_render_attribute( 'pae-typing-dynamic', 'class', 'pae-typing-text' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-typing' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<span class="pae-typing-static"><?php echo esc_html( $settings['static_text'] ); ?></span>
			<span <?php echo $this->get_render_attribute_string( 'pae-typing-dynamic' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></span>
		</div>
		<?php
	}
}
