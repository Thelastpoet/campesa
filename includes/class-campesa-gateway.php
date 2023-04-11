<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class Campesa_Gateway extends CampTix_Payment_Method {
    // Declare gateway properties
    public $id = 'mpesa';
    public $name = 'M-Pesa';
    public $description = 'M-Pesa Payment Gateway for CampTix';
    public $supported_currencies = array('KES');

    /**
     * M-Pesa API instance
     */
    private $mpesa_api;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // Initialize the Campesa_Mpesa_API class
        $this->mpesa_api = new Campesa_Mpesa_API();
    }

    // Implement required methods
    // camptix_options_fields()
    // payment_checkout()
    // payment_check_transaction()
    // payment_notify()

}
