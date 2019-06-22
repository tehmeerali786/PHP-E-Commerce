<?php

 require_once("config.php"); 

	// helper functions


	function last_id() {

		global $connection;

		return mysqli_insert_id($connection);

	}


	function set_message($msg) {


		if(!empty($msg)) {

			$_SESSION['message'] = $msg;

		} else {

			$msg = "";
		}


	}

	function display_message() {

		if(isset($_SESSION['message'])) {

			echo $_SESSION['message'];
			unset($_SESSION['message']);

		}
	}


	function redirect($location) {

		header("Location: $location");
	}


	function query($sql) {

		global $connection;

		return mysqli_query($connection, $sql);

	}

	function confirm($result) {


		global $connection;

		if(!$result) {

			die("QUERY FAILED" . mysqli_error($connection));
		} 

	}

	function escape_string($string) {


		global $connection;

		return mysqli_real_escape_string($connection, $string);
	}

	function fetch_array($result) {

		return mysqli_fetch_array($result);


	}


	/******************************* FRONT END FUNCTIONS  **************************************/

	// get products

	function get_products() {


		$query =  query(" SELECT * FROM products");

		confirm($query);

		while($row = fetch_array($query)) {


		$product = 

		 '<div class="col-sm-4 col-lg-4 col-md-4">
                   <div class="thumbnail">
                   <a href="item.php?id='. $row['product_id'] .' ">  <img src="' . $row['product_image'] .  '" alt=""> </a>
                   <div class="caption">
                   <h4 class="pull-right">&#36;' . $row['product_price'] . '</h4>
                   <h4><a href="item.php?id='  . $row['product_id'] .'">' . $row['product_title'] . '</a>
                   </h4>
                   <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                   <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add='. $row['product_id'] .' ">Add to cart</a>
                   </div>
                       
                   </div>
                   </div>';


                   echo $product;
                   


			


			
		}


	}


	function get_categories() {



		$query = query("SELECT * FROM categories");
        
        confirm($query);



                	while($row = fetch_array($query)) {

$category = <<<DELIMETER
<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>







DELIMETER;

echo $category;

                	}

	}


function get_category() {

	$id = $_GET['id'];

	$query = query("SELECT * FROM products WHERE product_category_id=" . escape_string($id) . " ") ;

	while ($row = fetch_array($query)) {


$cat_print = <<<DELIMETER1





<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}">  <img src="{$row['product_image']}" alt=""> </a>
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>












DELIMETER1;


echo $cat_print;
	}



}


function get_products_in_shope_page() {

	

	$query = query("SELECT * FROM products") ;

	while ($row = fetch_array($query)) {


$cat_print = <<<DELIMETER1





<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}">  <img src="{$row['product_image']}" alt=""> </a>
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>












DELIMETER1;


echo $cat_print;
	}



}




function login_user() {


	if(isset($_POST['submit'])) {


		$username = escape_string($_POST['username']);
		$password = escape_string($_POST['password']);


		$query = query("SELECT * FROM users WHERE username= '{$username}' AND password = '{$password}'");

		confirm($query);

		if (mysqli_num_rows($query) == 0) {

			set_message("Your Password or Username is Wrong!");
			redirect("login.php");


		} else {


			$_SESSION['username'] = $username;

			
			redirect("admin");
		}
	}


	
}

function send_message() {

	if(isset($_POST['submit'])) {

		$to         = "freelanceali786@gmail.com";
		$from_name  = $_POST['name'];
		$subject    = $_POST['subject'];
		$email      = $_POST['email'];
		$message    = $_POST['message'];


		$headers = "From: Tehmeer Ali Paryani ";

		$result = mail($to, $subject, $message);

		if(!$result) {

			echo "ERROR";
		} else {


			echo "SENT";
		}

	}


}


/******************************* BACK END FUNCTIONS  **************************************/



function display_orders() {


	$query = query("SELECT * FROM orders");
	confirm($query);

	while($row = fetch_array($query)) {

		$orders = <<<DELIMETER4




		<tr>

				<td>{$row['order_id']}</td>
				<td>{$row['order_amount']}</td>
				<td>{$row['order_transaction']}</td>
				<td>{$row['order_currency']}</td>
				<td>{$row['order_status']}</td>
				<td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove" ></span></a></td>




		</tr>




DELIMETER4;

echo $orders;

	}

}


/********************************************** Admin Products   ***********************************************************/


function get_products_in_admin() {


		$query =  query(" SELECT * FROM products");

		confirm($query);

		while($row = fetch_array($query)) {


		$product = <<<DELIMETER







						<tr>
							<td>{$row['product_id']}</td>
							<td>{$row['product_title']}<br>
							<a href="index.php?edit_product&id={$row['product_id']}" ><img src="{$row['product_image']}" alt=""></a>
							</td>
							<td>{$row['product_category_id']}</td>
							<td>{$row['product_price']}</td>
							<td>{$row['product_quantity']}</td>
							<td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove" ></span></a></td>
						</tr>
      

















DELIMETER;


                   echo $product;
                   


			


			
		}




}





function add_product() {



	if(isset($_POST['publish'])) {


		$product_title = escape_string($_POST['product_title']);
		$product_category_id = escape_string($_POST['product_category_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$short_desc = escape_string($_POST['short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);
		$product_image = escape_string($_FILES['file']['name']);
		$image_temp_location = $_FILES['file']['tmp_name'];


		



		move_uploaded_file($image_temp_location ,  UPLOAD_DIRECTORY. DS . $product_image);

		$query = query("INSERT INTO products(product_title, 
			product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES ('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', 
			'{$product_quantity}', '{$product_image}')");

		$last_id = last_id();

		confirm($query);
		set_message("New Product with id {$last_id} Just Added " . UPLOAD_DIRECTORY . " " . $image_temp_location. " ". $product_image . " " . UPLOAD_DIRECTORY. DS . $product_image);
		redirect("index.php?products");


	}

}



function show_categories_add_product_page() {

	

	$query = query("SELECT * FROM categories") ;

	while ($row = fetch_array($query)) {


$catagories_options= <<<DELIMETER1




<option value="{$row['cat_id']}">{$row['cat_title']}</option>












DELIMETER1;


echo $catagories_options;
	}



}



?>



