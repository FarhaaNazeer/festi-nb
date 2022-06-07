import Routing from '/public/bundles/fosjsrouting/js/router.min.js';

function handleCredentialResponse(response) {

    let url = Routing.generate('app_auth_google');
    console.log(url);
    return fetch(url).then(feedback => {
        console.log(feedback);
    });

    // async () => {
    //     const feedback = await fetch(url, {
    //         method: 'POST',
    //         body: JSON.stringify({
    //             'credential': response.credential,
    //         }),
    //         headers: {
    //             'Content-Type': 'application/json'
    //         }
    //     });
    //
    //     if (!feedback.ok) {
    //         throw new Error(feedback.status);
    //     }
    //     return await feedback.json();
    // };
    // console.log(response);
    // console.log("Encoded JWT ID token: " + response.credential);
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