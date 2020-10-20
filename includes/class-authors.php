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
}
