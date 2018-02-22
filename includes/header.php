	<!-- Fixed navbar -->
	<header class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
		
			<div class="navbar-header">
			<a class="navbar-brand" href="index.php">SJL</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
	
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
				
				<?php
					$pages_set = getAllVisiblePages();
					
					$output = "";
					while($row = mysql_fetch_array($pages_set)){
						$output .= "<li";
							if ($selectedPage == strtolower($row["page_name"])){
								$output .= " class='active'";
							}
						$output .= "><a href='index.php?page=".urlencode(strtolower($row["page_name"]))."'><span class='navicon icon-" . $row["icon_class"] . "'></span><span class='navlabel'>" .  ucwords($row["page_name"])  . "</span></a></li>";
					}
					echo $output;
				?>
				
				</ul>
			</div><!--/.nav-collapse -->
			
		</div>
	</header>
