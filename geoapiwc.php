<?php

/*
 * Plugin Name:       GeoAPI WC
 * Plugin URI:        https://github.com/obman/GeoApiWC
 * Description:       Integrate GeoAPI into WooCommerce checkout address fields.
 * Author:            obman
 * Version:           1.0
 * Requires at least: 6.4
 * Requires PHP:      8.3
 * Author             URI: https://github.com/obman/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       geoapiwc
*/

use PluginSettings\FieldSettings\ApiTypeFields;
use PluginSettings\FieldSettings\CityInputIdField;
use PluginSettings\FieldSettings\CountryInputIdField;
use PluginSettings\FieldSettings\ZipInputIdField;
use PluginSettings\PluginSettings;
use PluginSettings\SectionSettings\ApiTypeSection;
use PluginSettings\SectionSettings\EventHandlerFieldsSection;

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GEOAPIWC_DIR', plugin_dir_url( __FILE__ ) );

// Register plugin hooks
function geoapiwc__settings_page(): void {
    add_menu_page('GeoApiWC', 'GeoAPI WC Settings', 'manage_options', 'geoapiwc', 'geoapiwc__render_options_page_html', 'dashicons-rest-api');
}
add_action('admin_menu', 'geoapiwc__settings_page');

/**
 * Frontend assets
 *
 * @return void
 */
function geoapiwc__load_assets__frontend(): void {
    wp_register_script('geoapiwc-zipcity', GEOAPIWC_DIR . 'assets/js/geoapiwc-zipcity.js', false, '1.0', array('strategy' => 'defer', 'in_footer' => 'true'));

    $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
    if (stripos(implode($all_plugins), 'woocommerce.php')) {
        if (is_checkout()) {
            $script_data = array(
                'country_field_id'  => '#billing_country', // this needs to get from settings
                'postcode_field_id' => '#billing_postcode', // this needs to get from settings
                'city_field_id'     => '#billing_city' // this needs to get from settings
            );

            wp_enqueue_script('geoapiwc-zipcity');
            wp_localize_script('geoapiwc-zipcity', 'api_object', $script_data);
        }
    }
}
add_action( 'wp_enqueue_scripts', 'geoapiwc__load_assets__frontend' );

function geoapiwc__load_js_as_ES6($tag, $handle, $src) {
    if (
        $handle === 'geoapiwc-zipcity'/* ||
        $handle === 'germ-main-checkout-script'*/
    ) {
        return '<script src="' . esc_url( $src ) . '" type="module"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'geoapiwc__load_js_as_ES6', 10, 3);

## Helper functions
require 'PluginSettings/PluginSettings.php';
function setup_sections(): void
{
    $pluginSettings = new PluginSettings();
    $pluginSettings->renderSettingsSection(new ApiTypeSection());
    $pluginSettings->renderSettingsSection(new EventHandlerFieldsSection());
}
add_action('admin_init', 'setup_sections');

function setup_fields(): void
{
    $pluginSettings = new PluginSettings();
    $pluginSettings->renderSettingsFields(new ApiTypeFields());
    $pluginSettings->renderSettingsFields(new CountryInputIdField());
    $pluginSettings->renderSettingsFields(new ZipInputIdField());
    $pluginSettings->renderSettingsFields(new CityInputIdField());
}
add_action('admin_init', 'setup_fields');

function geoapiwc__render_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return; ?>
    <section>
        <h2>GeoAPI WC Settings</h2>
        <div class="settings-fields-wrapper">
            <form action="options.php" class="form-wrapper" method="post">
                <?php
                settings_fields( 'geoapiwc_settings_fields' );
                do_settings_sections( 'geoapiwc_settings_fields' );
                submit_button();
                ?>
            </form>
        </div>
    </section>
    <?php
}