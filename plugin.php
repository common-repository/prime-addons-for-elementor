<?php
/**
 * Init plugin
 *
 * @package Prime_Addons_Elementor
 */

// Counter needed in pagination in grid widgets.
static $pae_loop;

// Init global blocks.
require PAE_PLUGIN_URI . '/includes/global-blocks/init.php';

// Controls.
require PAE_PLUGIN_URI . '/includes/controls/init.php';

// Init Elementor widgets.
require PAE_PLUGIN_URI . '/includes/elements/helpers/class-utils.php';
require PAE_PLUGIN_URI . '/includes/elements/traits/controls.php';
require PAE_PLUGIN_URI . '/includes/elements/class-elements.php';
