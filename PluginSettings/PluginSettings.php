<?php

namespace PluginSettings;

use PluginSettings\FieldSettings\InterfaceFieldSettings;
use PluginSettings\SectionSettings\InterfaceSectionSettings;

require 'SectionSettings/InterfaceSectionSettings.php';
require 'SectionSettings/ApiTypeSection.php';
require 'SectionSettings/EventHandlerFieldsSection.php';

require 'FieldSettings/InterfaceFieldSettings.php';
require 'FieldSettings/ApiTypeField.php';
require 'FieldSettings/ApiMethodAddressToZipCityField.php';
require 'FieldSettings/ApiMethodSelectAddressesField.php';
require 'FieldSettings/CountryInputIdField.php';
require 'FieldSettings/AddressInputIdField.php';
require 'FieldSettings/ZipInputIdField.php';
require 'FieldSettings/CityInputIdField.php';

require 'SectionSettingsFactory.php';
require 'FieldSettingsFactory.php';

class PluginSettings
{
    public function renderSettingsSection(string $sectionType): void
    {
        $sectionSettings = SectionSettingsFactory::create($sectionType);
        $sectionSettings->setupSection();
    }

    public function renderSettingsFields(string $fieldType, string $options_name, string $field_name): void
    {
        $fieldSettings = FieldSettingsFactory::create($fieldType, $options_name, $field_name);
        $fieldSettings->setupFields();
    }
}