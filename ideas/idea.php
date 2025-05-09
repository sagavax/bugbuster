<?php 
include "../includes/dbconnect.php";
include "../includes/functions.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bug Buster - Ideas</title>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/ideas.css?<?php echo time(); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">  
    <script type="text/javascript" src="../js/idea.js?<?php echo time(); ?>" defer></script>  <!-- this file contains functions for like, comment, apply -->
    <link rel='shortcut icon' href='../letter-b.png'>
</head>
<body>
    <div class="main">
        <?php include("../includes/header.php"); ?>
        <div class="content">
            <div class="fab fab-icon-holder" onclick="window.location.href='index.php';">
                <i class="fa fa-arrow-left"></i>
            </div>
            <div class="list">
                <?php
                $idea_id = $_GET['idea_id'];
                //$is_applied = $_SESSION['is_applied'];

                $get_idea = "SELECT * FROM ideas WHERE idea_id = $idea_id";
                $result = mysqli_query($link, $get_idea);
                while ($row = mysqli_fetch_array($result)) {
                    $idea_id = htmlspecialchars($row['idea_id'] ?? '', ENT_QUOTES, 'UTF-8');
                    $idea_title = htmlspecialchars($row['idea_title'] ?? '', ENT_QUOTES, 'UTF-8');
                    $idea_text = htmlspecialchars($row['idea_text'] ?? '', ENT_QUOTES, 'UTF-8');
                    $idea_priority = htmlspecialchars($row['idea_priority'] ?? '', ENT_QUOTES, 'UTF-8');
                    $idea_status = htmlspecialchars($row['idea_status'] ?? '', ENT_QUOTES, 'UTF-8');
                    $is_implemented = htmlspecialchars($row['is_implemented'] ?? '', ENT_QUOTES, 'UTF-8');
                    $added_date = htmlspecialchars($row['added_date'] ?? '', ENT_QUOTES, 'UTF-8');
                    $application = htmlspecialchars($row['idea_application'] ?? '', ENT_QUOTES, 'UTF-8');

                    echo "<div class='idea_detail'>";
                    if (isset($idea_title)) {
                        echo "<div class='idea_title'>$idea_title</div>";
                    }

                    echo "<div class='idea_text'>$idea_text</div>";
                    echo "<div class='idea_footer'>";
                        echo "<div class='idea_application'>{$application}</div>";
                        $nr_of_comments = GetCountIdeaComments($idea_id);
                        echo "<div class='nr_of_comments'>$nr_of_comments comment(s)</div>";
                        echo "<div class='idea_status'>$idea_status</div><div class='idea_priority $idea_priority'>$idea_priority</div>";
                        echo "<button type='button' name='see_idea_details' class='button small_button'><i class='fa fa-eye'></i></button>";

                        if ($is_implemented == 0) {
                            echo "<form action='' method='post'>";
                            echo "<input type='hidden' name='idea_id' value='$idea_id'>";
                            echo "<button type='submit' name='to_apply' class='button small_button'><i class='fa fa-check'></i></button>";
                            echo "</form>";
                        } elseif ($is_implemented == 1) {
                            echo "<div class='idea_implemented'>Implemented</div>";
                        }
                        echo "</div>"; // idea_footer
                    echo "</div>"; // idea
                }      
                ?>

                <div class="idea_comments_list">
                    <?php
                    $get_comments = "SELECT * FROM ideas_comments WHERE idea_id = $idea_id ORDER BY comment_date ASC";
                    // echo $get_comments;
                    $result_comment = mysqli_query($link, $get_comments);
                    while ($row_comment = mysqli_fetch_array($result_comment)) {
                        $comm_id = $row_comment['comm_id'];
                        $comm_title = $row_comment['idea_comm_header'];
                        $comm_text = $row_comment['idea_comment'];
                        $comm_date = $row_comment['comment_date'];

                        echo "<div class='idea_comment' data-comment-id=$comm_id>";
                        echo "<div class='connector-line'></div>";
                        echo "<div class='idea_top_banner'></div>";

                        if ($comm_title != "") {
                            echo "<div class='idea_comm_title'>$comm_title</div>";
                        }
                        echo "<div class='idea_comm_text'>$comm_text</div>";
                        echo "<div class='idea_comm_action'>";

                        if ($is_implemented == 1) {
                            echo "<button type='button' name='delete_comment' class='button small_button' disabled><i class='fa fa-times'></i></button>";
                        } else {
                            echo "<button type='button' name='delete_comment' class='button small_button'><i class='fa fa-times'></i></button>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }   
                    ?>  
                </div><!-- idea comment list-->  

                <div class="idea_comment_new">
                    <h4>Add a comment</h4>
                    <input type="text" name="idea_comment_header" autocomplete="off" placeholder="Type title here">
                    <textarea name="idea_comment" placeholder="Type comment here..."></textarea>
                    <div class="idea_comment_action">
                        
                        <?php
                        if ($is_implemented == 0) {
                            echo "<button name='save_idea_comment' class='button small_button' type='button'>Save</button>";
                        } else if ($is_implemented == 1) {
                            echo "<button type='button' name='save_idea_comment' disabled class='button small_button'>Save</button>";
                        }
                        ?>  
                    </div>  
                </div><!-- list-->
            </div><!--content-->
        </div><!--main_wrap-->
    </div>
</body>
</html>
