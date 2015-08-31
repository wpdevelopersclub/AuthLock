<?php namespace AuthLock\Admin;

/**
 * Metabox
 *
 * @package     AuthLock\Admin
 * @since       1.1.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Config\I_Config;

class Metabox {

	/**
	 * Configuration array
	 *
	 * @var I_Config
	 */
	protected $config;

	/***************************
	 * Instantiate & Initialize
	 **************************/

	/**
	 * Handles the methods upon instantiation
	 *
	 * @since 1.1.0
	 *
	 * @param I_Config $config Configuration parameters
	 *
	 * @return  self
	 */
	public function __construct( I_Config $config ) {
		$this->config = $config;

		$this->init_hooks();
	}

	/**
	 * Initialize events
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_hooks() {
		add_filter( 'wpdevsclub_metabox_page_options_meta_defaults',   array( $this, 'meta_defaults' ) );

		add_filter( 'wpdevsclub_metabox_page_options_sanitize',        array( $this, 'sanitize' ) );

		add_action( 'wpdevsclub_metabox_render_view',                  array( $this, 'render_metabox' ), 10, 4 );
	}

	/***************************
	 * Callbacks
	 **************************/

	/**
	 * Add Meta to page options via filter
	 *
	 * @since 1.0.0
	 *
	 * @param $meta_defaults
	 * @return array
	 */
	public function meta_defaults( $meta_defaults ) {
		return $this->add_to_filter( 'meta_defaults', $meta_defaults );
	}

	/**
	 * Add Meta to page options sanitizer via filter
	 *
	 * @since 1.0.0
	 *
	 * @param $sanitize
	 * @return array
	 */
	public function sanitize( $sanitize ) {
		return $this->add_to_filter( 'sanitize', $sanitize );
	}

	/**
	 * Renders the metabox HTML
	 *
	 * @since 1.0.0
	 *
	 * @param string    $meta_box
	 * @param array     $meta
	 * @param           $post
	 * @param array     $args
	 * @return null
	 */
	public function render_metabox( $meta_box, $meta, $post, $args ) {
		if ( $meta_box == $this->config->meta_name && is_readable( $this->config->metabox_view ) ) {
			include( $this->config->metabox_view );
		}
	}

	/**
	 * Add to the filter's args
	 *
	 * @since 1.0.0
	 *
	 * @param string    $type
	 * @param array     $filter_array
	 * @return array
	 */
	protected function add_to_filter( $type, $filter_array ) {
		foreach ( $this->config->$type as $key => $value ) {
			$filter_array[ $key ] = $value;
		}

		return $filter_array;
	}
}