<?php

namespace PluginSettings\FieldSettings;

class ApiTypeFields implements InterfaceFieldSettings
{
    private string $options_name;
    private string $field_name;

    public function __construct(string $options_name, string $field_name)
    {
        $this->options_name  = $options_name;
        $this->field_name   = $field_name;
    }

    public function setupFields(): void
    {
        add_settings_field(
            'zip-to-city',
            'API type: Address to ZIP and City name',
            array($this, 'renderFieldsHTML'),
            MENU_SLUG,
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

        echo "<input id='{$this->field_name}' name='{$this->options_name}[{$this->field_name}]' type='checkbox' value='1' {$_checked}>";
    }
}