// Tăng giảm sản phẩm
function increment() {
  console.log("Increment is called");
  var quantityInput = document.getElementById("quantity");
  var currentQuantity = parseInt(quantityInput.value, 10);
  quantityInput.value = currentQuantity + 1;
}

function decrement() {
  console.log("Decrement is called");
  var quantityInput = document.getElementById("quantity");
  var currentQuantity = parseInt(quantityInput.value, 10);

  // Giảm số lượng chỉ khi nó lớn hơn 1
  if (currentQuantity > 1) {
    quantityInput.value = currentQuantity - 1;
  }
}
