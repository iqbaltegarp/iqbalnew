// Admin logic for dynamically updating orders, products, etc.
fetch('../api/get_orders.php')
    .then(response => response.json())
    .then(orders => {
        const orderList = document.getElementById('order-list');
        orders.forEach(order => {
            const orderDiv = document.createElement('div');
            orderDiv.className = 'order';

            orderDiv.innerHTML = `
                <h3>${order.name} (${order.phone})</h3>
                <p>${order.address}</p>
                <p>Total: Rp ${order.total_price.toLocaleString()}</p>
                <ul>
                    ${order.cart.map(item => `<li>${item.name} x ${item.quantity}</li>`).join('')}
                </ul>
            `;
            orderList.appendChild(orderDiv);
        });
    });
