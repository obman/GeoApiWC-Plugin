import {AddressSelect} from "./GeoApiCoreWC/AddressSelect.js";

((that) => {
    const
        document = that.document,
        geoapiwc = that.geoapiwc
    ;

    console.log (geoapiwc);

    that.window.addEventListener('load', () => {
        const addressesCity = new AddressSelect(
            document,
            geoapiwc.base_url + '/api/geo/v1/type3/addresses-data',
            geoapiwc.bearer_token,
            geoapiwc.license_key,
            geoapiwc.domain,
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