<?php
//pos_system.php

include('database_connection.php');
include('function.php');

if (!isset($_SESSION['type'])) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Point of Sale (POS)</title>

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

</body>
</html>