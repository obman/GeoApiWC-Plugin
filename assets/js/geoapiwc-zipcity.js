import {ZipToCity} from "./GeoApiWC/ZipToCity";

((that) => {
    const document = that.document;

    that.window.addEventListener('load', () => {
        const zipCity = new ZipToCity(
            document,
            '#billing_country',
            '#billing_postcode',
            '#billing_city'
        );

        zipCity.getZipElement().addEventListener('focusout', () => {
            zipCity.apiCallGeoZipData();
        });
    });
})(window);