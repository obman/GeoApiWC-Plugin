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

class PluginSettings
{
    public function renderSettingsSection(InterfaceSectionSettings $sectionSettings): void
    {
        $sectionSettings->setupSection();
    }

    public function renderSettingsFields(InterfaceFieldSettings $fieldSettings): void
    {
        $fieldSettings->setupFields();
    }
}