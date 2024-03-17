<?php

namespace PluginSettings\FieldSettings;

use PluginSettings\FieldSettings\InterfaceFieldSettings;

class CityInputIdField implements InterfaceFieldSettings
{

    public function setupFields(): void
    {
        add_settings_field(
            'city-id-field',
            __('ID of City input field:', 'geoapiwc'),
            array($this, 'renderFieldsHTML'),
            'geoapiwc_settings_fields',
            'event-handler-fields-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        echo '<input name="city-id-field" id="city-id-field" type="text" value="' . get_option('geoapiwc-city-id-field') . '" />';
    }
}