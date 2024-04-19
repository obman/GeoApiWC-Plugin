export class AddressToCity {
    constructor(document, api_url, country_target, address_target, zip_target, city_target) {
        this.apiUrl         = api_url;
        this.countryElement = document.querySelector(country_target);
        this.addressElement = document.querySelector(address_target);
        this.zipElement     = document.querySelector(zip_target);
        this.cityElement    = document.querySelector(city_target);
    }

    getCountryElement() {
        return this.countryElement;
    }

    getAddressElement() {
        return this.addressElement;
    }

    getZipElement() {
        return this.zipElement;
    }

    getCityElement() {
        return this.cityElement;
    }

    async apiCallGeoAddressData() {
        const
            countryCode = this.countryElement.options[this.countryElement.selectedIndex].value,
            addressValue = this.addressElement.value,
            response = await fetch(this.apiUrl + encodeURIComponent(addressValue) + '/' + countryCode)
        ;

        if (! response.ok) {
            return false;
        }

        const geoData = await response.json();

        // implement better checking ZIP and City separate
        if (! geoData) {
            return false;
        }

        this.zipElement.value  = geoData.zip;
        this.cityElement.value = geoData.name;
    }
}