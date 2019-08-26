<?php
/**
Plugin Name: Awesome Motives
Plugin URI: https://github.com/fahaadsheikh/am.git
Description: An Awesome Plugin!
Author: Fahad Sheikh
Version: 0.1
 **/
class Am {

	/**
	 * Constructor Method
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_files' ) );

		add_action( 'wp_ajax_return_response', array( $this, 'return_response' ) );
		add_action( 'wp_ajax_nopriv_return_response', array( $this, 'return_response' ) );

		add_shortcode( 'show_table', array( $this, 'register_show_table' ) );
	}

	/**
	 * Enqueue necessary files
	 *
	 * @return void
	 * @author
	 **/
	public function enqueue_files() {
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}

		wp_enqueue_script( 'javascript', plugin_dir_url( __FILE__ ) . 'js/javascript.js', array( 'jquery' ), '0.1', true );

		wp_localize_script(
			'javascript',
			'jsobject',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Function to call API
	 *
	 * @return response
	 * @author Fahad Sheikh
	 **/
	public function cached_results() {
		$response = get_transient( 'api_ress' );

		if ( false === $response ) {
			$response = $this->api_call();
			set_transient( 'api_ress', $response, DAY_IN_SECONDS );
		}
		return $response;
	}

	/**
	 * Return API Response to AJAX
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function return_response() {
		$response = $this->cached_results();

		if ( ! isset( $response ) ) :
			wp_send_json_error( array( 'error' => __( 'Data could not be fetched.' ) ) );
		else :
				wp_send_json_success( $response );
		endif;
	}

	/**
	 * Function to call the API
	 *
	 * @return response
	 * @author Fahad Sheikh
	 **/
	public function api_call() {
		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => 'https://miusage.com/v1/challenge/1/',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: */*',
					'Accept-Encoding: gzip, deflate',
					'Cache-Control: no-cache',
					'Connection: keep-alive',
					'Host: miusage.com',
					'Postman-Token: f10ee9b8-779c-4f7b-802c-3c5a76c9ea59,0965b535-ab52-4046-aace-fce078c933f9',
					'User-Agent: PostmanRuntime/7.15.2',
					'cache-control: no-cache',
				),
			)
		);

		$response = curl_exec( $curl );
		$err = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
			return 'cURL Error #:' . $err;
		} else {
			return $response;
		}
	}

	/**
	 * Register shortcode to show API Results
	 *
	 * @return $output
	 * @author Fahad Sheikh
	 **/
	public function register_show_table( $shortcode_attributes ) {

		ob_start(); ?>
		<table class="jspopulate">
		</table>

		<?php
		return ob_get_clean();
	}
}

new AM();
