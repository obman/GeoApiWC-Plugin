<?php

namespace PluginSettings;

use http\Exception\InvalidArgumentException;
use PluginSettings\SectionSettings\ApiCredentials;
use PluginSettings\SectionSettings\ApiTypeSection;
use PluginSettings\SectionSettings\EventHandlerFieldsSection;
use PluginSettings\SectionSettings\InterfaceSectionSettings;
use PluginSettings\SectionSettings\LicenseKey;

class SectionSettingsFactory
{
    public static function create(string $sectionType): InterfaceSectionSettings
    {
        return match ($sectionType) {
			'ApiCredentials' => new ApiCredentials(),
	        'LicenseKey' => new LicenseKey(),
            'ApiType' => new ApiTypeSection(),
            'EventHandlerFields' => new EventHandlerFieldsSection(),
            default => throw new InvalidArgumentException("Invalid section type: $sectionType"),
        };
    }
}