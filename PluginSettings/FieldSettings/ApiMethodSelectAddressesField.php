<?php

namespace PluginSettings\FieldSettings;

class ApiMethodSelectAddressesField implements InterfaceFieldSettings
{
    private string $options_name;
    private string $field_name;

    public function __construct(string $options_name, string $field_name)
    {
        $this->options_name  = $options_name;
        $this->field_name    = $field_name;
    }

    public function setupFields(): void
    {
        add_settings_field(
            'multiple-addresses-select-option',
            'API method: Select address from multiple address options',
            array($this, 'renderFieldsHTML'),
            GEOAPI_MENU_SLUG,
            'api-type-radio-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $options = get_option($this->options_name);

        if (isset($options[$this->field_name])) {
            if ($options[$this->field_name] === 1 || $options[$this->field_name] === '1') {
                $_checked = ' checked';
            }
            else {
                $_checked = '';
            }
        }
        else {
            $_checked = '';
        }

        $html = "<input id='{$this->field_name}' name='{$this->options_name}[{$this->field_name}]' type='checkbox' value='1' {$_checked}>";
        $html .= "<small>" . __('(Note: Available only in API type 3)', 'geoapiwc') . "</small>";

        echo $html;
    }
}