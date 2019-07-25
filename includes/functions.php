<?php
//Place functions here


function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
function redirectTo( $location = NULL){
	if($location != NULL){
		header("Location: {$location}");
		exit;
	}
}
	
function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}

function displayProjectGallery( $filters=NULL ){
	$projectSet = getProjects($filters);
	$output = "";
	while ($project = mysql_fetch_array($projectSet)){
		$href = "index.php?page=portfolio&projectid=" . $project["id"];
		foreach( $filters as $filter ){
			$href.="&categories[]=".$filter;
		}
		$output .= "<div class='tiny-12 col-xs-6 col-md-4 col-lg-3'>
		<a class='tn' href = '".$href."'>
			<img src='";
		if ((substr( $project["thumb"], 0, 4 )) === "http"){
			$output .= $project["thumb"];
		} else {
			$output .= "img/".$project["thumb"];
		}
		$output .= "' width='220' height='220' alt='".$project["alt"]."' onload='imgLoaded(this)'>
				<div class='thumbinfo'>
					<h4 class='project-title'>".$project["title"]."</h4>
					<p class='project-shortdesc'>".$project["short_desc"]."</p>
					<span class='project-year'>".$project['year']."</span>
					<ul class='category-holder'>";
					$catSet = getProjectCategories($project['id']);
					while ($cat = mysql_fetch_array($catSet)){
						$output .= "<li class='icon-" . $cat["icon_class"] . "' title='" . $cat["title"] . "'></li>";
					}				
					$output .= "</ul>
				</div>
			</a>
		</div>";
	}
	echo $output;
}

function getCorrespondingIndex($array, $input){
	foreach($array as $key => $value){
		if ($value == $input){
			return $key;
		} 
	}
}

function displayPortfolioControls( $project, $filters=NULL ){
	$catSet = getAllVisibleCategories();
	$output = "
			<!--begin portfolio controls-->
			<div class='clearfix rowspacer'>";
			
	//display previous and next buttons if we're viewing the project page
	if(isset($project)){  
		$projectIdList = getProjectIdArray($filters); #get an array of the project id column, in order.
		$count = count($projectIdList);
		$currentIndex = getCorrespondingIndex($projectIdList, $project["id"]);
		$prev = $projectIdList[$currentIndex - 1];
		$next = $projectIdList[$currentIndex + 1];
		
		//fb($projectIdList, '$projectIdList');
		//fb($project, '$project');
		//fb($count, '$count');
		//fb($currentIndex, '$currentIndex');
		//fb($prev, $next);
		
		$output .= "\t\t\t<a href='index.php?page=portfolio&projectid=" . $prev;
		foreach( $filters as $filter ){
			$output.="&categories[]=".$filter;
		}
		$output .= "' class='btn btn-default pull-left";
		if ($currentIndex == 0){
			$output .= " invisible";
		}
		$output .= "'><span class='icon-arrow-left2 arrowicon'></span><span class='hidden-xs'> Previous project</span></a>\n
		\t\t\t<a href='index.php?page=portfolio&projectid=". $next;
		foreach( $filters as $filter ){
			$output.="&categories[]=".$filter;
		}
		$output .= "' class='btn btn-default pull-right";
		
		if ($currentIndex == $count-1){
			$output .= " invisible";
		}
		$output .= "'><span class='hidden-xs'>Next project </span><span class='icon-arrow-right2 arrowicon'></span></a>\n";
	}
	
	//display the category filter buttons
	$output .= "<div class='filter-group'>\n
		\t\t\t<span class='hidden-xs'>Filter projects:</span>\n
		\t\t\t<a href = 'index.php?page=portfolio' class='icon-infinity btn btn-default";
	if (!isset($filters)){
		$output .= " active";
	}
	$output .= "' title='All Projects'></a>";
	
	while ($cat = mysql_fetch_array($catSet)){
		$output .= "<a href='index.php?page=portfolio&categories[]={$cat["id"]}' class='icon-" . $cat["icon_class"] . " btn btn-default";
		if (isset($filters)){
			foreach ($filters as $filter){
				if ($filter == $cat["id"]) { $output .= " active" ;}
			}
			unset($filter);
		}
		$output .= "' title = '" . $cat["title"] . "'></a>";
	}
	$output .= "</div>\n
	</div><!--end portfolio controls-->";
	echo $output;
}


