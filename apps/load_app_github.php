<?php

     $owner = 'sagavax';
    //$repo = 'bugbuster';
    $repo = $app_name = strtolower(getAppName($app_id));
    //echo $repo;
    //var_dump($repo);
    $token = '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';
    $perPage = 100;
    $page = 1;
    $hasMore = true;

    while ($hasMore) {
    $url = "https://api.github.com/repos/$owner/$repo/commits?per_page=$perPage&page=$page";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // iba na vývoj
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "User-Agent:".$repo,
        "Authorization: token $token",
        "Accept: application/vnd.github.v3+json"
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'cURL error: ' . curl_error($ch);
    }

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode === 200) {
        $commits = json_decode($response, true);

        if (empty($commits)) {
            $hasMore = false;
        } else {
            foreach ($commits as $commit) {
                $sha = substr($commit['sha'], 0, 7);
                $message = $commit['commit']['message'];
                $author = $commit['commit']['author']['name'];
                $date = $commit['commit']['author']['date'];

                echo "<p><strong>$sha</strong>: $message<br><em>$author – $date</em></p>";
            }
            $page++;
        }
    } else {
        echo "Chyba: $httpcode";
        break;
    }
    }


    ?>