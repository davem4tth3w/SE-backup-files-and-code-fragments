<?php
//pos.php

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
    <title>POS</title>

    <!-- Bootstrap CSS -->
    <link href="bootstrap_v5/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="DataTables/DataTables-1.13.8/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/pages_stylesheet/pos.css">


</head>

<body>
    <div class="content-container">
        <div class="d-flex flex-column h-100">
            <div class="w-100 d-flex justify-content-between" id="pos-header">
                <h3>POS</h3>
            </div>
            <form action="" id="pos-form" class="h-100 flex-grow-1">
                <div class="card border-dark h-100">
                    <div class="card-body d-flex h-100 py-0 px-0">
                        <div class="col-8 d-flex flex-column p-2">
                            <div class="d-flex align-items-center mb-1">
                                <label for="customer_name" class="col-form-label col-3 me-2">Customer Name</label>
                                <input type="text" name="inventory_order_name" id="inventory_order_name" class="form-control" required />
                            </div>
                         
                            <div class="d-flex align-items-center">
                                <label for="product_name" class="col-form-label col-3 me-2">Product Name</label>
                                <div id="product_search_wrapper">
                                    <input type="text" id="product_search" class="form-control" placeholder="Search product...">
                                        <span id="span_product_details"></span>
                                    </div>
                            </div>
                            <div class="flex-grow-1 bg-dark bg-gradient bg-opacity-25 mt-4">
                                <table class="table table-hover table-striped table-bordered" id="item-list">
                                    <thead>
                                        <tr class="bg-dark bg-gradient text-light">
                                            <th>QTY</th>
                                            <th>Unit</th>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-4 bg-dark d-flex flex-column bg-gradient h-100 p-2">
                            <div class="w-100">
                                <fieldset class="border border-light">
                                    <legend class="text-light fs-5">Keyboard Shortcuts</legend>
                                    <label for="" class="fs-6">Ctrl + F1 = Focuses the Product Code Text Field.</label>
                                    <label for="" class="fs-6">Ctrl + F2 = Focuses the Discount % Text Field.</label>
                                    <label for="" class="fs-6">Ctrl + F3 = Tender Amount.</label>
                                </fieldset>
                            </div>
                            <div class="w-100 computaion-pane">
                                <div class="w-100 d-flex align-items-end">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <div class="col-3 text-light">SubTotal</div>
                                            <div class="col-9 text-end bg-light px-1" id="sub_total">0.00</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-3 text-light">VAT %</div>
                                            <div class="col-9 text-end bg-light px-1" contenteditable id="disc_perc">0</div>
                                            <input type="hidden" name="disc_perc" value="0">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-3 text-light">Discount %</div>
                                            <div class="col-9 text-end bg-light px-1" contenteditable id="disc_perc">0</div>
                                            <input type="hidden" name="disc_perc" value="0">
                                        </div>
                                   
                                    </div>
                                </div>
                            </div>
                            <div class="pt-5">
                                <h3 class="text-light">Grand Total</h3>
                                <div class="bg-light text-end" id="grand-total" style="height:10vh;font-size:3rem">0.00</div>
                                <input type="hidden" name="total" value="0">
                                <input type="hidden" name="amount_tendered" value="0">
                                <input type="hidden" name="amount_change" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="bootstrap_v5/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="js/jqueryv3.6.0.js"></script>

    <!-- DataTables -->
    <script src="DataTables/datatables.min.js"></script>

    <!-- Your Custom Script -->
    <script src="js/your_custom_script.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        // Function to toggle search box visibility
        $('#span_product_details').on('click', function() {
            $('#product_search').toggle();
        });

        // Function to filter dropdown options based on search input
        $('#product_search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#span_product_details select option').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    
</script>

