<?php

namespace PluginSettings\SectionSettings;

class EventHandlerFieldsSection implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'event-handler-fields-section',
            __('IDs of checkout fields', 'geoapiwc'),
            array($this, 'additionalSectionInfo'),
            'geoapiwc_settings_fields'
        );
    }

    public function additionalSectionInfo(): ?string
    {
        return __('Enter the ID values of the input badges adapted to your needs', 'geoapiwc');
    }
}