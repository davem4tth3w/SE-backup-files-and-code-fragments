<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Point of Sale (POS)</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .card {
        margin-top: 20px;
    }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center mt-5">Point of Sale (POS)</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                            <!-- Product list will be displayed here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cart</h5>
                    <ul class="list-group" id="cart-items">
                        <!-- Cart items will be displayed here -->
                    </ul>
                    <hr>
                    <h5>Total Amount: <span id="total-amount">0</span></h5>
                    <button class="btn btn-primary btn-block mt-3" id="checkout-btn">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding products -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product to Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-product-form">
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price</label>
                        <input type="number" class="form-control" id="productPrice" required>
                    </div>
                    <div class="form-group">
                        <label for="productQuantity">Quantity</label>
                        <input type="number" class="form-control" id="productQuantity" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    // Array to store cart items
    let cartItems = [];

    // Add product modal form submission
    $('#add-product-form').submit(function(event){
        event.preventDefault();
        let productName = $('#productName').val();
        let productPrice = parseFloat($('#productPrice').val());
        let productQuantity = parseInt($('#productQuantity').val());
        
        if(productName && !isNaN(productPrice) && !isNaN(productQuantity) && productQuantity > 0){
            let cartItem = {name: productName, price: productPrice, quantity: productQuantity};
            cartItems.push(cartItem);
            displayCartItems();
            $('#addProductModal').modal('hide');
        } else {
            alert('Please enter valid product details.');
        }
    });

    // Display cart items
    function displayCartItems(){
        let cartHtml = '';
        let totalAmount = 0;
        cartItems.forEach(function(item, index){
            cartHtml += `<li class="list-group-item">${item.name} - ${item.price} x ${item.quantity}
                            <button type="button" class="btn btn-sm btn-danger float-right delete-item" data-index="${index}">Remove</button>
                        </li>`;
            totalAmount += item.price * item.quantity;
        });
        $('#cart-items').html(cartHtml);
        $('#total-amount').text(totalAmount.toFixed(2));
    }

    // Delete item from cart
    $(document).on('click', '.delete-item', function(){
        let index = $(this).data('index');
        cartItems.splice(index, 1);
        displayCartItems();
    });

    // Checkout button click event
    $('#checkout-btn').click(function(){
        if(cartItems.length > 0){
            // Perform checkout operation (e.g., send data to server, clear cart, etc.)
            alert('Checkout successful!');
            cartItems = [];
            displayCartItems();
        } else {
            alert('No items in cart. Please add some products.');
        }
    });

    // Open add product modal
    $('#add-product-btn').click(function(){
        $('#addProductModal').modal('show');
    });
});
</script>
</body>
</html>
