const productList = document.getElementById('product-list');

fetch('api/get_products.php')
    .then(response => response.json())
    .then(products => {
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'product';

            productDiv.innerHTML = `
                <img src="uploads/${product.image}" alt="${product.name}" width="100">
                <div>
                    <h3>${product.name}</h3>
                    <p>Harga: Rp ${product.price.toLocaleString()}</p>
                    <button onclick="addToCart(${product.id}, '${product.name}', ${product.price})">Beli</button>
                </div>
            `;

            productList.appendChild(productDiv);
        });
    });

function addToCart(id, name, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItem = cart.find(item => item.id === id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Produk ditambahkan ke keranjang!');
}
