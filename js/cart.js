const cartItemsDiv = document.getElementById('cart-items');
const totalPriceSpan = document.getElementById('total-price');

let cart = JSON.parse(localStorage.getItem('cart')) || [];

function renderCart() {
    cartItemsDiv.innerHTML = '';
    let totalPrice = 0;

    cart.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';

        totalPrice += item.price * item.quantity;

        itemDiv.innerHTML = `
            <img src="uploads/${item.image || 'default.png'}" alt="${item.name}" width="50">
            <div>
                <h3>${item.name}</h3>
                <p>Rp ${item.price.toLocaleString()} x ${item.quantity}</p>
                <button onclick="removeItem(${index})">Hapus</button>
            </div>
        `;

        cartItemsDiv.appendChild(itemDiv);
    });

    totalPriceSpan.innerText = `Rp ${totalPrice.toLocaleString()}`;
}

function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

function checkout() {
    const name = prompt('Nama Anda:');
    const phone = prompt('Nomor HP:');
    const address = prompt('Alamat Pengiriman:');

    fetch('api/save_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, phone, address, cart, total_price: cart.reduce((sum, item) => sum + item.price * item.quantity, 0) }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pesanan berhasil dibuat!');
                localStorage.removeItem('cart');
                renderCart();
            } else {
                alert('Gagal membuat pesanan!');
            }
        });
}

renderCart();
