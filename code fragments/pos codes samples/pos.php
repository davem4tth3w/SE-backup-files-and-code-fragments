<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS</title>
    <!-- bootstrap-5.3.2 start FOLDER LINKS-->
    <script src="js/jqueryv3.6.0.js"></script>
    <link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
    <script src="bootstrap_v5/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/dataTables.bootstrap5.min.css">
    <script src="bootstrap_v5/bootstrap-5.3.2-dist/js/jquery.dataTables.min.js"></script>
    <script src="bootstrap_v5/bootstrap-5.3.2-dist/js/dataTables.bootstrap5.min.js"></script>
    <!-- bootstrap-5.3.2 end -->

    <link rel="stylesheet" href="bootstrap_v5/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <script src="bootstrap_v5/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Original CSS files or styles can be included here -->
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>

<div class="container-fluid">
    <h1 class="text-center mb-4">Point of Sale</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" id="search-product" class="form-control" placeholder="Search product...">
                <button class="btn btn-primary" id="search-btn">Search</button>
            </div>
            <div id="product-list"></div>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered" id="pos-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Subtotal:</td>
                        <td><span id="subtotal">0.00</span></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Total:</td>
                        <td><span id="total">0.00</span></td>
                    </tr>
                </tfoot>
            </table>
            <button class="btn btn-success btn-block" id="save-order">Save Order</button>
        </div>
    </div>
</div>

<!-- Original JavaScript files or scripts can be included here -->
<script>
$(document).ready(function() {
    // Function to fetch products from the server
    function fetchProducts() {
        $.getJSON('path/to/your/product_fetch.php', function(data) {
            let html = '';
            data.forEach(product => {
                html += `<div class="product-item" data-id="${product.id}">
                <h4>${product.name}</h4>
                            <p>${product.description}</p>
                            <button class="btn btn-primary add-to-cart" data-id="${product.id}">Add to Cart</button>
                         </div>`;
            });
            $('#product-list').html(html);
        });
    }

    // Function to add a product to the cart
    function addToCart(productId) {
        // Fetch the product details from the server using AJAX
        $.getJSON('path/to/your/product_action.php', { btn_action: 'fetch_single', product_id: productId }, function(data) {
            let row = `<tr>
                            <td>${data.product_name}</td>
                            <td><input type="number" class="form-control quantity" value="1" data-id="${productId}"></td>
                            <td>${data.product_unit}</td>
                            <td>${data.product_base_price}</td>
                            <td><span class="total">${data.product_base_price}</span></td>
                            <td><button class="btn btn-danger remove-product" data-id="${productId}"><i class="fas fa-trash"></i></button></td>
                       </tr>`;
            $('#pos-table tbody').append(row);
            calculateTotals();
        });
    }

    // Function to remove a product from the cart
    function removeProduct(productId) {
        $('tr[data-id="' + productId + '"]').remove();
        calculateTotals();
    }

    // Function to calculate subtotal and total
    function calculateTotals() {
        let subtotal = 0;
        $('#pos-table tbody tr').each(function() {
            let quantity = $(this).find('.quantity').val();
            let price = $(this).find('.price').text();
            let total = quantity * price;
            $(this).find('.total').text(total.toFixed(2));
            subtotal += total;
       });
        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(subtotal.toFixed(2));
    }

    // Event listeners
    $(document).on('click', '.add-to-cart', function() {
        let productId = $(this).data('id');
        addToCart(productId);
    });

    $(document).on('change', '.quantity', function() {
        let productId = $(this).data('id');
        let quantity = $(this).val();
        let row = $(this).closest('tr');
        let price = row.find('.price').text();
        let total = quantity * price;
        row.find('.total').text(total.toFixed(2));
        calculateTotals();
    });

    $(document).on('click', '.remove-product', function() {
        let productId = $(this).data('id');
        removeProduct(productId);
    });

    $('#search-btn').click(function() {
        // Perform search logic here
    });

    $('#save-order').click(function() {
        // Save order logic here
    });

    // Fetch products when the page loads
    fetchProducts();
});
</script>

</body>
</html>