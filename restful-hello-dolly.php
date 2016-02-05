<?php
/**
 * Plugin Name: Restful Hello Dolly
 * Version: 0.5
 * Description: A more RESTful Hello Dolly
 * Author: Jake Spurlock
 * Author URI: http://jakespurlock.com
 * Plugin URI: http://jakespurlock.com
 * Text Domain: restful-hello-dolly
 * Domain Path: /languages
 * @package Restful Hello Dolly
 */


/**
 * RESTful Hello Dolly Output Class.
 * Wrap all of the default output functions into one extended class.
 */
class RESTful_Hello_Dolly {

	/**
	 * The one instance of RESTful Hello Dolly Routes.
	 *
	 * @var RESTful Hello Dolly Output
	 */
	private static $instance;

	/**
	 * Instantiate or return the one RESTful Hello Dolly Routes instance.
	 *
	 * @return RESTful Hello Dolly Output
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct the object.
	 *
	 * @return RESTful Hello Dolly Routes
	 */
	public function __construct() {
		if ( function_exists( 'hello_dolly_get_lyric' ) ) {
			add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		}
	}

	/**
	 * Register the API routes
	 *
	 * @param  array    $routes    The current JSON API routes.
	 * @return array               The modified routes.
	 */
	public function register_routes() {
		// Return a random Hello Dolly lyric
		register_rest_route( 'restful-hello-dolly/v1', '/lyric', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'rest_get_lyric' ),
		) );
	}

	/**
	 * Use the search endpoint to get a list of recent articles that were published
	 * @return array    Published articles
	 */
	public function rest_get_lyric( $request ) {
		return hello_dolly_get_lyric();
	}

}

/**
 * Wrapper function to return the one RESTful Hello Dolly Output instance.
 * @return    RESTful Hello Dolly Output
 */
function RESTful_Hello_Dolly() {
	return RESTful_Hello_Dolly::instance();
}

// Kick off the class.
add_action( 'init', 'RESTful_Hello_Dolly' );
