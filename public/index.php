

<?php require_once '../resources/config.php'; ?>


<?php include TEMPLATE_FRONT . DS . "header.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

           <!-- Categories here    -->

           <?php include TEMPLATE_FRONT . DS . "side_nav.php"; ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        
                        <!-- Carousel -->

                        <?php include TEMPLATE_FRONT . DS . "slider.php"; ?>

                    </div>

                </div>

                <div class="row">


                    <h1>
                        
                        



                    </h1>


                    <?php get_products();  ?>

                   

                    

                    

                </div> <!-- Row Ends Here  -->

            </div>

        </div>

    </div>
    <!-- /.container -->

    <?php  require TEMPLATE_FRONT . DS . "footer.php"  ?>
