<?php

namespace PluginSettings\FieldSettings;

use PluginSettings\FieldSettings\InterfaceFieldSettings;

class ZipInputIdField implements InterfaceFieldSettings
{

    public function setupFields(): void
    {
        add_settings_field(
            'zip-id-field',
            __('ID of ZIP/Postcode input field:', 'geoapiwc'),
            array($this, 'renderFieldsHTML'),
            'geoapiwc_settings_fields',
            'event-handler-fields-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        echo '<input name="zip-id-field" id="zip-id-field" type="text" value="' . get_option('geoapiwc-zip-id-field') . '" />';
    }
}