import {AddressToCity} from "./GeoApiCoreWC/AddressToCity.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    that.window.addEventListener('load', () => {
        const addressCity = new AddressToCity(
            document,
            geoapiwc.base_url + '/api/geo/v1/type1/address-data',
            geoapiwc.bearer_token,
            geoapiwc.license_key,
            geoapiwc.domain,
            geoapiwc.country_field_id,
            geoapiwc.address_field_id,
            geoapiwc.postcode_field_id,
            geoapiwc.city_field_id
        );
        
        addressCity.getAddressElement().addEventListener('focusout', () => {
            addressCity.apiCallGeoAddressData();
        });
    });
})(window);