<?php
/**
 * The single global block template
 *
 * @package Prime_Addons_Elementor
 */

get_header();

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_footer();
