# GeoAPI WooCommerce plugin

**Contributors:** (obman)  
**Tags:** comments, spam  
**Requires at least:** 6.0  
**Tested up to:** 6.4  
**Stable tag:** 1.2  
**License:** MIT  
**License URI:** https://opensource.org/licenses/MIT

Geocode API plugin for WooCommerce checkout forms

## Description

**Simplify your WooCommerce checkout with automatic location filling!**

Save your customers time and frustration by automatically filling in their city and ZIP/postal code based on their address input.
GeoApiWC uses various high-performance geocoding APIs to ensure a smooth and speedy checkout experience.

### Here's what GeoApiWC offers:

* **Automatic Location Filling:** Reduce checkout time by automatically filling in city and ZIP/postal code during address entry.
* **Multiple Geocoding Options:** Choose from 3 different API types to find the best fit for your needs.
* **Flexibility:** Enable only ZIP/postal code to city name geocoding if preferred.
* **Performance Focused:** Lightweight and asynchronous operations ensure minimal impact on your store's speed.
* **Modular Design:** Easily extend and customize the plugin's functionality.
* **Stable APIs:** Benefit from reliable and well-supported geocoding APIs.
* **Settings Panel:** Fine-tune the plugin's behavior to perfectly suit your store.

**Start saving your customers time and streamlining your checkout process today!**

## Installation

1. **Upload:** `GeoApiWC` folder to the `/wp-content/plugins/` directory
2. **Activate:** Navigate to the 'Plugins' menu in your WordPress dashboard and activate GeoApiWC.

## Settings

### API Type Settings

Choose which type of API would you like to use.

Not all API types return same data
at same accuracy. Best practice is to play with different types of API and find out for yourself
which API type best suit your needs.

**There are currently 3 types of geocode API available.**

### API Method Settings

Choose API method type.

If you want to geocode **address** to **ZIP/Postcode and City name** check checkbox field.

If you want to geocode **ZIP/Postcode** to **City name**, mark unchecked.

**Currently only API type 1 offers both options.**

### Fields IDs settings

Enter ID of input fields.

Right after you install plugin there will be default WooCommerce checkout form ID populated.
You can use this or if you have custom elements you can enter your values.

## License

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

To the extent possible under law, [obman](https://github.com/obman) has waived all copyright and related or neighboring rights to this work.