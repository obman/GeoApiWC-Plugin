<?php

namespace PluginSettings;

use PluginSettings\FieldSettings\InterfaceFieldSettings;
use PluginSettings\SectionSettings\InterfaceSectionSettings;

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