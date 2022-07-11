import {cartModal} from "./layouts/cart_modal.js";

const Routing = require('./routing');


let cart = () => {

    let self = {};

    self.init = () => {

        self.targetBtnAddToCart();
        self.targetCloseModalBtn();
    }

    self.targetBtnAddToCart = () => {

        document.querySelectorAll('.js-add-to-cart').forEach( (addToCartBtn) => {
            addToCartBtn.addEventListener('click', (event) => {
                let ticket = addToCartBtn.closest('.js-ticket');
                let ticketUuid = ticket.dataset.uuid;
                let quantity = ticket.querySelector('.js-ticket-quantity').value;

                if (quantity === 0) {
                    throw new Error('Please add a minimun quantity of 1');
                }

                let cartUuid = localStorage.getItem('cartUuid');

                if (!cartUuid) {
                    self.createCart(ticketUuid, quantity);
                }

                self.addItemToCart(cartUuid, ticketUuid, quantity);
            });
        })
    }

    self.targetCloseModalBtn = () => {
        document.querySelector('.js-cart-modal-close').addEventListener('click', (event) => {
            cartModal().closeCartModal();
        });

        document.querySelector('.js-cart-modal-overlay').addEventListener('click', (event) => {
            cartModal().closeCartModal();
        });

    }

    self.createCart = (ticketUuid, quantity) => {
        self.sendRequest('app_front_create_cart', {
            'ticket': {
                'uuid': ticketUuid,
                'quantity': parseInt(quantity)
            }
        }).then(function (response) {
                localStorage.setItem('cartUuid', response);
            }
        );
    }


    self.addItemToCart = () => {

    }


    self.sendRequest = async (route, data) => {

        let url = Routing.generate(route);

        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(response.statusText);
        }

        return await response.json();
    }

    return self;
}

cart().init();