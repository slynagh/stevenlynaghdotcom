<footer>
	<div class="container">
		<div class = "footer-content">
		
			<span class="text-muted small">Copyright <?php echo date("Y"); ?>, Steven Lynagh | <a href="index.php?page=siteinfo">About this site</a></span>
			
			<div class="social">
				<a href="http://www.linkedin.com/pub/steve-lynagh/38/724/a5b" target="_blank" title="LinkedIn"><span class="icon icon-linkedin" ></span></a>
				<a href="https://www.youtube.com/user/stevelynagh/videos" target="_blank" title="YouTube"><span class="icon icon-youtube" ></span></a>
				<a href="https://twitter.com/stevelynagh" target="_blank" title="Twitter"><span class="icon icon-twitter"></span></a>
				<a href="http://stackexchange.com/users/3319325/slynagh" target="_blank" title="stackoverflow"><span class="icon icon-stackoverflow"></span></a>
			</div>
			
		</div>
	</div><!--container--> 
</footer>


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="js/vendor/jquery-ui-1.10.4.custom.js"></script>
<script src="js/vendor/bootstrap.js"></script>

<script src="js/plugins.js"></script> 
<script src="js/main.js"></script> 

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. --> 
<script>
	/*
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='//www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','UA-XXXXX-X');ga('send','pageview');
	*/
</script>
</body>
</html>

<?php
	// 5. Close connection
	if (isset($connection)){
		mysql_close($connection);
	}
?>