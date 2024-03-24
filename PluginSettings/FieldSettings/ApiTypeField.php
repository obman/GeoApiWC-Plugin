<?php

namespace PluginSettings\FieldSettings;

class ApiTypeField implements InterfaceFieldSettings
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
            'api-type-engine',
            'API type: choose API type',
            array($this, 'renderFieldsHTML'),
            GEOAPI_MENU_SLUG,
            'api-type-radio-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $options = get_option($this->options_name);
        $_status = array(
            'type1' => false,
            'type2' => false,
            'type3' => false
        );

        if (isset($options[$this->field_name])) {
            /**
             * Checking which radio button
             * for API type settings
             * is activated.
             *
             * When adding new API types,
             * create new CASE
             */
            switch ($options[$this->field_name]) {
                case 1:
                    $_status['type1'] = true;
                    break;
                case 2:
                    $_status['type2'] = true;
                    break;
                case 3:
                    $_status['type3'] = true;
                    break;
            }
        }

        if ($_status['type1']) {
            $html = "<input id='{$this->field_name}-1' name='{$this->options_name}[{$this->field_name}]' type='radio' value='1' checked>";
        }
        else {
            $html = "<input id='{$this->field_name}-1' name='{$this->options_name}[{$this->field_name}]' type='radio' value='1'>";
        }
        $html .= "<label for='{$this->field_name}-1'>API type 1</label>";

        if ($_status['type2']) {
            $html .= "<input id='{$this->field_name}-2' name='{$this->options_name}[{$this->field_name}]' type='radio' value='2' checked>";
        }
        else {
            $html .= "<input id='{$this->field_name}-2' name='{$this->options_name}[{$this->field_name}]' type='radio' value='2'>";
        }
        $html .= "<label for='{$this->field_name}-2'>API type 2</label>";

        if ($_status['type3']) {
            $html .= "<input id='{$this->field_name}-3' name='{$this->options_name}[{$this->field_name}]' type='radio' value='3' checked>";
        }
        else {
            $html .= "<input id='{$this->field_name}-3' name='{$this->options_name}[{$this->field_name}]' type='radio' value='3'>";
        }
        $html .= "<label for='{$this->field_name}-3'>API type 3</label>";

        echo $html;
    }
}