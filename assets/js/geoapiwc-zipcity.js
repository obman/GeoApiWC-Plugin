import {ZipToCity} from "./GeoApiWC/ZipToCity.js";

((that) => {
    const document = that.document;

    that.window.addEventListener('load', () => {
        const zipCity = new ZipToCity(
            document,
            '#billing_country', // this needs to be pushed as translatable object data
            '#billing_postcode', // this needs to be pushed as translatable object data
            '#billing_city' // this needs to be pushed as translatable object data
        );

        zipCity.getZipElement().addEventListener('focusout', () => {
            zipCity.apiCallGeoZipData();
        });
    });
})(window);