let products = [];
let currencySymbol = '';
const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
const cartItemsContainer = document.getElementById('cartItems');
const totalAmountElement = document.getElementById('totalAmount');
const cartCounter = document.getElementById('cartCounter');
let cartItems = [];

/**Update Cart on load */
function getCartProducts() {
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'get_cart_products',
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.data && data.data.length) {
                cartItems = data.data
                localStorage.setItem('cartItems', JSON.stringify(cartItems))
                updateCart()
                updateCartCounter()
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
/**Update Cart on load End*/

function addToWooCommerceCart(productId) {
    const data = {
        action: 'add_to_cart',
        product_id: productId,
    };

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(data),
    })
        .then(response => response.json())
        .then(responseData => {
            // console.log('Product added to cart:', responseData);
        })
        .catch(error => {
            // console.error('Error adding product to cart:', error);
        });
}

function updateCart() {
    cartItemsContainer.innerHTML = '';
    cartItems.forEach(item => addToCartUI(item));
    updateTotalAmount();
}

function addToCartUI(product) {
    const cartItem = document.createElement('div');
    cartItem.classList.add('cart-item');

    const price = parseFloat(product.price).toFixed(2)

    cartItem.innerHTML = `
        <div class="cart_img">
            <img src="${product.image}" alt="${product.name}">
        </div>
        <div class="product_name">
            <h2>${product.name}</h2>
            <h3>${currencySymbol}${price}</h3> <!-- Dynamic currency symbol here -->
        </div>
        <div class="remove-btn" data-product-id="${product.id}"><img src="/wp-content/uploads/2024/09/cross.png"></div>
    `;
    cartItemsContainer.appendChild(cartItem);

    // Add event listener for removing product
    const removeButton = cartItem.querySelector('.remove-btn');
    removeButton.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        removeCartItem(productId);
    });

    updateTotalAmount();
}

function removeCartItem(productId) {
    cartItems = cartItems.filter(item => item.id != productId);
    updateCart();
    updateCartCounter();
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    removeFromWooCommerceCart(productId);
}

function removeFromWooCommerceCart(productId) {
    const data = {
        action: 'remove_from_cart',
        product_id: productId,
    };

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(data),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(responseData => {
            console.log('Product removed from WooCommerce cart:', responseData);
        })
        .catch(error => {
            console.error('Error removing product from WooCommerce cart:', error);
        });
}

function updateTotalAmount() {
    const totalAmount = cartItems.reduce((total, item) => total + parseFloat(item.price), 0);
    totalAmountElement.textContent = `${currencySymbol}${totalAmount.toFixed(2)}`;
}

function updateCartCounter() {
    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = cartItems.length;
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/wp-admin/admin-ajax.php?action=get_all_products_and_currency')
        .then(response => response.json())
        .then(data => {
            products = data.products;
            currencySymbol = data.currency_symbol;
            localStorage.setItem('currencySymbol', currencySymbol);
        })
        .catch(error => console.error('Error fetching products and currency:', error));
    getCartProducts()
    /** Initiate cart UI from local Storage if any */
    const localCartStorage = localStorage.getItem('cartItems')
    if (localCartStorage) {
        currencySymbol = localStorage.getItem('currencySymbol') ? localStorage.getItem('currencySymbol'):'AED ';
        cartItems = JSON.parse(localCartStorage)
        updateCart()
        updateCartCounter()
    }
    /** Initiate cart UI from local Storage end */


    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const isProductInCart = cartItems.some(item => item.id == productId);

            if (!isProductInCart) {
                const product = products.find(p => p.id == productId);
                cartItems.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image
                });
                addToCartUI(product);
                updateCartCounter();
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                addToWooCommerceCart(productId);
            }
        });
    });
});
window.addEventListener('pageshow', function () {
    const localCartStorage2 = localStorage.getItem('cartItems')
    if (localCartStorage2) {
        currencySymbol = localStorage.getItem('currencySymbol') ? localStorage.getItem('currencySymbol'):'AED ';
        cartItems = JSON.parse(localCartStorage2)
        updateCart()
        updateCartCounter()
    }
})
