<?php
/**
 * Helpers
 *
 * @package Prime_Addons_Elementor
 */

namespace PrimeAddonsElementor\Elements\Helpers;

use Elementor\Icons_Manager;

/**
 * Class Utils.
 *
 * @since 1.0.0
 */
class Utils {

	/**
	 * Returns all posts as options.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type.
	 * @param array  $args Arguments.
	 * @return array Array of posts options.
	 */
	public static function get_posts_options( $post_type = 'post', $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'add_default' => true,
			]
		);

		$qargs = [
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'asc',
		];

		$the_query = new \WP_Query( $qargs );

		$output = [];

		if ( true === $args['add_default'] ) {
			$output['0'] = esc_html__( '&mdash; Select &mdash;', 'prime-addons-for-elementor' );
		}

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$post_id = get_the_ID();

				$output[ $post_id ] = get_the_title();
			}

			wp_reset_postdata();
		}

		return $output;
	}

	/**
	 * Render attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes Attributes.
	 * @param bool  $display Whether to echo or not.
	 */
	public static function render_attr( $attributes, $display = true ) {
		if ( empty( $attributes ) ) {
			return;
		}

		$html = '';

		foreach ( $attributes as $name => $value ) {
			$esc_value = '';

			if ( 'class' === $name && is_array( $value ) ) {
				$classes = array_values( array_filter( array_unique( $value ) ) );
				$value   = join( ' ', $classes );
			}

			if ( false !== $value && 'href' === $name ) {
				$esc_value = esc_url( $value );

			} elseif ( false !== $value ) {
				$esc_value = esc_attr( $value );
			}

			$html .= false !== $value ? sprintf( ' %s="%s"', esc_html( $name ), $esc_value ) : esc_html( " {$name}" );
		}

		if ( ! empty( $html ) && true === $display ) {
			// All content in this variable have been cleaned and escaped already.
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}
	}

	/**
	 * Generate excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $length Excerpt length in words.
	 * @param WP_Post $post_obj WP_Post instance (Optional).
	 * @param string  $more More text.
	 * @return string Excerpt.
	 */
	public static function get_post_excerpt( $length, $post_obj = null, $more = '&hellip;' ) {
		global $post;

		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$length = absint( $length );

		if ( 0 === $length ) {
			return;
		}

		$source_content = $post_obj->post_content;

		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}

		$source_content  = strip_shortcodes( $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, $more );

		return $trimmed_content;
	}

	/**
	 * Get post terms slugs.
	 *
	 * @since 1.0.0
	 *
	 * @param  int    $post_id  Post ID.
	 * @param  string $tax Taxonomy.
	 * @return array Slugs array.
	 */
	protected static function get_post_terms_slugs( $post_id, $tax = 'category' ) {
		$output = [];

		$term_list = wp_get_post_terms( $post_id, $tax, [ 'fields' => 'slugs' ] );

		if ( ! empty( $term_list ) && ! is_wp_error( $term_list ) ) {
			$output = $term_list;
		}

		return $output;
	}

	/**
	 * Get post terms.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id Post ID.
	 * @param string $taxonomy Taxonomy.
	 * @param int    $max Maximum number of terms.
	 * @param string $separator Terms separator.
	 * @return string Terms string.
	 */
	public static function get_terms( $post_id, $taxonomy, $max, $separator ) {
		$output = '';

		$items = [];

		$terms = wp_get_post_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$terms = array_slice( $terms, 0, $max );

			foreach ( $terms as $term ) {
				$items[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
			}
		}

		if ( ! empty( $items ) ) {
			$output = join( $separator, $items );
		}

		return $output;
	}

	/**
	 * Check if WooCommerce is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if WooCommerce is active.
	 */
	public static function is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check if EDD is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if EDD is active.
	 */
	public static function is_edd_active() {
		return class_exists( 'Easy_Digital_Downloads' );
	}

	/**
	 * Check if weDocs is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if weDocs is active.
	 */
	public static function is_wedocs_active() {
		return class_exists( 'WeDocs' );
	}

	/**
	 * Check if CF7 is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if CF7 is active.
	 */
	public static function is_cf7_active() {
		return class_exists( 'WPCF7' );
	}

	/**
	 * Check if LearnPress is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if LearnPress is active.
	 */
	public static function is_learnpress_active() {
		return class_exists( 'LearnPress' );
	}

	/**
	 * Get alignment options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options.
	 */
	public static function get_alignment_options() {
		return [
			'left'   => [
				'title' => esc_html__( 'Left', 'prime-addons-for-elementor' ),
				'icon'  => 'eicon-text-align-left',
			],
			'center' => [
				'title' => esc_html__( 'Center', 'prime-addons-for-elementor' ),
				'icon'  => 'eicon-text-align-center',
			],
			'right'  => [
				'title' => esc_html__( 'Right', 'prime-addons-for-elementor' ),
				'icon'  => 'eicon-text-align-right',
			],
		];
	}

	/**
	 * Get post order by options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options.
	 */
	public static function get_post_orderby_options() {
		return [
			'date'  => esc_html__( 'Date', 'prime-addons-for-elementor' ),
			'rand'  => esc_html__( 'Random', 'prime-addons-for-elementor' ),
			'title' => esc_html__( 'Title', 'prime-addons-for-elementor' ),
		];
	}

	/**
	 * Get post order options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options.
	 */
	public static function get_post_order_options() {
		return [
			'asc'  => esc_html__( 'Ascending', 'prime-addons-for-elementor' ),
			'desc' => esc_html__( 'Descending', 'prime-addons-for-elementor' ),
		];
	}

	/**
	 * Get columns options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options.
	 */
	public static function get_columns_options() {
		return [
			'1' => esc_html__( '1 Column', 'prime-addons-for-elementor' ),
			/* translators: %d: columns */
			'2' => sprintf( esc_html__( '%d Columns', 'prime-addons-for-elementor' ), 2 ),
			/* translators: %d: columns */
			'3' => sprintf( esc_html__( '%d Columns', 'prime-addons-for-elementor' ), 3 ),
			/* translators: %d: columns */
			'4' => sprintf( esc_html__( '%d Columns', 'prime-addons-for-elementor' ), 4 ),
		];
	}

	public static function content_tag( $tag, $content, $attrs ) {
		return self::open_tag( $tag, $attrs ) . $content . self::close_tag( $tag );
	}

	public static function open_tag( $tag, $attrs ) {
		$attr_string = self::render_attr( $attrs, false );
		return '<' . $tag . ' ' . $attr_string . '>';
	}

	public static function close_tag( $tag ) {
		return '</' . $tag . '>';
	}

	/**
	 * Truncate the long string.
	 *
	 * @since 1.0.0
	 *
	 * @param string $full_str The string you want to truncate.
	 * @param int    $max_length The max length of output.
	 * @return string Truncated string.
	 */
	public static function truncate_string( $full_str, $max_length ) {
		if ( mb_strlen( $full_str, 'utf-8' ) > $max_length ) {
			$full_str = mb_substr( $full_str, 0, $max_length, 'utf-8' ) . '...';
		}

		$full_str = apply_filters( 'pae_truncate', $full_str );

		return $full_str;
	}

	public static function get_terms_options( $taxonomy ) {
		$opt = [];

		$all_terms = get_terms( [ 'taxonomy' => $taxonomy ] );

		if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) ) {
			$opt = wp_list_pluck( $all_terms, 'name', 'term_id' );
		}

		return $opt;
	}

	public static function get_blog_query_args( $settings ) {
		$query_args = [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $settings['number'] ),
			'ignore_sticky_posts' => true,
		];

		$taxonomies = [
			'category' => 'post_categories',
			'post_tag' => 'post_tags',
		];

		$tquery = [];

		foreach ( $taxonomies as $tax => $setting_key ) {
			if ( ! empty( $settings[ $setting_key ] ) ) {
				$tquery[] = [
					'taxonomy' => $tax,
					'field'    => 'term_id',
					'terms'    => $settings[ $setting_key ],
				];
			}
		}

		if ( ! empty( $tquery ) ) {
			$tquery['relation'] = 'AND';
		}

		if ( ! empty( $tquery ) ) {
			$query_args['tax_query'] = $tquery;
		}

		// Order by.
		if ( ! empty( $settings['post_orderby'] ) ) {
			$query_args['orderby'] = $settings['post_orderby'];
		}

		// Order.
		if ( ! empty( $settings['post_order'] ) ) {
			$query_args['order'] = $settings['post_order'];
		}

		// Exclude.
		if ( ! empty( $settings['post_exclude'] ) ) {
			$query_args['post__not_in'] = (array) $settings['post_exclude'];
		}

		return $query_args;
	}

	public static function render_icon( $icon, $display = true ) {
		ob_start();

		Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );

		$output = ob_get_clean();

		if ( $display ) {
			echo wp_kses_post( $output );
		}

		return $output;
	}

	public static function get_icon( $type ) {
		$output = '';

		$icons = [
			'plus'     => [
				'value'   => 'fas fa-plus',
				'library' => 'fa-solid',
			],
			'cart'     => [
				'value'   => 'fas fa-shopping-cart',
				'library' => 'fa-solid',
			],
			'eye'      => [
				'value'   => 'fas fa-eye',
				'library' => 'fa-solid',
			],
			'store'    => [
				'value'   => 'fas fa-store',
				'library' => 'fa-solid',
			],
			'link'     => [
				'value'   => 'fas fa-link',
				'library' => 'fa-solid',
			],
			'external' => [
				'value'   => 'fas fa-external-link-alt',
				'library' => 'fa-solid',
			],
			'cog'      => [
				'value'   => 'fas fa-cog',
				'library' => 'fa-solid',
			],
			'check'    => [
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			],
			'spinner'  => [
				'value'   => 'fas fa-spinner fa-spin',
				'library' => 'fa-solid',
			],
		];

		if ( isset( $icons[ $type ] ) ) {
			$output = self::render_icon( $icons[ $type ], false );
		}

		return $output;
	}

	/**
	 * Returns a normalized list of all currently registered image sub-sizes.
	 *
	 * @since 5.3.0
	 * @uses wp_get_additional_image_sizes()
	 * @uses get_intermediate_image_sizes()
	 *
	 * @return array Associative array of the registered image sub-sizes.
	 */
	public static function get_registered_image_subsizes() {
		$all_sizes = [];

		$additional_sizes = wp_get_additional_image_sizes();

		foreach ( get_intermediate_image_sizes() as $size_name ) {
			$size_data = [
				'width'  => 0,
				'height' => 0,
				'crop'   => false,
			];

			if ( isset( $additional_sizes[ $size_name ]['width'] ) ) {
				// For sizes added by plugins and themes.
				$size_data['width'] = (int) $additional_sizes[ $size_name ]['width'];
			} else {
				// For default sizes set in options.
				$size_data['width'] = (int) get_option( "{$size_name}_size_w" );
			}

			if ( isset( $additional_sizes[ $size_name ]['height'] ) ) {
				$size_data['height'] = (int) $additional_sizes[ $size_name ]['height'];
			} else {
				$size_data['height'] = (int) get_option( "{$size_name}_size_h" );
			}

			if ( empty( $size_data['width'] ) && empty( $size_data['height'] ) ) {
				// This size isn't set.
				continue;
			}

			if ( isset( $additional_sizes[ $size_name ]['crop'] ) ) {
				$size_data['crop'] = $additional_sizes[ $size_name ]['crop'];
			} else {
				$size_data['crop'] = get_option( "{$size_name}_crop" );
			}

			if ( ! is_array( $size_data['crop'] ) || empty( $size_data['crop'] ) ) {
				$size_data['crop'] = (bool) $size_data['crop'];
			}

			$all_sizes[ $size_name ] = $size_data;
		}

		return $all_sizes;
	}

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $allowed Allowed image size options.
	 * @param bool  $show_dimension Whether to show dimensions.
	 * @return array Image size options.
	 */
	public static function get_image_sizes_options( $allowed = [], $show_dimension = true ) {
		$subsizes = self::get_registered_image_subsizes();

		$options = [];

		if ( ! empty( $subsizes ) ) {
			foreach ( $subsizes as $key => $item ) {
				if ( ! empty( $allowed ) && ! in_array( $key, $allowed, true ) ) {
					continue;
				}

				$dimension = sprintf( ' - %1$s x %2$s', $item['width'], $item['height'] );
				$size_name = ucwords( str_replace( [ '_', '-' ], ' ', $key ) );

				$options[ $key ] = ( true === $show_dimension ) ? $size_name . $dimension : $size_name;
			}
		}

		$options['full'] = esc_html__( 'Full', 'prime-addons-for-elementor' );

		return $options;
	}

	/**
	 * Get SVG.
	 *
	 * Use this function to fetch SVG icon. This checks existence of the file before fetching it.
	 * When using SVG image for non-decorative purpose, use `aria_hidden` as false.
	 *
	 * @since 1.0.0
	 *
	 * @param string $filename SVG file name.
	 * @param array  $args {
	 *    Optional. Arguments to get SVG.
	 *
	 *   @type bool $aria_hidden Whether to add aria hidden attribute in SVG tag. Default true.
	 * }
	 * @return string SVG markup.
	 */
	public static function get_svg( $filename, $args = [] ) {
		$svg = '';

		$args = wp_parse_args(
			$args,
			[
				'aria_hidden' => true,
			]
		);

		// Remove extension if exists.
		$file = preg_replace( '/\\.[^.\\s]{3,4}$/', '', $filename );

		$icons = [
			'icon-chevron-left'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14.477.477a.675.675 0 0 1 0 .955L5.91 10l8.568 8.568a.675.675 0 1 1-.954.955l-8.816-8.816a1 1 0 0 1 0-1.414L13.523.477a.675.675 0 0 1 .954 0Z"/></svg>',
			'icon-chevron-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M1.37727273,19.5227273 C1.11368228,19.2591368 1.11368228,18.8317723 1.37727273,18.5681818 L9.94545455,10 L1.37727273,1.43181818 C1.11368228,1.16822773 1.11368228,0.740863176 1.37727273,0.477272727 C1.64086318,0.213682278 2.06822773,0.213682278 2.33181818,0.477272727 L11.1474387,9.29289322 C11.537963,9.68341751 11.537963,10.3165825 11.1474387,10.7071068 L2.33181818,19.5227273 C2.06822773,19.7863177 1.64086318,19.7863177 1.37727273,19.5227273 Z" transform="translate(4)"/></svg>',
		];

		if ( isset( $icons[ $file ] ) ) {
			$svg = $icons[ $file ];
		}

		if ( ! empty( $svg ) && true === $args['aria_hidden'] ) {
			$svg = str_replace( '<svg ', '<svg aria-hidden="true" ', $svg );
		}

		return $svg;
	}
}
