const Routing = require('./router.js');

function handleCredentialResponse(response) {

    let url = Routing.generate('app_auth_google');
    return fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            'client_id'  : response.clientId,
            'credential' : response.credential,
        }),
        headers: {
            'Content-Type' : 'application/json'
        }
    }).then(feedback => {
        console.log(feedback);
    });
}

window.onload = function () {
    google.accounts.id.initialize({
        client_id: "714449132704-vq2rndrmrocmkh8ps846lv5lmqb3kh96.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
    );
    google.accounts.id.prompt(); // also display the One Tap dialog
}