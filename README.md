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

### API Type

Choose the geocoding API that best suits your needs.
Different APIs offer varying data and accuracy levels.  
We recommend trying each one to find the optimal fit for your store.

*Note: Currently  are 3 types of geocode API available.*

### API Method

Select the desired geocoding method:

* **Address to ZIP/Postcode and City:** Check this box to automatically fill both city and ZIP/postal code based on the entered address.
* **ZIP/Postcode to City:** Leave unchecked if you only want to fill the city based on the ZIP/postal code.

*Note: Currently only API type 1 offers both options.*

### Fields IDs

Enter the IDs of your input fields.

By default, the plugin populates the IDs of the standard WooCommerce checkout form fields.
If you're using custom checkout elements, enter their respective IDs here.

**Here's how to find field IDs:**

1. Access your WordPress dashboard.
2. Navigate to Appearance > Widgets.
3. Add the "Custom HTML" widget to a sidebar.
4. Paste the following code into the widget content area:
```html
<script>
  console.log(document.getElementById('billing_postcode').id);
  console.log(document.getElementById('billing_city').id);
</script>
```
5. Save the widget.
6. Visit your checkout page and open your browser's developer console (usually by pressing F12). 
7. Look for the logged IDs in the console. These are the IDs you need to enter in the plugin settings.

**Remember to remove the "Custom HTML" widget afterward.**

## License

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

To the extent possible under law, [obman](https://github.com/obman) has waived all copyright and related or neighboring rights to this work.