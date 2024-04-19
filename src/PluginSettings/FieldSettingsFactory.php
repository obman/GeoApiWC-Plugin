<?php

namespace PluginSettings;

use http\Exception\InvalidArgumentException;
use PluginSettings\FieldSettings\AddressInputIdField;
use PluginSettings\FieldSettings\ApiBearerTokenField;
use PluginSettings\FieldSettings\ApiClientIdField;
use PluginSettings\FieldSettings\ApiClientSecretField;
use PluginSettings\FieldSettings\ApiMethodAddressToZipCityField;
use PluginSettings\FieldSettings\ApiMethodSelectAddressesField;
use PluginSettings\FieldSettings\ApiTypeField;
use PluginSettings\FieldSettings\CityInputIdField;
use PluginSettings\FieldSettings\CountryInputIdField;
use PluginSettings\FieldSettings\InterfaceFieldSettings;
use PluginSettings\FieldSettings\LicenseKeyField;
use PluginSettings\FieldSettings\ZipInputIdField;

class FieldSettingsFactory
{
    public static function create(string $fieldType, string $options_name, string $field_name): InterfaceFieldSettings
    {
        return match ($fieldType) {
			'ApiClientIDField' => new ApiClientIdField($options_name, $field_name),
	        'ApiClientSecretField' => new ApiClientSecretField($options_name, $field_name),
	        'ApiBearerTokenField' => new ApiBearerTokenField($options_name, $field_name),
	        'LicenseKeyField' => new LicenseKeyField($options_name, $field_name),
            'ApiTypeField' => new ApiTypeField($options_name, $field_name),
            'ApiMethodAddressToZIPCityField' => new ApiMethodAddressToZipCityField($options_name, $field_name),
            'ApiMethodSelectAddressesField' => new ApiMethodSelectAddressesField($options_name, $field_name),
            'CountryField' => new CountryInputIdField($options_name, $field_name),
            'AddressField' => new AddressInputIdField($options_name, $field_name),
            'ZipField' => new ZipInputIdField($options_name, $field_name),
            'CityField' => new CityInputIdField($options_name, $field_name),
            default => throw new InvalidArgumentException("Invalid field type: $fieldType"),
        };
    }
}