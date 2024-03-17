<?php

namespace PluginSettings\FieldSettings;

class ApiTypeFields implements InterfaceFieldSettings
{
    public function setupFields(): void
    {
        add_settings_field(
            'zip-to-city',
            'API type',
            array($this, 'renderFieldsHTML'),
            'geoapiwc_settings_fields',
            'api-type-radio-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $html = '<p>';
        $html .= '<label for="zip-to-city">ZIP/Postal code to City name</label>';
        $html .= '<input name="address-to-zip-city" id="address-to-zip-city" type="radio" value="' . get_option('geoapiwc-api-type') . '" />';
        $html .= '</p>';

        $html .= '<p>';
        $html .= '<label for="address-to-zip-city">Address to ZIP and City name</label>';
        $html .= '<input name="address-to-zip-city" id="address-to-zip-city" type="radio" value="' . get_option('geoapiwc-api-type') . '" />';
        $html .= '</p>';

        echo $html;
    }
}