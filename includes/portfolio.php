<?php
	if (isset($_GET["projectid"])){
		$project = getSelectedProject();//will return NULL if projectid invalid
		if ($project == NULL){
			redirectTo("index.php?page=portfolio");
		}		
	} else {
		$project = NULL;
	}
	
	if (isset($_GET["categories"])){
		//TODO: validate categories
		$filters = $_GET["categories"];
	} else {
		$filters = NULL;
	}
?>

<div class="container">
	
	<h1>Portfolio <small class="hidden-xs">
<?php
	if (!isset($filters)){?>Take a look at my work.<?php
	} else {
		$titles=getFilteredCategoryTitles($filters);
		$i = 0;
		foreach($titles as $title){
			if ($i>0){echo " / ";}
			echo $title;
			$i++;
		}
	}
?></small></h1>

	<section class="panel panel-default">
		<div class="panel-body">
			<?php displayPortfolioControls($project, $filters); ?>
		
			<div class='row'>
			
			<?php
				if($project == NULL){
						displayProjectGallery($filters);
				} else {
						include("project.php");
				}
			?>
			</div><!--/.row-->
		</div><!--/.panel-body-->
	</section>
</div><!--container--> 







