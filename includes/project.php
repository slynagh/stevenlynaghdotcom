					<!--begin info column-->
					<div class='col-md-3 project-info rowspacer'>
						<h3><?php echo $project['title']; ?></h3>
						
							<ul class='category-holder'>
								<?php
								//display the project categories
									$catSet = getProjectCategories($project['id']);
									while ($cat = mysql_fetch_array($catSet)){
										echo "<li class='icon-" , $cat["icon_class"] , "' title='" , $cat["title"] , "'></li>";
									}				
								?>
							</ul>
							
						<div class='long-desc justify'><?php echo $project['long_desc']; ?></div>
						<div class='year'>- <?php echo $project['year']; ?></div>
					
					</div>
					<!--end info column-->
	
					<!--begin carousel column-->
					<div class='col-md-9'>
							<?php 
								$slides = getSlides($project['id']);
								$slideCount = mysql_num_rows($slides);
								if ($slideCount > 1){
									// carousel
									echo "<div id='carousel-project' class='carousel slide' data-ride='carousel' data-interval='8000' data-pause='hover'>",
														"<ol class='carousel-indicators'>";
									for ($i=0; $i<$slideCount ;$i++){
										echo "<li data-target='#carousel-project' data-slide-to='" , $i ,"'";
										if ($i==0){ echo " class='active'";}
										echo "></li> ";
									}
									echo
									"										</ol>",
									"								<div class='carousel-inner'>";
									$i=0;
									while ( $slide = mysql_fetch_array($slides) ){
										if ($slide['is_video'] == 1){
											echo
											"									<div class='item flex-video widescreen";
											if ($i==0){ echo " active"; }
											echo "'>",
											"										<iframe src='" , $slide['filename'] , "' frameborder='0' allowfullscreen></iframe>",
											"									</div>";
										}	else {
											echo
											"<div class='item";
											if ($i==0){ echo " active"; }
											echo "'>",
											"										<img src='";
											if ((substr( $slide['filename'], 0, 4 )) === "http"){
												echo $slide['filename'];
											} else {
												echo "img/" , $slide['filename'] ;
											}
											echo "' alt='" , $slide['alt'] , "' onload='imgLoaded(this)'>",
											"									</div>";
										}
										$i++;
									}?>
															</div><!--/.carousel-inner -->
			
														<a class="carousel-control left" href="#carousel-project" data-slide="prev">
															<span class="icon icon-left"></span>
														</a>
														<a class="carousel-control right" href="#carousel-project" data-slide="next">
															<span class="icon icon-right"></span>
														</a>
					
													</div><!--/.carousel-->
													
								<?php } else {
									//single gallery object
									$slide = mysql_fetch_array($slides);
									if ($slide['is_video'] == 1){
											echo 
											"									<div class='flex-video widescreen'>",
											"										<iframe src='" , $slide['filename'] , "' frameborder='0' allowfullscreen></iframe>",
											"									</div>";
										}	else {
											echo
											"										<img class='img-responsive' src='img/" , $slide['filename'] , "' alt='" , $slide['alt'] , "' onload='imgLoaded(this)'>";
										}
								}
		
							?>
							
			</div><!--/.col-->




