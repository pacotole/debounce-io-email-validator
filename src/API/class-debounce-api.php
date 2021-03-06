<?php
/**
 * The main api.
 *
 * @package DEBOUNCE/API
 */

/**
 * Class DEBOUNCE_API
 */
class DEBOUNCE_API {

	/**
	 * The API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'https://api.debounce.io/v1/';

	/**
	 * The email to validate.
	 *
	 * @var string
	 */
	protected $email = null;

	/**
	 * The API Key.
	 *
	 * @var string
	 */
	protected $apikey = null;

	/**
	 * The response object.
	 *
	 * @var object
	 */
	protected $response = null;

	/**
	 * Perform the request.
	 *
	 * @return null|object
	 */
	public function request() {

		$email = $this->get_email();

		$response = get_transient( "debounce__$email" );
		if ( $response ) {
			return $this->set_response( $response );
		}

		$args = array(
			'method'   => 'POST',
			'timeout'  => 45,
			'blocking' => true,
			'body'     => array(
				'email' => $email,
				'api'   => $this->get_apikey(),
			),
		);

		$result = wp_remote_post( $this->endpoint, $args );

		if ( ! is_wp_error( $result ) ) {
			$response = json_decode( wp_remote_retrieve_body( $result ) );
			set_transient( "debounce__$email", $response, DAY_IN_SECONDS );
			return $this->set_response( $response );
		}

		return null;
	}

	/**
	 * Get the endpoint.
	 *
	 * @return string
	 */
	public function get_endpoint() {

		return $this->endpoint;
	}

	/**
	 * Set the endpoint.
	 *
	 * @param string $endpoint The endpoint.
	 *
	 * @return string
	 */
	public function set_endpoint( $endpoint ) {

		$this->endpoint = (string) $endpoint;
		return $this->get_endpoint();
	}

	/**
	 * Get the email.
	 *
	 * @return string
	 */
	public function get_email() {

		return $this->email;
	}

	/**
	 * Set the email number.
	 *
	 * @param string $email The email address.
	 *
	 * @return string
	 */
	public function set_email( $email ) {

		$email       = trim( (string) $email );
		$this->email = $email;
		return $this->get_email();
	}

	/**
	 * Get the API Key.
	 *
	 * @return string
	 */
	public function get_apikey() {

		return $this->apikey;
	}

	/**
	 * Set the API Key.
	 *
	 * @param string $apikey The API Key.
	 *
	 * @return string
	 */
	public function set_apikey( $apikey ) {

		$this->apikey = (string) $apikey;
		return $this->get_apikey();
	}

	/**
	 * Get the Response Object.
	 *
	 * @return object
	 */
	public function get_response() {

		return $this->response;
	}

	/**
	 * Set the Response Object.
	 *
	 * @param  object $response The Response Object.
	 *
	 * @return object
	 */
	public function set_response( $response ) {

		$this->response = (object) $response;
		return $this->get_response();
	}
}
