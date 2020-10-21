<?php
/**
 * Aba
 *
 * @author  Ajit Bohra <ajit@lubus.in>
 * @license MIT
 *
 * @see   https://www.abaiji.com/
 *
 * @copyright 2019 LUBUS
 * @package   Aba
 */

namespace LubusIN\Aba;

/**
 * Bootstrap plugin
 */
final class Authors {
	/**
	 * Instance.
	 *
	 * @since
	 *
	 * @var Aba
	 */
	private static $instance;

	/**
	 * Plugin pages
	 *
	 * @var array
	 */
	public static $plugin_pages = array();

	/**
	 * Singleton pattern.
	 *
	 * @since
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Get instance.
	 *
	 * @since
	 *
	 * @return Aba
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since  1.0.0
	 */
	private function init_hooks() {
		// Set up init Hook.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'register_posttype' ) );
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
		add_action( 'save_post', array( $this, 'save_meta' ), 10, 2 );
		add_filter( 'wp_insert_post_data', array( $this, 'save_title' ), '99', 2 );
		add_filter( 'single_template', array( $this, 'get_single_template' ) );
		add_filter( 'archive_template', array( $this, 'get_archive_template' ) );
	}

	/**
	 * Register Admin assets.
	 *
	 * @param string $hook current screen hook.
	 */
	public function register_admin_assets( $hook ) {
		// Only on authors posttype.
		if ( 'authors' !== get_post_type() ) {
			return;
		}

		$hooks = array(
			'post.php',
			'post-new.php',
		);

		if ( ! in_array( $hook, $hooks, true ) ) {
			return;
		}

		// Enable media assets.
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		// Scripts.
		wp_register_script(
			'aba-script',
			ABA_PLUGIN_URL . 'assets/admin.js',
			array( 'jquery' ),
			filemtime( ABA_PLUGIN_DIR . 'assets/admin.js' ),
			true
		);
		wp_enqueue_script( 'aba-script' );

		// Styles.
		wp_register_style(
			'aba',
			ABA_PLUGIN_URL . 'assets/admin.css',
			null,
			filemtime( ABA_PLUGIN_DIR . 'assets/admin.css' )
		);
		wp_enqueue_style( 'aba' );
	}

	/**
	 * Register assets
	 *
	 * @return void
	 */
	public function register_assets() {
		if ( 'authors' !== get_post_type() ) {
			return;
		}

		// Styles.
		wp_register_style(
			'aba',
			ABA_PLUGIN_URL . 'assets/style.css',
			null,
			filemtime( ABA_PLUGIN_DIR . 'assets/style.css' )
		);
		wp_enqueue_style( 'aba' );
	}

