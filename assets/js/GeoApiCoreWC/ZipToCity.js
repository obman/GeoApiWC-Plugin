export class ZipToCity {
    constructor(document, country_target, zip_target, city_target) {
        this.countryElement = document.querySelector(country_target);
        this.zipElement     = document.querySelector(zip_target);
        this.cityElement    = document.querySelector(city_target);
    }

    getCountryElement() {
        return this.countryElement;
    }

    getZipElement() {
        return this.zipElement;
    }

    getCityElement() {
        return this.cityElement;
    }

    async apiCallGeoZipData() {
        const
            zipCode     = this.zipElement.value,
            countryCode = this.countryElement.options[this.countryElement.selectedIndex].value,
            response = await fetch('https://geoapi.sample.si/api-type1/v1/city-name/' + zipCode + '/' + countryCode)
        ;

        if (! response.ok) {
            return false;
        }

        const cityData = await response.json();

        if (! cityData) {
            return false;
        }

        this.cityElement.value = cityData.name;
    }
}