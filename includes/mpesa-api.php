<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class Campesa_Mpesa_API {
    private $api_key;
    private $lnm_online_passkey;
    private $shortcode;
    private $initiator_name;
    private $consumer_secret;
    private $environment;

    public function __construct()
    {
        $this->load_settings();
    }

    private function load_settings()
    {
        $options = get_option('campesa_settings');
        $this->api_key = $options['mpesa_api_key'];
        $this->lnm_online_passkey = $options['mpesa_lnm_online_passkey'];
        $this->shortcode = $options['mpesa_shortcode'];
        $this->initiator_name = $options['mpesa_initiator_name'];
        $this->consumer_secret = $options['mpesa_consumer_secret'];
        $this->environment = $options['mpesa_environment'];
    }

    /**
     * Generate an access token for the M-Pesa API.
     *
     * @return string|bool Access token on success, false on failure.
     */
    function mpesa_get_access_token() {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        // Use the live URL when ready for production:
        // $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($this->shortcode . ':' . $this->api_key);

        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . $credentials,
            ),
        );

        $response = wp_remote_get( $url, $args );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( isset( $body['access_token'] ) ) {
            return $body['access_token'];
        }

        return false;
    }

    /**
     * Make a Lipa Na M-Pesa Online request.
     *
     * @param string $phone_number The phone number of the customer making the payment.
     * @param float  $amount       The amount to be paid.
     * @param string $account_ref  The account reference for the transaction.
     * @param string $callback_url The URL to receive the API response.
     *
     * @return array|bool API response on success, false on failure.
     */
    function mpesa_make_payment_request( $phone_number, $amount, $account_ref, $callback_url ) {
        $access_token = $this->mpesa_get_access_token();

        if ( ! $access_token ) {
            return false;
        }

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        // Use the live URL when ready for production:
        // $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $timestamp = date( 'YmdHis' );
        $password = base64_encode($this->shortcode . $this->lnm_online_passkey . $timestamp);

        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type'  => 'application/json',
            ),
            'body'    => json_encode( array(
                'BusinessShortCode' => $this->shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => $amount,
                'PartyA'            => $phone_number,
                'PartyB' => $this->shortcode,
                'PhoneNumber'       => $phone_number,
                'CallBackURL'       => $callback_url,
                'AccountReference'  => $account_ref,
                'TransactionDesc'   => 'Payment for WordCamp ticket',
            ) ),
            'method'  => 'POST',
        );
        
        $response = wp_remote_post( $url, $args );
        
        if ( is_wp_error( $response ) ) {
            return false;
        }
        
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        
        if ( isset( $body['ResponseCode'] ) && '0' === $body['ResponseCode'] ) {
            return $body;
        }
        
        return false;
    }

    /**
     * Handle the M-Pesa payment confirmation callback.
     * @param array $callback_data The callback data received from M-Pesa.
     * @return bool True on success, false on failure.
    */
    function mpesa_handle_payment_callback( $callback_data ) {
    // Process the callback data and update the order status accordingly.

    // Example:
    // Check if the payment has been made successfully and update the ticket order status in the CampTix plugin.

    return true;
    }
}