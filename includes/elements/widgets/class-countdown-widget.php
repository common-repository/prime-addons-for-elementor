<?php
/**
 * Widget: Countdown
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
 * Countdown widget class.
 *
 * @since 1.0.0
 */
class Countdown_Widget extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'prime-addons-elementor-countdown', PAE_PLUGIN_URL . '/third-party/countdown/jquery.countdown.js', [], '2.2.0', false );
		wp_register_script( 'prime-addons-elementor-countdown-script', PAE_PLUGIN_URL . '/assets/js/widgets/countdown.js', [ 'elementor-frontend', 'prime-addons-elementor-countdown' ], PAE_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pae-countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'prime-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'prime-addons-elementor' ];
	}

	public function get_script_depends() {
		return [ 'prime-addons-elementor-countdown-script' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_countdown',
			[
				'label' => esc_html__( 'Countdown', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'due_date',
			[
				'label'       => esc_html__( 'Due Date', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '2023/01/01 12:00',
				'description' => esc_html__( 'Set date according to your timezone.', 'prime-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'expired_notice',
			[
				'label'       => esc_html__( 'Expired Notice', 'prime-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'This offer has expired!',
				'description' => esc_html__( 'Show the text after the time is expired.', 'prime-addons-for-elementor' ),

			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => PAE_Utils::get_alignment_options(),
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .pae-countdown' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_countdown_style',
			[
				'label' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .pae-countdown' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_expired_color',
			[
				'label'     => esc_html__( 'Text Expired Color', 'prime-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F00',
				'selectors' => [
					'{{WRAPPER}} .pae-countdown.disabled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'prime-addons-for-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pae-countdown',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'pae-countdown', 'class', 'pae-countdown' );
		$this->add_render_attribute( 'pae-countdown', 'data-expired-notice', wp_kses_post( $settings['expired_notice'] ) );
		$this->add_render_attribute( 'pae-countdown', 'data-filter', str_replace( '-', '/', wp_kses_post( $settings['due_date'] ) ) );
		?>
		<div <?php echo $this->get_render_attribute_string( 'pae-countdown' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<span class="countdown-content"></span>
		</div>
		<?php
	}
}
