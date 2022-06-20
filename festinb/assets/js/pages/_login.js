let login = () => {

    let self = {};

    const login = 'login';
    const register = 'register';

    let signInSlide = document.getElementById('signInSlide');
    let signUpSlide = document.getElementById('signUpSlide');

    let signInTitle = document.querySelector('.login--title__signin');
    let siginUpTitle = document.querySelector('.login--title__signup');

    let loginForm = document.querySelector('.login--signin');
    let registerForm = document.querySelector('.login--signup');

    self.init = () => {

        self.displayForm();

        signInSlide.addEventListener('click', (e) => {
            self.displayForm(login);
        });

        signUpSlide.addEventListener('click', (e) => {
            self.displayForm(register);
        });
    }

    self.displayForm = (type) => {

        switch (type) {
            case login:
                loginForm.style.display = 'block';
                signInSlide.classList.add('login--slide-controls__active');
                signInTitle.style.display = 'block';
                registerForm.style.display = 'none';
                signUpSlide.classList.remove('login--slide-controls__active');
                siginUpTitle.style.display = 'none';
                break;
            case register:
                registerForm.style.display = 'block';
                signUpSlide.classList.add('login--slide-controls__active');
                siginUpTitle.style.display = 'block';
                loginForm.style.display = 'none';
                signInSlide.classList.remove('login--slide-controls__active');
                signInTitle.style.display = 'none';
                break;

            default:
                loginForm.style.display = 'block';
                signInSlide.classList.add('login--slide-controls__active');
                signInTitle.style.display = 'block';
                registerForm.style.display = 'none';
                signUpSlide.classList.remove('login--slide-controls__active');
                siginUpTitle.style.display = 'none';
        }
    };

    return self;
}

login().init();