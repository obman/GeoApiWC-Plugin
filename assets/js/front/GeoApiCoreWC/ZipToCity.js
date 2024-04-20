export class ZipToCity {
    constructor(document, api_url, bearer_token, license, domain, country_target, zip_target, city_target) {
        this.apiUrl    = api_url;
        this.bearerToken    = bearer_token;
        this.license        = license;
        this.domain         = domain;
        this.countryElement = document.querySelector(country_target);
        this.zipElement     = document.querySelector(zip_target);
        this.cityElement    = document.querySelector(city_target);
    }

    getApiUrl() {
        return this.apiUrl;
    }

    getBearerToken() {
        return this.bearerToken;
    }

    getLicense() {
        return this.license;
    }

    getDomain() {
        return this.domain;
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
                        'zip': zipCode,
                        'country': countryCode,
                        'license': this.getLicense(),
                        'domain': this.getDomain()
                    })
                }
            )
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