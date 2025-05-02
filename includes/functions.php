<?php 
	include("dbconnect.php");

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

function CloseGithubIssue($issue_id, $token) {
    $owner = 'sagavax';
    $repo = 'bugbuster';
    
    $url = "https://api.github.com/repos/$owner/$repo/issues/$issue_id";
    $ch = curl_init($url);

    // Odporúčam zrušiť SSL overovanie iba v prípade, že je to nutné, v iných prípadoch necháme to zapnuté
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["state" => "closed"]));
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "Content-Type: application/json",
        "User-Agent: BugBuster-Agent" // GitHub vyžaduje User-Agent hlavičku
    ]);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    
    // Skontrolujeme, či nastala chyba pri cURL požiadavke
    if(curl_errno($ch)) {
        // Vrátime chybu
        $error_message = curl_error($ch);
        curl_close($ch);
        return "cURL error: $error_message";
    }

    // Skontrolujeme odpoveď
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_status === 200) {
        // GitHub issue bolo úspešne uzavreté
        return "Issue #$issue_id successfully closed.";
    } else {
        // Odpoveď nebola úspešná, vrátime kód chyby a telo odpovede
        return "Failed to close issue #$issue_id. HTTP Status: $http_status. Response: $response";
    }
}


function GetcountFixedBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_status='fixed'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetcountNotFixedBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_status !='fixed'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetcountLowPriorityBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_priority='low'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetcountMediumPriorityBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_priority='medium'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetcountHighPriorityBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_priority='high'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetcountCriticalPriorityBugs() {
    global $link;
    $sql="SELECT COUNT(*) as count from bugs where bug_priority='critical'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}


function GetCountImplementedIdeas() {
    global $link;
    $sql="SELECT COUNT(*) as count from ideas where idea_status='implemented'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetCountNotImplementedIdeas() {
    global $link;
    $sql="SELECT COUNT(*) as count from ideas where idea_status !='implemented'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetCountLowPriorityIdeas() {
    global $link;
    $sql="SELECT  COUNT(*) as count from ideas where idea_priority='low'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetCountMediumPriorityIdeas() {
    global $link;
    $sql="SELECT COUNT(*) as count from ideas where idea_priority='medium'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetCountHighPriorityIdeas() {
    global $link;
    $sql="SELECT COUNT(*) as count from ideas where idea_priority='high'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}

function GetCountCriticalPriorityideas() {
    global $link;
    $sql="SELECT COUNT(*) as count from ideas where idea_priority='critical'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $count=$row['count'];
    } 
     return $count;
}