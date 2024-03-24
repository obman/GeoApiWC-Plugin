import {ZipToCity} from "./GeoApiType1WC/ZipToCity.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    that.window.addEventListener('load', () => {
        const zipCity = new ZipToCity(
            document,
            geoapiwc.country_field_id,
            geoapiwc.postcode_field_id,
            geoapiwc.city_field_id
        );

        zipCity.getZipElement().addEventListener('focusout', () => {
            zipCity.apiCallGeoZipData();
        });
    });
})(window);