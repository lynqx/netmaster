		<?php // include footer 
		$page_title = "NetMaster Shopping Cart";
		include ('partials/header.php'); 
		?>
				<!-- SLIDER UNIT -->

		<div class="slider">
            <div class="flexslider">
                <ul class="slides">
                   
                    <li class="slide slide-01">
                        <div class="slider-overlay">
                            <div class="slider-content container">
                                <div class="slider-content-wrapper clearfix">
                                    <p>Start buying all products online today</p>
                                    <div class="slider-btn-wrapper clearfix">
                                        <a href="https://shoppi.ng/front/register_merchant" class="slider-btn-green">Buy this</a>
                                        <a href="https://shoppi.ng/opportunity" class="slider-btn-blue">Buy that!</a>
                                    </div>
                                </div>
                             </div>
                         </div>
                    </li>
                    <li class="slide slide-02">
                        <div class="slider-overlay">
                            <div class="slider-content container">
                                <div class="slider-content-wrapper clearfix">
                                    <p>Help businesses make money.</p>
                                    <div class="slider-btn-wrapper">
                                        <a href="https://shoppi.ng/front/register_merchant" class="slider-btn-green">Content Link</a>
                                        <a href="https://shoppi.ng/opportunity" class="slider-btn-blue">Another Link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
		<!-- END SLIDER UNIT -->
		
		<!-- PORTFOLIO UNIT -->
		<section id="portfolio" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						<div class="col-md-12">
								<h2 class="text-center">
								<span class="bigintro">Best Selling</span>
								</h2>
						</div>
					</div>
					<div class="divide60"></div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div id="filters" class="text-center btn-group">
								<div  class="hidden-xs">
						<a class="btn btn-lg btn-primary active" data-filter="*" href="#" style="color:#fff;">All</a>

	<?php 
								$q = "SELECT DISTINCT category_id, category_name, filter FROM  `category`
								JOIN items ON items.category = category.category_id
								WHERE items.tag = 1";
								$r = mysqli_query ($conn, $q);
								while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	?>

								  	<a class="btn btn-lg btn-danger" data-filter=".<?php echo $row['filter']; ?>" href="#" style="color:#fff;">
								  	<?php echo $row['category_name']; ?>
								  	</a>
<?php } ?>
								  </div>
								  
								  <!-- comment out for now 
								  	<div class="visible-xs">
									   <select id="e1" class="form-control">
											<option value="*">All</option>
											<option value=".design">Designs</option>
											<option value=".videos">Videos</option>
											<option value=".banners">Banners</option>
										</select>
								  </div>
								  -->
							</div>
						</div>
					</div>
					<div class="divide40"></div>
					<div class="container">
						<div id="filter-items" class="row">
							
				<?php 
								$q2 = "SELECT * FROM  `items`
								JOIN category ON category.category_id = items.category
								WHERE items.tag = 1";
								$r2 = mysqli_query ($conn, $q2); 
								while ($item= mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
				?>
					
							<div class="col xs-12 col-sm-4 <?php echo $item{'filter'};?> item">
								<div class="filter-content">
									<img src="img/product/<?php echo $item{'image'};?>" alt="" class="img-responsive" />
									<div class="image-content">
										<h4><?php echo $item{'item_name'}; ?></h4>
										<p class="hidden-xs hidden-sm">
											<?php echo $item{'item_desc'}; ?>
										</p>
										<a href="product.php?prod=<?php echo $item{'item_id'}; ?> " class="btn btn-sm btn-warning">
											Add to Cart</a>
									</div>
								</div>
							</div>
							
							<?php } ?>
							
						</div>
					</div>
					<div class="divide60"></div>
		</section>
		<!--/PORTFOLIO UNIT  -->
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