/*
			Place query functions here
*/

function getPageByName($pageName){//unused
	global $connection;
	$query = "SELECT * 
						FROM pages 
						WHERE page_name = '$pageName'
						LIMIT 1";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	// REMEMBER:
	// if no rows are returned, fetch_array will return false
	if ($result = mysql_fetch_array($resultSet)) {
		return $result;
	} else {
		return NULL;
	}
}

function getAllVisiblePages(){
	global $connection;
	$query = "SELECT * FROM pages WHERE visible = 1 ORDER BY position ";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	return $resultSet;
}

function getProjectIdArray($filters=NULL){
	global $connection;
	$arrayColumn = array();
	$query = "SELECT DISTINCT projects.id
					 FROM projects ";
	if (isset($filters)){
		$count = count($filters);
		$query .= "INNER JOIN projects_categories
							ON projects.id = projects_categories.project_id
							WHERE ";
		foreach($filters as $key => $categoryID){
			$query .= "(visible = 1 AND category_id = " . $categoryID . ") ";
			if (($key+1) < $count) { $query .= "OR "; }
		}
	} else { $query .=	"WHERE visible = 1 "; }
	
	$query .=	"ORDER BY rank DESC";
	$result = mysql_query($query, $connection);
	confirm_query($result);
	while ($row = mysql_fetch_row($result)){
		$arrayColumn[] = $row[0];
	}
	return $arrayColumn;
}

function getProjects($filters = NULL){ 
	global $connection;
	$query = "SELECT DISTINCT projects.id, alt, short_desc, rank, thumb, title, year
					 FROM projects ";
	if (isset($filters)){
		$count = count($filters);
		$query .= "INNER JOIN projects_categories
							ON projects.id = projects_categories.project_id
							WHERE ";
		foreach($filters as $key => $categoryID){
			$query .= "(visible = 1 AND category_id = " . $categoryID . ") ";
			if (($key+1) < $count) { $query .= "OR "; }
		}
	} else { $query .=	"WHERE visible = 1 "; }
	$query .=	"ORDER BY rank DESC";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	return $resultSet;
}

function getProjectCategories($projectID){
	global $connection;
	$query = "SELECT *
						FROM categories
						INNER JOIN projects_categories
						ON categories.id = projects_categories.category_id
						WHERE project_id = " .  $projectID . "						
						ORDER BY position ASC";
						
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	return $resultSet;
}

function getAllVisibleCategories(){
	global $connection;
	$query = "SELECT * FROM categories WHERE visible = 1 ORDER BY position ASC";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	return $resultSet;
}

function getFilteredCategoryTitles($filters){
	global $connection;
	$titles = array();
	$query = "SELECT title FROM categories WHERE id = ";
	$i = 0;
	foreach($filters as $filter){
		if ($i > 0){$query .= " OR id = ";}
		$query .= $filter;
		$i++;
	}
	$query .= " ORDER BY position ASC";
	
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	while ($row = mysql_fetch_row($resultSet)){
		
		$titles[] = $row[0];
	}
	return $titles;
}

function getSelectedProject(){
	global $connection;
	$query = "SELECT id, title, long_desc, year FROM projects WHERE id = {$_GET["projectid"]}";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	if ($result = mysql_fetch_array($resultSet)) {
		return $result;
	} else {
		return NULL;
	}
}

function getSlides($projectid){
	global $connection;
	$query = "SELECT filename, is_video, alt FROM slides WHERE project_id = {$projectid} ORDER BY position ASC";
	$resultSet = mysql_query($query, $connection);
	confirm_query($resultSet);
	return $resultSet;
}

	
function countTableEntries($table){
	global $connection;
	$query = "SELECT COUNT(*) FROM {$table}";
	$result = mysql_query($query, $connection);
	confirm_query($result);
	if ($row = mysql_fetch_array($result)){
		return $row[0];
	} else {
		return NULL;
	}
}

?>