	/**
	 * Register posttype
	 *
	 * @return void
	 */
	public function register_posttype() {
		$labels = array(
			'name'                  => _x( 'Authors', 'Post Type General Name', 'aba' ),
			'singular_name'         => _x( 'authors', 'Post Type Singular Name', 'aba' ),
			'menu_name'             => __( 'Authors', 'aba' ),
			'name_admin_bar'        => __( 'Authors', 'aba' ),
			'archives'              => __( 'Authors Archives', 'aba' ),
			'attributes'            => __( 'Author Attributes', 'aba' ),
			'parent_item_colon'     => __( 'Parent Author:', 'aba' ),
			'all_items'             => __( 'All Authors', 'aba' ),
			'add_new_item'          => __( 'Add New Author', 'aba' ),
			'add_new'               => __( 'Add New', 'aba' ),
			'new_item'              => __( 'New Author', 'aba' ),
			'edit_item'             => __( 'Edit Author', 'aba' ),
			'update_item'           => __( 'Update Author', 'aba' ),
			'view_item'             => __( 'View Author', 'aba' ),
			'view_items'            => __( 'View Authors', 'aba' ),
			'search_items'          => __( 'Search Author', 'aba' ),
			'not_found'             => __( 'Not found', 'aba' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'aba' ),
			'featured_image'        => __( 'Featured Image', 'aba' ),
			'set_featured_image'    => __( 'Set featured image', 'aba' ),
			'remove_featured_image' => __( 'Remove featured image', 'aba' ),
			'use_featured_image'    => __( 'Use as featured image', 'aba' ),
			'insert_into_item'      => __( 'Insert into Author', 'aba' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Author', 'aba' ),
			'items_list'            => __( 'Authors list', 'aba' ),
			'items_list_navigation' => __( 'Authors list navigation', 'aba' ),
			'filter_items_list'     => __( 'Filter suthors list', 'aba' ),
		);
		$args   = array(
			'label'                => __( 'authors', 'aba' ),
			'description'          => __( 'Author Profiles', 'aba' ),
			'labels'               => $labels,
			'supports'             => array( '' ),
			'taxonomies'           => array(),
			'register_meta_box_cb' => array( $this, 'register_metabox' ),
			'hierarchical'         => false,
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'menu_position'        => 5,
			'menu_icon'            => 'dashicons-admin-users',
			'show_in_admin_bar'    => true,
			'show_in_nav_menus'    => true,
			'can_export'           => true,
			'has_archive'          => true,
			'exclude_from_search'  => true,
			'publicly_queryable'   => true,
			'capability_type'      => 'post',
			'show_in_rest'         => false,
		);
		register_post_type( 'authors', $args );
	}

	/**
	 * Authors updated messages
	 *
	 * @param array $messages update messages array.
	 * @return array
	 */
	public function updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['authors'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Author updated.', 'aba' ),
			2  => __( 'Custom field updated.', 'aba' ),
			3  => __( 'Custom field deleted.', 'aba' ),
			4  => __( 'Author updated.', 'aba' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Author restored to revision from %s', 'aba' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Author published.', 'aba' ),
			7  => __( 'Author saved.', 'aba' ),
			8  => __( 'Author submitted.', 'aba' ),
			9  => sprintf(
				/* translators: %1$s: date and time of the revision */
				__( 'Author scheduled for: <strong>%1$s</strong>.', 'aba' ),
				// translators: Publish box date format, see http://php.net/date.
				date_i18n( __( 'M j, Y @ G:i', 'aba' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Author draft updated.', 'aba' ),
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link               = sprintf( '&nbsp;<a href="%s">%s</a>', esc_url( $permalink ), __( 'View author', 'aba' ) );
			$messages['authors'][1] .= $view_link;
			$messages['authors'][6] .= $view_link;
			$messages['authors'][9] .= $view_link;

			$preview_permalink           = add_query_arg( 'preview', 'true', $permalink );
			$preview_link                = sprintf( '<a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview author', 'aba' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Custom metabox
	 *
	 * @return void
	 */
	public function register_metabox() {
		add_meta_box(
			'aba_metabox',
			'Details',
			array( $this, 'render_metabox' ),
			'authors',
			'normal',
			'default'
		);
	}

	/**
	 * Render metabox content
	 *
	 * @param WP_Post $post current post.
	 * @return void
	 */
	public function render_metabox( $post ) {
		require_once 'views/meta-fields.php';
	}

	/**
	 * Save custom meta
	 *
	 * @param int     $post_id post id.
	 * @param WP_Post $post post objet.
	 * @return void
	 */
	public function save_meta( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'authors' !== $post->post_type ) {
			return;
		}

		// nonce check.
		if ( ! isset( $_POST['_aba_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_aba_nonce'] ) ), 'aba_authors_meta' ) ) {
			return;
		}

		$fields = array(
			'first_name',
			'last_name',
			'biography',
			'facebook_url',
			'linkedin_url',
			'user_id',
			'image_id',
			'gallery_image_ids',
		);

		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			} else {
				delete_post_meta( $post_id, $field );
			}
		}
	}

	/**
	 * Save author title
	 *
	 * @param array $data post data.
	 * @param array $postarr post attr.
	 * @return void
	 */
	public function save_title( $data, $postarr ) {
		if ( 'authors' !== $data['post_type'] ) {
			return;
		}

		// nonce check.
		if ( ! isset( $_POST['_aba_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_aba_nonce'] ) ), 'aba_authors_meta' ) ) {
			return;
		}

		$first_name  = ( ! empty( $_POST['first_name'] ) ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : get_post_meta( $postarr['ID'], 'first_name', true );
		$last_name   = ( ! empty( $_POST['last_name'] ) ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : get_post_meta( $postarr['ID'], 'last_name', true );
		$author_name = "{$first_name} {$last_name}";

		if ( '' !== $author_name ) {
			$data['post_title'] = $author_name;
			$data['post_name']  = sanitize_title( sanitize_title_with_dashes( $author_name, '', 'save' ) );
		}

		return $data;
	}

	/**
	 * Get authors single template
	 *
	 * @param string $single_template template path.
	 * @return string
	 */
	public function get_single_template( $single_template ) {
		if ( 'authors' === get_post_type() ) {
			$single_template = locate_template( 'single-authors.php' );

			if ( ! file_exists( $single_template ) ) {
				$single_template = ABA_PLUGIN_DIR . '/templates/single-authors.php';
			}
		}

		return $single_template;
	}

	/**
	 * Get authors archive template
	 *
	 * @param string $archive_template template patch.
	 * @return string
	 */
	public function get_archive_template( $archive_template ) {
		if ( 'authors' === get_post_type() ) {
			$archive_template = locate_template( 'archive-authors.php' );

			if ( ! file_exists( $archive_template ) ) {
				$archive_template = ABA_PLUGIN_DIR . '/templates/archive-authors.php';
			}
		}

		return $archive_template;
	}
}
