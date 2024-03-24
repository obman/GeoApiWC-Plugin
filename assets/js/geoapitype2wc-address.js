import {AddressToCity} from "./GeoApiType1WC/AddressToCity.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    that.window.addEventListener('load', () => {
        const addressCity = new AddressToCity(
            document,
            'https://geoapi.sample.si/api-type2/v1/address-data/',
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