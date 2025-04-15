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

function createGithubIssue($title, $body, $token) {
    $owner = 'sagavax';
    $repo = 'bugbuster';

    // Údaje pre nové issue
    $data = [
        "title" => $title,
        "body" => $body
    ];

    // Inicializácia cURL
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$owner/$repo/issues");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $owner); // Povinný header pre GitHub API
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "Content-Type: application/json",
        "Accept: application/vnd.github.v3+json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Spustenie požiadavky a spracovanie odpovede
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Spracovanie chýb
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return ["success" => false, "error" => $error];
    }

    curl_close($ch);

    // Návrat celej odpovede spolu s HTTP kódom
    return [
        "success" => $httpCode === 201,
        "http_code" => $httpCode,
        "response" => json_decode($response, true)
    ];
}


function createCommentGithubIssue($issue_id, $body, $token) {
    $owner = 'sagavax';
    $repo = 'bugbuster';

    // API URL pre pridanie komentára
    $url = "https://api.github.com/repos/$owner/$repo/issues/$issue_id/comments";

    // Dáta pre nové issue
    $data = [
        "body" => $body
    ];

    // Inicializácia cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "Content-Type: application/json",
        "User-Agent: BugBuster-Agent" // GitHub vyžaduje User-Agent hlavičku
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Spustenie požiadavky
    $response = curl_exec($ch);
    curl_close($ch);

    return $response; // Tu môžete spracovať odpoveď (napr. kontrolovať, či bola požiadavka úspešná)
}
