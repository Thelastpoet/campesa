<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Campesa_Gateway extends CampTix_Payment_Method {
    // Declare gateway properties
    public $id = 'mpesa';
    public $name = 'M-Pesa';
    public $description = 'M-Pesa Payment Gateway for CampTix';
    public $supported_currencies = array('KES');

    // Declare your M-Pesa API key
    protected $api_key = 'YOUR_MPESA_API_KEY';

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

        // Load public-facing styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
    }

    /**
     * Enqueue public-facing styles and scripts
     */
    public function enqueue_public_assets() {
        wp_enqueue_style( 'campesa-public', CAMPESA_PLUGIN_URL . 'public/css/campesa-public.css', array(), CAMPESA_VERSION, 'all' );
        wp_enqueue_script( 'campesa-public', CAMPESA_PLUGIN_URL . 'public/js/campesa-public.js', array( 'jquery' ), CAMPESA_VERSION, true );
    }

    // Implement required methods
    // camptix_options_fields()
    // payment_checkout()
    // payment_check_transaction()
    // payment_notify()

}
