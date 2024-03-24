<?php

/*
 * Plugin Name:       GeoAPI WC
 * Plugin URI:        https://github.com/obman/GeoApiWC
 * Description:       Integrate GeoAPI into WooCommerce checkout address fields.
 * Author:            obman
 * Version:           1.0.1
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author             URI: https://github.com/obman/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       geoapiwc
*/

use PluginSettings\FieldSettings\ApiMethodField;
use PluginSettings\FieldSettings\ApiTypeField;
use PluginSettings\FieldSettings\CityInputIdField;
use PluginSettings\FieldSettings\CountryInputIdField;
use PluginSettings\FieldSettings\AddressInputIdField;
use PluginSettings\FieldSettings\ZipInputIdField;
use PluginSettings\PluginSettings;
use PluginSettings\SectionSettings\ApiTypeSection;
use PluginSettings\SectionSettings\EventHandlerFieldsSection;

if ( ! defined( 'ABSPATH' ) ) exit;

define('GEOAPIWC_DIR', plugin_dir_url( __FILE__ ));

const GEOAPI_OPTIONS_NAME = 'geoapiwc_settings_options';
const GEOAPI_MENU_SLUG = 'geoapiwc-plugin';

// Register plugin hooks
function geoapiwc__settings_page(): void {
    add_menu_page('GeoApiType1WC', 'GeoAPI WC Settings', 'manage_options', GEOAPI_MENU_SLUG, 'geoapiwc__render_options_page_html', 'dashicons-rest-api');
}
add_action('admin_menu', 'geoapiwc__settings_page');

/**
 * Frontend assets
 *
 * @return void
 */
function geoapiwc__load_assets__frontend(): void {
    wp_register_script('geoapitype1wc-zipcity', GEOAPIWC_DIR . 'assets/js/geoapitype1wc-zipcity.js', false, '1.0', array('strategy' => 'defer', 'in_footer' => 'true'));
    wp_register_script('geoapitype1wc-address', GEOAPIWC_DIR . 'assets/js/geoapitype1wc-address.js', false, '1.0', array('strategy' => 'defer', 'in_footer' => 'true'));

    $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
    if (stripos(implode($all_plugins), 'woocommerce.php')) {
        if (is_checkout()) {
            $options     = get_option(GEOAPI_OPTIONS_NAME);
            $script_data = array(
                'country_field_id'  => $options['country-id-field'],
                'address_field_id'  => $options['address-id-field'],
                'postcode_field_id' => $options['zip-id-field'],
                'city_field_id'     => $options['city-id-field']
            );

            if (isset($options['api-type'])) {
                switch ($options['api-type']) {
                    case 1:
                        if (isset($options['api-method'])) {
                            wp_enqueue_script('geoapitype1wc-address');
                            wp_localize_script('geoapitype1wc-address', 'geoapiwc', $script_data);
                        }
                        else {
                            wp_enqueue_script('geoapitype1wc-zipcity');
                            wp_localize_script('geoapitype1wc-zipcity', 'geoapiwc', $script_data);
                        }
                        break;
                    case 2:
                        break;
                    case 3:
                        break;
                }
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'geoapiwc__load_assets__frontend' );

function geoapiwc__load_js_as_ES6($tag, $handle, $src) {
    if (
        $handle === 'geoapitype1wc-zipcity' ||
        $handle === 'geoapitype1wc-address'
    ) {
        return '<script src="' . esc_url( $src ) . '" type="module"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'geoapiwc__load_js_as_ES6', 10, 3);

## Helper functions
require 'PluginSettings/PluginSettings.php';

function setup_plugin_settings(): void
{
    register_setting(GEOAPI_OPTIONS_NAME, GEOAPI_OPTIONS_NAME);

    $pluginSettings = new PluginSettings();
    $pluginSettings->renderSettingsSection(new ApiTypeSection());
    $pluginSettings->renderSettingsSection(new EventHandlerFieldsSection());

    $pluginSettings->renderSettingsFields(new ApiTypeField(GEOAPI_OPTIONS_NAME, 'api-type'));

    $pluginSettings->renderSettingsFields(new ApiMethodField(GEOAPI_OPTIONS_NAME, 'api-method'));
    $pluginSettings->renderSettingsFields(new CountryInputIdField(GEOAPI_OPTIONS_NAME, 'country-id-field'));
    $pluginSettings->renderSettingsFields(new AddressInputIdField(GEOAPI_OPTIONS_NAME, 'address-id-field'));
    $pluginSettings->renderSettingsFields(new ZipInputIdField(GEOAPI_OPTIONS_NAME, 'zip-id-field'));
    $pluginSettings->renderSettingsFields(new CityInputIdField(GEOAPI_OPTIONS_NAME, 'city-id-field'));
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