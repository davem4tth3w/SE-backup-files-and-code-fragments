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
    <title>POS</title>
    <script src="js/jqueryv3.6.0.js"></script>
<link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/dataTables.bootstrap5.min.css">
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/jquery.dataTables.min.js"></script>
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/dataTables.bootstrap5.min.js"></script>
<!-- bootstrap-5.3.2 end -->

    <link rel="stylesheet" href="bootstrap_v5/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <script src="bootstrap_v5/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/pages_stylesheet/pos.css">
</head>

<body>
    <div class="content-container">
        <div class="d-flex flex-column h-100">
            <div class="w-100 d-flex justify-content-between" id="pos-header">
                <h3>POS</h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-6" style="text-align: right;">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-sm">Add</button>
                        </div>
                        
    <div class="modal fade" id="orderModal">
        <div class="modal-dialog">
            <form method="post" id="order_form">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Create Order</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Receiver Name</label>
                                    <input type="text" name="inventory_order_name" id="inventory_order_name" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="inventory_order_date" id="inventory_order_date" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Enter Receiver Address</label>
                            <textarea name="inventory_order_address" id="inventory_order_address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">


    <label>Enter Product Details</label>
    <hr />
    <div id="product_search_wrapper">
	<input type="text" id="product_search" class="form-control" placeholder="Search product...">
        <span id="span_product_details"></span>
    </div>
    <hr />
</div>

<!-- VAT CODE START -->
<div class="form-group">
    <label>Enter VAT%</label>
    <input type="text" name="vat_percentage" id="vat_percentage" class="form-control" />
</div>
<div class="form-group">
    <label>Enter Discount</label>
    <input type="text" name="discount" id="discount" class="form-control" />
</div>
<!-- VAT CODE END -->

                        <div class="form-group">
                            <label>Select Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="inventory_order_id" id="inventory_order_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>



<script type="text/javascript">
    
        $(document).ready(function () {
            $('#inventory_order_date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
        });
    
    
					$(document).ready(function(){

						var orderdataTable = $('#order_data').DataTable({
							"processing":true,
							"serverSide":true,
							"order":[],
							"ajax":{
								url:"order_fetch.php",
								type:"POST"
							},
							<?php
							if($_SESSION["type"] == 'admin')
							{
							?>
							"columnDefs":[
								{
									"targets":[4, 5, 6, 7, 8, 9, 10],
									"orderable":false,
								},
							],
							<?php
							}
							else
							{
							?>
							"columnDefs":[
								{
									"targets":[4, 5, 6, 7, 8],
									"orderable":false,
								},
							],
							<?php
							}
							?>
							"pageLength": 10
						});

						$('#add_button').click(function(){
							$('#orderModal').modal('show');
							$('#order_form')[0].reset();
							$('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
							$('#action').val('Add');
							$('#btn_action').val('Add');
							$('#span_product_details').html('');
							add_product_row();
						});

						function add_product_row(count = '')
						{
							var html = '';
							html += '<span id="row'+count+'"><div class="row">';
							html += '<div class="col-md-8">';
							html += '<select name="product_id[]" id="product_id'+count+'" class="form-control selectpicker" data-live-search="true" required>';
							html += '<?php echo fill_product_list($connect); ?>';
							html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'+count+'" />';
							html += '</div>';
							html += '<div class="col-md-3">';
							html += '<input type="text" name="quantity[]" class="form-control" required />';
							html += '</div>';
							html += '<div class="col-md-1">';
							if(count == '')
							{
								html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
							}
							else
							{
								html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
							}
							html += '</div>';
							html += '</div></div><br /></span>';
							$('#span_product_details').append(html);

							$('.selectpicker').selectpicker();
						}

						var count = 0;

						$(document).on('click', '#add_more', function(){
							count = count + 1;
							add_product_row(count);
						});
						$(document).on('click', '.remove', function(){
							var row_no = $(this).attr("id");
							$('#row'+row_no).remove();
						});


						$(document).on('submit', '#order_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled', 'disabled');
    var form_data = $(this).serialize();
    $.ajax({
        url:"order_action.php",
        method:"POST",
        data:form_data,
        success:function(data){
            $('#order_form')[0].reset();
            $('#orderModal').modal('hide');
            $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
            $('#action').attr('disabled', false);
            orderdataTable.ajax.reload();
        }
    });
});


						$(document).on('click', '.update', function(){
							var inventory_order_id = $(this).attr("id");
							var btn_action = 'fetch_single';
							$.ajax({
								url:"order_action.php",
								method:"POST",
								data:{inventory_order_id:inventory_order_id, btn_action:btn_action},
								dataType:"json",
								success:function(data)
								{
									$('#orderModal').modal('show');
									$('#inventory_order_name').val(data.inventory_order_name);
									$('#inventory_order_date').val(data.inventory_order_date);
									$('#inventory_order_address').val(data.inventory_order_address);
									$('#span_product_details').html(data.product_details);
									$('#payment_status').val(data.payment_status);
									$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Order");
									$('#inventory_order_id').val(inventory_order_id);
									$('#action').val('Edit');
									$('#btn_action').val('Edit');
								}
							})
						});

						//orginalcode start

						$(document).on('click', '.status', function(){
							var inventory_order_id = $(this).attr("id");
							var status = $(this).data("status");
							var btn_action = "status";
							if(confirm("Are you sure you want to change status?"))
							{
								$.ajax({
									url:"order_action.php",
									method:"POST",
									data:{inventory_order_id:inventory_order_id, status:status, btn_action:btn_action},
									success:function(data)
									{
										$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
										orderdataTable.ajax.reload();
									}
								})
							}
							else
							{
								return false;
							}
						});

						//orginalcode end

					

					});


                    $(document).on('click', '.delete', function(){
            var inventory_order_id = $(this).attr("id");

            var btn_action = 'delete';
            if(confirm("Are you sure you want to delete this order?"))
            {
                $.ajax({
                    url:"order_action.php",
                    method:"POST",
                    data:{inventory_order_id:inventory_order_id, btn_action:btn_action},
                    success:function(data){
                        $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                        orderdataTable.ajax.reload();
                    }
                });
            }
            else
            {
                return false;
            }
        });


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