<?php
	ini_set('display_errors', '0');     # ..disable error display
	error_reporting(E_ALL | E_STRICT);  # ...but do log them
?>
<?php //require_once('FirePHPCore/fb.php');?>
<?php require_once("includes/db_connect.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	//globals
	$selectedPage;
	
	if (isset($_GET["page"])){
		$selectedPage = $_GET["page"];
	} else {
		$selectedPage = "profile";
	};
?>
<?php require("includes/head.php") ?>
<?php

?>
<body>

<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]--> 
				
<!-- Wrap all page content here -->
<div id="wrap">

	<?php include("includes/header.php"); ?>
	
	<!-- Begin main content -->
	
	<?php
		switch ($selectedPage){
			case "profile":
				include("includes/home.php");
				break;
			case  "portfolio":
				include("includes/portfolio.php");
				break;
			case "blog":
			
			case "contact":
				include("includes/contact.php");
				break;
			case "siteinfo":
				include("includes/siteinfo.php");
				break;
			default:
				include("includes/home.php");
		}
	?>
	
</div><!--wrap-->

<?php require("includes/footer.php"); ?>