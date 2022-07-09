import {cartModal} from "./layouts/cart_modal.js";

let cart = () => {

    let self = {};

    self.init = () => {
        self.targetBtnAddToCart();
        self.targetCloseModalBtn();
    }

    self.targetBtnAddToCart = () => {

        document.querySelector('#js-add-to-cart').addEventListener('click', (event) => {
            event.preventDefault();
            cartModal().openCartModal();
        });
    }

    self.targetCloseModalBtn = () => {
        document.querySelector('.js-cart-modal-close').addEventListener('click', (event) => {
            cartModal().closeCartModal();
        });

        document.querySelector('.js-cart-modal-overlay').addEventListener('click', (event) => {
            cartModal().closeCartModal();
        });

    }

    return self;
}

cart().init();