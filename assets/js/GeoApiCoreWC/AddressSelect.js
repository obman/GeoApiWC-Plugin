import {AddressToCity} from "./AddressToCity.js";

export class AddressSelect extends AddressToCity {
    constructor(document, api_url, country_target, address_target, zip_target, city_target) {
        super(document, api_url, country_target, address_target, zip_target, city_target);
    }

    async apiCallGeoAddressesData() {
        const
            countryCode = this.getCountryElement().options[this.getCountryElement().selectedIndex].value,
            addressValue = this.getAddressElement().value,
            response = await fetch(this.apiUrl + encodeURIComponent(addressValue) + '/' + countryCode)
        ;

        if (! response.ok) {
            console.error("API request failed with status:", response.status);
            return false;
        }

        const apiData = await response.json();

        if (! apiData) {
            return false;
        }

        // Add new HTML with addresses as list to DOM
        // after the address input field
        this.#appendSelectAddressHtml(apiData);

        // Add click event handlers for single-address elements
        const addressContainer = this.getAddressElement().parentElement.querySelector('.geoapiwc-content--api-data--container');
        addressContainer
            .querySelectorAll('.single-address')
            .forEach((addressElement) => {
                addressElement.addEventListener('click', (event) => {
                    this.#selectAddressHandler(event, this.getAddressElement(), this.getZipElement(), this.getCityElement(), addressContainer)
                });
            });
    }

    #createAddressContainer(addressFieldHeight) {
        const _addressContainer = document.createElement('span');

        _addressContainer.classList.add('geoapiwc-content--api-data--container');
        _addressContainer.style.top = `${addressFieldHeight}px`;

        return _addressContainer;
    }

    #createSelectAddressesHtml(apiAddresses) {
        let html = '';
        apiAddresses.forEach((apiAddress) => {
            html += `<span class="single-address" data-address="${apiAddress.address}" data-street="${apiAddress.street}" data-zip="${apiAddress.zip}" data-city="${apiAddress.name}">${apiAddress.address}</span>`;
        });

        return html;
    }

    #appendSelectAddressHtml(apiData) {
        const addressContainer = this.#createAddressContainer(this.getAddressElement().offsetHeight);

        addressContainer.innerHTML = this.#createSelectAddressesHtml(apiData);

        // Add a class to highlight suggested address container
        this.addressElement.parentElement.classList.add('geoapiwc-parent-wrapper');

        // Append the address container to the parent element
        this.addressElement.parentElement.appendChild(addressContainer);
    }

    #selectAddressHandler(event, addressElement, zipElement, cityElement, addressContainer) {
        const selectedAddressElement = event.target; // Get the clicked address element
        const address = selectedAddressElement.dataset.address;
        const zip = selectedAddressElement.dataset.zip;
        const city = selectedAddressElement.dataset.city;

        //this.addressElement.value = address; // Update address field
        zipElement.value = zip; // Update ZIP field
        cityElement.value = city; // Update city field

        // Hide the address suggestions container
        addressElement.parentElement.classList.remove('geoapiwc-parent-wrapper'); // Assuming this class hides the container
        addressContainer.remove(); // remove all addresses from DOM
    }
}