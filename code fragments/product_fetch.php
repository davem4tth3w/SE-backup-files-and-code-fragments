<?php

//product_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM product 
INNER JOIN brand ON brand.brand_id = product.brand_id
INNER JOIN category ON category.category_id = product.category_id 
INNER JOIN unit ON unit.unit_id = product.unit_id 
INNER JOIN user_details ON user_details.user_id = product.product_enter_by 

";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE brand.brand_name LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR category.category_name LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR product.product_name LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR product.product_quantity LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR unit.unit_name LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	
	$query .= 'OR product.product_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY product_id DESC ';
}


if(isset($_POST['length']) && isset($_POST['start']) && $_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row)

{
	$status = '';
	if($row['product_status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['product_id'];
	$sub_array[] = $row['category_name'];
	$sub_array[] = $row['brand_name'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = available_product_quantity($connect, $row["product_id"]);
	$sub_array[] = $row['unit_name'];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $status;

	// new column start
	$sub_array[] = $row['product_base_price'];
	// new column end

	$sub_array[] = '<button type="button" name="view " id="'.$row["product_id"].'" class="btn btn-info btn-xs view"><i class="fa-solid fa-eye"></i></button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["product_id"].'" class="btn btn-warning btn-xs update"><i class="fa-solid fa-pen-to-square"></i></button>';
	$sub_array[] = '<button type="button" name="status" id="'.$row["product_id"].'" class="btn btn-success btn-xs status" data-status="'.$row["product_status"].'">Status</button>';

	$sub_array[] = '<button type="button" name="delete" id="'.$row["product_id"].'" class="btn btn-danger btn-xs delete" data-delete="'.$row["product_id"].'"><i class="fa-solid fa-trash"></i></button>';
	
	
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM product');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"    			=> 	isset($_POST["draw"]) ? intval($_POST["draw"]) : 0,
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);

echo json_encode($output);

?>
