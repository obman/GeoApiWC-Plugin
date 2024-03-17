<?php

namespace PluginSettings\FieldSettings;

interface InterfaceFieldSettings
{
    public function setupFields(): void;
    public function renderFieldsHTML(): void;
}