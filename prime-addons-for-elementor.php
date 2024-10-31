<?php
/**
 * Plugin Name: Prime Addons for Elementor
 * Description: Prime Addons for Elementor features 25+ beautiful and highly customizable Elementor widgets. Each widget comes with tons of easy-to-use options that will allow you to build professional Elementor websites in a few clicks with no coding required.
 * Plugin URI: https://www.nilambar.net/plugins/prime-addons-for-elementor/
 * Version: 2.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: prime-addons-for-elementor
 * Domain Path: /languages
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins: elementor
 * Elementor tested up to: 3.23.3
 *
 * @package Prime_Addons_Elementor
 */

use Nilambar\AdminNotice\Notice;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define.
define( 'PAE_PLUGIN_FILE', __FILE__ );
define( 'PAE_PLUGIN_VERSION', '2.0.1' );
define( 'PAE_PLUGIN_SLUG', 'prime-addons-for-elementor' );
define( 'PAE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'PAE_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'PAE_PLUGIN_URI', rtrim( plugin_dir_path( __FILE__ ), '/' ) );

// Init autoload.
require_once PAE_PLUGIN_URI . '/vendor/autoload.php';

/**
 * Main plugin class.
 *
 * @since 1.0.0
 */
final class Prime_Addons_Elementor_Main {

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = PAE_PLUGIN_VERSION;

	/**
	 * Minimum elementor version.
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP version.
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Load translation.
		add_action( 'init', [ $this, 'i18n' ] );

		// Init plugin.
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load textdomain.
	 *
	 * @since 1.0.0
	 */
	public function i18n() {
		load_plugin_textdomain( 'prime-addons-for-elementor' );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add admin notice.
		add_action( 'admin_init', [ $this, 'setup_custom_notice' ] );

		// Once we get here, We have passed all validation checks so we can safely include our plugin.
		require_once PAE_PLUGIN_URI . '/plugin.php';
	}

	/**
	 * Admin notice for missing main plugin.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'prime-addons-for-elementor' ),
			'<strong>' . esc_html__( 'Prime Addons for Elementor', 'prime-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'prime-addons-for-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin notice for minimum Elementor version.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Requirement 3: Required version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'prime-addons-for-elementor' ),
			'<strong>' . esc_html__( 'Prime Addons for Elementor', 'prime-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'prime-addons-for-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin notice for minimum PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Requirement 3: Required version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'prime-addons-for-elementor' ),
			'<strong>' . esc_html__( 'Prime Addons for Elementor', 'prime-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'prime-addons-for-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Setup admin notice.
	 *
	 * @since 1.0.8
	 * @access public
	 */
	public function setup_custom_notice() {
		// Setup notice.
		Notice::init(
			[
				'slug' => PAE_PLUGIN_SLUG,
				'name' => esc_html__( 'Prime Addons for Elementor', 'prime-addons-for-elementor' ),
			]
		);
	}
}

// Instantiate class.
new Prime_Addons_Elementor_Main();
