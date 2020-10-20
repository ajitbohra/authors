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
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'register_posttype'));
	}

	/**
	 * Register Scripts.
	 */
	public function register_assets() {
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
		$args = array(
			'label'                 => __( 'authors', 'aba' ),
			'description'           => __( 'Author Profiles', 'aba' ),
			'labels'                => $labels,
			'supports'              => array('title'),
			'taxonomies'            => array(),
			'register_meta_box_cb'  => array($this, 'register_metabox'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-users',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => false,
		);
		register_post_type( 'authors', $args );
	}

	/**
	 * Custom metabox
	 *
	 * @return void
	 */
	public function register_metabox(){
		add_meta_box(
			'aba_metabox',
			'Details',
			array($this, 'render_metabox'),
			'authors',
			'normal',
			'default'
		);
	}

	/**
	 * Render metabox content
	 *
	 * @return void
	 */
	public function render_metabox($post){
		echo 'Authors Metabox';
	}
}
