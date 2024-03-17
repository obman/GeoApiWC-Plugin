<?php

namespace PluginSettings\FieldSettings;

class CityInputIdField implements InterfaceFieldSettings
{
    private string $options_name;
    private string $field_name;

    public function __construct(string $options_name, string $field_name)
    {
        $this->options_name = $options_name;
        $this->field_name   = $field_name;
    }

    public function setupFields(): void
    {
        add_settings_field(
            'city-id-field',
            __('ID of City input field:', 'geoapiwc'),
            array($this, 'renderFieldsHTML'),
            MENU_SLUG,
            'event-handler-fields-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $options = get_option($this->options_name);

        if (isset($options[$this->field_name])) {
            echo sprintf('<input id="%1$s" name="%2$s[%1$s]" type="text" value="%3$s">', $this->field_name, $this->options_name, $options[$this->field_name]);
        }
        else {
            echo sprintf('<input id="%1$s" name="%2$s[%1$s]" type="text" value="#billing_city">', $this->field_name, $this->options_name);
        }
    }
}