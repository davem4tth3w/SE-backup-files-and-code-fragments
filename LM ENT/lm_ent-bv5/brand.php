<?php
//brand.php
include('database_connection.php');

include('function.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

if($_SESSION['type'] != 'admin')
{
	header('location:index.php');
}

include('sidebar.php');

?>

<style>
    <?php include"css/pages_stylesheet/brand.css"?>
</style>


<!-- bootstrap-5.3.2 start FOLDER LINKS-->
<script src="js/jqueryv3.6.0.js"></script>
<link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="bootstrap_v5/bootstrap-5.3.2-dist/css/dataTables.bootstrap5.min.css">
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/jquery.dataTables.min.js"></script>
<script src="bootstrap_v5/bootstrap-5.3.2-dist/js/dataTables.bootstrap5.min.js"></script>
<!-- bootstrap-5.3.2 end -->


<div class="content-container">


<span id="alert_action"></span>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-10">
						<h3 class="card-title">Brand List</h3>
					</div>
					<div class="col-md-2" style="text-align: right;">
						<button type="button" name="add" id="add_button" class="btn btn-success btn-sm">Add</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table id="brand_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>Brand Name</th>
							<th>Status</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="brandModal">
	<div class="modal-dialog">
		<form method="post" id="brand_form">
			<div class="modal-content">
				<div class="modal-header">
	
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<select name="category_id" id="category_id" class="form-control" required>
							<option value="">Select Category</option>
							<?php echo fill_category_list($connect); ?>
						</select>
					</div>
					<div class="form-group">
						<label>Enter Brand Name</label>
						<input type="text" name="brand_name" id="brand_name" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="brand_id" id="brand_id" />
					<input type="hidden" name="btn_action" id="btn_action" />
					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function () {

		$('#add_button').click(function () {
			$('#brandModal').modal('show');
			$('#brand_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Brand");
			$('#action').val('Add');
			$('#btn_action').val('Add');
		});

		$(document).on('submit', '#brand_form', function (event) {
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url: "brand_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#brand_form')[0].reset();
					$('#brandModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
					$('#action').attr('disabled', false);
					branddataTable.ajax.reload();
				}
			})
		});

		$(document).on('click', '.update', function () {
			var brand_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url: 'brand_action.php',
				method: "POST",
				data: { brand_id: brand_id, btn_action: btn_action },
				dataType: "json",
				success: function (data) {
					$('#brandModal').modal('show');
					$('#category_id').val(data.category_id);
					$('#brand_name').val(data.brand_name);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Brand");
					$('#brand_id').val(brand_id);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');
				}
			})
		});

		$(document).on('click', '.delete', function () {
			var brand_id = $(this).attr("id");
			var status = $(this).data('status');
			var btn_action = 'delete';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "brand_action.php",
					method: "POST",
					data: { brand_id: brand_id, status: status, btn_action: btn_action },
					success: function (data) {
						$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
						branddataTable.ajax.reload();
					}
				})
			} else {
				return false;
			}
		});


		var branddataTable = $('#brand_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "brand_fetch.php",
				type: "POST"
			},
			"columnDefs": [
				{
					"targets": [4, 5],
					"orderable": false,
				},
			],
			"pageLength": 10
		});

	});
</script>


<?php
include('footer.php');
?>


</div>
