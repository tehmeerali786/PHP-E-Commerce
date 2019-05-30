 <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">

                	<?php 

                	$query = "SELECT * FROM categories";
                	$send_query = mysqli_query($connection, $query);

                	get_categories();


                	?>
                    
                </div>
            </div>