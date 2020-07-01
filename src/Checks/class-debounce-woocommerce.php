<?php
/**
 * This class handles the checks for WooCommerce.
 *
 * @package DEBOUNCE/Checks
 */

/**
 * Class DEBOUNCE_WooCommerce
 */
class DEBOUNCE_WooCommerce {

	/**
	 * The validator object
	 *
	 * @var object
	 */
	protected $validator = null;


	/**
	 * DEBOUNCE_WooCommerce constructor.
	 */
	public function __construct() {}

	/**
	 * Set up the handler.
	 */
	public function setup() {

		add_action( 'woocommerce_after_checkout_validation', array( $this, 'validate' ), 10, 2 );
	}

	/**
	 * Validate checkout fields.
	 *
	 * @param  fields
	 * @param  errors
	 */
	public function validate( $fields, $errors ) {
		if ( ! empty( $fields['billing_email'] ) ) {
			$this->validator->set_email( sanitize_email( $fields['billing_email'] ) );
			$this->validator->validate();
			if ( ! $this->validator->get_is_valid() ) {
				$errors->add( 'validation', __( 'The billing email address is invalid or not allowed - please check.', 'email-validator-by-debounce' ) );
			}
		}
		if ( ! empty( $fields['shipping_email'] ) ) {
			$this->validator->set_email( sanitize_email( $fields['shipping_email'] ) );
			$this->validator->validate();
			if ( ! $this->validator->get_is_valid() ) {
				$errors->add( 'validation', __( 'The shipping email address is invalid or not allowed - please check.', 'email-validator-by-debounce' ) );
			}
		}
	}

	/**
	 * Set the validator.
	 *
	 * @param object $validator The validator.
	 *
	 * @return object
	 */
	public function set_validator( $validator ) {

		$this->validator = (object) $validator;
		return $this->get_validator();
	}

	/**
	 * Get the validator.
	 *
	 * @return object
	 */
	public function get_validator() {

		return $this->validator;
	}

}
