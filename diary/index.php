<!DOCTYPE html>
<html lang="en">

<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bugbuster - diary</title>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/diary.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/diary.js?<?php echo time(); ?>"></script>
    <link rel="shortcut icon" href="../letter-b.png">
</head>

<body>
    <div class="main">
        <?php include("../includes/header.php") ?>
        <div class="content">
            <div class="list">
            <h3>Developer's Diary</h3>
                <div class="new_diary_record">

                <form action="diary_record_new.php" method="post">

                      <textarea name="diary_text" placeholder="Put a diary record here"></textarea>
                     
                      <select name="diary_application">
                          <option value=0>--- choose application --- </option>
                          <?php
                          $get_apps = "SELECT * from apps ORDER BY app_name ASC";
                          $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                          while ($row_apps = mysqli_fetch_array($result_apps)) {
                              $app_id = $row_apps['app_id'];
                              $app_name = $row_apps['app_name'];
                              echo "<option value =$app_id>$app_name</option>";
                          }
                          ?>
                      </select>
                      <div class="new_diary_record_action">
                        <button type="buttont" name="save_record" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new diary record -->
              <div class="diary_button_filter">
                <?php
                    $sql = "SELECT * from apps";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $app_name = $row['app_name'];
                            $app_id = $row['app_id'];
                            echo "<button type='button' name='filter_app' class='button small_button' data-app-id=$app_id>$app_name</button>";
                        }       
                   ?>     
               </div>    
                <!-- /diary_filter -->
                <div id="diary_content">
                    <?php
                    //error_reporting(E_ALL ^ E_NOTICE);
                    $adjacents = 5;
                    $limit = 10; // how many items to show per page
                    if(!isset($_GET['page'])) $_GET['page'] = 1;
                    $page = $_GET['page'];

                    if (isset($_GET['cat_id'])) {
                        $cat_id = $_GET['cat_id'];
                        $sql_count = "SELECT COUNT(*) as num from diary where project_id=$cat_id ORDER BY id DESC";
                    } else {
                        $sql_count = "SELECT COUNT(*) as num from diary ORDER BY id DESC";
                    }

                    //echo $sql_count;

                    $query = mysqli_query($link, $sql_count) or die(mysql_error($link));
                    $total_pages = mysqli_fetch_array($query);
                    $total_pages = $total_pages['num'];

                   

                    $start = ($page) ? ($page - 1) * $limit : 0; // Calculate start index

                    if (isset($_GET['cat_id'])) {
                        $cat_id = $_GET['cat_id'];
                        $sql = "SELECT * from diary where project_id=$cat_id ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $sql = "SELECT * from diary ORDER BY id DESC LIMIT $start, $limit";
                    }

                    $result = mysqli_query($link, $sql) or die(mysql_error($link));

                    $page = $page ?: 1; // Default to page 1 if no page variable given
                    $prev = $page - 1;
                    $next = $page + 1;
                    $lastpage = ceil($total_pages / $limit);
                    $lpm1 = $lastpage - 1;

                    $pagination = "";
                    if ($lastpage > 1) {
                        $pagination .= "<div class=\"pagination\">";
                        $pagination .= ($page > 1)
                            ? "<a href=\"diary.php?page=$prev\" class='page_next'>« previous</a>"
                            : "<span class=\"disabled\">« previous</span>";

                        $pagination .= ($page < $lastpage)
                            ? "<a href=\"diary.php?page=$next\" class='page_next'>next »</a>"
                            : "<span class=\"disabled\">next »</span>";
                        $pagination .= "</div>\n";
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        $diary_date = $row['created_date'];
                        $diary_text = $row['diary_text'];
                        $app_id = $row['project_id'];
                        $diary_app = GetAppName($app_id);

                        echo "<div class='diary_record' data-id='" . $row['id'] . "'>
                                <div class='diary_text'>$diary_text</div>
                                <div class='diary_app'><span class='app_name'>$diary_app<span></div>
                                <div class='diary_action'><button class='button button_small' name='delete_record'><i class='fa fa-times'></i></button></div>
                              </div>";
                    }
                    ?>
                </div>
                <?php echo $pagination; ?>
            </div>
            <!-- /.list-->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.main -->

    <div class="modal" id="modal-add-record">
        <div class="modal-dialog">
            <div class="modal-header">
                <div class="title">
                    <h1 class="title-text">Add new record</h1>
                </div>
                <button type="button" class="close-modal" data-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /header -->

            <div class="modal-content">
                <form class="form" method="post">
                    <div class="form-group">
                        <textarea name="diary_text" class="text-field" placeholder="Some update here ..."></textarea>
                    </div>

                    <div class="form-group">
                        <select name="project" class="select">
                            <option value="0">-- All --</option>
                            <?php
                            $sql = "SELECT * FROM apps";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $app_name = htmlspecialchars($row['app_name']);
                                $app_id = htmlspecialchars($row['app_id']);
                                echo "<option value=\"$app_id\">$app_name</option>";
                            }                        
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button name="add_record" type="submit" class="green-button">+ Add</button>
                    </div>
                </form>
            </div><!-- /modal content -->
        </div><!-- /modal dialog -->
    </div><!-- /modal new record -->
    
    <!-- Modal change app -->
    <dialog class="modal_change_app">
       <?php
            echo "<ul>";
            $get_apps = "SELECT * FROM apps";
            $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
            while ($row_apps = mysqli_fetch_array($result_apps)) {
                $app_id = $row_apps['app_id'];
                $app_name = $row_apps['app_name'];
                echo "<li data-app-id=$app_id>$app_name</li>";
            } 
            echo "</ul>";          
            ?>          
    </dialog>
</body>

</html>
