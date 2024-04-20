import {ZipToCity} from "./GeoApiCoreWC/ZipToCity.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    that.window.addEventListener('load', () => {
        const zipCity = new ZipToCity(
            document,
            geoapiwc.base_url + '/api/geo/v1/type1/city-name',
            geoapiwc.bearer_token,
            geoapiwc.license_key,
            geoapiwc.domain,
            geoapiwc.country_field_id,
            geoapiwc.postcode_field_id,
            geoapiwc.city_field_id
        );

        zipCity.getZipElement().addEventListener('focusout', () => {
            zipCity.apiCallGeoZipData();
        });
    });
})(window);