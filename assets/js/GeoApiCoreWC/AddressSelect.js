import {AddressToCity} from "./AddressToCity.js";
import {ApiOverlay} from "./ApiOverlay.js";
import {AddressSelectHtmlService} from "./AddressSelectHtmlService.js";

export class AddressSelect extends AddressToCity {
    constructor(document, api_url, country_target, address_target, zip_target, city_target) {
        super(document, api_url, country_target, address_target, zip_target, city_target);
    }

    async apiCallGeoAddressesData() {
        const Overlay = new ApiOverlay();
        const HtmlService = new AddressSelectHtmlService();
        let response = null;
        let apiData  = null;

        try {
            const countryCode  = this.getCountryElement().options[this.getCountryElement().selectedIndex].value;
            const addressValue = this.getAddressElement().value;

            Overlay.show(); // Show overlay and loader

            response = await fetch(this.apiUrl + encodeURIComponent(addressValue) + '/' + countryCode);

            if (!response.ok) {
                throw new Error(`API request failed with status: ${response.status}`);
            }

            apiData = await response.json();

            if (!apiData) {
                throw new Error('Invalid API response');
            }

            // Add new HTML with addresses as list to DOM
            // after the address input field
            HtmlService.renderAddresses(apiData, this.getAddressElement());
        } catch (error) {
            console.error('Error fetching addresses:', error);
        } finally {
            Overlay.remove(); // Always remove overlay and loader
        }

        // Add click event handlers for single-address elements
        const addressContainer = this.getAddressElement().parentElement.querySelector('.geoapiwc-content--api-data--container');
        addressContainer
            .querySelectorAll('.single-address')
            .forEach((addressElement) => {
                addressElement.addEventListener('click', (event) => {
                    HtmlService.selectAddressHandler(event, this.getAddressElement(), this.getZipElement(), this.getCityElement(), addressContainer)
                });
            });
    }
}