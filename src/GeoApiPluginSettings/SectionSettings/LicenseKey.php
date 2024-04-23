<?php

namespace PluginSettings\SectionSettings;

class LicenseKey implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'license-key-section',
            __('License Key', 'geoapiwc'),
            false,
            GEOAPI_MENU_SLUG
        );
    }
}