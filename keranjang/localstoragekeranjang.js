function addToCart(productName) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(productName);
    localStorage.setItem('cart', JSON.stringify(cart));
    
    alert(`${productName} berhasil ditambahkan ke keranjang!`);
}