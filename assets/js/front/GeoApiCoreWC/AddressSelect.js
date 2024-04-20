import {AddressToCity} from "./AddressToCity.js";
import {ApiOverlay} from "./ApiOverlay.js";
import {AddressSelectHtmlService} from "./AddressSelectHtmlService.js";

export class AddressSelect extends AddressToCity {
    constructor(document, api_url, bearer_token, license, domain, country_target, address_target, zip_target, city_target,) {
        super(document, api_url, bearer_token, license, domain, country_target, address_target, zip_target, city_target);
    }

    async apiCallGeoAddressesData() {
        const Overlay = new ApiOverlay();
        const HtmlService = new AddressSelectHtmlService();
        let response = null;
        let apiData  = null;

        try {
            const countryCode  = (this.getCountryElement().options !== undefined) ?
                this.getCountryElement().options[this.getCountryElement().selectedIndex].value :
                this.getCountryElement().value;
            const addressValue = this.getAddressElement().value;

            Overlay.show(); // Show overlay and loader

            if (! addressValue) {
                return false;
            }
            //response = await fetch(this.apiUrl + encodeURIComponent(addressValue) + '/' + countryCode);
            response = await fetch(
                this.getApiUrl(),
                {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + this.getBearerToken()
                        },
                        body: JSON.stringify({
                            'address': encodeURIComponent(addressValue),
                            'country': countryCode,
                            'license': this.getLicense(),
                            'domain': this.getDomain()
                        })
                    }
                );

            if (!response.ok) {
                throw new Error(`API request failed with status: ${response.status}`);
            }

            apiData = await response.json();

            if (! apiData) {
                return false;
            }

            if (apiData.error) {
                throw new Error('Invalid API response');
            }

            // Add new HTML with addresses as list to DOM
            // after the address input field
            HtmlService.renderAddresses(apiData, this.getAddressElement());

            // Add click event handlers for single-address elements
            const addressContainer = this.getAddressElement().parentElement.querySelectorAll('.geoapiwc-content--api-data--container');
            addressContainer.forEach((addressElement, _index, array) => {
                // find last '.geoapiwc-content--api-data--container'
                if (_index === array.length - 1) {
                    addressElement
                        .querySelectorAll('.single-address')
                        .forEach((addressElement) => {
                            addressElement.addEventListener('click', (event) => {
                                HtmlService.selectAddressHandler(event, this.getAddressElement(), this.getZipElement(), this.getCityElement(), addressElement)
                            });
                        });
                }
                else {
                    addressElement.remove();
                }
            });
        } catch (error) {
            console.error('Error fetching addresses:', error);
        } finally {
            Overlay.remove(); // Always remove overlay and loader
        }
    }
}