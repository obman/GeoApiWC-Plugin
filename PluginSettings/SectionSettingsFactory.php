<?php

namespace PluginSettings;

use http\Exception\InvalidArgumentException;
use PluginSettings\SectionSettings\ApiTypeSection;
use PluginSettings\SectionSettings\EventHandlerFieldsSection;
use PluginSettings\SectionSettings\InterfaceSectionSettings;

class SectionSettingsFactory
{
    public static function create(string $sectionType): InterfaceSectionSettings
    {
        return match ($sectionType) {
            'ApiType' => new ApiTypeSection(),
            'EventHandlerFields' => new EventHandlerFieldsSection(),
            default => throw new InvalidArgumentException("Invalid section type: $sectionType"),
        };
    }
}