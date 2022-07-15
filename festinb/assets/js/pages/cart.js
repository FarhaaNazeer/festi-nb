const Routing = require('../components/routing');

let cart = () => {

    let self = {};

    let deleteButtons = document.getElementsByClassName('delete-item');
    let qtyInputs = document.getElementsByClassName('qty-item');
    let total = document.getElementById('total');
    let cartBtnValidate = document.querySelector('.js-cart-validate');

    self.init = () => {
        self.deleteItem();
        self.updateCart();

       
        if (cartBtnValidate){
            cartBtnValidate.addEventListener('click', (event) => {
                let cartUuid = event.target.dataset.cartUuid;
                self.validateCart(cartUuid)
            });
        } 
       
    }

    self.deleteItem = () => {
        for (let i = 0; i < deleteButtons.length; i++) {
            const element = deleteButtons[i];
            if (element) {
                element.addEventListener('click', (e) => {
                    let itemUuid = e.target.getAttribute('data-uuid-item');
                    let itemPrice = parseInt(document.getElementById('item-total-' + itemUuid).innerText);
                    let totalPrice = parseInt(total.innerText);
                    let containerCart = document.getElementById('cart-container-'+itemUuid);

                    self.sendRequest('app_front_delete_cart', {
                        'ticket': {
                            'uuid': itemUuid,
                        },
                    }).then(function (response) {

                        let newTotalPrice = totalPrice - itemPrice;
                        total.textContent = `${newTotalPrice}`;
                        containerCart.remove();

                        if (newTotalPrice == 0) {
                            document.getElementById('container-total').style.display = 'none';
                            let pCartEmpty = document.createElement("p");
                            pCartEmpty.innerHTML = "Aucun article dans ton panier ! Ne perds pas une minute de plus :)";	
                            document.getElementById('container-card').appendChild(pCartEmpty);
                        }                        
                    });
                });
            }
        }
    }

    self.validateCart = (cartUuid) => {

        document.querySelectorAll('.js-cart-item').forEach((item)=>{

            let itemUuid = item.dataset.uuid;
            let itemQuantity = item.querySelector('input').value;

            let cart = {
                'cart' :{
                    'uuid' : cartUuid
                },
                'tickets' :  {
                    'uuid' : itemUuid,
                },
                'quantity' : parseInt(itemQuantity)
            }

            self.sendRequest('app_front_cart_items_validate', cart);
            // self.sendRequest('app_front_cart_validate', cart);
        });
    };

    self.updateCart = () => {
        for (let i = 0; i < qtyInputs.length; i++) {
            const element = qtyInputs[i];
            
            if (element) {
                element.addEventListener('change', (e) => {
                    let newQty = e.target.value;
                    let itemUuid = e.target.getAttribute('data-uuid-item');
                    let itemPrice = parseInt(document.getElementById('item-price-' + itemUuid).value);
                    let totalItemPrice = document.getElementById('item-total-' + itemUuid);
                    let newTotalItemPrice = newQty * itemPrice;

                    totalItemPrice.innerText = `${newTotalItemPrice}`;
                    self.updateTotal();
                  
                    self.sendRequest('app_front_update_item_qty', {
                        'ticket': {
                            'uuid': itemUuid,
                            'qty': newQty
                        },
                    })
                });
            }
        }
    }

    self.updateTotal = () => {
        let items = document.getElementsByClassName('container_card__item');
        let priceTotal = 0;
        for (let i = 0; i < items.length; i++) {
            const element = items[i];
            let uuid = element.getAttribute('data-uuid-item');
            let itemTotal = parseInt(document.getElementById('item-total-' + uuid).innerText);
            priceTotal += itemTotal;
            total.innerText = `${priceTotal}`;
        }
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

        return await response;
    }

    return self;
}

cart().init();