<?php

namespace PluginSettings\FieldSettings;

class CountryInputIdField implements InterfaceFieldSettings
{

    public function setupFields(): void
    {
        add_settings_field(
            'country-id-field',
            __('ID of country input field:', 'geoapiwc'),
            array($this, 'renderFieldsHTML'),
            'geoapiwc_settings_fields',
            'event-handler-fields-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        echo '<input name="country-id-field" id="country-id-field" type="text" value="' . get_option('geoapiwc-country-id-field') . '" />';
    }
}