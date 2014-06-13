<!-- FOOTER -->
		<section id="footer" class="color-light pattern">
			<div class="container">
				<div id="column-footer" class="row-fluid">
					<div class="col-sm-4">
						<h3>Learn More</h3>
						<ul>
							<li><a href="#">How it works</a></li>
							<li><a href="#">Safety measures</a></li>
							<li><a href="#">Testimonials</a></li>
							<li><a href="#">The Blog</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<h3>Help & Support</h3>
						<ul>
							<li><a href="#">Frequently Asked Questions</a></li>
							<li><a href="#">Creative Requirements</a></li>
							<li><a href="#">Glossary of Terms</a></li>
							<li><a href="#">The Safety</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<h3>About Us</h3>
						<ul>
							<li><a href="#">Press</a></li>
							<li><a href="#">Our Team</a></li>
							<li><a href="#">Careers</a></li>
							<li><a href="#">Our Partners</a></li>
						</ul>
					</div>
				</div>
			  </div>
		</section>
		<!--/FOOTER -->
	</div>
	<!--/PAGE -->
	
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/waypoint/waypoints.min.js"></script>
	<script type="text/javascript" src="js/navmaster/jquery.scrollTo.js"></script>
	<script type="text/javascript" src="js/navmaster/jquery.nav.js"></script>
	<script src="js/isotope/jquery.isotope.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/isotope/imagesloaded.pkgd.min.min.js"></script>
	<!-- COLORBOX -->
	<script type="text/javascript" src="js/colorbox/jquery.colorbox.min.js"></script>
	<script src="js/script.js"></script>
	
	<!-- FlexSlider -->
  <script defer src="https://shoppi.ng/js/front/jquery.flexslider-min.js"></script>

  <script type="text/javascript">
//      $(function(){
//          SyntaxHighlighter.all();
//      });
      $(window).load(function(){
          $('.flexslider').flexslider({
              animation: "slide",
              start: function(slider){
              $('body').removeClass('loading');
              }
          });
      });
  </script>
</body>
</html>