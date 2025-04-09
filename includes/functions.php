<?php 
	include("includes/dbconnect.php");

function GetCountIdeas(){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_ideas from ideas";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_ideas= $row['nr_of_ideas'];
	return $nr_of_ideas;	
}

function GetCountIdeaComments($idea_id){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_comms from ideas_comments WHERE idea_id=$idea_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}


function GetCountBugs(){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_bugs from bugs";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_bugs= $row['nr_of_bugs'];
	return $nr_of_bugs;			
}


function GetCountBugComments($bug_id){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_comms from bugs_comments WHERE bug_id=$bug_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}

function GetAppName($project_id){
	global $link;
	if($project_id==0){
		$app_name="";
	} else {
    $sql="SELECT app_name from apps where app_id=$project_id";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $app_name=$row['app_name'];
    } 
	}
	 return $app_name;  

    mysqli_close($link);
}