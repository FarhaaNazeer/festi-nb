 let displayMenuOnDevice = (() => {
    let self = {};

    self.init = () => {
        let toggleButton = document.getElementById('toggleButton');
        let navLinks = document.getElementById('navLinks');

        toggleButton.addEventListener('click', () => {
            navLinks.classList.toggle('navbar__active');
        });
    }
    return self;
 });

displayMenuOnDevice().init();