AOS.init({
 
  offset: 120,
  delay: 0, 
  duration: 900,
  easing: 'ease', 
  once: false,
  mirror: false, 
  anchorPlacement: 'top-bottom', 

});

// Fungsi untuk mengurangi jumlah
function decrementQuantity(productId) {
  var quantityInput = document.getElementById('quantity-' + productId);
  var currentQuantity = parseInt(quantityInput.value);
  if (currentQuantity > 1) {
      quantityInput.value = currentQuantity - 1;
  }
}

// Fungsi untuk menambah jumlah
function incrementQuantity(productId) {
  var quantityInput = document.getElementById('quantity-' + productId);
  var currentQuantity = parseInt(quantityInput.value);
  quantityInput.value = currentQuantity + 1;
}

