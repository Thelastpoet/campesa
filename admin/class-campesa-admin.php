<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class Campesa_Admin {

    /**
     * Initialize the admin functionality.
     */
    public function init() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Add the settings page.
     */
    public function add_settings_page() {
        add_options_page(
            'Campesa Settings',
            'Campesa Settings',
            'manage_options',
            'campesa-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Render the settings page.
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Campesa Settings', 'campesa' ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'campesa_settings' );
                do_settings_sections( 'campesa_settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register the settings.
     */
    public function register_settings() {
        register_setting( 'campesa_settings', 'campesa_settings' );

        add_settings_section(
            'campesa_settings_section',
            __( 'M-Pesa API Settings', 'campesa' ),
            null,
            'campesa_settings'
        );

        add_settings_field(
            'mpesa_api_key',
            __( 'M-Pesa API Key', 'campesa' ),
            array( $this, 'render_api_key_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

        // Add Lipa Na M-Pesa Online Passkey field
        add_settings_field(
            'mpesa_lnm_online_passkey',
            __( 'Lipa Na M-Pesa Online Passkey', 'campesa' ),
            array( $this, 'render_lnm_online_passkey_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

        // Add Shortcode field
        add_settings_field(
            'mpesa_shortcode',
            __( 'M-Pesa Shortcode', 'campesa' ),
            array( $this, 'render_shortcode_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

        // Add Initiator Name field
        add_settings_field(
            'mpesa_initiator_name',
            __( 'M-Pesa Initiator Name', 'campesa' ),
            array( $this, 'render_initiator_name_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

        // Add Consumer Secret field
        add_settings_field(
            'mpesa_consumer_secret',
            __( 'M-Pesa Consumer Secret', 'campesa' ),
            array( $this, 'render_consumer_secret_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

        // Add Environment field
        add_settings_field(
            'mpesa_environment',
            __( 'M-Pesa Environment', 'campesa' ),
            array( $this, 'render_environment_field' ),
            'campesa_settings',
            'campesa_settings_section'
        );

    }

    /**
     * Render the API key field.
     */
    public function render_api_key_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <input type="text" name="campesa_settings[mpesa_api_key]" value="<?php echo esc_attr( $options['mpesa_api_key'] ); ?>" size="40">
        <?php
    }

    // Render Lipa Na M-Pesa Online Passkey field
    public function render_lnm_online_passkey_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <input type="text" name="campesa_settings[mpesa_lnm_online_passkey]" value="<?php echo esc_attr( $options['mpesa_lnm_online_passkey'] ); ?>" size="40">
        <?php
    }

    // Render Shortcode field
    public function render_shortcode_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <input type="text" name="campesa_settings[mpesa_shortcode]" value="<?php echo esc_attr( $options['mpesa_shortcode'] ); ?>" size="40">
        <?php
    }

    // Render Initiator Name field
    public function render_initiator_name_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <input type="text" name="campesa_settings[mpesa_initiator_name]" value="<?php echo esc_attr( $options['mpesa_initiator_name'] ); ?>" size="40">
        <?php
    }

    // Render Consumer Secret field
    public function render_consumer_secret_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <input type="text" name="campesa_settings[mpesa_consumer_secret]" value="<?php echo esc_attr( $options['mpesa_consumer_secret'] ); ?>" size="40">
        <?php
    }

    // Render Environment field
    public function render_environment_field() {
        $options = get_option( 'campesa_settings' );
        ?>
        <select name="campesa_settings[mpesa_environment]">
            <option value="sandbox" <?php selected( $options['mpesa_environment'], 'sandbox' ); ?>><?php _e( 'Sandbox', 'campesa' ); ?></option>
            <option value="production" <?php selected( $options['mpesa_environment'], 'production' ); ?>><?php _e( 'Production', 'campesa' ); ?></option>
        </select>
        <?php
    }


}