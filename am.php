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
		$this->api_call();
	}

	/**
	 * Function to call API
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	private function api_call() {
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
				CURLOPT_HTTPHEADER => array(
					'Accept: */*',
					'Accept-Encoding: gzip, deflate',
					'Cache-Control: no-cache',
					'Connection: keep-alive',
					'Host: miusage.com',
					'Postman-Token: f10ee9b8-779c-4f7b-802c-3c5a76c9ea59,e9e4806b-d4bc-445d-885b-5297dd941769',
					'User-Agent: PostmanRuntime/7.15.2',
					'cache-control: no-cache',
				),
			)
		);

		$response = curl_exec( $curl );
		$err = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
			echo 'cURL Error #:' . esc_attr( $err );
		} else {
			echo esc_attr( $response );
		}
	}
}
