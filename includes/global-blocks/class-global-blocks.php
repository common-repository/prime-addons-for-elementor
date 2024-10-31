<?php
/**
 * Global Blocks
 *
 * @package Prime_Addons_Elementor
 */

use Elementor\Plugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class.
 *
 * @since 1.0.0
 */
class PAE_Global_Blocks {

	/**
	 * The single instance of the class.
	 *
	 * @since 1.0.0
	 * @var PAE_Global_Blocks
	 */
	protected static $instance = null;

	/**
	 * The arguments of post type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $post_type = 'pae_global_block';

	/**
	 * Post type slug.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $post_type_slug = 'global-block';

	/**
	 * Post type labels.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $post_type_labels;

	/**
	 * Post type label.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $post_type_label;

	/**
	 * Rewrite for post type.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $rewrite = true;

	/**
	 * Taxonomy.
	 *
	 * @since 1.0.0
	 * @var string string
	 */
	public $taxonomy = 'pae_global_block_cat';

	/**
	 * Taxonomy slug.
	 *
	 * @since 1.0.0
	 * @var string string
	 */
	public $taxonomy_slug = 'global-block-category';

	/**
	 * Taxonomy labels.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $taxonomy_labels;

	/**
	 * Get class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return PAE_Global_Blocks Class instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init_hooks();

		$this->post_type_labels = [
			'name'               => esc_html__( 'Global Blocks', 'prime-addons-for-elementor' ),
			'singular_name'      => esc_html__( 'Global Block', 'prime-addons-for-elementor' ),
			'menu_name'          => esc_html__( 'Global Blocks', 'prime-addons-for-elementor' ),
			'name_admin_bar'     => esc_html__( 'Global Blocks', 'prime-addons-for-elementor' ),
			'add_new'            => esc_html__( 'Add New', 'prime-addons-for-elementor' ),
			'add_new_item'       => esc_html__( 'Add New Global Block', 'prime-addons-for-elementor' ),
			'new_item'           => esc_html__( 'New Global Block', 'prime-addons-for-elementor' ),
			'edit_item'          => esc_html__( 'Edit Global Block', 'prime-addons-for-elementor' ),
			'view_item'          => esc_html__( 'View Global Block', 'prime-addons-for-elementor' ),
			'all_items'          => esc_html__( 'All Global Blocks', 'prime-addons-for-elementor' ),
			'search_items'       => esc_html__( 'Search Global Blocks', 'prime-addons-for-elementor' ),
			'parent_item_colon'  => esc_html__( 'Parent Global Blocks:', 'prime-addons-for-elementor' ),
			'not_found'          => esc_html__( 'No global block found.', 'prime-addons-for-elementor' ),
			'not_found_in_trash' => esc_html__( 'No global block found in Trash.', 'prime-addons-for-elementor' ),
		];

		$this->post_type_label = esc_html__( 'Global Block', 'prime-addons-for-elementor' );

		$this->taxonomy_labels = [
			'name'                       => esc_html_x( 'Block Categories', 'taxonomy general name', 'prime-addons-for-elementor' ),
			'singular_name'              => esc_html_x( 'Block Category', 'taxonomy singular name', 'prime-addons-for-elementor' ),
			'search_items'               => esc_html__( 'Search Block Category', 'prime-addons-for-elementor' ),
			'popular_items'              => esc_html__( 'Popular Block Category', 'prime-addons-for-elementor' ),
			'all_items'                  => esc_html__( 'All Categories', 'prime-addons-for-elementor' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => esc_html__( 'Edit Block Category', 'prime-addons-for-elementor' ),
			'update_item'                => esc_html__( 'Update Block Category', 'prime-addons-for-elementor' ),
			'add_new_item'               => esc_html__( 'Add New Block Category', 'prime-addons-for-elementor' ),
			'new_item_name'              => esc_html__( 'New Block Category Name', 'prime-addons-for-elementor' ),
			'separate_items_with_commas' => esc_html__( 'Separate block category with commas', 'prime-addons-for-elementor' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove block category', 'prime-addons-for-elementor' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used block category', 'prime-addons-for-elementor' ),
			'not_found'                  => esc_html__( 'No block category found.', 'prime-addons-for-elementor' ),
			'menu_name'                  => esc_html__( 'Block Categories', 'prime-addons-for-elementor' ),
		];
	}

	/**
	 * Init hooks.
	 *
	 * @since 1.0.0
	 */
	public function init_hooks() {
		add_action( 'init', [ $this, 'post_type' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
		add_action( 'elementor/init', [ $this, 'enable_elementor' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_shortcode_meta_box' ] );
		add_filter( 'single_template', [ $this, 'single_template' ] );
		add_filter( 'manage_' . $this->post_type . '_posts_columns', [ $this, 'customize_column_headings' ] );
		add_action( 'manage_' . $this->post_type . '_posts_custom_column', [ $this, 'customize_column_content' ], 10, 2 );

		// Add shortcode.
		add_shortcode( 'pae_global_block', [ $this, 'render_elementor_global_block' ] );
	}

	/**
	 * Register post type.
	 *
	 * @since 1.0.0
	 */
	public function post_type() {
		$args = apply_filters(
			'pae_global_blocks_post_type_args',
			[
				'labels'                => $this->post_type_labels,
				'label'                 => $this->post_type_label,
				'public'                => true,
				'publicly_queryable'    => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => false,
				'show_in_admin_bar'     => false,
				'query_var'             => true,
				'capability_type'       => 'post',
				'has_archive'           => false,
				'hierarchical'          => false,
				'menu_position'         => null,
				'menu_icon'             => 'dashicons-layout',
				'supports'              => [ 'title', 'editor' ],
				'exclude_from_search'   => true,
				'map_meta_cap'          => null,
				'can_export'            => true,
				'show_in_rest'          => false,
				'rest_base'             => $this->post_type,
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'taxonomies'            => [ $this->taxonomy ],
			]
		);

		if ( $this->rewrite ) {
			$args['rewrite'] = [ 'slug' => $this->post_type_slug ];
		} else {
			$args['rewrite'] = $this->rewrite;
		}

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register taxonomy.
	 *
	 * @since 1.0.0
	 */
	public function register_taxonomies() {
		$args = apply_filters(
			'pae_global_blocks_taxonomy_args',
			[
				'hierarchical'          => true,
				'labels'                => $this->taxonomy_labels,
				'public'                => false,
				'publicly_queryable'    => false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => false,
				'show_admin_column'     => true,
				'show_tagcloud'         => false,
				'show_in_rest'          => true,
				'rest_base'             => $this->taxonomy,
				'rest_controller_class' => 'WP_REST_Terms_Controller',
				'show_in_quick_edit'    => true,
				'query_var'             => false,
				'rewrite'               => [ 'slug' => $this->taxonomy_slug ],
			]
		);

		register_taxonomy( $this->taxonomy, $this->post_type, $args );
		register_taxonomy_for_object_type( $this->taxonomy, $this->post_type );
	}

	/**
	 * The single template.
	 *
	 * @since 1.0.0
	 *
	 * @param string $single Template path.
	 * @return string Modified template path.
	 */
	public function single_template( $single ) {
		global $post;

		$single_template_file = 'single-pae_global_block.php';

		if ( get_post_type( $post->ID ) === $this->post_type ) {

			if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $single_template_file ) ) {
				$single = trailingslashit( get_stylesheet_directory() ) . $single_template_file;
			} elseif ( file_exists( PAE_PLUGIN_URI . '/includes/global-blocks/' . $single_template_file ) ) {
					$single = PAE_PLUGIN_URI . '/includes/global-blocks/' . $single_template_file;
			}
		}

		return $single;
	}

	/**
	 * Add metabox.
	 *
	 * @since 1.0.0
	 */
	public function add_shortcode_meta_box() {
		add_meta_box( 'pae-global-block-shortcode-info', esc_html__( 'Global Block Shortcode', 'prime-addons-for-elementor' ), [ $this, 'shortcode_metabox' ], $this->post_type, 'side', 'high' );
	}

	/**
	 * Render metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post The post object.
	 */
	public function shortcode_metabox( $post ) {
		?>
		<p><?php esc_html_e( 'Please copy following shortcode and use it anywhere you want.', 'prime-addons-for-elementor' ); ?></p>
		<input type='text' class='widefat' value='[pae_global_block id="<?php echo absint( $post->ID ); ?>"]' readonly="" />
		<?php
	}

	/**
	 * Enable elementor for global block by default.
	 *
	 * @since 1.0.0
	 */
	public function enable_elementor() {
		add_post_type_support( $this->post_type, 'elementor' );
	}

	/**
	 * Output elementor block.
	 *
	 * @since 1.0
	 *
	 * @param array $atts Shortcode arguments.
	 * @return mixed Shortcode output.
	 */
	public static function render_elementor_global_block( $atts ) {
		if ( ! class_exists( 'Elementor\Plugin' ) ) {
			return '';
		}

		if ( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) {
			return '';
		}

		$post_id = $atts['id'];

		$response = Plugin::instance()->frontend->get_builder_content_for_display( $post_id );

		return $response;
	}

	/**
	 * Manage column head in admin listing.
	 *
	 * @since 1.0.0
	 *
	 * @param array $columns An array of column names.
	 * @return array Modified array of column names.
	 */
	public function customize_column_headings( $columns ) {
		$columns['usage'] = esc_html__( 'Usage', 'prime-addons-for-elementor' );

		return $columns;
	}

	/**
	 * Content for extra column in admin listing.
	 *
	 * @since 1.0.0
	 *
	 * @param array $column_name The name of the column to display.
	 * @param array $post_id The current post ID.
	 */
	public function customize_column_content( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'usage':
				echo '<code>[pae_global_block id="' . absint( $post_id ) . '"]</code>';
				break;

			default:
				break;
		}
	}
}

// Initialize class.
$pae_global_blocks = PAE_Global_Blocks::get_instance();
