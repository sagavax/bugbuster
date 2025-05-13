<?php 
    include "../includes/dbconnect.php";
    include "../includes/functions.php";
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/app.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/bugs.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/diary.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/notes.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/ideas.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/app.js?<?php echo time(); ?>"></script>
    <title>Bugbuster - application details</title>
    <link rel='shortcut icon' href='../letter-b.png'>
</head>
<body>
<div class="main">
        <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
                 
                    <?php
                        //get list of the applicationa
                        $app_id = $_GET['app_id'];
                        $get_apps = "SELECT * FROM apps WHERE app_id=$app_id";
                        $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                            while ($row_apps = mysqli_fetch_array($result_apps)) {
                                $app_id = $row_apps['app_id'];
                                $app_name = $row_apps['app_name'];
                                $app_short_name = $row_apps['app_short_name'];
                                $app_desc = $row_apps['app_descr'];
                                $app_github_repo = $row_apps['github_repo'];
                                $app_active_dev = $row_apps['is_active_dev'];
                                $app_is_active = $row_apps['is_app_active'];
                                echo "<div class='application' data-app-id=$app_id>";
                                    //echo "<div class='connector-line'></div>";
                                    //echo "<div class='app-icon'>$app_icon</div>";
                                    //echo "<div class='app-info'>";
                                        echo "<input type='text' name='app_name' autocomplete='off' value='$app_name'>";
                                        echo "<input type='text' name='app_short_name' autocomplete='off' value='$app_short_name'>";
                                        echo "<textarea name='app_description'>$app_desc</textarea>";
                                        
                                        echo "<div class='app-actions'>";
                                            echo "<button type='button' name='app_save_changes' class='button small_button'><i class='fa fa-plus'></i></button>";
                                            //echo "<button type='button' name='edit_app' class='button small_button'><i class='fa fa-edit'></i></button>";
                                        echo "</div>";
                                echo "</div>";
                        }
                    ?>
                
                    <div class="application_details">
                        <div class="application_details_header">
                            <h3>Application details</h3>
                            <div class="application_details_tabs">
                                <button type="button" name="github_link" class="button small_button">Github</button>
                                <button type="button" name="app_diary" class="button small_button">Diary</button>
                                <button type="button" name="app_notes" class="button small_button">Notes</button>
                                <button type="button" name="app_bugs" class="button small_button">Bugs</button>
                                <button type="button" name="app_ideas" class="button small_button">Ideas</button>
                            </div><!-- application_details_header_actions -->
                        </div><!-- application_details_header -->
                        <div class="application_details_body">
                            <div class="application_details_github">
                                <?php

                                   /*  $owner = 'tvoje-username';
                                    $repo = 'tvoj-repo';
                                    $token = 'ghp_tvoj_token';
                                    $perPage = 100;
                                    $page = 1;
                                    $hasMore = true;

                                    while ($hasMore) {
                                        $url = "https://api.github.com/repos/$owner/$repo/commits?per_page=$perPage&page=$page";

                                        $ch = curl_init($url);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                            "User-Agent: tvoje-app",
                                            "Authorization: token $token",
                                            "Accept: application/vnd.github.v3+json"
                                        ]);

                                        $response = curl_exec($ch);
                                        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        curl_close($ch);

                                        if ($httpcode === 200) {
                                            $commits = json_decode($response, true);

                                            if (empty($commits)) {
                                                $hasMore = false; // už nie sú ďalšie commity
                                            } else {
                                                foreach ($commits as $commit) {
                                                    $sha = substr($commit['sha'], 0, 7);
                                                    $message = $commit['commit']['message'];
                                                    $author = $commit['commit']['author']['name'];
                                                    $date = $commit['commit']['author']['date'];

                                                    echo "<p><strong>$sha</strong>: $message<br><em>$author – $date</em></p>";
                                                }
                                                $page++; // ďalšia strana
                                            }
                                        } else {
                                            echo "Chyba: $httpcode";
                                            break;
                                        }
                                    } */

                                    ?>

                            </div>
                            <div class="application_details_diary">
                                <?php
                                 
                                     $itemsPerPage = 10;
                                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                     $offset = ($current_page - 1) * $itemsPerPage;   

                                    $get_diary = "SELECT * FROM diary WHERE project_id=$app_id ORDER BY id DESC LIMIT $offset, $itemsPerPage";
                                    $result_diary = mysqli_query($link, $get_diary) or die(mysqli_error($link));
                                        while ($row_diary = mysqli_fetch_array($result_diary)) {
                                            $diary_id = $row_diary['id'];
                                            $diary_text = $row_diary['diary_text'];
                                            $diary_date = $row_diary['created_date'];
                                            echo "<div class='diary' data-diary-id=$diary_id>";
                                                echo "<div class='diary_text'>$diary_text</div>";
                                                echo "<div class='diary_date'>$diary_date</div>";
                                            echo "</div>";
                                        }

                    
                                            // Calculate the total number of pages
                                            $sql = "SELECT COUNT(*) as total FROM diary WHERE project_id=$app_id";
                                            $result = mysqli_query($link, $sql);
                                            
                                            $totalItems = 0; // Predvolene nulová hodnota
                                            
                                            if ($row = mysqli_fetch_array($result)) {
                                                $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                                            }
                                            
                                            // Výpočet počtu strán
                                            $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                                            
                                            // Zobrazenie stránkovania
                                            echo '<div class="diary_pagination">';
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                               echo "<button type='button' class='button small_button' name='page'>" . $i . "</button>"; // Opravené úvodzovky
                                            }
                                            echo '</div>';
                    
                                    ?>
                            </div>
                            <div class="application_details_notes">
                                <?php    

                                 /*    $itemsPerPage = 10;
                                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                     $offset = ($current_page - 1) * $itemsPerPage;  
                                            
                                    $app_name = getAppName($app_id);
                                    $get_notes = "SELECT * FROM notes WHERE note_application='$app_name' ORDER BY note_id DESC LIMIT $offset, $itemsPerPage";
                                    $result_notes = mysqli_query($link, $get_notes) or die(mysqli_error($link));
                                        while ($row_notes = mysqli_fetch_array($result_notes)) {
                                            $note_id = $row_notes['note_id'];
                                            $note_title = $row_notes['note_title'];
                                            $note_text = $row_notes['note_text'];
                                            $note_date = $row_notes['created_date'];
                                            echo "<div class='note' data-note-id=$note_id>";
                                                echo "<div class='note_title'>$note_title</div>";
                                                echo "<div class='note_text'>$note_text</div>";
                                                echo "<div class='note_date'>$note_date</div>";
                                            echo "</div>";
                                        }

                                         // Calculate the total number of pages
                                            $sql = "SELECT COUNT(*) as total FROM diary WHERE note_application='$app_name'";
                                            $result = mysqli_query($link, $sql);
                                            
                                            $totalItems = 0; // Predvolene nulová hodnota
                                            
                                            if ($row = mysqli_fetch_array($result)) {
                                                $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                                            }
                                            
                                            // Výpočet počtu strán
                                            $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                                            
                                            // Zobrazenie stránkovania
                                            echo '<div class="notes_pagination">';
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                                echo '<a href="?page=' . $i . '">' . $i . '</a>'; // Opravené úvodzovky
                                            }
                                            echo '</div>'; */
                                ?>
                            </div>
                            <div class="application_details_bugs">
                                <?php

                                   $itemsPerPage = 10;
                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $offset = ($current_page - 1) * $itemsPerPage;   

                                    $app_name = getAppName($app_id);
                                    $get_bugs = "SELECT * FROM bugs WHERE bug_application='$app_name' ORDER BY bug_id DESC LIMIT $offset, $itemsPerPage";
                                    $result_bugs = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
                                        while ($row_bugs = mysqli_fetch_array($result_bugs)) {
                                            $bug_id = $row_bugs['bug_id'];
                                            $bug_title = $row_bugs['bug_title'];
                                            $bug_text = $row_bugs['bug_text'];
                                            $bug_status = $row_bugs['bug_status'];
                                            $bug_priority = $row_bugs['bug_priority'];
                                            $bug_comments = $row_bugs['comments'];
                                            $bug_date = $row_bugs['added_date'];
                                            echo "<div class='bug' data-bug-id=$bug_id>";
                                            if($bug_title !=""){
                                                echo "<div class='bug_title'>$bug_title</div>";
                                            }
                                                echo "<div class='bug_text'>$bug_text</div>";
                                                echo "<div class='bug_date'>$bug_date</div>";
                                            echo "</div>";
                                        }

                                          // Calculate the total number of pages
                                            $sql = "SELECT COUNT(*) as total FROM bugs WHERE bug_application='$app_name'";
                                            $result = mysqli_query($link, $sql);
                                            
                                            $totalItems = 0; // Predvolene nulová hodnota
                                            
                                            if ($row = mysqli_fetch_array($result)) {
                                                $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                                            }
                                            
                                            // Výpočet počtu strán
                                            $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                                            
                                            // Zobrazenie stránkovania
                                            echo '<div class="bugs_pagination">';
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                                //echo '<a href="?page=' . $i . '">' . $i . '</a>'; // Opravené úvodzovky
                                                 echo "<button type='button' class='button small_button' name='page'>" . $i . "</button>"; // Opravené úvodzovky
                                            }
                                            echo '</div>';
                                ?>
                            </div>
                            <div class="application_details_ideas">
                                <?php

                                    $itemsPerPage = 10;
                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $offset = ($current_page - 1) * $itemsPerPage;        

                                    $app_name = getAppName($app_id);
                                    $get_ideas = "SELECT * FROM ideas WHERE idea_application='$app_name' ORDER BY idea_id DESC LIMIT $offset, $itemsPerPage";
                                    $result_ideas = mysqli_query($link, $get_ideas) or die(mysqli_error($link));
                                        while ($row_ideas = mysqli_fetch_array($result_ideas)) {
                                            $idea_id = $row_ideas['idea_id'];
                                            $idea_title = $row_ideas['idea_title'];
                                            $idea_text = $row_ideas['idea_text'];
                                            $idea_status = $row_ideas['idea_status'];
                                            $idea_priority = $row_ideas['idea_priority'];
                                            $idea_comments = $row_ideas['comments'];
                                            $idea_date = $row_ideas['added_date'];
                                            echo "<div class='idea' data-idea-id=$idea_id>";
                                                echo "<div class='idea_title'>$idea_title</div>";
                                                echo "<div class='idea_text'>$idea_text</div>";
                                                echo "<div class='idea_date'>$idea_date</div>";
                                            echo "</div>";
                                        }

                                          // Calculate the total number of pages
                                            $sql = "SELECT COUNT(*) as total FROM ideas WHERE idea_application='$app_name'";
                                            $result = mysqli_query($link, $sql);
                                            
                                            $totalItems = 0; // Predvolene nulová hodnota
                                            
                                            if ($row = mysqli_fetch_array($result)) {
                                                $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                                            }
                                            
                                            // Výpočet počtu strán
                                            $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                                            
                                            // Zobrazenie stránkovania
                                            echo '<div class="ideas_pagination">';
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                               echo "<button type='button' class='button small_button' name='page'>" . $i . "</button>"; // Opravené úvodzovky
                                            }
                                            echo '</div>';
                                ?>
                            </div>    
                        </div>    
                    </div><!-- application_details -->    
              </div><!-- list-->
            </div><!-- content -->      
    </div><!-- main -->

</body>
</html>