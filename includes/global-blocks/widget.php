<?php
/**
 * Init
 *
 * @package Prime_Addons_Elementor
 */

/**
 * Register widget.
 *
 * @since 1.0.0
 */
function pae_register_global_blocks_widgets() {
	require PAE_PLUGIN_URI . '/includes/global-blocks/class-global-blocks-widget.php';
	register_widget( 'PAE_Global_Blocks_Widget' );
}

add_action( 'widgets_init', 'pae_register_global_blocks_widgets' );
