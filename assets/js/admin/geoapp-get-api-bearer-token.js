((that) => {
    // get data from optikons
    const geoapiwc = that.geoapiwc;
    const document = that.document;

    document.addEventListener('DOMContentLoaded', () => {
        // find button for activation
        const settingsForm = document.querySelector('form.form-wrapper');
        const bearerTokenButton = document.getElementById('get-bearer-token-button');

        if (! bearerTokenButton) {
            return;
        }

        bearerTokenButton.addEventListener('click', () => {
            let bearerToken = '';

            settingsForm.classList.toggle('disabled');

            // do api call to get bearer token
            fetch(geoapiwc.base_url + '/oauth/token', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'grant_type': 'client_credentials',
                    'client_id': geoapiwc.client_id,
                    'client_secret': geoapiwc.client_secret,
                    'scope': '*'
                })
            })
                .then(function(response) { return response.json(); })
                .then(function(json) {
                    if (! json) {
                        return false;
                    }

                    bearerToken = json.access_token;

                    if (! bearerToken) {
                        document.getElementById(geoapiwc.bearer_token_field_id).value = '';

                        return false;
                    }

                    // set the token in the field
                    document.getElementById(geoapiwc.bearer_token_field_id).value = bearerToken;

                    // update the options
                    document.getElementById('submit').click();
                    settingsForm.classList.toggle('disabled');
                });
        });
    })
})(window);