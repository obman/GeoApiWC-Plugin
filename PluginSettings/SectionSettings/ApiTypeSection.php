<?php

namespace PluginSettings\SectionSettings;

class ApiTypeSection implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'api-type-radio-section',
            __('Which type of geocoding API', 'geoapiwc'),
            false,
            MENU_SLUG
        );
    }
}