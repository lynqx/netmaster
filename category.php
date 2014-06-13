		<?php // include footer 
		include ('partials/header.php'); 
		?>
		<!-- PORTFOLIO UNIT -->
		<section id="portfolio" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						<div class="col-md-12">
								<h2 class="text-center">
								<span class="bigintro">CATEGORIES</span><br /><br />
								<h5 class="smallintro">Select Category Below</h5>

								</h2>
						</div>
					</div>

					<div class="divide40"></div>
					<div class="container">
						<div id="filter-items" class="row">
							
			<?php 
								$q = "SELECT * FROM  `category`";
								$r = mysqli_query ($conn, $q); 
								while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			?>
					
							<div class="col xs-12 col-sm-3">
								<a href="store.php?cat=<?php echo $row['category_id']; ?>"><div class="filter-content">
									<img src="img/category/<?php 
									if (isset($row['avatar']) && $row['avatar'] != "") { echo $row['avatar'];
									} else {
										 echo 'default.png'; }
									 ?>" alt="" class="img-responsive" />
									<div class="image-content">
										<h4><?php echo $row{'category_name'}; ?></h4>
									</div>
							</div></a>
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
