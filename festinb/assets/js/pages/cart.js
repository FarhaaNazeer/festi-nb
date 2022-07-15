const Routing = require('../components/routing');

let cart = () => {

    let self = {};

    let deleteButtons = document.getElementsByClassName('delete-item');
    let qtyInputs = document.getElementsByClassName('qty-item');
    let total = document.getElementById('total');
    let cartBtnValidate = document.querySelector('.js-cart-validate');

    self.init = () => {
        self.deleteItem();
       // self.updateCart();

       
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

                    self.sendRequest('app_front_delete_cart', {
                        'ticket': {
                            'uuid': itemUuid,
                        },
                    }).then(function (response) {
                        const containerCart = document.getElementById('cart-container-'+itemUuid);
                        containerCart.remove();

                        let itemPrice = parseInt(document.getElementById('item-total-' + itemUuid).innerText);

                        let totalPrice = parseInt(total.innerText);

                        let newTotalPrice = totalPrice - itemPrice;

                        if (newTotalPrice == 0) {
                            document.getElementById('cart-container-total').style.display = 'none';
                            let pCartEmpty = document.createElement("p");
                            pCartEmpty.innerHTML = "Aucun article dans ton panier ! Ne perds pas une minute de plus :)";	
                        
                            document.getElementById('card-container').appendChild(pCartEmpty);
                        }

                        total.textContent = `${newTotalPrice}`;



                        
                    });
                });
            }
        }
    }

    self.updateCart = () => {
        for (let i = 0; i < qtyInputs.length; i++) {
            const element = qtyInputs[i];
            
            element.addEventListener('change', (e) => {
                let uuidItem = e.target.getAttribute('data-uuid-item');
                let itemPrice = parseInt(document.getElementById('item-price-' + uuidItem).innerText);
                let itemQty = parseInt(e.target.value);
                let itemTotal = itemPrice * itemQty;

                document.getElementById('item-total-' + uuidItem).innerText = itemTotal;

                console.log(itemTotal);
                

            });
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