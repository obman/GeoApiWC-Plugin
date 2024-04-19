<?php

namespace PluginSettings\SectionSettings;

class ApiCredentials implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'api-credentials-section',
            __('API Credentials', 'geoapiwc'),
            false,
            GEOAPI_MENU_SLUG
        );
    }
}