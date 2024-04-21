<?php

/*
 * Plugin Name:       GeoWC API plugin
 * Plugin URI:        https://github.com/obman/GeoWC-Plugin
 * Description:       Integrate GeoWC application APIs into WooCommerce checkout address fields.
 * Author:            obman
 * Version:           1.2.2
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author             URI: https://github.com/obman/
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       geoapiwc
*/

use PluginSettings\PluginSettings;

if ( ! defined( 'ABSPATH' ) ) exit;

if (! function_exists('get_plugin_data')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

define('PLUGIN_DATA', get_plugin_data(__FILE__));
define('GEOAPIWC_DIR', plugin_dir_url( __FILE__ ));

require __DIR__ . '/vendor/autoload.php';

const GEOAPI_OPTIONS_NAME = 'geoapiwc_settings_options';
const GEOAPI_MENU_SLUG = 'geoapiwc-plugin';

define('GEOAPISERVICE_BASE_URL', 'https://geowc.sample.si');

// Register plugin hooks
function geoapiwc__settings_page(): void {
    add_menu_page('GeoApiCoreWC', 'GeoAPI WC Settings', 'manage_options', GEOAPI_MENU_SLUG, 'geoapiwc__render_options_page_html', 'dashicons-rest-api');
}
add_action('admin_menu', 'geoapiwc__settings_page');

/**
 * Frontend assets
 *
 * @return void
 */
function geoapi__register_assets__frontend(): void {
    // Admin
	wp_register_style('geoapi-admin-form', GEOAPIWC_DIR . 'assets/css/admin/geoapi-admin-form.css', false, PLUGIN_DATA['Version'], 'all');
    wp_register_script('geoapi-admin-bearer-token', GEOAPIWC_DIR . 'assets/js/admin/geoapp-get-api-bearer-token.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));

    // Type 1
    wp_register_script('geoapitype1wc-zipcity', GEOAPIWC_DIR . 'assets/js/front/geoapitype1wc-zipcity.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));
    wp_register_script('geoapitype1wc-address', GEOAPIWC_DIR . 'assets/js/front/geoapitype1wc-address.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));

    // Type 2
    wp_register_script('geoapitype2wc-address', GEOAPIWC_DIR . 'assets/js/front/geoapitype2wc-address.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));

    // Type 3
    wp_register_script('geoapitype3wc-address', GEOAPIWC_DIR . 'assets/js/front/geoapitype3wc-address.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));
    wp_register_style('geoapitype3wc-addresses', GEOAPIWC_DIR . 'assets/css/front/geoapitype3wc-addresses.css', false, PLUGIN_DATA['Version'], 'all');
    wp_register_script('geoapitype3wc-addresses', GEOAPIWC_DIR . 'assets/js/front/geoapitype3wc-addresses.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));
}
add_action('init', 'geoapi__register_assets__frontend');

function geoapi__register_assets__admin(): void {
	$options     = get_option(GEOAPI_OPTIONS_NAME);
	$script_data = array(
        'base_url'              => GEOAPISERVICE_BASE_URL,
		'client_id'             => $options['api-client-id-field'],
		'client_secret'         => $options['api-client-secret-field'],
        'bearer_token_field_id' => 'api-bearer-token-field',
	);

	wp_enqueue_style('geoapi-admin-form');
	wp_enqueue_script('geoapi-admin-bearer-token');
	wp_localize_script('geoapi-admin-bearer-token', 'geoapiwc', $script_data);
}
add_action('admin_enqueue_scripts', 'geoapi__register_assets__admin');

function geoapiwc__load_assets__frontend(): void {
    $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (stripos(implode($all_plugins), 'woocommerce.php')) {
        if (is_checkout()) {
            $options     = get_option(GEOAPI_OPTIONS_NAME);
            $script_data = array(
                'base_url'          => GEOAPISERVICE_BASE_URL,
                'bearer_token'      => $options['api-bearer-token-field'],
                'license_key'       => $options['license-key-field'],
                'domain'            => get_site_url(),
                'country_field_id'  => $options['country-id-field'],
                'address_field_id'  => $options['address-id-field'],
                'postcode_field_id' => $options['zip-id-field'],
                'city_field_id'     => $options['city-id-field']
            );

            if (isset($options['api-type'])) {
                switch ($options['api-type']) {
                    case '1':
                        if (isset($options['api-method-address-to-zip-city'])) {
                            wp_enqueue_script('geoapitype1wc-zipcity');
                            wp_localize_script('geoapitype1wc-zipcity', 'geoapiwc', $script_data);
                        }
                        else {
                            wp_enqueue_script('geoapitype1wc-address');
                            wp_localize_script('geoapitype1wc-address', 'geoapiwc', $script_data);
                        }
                        break;
                    case '2':
                        wp_enqueue_script('geoapitype2wc-address');
                        wp_localize_script('geoapitype2wc-address', 'geoapiwc', $script_data);
                        break;
                    case '3':
                        if (isset($options['api-method-multiple-addresses-select-option'])) {
                            wp_enqueue_style('geoapitype3wc-addresses');
                            wp_enqueue_script('geoapitype3wc-addresses');
                            wp_localize_script('geoapitype3wc-addresses', 'geoapiwc', $script_data);
                        }
                        else {
                            wp_enqueue_script('geoapitype3wc-address');
                            wp_localize_script('geoapitype3wc-address', 'geoapiwc', $script_data);
                        }
                        break;
                }
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'geoapiwc__load_assets__frontend');

function geoapiwc__load_js_as_ES6($tag, $handle, $src) {
    if (
        $handle === 'geoapitype1wc-zipcity' ||
        $handle === 'geoapitype1wc-address' ||
        $handle === 'geoapitype2wc-address' ||
        $handle === 'geoapitype3wc-address' ||
        $handle === 'geoapitype3wc-addresses'
    ) {
        return '<script src="' . esc_url( $src ) . '" type="module"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'geoapiwc__load_js_as_ES6', 10, 3);

## Helper functions
function setup_plugin_settings(): void
{
    register_setting(GEOAPI_OPTIONS_NAME, GEOAPI_OPTIONS_NAME);

    $pluginSettings = new PluginSettings();

    $pluginSettings->renderSettingsSection('ApiCredentials');
    $pluginSettings->renderSettingsSection('LicenseKey');
    $pluginSettings->renderSettingsSection('ApiType');
    $pluginSettings->renderSettingsSection('EventHandlerFields');

	// API Credential
	$pluginSettings->renderSettingsFields('ApiClientIDField', GEOAPI_OPTIONS_NAME, 'api-client-id-field');
	$pluginSettings->renderSettingsFields('ApiClientSecretField', GEOAPI_OPTIONS_NAME, 'api-client-secret-field');
	$pluginSettings->renderSettingsFields('ApiBearerTokenField', GEOAPI_OPTIONS_NAME, 'api-bearer-token-field');
	$pluginSettings->renderSettingsFields('GetBearerTokenButton', GEOAPI_OPTIONS_NAME, 'get-bearer-token-button');

	// License
	$pluginSettings->renderSettingsFields('LicenseKeyField', GEOAPI_OPTIONS_NAME, 'license-key-field');

    $pluginSettings->renderSettingsFields('ApiTypeField', GEOAPI_OPTIONS_NAME, 'api-type');

    $pluginSettings->renderSettingsFields('ApiMethodAddressToZIPCityField', GEOAPI_OPTIONS_NAME, 'api-method-address-to-zip-city');
    $pluginSettings->renderSettingsFields('ApiMethodSelectAddressesField', GEOAPI_OPTIONS_NAME, 'api-method-multiple-addresses-select-option');

    $pluginSettings->renderSettingsFields('CountryField', GEOAPI_OPTIONS_NAME, 'country-id-field');
    $pluginSettings->renderSettingsFields('AddressField', GEOAPI_OPTIONS_NAME, 'address-id-field');
    $pluginSettings->renderSettingsFields('ZipField', GEOAPI_OPTIONS_NAME, 'zip-id-field');
    $pluginSettings->renderSettingsFields('CityField', GEOAPI_OPTIONS_NAME, 'city-id-field');
}
add_action('admin_init', 'setup_plugin_settings');

function geoapiwc__render_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return; ?>
    <section>
        <h2>GeoAPI WC Settings</h2>
        <div class="settings-fields-wrapper">
            <form action="options.php" class="form-wrapper" method="post">
                <?php
                settings_fields(GEOAPI_OPTIONS_NAME);
                do_settings_sections(GEOAPI_MENU_SLUG);
                submit_button();
                ?>
            </form>
        </div>
    </section>
    <?php
}