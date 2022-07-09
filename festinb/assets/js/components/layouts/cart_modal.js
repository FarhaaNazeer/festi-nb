export let cartModal = () => {

    let self = {};
    let cartModal = document.querySelector('.js-cart-modal');
    let overlay = document.querySelector('.js-cart-modal-overlay');

    self.init = () => {

    };

    self.openCartModal = () => {
        cartModal.classList.add('cart-modal__open');
        overlay.classList.add('cart-modal__overlay--display');
    };

    self.closeCartModal = () => {
        cartModal.classList.remove('cart-modal__open');
        overlay.classList.remove('cart-modal__overlay--display');
    };

    return self;
}

cartModal().init();