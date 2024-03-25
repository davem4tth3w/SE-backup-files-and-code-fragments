<?php

//order_action.php

include('database_connection.php');

include('function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO inventory_order (user_id, inventory_order_total, inventory_order_date, inventory_order_name, inventory_order_address, payment_status, inventory_order_status, inventory_order_created_date) 
		VALUES (:user_id, :inventory_order_total, :inventory_order_date, :inventory_order_name, :inventory_order_address, :payment_status, :inventory_order_status, :inventory_order_created_date)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':inventory_order_total'		=>	0,
				':inventory_order_date'			=>	$_POST['inventory_order_date'],
				':inventory_order_name'			=>	$_POST['inventory_order_name'],
				':inventory_order_address'		=>	$_POST['inventory_order_address'],
				':payment_status'				=>	$_POST['payment_status'],
				':inventory_order_status'		=>	'paid',
				':inventory_order_created_date'	=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$inventory_order_id = $statement->fetchColumn();

		if(isset($inventory_order_id))
		{

			$total_amount = 0;
			for($count = 0; $count < count($_POST["product_id"]); $count++)
			{
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
				INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price) VALUES (:inventory_order_id, :product_id, :quantity, :price)
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':inventory_order_id'	=>	$inventory_order_id,
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>	$product_details['price'],
						
					)
				);

		$base_price = $product_details['price'] * $_POST["quantity"][$count];
		$vat_percentage = isset($_POST['vat_percentage']) ? $_POST['vat_percentage'] : 0;
		$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;

		$discount_amount = ($base_price * $discount) / 100;
		$price_after_discount = $base_price - $discount_amount;
		$vat_amount = ($price_after_discount * $vat_percentage) / 100;
		$total_amount += $price_after_discount + $vat_amount;

			}
			$update_query = "
			UPDATE inventory_order 
			SET inventory_order_total = '".$total_amount."' 
			WHERE inventory_order_id = '".$inventory_order_id."'
			";
			$statement = $connect->prepare($update_query);
			$statement->execute();
			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'Order Created...';
				echo '<br />';
				echo $total_amount;
				echo '<br />';
				echo $inventory_order_id;
			}


			$update_query = "
            UPDATE inventory_order 
            SET vat_percentage = :vat_percentage, 
                discount = :discount 
            WHERE inventory_order_id = :inventory_order_id
        ";
        $statement = $connect->prepare($update_query);
        $statement->execute(array(
            ':vat_percentage' => $vat_percentage,
            ':discount' => $discount,
            ':inventory_order_id' => $inventory_order_id // Make sure you have $inventory_order_id available
        ));

		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM inventory_order WHERE inventory_order_id = :inventory_order_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':inventory_order_id'	=>	$_POST["inventory_order_id"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach($result as $row)
		{
			$output['inventory_order_name'] = $row['inventory_order_name'];
			$output['inventory_order_date'] = $row['inventory_order_date'];
			$output['inventory_order_address'] = $row['inventory_order_address'];
			$output['payment_status'] = $row['payment_status'];
		}
		$sub_query = "
		SELECT * FROM inventory_order_product 
		WHERE inventory_order_id = '".$_POST["inventory_order_id"]."'
		";
		$statement = $connect->prepare($sub_query);
		$statement->execute();
		$sub_result = $statement->fetchAll();
		$product_details = '';
		$count = '';
		foreach($sub_result as $sub_row)
		{
			$product_details .= '
			<script>
			$(document).ready(function(){
				$("#product_id'.$count.'").selectpicker("val", '.$sub_row["product_id"].');
				$(".selectpicker").selectpicker();
			});
			</script>
			<span id="row'.$count.'">
				<div class="row">
					<div class="col-md-8">
						<select name="product_id[]" id="product_id'.$count.'" class="form-control selectpicker" data-live-search="true" required>
							'.fill_product_list($connect).'
						</select>
						<input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'" />
					</div>
					<div class="col-md-3">
						<input type="text" name="quantity[]" class="form-control" value="'.$sub_row["quantity"].'" required />
					</div>
					<div class="col-md-1">
			';

			if($count == '')
			{
				$product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				$product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
			}
			$product_details .= '
						</div>
					</div>
				</div><br />
			</span>
			';
			$count = $count + 1;
		}
		$output['product_details'] = $product_details;
		echo json_encode($output);
	}
	// Original code
	if($_POST['btn_action'] == 'Edit')
	{
		$delete_query = "
		DELETE FROM inventory_order_product 
		WHERE inventory_order_id = '".$_POST["inventory_order_id"]."'
		";
		$statement = $connect->prepare($delete_query);
		$statement->execute();
		$delete_result = $statement->fetchAll();
		if(isset($delete_result))
		{
			$total_amount = 0;

			// Original code
			// for($count = 0; $count < count($_POST["product_id"]); $count++)
			for($count = 0; $count < count($_POST["inventory_order_id"]); $count++)
			{
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
				INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price) VALUES (:inventory_order_id, :product_id, :quantity, :price)
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':inventory_order_id'	=>	$_POST["inventory_order_id"],
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>	$product_details['price'],
						
					)
				);
				$base_price = $product_details['price'] * $_POST["quantity"][$count];

				$total_amount = $total_amount + $base_price;
			}
			$update_query = "
			UPDATE inventory_order 

			SET inventory_order_name = :inventory_order_name, 
			inventory_order_date = :inventory_order_date, 
			inventory_order_address = :inventory_order_address, 
			inventory_order_total = :inventory_order_total, 
			payment_status = :payment_status

			WHERE inventory_order_id = :inventory_order_id
			";
			$statement = $connect->prepare($update_query);
			$statement->execute(
				array(
					':inventory_order_name'			=>	$_POST["inventory_order_name"],
					':inventory_order_date'			=>	$_POST["inventory_order_date"],
					':inventory_order_address'		=>	$_POST["inventory_order_address"],
					':inventory_order_total'		=>	$total_amount,
					':payment_status'				=>	$_POST["payment_status"],
					':inventory_order_id'			=>	$_POST["inventory_order_id"]
				)
			);

			//VAT CODE START
			$update_query = "
    UPDATE inventory_order 
    SET inventory_order_total = :inventory_order_total 
    WHERE inventory_order_id = :inventory_order_id
    ";
    $statement = $connect->prepare($update_query);
    $statement->execute(
        array(
            ':inventory_order_total'    =>  $total_amount,
            ':inventory_order_id'       =>  $inventory_order_id
        )
    );
		//VAT CODE END


			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'Order Edited...';
			}
		}
	}

	//ORIGINAL CODE START


	if($_POST['btn_action'] == 'status')
	{
		$status = 'paid';
		if($_POST['status'] == 'paid')
		{
			$status = 'partial payment';
		}

		$query = "
		UPDATE inventory_order 
		SET inventory_order_status = :inventory_order_status 
		WHERE inventory_order_id = :inventory_order_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':inventory_order_status'	=>	$status,
				':inventory_order_id'		=>	$_POST["inventory_order_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Order status change to ' . $status;
		}
	}

	//ORIGINAL CODE END

	if($_POST['btn_action'] == 'delete')
	{
		$query = "
		DELETE FROM inventory_order 
		WHERE inventory_order_id = :inventory_order_id
		";
		
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':inventory_order_id'		=>	$_POST["inventory_order_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Order deleted';
		}
	}
}

?>