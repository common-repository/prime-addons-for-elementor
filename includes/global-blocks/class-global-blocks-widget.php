<?php
/**
 * Global Blocks Widget
 *
 * @package Prime_Addons_Elementor
 */

/**
 * Class for the widget.
 *
 * @since 1.0.0
 */
class PAE_Global_Blocks_Widget extends WP_Widget {

	/**
	 * Sets up a new widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			'pae_global_blocks_widget',
			esc_html__( 'Global Block', 'prime-addons-for-elementor' ),
			[
				'description' => esc_html__( 'Add the global blocks widget.', 'prime-addons-for-elementor' ),
			]
		);
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {
		$gb_id = isset( $instance['gb_id'] ) ? absint( $instance['gb_id'] ) : '';

		echo do_shortcode( '[pae_global_block id="' . absint( $gb_id ) . '"]' );
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance.
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = [];

		$instance['gb_id'] = absint( $new_instance['gb_id'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$defaults = [
			'gb_id' => '',
		];

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'gb_id' ) ); ?>"><?php esc_html_e( 'Select Block:', 'prime-addons-for-elementor' ); ?></label>
			<?php
			$dropdown_args = [
				'id'       => $this->get_field_id( 'gb_id' ),
				'name'     => $this->get_field_name( 'gb_id' ),
				'selected' => $instance['gb_id'],
				'class'    => 'widefat',
			];

			$this->render_select_dropdown( $dropdown_args, [ $this, 'get_all_global_blocks' ] );
			?>
		</p>
		<?php
	}

	/**
	 * Returns all global blocks.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of global blocks.
	 */
	protected function get_all_global_blocks() {
		$qargs = [
			'post_type'      => 'pae_global_block',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'asc',
		];

		$the_query = new WP_Query( $qargs );

		$output = [];

		$output['0'] = esc_html__( '&mdash; Select &mdash;', 'prime-addons-for-elementor' );

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
	 * Render select dropdown.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $main_args     Main arguments.
	 * @param string $callback      Callback method.
	 * @param array  $callback_args Callback arguments.
	 * @return string Rendered markup.
	 */
	protected function render_select_dropdown( $main_args, $callback, $callback_args = [] ) {
		$defaults = [
			'id'          => '',
			'name'        => '',
			'class'       => '',
			'selected'    => 0,
			'echo'        => true,
			'add_default' => false,
		];

		$r = wp_parse_args( $main_args, $defaults );

		$output = '';

		$choices = [];

		if ( is_callable( $callback ) ) {
			$choices = call_user_func_array( $callback, $callback_args );
		}

		if ( ! empty( $choices ) || true === $r['add_default'] ) {

			$output = "<select class='" . esc_attr( $r['class'] ) . "' name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";

			if ( true === $r['add_default'] ) {
				$output .= '<option value="">' . esc_html__( 'Default', 'prime-addons-for-elementor' ) . '</option>\n';
			}

			if ( ! empty( $choices ) ) {
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
			}

			$output .= "</select>\n";
		}

		if ( $r['echo'] ) {
			// All content in this variable have been cleaned and escaped already.
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $output;
	}
}
