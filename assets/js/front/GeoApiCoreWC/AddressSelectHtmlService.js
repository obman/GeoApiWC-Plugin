export class AddressSelectHtmlService {
    /**
     * Create container for address list.
     * 
     * @param addressFieldHeight
     * @returns {*}
     */
    #createAddressContainer(addressFieldHeight) {
        const _addressContainer = document.createElement('span');

        _addressContainer.classList.add('geoapiwc-content--api-data--container');
        _addressContainer.style.top = `${addressFieldHeight}px`;

        return _addressContainer;
    }

    /**
     * Create address list HTML.
     * Each address has data parameters populated with api data.
     *
     * @param apiAddresses
     * @returns {string}
     */
    #createSelectAddressesHtml(apiAddresses) {
        let html = '';
        apiAddresses.forEach((apiAddress) => {
            html += `<span class="single-address" data-address="${apiAddress.address}" data-street="${apiAddress.street}" data-zip="${apiAddress.zip}" data-city="${apiAddress.name}">${apiAddress.address}</span>`;
        });

        return html;
    }

    renderAddresses(apiData, addressElement) {
        const addressContainer = this.#createAddressContainer(addressElement.offsetHeight);

        addressContainer.innerHTML = this.#createSelectAddressesHtml(apiData);

        // Add a class to highlight suggested address container
        addressElement.parentElement.classList.add('geoapiwc-parent-wrapper');

        // Append the address container to the parent element
        addressElement.parentElement.appendChild(addressContainer);
    }

    selectAddressHandler(event, addressElement, zipElement, cityElement, addressContainer) {
        const selectedAddressElement = event.target; // Get the clicked address element
        const address = selectedAddressElement.dataset.address;
        const zip = selectedAddressElement.dataset.zip;
        const city = selectedAddressElement.dataset.city;

        //this.addressElement.value = address; // Update address field
        zipElement.value = zip; // Update ZIP field
        cityElement.value = city; // Update city field

        // Hide the address suggestions container
        addressElement.parentElement.classList.remove('geoapiwc-parent-wrapper'); // Assuming this class hides the container
        addressContainer.parentNode.remove(); // remove all addresses from DOM
    }
}