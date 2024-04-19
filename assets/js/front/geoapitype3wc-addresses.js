import {AddressSelect} from "./GeoApiCoreWC/AddressSelect.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    that.window.addEventListener('load', () => {
        const addressesCity = new AddressSelect(
            document,
            'https://geoapi.sample.si/api-type3/v1/addresses-data/',
            geoapiwc.country_field_id,
            geoapiwc.address_field_id,
            geoapiwc.postcode_field_id,
            geoapiwc.city_field_id
        );
        
        addressesCity.getAddressElement().addEventListener('change', () => {
            addressesCity.apiCallGeoAddressesData();
        });
    });
})(window);